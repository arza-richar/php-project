-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2025 at 10:28 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `healthhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `exmed_info`
--

CREATE TABLE `exmed_info` (
  `id` int(11) NOT NULL,
  `exmed_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `exmed_quantity` int(11) NOT NULL,
  `exmed_exdate` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `exmed_info`
--

INSERT INTO `exmed_info` (`id`, `exmed_name`, `exmed_quantity`, `exmed_exdate`) VALUES
(1, 'เบตาดีน (Betadine)', 30, '28/04/2568'),
(2, 'คาลาไมน์โลชั่น (Calamine Lotion)', 20, '28/04/2568');

-- --------------------------------------------------------

--
-- Table structure for table `inmed_info`
--

CREATE TABLE `inmed_info` (
  `id` int(11) NOT NULL,
  `inmed_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `inmed_quantity` int(11) NOT NULL,
  `inmed_exdate` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inmed_info`
--

INSERT INTO `inmed_info` (`id`, `inmed_name`, `inmed_quantity`, `inmed_exdate`) VALUES
(1, 'พาราเซตามอล (Paracetamol)', 50, '28/04/2568'),
(2, '(Loratadine) ยาแก้แพ้', 50, '28/04/2568'),
(3, 'ยาหม่อง', 8, '2025-04-29');

-- --------------------------------------------------------

--
-- Table structure for table `service_info`
--

CREATE TABLE `service_info` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `stuid` int(11) NOT NULL,
  `stuname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `stuclass` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `stucondition` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `treatment` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `medicine` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dose` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `service_info`
--

INSERT INTO `service_info` (`id`, `date`, `time`, `stuid`, `stuname`, `stuclass`, `stucondition`, `treatment`, `medicine`, `dose`) VALUES
(1, '2025-03-28', '00:00:16', 68001, 'นางสาวอาซาริยาห์ ภัทรเมษสิยาห์กุล', '4/1', 'ปวดหัวตัวร้อน', 'นอนพัก', 'พาราเซตามอล (Paracetamol)', 1),
(2, '2025-03-28', '18:35:43', 68002, 'นางสาวสุทธิดา ถุงแก้ว', '4/1', 'ประจำเดือน', 'รับยาตามอาการ', 'พาราเซตามอล (Paracetamol)', 1),
(3, '2025-03-29', '06:24:41', 68001, 'นางสาวอาซาริยาห์ ภัทรเมษสิยาห์กุล', '4/1', 'ปวดเอว', 'ทำแผล', '(Loratadine) ยาแก้แพ้', 1),
(4, '2025-03-29', '06:50:47', 68002, 'นางสาวสุทธิดา ถุงแก้ว', '4/1', 'คิ้วกระตุก', 'นอนพัก', 'คาลาไมน์โลชั่น (Calamine Lotion)', 1),
(5, '2025-03-29', '06:53:56', 68003, 'นางสาววิภาดา สมพร', '4/1', 'ปวดท้องผูก', 'ทำแผล', '(Loratadine) ยาแก้แพ้', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stu_info`
--

CREATE TABLE `stu_info` (
  `id` int(11) NOT NULL,
  `stu_id` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `stu_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `stu_class` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stu_info`
--

INSERT INTO `stu_info` (`id`, `stu_id`, `stu_name`, `stu_class`) VALUES
(1, '68001', 'นางสาวอาซาริยาห์ ภัทรเมษสิยาห์กุล', '4/2'),
(4, '68002', 'นางสาวสุทธิดา ถุงแก้ว', '4/1'),
(5, '68003', 'นางสาววิภาดา สมพร', '4/1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exmed_info`
--
ALTER TABLE `exmed_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inmed_info`
--
ALTER TABLE `inmed_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_info`
--
ALTER TABLE `service_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stu_info`
--
ALTER TABLE `stu_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exmed_info`
--
ALTER TABLE `exmed_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inmed_info`
--
ALTER TABLE `inmed_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_info`
--
ALTER TABLE `service_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stu_info`
--
ALTER TABLE `stu_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
