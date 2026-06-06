<?php
include 'db_auth.php';

// Fetch order status counts
$orderQuery = "SELECT 
                SUM(CASE WHEN OrderStatus = 'Pending' THEN 1 ELSE 0 END) AS pendingOrders,
                SUM(CASE WHEN OrderStatus = 'To Package' THEN 1 ELSE 0 END) AS toPackageOrders,
                SUM(CASE WHEN OrderStatus = 'For Meetup' THEN 1 ELSE 0 END) AS forMeetupOrders,
                SUM(CASE WHEN OrderStatus = 'Delivered' THEN 1 ELSE 0 END) AS deliveredOrders,
                SUM(CASE WHEN OrderStatus = 'Completed' THEN 1 ELSE 0 END) AS completedOrders,
                SUM(CASE WHEN OrderStatus = 'Cancelled' THEN 1 ELSE 0 END) AS cancelledOrders
               FROM orders";
$orderResult = mysqli_query($conn, $orderQuery);
$orderData = mysqli_fetch_assoc($orderResult);

$pendingOrders = $orderData['pendingOrders'] ?? 0;
$toPackageOrders = $orderData['toPackageOrders'] ?? 0;
$formeetupOrders = $orderData['forMeetupOrders'] ?? 0;
$deliveredOrders = $orderData['deliveredOrders'] ?? 0;
$completedOrders = $orderData['completedOrders'] ?? 0;
$cancelledOrders = $orderData['cancelledOrders'] ?? 0;

// Fetch request status counts
$requestQuery = "SELECT 
                SUM(CASE WHEN RequestStatus = 'Pending' THEN 1 ELSE 0 END) AS pendingRequests,
                SUM(CASE WHEN RequestStatus = 'To Pay' THEN 1 ELSE 0 END) AS toPayRequests,
                SUM(CASE WHEN RequestStatus = 'In Progress' THEN 1 ELSE 0 END) AS inProgressRequests,
                SUM(CASE WHEN RequestStatus = 'To Package' THEN 1 ELSE 0 END) AS toPackageRequests,
                SUM(CASE WHEN RequestStatus = 'For Meetup' THEN 1 ELSE 0 END) AS forMeetupRequests,
                SUM(CASE WHEN RequestStatus = 'Delivered' THEN 1 ELSE 0 END) AS deliveredRequests,
                SUM(CASE WHEN RequestStatus = 'Completed' THEN 1 ELSE 0 END) AS completedRequests,
                SUM(CASE WHEN RequestStatus = 'Rejected' THEN 1 ELSE 0 END) AS rejectedRequests,
                SUM(CASE WHEN RequestStatus = 'Cancelled' THEN 1 ELSE 0 END) AS cancelledRequests
               FROM requests";
$requestResult = mysqli_query($conn, $requestQuery);
$requestData = mysqli_fetch_assoc($requestResult);

$pendingRequests = $requestData['pendingRequests'] ?? 0;
$toPayRequests = $requestData['toPayRequests'] ?? 0;
$inProgressRequests = $requestData['inProgressRequests'] ?? 0;
$toPackageRequests = $requestData['toPackageRequests'] ?? 0;
$forMeetupRequests = $requestData['forMeetupRequests'] ?? 0;
$deliveredRequests = $requestData['deliveredRequests'] ?? 0;
$completedRequests = $requestData['completedRequests'] ?? 0;
$rejectedRequests = $requestData['rejectedRequests'] ?? 0;
$cancelledRequests = $requestData['cancelledRequests'] ?? 0;

// Fetch total products and low stock count
$productQuery = "SELECT 
                    COUNT(*) AS totalProducts, 
                    SUM(CASE WHEN InStock <= 5 THEN 1 ELSE 0 END) AS lowStock 
                 FROM products";
$productResult = mysqli_query($conn, $productQuery);
$productData = mysqli_fetch_assoc($productResult);

$totalProducts = $productData['totalProducts'] ?? 0;
$lowStockProducts = $productData['lowStock'] ?? 0;

// Fetch products with low stock (≤5)
$lowStockQuery = "SELECT ProductName, InStock FROM products WHERE InStock <= 5 ORDER BY InStock ASC";
$lowStockResult = mysqli_query($conn, $lowStockQuery);

$lowStockProductsList = [];
while ($row = mysqli_fetch_assoc($lowStockResult)) {
  $lowStockProductsList[] = $row;
}

// Fetch customer statistics
$customerQuery = "SELECT 
                    COUNT(*) AS totalCustomers, 
                    SUM(CASE WHEN RegisteredAt >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS newCustomers
                 FROM users";
$customerResult = mysqli_query($conn, $customerQuery);
$customerData = mysqli_fetch_assoc($customerResult);

$totalCustomers = $customerData['totalCustomers'] ?? 0;
$newCustomers = $customerData['newCustomers'] ?? 0;

// Fetch total revenue from completed orders
$orderRevenueQuery = "SELECT 
                        SUM(TotalPrice) AS totalOrderRevenue 
                      FROM orders 
                      WHERE OrderStatus = 'Completed'";
$orderRevenueResult = mysqli_query($conn, $orderRevenueQuery);
$orderRevenueData = mysqli_fetch_assoc($orderRevenueResult);
$totalOrderRevenue = $orderRevenueData['totalOrderRevenue'] ?? 0;

// Fetch total revenue from completed requests
$requestRevenueQuery = "SELECT 
                          SUM(RequestPrice) AS totalRequestRevenue 
                        FROM requests 
                        WHERE RequestStatus = 'Completed'";
$requestRevenueResult = mysqli_query($conn, $requestRevenueQuery);
$requestRevenueData = mysqli_fetch_assoc($requestRevenueResult);
$totalRequestRevenue = $requestRevenueData['totalRequestRevenue'] ?? 0;

// Calculate the grand total revenue (orders + requests)
$grandTotalRevenue = $totalOrderRevenue + $totalRequestRevenue;

mysqli_close($conn);
