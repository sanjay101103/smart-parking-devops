-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 08:10 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slot_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `slot_number` varchar(10) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `total_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `slot_id`, `location`, `slot_number`, `booking_date`, `booking_time`, `amount`, `status`, `from_date`, `to_date`, `total_days`) VALUES
(1, 2, 1, 'Bus Stand', 'A1', '2026-02-20', '01:27:00', 50, 'Cancelled', NULL, NULL, NULL),
(2, 2, 4, 'Railway Station', 'B1', NULL, NULL, 500, 'Cancelled', '2026-02-19', '2026-02-19', 1),
(3, 3, 1, 'Bus Stand', 'A1', NULL, NULL, 500, 'Cancelled', '2026-02-19', '2026-02-19', 1),
(4, 3, 2, 'Bus Stand', 'A2', '2026-02-20', '04:22:38', 500, 'Booked', '2026-02-19', '2026-02-19', 1),
(5, 4, 4, 'Railway Station', 'B1', '2026-02-28', '03:25:25', 0, 'Booked', '2026-02-28', '2026-02-28', 1),
(6, 4, 3, 'Bus Stand', 'A3', '2026-02-28', '03:35:53', 500, 'Booked', '2026-02-28', '2026-02-28', 1),
(7, 5, 5, 'Railway Station', 'B2', '2026-02-28', '03:43:48', 500, 'Booked', '2026-02-28', '2026-02-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE `slots` (
  `id` int(11) NOT NULL,
  `slot_number` varchar(10) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `status` enum('Available','Booked') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slots`
--

INSERT INTO `slots` (`id`, `slot_number`, `location`, `latitude`, `longitude`, `status`) VALUES
(1, 'A1', 'Bus Stand', '11.3997', '79.6937', 'Available'),
(2, 'A2', 'Bus Stand', '11.3998', '79.6938', 'Booked'),
(3, 'A3', 'Bus Stand', '11.3999', '79.6939', 'Booked'),
(4, 'B1', 'Railway Station', '11.4012', '79.6954', 'Booked'),
(5, 'B2', 'Railway Station', '11.4013', '79.6955', 'Booked'),
(6, 'B3', 'Railway Station', '11.4014', '79.6956', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', '9999999999', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9tZ4aWz7GZbR9YF3K9p9y6', 'admin'),
(2, 'anu', 'anu@gmail.com', '8907654321', 'anu123', 'user'),
(3, 'ramya', 'ramya@gmail.com', '6369380733', 'ramya123', 'user'),
(4, 'abi', 'abi@gmail.com', '6369380733', 'abi123', 'user'),
(5, 'anitha', 'anitha@gmail.com', '6369380733', 'anitha123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
