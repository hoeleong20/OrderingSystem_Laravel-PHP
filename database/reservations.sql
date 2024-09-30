-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 06:26 PM
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
-- Database: `restaurant-ordering-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `pax` int(11) NOT NULL DEFAULT 1,
  `datetime` datetime NOT NULL,
  `reservation_type` enum('table','table_with_dish','dish','event') NOT NULL,
  `extra_info` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `email`, `phone`, `pax`, `datetime`, `reservation_type`, `extra_info`, `created_at`, `updated_at`) VALUES
(1, 'gg', 'gg@gmail.com', '99', 2, '2024-09-22 18:10:00', 'table', NULL, '2024-09-22 02:03:09', '2024-09-22 02:03:09'),
(2, 'bb', 'hh@gmail.com', '57', 4, '2024-09-22 19:24:00', 'table', NULL, '2024-09-22 03:24:58', '2024-09-22 03:24:58'),
(3, 'aa', 'kor@gmail.com', '34', 1, '2024-09-22 20:23:00', 'dish', 'dish1, dish2', '2024-09-22 04:23:11', '2024-09-22 04:23:11'),
(4, 'we', 'gg@gmail.com', '66', 1, '2024-09-23 10:35:00', 'dish', NULL, '2024-09-22 04:35:39', '2024-09-22 04:35:39'),
(5, 'cc', 'gg@gmail.com', '99', 3, '2024-09-22 12:02:00', 'table_with_dish', NULL, '2024-09-22 04:59:54', '2024-09-22 04:59:54'),
(6, 'cc', 'gg@gmail.com', '99', 1, '2024-10-04 12:18:00', 'event', 'Birthday Party', '2024-09-22 05:15:58', '2024-09-22 05:15:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
