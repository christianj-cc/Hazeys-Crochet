<?php
session_start();
require "../db_connect.php"; // Ensure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve user from database
    $stmt = $conn->prepare("SELECT UserId, Password FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            $_SESSION["user_id"] = $row["UserId"];
            $_SESSION["email"] = $email;
            echo "Login successful!";

            if ($_SESSION["user_id"] == 1) {
                header("Location: ../admin.php"); // Redirect to landing page
                exit();
            } else {
                header("Location: ../index.php"); // Redirect to landing page
                exit();
            }
        } else {
            echo "Invalid password.";
            header("Location: ../login.php?error=Invalid-password");
        }
    } else {
        echo "No user found with this email.";
        header("Location: ../login.php?error=No-user-found-with-this-email");
    }

    $stmt->close();
    $conn->close();
}
