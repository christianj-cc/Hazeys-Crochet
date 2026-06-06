<?php
require 'db_auth.php';

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// Check if an Order ID was passed
if (!isset($_GET['order_id'])) {
    die("No order selected for review.");
}

$orderId = $_GET['order_id'];
$userId = $_SESSION['user_id'];

// Fetch products from the completed order
$stmt = $conn->prepare("
    SELECT oi.ProductId, p.ProductName 
    FROM order_items oi
    JOIN products p ON oi.ProductId = p.ProductId
    WHERE oi.OrderId = ? AND EXISTS (
        SELECT 1 FROM orders o WHERE o.OrderId = oi.OrderId AND o.UserId = ? AND o.OrderStatus = 'Completed'
    )
");
$stmt->bind_param("ii", $orderId, $userId);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

if (empty($products)) {
    die("Invalid order or no products found.");
}
