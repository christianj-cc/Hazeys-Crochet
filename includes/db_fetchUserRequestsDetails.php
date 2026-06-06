<?php
require 'db_auth.php';

if (!isset($_SESSION['user_id'])) {
    die("You must log in first.");
}

$userId = intval($_SESSION['user_id']); // Ensure it's an integer

function fetchRequestDetails($requestId)
{
    global $conn; // Use the database connection from db_connection.php

    $sql = "SELECT r.*, u.Username 
            FROM requests r
            JOIN users u ON r.UserId = u.UserId
            WHERE r.RequestId = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc(); // Fetch as an associative array
}

// Get request ID from URL
if (isset($_GET['request_id']) && is_numeric($_GET['request_id'])) {
    $requestId = $_GET['request_id'];
    $requestDetails = fetchRequestDetails($requestId);
} else {
    $requestDetails = null; // Handle invalid or missing request ID
}
