-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 25, 2024 at 06:37 PM
-- Server version: 8.0.37-0ubuntu0.22.04.3
-- PHP Version: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jwt`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_master`
--

CREATE TABLE `accounts_master` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `group_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `accounts_master`
--

INSERT INTO `accounts_master` (`id`, `name`, `group_id`) VALUES
(1, 'Okys Stationery', 5),
(2, 'Prakash Interprises', 5),
(3, 'Balaji Trasport', 6),
(4, 'Mayank Trasport', 6);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mobile` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_on` date DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `address`, `mobile`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'Vaibhav Jain', 'vaibhavJain@gmail.com', '603 pearl Sky', '1234567890', 2, '2024-04-24', NULL, NULL),
(2, 'Vaibhav Jain', 'vaibhavJain@gmail.com', '603 pearl Sky', '1234567890', 2, '2024-04-24', NULL, NULL),
(3, 'Mayur Motwani', 'Mayur@gmail.com', '605 pearl Sky', '1234567893', 2, '2024-04-24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int NOT NULL,
  `date` date NOT NULL,
  `customer_id` int NOT NULL,
  `billing_address` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `delivery_address` text COLLATE utf8mb3_unicode_ci,
  `transporter_id` int DEFAULT NULL,
  `gross_amount_total` decimal(10,2) DEFAULT NULL,
  `discount_amount_total` decimal(10,2) DEFAULT NULL,
  `tax_amount_total` decimal(10,2) DEFAULT NULL,
  `net_amount_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `date`, `customer_id`, `billing_address`, `delivery_address`, `transporter_id`, `gross_amount_total`, `discount_amount_total`, `tax_amount_total`, `net_amount_total`) VALUES
(1, '2024-06-14', 2, 'as', '', 0, '80.00', '2.80', '1.92', '79.12'),
(2, '2024-06-14', 2, 'as', '', 0, '80.00', '2.80', '1.92', '79.12'),
(3, '2024-06-14', 2, 'as', '', 0, '270.00', '8.40', '5.50', '267.10'),
(4, '2024-06-26', 1, 'asdfadf', '', 0, '45.00', '0.00', '0.00', '45.00'),
(5, '2021-05-04', 2, 'asdfkljlj', 'a', 0, '95.00', '4.20', '2.38', '93.18'),
(6, '2020-04-01', 2, 'asdfff', '', 0, '30.00', '0.00', '0.00', '30.00'),
(7, '2020-04-01', 2, 'asdfff', '', 0, '230.00', '40.60', '16.29', '205.69'),
(8, '2020-04-01', 2, 'asdfff', '', 0, '230.00', '40.60', '16.29', '205.69'),
(9, '2020-04-01', 2, 'asdfff', '', 0, '230.00', '40.60', '16.29', '205.69'),
(10, '2020-04-01', 2, 'asdfff', '', 0, '230.00', '40.60', '16.29', '205.69'),
(11, '2020-04-01', 2, 'asdfff', '', 0, '230.00', '40.60', '16.29', '205.69'),
(12, '2020-04-01', 2, 'asdfff', '', 0, '3176.00', '0.00', '0.00', '3176.00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int NOT NULL,
  `invoice_id` int NOT NULL,
  `item_id` int NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `gross_amount` decimal(10,2) DEFAULT NULL,
  `tax_rate` decimal(5,2) DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `discount_rate` decimal(5,2) DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `net_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `item_id`, `qty`, `rate`, `gross_amount`, `tax_rate`, `tax_amount`, `discount_rate`, `discount_amount`, `net_amount`) VALUES
(12, 3, 1, '10.00', '15.00', '150.00', '3.00', '4.32', '4.00', '6.00', '148.32'),
(26, 12, 2, '21.00', '22.00', '462.00', '0.00', '0.00', '0.00', '0.00', '462.00'),
(27, 12, 1, '31.00', '32.00', '992.00', '0.00', '0.00', '0.00', '0.00', '992.00'),
(28, 12, 2, '41.00', '42.00', '1722.00', '0.00', '0.00', '0.00', '0.00', '1722.00');

-- --------------------------------------------------------

--
-- Table structure for table `item_master`
--

CREATE TABLE `item_master` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `group_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`id`, `name`, `group_id`) VALUES
(1, 'item1', 1),
(2, 'Item2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `active`) VALUES
(1, 'manoj rathore', 'manoj@manoj.com', '1234567890', 'abc123456789', 1),
(12, 'manoj rathore', 'manoj@manoj1.com', 'asdf223211', 'asdfas2313213', 1),
(13, 'manoj rathore', 'manoj1@manoj.com', '1234879798', 'as13213a1sd1f3', 1),
(16, 'manoj rathore', 'manoj2@manoj.com', '2234879798', 'asdfa13232', 1),
(19, 'manoj rathore', 'manoj3@manoj.com', '1234879799', 'asdf21321as', 1),
(20, 'manoj rathore', 'manoj4@manoj.com', '1234879797', 'asdfa321321', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_master`
--
ALTER TABLE `accounts_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_master`
--
ALTER TABLE `item_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts_master`
--
ALTER TABLE `accounts_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
