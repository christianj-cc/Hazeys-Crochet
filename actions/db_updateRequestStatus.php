<?php
require '../db_auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $requestId = intval($_POST['request_id']);
    $requestStatus = trim($_POST['request_status']);
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';
    $return_url = filter_var($_POST['return_url'], FILTER_SANITIZE_URL); // Sanitize URL

    // Define the status progression flow
    $statusFlow = [
        "Pending" => ["Accept" => "To Pay", "Reject" => "Rejected"],
        "To Pay" => "In Progress",
        "In Progress" => "To Package",
        "To Package" => "For Meetup",
        "For Meetup" => "Delivered",
        "Delivered" => "Completed",
        "Completed" => "Completed", // Final state
        "Rejected" => "Rejected", // Final state
        "Cancelled" => "Cancelled" // Final state
    ];

    // Check if the status exists in the flow and determine the next state
    if (isset($statusFlow[$requestStatus])) {
        if ($requestStatus === "Pending") {
            // If request is Pending, determine next status based on action
            if ($action === "Reject") {
                $new_status = "Rejected";
            } else {
                $new_status = "To Pay"; // Default action is Accept
            }
        } else {
            // For other statuses, use predefined flow
            $new_status = $statusFlow[$requestStatus];
        }

        try {
            // Start transaction
            $conn->begin_transaction();

            // Update request status
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

            // Set success message in session
            $_SESSION['alert_message'] = "Request status updated successfully!";
            $_SESSION['alert_type'] = "success"; // Can be 'error' for failures

            header("Location: " . $return_url . "?success=Request-status-updated");
            exit();
        } catch (Exception $e) {
            $conn->rollback(); // Rollback transaction on error

            // Set success message in session
            $_SESSION['alert_message'] = "Request status update failed!";
            $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

            header("Location: " . $return_url . "?error=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        // Set success message in session
        $_SESSION['alert_message'] = "Update failed! Invalid status.";
        $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

        header("Location: " . $return_url . "?error=Invalid-status");
        exit();
    }
} else {
    // Set success message in session
    $_SESSION['alert_message'] = "Update failed! No post sent.";
    $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

    header("Location: " . $return_url . "?error=No-post-sent");
    exit();
}
