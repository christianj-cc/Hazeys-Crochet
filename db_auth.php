<?php
session_start(); // Start session for authentication

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hazeyscrochet_db"; // Change to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;

// Check if the user is an admin
$isAdmin = ($userId === 1);

// Initialize totalCartItems
$totalCartItems = 0;

// Fetch total number of unique products in the cart (excluding removed items) if the user is logged in
if ($isLoggedIn) {
    $query = "SELECT COUNT(DISTINCT ProductId) AS total_items FROM cart WHERE UserId = ? AND isRemoved = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $totalCartItems = $row['total_items'] ?? 0;
    }

    $_SESSION['totalCartItems'] = $totalCartItems;

    $stmt->close();
}
