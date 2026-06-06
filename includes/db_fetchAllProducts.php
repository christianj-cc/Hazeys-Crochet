<?php
require 'db_auth.php';

if (!isset($_SESSION['user_id'])) {
    die("You must log in first.");
}

$user_id = intval($_SESSION['user_id']); // Ensure it's an integer

// Corrected SQL query: Removed the extra comma and added Quantity
$sql = "SELECT ProductId, ProductName, ProductPrice, ProductImg, ProductCategory, InStock, IsActive FROM products";
$result = $conn->query($sql);

$productList = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $productList[] = [
            'ProductId' => $row['ProductId'],
            'ProductName' => $row['ProductName'],
            'ProductPrice' => $row['ProductPrice'],
            'ProductImg' => $row['ProductImg'],
            'ProductCategory' => $row['ProductCategory'],
            'InStock' => $row['InStock'],
            'IsActive' => $row['IsActive']
        ];
    }
} else {
    die("Error retrieving products: " . $conn->error);
}
