<?php
require 'db_auth.php';

$sql = "SELECT UserId, FirstName, LastName, Username, ContactNumber, Email, FacebookLink, RegisteredAt FROM users ORDER BY UserId DESC";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
