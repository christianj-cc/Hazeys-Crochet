<?php
session_start(); // Ensure session is started
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to homepage
header("Location: ../index.php");
exit();
