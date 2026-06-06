-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 11:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hazeyscrochet_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `AddedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `isRemoved` tinyint(1) NOT NULL DEFAULT 0,
  `OrderId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartId`, `UserId`, `ProductId`, `Quantity`, `AddedAt`, `isRemoved`, `OrderId`) VALUES
(1, 2, 4, 1, '2025-03-12 13:54:41', 1, NULL),
(2, 2, 1, 1, '2025-03-12 15:14:40', 1, NULL),
(3, 2, 8, 1, '2025-03-12 15:26:34', 1, NULL),
(4, 2, 7, 1, '2025-03-12 15:26:40', 1, NULL),
(5, 2, 18, 1, '2025-03-12 15:32:37', 1, NULL),
(6, 2, 11, 2, '2025-03-12 15:32:47', 1, NULL),
(7, 2, 13, 1, '2025-03-12 17:42:02', 1, NULL),
(8, 2, 24, 1, '2025-03-12 17:42:18', 1, NULL),
(9, 2, 2, 1, '2025-03-12 17:57:51', 1, NULL),
(10, 2, 15, 2, '2025-03-12 18:11:28', 1, NULL),
(11, 1, 3, 2, '2025-03-12 18:57:16', 1, NULL),
(12, 1, 4, 1, '2025-03-12 18:57:22', 1, NULL),
(13, 3, 3, 1, '2025-03-13 01:43:48', 1, NULL),
(14, 3, 22, 1, '2025-03-13 01:44:00', 1, NULL),
(15, 3, 25, 1, '2025-03-13 02:14:51', 1, NULL),
(16, 2, 6, 1, '2025-03-14 08:11:28', 1, NULL),
(17, 1, 13, 2, '2025-03-14 08:14:52', 1, NULL),
(18, 1, 29, 1, '2025-03-14 08:16:24', 1, NULL),
(19, 1, 17, 1, '2025-03-14 08:17:37', 1, NULL),
(20, 3, 1, 2, '2025-03-14 23:23:34', 0, NULL),
(21, 3, 2, 1, '2025-03-14 23:27:13', 0, NULL),
(22, 1, 2, 1, '2026-06-05 16:21:05', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meetup_places`
--

CREATE TABLE `meetup_places` (
  `PlaceId` int(11) NOT NULL,
  `PlaceName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meetup_places`
--

INSERT INTO `meetup_places` (`PlaceId`, `PlaceName`) VALUES
(1, 'UM Matina'),
(2, 'UM Bolton');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `MeetupPlaceId` int(11) NOT NULL,
  `TotalPrice` decimal(10,2) NOT NULL,
  `OrderStatus` enum('Pending','To Package','For Meetup','Delivered','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderId`, `UserId`, `MeetupPlaceId`, `TotalPrice`, `OrderStatus`, `CreatedAt`) VALUES
(1, 2, 1, 505.00, 'Completed', '2025-03-12 18:12:02'),
(2, 1, 2, 175.00, 'Delivered', '2025-03-12 18:57:51'),
(5, 3, 1, 170.00, 'To Package', '2025-03-13 01:47:20'),
(6, 3, 2, 200.00, 'Pending', '2025-03-13 02:14:59'),
(7, 2, 2, 120.00, 'Pending', '2025-03-14 08:11:36'),
(9, 1, 1, 240.00, 'Pending', '2025-03-14 08:15:00'),
(10, 1, 1, 50.00, 'To Package', '2025-03-14 08:16:31'),
(11, 1, 1, 120.00, 'To Package', '2025-03-14 08:17:43'),
(12, 2, 2, 195.00, 'For Meetup', '2025-03-14 08:38:27'),
(13, 3, 2, 50.00, 'For Meetup', '2025-03-14 22:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `OrderItemId` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`OrderItemId`, `OrderId`, `ProductId`, `Quantity`, `Price`) VALUES
(1, 1, 24, 1, 150.00),
(2, 1, 2, 1, 55.00),
(3, 1, 15, 2, 150.00),
(4, 2, 3, 2, 50.00),
(5, 2, 4, 1, 75.00),
(6, 5, 3, 1, 50.00),
(7, 5, 22, 1, 120.00),
(8, 6, 25, 1, 200.00),
(9, 7, 6, 1, 120.00),
(11, 9, 13, 2, 120.00),
(12, 10, 29, 1, 50.00),
(13, 11, 17, 1, 120.00),
(14, 12, 4, 1, 75.00),
(15, 12, 13, 1, 120.00),
(16, 13, 3, 1, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_payments`
--

CREATE TABLE `order_payments` (
  `PaymentId` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `PaymentMethod` enum('Cash on Meetup','GCash') NOT NULL,
  `PaymentRefNo` varchar(50) DEFAULT NULL,
  `ReceiptImage` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_payments`
--

INSERT INTO `order_payments` (`PaymentId`, `OrderId`, `PaymentMethod`, `PaymentRefNo`, `ReceiptImage`, `CreatedAt`) VALUES
(1, 1, 'GCash', '921741264', 'uploads/1741803122_IMG20240130135334.jpg', '2025-03-12 18:12:02'),
(2, 2, 'Cash on Meetup', NULL, NULL, '2025-03-12 18:57:51'),
(3, 5, 'GCash', '547548856', 'uploads/1741830440_28656b97-bd69-4d27-83bc-ca3decb02e98.jpg', '2025-03-13 01:47:20'),
(4, 6, 'Cash on Meetup', NULL, NULL, '2025-03-13 02:14:59'),
(5, 7, 'Cash on Meetup', NULL, NULL, '2025-03-14 08:11:36'),
(7, 9, 'Cash on Meetup', NULL, NULL, '2025-03-14 08:15:00'),
(8, 10, 'Cash on Meetup', NULL, NULL, '2025-03-14 08:16:31'),
(9, 11, 'Cash on Meetup', NULL, NULL, '2025-03-14 08:17:43'),
(10, 12, 'GCash', '6757547', 'uploads/1741941507_Whisper of the Heart_10.jpg', '2025-03-14 08:38:27'),
(11, 13, 'GCash', '637474868', 'uploads/1741990621_Whisper of the Heart_15.jpg', '2025-03-14 22:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `HistoryId` int(11) NOT NULL,
  `OrderId` int(11) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `MadeAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status_history`
--

INSERT INTO `order_status_history` (`HistoryId`, `OrderId`, `Status`, `MadeAt`) VALUES
(1, 1, 'To Package', '2025-03-12 18:12:45'),
(2, 1, 'For Meetup', '2025-03-12 18:21:17'),
(3, 1, 'Delivered', '2025-03-12 18:21:19'),
(4, 1, 'Completed', '2025-03-12 18:22:46'),
(5, 2, 'To Package', '2025-03-13 02:11:15'),
(6, 5, 'To Package', '2025-03-13 02:16:05'),
(7, 2, 'For Meetup', '2025-03-13 03:01:24'),
(8, 13, 'To Package', '2025-03-14 22:22:39'),
(9, 12, 'To Package', '2025-03-14 23:15:02'),
(10, 13, 'For Meetup', '2025-03-14 23:15:17'),
(11, 11, 'To Package', '2025-03-14 23:19:02'),
(12, 10, 'To Package', '2025-03-14 23:19:31'),
(13, 12, 'For Meetup', '2025-03-14 23:19:36'),
(14, 2, 'Delivered', '2025-03-14 23:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductId` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `ProductPrice` decimal(10,2) NOT NULL,
  `ProductImg` varchar(127) NOT NULL,
  `ProductCategory` varchar(127) NOT NULL,
  `InStock` int(11) NOT NULL DEFAULT 0,
  `IsActive` tinyint(4) NOT NULL DEFAULT 1,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductId`, `ProductName`, `ProductPrice`, `ProductImg`, `ProductCategory`, `InStock`, `IsActive`, `CreatedAt`) VALUES
(1, 'Bee', 45.00, 'key-bee.jpg', 'keychain animal', 9, 1, '2025-02-15 11:39:24'),
(2, 'Bunny', 55.00, 'key-bunny.jpg', 'keychain animal', 7, 1, '2025-02-15 11:40:01'),
(3, 'Chick', 50.00, 'key-chick.jpg', 'keychain animal', 8, 1, '2025-02-15 11:40:01'),
(4, 'Dog', 75.00, 'key-dog.jpg', 'keychain animal', 7, 1, '2025-02-15 12:35:47'),
(5, 'Fish', 200.00, 'key-fish.jpg', 'keychain animal', 6, 1, '2025-02-15 12:35:47'),
(6, 'Frog', 120.00, 'key-frog.jpg', 'keychain animal', 5, 1, '2025-02-15 12:35:47'),
(7, 'Hamster', 180.00, 'key-hamster.jpg', 'keychain animal', 6, 1, '2025-02-15 12:35:47'),
(8, 'Penguin', 150.00, 'key-penguin.jpg', 'keychain animal', 8, 1, '2025-02-15 12:35:47'),
(9, 'Pig', 200.00, 'key-pig.jpg', 'keychain animal', 5, 1, '2025-02-15 12:35:47'),
(10, 'Octopus', 120.00, 'key-octopus.jpg', 'keychain animal', 4, 1, '2025-02-15 12:35:47'),
(11, 'Whale', 180.00, 'key-whale.jpg', 'keychain animal', 5, 1, '2025-02-15 12:35:47'),
(12, 'Egg', 200.00, 'key-egg.jpg', 'keychain food', 4, 1, '2025-02-15 12:35:47'),
(13, 'Melon', 120.00, 'key-melon.jpg', 'keychain food', 7, 1, '2025-02-15 12:35:47'),
(14, 'Oreo', 180.00, 'key-oreo.jpg', 'keychain food', 5, 1, '2025-02-15 12:35:47'),
(15, 'Taco', 150.00, 'key-taco.jpg', 'keychain food', 7, 1, '2025-02-15 12:35:47'),
(16, 'Clover', 200.00, 'key-clover.jpg', 'keychain nature', 5, 1, '2025-02-15 12:35:47'),
(17, 'Purple', 120.00, 'key-purple.jpg', 'keychain nature', 7, 1, '2025-02-15 12:35:47'),
(18, 'Heart', 180.00, 'key-heart.jpg', 'keychain misc', 9, 1, '2025-02-15 12:35:47'),
(19, 'Traffic Cone', 120.00, 'key-cone.jpg', 'keychain misc', 7, 1, '2025-02-15 12:35:47'),
(20, 'Kirby', 180.00, 'key-kirby.jpg', 'keychain cartoon', 6, 1, '2025-02-15 12:35:47'),
(21, 'Melon Hat', 200.00, 'hat-melon.jpg', 'clothing food', 4, 1, '2025-02-15 12:35:47'),
(22, 'Strawberry Hat', 120.00, 'hat-strawberry.jpg', 'clothing food', 7, 1, '2025-02-15 12:35:47'),
(23, 'Daisy Bandana', 180.00, 'bandana-daisy.jpg', 'clothing nature', 6, 1, '2025-02-15 12:35:47'),
(24, 'Daisy Hat', 150.00, 'hat-daisy.jpg', 'clothing nature', 8, 1, '2025-02-15 12:35:47'),
(25, 'Skull Hat', 200.00, 'hat-skull.jpg', 'clothing misc', 7, 1, '2025-02-15 12:35:47'),
(26, 'Plain Bandana', 120.00, 'bandana-plain.jpg', 'clothing ', 8, 1, '2025-02-15 12:35:47'),
(27, 'Rose Pouch', 180.00, 'pouch-rose.png', 'misc nature', 6, 1, '2025-02-15 12:35:47'),
(28, 'Blue Pouch', 120.00, 'pouch-blue.png', 'misc', 6, 1, '2025-02-15 12:35:47'),
(29, 'Flat Pouch', 50.00, 'pouch-flat.png', 'misc', 14, 1, '2025-02-15 12:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `RequestId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `MeetupPlaceId` int(11) DEFAULT NULL,
  `RequestName` varchar(127) NOT NULL,
  `Deadline` date NOT NULL,
  `Instructions` varchar(255) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `ReferenceImage` varchar(127) DEFAULT NULL,
  `RequestPrice` decimal(10,2) DEFAULT NULL,
  `RequestStatus` enum('Pending','To Pay','In Progress','To Package','For Meetup','Delivered','Completed','Rejected','Cancelled') NOT NULL DEFAULT 'Pending',
  `RequestedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `AdminMessage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`RequestId`, `UserId`, `MeetupPlaceId`, `RequestName`, `Deadline`, `Instructions`, `Quantity`, `ReferenceImage`, `RequestPrice`, `RequestStatus`, `RequestedAt`, `AdminMessage`) VALUES
(1, 2, 1, 'Calico Cat', '2025-03-28', 'Make a calico cat', 1, 'uploads/1741716545_413130432_673172218322840_6986619840207552766_n.jpg', 150.00, 'In Progress', '2025-03-11 09:28:50', 'Please pay the required amount <3'),
(2, 2, 2, 'Donut', '2025-03-26', 'Make a confetti donut with pink glaze', 1, 'uploads/1741742954_donut s.png', 75.00, 'Completed', '2025-03-12 09:01:49', 'Accepted :) Please pay the set amount.'),
(3, 2, 2, 'Cookie', '2025-03-23', 'Make it cute!', 1, 'uploads/1741801031_richard-wright-1-storm.jpg', 45.00, 'To Pay', '2025-03-12 17:37:11', 'Will work on it as quickly as possible!'),
(4, 2, 1, 'Basketball', '2025-03-29', 'Make it cute and small.', 1, 'uploads/1741804037_IMG20240424175343.jpg', 0.00, 'Rejected', '2025-03-12 18:27:17', 'I am sorry. I cannot do this as I dislike basketball <3'),
(5, 3, 1, 'Hello Kitty Keychain', '2025-03-27', 'Hi! So I want a hello kitty keychain that\'s approximately like 1.5-2 inches big. Make it as girly as possible. Thank you!', 1, 'uploads/1741831432_wallpaperflare.com_wallpaper (3).jpg', NULL, 'Pending', '2025-03-13 02:03:52', NULL),
(6, 3, 2, 'Susuwatari Keychain', '2025-03-31', 'Susuwatari are the dust creatures from the Studio Ghibli film \"Spirited Away\". Just please make it look as similar as possible.', 1, 'uploads/1741991461_wallpaperflare.com_wallpaper (2).jpg', 0.00, 'Rejected', '2025-03-14 22:31:01', 'I\'m sorry but I cannot make this and submit before the deadline.'),
(7, 3, 2, 'Orange Keychain', '2025-04-17', 'No further instructions.', 1, 'uploads/1741991862_wallpaperflare.com_wallpaper.jpg', 55.00, 'For Meetup', '2025-03-14 22:37:42', 'Cute! Please pay the set amount so I can start working on it!');

-- --------------------------------------------------------

--
-- Table structure for table `request_payments`
--

CREATE TABLE `request_payments` (
  `PaymentId` int(11) NOT NULL,
  `RequestId` int(11) NOT NULL,
  `PaymentMethod` enum('Cash on Meetup','GCash') NOT NULL,
  `PaymentRefNo` varchar(50) DEFAULT NULL,
  `ReceiptImage` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_payments`
--

INSERT INTO `request_payments` (`PaymentId`, `RequestId`, `PaymentMethod`, `PaymentRefNo`, `ReceiptImage`, `CreatedAt`) VALUES
(2, 1, 'GCash', '36458675', 'uploads/1741799639_dennis-chan-peters-workshop-final-v01.jpg', '2025-03-12 17:13:59'),
(3, 2, 'GCash', '976067547', 'uploads/1741832510_pxfuel (8).jpg', '2025-03-13 02:21:50'),
(4, 7, 'GCash', '56436346', 'uploads/1741992587_pxfuel.jpg', '2025-03-14 22:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `request_status_history`
--

CREATE TABLE `request_status_history` (
  `HistoryId` int(11) NOT NULL,
  `RequestId` int(11) NOT NULL,
  `Status` enum('Pending','To Pay','In Progress','To Package','For Meetup','Delivered','Completed','Rejected','Cancelled') NOT NULL,
  `MadeAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_status_history`
--

INSERT INTO `request_status_history` (`HistoryId`, `RequestId`, `Status`, `MadeAt`) VALUES
(1, 1, 'To Pay', '2025-03-12 09:28:50'),
(2, 2, 'To Pay', '2025-03-12 09:34:27'),
(3, 1, 'In Progress', '2025-03-12 17:13:59'),
(4, 3, 'To Pay', '2025-03-12 17:59:39'),
(5, 4, 'Rejected', '2025-03-12 18:30:05'),
(6, 2, 'In Progress', '2025-03-13 02:21:50'),
(7, 2, 'To Package', '2025-03-13 02:36:37'),
(8, 2, 'For Meetup', '2025-03-13 02:40:01'),
(9, 2, 'Delivered', '2025-03-14 07:29:55'),
(10, 2, 'Completed', '2025-03-14 07:30:09'),
(11, 7, 'To Pay', '2025-03-14 22:48:32'),
(12, 7, 'In Progress', '2025-03-14 22:49:47'),
(13, 7, 'To Package', '2025-03-14 22:56:12'),
(14, 7, 'For Meetup', '2025-03-14 23:00:26'),
(15, 6, 'Rejected', '2025-03-14 23:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `OrderId` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `ReviewText` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewId`, `UserId`, `OrderId`, `ProductId`, `Rating`, `ReviewText`, `CreatedAt`) VALUES
(6, 2, 1, 24, 5, 'This is cute. Matches my aesthetic so much!', '2025-03-12 18:24:13'),
(7, 2, 1, 2, 5, 'Adorable! Great accessory for my purse.', '2025-03-12 18:24:13'),
(8, 2, 1, 15, 5, 'I love it!!!', '2025-03-12 18:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `FirstName` varchar(127) NOT NULL,
  `LastName` varchar(127) NOT NULL,
  `Username` varchar(127) NOT NULL,
  `ProfileImage` varchar(127) DEFAULT NULL,
  `ContactNumber` varchar(127) NOT NULL,
  `Email` varchar(127) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FacebookLink` varchar(127) NOT NULL,
  `RegisteredAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `FirstName`, `LastName`, `Username`, `ProfileImage`, `ContactNumber`, `Email`, `Password`, `FacebookLink`, `RegisteredAt`) VALUES
(1, 'admin', 'admin', 'admin', NULL, '09495655839', 'admin@gmail.com', '$2y$10$QBGIcVOe8O5sg5xJVKKgY.fhKInFYmTSuUCp5ECtGzXpQikj0j962', 'https://www.facebook.com/christianjames.cahilig', '2025-02-25 10:42:27'),
(2, 'Christian', 'Cahilig', 'james', NULL, '09346346054', 'christianc.xviii@gmail.com', '$2y$10$4ycAKSomBUuVRkAUQzjAdexmby3pIhk1HReNa3E/Dz1.VJ7/I/AwC', '', '2025-03-14 08:59:56'),
(3, 'Bai Fatima', 'Andong', 'baifat', NULL, '09123456789', 'andongf@gmail.com', '$2y$10$re7afnw2uxZmsh1hHCcE1.4KZ8TCuDR3Qf4lSSOeiV5N79jG0ZNKa', '', '2025-03-14 23:22:13'),
(4, 'Karylle', 'Gellica', 'kgellica', NULL, '09458162143', 'kgellica@gmail.com', '$2y$10$hBDJLWhZJh0xvrmatc4kGuD/zdtax9/U/1FApyJ/Sh2Gcws5UZoLa', '', '2025-03-03 05:19:45'),
(5, 'John', 'Sarmiento', 'llorieeer', NULL, '0987767676', 'sarmiento@gmail.com', '$2y$10$G60i/csJCd.yB6dyHwaQZOxAZgVwKYhHUStw64psQB/cbzdbar61q', '', '2025-03-03 07:10:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartId`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `ProductId` (`ProductId`),
  ADD KEY `fk_cart_order` (`OrderId`);

--
-- Indexes for table `meetup_places`
--
ALTER TABLE `meetup_places`
  ADD PRIMARY KEY (`PlaceId`) USING BTREE;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderId`) USING BTREE,
  ADD KEY `UserId` (`UserId`),
  ADD KEY `MeetupPlaceId` (`MeetupPlaceId`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`OrderItemId`),
  ADD KEY `ProductId` (`ProductId`),
  ADD KEY `OrderId` (`OrderId`) USING BTREE;

--
-- Indexes for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD PRIMARY KEY (`PaymentId`),
  ADD KEY `fk_payments_order` (`OrderId`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`HistoryId`),
  ADD KEY `fk_status_history_order` (`OrderId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductId`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`RequestId`),
  ADD KEY `fk_requests_userid` (`UserId`),
  ADD KEY `fk_requests_meetup` (`MeetupPlaceId`);

--
-- Indexes for table `request_payments`
--
ALTER TABLE `request_payments`
  ADD PRIMARY KEY (`PaymentId`),
  ADD KEY `fk_request_payments_request` (`RequestId`);

--
-- Indexes for table `request_status_history`
--
ALTER TABLE `request_status_history`
  ADD PRIMARY KEY (`HistoryId`),
  ADD KEY `RequestId` (`RequestId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewId`),
  ADD KEY `OrderId` (`OrderId`),
  ADD KEY `ProductId` (`ProductId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `meetup_places`
--
ALTER TABLE `meetup_places`
  MODIFY `PlaceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `OrderItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_payments`
--
ALTER TABLE `order_payments`
  MODIFY `PaymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `HistoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `RequestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `request_payments`
--
ALTER TABLE `request_payments`
  MODIFY `PaymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `request_status_history`
--
ALTER TABLE `request_status_history`
  MODIFY `HistoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ProductId`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_order` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_meetup` FOREIGN KEY (`MeetupPlaceId`) REFERENCES `meetup_places` (`PlaceId`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_order` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_product` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ProductId`) ON DELETE CASCADE;

--
-- Constraints for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD CONSTRAINT `fk_payments_order` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE CASCADE;

--
-- Constraints for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD CONSTRAINT `fk_status_history_order` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE CASCADE;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `fk_requests_meetup` FOREIGN KEY (`MeetupPlaceId`) REFERENCES `meetup_places` (`PlaceId`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_requests_userid` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE;

--
-- Constraints for table `request_payments`
--
ALTER TABLE `request_payments`
  ADD CONSTRAINT `fk_request_payments_request` FOREIGN KEY (`RequestId`) REFERENCES `requests` (`RequestId`) ON DELETE CASCADE;

--
-- Constraints for table `request_status_history`
--
ALTER TABLE `request_status_history`
  ADD CONSTRAINT `request_status_history_ibfk_1` FOREIGN KEY (`RequestId`) REFERENCES `requests` (`RequestId`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ProductId`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
