<?php
require 'db_auth.php';

$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
    $user_id = $_SESSION['user_id'];

    // Fetch user info, including FacebookLink
    $sql = "SELECT FirstName, LastName, Username, ProfileImage, ContactNumber, Email, Password, FacebookLink FROM users WHERE UserId = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error); // Debugging
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("No user found for UserId: " . htmlspecialchars($user_id)); // Debugging
    }

    $stmt->close();
} else {
    echo "User is not logged in.";
    $user = null;
}

$conn->close();
