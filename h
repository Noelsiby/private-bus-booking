-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 09, 2024 at 10:15 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vs code`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$yourHashedPasswordHere', '2024-11-03 09:21:39');

-- --------------------------------------------------------

--
-- Table structure for table `booked_seats`
--

DROP TABLE IF EXISTS `booked_seats`;
CREATE TABLE IF NOT EXISTS `booked_seats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bus_id` int NOT NULL,
  `seat_number` varchar(5) NOT NULL,
  `booking_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `booked_by` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bus_id` (`bus_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booked_seats`
--

INSERT INTO `booked_seats` (`id`, `bus_id`, `seat_number`, `booking_time`, `booked_by`) VALUES
(12, 5, '23', '2024-12-04 16:16:57', ''),
(11, 5, '12', '2024-12-04 15:57:04', ''),
(4, 24, '11', '2024-12-03 17:46:21', ''),
(5, 24, '12', '2024-12-03 17:57:46', ''),
(6, 24, '13', '2024-12-03 17:57:59', ''),
(7, 5, '7', '2024-12-03 17:58:45', ''),
(8, 5, '13', '2024-12-04 15:32:24', ''),
(9, 5, '17', '2024-12-04 15:32:32', ''),
(10, 5, '14', '2024-12-04 15:41:17', ''),
(13, 5, '18', '2024-12-04 16:16:57', ''),
(14, 5, '28', '2024-12-04 16:22:21', ''),
(15, 5, '1', '2024-12-04 16:24:53', ''),
(16, 5, '6', '2024-12-04 16:24:53', ''),
(17, 33, '13', '2024-12-04 16:28:49', ''),
(18, 33, '12', '2024-12-04 16:29:07', ''),
(19, 8, '13', '2024-12-04 16:35:34', ''),
(20, 8, '8', '2024-12-04 16:35:34', ''),
(21, 8, '18', '2024-12-04 16:35:43', ''),
(22, 8, '1', '2024-12-04 16:41:05', ''),
(23, 8, '2', '2024-12-04 16:43:59', ''),
(24, 8, '14', '2024-12-04 16:47:56', ''),
(25, 48, '16', '2024-12-04 16:51:35', ''),
(26, 48, '21', '2024-12-04 16:51:35', '');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

DROP TABLE IF EXISTS `buses`;
CREATE TABLE IF NOT EXISTS `buses` (
  `bus_id` int NOT NULL AUTO_INCREMENT,
  `bus_name` varchar(100) NOT NULL,
  `from_location` varchar(100) NOT NULL,
  `to_location` varchar(100) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `fare` decimal(10,2) NOT NULL,
  `seats_available` int NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `duration` time DEFAULT NULL,
  PRIMARY KEY (`bus_id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`bus_id`, `bus_name`, `from_location`, `to_location`, `departure_time`, `arrival_time`, `fare`, `seats_available`, `rating`, `duration`) VALUES
(42, 'Mizo travels ', 'kottayam', 'palakkad ', '11:00:00', '04:01:00', 200.00, 20, NULL, NULL),
(2, 'Cityliner', 'Thiruvananthapuram', 'Kollam', '07:00:00', '09:00:00', 150.00, 20, 4.00, '02:00:00'),
(3, 'FastTrack', 'Ernakulam', 'Palakkad', '08:00:00', '11:00:00', 300.00, 25, 4.30, '03:00:00'),
(4, 'Kochi Kings', 'Kochi', 'Kottayam', '06:30:00', '09:00:00', 200.00, 35, 4.10, '02:30:00'),
(5, 'Royal Ride', 'Malappuram', 'Thrissur', '10:00:00', '11:30:00', 250.00, 15, 4.40, '01:30:00'),
(6, 'Express Line', 'Kannur', 'Kozhikode', '05:45:00', '07:00:00', 180.00, 40, 4.20, '01:15:00'),
(7, 'Sree Travels', 'Palakkad', 'Kottayam', '07:15:00', '09:30:00', 220.00, 22, 4.60, '02:15:00'),
(8, 'Green Travels', 'Kozhikode', 'Thrissur', '09:30:00', '13:00:00', 450.00, 18, 4.00, '03:30:00'),
(9, 'South Star', 'Thiruvananthapuram', 'Kochi', '11:00:00', '15:00:00', 400.00, 10, 4.50, '04:00:00'),
(10, 'Jet Set', 'Kottayam', 'Malappuram', '08:15:00', '11:00:00', 300.00, 20, 4.10, '02:45:00'),
(11, 'Highway Express', 'Kozhikode', 'Palakkad', '09:00:00', '13:00:00', 350.00, 15, 4.30, '04:00:00'),
(12, 'Kerala Express', 'Kollam', 'Kottayam', '06:45:00', '08:30:00', 120.00, 28, 4.00, '01:45:00'),
(13, 'Horizon Buses', 'Ernakulam', 'Kannur', '10:30:00', '15:30:00', 500.00, 12, 4.20, '05:00:00'),
(14, 'Coastal Ride', 'Kochi', 'Kozhikode', '05:30:00', '07:30:00', 180.00, 45, 4.40, '02:00:00'),
(15, 'Palace on Wheels', 'Palakkad', 'Kollam', '08:30:00', '11:00:00', 275.00, 25, 4.10, '02:30:00'),
(16, 'Royal Kerala', 'Kottayam', 'Malappuram', '07:00:00', '10:00:00', 320.00, 18, 4.30, '03:00:00'),
(17, 'Serene Travels', 'Kozhikode', 'Thiruvananthapuram', '10:15:00', '13:30:00', 450.00, 30, 4.00, '03:15:00'),
(18, 'Sahyadri Travels', 'Kannur', 'Kollam', '06:00:00', '10:00:00', 300.00, 22, 4.50, '04:00:00'),
(19, 'Himalaya Express', 'Thrissur', 'Kottayam', '09:45:00', '12:00:00', 240.00, 40, 4.40, '02:15:00'),
(20, 'Starline Buses', 'Ernakulam', 'Kannur', '10:00:00', '13:30:00', 260.00, 15, 4.20, '03:30:00'),
(21, 'Expressway', 'Kollam', 'Kozhikode', '07:15:00', '09:00:00', 220.00, 35, 4.10, '01:45:00'),
(22, 'Sky High Travels', 'Kochi', 'Malappuram', '08:00:00', '11:00:00', 300.00, 20, 4.00, '03:00:00'),
(23, 'Golden Route', 'Palakkad', 'Kollam', '11:30:00', '13:00:00', 190.00, 30, 4.60, '01:30:00'),
(24, 'Coconut Travels', 'Kozhikode', 'Kottayam', '06:00:00', '08:30:00', 150.00, 50, 4.40, '02:30:00'),
(25, 'Traveler’s Choice', 'Kollam', 'Thrissur', '10:45:00', '12:00:00', 280.00, 18, 4.30, '01:15:00'),
(26, 'Voyager Buses', 'Thiruvananthapuram', 'Kochi', '09:15:00', '13:00:00', 400.00, 12, 4.20, '03:45:00'),
(27, 'East Coast Buses', 'Ernakulam', 'Palakkad', '08:30:00', '11:30:00', 250.00, 25, 4.10, '03:00:00'),
(28, 'Metro Express', 'Kozhikode', 'Kannur', '07:00:00', '09:00:00', 180.00, 30, 4.00, '02:00:00'),
(29, 'Sundaram Travels', 'Kollam', 'Malappuram', '10:30:00', '13:45:00', 360.00, 20, 4.30, '03:15:00'),
(30, 'Royal Voyage', 'Thiruvananthapuram', 'Kottayam', '05:45:00', '09:15:00', 290.00, 22, 4.60, '03:30:00'),
(31, 'Super Fast Bus', 'Palakkad', 'Thrissur', '11:00:00', '12:45:00', 250.00, 35, 4.40, '01:45:00'),
(32, 'Express Connect', 'Kozhikode', 'Kollam', '09:30:00', '12:00:00', 200.00, 28, 4.20, '02:30:00'),
(33, 'Breeze Travels', 'Kottayam', 'Kannur', '06:30:00', '09:30:00', 230.00, 18, 4.10, '03:00:00'),
(34, 'Kerala Ride', 'Kollam', 'Malappuram', '07:15:00', '09:30:00', 180.00, 50, 4.50, '02:15:00'),
(35, 'Sunrise Buses', 'Kochi', 'Kozhikode', '10:15:00', '11:45:00', 320.00, 15, 4.40, '01:30:00'),
(36, 'Dreamliner', 'Thiruvananthapuram', 'Palakkad', '08:00:00', '11:15:00', 250.00, 22, 4.10, '03:15:00'),
(37, 'Pine Valley Buses', 'Kollam', 'Kottayam', '09:30:00', '12:00:00', 200.00, 20, 4.20, '02:30:00'),
(38, 'Platinum Travel', 'Kozhikode', 'Kannur', '06:00:00', '07:45:00', 160.00, 35, 4.50, '01:45:00'),
(39, 'Starry Night', 'Kochi', 'Thrissur', '11:30:00', '13:45:00', 320.00, 15, 4.00, '02:15:00'),
(40, 'Ocean Express', 'Palakkad', 'Kozhikode', '07:45:00', '10:45:00', 280.00, 20, 4.30, '03:00:00'),
(41, 'Evergreen Travels', 'Kollam', 'Thiruvananthapuram', '10:00:00', '12:30:00', 290.00, 30, 4.40, '02:30:00'),
(43, 'torrer', 'Thiruvananthapuram', 'palakkad ', '03:09:00', '23:13:00', 71.00, 20, NULL, NULL),
(44, 'bbu', 'kozhikode', 'kollam', '23:52:00', '03:48:00', 850.00, 20, NULL, NULL),
(45, 'christmas', 'Palakkad', 'Kannur', '04:51:00', '03:51:00', 456.00, 25, NULL, NULL),
(46, 'Leon', 'Kottayam', 'Kozhikode', '18:20:00', '05:20:00', 250.00, 22, NULL, NULL),
(47, 'ronk', 'Thiruvananthapuram', 'Ernakulam', '21:03:00', '16:08:00', 220.00, 10, NULL, NULL),
(48, 'Prabu', 'Thiruvananthapuram', 'Ernakulam', '22:24:00', '02:23:00', 220.00, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `location_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location_name` (`location_name`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_name`) VALUES
(1, 'Thiruvananthapuram'),
(2, 'Kollam'),
(3, 'Kottayam'),
(4, 'Ernakulam'),
(5, 'Thrissur'),
(6, 'Palakkad'),
(7, 'Malappuram'),
(8, 'Kozhikode'),
(9, 'Kannur');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE IF NOT EXISTS `routes` (
  `route_id` int NOT NULL AUTO_INCREMENT,
  `from_location` varchar(255) NOT NULL,
  `to_location` varchar(255) NOT NULL,
  PRIMARY KEY (`route_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`route_id`, `from_location`, `to_location`) VALUES
(1, 'kerala', 'tamilnadu'),
(2, 'kerala', 'tamilnadu');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `ticket_id` int NOT NULL AUTO_INCREMENT,
  `departure_time` varchar(100) DEFAULT NULL,
  `arrival_time` varchar(100) DEFAULT NULL,
  `bus_name` varchar(100) DEFAULT NULL,
  `from` varchar(100) DEFAULT NULL,
  `to` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `seats` varchar(50) DEFAULT NULL,
  `ticket` varchar(50) DEFAULT NULL,
  `pnr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `departure_time`, `arrival_time`, `bus_name`, `from`, `to`, `name`, `age`, `gender`, `seats`, `ticket`, `pnr`) VALUES
(1, '07:15:00', '09:30:00', 'Sree Travels', 'Palakkad', 'Kottayam', 'rohit', 44, '0', '1', 'TTB393952309', '107732425408102_7827206-423012'),
(4, '10:30:00', '15:30:00', 'Horizon Buses', 'Ernakulam', 'Kannur', 'nnnnp', 5, '0', '1', 'TTB393952309', '107732425408102_7827206-423012'),
(3, '07:00:00', '10:00:00', 'Royal Kerala', 'Kottayam', 'Malappuram', 'nnnnp', 5, '0', '7', 'TTB393952309', '107732425408102_7827206-423012'),
(5, '18:20:00', '05:20:00', 'Leon', 'Kottayam', 'Kozhikode', 'leon', 52, '0', '13', 'TTB393952309', '107732425408102_7827206-423012'),
(6, 'Not Available', 'Not Available', 'Leon', 'Not Available', 'Not Available', 'leon', 52, '0', '11', 'TTB393952309', '107732425408102_7827206-423012'),
(7, '10:00:00', '11:30:00', 'Royal Ride', 'Malappuram', 'Thrissur', 'pavithran', 44, 'male', '17', 'TTB393952309', '107732425408102_7827206-423012'),
(8, '10:00:00', '11:30:00', 'Royal Ride', 'Malappuram', 'Thrissur', 'pavithran', 44, 'male', '17', 'TTB393952309', '107732425408102_7827206-423012'),
(9, '09:30:00', '13:00:00', 'Green Travels', 'Kozhikode', 'Thrissur', 'monuu', 55, 'male', '2', 'TTB393952309', '107732425408102_7827206-423012'),
(10, '09:30:00', '13:00:00', 'Green Travels', 'Kozhikode', 'Thrissur', 'monuu', 55, 'female', '14', 'TTB393952309', '107732425408102_7827206-423012'),
(11, '22:24:00', '02:23:00', 'prabu', 'Thiruvananthapuram', 'Ernakulam', 'prabu', 45, 'male', '16,21', 'TTB393952309', '107732425408102_7827206-423012');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `phoneno` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phoneno` (`phoneno`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `phoneno`, `password`) VALUES
(1, 'admin', '09061257782', '$2y$10$eYhXzMmvIJPHLuK7GIUrJe9f61K1gOf.eTLGzz3yQTPr2B/GhbFXe'),
(2, 'noel', '92', '$2y$10$msNiJ.NDfF6Pu1EJr.pLBuuEBGGnbOqBdvba0l8/tlx3a.qZ.rVEW'),
(3, 'Noel', '90', '$2y$10$ZpzC1WoBwixyrE898gHWJOTDTE5yzCk.1vw1ZTllRGfV8Q9Pq9zoi'),
(15, 'roono', '2222', '$2y$10$lzZ9GjIiIQ0dKU8v8MOm8.PioavCFFIymxPtQEZGDsoaOUDgfZKja'),
(5, 'Noel', '33', '$2y$10$hKQzyUfQBOLSOgPlvD1rZObbMm7cRR/PxM3y8pYouZpWdwTWHqflm'),
(6, 'Noel', '66', '$2y$10$nrF9sZV6POV7pXhfzFzMVe0Ydq2IE7iDacqOIEZDx8WtiiZ.EPDw6'),
(7, 'Noel', '88', '$2y$10$U4jn/6eUaSDlozkqtN27LOomLtXqFfUzIfPMw3ElfVXEXd21OVNEy'),
(8, 'Noel', '886', '$2y$10$ra3XF27BziSz8crusug.lepDx6bz6dFVkQ8sGDYKLbX3oXjYaCF/K'),
(9, 'abin', '77', '$2y$10$LS5Ic4Z1MjV2GFThzt6jTec4CUqgbh19poxHgF4w2qxZsIjNB52Zy'),
(10, 'Noel', '55', '$2y$10$fUx0HraYzihHOENhUfYlLeNlU8uKRcG0IfsQQkTNTh.BFrYupuFJy'),
(11, 'Noel', '22', '$2y$10$Ead6IElsGJDjV3Kunil9O.w/JSGE1Jyd4qLuw7S444zjw.dRp.BMa'),
(12, 'Noel', '5', '$2y$10$O6LXVrxLjbuOVEMN6BT2/u6YZ.8Hgd256vlU.WHga1dv7D.c8VhsK'),
(13, 'rohit', '44', '$2y$10$yXY4IKO/8kTkDG6lzYhhpuKa.kbNgEbJ2J4BlTqDewP4DYGGQBQre'),
(14, 'rohit', '444', '$2y$10$Sz0oGPXrXGvEgiAd66XcD.ktTlSvLzEKm/2NJG4ox/AoSPKXEIciK'),
(16, 'peter', '8888', '$2y$10$FE/jtFaAWJcAfBYv4JOpG.eDMzLHbMRWAgPmb2LfDEI74V7Sf8YYu'),
(17, 'rohit', '666', '$2y$10$nxcXptOcYx7RLpmiAev3Sehtyx4RvKoR2w8PSSWNHT4zfG0R7C0aa'),
(18, 'ex', '7777', '$2y$10$7g0FVtEsF1tLXf7bUaCb0.0X6PJGlyucyFwVTPwlrHX0onMlzQVG2');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
