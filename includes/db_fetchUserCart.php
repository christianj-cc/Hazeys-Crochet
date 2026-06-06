<?php
require 'db_auth.php';

if (!isset($_SESSION['user_id'])) {
    die("You must log in first.");
}

$userId = intval($_SESSION['user_id']); // Ensure it's an integer

$sql = "SELECT products.ProductId, products.ProductName, products.ProductPrice, products.InStock, cart.Quantity 
        FROM cart
        JOIN products ON cart.ProductId = products.ProductId
        WHERE cart.UserId = ? AND cart.isRemoved = 0"; // Ensure only available products are fetched

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = [
        'ProductId' => $row['ProductId'],
        'ProductName' => $row['ProductName'],
        'ProductPrice' => $row['ProductPrice'],
        'Quantity' => $row['Quantity'],
        'InStock' => $row['InStock'],
    ];
}

$stmt->close();
