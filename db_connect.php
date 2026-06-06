<?php
$servername = "localhost"; // XAMPP runs on localhost
$username = "root"; // Default XAMPP user
$password = ""; // Default password is empty
$dbname = "hazeyscrochet_db"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
