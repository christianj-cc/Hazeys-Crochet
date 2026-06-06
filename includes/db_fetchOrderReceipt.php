<?php
require 'db_auth.php';

// Check if OrderId is present in URL
if (!isset($_GET['order_id'])) {
    echo "<p class='error'>Order ID is missing.</p>";
    exit;
}

$orderId = intval($_GET['order_id']); // Get OrderId from URL

// Fetch order details
$orderQuery = "SELECT 
                o.OrderId, 
                o.TotalPrice, 
                o.OrderStatus, 
                o.CreatedAt, 
                m.PlaceName AS MeetupPlace, 
                op.PaymentMethod, 
                op.PaymentRefNo, 
                op.ReceiptImage
              FROM orders o
              JOIN meetup_places m ON o.MeetupPlaceId = m.PlaceId
              LEFT JOIN order_payments op ON o.OrderId = op.OrderId
              WHERE o.OrderId = ?";
$stmt_order = $conn->prepare($orderQuery);
$stmt_order->bind_param("i", $orderId);
$stmt_order->execute();
$result_order = $stmt_order->get_result();

if ($result_order->num_rows === 0) {
    echo "<p class='error'>Order not found.</p>";
    exit;
}

$order = $result_order->fetch_assoc();
$stmt_order->close();

// Fetch order items
$itemsQuery = "SELECT 
                oi.ProductId, 
                p.ProductName, 
                oi.Quantity, 
                oi.Price 
              FROM order_items oi
              JOIN products p ON oi.ProductId = p.ProductId
              WHERE oi.OrderId = ?";
$stmt_items = $conn->prepare($itemsQuery);
$stmt_items->bind_param("i", $orderId);
$stmt_items->execute();
$result_items = $stmt_items->get_result();

$items = [];
while ($row = $result_items->fetch_assoc()) {
    $items[] = $row;
}

$stmt_items->close();
mysqli_close($conn);
