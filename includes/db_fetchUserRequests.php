<?php
require 'db_auth.php';

if (!isset($_SESSION['user_id'])) {
    die("You must log in first.");
}

$userId = intval($_SESSION['user_id']); // Ensure it's an integer

// Fetch all requests made by the user along with the latest status timestamp
$sqlRequests = "SELECT r.RequestId, r.RequestName, r.Deadline, r.Instructions, 
                       r.Quantity, r.ReferenceImage, r.RequestPrice, r.RequestStatus, r.RequestedAt, r.AdminMessage,
                       (SELECT h.MadeAt FROM request_status_history h 
                        WHERE h.RequestId = r.RequestId AND h.Status = r.RequestStatus 
                        ORDER BY h.MadeAt DESC LIMIT 1) AS StatusUpdatedAt
                FROM requests r
                WHERE r.UserId = ? 
                ORDER BY r.RequestedAt DESC";

$stmtRequests = $conn->prepare($sqlRequests);
$stmtRequests->bind_param("i", $userId);
$stmtRequests->execute();
$resultRequests = $stmtRequests->get_result();

$requests = [];
while ($request = $resultRequests->fetch_assoc()) {
    $requests[$request['RequestId']] = [
        'RequestId' => $request['RequestId'],
        'RequestName' => $request['RequestName'],
        'Deadline' => $request['Deadline'],
        'Instructions' => $request['Instructions'],
        'Quantity' => $request['Quantity'],
        'RequestPrice' => $request['RequestPrice'],
        'ReferenceImage' => $request['ReferenceImage'],
        'RequestStatus' => $request['RequestStatus'],
        'RequestedAt' => $request['RequestedAt'],
        'AdminMessage' => $request['AdminMessage'],
        'StatusUpdatedAt' => $request['StatusUpdatedAt'] ?? 'N/A', // Latest status timestamp
        'StatusHistory' => [] // Placeholder for history
    ];
}
$stmtRequests->close();

// Fetch status history for each request
if (!empty($requests)) {
    $requestIds = implode(',', array_keys($requests)); // Get request IDs for filtering
    $sqlHistory = "SELECT RequestId, Status, MadeAt 
                   FROM request_status_history 
                   WHERE RequestId IN ($requestIds) 
                   ORDER BY MadeAt ASC";

    $resultHistory = $conn->query($sqlHistory);
    while ($history = $resultHistory->fetch_assoc()) {
        $requests[$history['RequestId']]['StatusHistory'][] = [
            'Status' => $history['Status'],
            'MadeAt' => $history['MadeAt']
        ];
    }
}
