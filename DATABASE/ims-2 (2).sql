-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 04:27 PM
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
  `meter` int(255) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challan_details`
--

INSERT INTO `challan_details` (`id`, `challan_no`, `customer_name`, `company_name`, `meter`, `date`, `user_id`) VALUES
(1, 0, 'Nireshbhai', 'maruti fabrics', 1, '2024-07-05', 1001),
(2, 0, 'Nireshbhai', 'maruti fabrics', 2, '2024-07-05', 1001),
(3, 0, 'Nireshbhai', 'maruti fabrics', 3, '2024-07-05', 1001),
(4, 0, 'Nireshbhai', 'maruti fabrics', 4, '2024-07-05', 1001),
(5, 0, 'Nireshbhai', 'maruti fabrics', 5, '2024-07-05', 1001),
(6, 0, 'Nireshbhai', 'maruti fabrics', 6, '2024-07-05', 1001),
(7, 0, 'Nireshbhai', 'maruti fabrics', 7, '2024-07-05', 1001),
(8, 0, 'Nireshbhai', 'maruti fabrics', 8, '2024-07-05', 1001),
(9, 0, 'Nireshbhai', 'maruti fabrics', 9, '2024-07-05', 1001),
(10, 0, 'Nireshbhai', 'maruti fabrics', 10, '2024-07-05', 1001),
(11, 0, 'Nireshbhai', 'maruti fabrics', 11, '2024-07-05', 1001),
(12, 0, 'Nireshbhai', 'maruti fabrics', 12, '2024-07-05', 1001),
(13, 1, 'Nireshbhai', '2nd company', 1, '2024-07-05', 1001),
(14, 1, 'Nireshbhai', '2nd company', 2, '2024-07-05', 1001),
(15, 1, 'Nireshbhai', '2nd company', 3, '2024-07-05', 1001),
(16, 1, 'Nireshbhai', '2nd company', 4, '2024-07-05', 1001),
(17, 1, 'Nireshbhai', '2nd company', 5, '2024-07-05', 1001),
(18, 1, 'Nireshbhai', '2nd company', 6, '2024-07-05', 1001),
(19, 1, 'Nireshbhai', '2nd company', 7, '2024-07-05', 1001),
(20, 1, 'Nireshbhai', '2nd company', 8, '2024-07-05', 1001),
(21, 1, 'Nireshbhai', '2nd company', 9, '2024-07-05', 1001),
(22, 1, 'Nireshbhai', '2nd company', 10, '2024-07-05', 1001),
(23, 1, 'Nireshbhai', '2nd company', 11, '2024-07-05', 1001),
(24, 1, 'Nireshbhai', '2nd company', 12, '2024-07-05', 1001);

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
  `total_meter` int(255) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challan_header`
--

INSERT INTO `challan_header` (`id`, `challan_no`, `customer_name`, `company_name`, `total_taka`, `total_meter`, `date`, `user_id`) VALUES
(2, 1, 'Nireshbhai', '2nd company', 12, 78, '2024-07-05', 1001);

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
(1001, 'Patel Mobile', 'hp004086@gmail.com', 'HARSH PATEL', '$2y$10$V88BifLZIAN0zXFR3Lkng.fk4qHD4mREgy8VH6lzSpnIZS8DKfoJK', NULL, NULL, NULL, 'Gujarat', 'MS_00605.JPG', '05/07/2024 07:21:25 pm');

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `challan_header`
--
ALTER TABLE `challan_header`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
