<?php
require '../db_auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userId = $_SESSION['user_id'];
    $totalPrice = $_POST['total_price'];
    $paymentMethod = $_POST['payment_method'];
    $paymentRefNo = isset($_POST['payment_ref_no']) ? $_POST['payment_ref_no'] : null;
    $receiptImage = null;

    // Ensure the meetup place is valid
    $allowedMeetupPlaces = ["UM Matina", "UM Bolton"];
    $meetupPlace = isset($_POST['meetup_place']) ? $_POST['meetup_place'] : null;

    if (!in_array($meetupPlace, $allowedMeetupPlaces)) {
        die("Invalid meetup place selected.");
    }

    // Prepare the statement
    $stmt = $conn->prepare("SELECT PlaceId FROM meetup_places WHERE PlaceName = ?");
    $stmt->bind_param("s", $meetupPlace);
    $stmt->execute();
    $stmt->bind_result($meetupPlaceId);
    $stmt->fetch();
    $stmt->close();

    // Handle receipt upload (if applicable)
    if (isset($_FILES['receipt_image']) && $_FILES['receipt_image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES["receipt_image"]["name"]);
        $filePath = $targetDir . $fileName;
        $receiptImage = "uploads/" . $fileName;

        if (!move_uploaded_file($_FILES["receipt_image"]["tmp_name"], $filePath)) {
            die("Error uploading receipt image.");
        }
    }

    // Insert order into orders table
    $stmt_order = $conn->prepare("INSERT INTO orders (UserId, MeetupPlaceId, TotalPrice, OrderStatus, CreatedAt) VALUES (?, ?, ?, 'Pending', NOW())");
    $stmt_order->bind_param("iid", $userId, $meetupPlaceId, $totalPrice);

    if ($stmt_order->execute()) {
        $orderId = $stmt_order->insert_id; // Get the generated OrderId

        if (!$orderId) {
            die("Error: Order ID is missing. Order insert may have failed.");
        }

        // Insert products into order_items table
        $stmt_items = $conn->prepare("INSERT INTO order_items (OrderId, ProductId, Quantity, Price) VALUES (?, ?, ?, ?)");

        foreach ($_POST['product_ids'] as $index => $productId) {
            $quantity = $_POST['quantities'][$index];
            $price = $_POST['prices'][$index];

            $stmt_items->bind_param("iiid", $orderId, $productId, $quantity, $price);
            $stmt_items->execute();
        }

        // Remove purchased items from cart
        $stmt_update_cart = $conn->prepare("UPDATE cart SET isRemoved = 1 WHERE UserId = ? AND ProductId = ?");
        foreach ($_POST['product_ids'] as $productId) {
            $stmt_update_cart->bind_param("ii", $userId, $productId);
            $stmt_update_cart->execute();
        }

        $stmt_payment = $conn->prepare("INSERT INTO order_payments (OrderId, PaymentMethod, PaymentRefNo, ReceiptImage, CreatedAt) VALUES (?, ?, ?, ?, NOW())");
        $stmt_payment->bind_param("isss", $orderId, $paymentMethod, $paymentRefNo, $receiptImage);

        if (!$stmt_payment->execute()) {
            die("Error inserting payment: " . $stmt_payment->error);
        }
        $stmt_payment->close();

        // Clear session cart
        unset($_SESSION['cart']);

        echo "Order placed successfully!";
        header("Location: ../success-order.php?order_id=$orderId&success=Order-successful");

        exit;
    } else {
        die("Error inserting order: " . $stmt_order->error);
    }
}
