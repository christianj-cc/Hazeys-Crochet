<?php
require 'db_auth.php';

function getAllProducts($conn)
{
    $sql = "SELECT ProductId, ProductName, ProductPrice, InStock, ProductImg, ProductCategory FROM products WHERE IsActive = 1";
    $result = $conn->query($sql);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}
