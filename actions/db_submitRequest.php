<?php
require '../db_auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $userId = $_SESSION['user_id']; // Ensure user is logged in
    $requestName = trim($_POST['request_name']);
    $deadline = $_POST['deadline'];
    $instructions = trim($_POST['instructions']);
    $quantity = intval($_POST['quantity']);
    $requestStatus = "Pending"; // Default status

    // Ensure the meetup place is valid
    $allowedMeetupPlaces = ["UM Matina", "UM Bolton"];
    $meetupPlace = isset($_POST['meetup_place']) ? $_POST['meetup_place'] : null;

    if (!in_array($meetupPlace, $allowedMeetupPlaces)) {
        die("Invalid meetup place selected.");
    }

    // Prepare the statement
    $stmt = $conn->prepare("SELECT PlaceId FROM meetup_places WHERE PlaceName = ?");
    $stmt->bind_param("s", $meetupPlace);
    $stmt->execute();
    $stmt->bind_result($meetupPlaceId);
    $stmt->fetch();
    $stmt->close();


    // Handle file upload
    $targetDir = "../uploads/"; // Corrected path
    $fileName = time() . "_" . basename($_FILES["reference_image"]["name"]);
    $filePath = $targetDir . $fileName; // Full server path
    $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    $referenceImage = "uploads/" . $fileName; // Store relative path in database

    if (!in_array(strtolower($fileType), $allowedTypes)) {
        header("Location: ../request.php?error=Invalid-file-type"); // Redirect after successful submission
        exit();
    }

    if (move_uploaded_file($_FILES["reference_image"]["tmp_name"], $filePath)) {
        try {
            // Insert into database using prepared statements
            $stmt = $conn->prepare("INSERT INTO requests (UserId, MeetupPlaceId, RequestName, Deadline, Instructions, Quantity, ReferenceImage, RequestStatus, RequestedAt) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("iisssiss", $userId, $meetupPlaceId, $requestName, $deadline, $instructions, $quantity, $referenceImage, $requestStatus);

            if ($stmt->execute()) {
                $requestId = $stmt->insert_id; // Get the generated RequestId

                echo "Request submitted successfully!";
                header("Location: ../success-request.php?request_id=$requestId&success=Request-submitted-successfully");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } catch (Exception $e) {
            die("Database error: " . $e->getMessage());
        }
    } else {
        header("Location: ../request.php?error=Failed-to-upload-file");
        exit();
    }
}
