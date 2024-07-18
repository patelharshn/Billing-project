-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2024 at 09:41 AM
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
-- Database: `ims-2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `last_login`) VALUES
(1, 'hp004086@gmail.com', 'admin@4086', '09/05/2024 07:04:05 pm');

-- --------------------------------------------------------

--
-- Table structure for table `billing_details`
--

CREATE TABLE `billing_details` (
  `id` int(255) NOT NULL,
  `bill_no` int(5) UNSIGNED ZEROFILL DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_qty` int(255) NOT NULL,
  `product_price` int(255) NOT NULL,
  `gst_amount` int(10) NOT NULL,
  `total` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing_header`
--

CREATE TABLE `billing_header` (
  `id` int(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `bill_no` int(5) UNSIGNED ZEROFILL DEFAULT NULL,
  `payment_status` varchar(20) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `challan_details`
--

CREATE TABLE `challan_details` (
  `id` int(255) NOT NULL,
  `challan_no` int(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `meter` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challan_details`
--

INSERT INTO `challan_details` (`id`, `challan_no`, `customer_name`, `company_name`, `meter`, `date`, `user_id`) VALUES
(1, 6, 'Nireshbhai', 'ITprojects', '101', '2024-07-16', 1001),
(2, 6, 'Nireshbhai', 'ITprojects', '102', '2024-07-16', 1001),
(3, 6, 'Nireshbhai', 'ITprojects', '103', '2024-07-16', 1001),
(4, 6, 'Nireshbhai', 'ITprojects', '104', '2024-07-16', 1001),
(5, 6, 'Nireshbhai', 'ITprojects', '105', '2024-07-16', 1001),
(6, 6, 'Nireshbhai', 'ITprojects', '106', '2024-07-16', 1001),
(7, 6, 'Nireshbhai', 'ITprojects', '107', '2024-07-16', 1001),
(8, 6, 'Nireshbhai', 'ITprojects', '108', '2024-07-16', 1001),
(9, 6, 'Nireshbhai', 'ITprojects', '109', '2024-07-16', 1001),
(10, 6, 'Nireshbhai', 'ITprojects', '110', '2024-07-16', 1001),
(11, 6, 'Nireshbhai', 'ITprojects', '111', '2024-07-16', 1001),
(12, 6, 'Nireshbhai', 'ITprojects', '112.5', '2024-07-16', 1001),
(13, 6, 'Nireshbhai', 'ITprojects', '113.20', '2024-07-16', 1001),
(14, 6, 'Nireshbhai', 'ITprojects', '114', '2024-07-16', 1001),
(15, 6, 'Nireshbhai', 'ITprojects', '115', '2024-07-16', 1001),
(16, 6, 'Nireshbhai', 'ITprojects', '116', '2024-07-16', 1001),
(17, 6, 'Nireshbhai', 'ITprojects', '117', '2024-07-16', 1001),
(18, 6, 'Nireshbhai', 'ITprojects', '118', '2024-07-16', 1001),
(19, 6, 'Nireshbhai', 'ITprojects', '119', '2024-07-16', 1001),
(20, 6, 'Nireshbhai', 'ITprojects', '120', '2024-07-16', 1001),
(21, 6, 'Nireshbhai', 'ITprojects', '121', '2024-07-16', 1001),
(22, 6, 'Nireshbhai', 'ITprojects', '122', '2024-07-16', 1001),
(23, 6, 'Nireshbhai', 'ITprojects', '123', '2024-07-16', 1001),
(24, 6, 'Nireshbhai', 'ITprojects', '125.6', '2024-07-16', 1001),
(25, 6, 'Nireshbhai', 'ITprojects', '101', '2024-07-16', 1001),
(26, 6, 'Nireshbhai', 'ITprojects', '102', '2024-07-16', 1001),
(27, 6, 'Nireshbhai', 'ITprojects', '103', '2024-07-16', 1001),
(28, 6, 'Nireshbhai', 'ITprojects', '104', '2024-07-16', 1001),
(29, 6, 'Nireshbhai', 'ITprojects', '105', '2024-07-16', 1001),
(30, 6, 'Nireshbhai', 'ITprojects', '106', '2024-07-16', 1001),
(31, 6, 'Nireshbhai', 'ITprojects', '107', '2024-07-16', 1001),
(32, 6, 'Nireshbhai', 'ITprojects', '108', '2024-07-16', 1001),
(33, 6, 'Nireshbhai', 'ITprojects', '109', '2024-07-16', 1001),
(34, 6, 'Nireshbhai', 'ITprojects', '110', '2024-07-16', 1001),
(35, 6, 'Nireshbhai', 'ITprojects', '111', '2024-07-16', 1001),
(36, 6, 'Nireshbhai', 'ITprojects', '112.5', '2024-07-16', 1001),
(37, 6, 'Nireshbhai', 'ITprojects', '113.20', '2024-07-16', 1001),
(38, 6, 'Nireshbhai', 'ITprojects', '114', '2024-07-16', 1001),
(39, 6, 'Nireshbhai', 'ITprojects', '115', '2024-07-16', 1001),
(40, 6, 'Nireshbhai', 'ITprojects', '116', '2024-07-16', 1001),
(41, 6, 'Nireshbhai', 'ITprojects', '117', '2024-07-16', 1001),
(42, 6, 'Nireshbhai', 'ITprojects', '118', '2024-07-16', 1001),
(43, 6, 'Nireshbhai', 'ITprojects', '119', '2024-07-16', 1001),
(44, 6, 'Nireshbhai', 'ITprojects', '120', '2024-07-16', 1001),
(45, 6, 'Nireshbhai', 'ITprojects', '121', '2024-07-16', 1001),
(46, 6, 'Nireshbhai', 'ITprojects', '122', '2024-07-16', 1001),
(47, 6, 'Nireshbhai', 'ITprojects', '123', '2024-07-16', 1001),
(48, 6, 'Nireshbhai', 'ITprojects', '125.6', '2024-07-16', 1001),
(49, 6, 'Nireshbhai', 'ITprojects', '101', '2024-07-16', 1001),
(50, 6, 'Nireshbhai', 'ITprojects', '102', '2024-07-16', 1001),
(51, 6, 'Nireshbhai', 'ITprojects', '103', '2024-07-16', 1001),
(52, 6, 'Nireshbhai', 'ITprojects', '104', '2024-07-16', 1001),
(53, 6, 'Nireshbhai', 'ITprojects', '105', '2024-07-16', 1001),
(54, 6, 'Nireshbhai', 'ITprojects', '106', '2024-07-16', 1001),
(55, 6, 'Nireshbhai', 'ITprojects', '107', '2024-07-16', 1001),
(56, 6, 'Nireshbhai', 'ITprojects', '108', '2024-07-16', 1001),
(57, 6, 'Nireshbhai', 'ITprojects', '109', '2024-07-16', 1001),
(58, 6, 'Nireshbhai', 'ITprojects', '110', '2024-07-16', 1001),
(59, 6, 'Nireshbhai', 'ITprojects', '111', '2024-07-16', 1001),
(60, 6, 'Nireshbhai', 'ITprojects', '112.5', '2024-07-16', 1001),
(61, 6, 'Nireshbhai', 'ITprojects', '113.20', '2024-07-16', 1001),
(62, 6, 'Nireshbhai', 'ITprojects', '114', '2024-07-16', 1001),
(63, 6, 'Nireshbhai', 'ITprojects', '115', '2024-07-16', 1001),
(64, 6, 'Nireshbhai', 'ITprojects', '116', '2024-07-16', 1001),
(65, 6, 'Nireshbhai', 'ITprojects', '117', '2024-07-16', 1001),
(66, 6, 'Nireshbhai', 'ITprojects', '118', '2024-07-16', 1001),
(67, 6, 'Nireshbhai', 'ITprojects', '119', '2024-07-16', 1001),
(68, 6, 'Nireshbhai', 'ITprojects', '120', '2024-07-16', 1001),
(69, 6, 'Nireshbhai', 'ITprojects', '121', '2024-07-16', 1001),
(70, 6, 'Nireshbhai', 'ITprojects', '122', '2024-07-16', 1001),
(71, 6, 'Nireshbhai', 'ITprojects', '123', '2024-07-16', 1001),
(72, 6, 'Nireshbhai', 'ITprojects', '125.6', '2024-07-16', 1001),
(73, 6, 'Nireshbhai', 'ITprojects', '101', '2024-07-16', 1001),
(74, 6, 'Nireshbhai', 'ITprojects', '102', '2024-07-16', 1001),
(75, 6, 'Nireshbhai', 'ITprojects', '103', '2024-07-16', 1001),
(76, 6, 'Nireshbhai', 'ITprojects', '104', '2024-07-16', 1001),
(77, 6, 'Nireshbhai', 'ITprojects', '105', '2024-07-16', 1001),
(78, 6, 'Nireshbhai', 'ITprojects', '106', '2024-07-16', 1001),
(79, 6, 'Nireshbhai', 'ITprojects', '107', '2024-07-16', 1001),
(80, 6, 'Nireshbhai', 'ITprojects', '108', '2024-07-16', 1001),
(81, 6, 'Nireshbhai', 'ITprojects', '109', '2024-07-16', 1001),
(82, 6, 'Nireshbhai', 'ITprojects', '110', '2024-07-16', 1001),
(83, 6, 'Nireshbhai', 'ITprojects', '111', '2024-07-16', 1001),
(84, 6, 'Nireshbhai', 'ITprojects', '112.5', '2024-07-16', 1001),
(85, 6, 'Nireshbhai', 'ITprojects', '113.20', '2024-07-16', 1001),
(86, 6, 'Nireshbhai', 'ITprojects', '114', '2024-07-16', 1001),
(87, 6, 'Nireshbhai', 'ITprojects', '115', '2024-07-16', 1001),
(88, 6, 'Nireshbhai', 'ITprojects', '116', '2024-07-16', 1001),
(89, 6, 'Nireshbhai', 'ITprojects', '117', '2024-07-16', 1001),
(90, 6, 'Nireshbhai', 'ITprojects', '118', '2024-07-16', 1001),
(91, 6, 'Nireshbhai', 'ITprojects', '119', '2024-07-16', 1001),
(92, 6, 'Nireshbhai', 'ITprojects', '120', '2024-07-16', 1001),
(93, 6, 'Nireshbhai', 'ITprojects', '121', '2024-07-16', 1001),
(94, 6, 'Nireshbhai', 'ITprojects', '122', '2024-07-16', 1001),
(95, 6, 'Nireshbhai', 'ITprojects', '123', '2024-07-16', 1001),
(96, 6, 'Nireshbhai', 'ITprojects', '125.6', '2024-07-16', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `challan_header`
--

CREATE TABLE `challan_header` (
  `id` int(255) NOT NULL,
  `challan_no` int(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `total_taka` int(255) NOT NULL,
  `total_meter` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `quality` varchar(255) NOT NULL,
  `broker` varchar(255) NOT NULL,
  `tempo_num` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challan_header`
--

INSERT INTO `challan_header` (`id`, `challan_no`, `customer_name`, `company_name`, `total_taka`, `total_meter`, `date`, `quality`, `broker`, `tempo_num`, `user_id`) VALUES
(1, 6, 'Nireshbhai', 'ITprojects', 24, '2702.3', '2024-07-16', 'QWE', 'PATEL JI', 'GJ05AB4086', 1001),
(2, 6, 'Nireshbhai', 'ITprojects', 24, '2702.3', '2024-07-16', 'QWE', 'PATEL JI', 'GJ05AB4086', 1001),
(3, 6, 'Nireshbhai', 'ITprojects', 24, '2702.3', '2024-07-16', 'QWE', 'PATEL JI', 'GJ05AB4086', 1001),
(4, 6, 'Nireshbhai', 'ITprojects', 24, '2702.3', '2024-07-16', 'QWE', 'PATEL JI', 'GJ05AB4086', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_mobile` varchar(15) NOT NULL,
  `company_gst` varchar(255) NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `company_address`, `company_mobile`, `company_gst`, `company_logo`, `user_id`) VALUES
(1, 'ITprojects', 'Surat, Althan', '1234567890', '123456789012345', '2024.png', 1001),
(2, 'patelmobile', 'XYZ', '1234567890', '123456789012345', '5.jpg', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(255) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_add` varchar(255) NOT NULL,
  `c_phone` varchar(255) DEFAULT NULL,
  `gstno` varchar(50) NOT NULL,
  `u_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `c_name`, `c_add`, `c_phone`, `gstno`, `u_id`) VALUES
(1001, 'Nireshbhai', 'Surat', '1234567890', '22AAAAA0000A1Z2', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `star` int(255) NOT NULL,
  `user_ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(255) DEFAULT NULL,
  `typeofsell` varchar(255) NOT NULL,
  `buy_price` int(255) NOT NULL DEFAULT 0,
  `sell_price` varchar(255) NOT NULL,
  `profit` int(255) NOT NULL,
  `gst` int(5) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_return`
--

CREATE TABLE `product_return` (
  `id` int(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `total` int(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(10) NOT NULL,
  `qty` int(255) NOT NULL,
  `total_cost` int(10) NOT NULL,
  `time` varchar(255) NOT NULL,
  `p_id` int(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `sup_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(255) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_address` varchar(255) NOT NULL,
  `supplier_phone` bigint(255) NOT NULL,
  `supplier_companyname` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tempo`
--

CREATE TABLE `tempo` (
  `id` int(255) NOT NULL,
  `tempo_number` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tempo`
--

INSERT INTO `tempo` (`id`, `tempo_number`, `user_id`) VALUES
(1, 'GJ05AB1234', 1001),
(2, 'GJ05AB4086', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `shopname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_no` bigint(255) DEFAULT NULL,
  `gstnumber` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `last_login` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `shopname`, `email`, `username`, `password`, `mobile_no`, `gstnumber`, `address`, `state`, `image`, `last_login`) VALUES
(1001, 'Patel Mobile', 'hp004086@gmail.com', 'HARSH PATEL', '$2y$10$V88BifLZIAN0zXFR3Lkng.fk4qHD4mREgy8VH6lzSpnIZS8DKfoJK', NULL, NULL, NULL, 'Gujarat', 'MS_00605.JPG', '18/07/2024 01:02:31 pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_details`
--
ALTER TABLE `billing_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`user_id`);

--
-- Indexes for table `billing_header`
--
ALTER TABLE `billing_header`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uuid` (`user_id`);

--
-- Indexes for table `challan_details`
--
ALTER TABLE `challan_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uuidd` (`user_id`);

--
-- Indexes for table `challan_header`
--
ALTER TABLE `challan_header`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uidd` (`user_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`u_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDUser` (`user_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_mail` (`user_id`);

--
-- Indexes for table `product_return`
--
ALTER TABLE `product_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`user_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempo`
--
ALTER TABLE `tempo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tempo_user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `billing_details`
--
ALTER TABLE `billing_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing_header`
--
ALTER TABLE `billing_header`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `challan_details`
--
ALTER TABLE `challan_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `challan_header`
--
ALTER TABLE `challan_header`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1018;

--
-- AUTO_INCREMENT for table `product_return`
--
ALTER TABLE `product_return`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `tempo`
--
ALTER TABLE `tempo`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing_details`
--
ALTER TABLE `billing_details`
  ADD CONSTRAINT `userID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `billing_header`
--
ALTER TABLE `billing_header`
  ADD CONSTRAINT `uuid` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `challan_details`
--
ALTER TABLE `challan_details`
  ADD CONSTRAINT `uuidd` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `challan_header`
--
ALTER TABLE `challan_header`
  ADD CONSTRAINT `uidd` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `uid` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `IDUser` FOREIGN KEY (`user_ID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `user_mail` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `p_id` FOREIGN KEY (`p_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `u_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tempo`
--
ALTER TABLE `tempo`
  ADD CONSTRAINT `tempo_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
