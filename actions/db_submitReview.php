<?php
require '../db_auth.php';

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $orderId = $_POST['order_id'];
    $productIds = $_POST['product_ids'];
    $ratings = $_POST['ratings'];
    $reviewTexts = $_POST['review_texts'];

    // Check if the order is completed
    $stmt = $conn->prepare("SELECT * FROM orders WHERE OrderId = ? AND UserId = ? AND OrderStatus = 'Completed'");
    $stmt->bind_param("ii", $orderId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Insert reviews for each product
        $stmt = $conn->prepare("INSERT INTO reviews (UserId, OrderId, ProductId, Rating, ReviewText, CreatedAt) VALUES (?, ?, ?, ?, ?, NOW())");

        foreach ($productIds as $index => $productId) {
            $rating = $ratings[$index];
            $reviewText = $reviewTexts[$index];
            $stmt->bind_param("iiiis", $userId, $orderId, $productId, $rating, $reviewText);
            $stmt->execute();
        }

        echo "Review submitted successfully!";
        header("Location: ../user-orders.php?success=Order-reviewed"); // Redirect to review list
        exit;
    } else {
        die("You can only review completed orders.");
    }
}
