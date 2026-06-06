<?php
require '../db_auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        $user_id = $_SESSION['user_id']; // Assuming user is logged in

        $deleteQuery = "UPDATE cart SET isRemoved = 1 WHERE ProductID = ? AND UserID = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("ii", $product_id, $user_id);

        if ($stmt->execute()) {
            // Set success message in session
            $_SESSION['alert_message'] = "Item removed succesfully!";
            $_SESSION['alert_type'] = "succcess"; // Can be 'error' for failures

            $_SESSION['success_message'] = "Item removed from cart!";
        } else {
            // Set success message in session
            $_SESSION['alert_message'] = "Failed to remove item!";
            $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

            $_SESSION['error_message'] = "Failed to remove item.";
        }

        $stmt->close();
        $conn->close();
    }
}
// Set success message in session
$_SESSION['alert_message'] = "Item removed successfully!";
$_SESSION['alert_type'] = "error"; // Can be 'error' for failures

header("Location: ../cart.php?success=Item-removed");
exit();
