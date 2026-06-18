-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2026 at 03:35 PM
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
-- Database: `clothingstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `adminID` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`adminID`, `fullName`, `email`, `username`, `passwordHash`, `createdAt`) VALUES
(4, 'Peter John', 'pj@gmail.com', 'pj_123', '182382c2609c1c428b04017f66e9cf6c', '2026-05-06 17:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `tblclothes`
--

CREATE TABLE `tblclothes` (
  `clothingID` int(11) NOT NULL,
  `sellerID` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `category` enum('tops','bottoms','dresses','outerwear','footwear','accessories','activewear') DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `itemCondition` enum('like new','good','fair') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `imagePath` varchar(255) DEFAULT 'images/default-clothing.jpg',
  `status` enum('pending','approved','sold','rejected') DEFAULT 'pending',
  `suggestedPrice` decimal(10,2) DEFAULT NULL,
  `co2Saved` decimal(5,2) DEFAULT 3.00,
  `waterSaved` int(11) DEFAULT 2700,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblclothes`
--

INSERT INTO `tblclothes` (`clothingID`, `sellerID`, `title`, `brand`, `category`, `size`, `itemCondition`, `price`, `description`, `imagePath`, `status`, `suggestedPrice`, `co2Saved`, `waterSaved`, `createdAt`) VALUES
(16, 11, 'LOS ANGELES', 'Shein / Unbranded (Collegiate Streetwear)', 'tops', 'L', 'good', 250.00, 'Trendy royal blue oversized crewneck sweatshirt featuring a white arched &quot;Los Angeles California&quot; collegiate varsity print. Made from a soft, comfortable cotton-fleece blend with dropped shoulders and ribbed cuffs/hem for a relaxed boyfriend fit. Perfect for casual streetwear styling. Excellent condition with no stains, fading, or cracking on the print.', 'images/6a15afb21058e.jpg', 'approved', NULL, 3.00, 2700, '2026-05-26 14:35:30'),
(17, 11, 'Los Angeles California Varsity Crewneck Sweatshirt', 'Shein / Unbranded (Collegiate Streetwear)', 'tops', 'L', 'like new', 349.97, 'Trendy dark red/crimson crewneck sweatshirt featuring an arched &quot;Los Angeles California&quot; collegiate varsity graphic in white outline text. Made from a comfortable, soft fleece blend fabric with cozy dropped shoulders, a slightly raised crew neckline, and ribbed detailing on the cuffs and hem. Relaxed, casual fit perfect for streetwear or lounging. Great condition with no noticeable fading, marks, or cracking on the print.', 'images/6a15b42cd1a7e.jpg', 'approved', NULL, 3.00, 2700, '2026-05-26 14:54:36'),
(18, 14, 'AP watch', 'Audemars Piguet', 'accessories', 'ONE', 'like new', 45000.00, '“John Mayer” Limited Limited of 200 pieces 41mm sliver 26574BC', 'images/6a1ea974ed80f.jpg', 'approved', NULL, 3.00, 2700, '2026-06-02 09:59:16'),
(19, 14, 'Metal and pearl necklace', 'prada', 'accessories', 'ONE', 'good', 504.00, 'Color Gold/Pearl', 'images/6a1eac4a79817.jpeg', 'approved', NULL, 3.00, 2700, '2026-06-02 10:11:22'),
(20, 14, 'Metal necklace', 'prada', 'accessories', 'ONE', 'like new', 12000.00, 'Color Gold', 'images/6a1eacecd4565.jpeg', 'sold', NULL, 3.00, 2700, '2026-06-02 10:14:04'),
(21, 15, 'puma tight', 'puma', 'activewear', 'M', 'like new', 170.00, 'black puma tights', 'images/6a1eaf48aabfb.jpg', 'approved', NULL, 3.00, 2700, '2026-06-02 10:24:08'),
(22, 15, 'nike shoes', 'nike', 'footwear', 'ONE', 'like new', 3000.00, 'black and white nike shoes size 7', 'images/6a1eafba8dfe6.jpg', 'approved', NULL, 3.00, 2700, '2026-06-02 10:26:02'),
(23, 15, 'gym set', 'Chris Cross', 'activewear', 'M', 'like new', 550.00, 'jogging Breathable Compression Sportswear Summer Men&#039;s Training Two-piece Tight T-shirt Fitness Shorts Gym Workout Set', 'images/6a1eb3498187f.jpeg', 'approved', NULL, 3.00, 2700, '2026-06-02 10:41:13'),
(24, 15, 'Gym-Gloves', 'DXM-SPORTS', 'activewear', 'S', 'like new', 555.00, 'Weightlifting-Workout-Gym-Gloves-', 'images/6a1eb5199d1ce.webp', 'approved', NULL, 3.00, 2700, '2026-06-02 10:48:57'),
(25, 16, 'red dress', 'mr price', 'dresses', 'XS', 'like new', 890.00, 'long red dress w short sleeve and a open chest', 'images/6a1eb9fe7eca8.jpeg', 'sold', NULL, 3.00, 2700, '2026-06-02 11:09:50'),
(26, 16, 'blue jean', 'Truworths', 'bottoms', 'L', 'like new', 780.00, 'Inwear\r\nDark Wash Balloon Cargo Jeans', 'images/6a1ebd564cff0.webp', 'approved', NULL, 3.00, 2700, '2026-06-02 11:24:06'),
(27, 16, 'blue shirt', 'Truworths', 'bottoms', 'M', 'fair', 89.00, 'navey blue short skirt', 'images/6a1ebdd59455a.jpg', 'approved', NULL, 3.00, 2700, '2026-06-02 11:26:13'),
(28, 16, 'Trench Coat', 'Truworths', 'outerwear', 'L', 'like new', 1300.00, 'Classic Brown Trench Coat', 'images/6a1ebf2d9f108.jpg', 'approved', NULL, 3.00, 2700, '2026-06-02 11:31:57'),
(29, 18, 'green short dress', 'Truworths', 'dresses', 'M', 'like new', 870.00, 'short sleeve green dress with open chest', 'images/6a203397e7d15.webp', 'rejected', NULL, 3.00, 2700, '2026-06-03 14:00:55'),
(30, 18, 'blue short dress', 'Truworths', 'dresses', 'M', 'like new', 900.00, 'blue short dress with open chest', 'images/6a2037eb5049f.webp', 'approved', 900.00, 3.00, 2700, '2026-06-03 14:19:23'),
(35, 18, 'black dress', 'Truworths', 'dresses', 'S', 'good', 870.00, 'short black dress', 'images/6a26c66d81bf9.jpeg', 'approved', NULL, 3.00, 2700, '2026-06-08 13:41:01'),
(37, 14, 'Black and White Court Vision Low', 'Nike', 'footwear', 'ONE', 'good', 1900.00, 'The fastbreak style of &#039;80s basketball meets the fast-paced culture of today&#039;s game, with the new Nike Court Vision Low. It features an upper inspired by old-school basketball sneakers and the classic rubber cupsole featured on some of the most iconic silhouettes of the past.', 'images/6a32cc5af2d89.webp', 'approved', NULL, 3.00, 2700, '2026-06-17 16:33:30');

-- --------------------------------------------------------

--
-- Table structure for table `tblmessages`
--

CREATE TABLE `tblmessages` (
  `messageID` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `clothingID` int(11) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `messageBody` text NOT NULL,
  `isRead` tinyint(1) DEFAULT 0,
  `sentAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblmessages`
--

INSERT INTO `tblmessages` (`messageID`, `senderID`, `receiverID`, `clothingID`, `subject`, `messageBody`, `isRead`, `sentAt`) VALUES
(4, 21, 17, 20, 'Regarding your order', 'Hello, please confirm the item condition and delivery details. Admin will follow up to ensure correct delivery.', 1, '2026-06-08 13:50:06'),
(5, 21, 17, 20, 'Regarding your order', 'Hello, please confirm the item condition and delivery details. Admin will follow up to ensure correct delivery.', 1, '2026-06-08 13:50:11'),
(6, 21, 17, 20, 'Regarding your order', 'Hello, please confirm the item condition and delivery details. Admin will follow up to ensure correct delivery.', 1, '2026-06-08 13:56:05'),
(7, 21, 14, 20, 'Regarding your order', 'Hello, please confirm the item condition and delivery details. Admin will follow up to ensure correct delivery.', 1, '2026-06-08 13:58:08'),
(8, 21, 22, NULL, 'Regarding your order', 'Hello Sheketli Mochaki, have you bought any items?', 1, '2026-06-17 16:40:53'),
(9, 22, 21, NULL, '0', 'No, I have not bought any items.', 0, '2026-06-17 16:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `tblorder`
--

CREATE TABLE `tblorder` (
  `orderID` int(11) NOT NULL,
  `buyerID` int(11) NOT NULL,
  `clothingID` int(11) NOT NULL,
  `deliveryName` varchar(100) NOT NULL,
  `deliveryAddress` text NOT NULL,
  `deliveryCity` varchar(100) DEFAULT NULL,
  `postalCode` varchar(20) DEFAULT NULL,
  `deliveryType` enum('residential','work') DEFAULT 'residential',
  `totalAmount` decimal(10,2) NOT NULL,
  `serviceFee` decimal(10,2) DEFAULT 15.00,
  `status` enum('pending','dispatched','delivered','cancelled') DEFAULT 'pending',
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblorder`
--

INSERT INTO `tblorder` (`orderID`, `buyerID`, `clothingID`, `deliveryName`, `deliveryAddress`, `deliveryCity`, `postalCode`, `deliveryType`, `totalAmount`, `serviceFee`, `status`, `orderDate`) VALUES
(11, 14, 25, 'Nathan mulaudzi junior', 'cardiff  road', 'Pretoria', '0001', 'residential', 905.00, 15.00, 'delivered', '2026-06-02 11:18:28'),
(12, 17, 20, 'lufuno', 'cardiff  road', 'Pretoria', '0001', 'residential', 12015.00, 15.00, 'pending', '2026-06-03 13:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `userID` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `role` enum('buyer','seller','both') DEFAULT 'buyer',
  `status` enum('pending','active','suspended') DEFAULT 'pending',
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postalCode` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profilePic` varchar(255) DEFAULT 'images/default-avatar.png',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`userID`, `fullName`, `email`, `username`, `passwordHash`, `role`, `status`, `address`, `city`, `postalCode`, `phone`, `profilePic`, `createdAt`) VALUES
(11, 'Katlago', 'kg@gmail.com', 'KG_14', '182382c2609c1c428b04017f66e9cf6c', 'seller', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-05-06 17:08:16'),
(13, 'Nathan', 'mulaudzi01@gmail.com', 'Junior_baby', '7b2475706fc87b6afd19827431318097', 'buyer', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-06-02 09:46:25'),
(14, 'Nathan', 'mulaudzi02@gmail.com', 'Junior_babySeller', '7b2475706fc87b6afd19827431318097', 'seller', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-06-02 09:48:43'),
(15, 'Lesego', 'lesegonkambule@gmail.com', 'khados_bubu', '6efb89d5eef2fe52a9ea51a38bdcc6f3', 'seller', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-06-02 10:20:32'),
(16, 'Rotondwa', 'makhadorotondwa@gmail.com', 'Desree_roto', '18e384c59abd63d6fe9047f17512220e', 'seller', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-06-02 10:56:37'),
(17, 'lufuno', 'makhado@gmail.com', 'lufuno_rii', '05e2b63a02f5fa5e817f4165dfc6e4aa', 'buyer', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-06-03 13:25:18'),
(18, 'tamar', 'phago@gmail.com', 'tamar_lili', '588e56783744d984648ac5c94174bc11', 'seller', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-06-03 13:41:14'),
(19, 'KABELO', 'kabelomm@gmail.com', 'KB_RIA', '018ec41ab0bdef881a65a54ea423ff71', 'buyer', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-06-08 12:26:19'),
(21, 'System', 'system@pastimes.local', 'system_user', 'fdc376203856d26998006fcbef19a201', 'buyer', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-06-08 13:50:06'),
(22, 'Sheketli Mochaki', 'sheketlim@gmail.com', 'SMM_77', '57ed1831ee91424bbf1ae336ad2847b7', 'buyer', 'active', NULL, NULL, NULL, NULL, 'images/default-avatar.png', '2026-06-17 15:58:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tblclothes`
--
ALTER TABLE `tblclothes`
  ADD PRIMARY KEY (`clothingID`),
  ADD KEY `sellerID` (`sellerID`);

--
-- Indexes for table `tblmessages`
--
ALTER TABLE `tblmessages`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `senderID` (`senderID`),
  ADD KEY `receiverID` (`receiverID`);

--
-- Indexes for table `tblorder`
--
ALTER TABLE `tblorder`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `buyerID` (`buyerID`),
  ADD KEY `clothingID` (`clothingID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblclothes`
--
ALTER TABLE `tblclothes`
  MODIFY `clothingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tblmessages`
--
ALTER TABLE `tblmessages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblorder`
--
ALTER TABLE `tblorder`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblclothes`
--
ALTER TABLE `tblclothes`
  ADD CONSTRAINT `tblclothes_ibfk_1` FOREIGN KEY (`sellerID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `tblmessages`
--
ALTER TABLE `tblmessages`
  ADD CONSTRAINT `tblmessages_ibfk_1` FOREIGN KEY (`senderID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblmessages_ibfk_2` FOREIGN KEY (`receiverID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `tblorder`
--
ALTER TABLE `tblorder`
  ADD CONSTRAINT `tblorder_ibfk_1` FOREIGN KEY (`buyerID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblorder_ibfk_2` FOREIGN KEY (`clothingID`) REFERENCES `tblclothes` (`clothingID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
