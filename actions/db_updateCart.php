<?php
require '../db_auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);

        if ($quantity < 1) {
            header("Location: cart.php");
            exit();
        }

        $user_id = $_SESSION['user_id']; // Assuming user is logged in and session holds user ID

        $updateQuery = "UPDATE cart SET Quantity = ? WHERE ProductID = ? AND UserID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iii", $quantity, $product_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Cart updated successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to update cart.";
        }

        $stmt->close();
        $conn->close();
    }
}

header("Location: ../cart.php?success=Cart-updated");
exit();
