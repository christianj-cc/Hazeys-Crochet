<?php
require 'db_auth.php';

// Check if RequestId is present in URL
if (!isset($_GET['request_id'])) {
    echo "<p class='error'>Request ID is missing.</p>";
    exit;
}

$requestId = intval($_GET['request_id']); // Get RequestId from URL

// Fetch request details
$requestQuery = "SELECT 
                r.RequestId, 
                r.RequestName,
                r.Deadline,
                r.Instructions,
                r.Quantity,
                r.RequestPrice,
                r.RequestStatus, 
                r.RequestedAt, 
                m.PlaceName AS MeetupPlace, 
                rp.PaymentMethod, 
                rp.PaymentRefNo, 
                rp.ReceiptImage
              FROM requests r
              JOIN meetup_places m ON r.MeetupPlaceId = m.PlaceId
              LEFT JOIN request_payments rp ON r.RequestId = rp.RequestId
              WHERE r.RequestId = ?";
$stmt_request = $conn->prepare($requestQuery);
$stmt_request->bind_param("i", $requestId);
$stmt_request->execute();
$result_request = $stmt_request->get_result();

if ($result_request->num_rows === 0) {
    echo "<p class='error'>Request not found.</p>";
    exit;
}

$request = $result_request->fetch_assoc();
$stmt_request->close();

mysqli_close($conn);
