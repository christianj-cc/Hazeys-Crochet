<?php
require '../db_auth.php';
session_start(); // Ensure session is started

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit("You must log in first.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && isset($_POST['product_name'])) {
        $productId = intval($_POST['product_id']);
        if ($productId <= 0) {
            exit("Invalid product ID.");
        }
        $productName = trim($_POST['product_name']);
        $userId = $_SESSION['user_id'];

        // Check if product is in cart (excluding ordered items)
        $stmt = $conn->prepare("SELECT CartId, Quantity, IsRemoved FROM cart WHERE UserId = ? AND ProductId = ? AND OrderId IS NULL");
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cartItem = $result->fetch_assoc();
        $stmt->close();

        if ($cartItem) {
            if ($cartItem['IsRemoved'] == 1) {
                // Reactivate item: Set IsRemoved = 0 and increment quantity
                $stmt = $conn->prepare("UPDATE cart SET Quantity = 1, IsRemoved = 0 WHERE CartId = ?");
            } else {
                // Simply update quantity if already active
                $stmt = $conn->prepare("UPDATE cart SET Quantity = Quantity + 1 WHERE CartId = ?");
            }
            $stmt->bind_param("i", $cartItem['CartId']);
            $stmt->execute();
            $stmt->close();

            // Set success message in session
            $_SESSION['alert_message'] = "Product added to cart!";
            $_SESSION['alert_type'] = "succcess"; // Can be 'error' for failures

            header("Location: ../shop.php?success=Product-updated");
            exit();
        } else {
            // Insert new product into cart
            $stmt = $conn->prepare("INSERT INTO cart (UserId, ProductId, Quantity, IsRemoved) VALUES (?, ?, 1, 0)");
            $stmt->bind_param("ii", $userId, $productId);
            $stmt->execute();
            $stmt->close();

            // Set success message in session
            $_SESSION['alert_message'] = "Product added to cart!";
            $_SESSION['alert_type'] = "succcess"; // Can be 'error' for failures

            header("Location: ../shop.php?success=Product-added-to-cart");
            exit();
        }
    } else {
        exit("Product ID or name not set.");
    }
}
