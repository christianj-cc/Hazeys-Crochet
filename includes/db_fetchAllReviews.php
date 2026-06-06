<?php
require 'db_auth.php';

$reviews = [];

// Fetch only products that have reviews
$query = "SELECT r.ProductId, p.ProductName, p.ProductImg, u.Username, r.Rating, r.ReviewText, r.CreatedAt 
          FROM reviews r
          JOIN products p ON r.ProductId = p.ProductId
          JOIN users u ON r.UserId = u.UserId
          ORDER BY p.ProductId, r.CreatedAt DESC";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $productId = $row['ProductId'];

    if (!isset($reviews[$productId])) {
        // Store product details once
        $reviews[$productId] = [
            'ProductName' => $row['ProductName'],
            'ProductImg' => $row['ProductImg'],
            'AvgRating' => 0, // Default, will be updated later
            'Reviews' => []
        ];
    }

    // Append review
    $reviews[$productId]['Reviews'][] = [
        'Username' => $row['Username'],
        'Rating' => $row['Rating'],
        'ReviewText' => $row['ReviewText'],
        'CreatedAt' => $row['CreatedAt']
    ];
}
mysqli_free_result($result);

// Fetch average ratings for only reviewed products
$avgQuery = "SELECT ProductId, ROUND(AVG(Rating), 0) AS AvgRating FROM reviews GROUP BY ProductId";
$avgResult = mysqli_query($conn, $avgQuery);

while ($row = mysqli_fetch_assoc($avgResult)) {
    $productId = $row['ProductId'];

    if (isset($reviews[$productId])) {
        $reviews[$productId]['AvgRating'] = $row['AvgRating'];
    }
}
mysqli_free_result($avgResult);

mysqli_close($conn);
