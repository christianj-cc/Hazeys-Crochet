<?php
require '../db_auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['in_stock'], $_POST['is_active'])) {
        require '../db_auth.php';

        $product_id = intval($_POST['product_id']);
        $product_name = trim($_POST['product_name']);
        $product_price = floatval($_POST['product_price']);
        $in_stock = intval($_POST['in_stock']);
        $is_active = intval($_POST['is_active']);

        $updateQuery = "UPDATE products SET ProductName = ?, ProductPrice = ?, InStock = ?, IsActive = ? WHERE ProductId = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sdiii", $product_name, $product_price, $in_stock, $is_active, $product_id);

        if ($stmt->execute()) {
            // Set success message in session
            $_SESSION['alert_message'] = "Product details updated successfully!";
            $_SESSION['alert_type'] = "success"; // Can be 'error' for failures

            header("Location: ../admin-products.php?success=Product-updated");
        } else {
            // Set success message in session
            $_SESSION['alert_message'] = "Product details update failed!";
            $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

            header("Location: ../admin-products.php?error=update-failed");
        }

        $stmt->close();
        $conn->close();
        exit();
    }
} else {
    // Set success message in session
    $_SESSION['alert_message'] = "Update failed! Missing fields.";
    $_SESSION['alert_type'] = "error"; // Can be 'error' for failures

    header("Location: ../admin-products.php?error=missing-fields");
    exit();
}
