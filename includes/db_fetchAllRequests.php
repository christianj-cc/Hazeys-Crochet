<?php
require 'db_auth.php';

// Function to fetch custom requests based on status
function fetchRequests($status)
{
    global $conn;

    $stmt = $conn->prepare("
        SELECT r.RequestId, u.Username, r.RequestName, r.Deadline, r.Instructions, m.PlaceName, 
               r.Quantity, r.ReferenceImage, r.RequestPrice, r.RequestStatus, r.RequestedAt, r.AdminMessage,
               p.PaymentMethod, p.PaymentRefNo, p.ReceiptImage
        FROM requests r
        JOIN users u ON r.UserId = u.UserId
        JOIN meetup_places m ON r.MeetupPlaceId = m.PlaceId
        LEFT JOIN request_payments p ON r.RequestId = p.RequestId
        WHERE r.RequestStatus = ?
        ORDER BY r.RequestedAt DESC
    ");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();

    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requestId = $row['RequestId'];

        // Fetch status update timestamp
        $row['StatusUpdatedAt'] = fetchRequestStatusTimestamp($requestId, $row['RequestStatus']);

        // Fetch status history for the request
        $row['StatusHistory'] = fetchRequestStatusHistory($requestId);

        $requests[] = $row;
    }

    return $requests;
}

// Function to fetch the latest timestamp for the given request's current status
function fetchRequestStatusTimestamp($requestId, $status)
{
    global $conn;

    $stmt = $conn->prepare("
        SELECT MadeAt 
        FROM request_status_history 
        WHERE RequestId = ? AND Status = ? 
        ORDER BY MadeAt DESC 
        LIMIT 1
    ");
    $stmt->bind_param("is", $requestId, $status);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['MadeAt']; // Return the latest timestamp if found
    } else {
        return "N/A"; // Return 'N/A' if no record exists
    }
}

// Function to fetch the complete status history for a request
function fetchRequestStatusHistory($requestId)
{
    global $conn;

    $stmt = $conn->prepare("
        SELECT Status, MadeAt 
        FROM request_status_history 
        WHERE RequestId = ? 
        ORDER BY MadeAt ASC
    ");
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();

    $statusHistory = [];
    while ($row = $result->fetch_assoc()) {
        $statusHistory[] = $row;
    }

    return $statusHistory;
}
