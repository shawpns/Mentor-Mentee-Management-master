-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 05:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_frontdesk_users`
--

CREATE TABLE `tbl_frontdesk_users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `bdate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_frontdesk_users`
--

INSERT INTO `tbl_frontdesk_users` (`id`, `username`, `pwd`, `bdate`) VALUES
(1, 'shaw', '*1D72DAFB953E3606E84902DB8C521C98EC46266E', '2024-11-15 22:20:11'),
(2, 'mark', '*3C792B587BE4C8A08A067FED1D36302941BC7633', '2024-11-15 22:20:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_holidays`
--

CREATE TABLE `tbl_holidays` (
  `id` int(10) NOT NULL,
  `date` varchar(20) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `bdate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_holidays`
--

INSERT INTO `tbl_holidays` (`id`, `date`, `reason`, `bdate`) VALUES
(2, '2024-11-15', 'National day', '2024-11-15 22:20:11'),
(3, '2024-11-16', 'My sons borthday', '2024-11-15 22:20:11'),
(5, '2024-11-25', 'Christians celebrate', '2024-11-15 21:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservations`
--

CREATE TABLE `tbl_reservations` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `ucount` int(10) NOT NULL,
  `rdate` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `comments` varchar(250) NOT NULL,
  `bdate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_reservations`
--

INSERT INTO `tbl_reservations` (`id`, `uid`, `ucount`, `rdate`, `status`, `comments`, `bdate`) VALUES
(11, 101, 10, '2024-11-18 10:00', 'APPROVED', '', '2024-11-15 21:38:35'),
(13, 100, 100, '2024-11-21 10:00', 'PENDING', '', '2024-11-15 21:42:50'),
(14, 104, 19, '2024-11-22 10:00', 'APPROVED', '', '2024-11-15 21:53:54'),
(15, 107, 11, '2024-11-12 16:33', 'PENDING', '', '2024-11-15 21:54:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `bdate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `pwd`, `address`, `phone`, `email`, `type`, `status`, `bdate`) VALUES
(100, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'some where in india', '123456789', 'mail@mail.com', 'admin', 'active', '2024-11-20 10:00:08'),
(101, '1234456', 'e10adc3949ba59abbe56e057f20f883e', 'some where in india', '123456789', 'mail@mail.com', 'student', 'active', '2024-11-15 19:25:33'),
(104, 'science', 'fb5c7f9bb4b32ce2f3bff4662f1ab27b', '10, 2nd Cross Rd, Venkatadri Layout, Amalodbhavi Nagar, Panduranga Nagar, Bengaluru, Karnataka 560076', '987654321', 'science@mail.com', 'teacher', 'active', '2024-11-15 21:47:44'),
(105, 'student2', '213ee683360d88249109c2f92789dbc3', ' Bengaluru, Karnataka 560076', '456987123', 'demo12@mail.com', 'student', 'inactive', '2024-11-15 21:49:47'),
(106, 'student3', '8e4947690532bc44a8e41e9fb365b76a', '10, 2nd Cross Rd', '125463987', 'student3@mail.com', 'student', 'active', '2024-11-15 21:50:44'),
(107, 'teacher2', 'ccffb0bb993eeb79059b31e1611ec353', 'somewhere at INDIA', '253641789', 'teacher2@mail.com', 'teacher', 'inactive', '2024-11-15 21:51:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_frontdesk_users`
--
ALTER TABLE `tbl_frontdesk_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_holidays`
--
ALTER TABLE `tbl_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_frontdesk_users`
--
ALTER TABLE `tbl_frontdesk_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_holidays`
--
ALTER TABLE `tbl_holidays`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
