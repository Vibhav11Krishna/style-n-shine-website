-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2025 at 08:37 AM
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
-- Database: `salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `email`, `mobile`, `service`, `date`, `created_at`) VALUES
(33, 'Jayant krishna', 'agr.jkrishna@gmail.com', '12456789', 'Manicure & Pedicure', '2025-12-19', '2025-12-24 15:57:53'),
(34, 'Jayant krishna', 'agr.jkrishna@gmail.com', '12456789', 'Facial', '2025-12-20', '2025-12-24 15:58:28'),
(35, 'Jayant krishna', 'agr.jkrishna@gmail.com', '12345678', 'Facial', '2025-12-27', '2025-12-24 15:59:06'),
(36, 'Jayant krishna', 'agr.jkrishna@gmail.com', '+91 7209749002', 'Bridal Makeup', '2025-12-13', '2025-12-24 15:59:28'),
(37, 'Jayant krishna', 'agr.jkrishna@gmail.com', '+91 7209749002', 'Bridal Makeup', '2025-12-13', '2025-12-24 15:59:40'),
(38, 'Jayant krishna', 'agr.jkrishna@gmail.com', '7209749002', 'Haircut & Styling', '2025-12-26', '2025-12-24 16:01:10'),
(39, 'Jayant krishna', 'agr.jkrishna@gmail.com', '7209749002', 'Haircut & Styling', '2025-12-26', '2025-12-24 16:01:33'),
(40, 'nishu sinha', 'sinha@gmail.com', '+91 9199825858', 'Hair Spa', '2025-12-26', '2025-12-24 16:01:51'),
(41, 'nishu sinha', 'sinha@gmail.com', '+91 9199825858', 'Hair Spa', '2025-12-26', '2025-12-24 16:02:09'),
(42, 'Jayant krishna', 'agr.jkrishna@gmail.com', '+91 7209749002', 'Hair Spa', '2025-12-26', '2025-12-24 16:02:27'),
(43, 'Jayant krishna', 'agr.jkrishna@gmail.com', '+91 7209749002', 'Hair Spa', '2025-12-26', '2025-12-24 16:02:56'),
(44, 'amrita singh', 'amrita@gmail.com', '12345678', 'Hair Spa', '2025-12-04', '2025-12-24 16:03:27'),
(45, 'Jayant krishna', 'agr.jkrishna@gmail.com', '+91 9199825858', 'Hair Spa', '2025-12-27', '2025-12-24 16:04:18'),
(46, 'Jayant krishna', 'agr.jkrishna@gmail.com', '+91 9199825858', 'Hair Spa', '2025-12-27', '2025-12-24 16:04:42'),
(47, 'Pulkit krishna', 'agr.jkrishna@gmail.com', '+91 9199825858', 'Haircut & Styling', '2025-12-26', '2025-12-24 16:05:18'),
(48, 'Jayant krishna', 'agr.jkrishna@gmail.com', '7209749002', 'Haircut & Styling', '2026-01-01', '2025-12-24 16:06:50'),
(49, 'Jayant krishna', 'agr.jkrishna@gmail.com', '7209749002', 'Haircut & Styling', '2026-01-01', '2025-12-24 16:07:04'),
(50, 'Jayant krishna', 'agr.jkrishna@gmail.com', '7209749002', 'Haircut & Styling', '2026-01-03', '2025-12-24 16:07:22'),
(51, 'Jayant krishna', 'agr.jkrishna@gmail.com', '12456789', 'Haircut & Styling', '2025-12-11', '2025-12-25 07:06:53'),
(53, 'Jayant krishna', 'agr.jkrishna@gmail.com', '+91 9199825858', 'Haircut & Styling', '2026-01-03', '2025-12-25 15:43:29'),
(54, 'Jayant krishna', 'agr.jkrishna@gmail.com', '+91 9199825858', 'Haircut & Styling', '2026-01-03', '2025-12-25 15:51:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
