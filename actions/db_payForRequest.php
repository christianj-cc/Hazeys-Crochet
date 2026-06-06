<?php
require '../db_auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userId = $_SESSION['user_id'];
    $requestId = $_POST['request_id']; // Ensure request_id is passed from the form
    $paymentMethod = $_POST['payment_method'];
    $paymentRefNo = isset($_POST['payment_ref_no']) ? $_POST['payment_ref_no'] : null;
    $receiptImage = null;

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


    // Handle receipt upload (if applicable)
    if (isset($_FILES['receipt_image']) && $_FILES['receipt_image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES["receipt_image"]["name"]);
        $filePath = $targetDir . $fileName;
        $receiptImage = "uploads/" . $fileName;

        if (!move_uploaded_file($_FILES["receipt_image"]["tmp_name"], $filePath)) {
            die("Error uploading receipt image.");
        }
    }

    // **Step 1: Check if request exists and belongs to user**
    $stmt_check = $conn->prepare("SELECT RequestId FROM requests WHERE RequestId = ? AND UserId = ?");
    $stmt_check->bind_param("ii", $requestId, $userId);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows === 0) {
        die("Invalid request or unauthorized access.");
    }
    $stmt_check->close();

    // **Step 2: Insert payment record into request_payments table**
    $stmt_payment = $conn->prepare("INSERT INTO request_payments (RequestId, PaymentMethod, PaymentRefNo, ReceiptImage, CreatedAt) VALUES (?, ?, ?, ?, NOW())");
    $stmt_payment->bind_param("isss", $requestId, $paymentMethod, $paymentRefNo, $receiptImage);

    if (!$stmt_payment->execute()) {
        die("Error inserting payment: " . $stmt_payment->error);
    }
    $stmt_payment->close();

    // **Step 3: Update request status**
    try {
        // Start transaction
        $conn->begin_transaction();

        // Update request status
        $new_status = "In Progress";
        $stmt = $conn->prepare("UPDATE requests SET RequestStatus = ? WHERE RequestId = ?");
        $stmt->bind_param("si", $new_status, $requestId);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update request status.");
        }
        $stmt->close();

        // Insert status change into request_status_history
        $stmtHistory = $conn->prepare("INSERT INTO request_status_history (RequestId, Status) VALUES (?, ?)");
        $stmtHistory->bind_param("is", $requestId, $new_status);

        if (!$stmtHistory->execute()) {
            throw new Exception("Failed to insert into request_status_history.");
        }
        $stmtHistory->close();

        // Commit transaction
        $conn->commit();

        header("Location: ../success-request-payment.php?request_id=$requestId&success=Request-paid-successfully");
        exit();
    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaction on error
        header("Location: ../user-requests.php?error=" . urlencode($e->getMessage()));
        exit();
    }

    echo "Request paid successfully!";
    header("Location: ../success-request-payment.php?request_id=$requestId&success=Request-paid-successfully");
    exit;
}
