-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2021 at 04:52 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `personal_oop_crud_lvl1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartment`
--

CREATE TABLE `tbldepartment` (
  `DepartmentID` int(11) NOT NULL,
  `DepartmentName` varchar(200) DEFAULT NULL,
  `DepartmentDetails` text,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbldepartment`
--

INSERT INTO `tbldepartment` (`DepartmentID`, `DepartmentName`, `DepartmentDetails`, `created_at`, `deleted_at`) VALUES
(1, 'Department 1', NULL, NULL, NULL),
(2, 'Department 2', NULL, NULL, NULL),
(3, 'Department 3', NULL, NULL, NULL),
(4, 'Department 4', NULL, NULL, NULL),
(5, 'Department 5', NULL, NULL, NULL),
(6, 'Department 6', NULL, NULL, NULL),
(7, 'Department 7', NULL, NULL, NULL),
(8, 'Department 8', NULL, NULL, NULL),
(9, 'Department 9', NULL, NULL, NULL),
(10, 'Department 10', NULL, NULL, NULL),
(11, 'Department 11', NULL, NULL, NULL),
(12, 'Department 12', NULL, NULL, NULL),
(13, 'Department 13', NULL, NULL, NULL),
(14, 'Department 14', NULL, NULL, NULL),
(15, 'Department 15', NULL, NULL, NULL),
(16, 'Department 16', NULL, NULL, NULL),
(17, 'Department 17', NULL, NULL, NULL),
(18, 'Department 18', NULL, NULL, NULL),
(19, 'Department 19', NULL, NULL, NULL),
(20, 'Department 20', NULL, NULL, NULL),
(21, 'Department 21', NULL, NULL, NULL),
(22, 'Department 22', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  ADD PRIMARY KEY (`DepartmentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
