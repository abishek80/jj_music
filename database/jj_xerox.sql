-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 11:26 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jj_music`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_invoice`
--

CREATE TABLE `bill_invoice` (
  `id` int(11) NOT NULL,
  `sno` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `customer_name` varchar(500) NOT NULL,
  `bill_type` int(11) NOT NULL,
  `bill_amount` varchar(20) NOT NULL,
  `bill_charge_amount` varchar(20) NOT NULL,
  `total_amount` varchar(20) NOT NULL,
  `status` enum('paid','unpaid') DEFAULT NULL,
  `delete_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_bill_type`
--

CREATE TABLE `master_bill_type` (
  `id` int(11) NOT NULL,
  `sno` varchar(100) NOT NULL,
  `token` varchar(250) NOT NULL,
  `bill_type_name` varchar(250) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `delete_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_material`
--

CREATE TABLE `master_material` (
  `id` int(11) NOT NULL,
  `sno` varchar(100) NOT NULL,
  `token` varchar(250) NOT NULL,
  `material_name` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `delete_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_stock_in`
--

CREATE TABLE `material_stock_in` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_name` varchar(250) NOT NULL,
  `material_type` varchar(250) NOT NULL,
  `material_category` varchar(250) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  `buy_price` varchar(20) NOT NULL,
  `selling_price` varchar(20) NOT NULL,
  `buy_sub_price` varchar(50) NOT NULL,
  `selling_sub_price` varchar(50) NOT NULL,
  `delete_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_stock_out`
--

CREATE TABLE `material_stock_out` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_name` varchar(250) NOT NULL,
  `material_type` varchar(250) NOT NULL,
  `material_category` varchar(250) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  `buy_price` varchar(20) NOT NULL,
  `selling_price` varchar(20) NOT NULL,
  `buy_sub_total` varchar(20) NOT NULL,
  `sub_total` varchar(20) NOT NULL,
  `delete_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_bill`
--

CREATE TABLE `purchase_bill` (
  `id` int(11) NOT NULL,
  `sno` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `sub_total_amount` varchar(20) NOT NULL,
  `total_amount` varchar(20) NOT NULL,
  `delete_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `selling_bill`
--

CREATE TABLE `selling_bill` (
  `id` int(11) NOT NULL,
  `sno` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `customer_name` varchar(500) NOT NULL,
  `sub_total_amount` varchar(20) NOT NULL,
  `total_amount` varchar(20) NOT NULL,
  `delete_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `sno` varchar(100) NOT NULL,
  `token` varchar(250) NOT NULL,
  `login_code` varchar(100) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_number` varchar(100) NOT NULL,
  `status` varchar(11) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `delete_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `sno`, `token`, `login_code`, `user_name`, `password`, `email`, `mobile_number`, `status`, `is_admin`, `delete_status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'JJ001', 'admin', 'jj001', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'jjxerox@gmail.com', '1234567890', 'active', 1, 0, 1, '2025-02-20 17:12:58', 1, '2025-03-03 21:57:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill_invoice`
--
ALTER TABLE `bill_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_bill_type`
--
ALTER TABLE `master_bill_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_material`
--
ALTER TABLE `master_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_stock_in`
--
ALTER TABLE `material_stock_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_stock_out`
--
ALTER TABLE `material_stock_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_bill`
--
ALTER TABLE `purchase_bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selling_bill`
--
ALTER TABLE `selling_bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill_invoice`
--
ALTER TABLE `bill_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_bill_type`
--
ALTER TABLE `master_bill_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_material`
--
ALTER TABLE `master_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_stock_in`
--
ALTER TABLE `material_stock_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_stock_out`
--
ALTER TABLE `material_stock_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_bill`
--
ALTER TABLE `purchase_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `selling_bill`
--
ALTER TABLE `selling_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
