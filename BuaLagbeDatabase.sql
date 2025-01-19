-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2025 at 08:33 AM
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
-- Database: `bualagbedatabase`
--

DROP DATABASE IF EXISTS `bualagbedatabase`;
CREATE DATABASE `bualagbedatabase`;
USE `bualagbedatabase`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aemail`, `apassword`) VALUES
('admin@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment` (
  `appoid` int(11) NOT NULL,
  `clientid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `scheduleid` int(10) DEFAULT NULL,
  `appodate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `clientid` int(11) NOT NULL,
  `clientemail` varchar(255) DEFAULT NULL,
  `clientname` varchar(255) DEFAULT NULL,
  `clientpassword` varchar(255) DEFAULT NULL,
  `clientaddress` varchar(255) DEFAULT NULL,
  `clientnic` varchar(15) DEFAULT NULL,
  `clientdob` date DEFAULT NULL,
  `clienttel` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientid`, `clientemail`, `clientname`, `clientpassword`, `clientaddress`, `clientnic`, `clientdob`, `clienttel`) VALUES
(1, 'client@gmail.com', 'Test Client', '123', 'Sri Lanka', '0000000000', '2000-01-01', '0120000000'),
(2, 'emhashenudara@gmail.com', 'Hashen Udara', '123', 'Sri Lanka', '0110000000', '2022-06-03', '0700000000'),
(3, 'shahedislam6190sr@gmail.com', 'shahed islam', '123', 'shahedislam6190sr@gmail.com', '112233', '2025-01-23', '01913651083');

-- --------------------------------------------------------

--
-- Table structure for table `maid`
--

DROP TABLE IF EXISTS `maid`;
CREATE TABLE `maid` (
  `maidid` int(11) NOT NULL,
  `maidemail` varchar(255) DEFAULT NULL,
  `maidname` varchar(255) DEFAULT NULL,
  `maidpassword` varchar(255) DEFAULT NULL,
  `maidnic` varchar(15) DEFAULT NULL,
  `maidtel` varchar(15) DEFAULT NULL,
  `specialties` int(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `maid`
--

INSERT INTO `maid` (`maidid`, `maidemail`, `maidname`, `maidpassword`, `maidnic`, `maidtel`, `specialties`) VALUES
(1, 'maid@gmail.com', 'Test Maid', '123', '000000000', '0110000000', 1),
(2, 'asma@gmail.com', 'asma', '2121', '33222', '0129', 4),
(3, 'maid2@edoc.com', 'Second Maid', '123', '987654321', '0987654321', 2),
(4, 'sayma@gmail.com', 'sayma', '123', '2222', '4324', 4),
(5, 'fabiha@gmail.com', 'fabiha', '123', '123', '233', 4);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `scheduleid` int(11) NOT NULL,
  `maidid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `fees/hr` int(11) DEFAULT NULL,
  `cost/delay` decimal(10,2) DEFAULT NULL,
  `nop` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleid`, `maidid`, `title`, `scheduledate`, `scheduletime`, `fees/hr`, `cost/delay`, `nop`) VALUES
(1, '1', 'Test Session', '2050-01-01', '18:00:00', 50, 1.00, 1),
(9, '2', 'Second Maid Session', '2025-01-15', '10:00:00', 10, 1.00, 1),
(3, '1', '12', '2022-06-10', '20:33:00', 1, 1.00, 1),
(4, '1', '1', '2022-06-10', '12:32:00', 1, 1.00, 1),
(5, '1', '1', '2022-06-10', '20:35:00', 1, 1.00, 1),
(6, '1', '12', '2022-06-10', '20:35:00', 1, 1.00, 1),
(7, '1', '1', '2022-06-24', '20:36:00', 1, 1.00, 1),
(8, '1', '12', '2022-06-10', '13:33:00', 1, 1.00, 1),
(10, '2', 'Another Session', '2025-01-16', '14:00:00', 5, 1.00, 1),
(11, '4', 'sayma', '2423-03-23', '21:34:00', 23, 1.00, 1),
(12, '5', 'shh', '2000-03-23', '12:32:00', 42, 1.00, 1),
(13, '1', 'fdfs', '2431-02-24', '21:32:00', 1, 1.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

DROP TABLE IF EXISTS `specialties`;
CREATE TABLE `specialties` (
  `id` int(2) NOT NULL,
  `sname` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `sname`) VALUES
(1, 'House Cleaning'),
(2, 'Laundry'),
(3, 'Cooking'),
(4, 'Child Care'),
(5, 'Elderly Care'),
(6, 'Pet Care'),
(7, 'Gardening'),
(8, 'Grocery Shopping'),
(9, 'Ironing'),
(10, 'Window Cleaning');

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

DROP TABLE IF EXISTS `webuser`;
CREATE TABLE `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('admin@gmail.com', 'a'),
('maid@gmail.com', 'm'),
('client@gmail.com', 'c'),
('emhashenudara@gmail.com', 'c'),
('asma@gmail.com', 'm'),
('shahedislam6190sr@gmail.com', 'c'),
('sayma@gmail.com', 'm'),
('fabiha@gmail.com', 'm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aemail`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appoid`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `scheduleid` (`scheduleid`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientid`);

--
-- Indexes for table `maid`
--
ALTER TABLE `maid`
  ADD PRIMARY KEY (`maidid`),
  ADD KEY `specialties` (`specialties`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleid`),
  ADD KEY `maidid` (`maidid`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webuser`
--
ALTER TABLE `webuser`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maid`
--
ALTER TABLE `maid`
  MODIFY `maidid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;