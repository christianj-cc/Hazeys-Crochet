<?php
require "../db_connect.php"; // Ensure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if email already exists
    $check_email = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists! Please use a different email.";
    } else {
        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (FirstName, LastName, Username, ContactNumber, Email, Password, RegisteredAt) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $first_name, $last_name, $username, $contact_number, $email, $password);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: ../login.php?success=1"); // Redirect to login page
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_email->close();
    $conn->close();
}
