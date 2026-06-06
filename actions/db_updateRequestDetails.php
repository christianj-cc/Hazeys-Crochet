<?php
require '../db_auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $request_id = intval($_POST['request_id']);
    $current_status = trim($_POST['request_status']);
    $request_price = floatval($_POST['request_price']);
    $admin_message = !empty(trim($_POST['admin_message'])) ? trim($_POST['admin_message']) : NULL;
    $return_url = filter_var($_POST['return_url'], FILTER_SANITIZE_URL);
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';

    if (empty($request_id) || empty($current_status)) {
        header("Location: $return_url?error=Invalid request.");
        exit();
    }

    // Determine new status based on action
    $new_status = ($action === 'accept') ? 'To Pay' : (($action === 'reject') ? 'Rejected' : $current_status);

    try {
        $conn->begin_transaction();

        $update_sql = "UPDATE requests SET RequestStatus = ? , RequestPrice = ? , AdminMessage = ?  WHERE RequestId = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sdsi", $new_status, $request_price, $admin_message, $request_id);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update request status.");
        }
        $stmt->close();

        // Insert status change into request_status_history
        $history_sql = "INSERT INTO request_status_history (RequestId, Status, MadeAt) VALUES (?, ?, NOW())";
        $stmtHistory = $conn->prepare($history_sql);
        $stmtHistory->bind_param("is", $request_id, $new_status);

        if (!$stmtHistory->execute()) {
            throw new Exception("Failed to insert status history.");
        }
        $stmtHistory->close();

        $conn->commit();
        header("Location: ../admin-requests.php?success=Request-updated");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: ../admin-requests.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
