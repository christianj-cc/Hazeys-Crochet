<?php
require 'db_auth.php';

if (!isset($_SESSION['user_id'])) {
    die("You must log in first.");
}

$userId = intval($_SESSION['user_id']); // Ensure it's an integer

// Fetch all orders placed by the user along with the review status and latest status timestamp
$sqlOrders = "SELECT o.OrderId, o.TotalPrice, p.PaymentMethod, p.PaymentRefNo, p.ReceiptImage, 
                     o.OrderStatus, o.CreatedAt,
                     (SELECT COUNT(*) FROM reviews r WHERE r.OrderId = o.OrderId) AS HasReview,
                     (SELECT h.MadeAt FROM order_status_history h 
                      WHERE h.OrderId = o.OrderId AND h.Status = o.OrderStatus 
                      ORDER BY h.MadeAt DESC LIMIT 1) AS StatusUpdatedAt
              FROM orders o
              LEFT JOIN order_payments p ON o.OrderId = p.OrderId
              WHERE o.UserId = ? 
              ORDER BY o.CreatedAt DESC";

$stmtOrders = $conn->prepare($sqlOrders);
$stmtOrders->bind_param("i", $userId);
$stmtOrders->execute();
$resultOrders = $stmtOrders->get_result();

$orders = [];
while ($order = $resultOrders->fetch_assoc()) {
    $orders[$order['OrderId']] = [
        'OrderId' => $order['OrderId'],
        'TotalPrice' => $order['TotalPrice'],
        'PaymentMethod' => $order['PaymentMethod'],
        'PaymentRefNo' => $order['PaymentRefNo'],
        'ReceiptImage' => $order['ReceiptImage'],
        'OrderStatus' => $order['OrderStatus'],
        'CreatedAt' => $order['CreatedAt'],
        'HasReview' => $order['HasReview'], // Include review status
        'StatusUpdatedAt' => $order['StatusUpdatedAt'] ?? 'N/A', // Latest status timestamp
        'Products' => []
    ];
}
$stmtOrders->close();

// Fetch products for each order from order_items
if (!empty($orders)) {
    $orderIds = implode(',', array_keys($orders)); // Get order IDs for filtering
    $sqlItems = "SELECT oi.OrderId, p.ProductId, p.ProductName, oi.Quantity, oi.Price 
                 FROM order_items oi
                 JOIN products p ON oi.ProductId = p.ProductId
                 WHERE oi.OrderId IN ($orderIds)";

    $resultItems = $conn->query($sqlItems);
    while ($item = $resultItems->fetch_assoc()) {
        $orders[$item['OrderId']]['Products'][] = [
            'ProductId' => $item['ProductId'],
            'ProductName' => $item['ProductName'],
            'Quantity' => $item['Quantity'],
            'Price' => $item['Price']
        ];
    }
}
