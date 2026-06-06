<?php
require '../db_auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['order_id']) && isset($_POST['order_status'])) {
        $order_id = intval($_POST['order_id']);
        $order_status = trim($_POST['order_status']);
        $return_url = filter_var($_POST['return_url'], FILTER_SANITIZE_URL); // Sanitize URL

        // Fetch ordered products
        $stmt = $conn->prepare("SELECT ProductId, Quantity FROM order_items WHERE OrderId = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Update stock for each ordered product
        $stmt_update_stock = $conn->prepare("UPDATE products SET InStock = InStock - ? WHERE ProductId = ? AND InStock >= ?");
        while ($row = $result->fetch_assoc()) {
            $productId = $row['ProductId'];
            $quantity = $row['Quantity'];

            // Update stock
            $stmt_update_stock->bind_param("iii", $quantity, $productId, $quantity);
            if (!$stmt_update_stock->execute()) {
                die("Error updating stock: " . $stmt_update_stock->error);
            }
        }

        // Define the order status flow
        $statusFlow = [
            "Pending" => "To Package",
            "To Package" => "For Meetup",
            "For Meetup" => "Delivered",
            "Delivered" => "Completed",
            "Completed" => "Completed", // Completed is the final stage
            "Cancelled" => "Cancelled" // Cancelled remains cancelled
        ];

        // If the status exists in the flow, move to the next stage
        if (isset($statusFlow[$order_status])) {
            $new_status = $statusFlow[$order_status]; // Get the next status

            // Begin transaction
            $conn->begin_transaction();

            // Insert into order_status_history
            $stmt_history = $conn->prepare("INSERT INTO order_status_history (OrderId, Status, MadeAt) VALUES (?, ?, NOW())");
            $stmt_history->bind_param("is", $order_id, $new_status);
            if (!$stmt_history->execute()) {
                $conn->rollback();
                die("Error inserting into history: " . $stmt_history->error);
            }
            $stmt_history->close();

            // Update order status
            $updateQuery = "UPDATE orders SET OrderStatus = ? WHERE OrderId = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("si", $new_status, $order_id);

            if ($stmt->execute()) {
                $conn->commit(); // Commit changes

                // Set success message in session
                $_SESSION['alert_message'] = "Order stock out successful!";
                $_SESSION['alert_type'] = "success"; // Can be 'error' for failures

                header("Location: " . $return_url . "?success=Order-stock-out-successful");
                exit();
            } else {
                $conn->rollback(); // Rollback if update fails

                // Set success message in session
                $_SESSION['alert_message'] = "Order stock out failed!";
                $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

                header("Location: " . $return_url . "?error=Order-stock-out-failed");
                exit();
            }

            $stmt->close();
            $conn->close();
        } else {
            // Set success message in session
            $_SESSION['alert_message'] = "Update failed! Invalid status.";
            $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

            header("Location: " . $return_url . "?error=Invalid-status");
            exit();
        }
    } else {
        // Set success message in session
        $_SESSION['alert_message'] = "Update failed! Missing data.";
        $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

        header("Location: " . $return_url . "?error=Missing-data");
        exit();
    }
} else {
    // Set success message in session
    $_SESSION['alert_message'] = "Update failed! No post sent.";
    $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

    header("Location: " . $return_url . "?error=No-post-sent");
    exit();
}
