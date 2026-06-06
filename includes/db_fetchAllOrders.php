<?php
require 'db_auth.php';

// Function to fetch orders based on status
function fetchOrders($status)
{
    global $conn;

    $stmt = $conn->prepare("
        SELECT o.OrderId, u.Username, o.CreatedAt, o.TotalPrice, o.OrderStatus,
               m.PlaceName, p.PaymentMethod, p.ReceiptImage
        FROM orders o
        JOIN users u ON o.UserId = u.UserId
        JOIN meetup_places m ON o.MeetupPlaceId = m.PlaceId
        LEFT JOIN order_payments p ON o.OrderId = p.OrderId
        WHERE o.OrderStatus = ?
        ORDER BY o.CreatedAt DESC
    ");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orderId = $row['OrderId'];

        // Fetch ordered products
        $products = fetchOrderProducts($orderId);
        $row['Products'] = $products;

        // Fetch timestamp of the current order status
        $row['StatusUpdatedAt'] = fetchOrderStatusTimestamp($orderId, $row['OrderStatus']);

        $orders[] = $row;
    }

    return $orders;
}

// Function to fetch products of an order
function fetchOrderProducts($orderId)
{
    global $conn;

    $stmt = $conn->prepare("
        SELECT p.ProductName, oi.Quantity
        FROM order_items oi
        JOIN products p ON oi.ProductId = p.ProductId
        WHERE oi.OrderId = ?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}



// Function to fetch the latest timestamp for the given order's current status
function fetchOrderStatusTimestamp($orderId, $status)
{
    global $conn;

    $stmt = $conn->prepare("
        SELECT MadeAt 
        FROM order_status_history 
        WHERE OrderId = ? AND Status = ? 
        ORDER BY MadeAt DESC 
        LIMIT 1
    ");
    $stmt->bind_param("is", $orderId, $status);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['MadeAt']; // Return the latest timestamp if found
    } else {
        return "N/A"; // Return 'N/A' if no record exists
    }
}
