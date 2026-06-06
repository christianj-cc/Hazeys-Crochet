<?php
require '../db_auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
        die("Invalid request.");
    }

    $user_id = intval($_POST['user_id']);
    $fields = [];
    $values = [];

    if (!empty($_POST['username'])) {
        $fields[] = "Username = ?";
        $values[] = $_POST['username'];
    }

    if (!empty($_POST['facebook_link'])) {
        $fields[] = "FacebookLink = ?";
        $values[] = $_POST['facebook_link'];
    }

    if (!empty($_POST['contact_number'])) {
        if (!preg_match('/^\d{11}$/', $_POST['contact_number'])) {
            die("Invalid contact number format.");
        }
        $fields[] = "ContactNumber = ?";
        $values[] = $_POST['contact_number'];
    }

    if (!empty($fields)) {
        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE UserId = ?";
        $values[] = $user_id;

        $stmt = $conn->prepare($sql);

        $types = str_repeat("s", count($values) - 1) . "i"; // All string except last int
        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            // Set success message in session
            $_SESSION['alert_message'] = "User information updated successfully!";
            $_SESSION['alert_type'] = "success"; // Can be 'error' for failures

            header("Location: ../user.php?success=User-info-successfully-updated");
        } else {
            // Set success message in session
            $_SESSION['alert_message'] = "User information update failed";
            $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

            echo "Error updating record: " . $conn->error;
            header("Location: ../user.php?error=Error-updating-record");
        }

        $stmt->close();
    } else {
        // Set success message in session
        $_SESSION['alert_message'] = "Update failed! No fields to update.";
        $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

        echo "No fields to update.";
        header("Location: ../user.php?error=No-fields-to-update");
    }
} else {
    // Set success message in session
    $_SESSION['alert_message'] = "Update failed! Invalid request.";
    $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

    die("Invalid request method.");
    header("Location: ../user.php?error=Invalid-request");
}
