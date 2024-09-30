-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 10:03 AM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `usertype` enum('admin','user') NOT NULL DEFAULT 'user',
  `account_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `last_login`, `remember_token`, `created_at`, `updated_at`, `usertype`, `account_number`) VALUES
(2, 'adsa', 'test1234@gmail.com', '2024-09-22 05:30:51', '$2y$12$BjQUXmwlMBQEkig7jT98hOJpNvaEeyFcS9FQ91I3CWLXPj3SIzv1a', '2024-09-22 05:31:36', NULL, '2024-09-22 05:30:36', '2024-09-22 05:31:36', 'user', NULL),
(5, 'ofds', 'kjdkaj@gmail.com', '2024-09-22 07:23:43', '$2y$12$uAjN/KSPdKUR1l8uP0husOdVTlGEYP0Ao1ylTuMslfoax9km.pyny', '2024-09-09 07:54:24', NULL, '2024-09-22 07:23:35', '2024-09-22 07:23:43', 'user', NULL),
(6, 'admin', 'admin@gmail.com', '2024-09-22 07:24:12', '$2y$12$od58Y51q/qAq2cI6qMgvSe8aPkQvZMXiFNyqufPWQhjHD0MNLWfMS', NULL, NULL, '2024-09-22 07:24:05', '2024-09-22 07:24:12', 'admin', NULL),
(7, 'dsada', 'oi@gmail.com', '2024-09-22 09:46:18', '$2y$12$NStERlyoT5Vflic5dkKcPeH9W0I4yodpMhgXwGgfFC0VPVIcjB0uS', '2024-07-09 07:54:17', NULL, '2024-09-22 09:46:02', '2024-09-22 09:46:18', 'user', NULL),
(8, 'dsada', 'abc12345@gmail.com', '2024-09-29 23:57:36', '$2y$12$UfovjwEeNlRkIMnfEXNHPOJzp9gWzBARocgl6lr2E4/mnV7Oc4rVK', '2024-09-29 23:58:52', NULL, '2024-09-24 12:56:03', '2024-09-29 23:58:52', 'user', NULL),
(9, 'sdadsada', 'oeiwqeowi@gmail.com', NULL, '$2y$12$1KoTDh4AnMfQ2ljOelKcAOEAPl7.2iNqIHgO6KCnnd2RJjxf053KC', '2024-03-12 08:01:39', NULL, '2024-09-30 00:00:04', '2024-09-30 00:00:04', 'user', NULL),
(10, 'sadadsa', 'hi@gmail.com', '2024-09-30 00:01:11', '$2y$12$Vi8lSVeHoRCU1.bqIXD0JO16MRxk6/W4A0jdNWfT.hfdXhlyqxQi6', '2024-07-18 08:01:49', NULL, '2024-09-30 00:00:56', '2024-09-30 00:01:11', 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
