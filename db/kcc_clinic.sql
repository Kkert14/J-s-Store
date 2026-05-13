-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2026 at 08:34 PM
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
-- Database: `kcc_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `user_id`, `appointment_date`, `status`, `notes`, `created_at`) VALUES
(8, 3, 17, '2026-05-15 13:13:00', 'pending', '', '2026-05-13 13:13:50'),
(9, 3, 18, '2026-05-17 13:14:00', 'confirmed', '', '2026-05-13 13:14:04'),
(10, 3, 17, '2026-05-17 00:28:35', 'pending', 'Scheduled on: May 14, 2026', '2026-05-14 00:28:35');

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(100) DEFAULT NULL,
  `quantity` int(255) DEFAULT NULL,
  `item_status` varchar(100) DEFAULT NULL,
  `date_acquired` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`equipment_id`, `equipment_name`, `quantity`, `item_status`, `date_acquired`) VALUES
(5, 'Folding Bed', 2, 'Good', '2026-04-27'),
(7, 'Blood Pressure Monitor', 3, 'Good', '2026-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempt_time` datetime NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `email`, `ip_address`, `attempt_time`, `user_agent`, `user_id`) VALUES
(36, 'glennazuelo1@gmail.com', '::142432432', '2025-04-15 13:15:00', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_consulted` datetime DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `chief_complaint` text DEFAULT NULL,
  `treatment` text DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`record_id`, `patient_id`, `user_id`, `date_consulted`, `diagnosis`, `chief_complaint`, `treatment`, `remarks`) VALUES
(13, 10, 18, '2026-05-13 13:14:00', 'Hyperventilate', 'Headache', 'Sweets', NULL),
(14, 12, 22, '2026-05-23 13:39:00', 'Hyperventilate', 'Headache', 'Rest', NULL),
(16, 20, 17, '2026-05-14 02:14:00', 'Hyperventilate', 'Headache', 'Sweets and rest', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(100) DEFAULT NULL,
  `quantity` int(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `date_received` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_id`, `medicine_name`, `quantity`, `expiry_date`, `date_received`) VALUES
(10, 'Biogesic', 14, '2027-05-13', '2026-05-13'),
(11, 'Flanax', 8, '2027-05-13', '2026-05-13'),
(12, 'Bioflu', 7, '2027-05-13', '2026-05-13'),
(13, 'Paracetamol', 49, '2028-05-14', '2026-05-14'),
(14, 'Amoxicillin', 30, '2027-11-14', '2026-05-14'),
(15, 'Ibuprofen', 40, '2027-05-14', '2026-05-14'),
(16, 'Cetirizine', 15, '2028-05-14', '2026-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_id` int(11) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`parent_id`, `last_name`, `name`, `middle_name`, `contact`, `address`) VALUES
(5, 'Villahermosa', 'Robert', 'T', '09707522792', 'Coloso Street'),
(6, 'Roquero', 'Lyn', '', '09303522792', 'Manalad'),
(7, 'Bendoy', 'Jema', 'Go', '09303522792', 'ilog'),
(8, 'Rendon', 'Maria', 'Ortega', '0953025960', 'Hilamonan'),
(9, 'Santos', 'Divino', 'Garcia', '', 'Coloso Street'),
(10, 'Bautista', 'Juan Miguel', 'Flores', '09391234567', 'Brgy. 5, Bacolod City, Negros Occidental'),
(11, 'Villahermosa', 'Bebeng', 'Mendoza', '0977395610', 'San Ramon');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `sex` varchar(14) DEFAULT 'male',
  `age` int(120) NOT NULL,
  `birthdate` date NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `department` varchar(50) DEFAULT 'Elementary'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `last_name`, `name`, `middle_name`, `sex`, `age`, `birthdate`, `contact`, `department`) VALUES
(10, 'Velasco', 'Delmar Emman', 'Bendoy', 'Male', 21, '2005-12-06', '09303522792', 'College'),
(12, 'Villahermosa', 'kol', 'Ortega', 'Female', 23, '2026-05-26', '09202056776', 'College'),
(13, 'lobaton', 'EJ', 'rey', 'Male', 26, '2026-05-27', '098210', 'College'),
(14, 'REYES', 'MARIA CLARA', 'SANTOS', 'Female', 20, '2005-03-14', '09171234567', 'College'),
(16, 'Sabanal', 'Mark Owen', 'Casio', 'Male', 22, '2003-06-15', '09561234567', 'College'),
(17, 'DELA CRUZ', 'ANA MARIE', 'S', 'Female', 19, '2006-11-22', '09123456789', 'HIGH SCHOOL'),
(18, 'Villahermosa', 'Rafa Lane', 'Mendoza', 'Female', 15, '2009-08-08', '097075227920', 'Highschool'),
(19, 'Villahermosa', 'Lara Jane', 'Mendoza', 'Female', 18, '2008-08-08', '09202056776', 'Senior'),
(20, 'Villahermosa', 'Kert', 'Garcia', 'Male', 22, '2004-08-14', '09303522792', 'College'),
(21, 'lobaton', 'kol', 'rey', 'Male', 22, '2004-07-14', '09303522792', 'College'),
(22, 'Villahermosa', 'Miles', 'Garcia', 'Female', 20, '2006-08-08', '09707522792', 'College');

-- --------------------------------------------------------

--
-- Table structure for table `patient_parents`
--

CREATE TABLE `patient_parents` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `relationship` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_parents`
--

INSERT INTO `patient_parents` (`id`, `patient_id`, `parent_id`, `relationship`) VALUES
(1, 14, 8, 'Mother'),
(3, 12, 4, 'Other'),
(8, 15, 6, 'Mother'),
(10, 16, 7, 'Sibling'),
(11, 22, 5, 'Father'),
(12, 20, 5, 'Father');

-- --------------------------------------------------------

--
-- Table structure for table `record_medicines`
--

CREATE TABLE `record_medicines` (
  `id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity_given` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record_medicines`
--

INSERT INTO `record_medicines` (`id`, `record_id`, `medicine_id`, `quantity_given`) VALUES
(0, 13, 16, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `LOGID` int(11) NOT NULL,
  `USERID` int(11) DEFAULT NULL,
  `ACTION` text DEFAULT NULL,
  `DATELOG` varchar(30) DEFAULT NULL,
  `TIMELOG` varchar(30) DEFAULT NULL,
  `user_ip_address` text DEFAULT NULL,
  `device_used` text DEFAULT NULL,
  `USER_NAME` varchar(100) DEFAULT NULL,
  `identifier` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_logs`
--

INSERT INTO `tbl_logs` (`LOGID`, `USERID`, `ACTION`, `DATELOG`, `TIMELOG`, `user_ip_address`, `device_used`, `USER_NAME`, `identifier`) VALUES
(1, 12, 'Login: Kert', '2026-05-12', '00:24:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(101, 12, 'Logout', '2026-04-17', '02:59:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(102, 12, 'Login: Kert', '2026-04-17', '02:59:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(103, 12, 'New User has been added: Admin', '2026-04-17', '03:00:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(104, 12, 'Logout', '2026-04-17', '03:00:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(105, 13, 'Login: Admin', '2026-04-17', '03:00:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGIN'),
(106, 13, 'Logout', '2026-04-17', '03:32:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGOUT'),
(107, 12, 'Login: Kert', '2026-04-17', '03:32:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(108, 12, 'Logout', '2026-04-17', '03:38:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(109, 12, 'Login: Kert', '2026-04-17', '03:41:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(110, 12, 'Logout', '2026-04-17', '04:11:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(111, 12, 'Login: Kert', '2026-04-17', '04:12:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(112, 12, 'Logout', '2026-04-17', '04:12:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(113, 12, 'Login: Kert', '2026-04-17', '04:13:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(114, 12, 'Logout', '2026-04-17', '04:14:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(115, 12, 'Login: Kert', '2026-04-17', '04:14:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(116, 12, 'Logout', '2026-04-17', '04:15:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(117, 13, 'Login: Admin', '2026-04-17', '04:15:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGIN'),
(118, 13, 'Logout', '2026-04-17', '04:16:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGOUT'),
(119, 13, 'Login: Admin', '2026-04-17', '04:16:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGIN'),
(120, 13, 'Logout', '2026-04-17', '04:18:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGOUT'),
(121, 12, 'Login: Kert', '2026-04-17', '04:18:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(122, 12, 'Logout', '2026-04-17', '04:33:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(123, 12, 'Login: Kert', '2026-04-17', '07:46:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(124, 12, 'Logout', '2026-04-17', '07:50:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(125, 12, 'Login: Kert', '2026-04-17', '13:33:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(126, 12, 'Logout', '2026-04-17', '13:34:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(127, 12, 'Login: Kert', '2026-04-17', '13:42:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(128, 12, 'New Record has been added: Mark', '2026-04-17', '13:44:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(129, 12, 'New Medicine has been added: Biogesic', '2026-04-17', '13:45:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(130, NULL, 'Logout', '2026-04-17', '18:19:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, 'LOGOUT'),
(131, 12, 'Login: Kert', '2026-04-17', '18:20:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(132, 12, 'New Medicine has been added: Biogesic', '2026-04-17', '18:21:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(133, 12, 'New Equipment has been added: Folding Bed', '2026-04-17', '18:31:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(134, 12, 'Logout', '2026-04-17', '18:32:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(135, 12, 'Login: Kert', '2026-04-17', '18:32:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(136, 12, 'Logout', '2026-04-17', '18:39:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(137, 12, 'Login: Kert', '2026-04-17', '18:42:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(138, 12, 'Logout', '2026-04-17', '18:43:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(139, 12, 'Login: Kert', '2026-04-18', '21:41:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(140, 12, 'Login: Kert', '2026-04-19', '12:24:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(141, 12, 'Logout', '2026-04-19', '12:24:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(142, 12, 'Login: Kert', '2026-04-19', '21:39:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(143, 12, 'Login: Kert', '2026-04-19', '23:10:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(144, 12, 'Logout', '2026-04-19', '23:13:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(145, 12, 'Login: Kert', '2026-04-19', '23:14:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(146, 12, 'Logout', '2026-04-19', '23:14:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(147, 12, 'Login: Kert', '2026-04-19', '23:14:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(148, 12, 'Logout', '2026-04-19', '23:15:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(149, 12, 'Login: Kert', '2026-04-19', '23:16:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(150, 12, 'Logout', '2026-04-19', '23:22:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(151, 12, 'Login: Kert', '2026-04-19', '23:28:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(152, 12, 'Logout', '2026-04-19', '23:29:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(153, 12, 'Login: Kert', '2026-04-20', '23:54:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(154, 12, 'New Record has been added: Mark Owen', '2026-04-20', '23:54:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(155, 12, 'Delete Record', '2026-04-20', '23:54:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETED'),
(156, 12, 'New Record has been added: Kert', '2026-04-21', '00:29:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(157, 12, 'Logout', '2026-04-21', '00:31:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(158, 12, 'Login: Kert', '2026-04-21', '02:28:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(159, 12, 'Logout', '2026-04-21', '02:45:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(160, 12, 'Login: Kert', '2026-04-21', '02:56:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(161, 12, 'Logout', '2026-04-21', '02:56:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(162, 12, 'Login: Kert', '2026-04-21', '03:02:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(163, 13, 'Login: Admin', '2026-04-21', '03:03:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGIN'),
(164, 13, 'Logout', '2026-04-21', '03:03:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGOUT'),
(165, 13, 'Login: Admin', '2026-04-21', '03:04:57', '::1', 'Mozilla/5.0 (Linux; Android 9; ASUS_I001DA Build/PKQ1.190414.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/131.0.6778.260 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/557.0.0.53.76;]', 'Admin', 'LOGIN'),
(166, 13, 'Logout', '2026-04-21', '03:05:05', '::1', 'Mozilla/5.0 (Linux; Android 9; ASUS_I001DA Build/PKQ1.190414.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/131.0.6778.260 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/557.0.0.53.76;]', 'Admin', 'LOGOUT'),
(167, 13, 'Login: Admin', '2026-04-21', '03:05:14', '::1', 'Mozilla/5.0 (Linux; Android 9; ASUS_I001DA Build/PKQ1.190414.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/131.0.6778.260 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/557.0.0.53.76;]', 'Admin', 'LOGIN'),
(168, 13, 'Login: Admin', '2026-04-21', '03:05:49', '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Admin', 'LOGIN'),
(169, 13, 'New Equipment has been added: Thermometer ', '2026-04-21', '03:06:23', '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Admin', 'ADD'),
(170, 13, 'Logout', '2026-04-21', '03:06:41', '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'Admin', 'LOGOUT'),
(171, 12, 'Logout', '2026-04-21', '03:06:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(172, 12, 'Login: Kert', '2026-04-21', '03:23:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(173, 12, 'New User has been added: Divino', '2026-04-21', '03:24:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(174, NULL, 'Login: Divino', '2026-04-21', '03:25:36', '::1', 'Mozilla/5.0 (Linux; Android 14; 2310FPCA4G Build/UP1A.231005.007; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/147.0.7727.55 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/557.0.0.53.76;]', 'Divino', 'LOGIN'),
(175, 12, 'Login: Kert', '2026-04-21', '03:25:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(176, 12, 'Logout', '2026-04-21', '03:25:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(177, 13, 'Logout', '2026-04-21', '03:26:13', '::1', 'Mozilla/5.0 (Linux; Android 9; ASUS_I001DA Build/PKQ1.190414.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/131.0.6778.260 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/557.0.0.53.76;]', 'Admin', 'LOGOUT'),
(178, 12, 'Logout', '2026-04-21', '03:28:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(179, 12, 'Login: Kert', '2026-04-21', '06:04:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(180, 12, 'New User has been added: Jorem Tabungcay', '2026-04-21', '06:05:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(181, NULL, 'Login: Jorem Tabungcay', '2026-04-21', '06:09:33', '::1', 'Mozilla/5.0 (Linux; Android 14; Infinix X6882 Build/UP1A.231005.007; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/146.0.7680.177 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/557.0.0.53.76;]', 'Jorem Tabungcay', 'LOGIN'),
(182, 12, 'Login: Kert', '2026-04-21', '10:33:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(183, 12, 'New User has been added: Kaye', '2026-04-21', '10:33:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(184, 12, 'Logout', '2026-04-21', '10:34:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(185, NULL, 'Login: Kaye', '2026-04-21', '10:34:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kaye', 'LOGIN'),
(186, NULL, 'Logout', '2026-04-21', '10:34:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kaye', 'LOGOUT'),
(187, NULL, 'Login: Kaye', '2026-04-21', '10:44:40', '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'Kaye', 'LOGIN'),
(188, NULL, 'Login: Kaye', '2026-04-21', '23:55:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Kaye', 'LOGIN'),
(189, NULL, 'New Record has been added: Kaye Ranier', '2026-04-21', '23:57:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Kaye', 'ADD'),
(190, 12, 'Login: Kert', '2026-04-22', '13:41:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(191, 12, 'Logout', '2026-04-22', '13:43:23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(192, 12, 'Login: Kert', '2026-04-22', '14:23:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(193, 12, 'Logout', '2026-04-22', '14:55:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(194, 13, 'Login: Admin', '2026-04-22', '14:56:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGIN'),
(195, 13, 'Login: Admin', '2026-04-22', '14:56:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGIN'),
(196, 13, 'Logout', '2026-04-22', '15:00:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGOUT'),
(197, 13, 'Login: Admin', '2026-04-22', '15:01:27', '::1', 'Mozilla/5.0 (Linux; Android 15; Infinix X6852 Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/147.0.7727.55 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/557.0.0.53.76;]', 'Admin', 'LOGIN'),
(198, 12, 'Login: Kert', '2026-04-22', '15:02:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(199, 13, 'New Medicine has been added: Adrian', '2026-04-22', '15:03:06', '::1', 'Mozilla/5.0 (Linux; Android 15; Infinix X6852 Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/147.0.7727.55 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/557.0.0.53.76;]', 'Admin', 'ADD'),
(200, 12, 'Logout', '2026-04-22', '15:03:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(201, 12, 'Login: Kert', '2026-04-26', '23:09:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(202, 12, 'Delete user', '2026-04-26', '23:29:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETED'),
(203, 12, 'Delete user', '2026-04-26', '23:32:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETED'),
(204, 12, 'Delete user', '2026-04-26', '23:32:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETED'),
(205, 12, 'Logout', '2026-04-26', '23:49:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(206, 12, 'Login: Kert', '2026-04-26', '23:49:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(207, 12, 'Logout', '2026-04-26', '23:56:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(208, 12, 'Login: Kert', '2026-04-26', '23:57:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(209, 12, 'New User has been added: Mark Owen', '2026-04-27', '00:07:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(210, 12, 'Logout', '2026-04-27', '00:07:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(211, 17, 'Login: Mark Owen', '2026-04-27', '00:07:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(212, 17, 'Logout', '2026-04-27', '00:09:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(213, 12, 'Login: Kert', '2026-04-27', '00:09:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(214, 12, 'Logout', '2026-04-27', '00:10:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(215, 17, 'Login: Mark Owen', '2026-04-27', '00:10:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(216, 17, 'Logout', '2026-04-27', '00:11:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(217, 17, 'Login: Mark Owen', '2026-04-27', '00:11:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(218, 17, 'Logout', '2026-04-27', '00:14:58', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(219, 12, 'Login: Kert', '2026-04-27', '00:15:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(220, 12, 'Logout', '2026-04-27', '00:15:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(221, 17, 'Login: Mark Owen', '2026-04-27', '00:15:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(222, 17, 'Logout', '2026-04-27', '00:22:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(223, 17, 'Login: Mark Owen', '2026-04-27', '00:22:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(224, 17, 'Login: Mark Owen', '2026-04-27', '00:24:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(225, 17, 'Logout', '2026-04-27', '00:26:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(226, 17, 'Login: Mark Owen', '2026-04-27', '00:26:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(227, 17, 'Logout', '2026-04-27', '00:27:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(228, 12, 'Login: Kert', '2026-04-27', '00:28:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(229, 12, 'Logout', '2026-04-27', '00:28:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(230, 17, 'Login: Mark Owen', '2026-04-27', '00:28:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(231, 17, 'Logout', '2026-04-27', '00:29:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(232, 17, 'Login: Mark Owen', '2026-04-27', '00:29:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(233, 17, 'Logout', '2026-04-27', '00:37:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(234, 12, 'Login: Kert', '2026-04-27', '00:37:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(235, 12, 'New User has been apdated: Kert', '2026-04-27', '00:37:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(236, 12, 'New User has been added: Divino', '2026-04-27', '00:38:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(237, 12, 'Logout', '2026-04-27', '00:38:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(238, 18, 'Login: Divino', '2026-04-27', '00:38:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(239, 18, 'Logout', '2026-04-27', '00:39:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(240, 17, 'Login: Mark Owen', '2026-04-27', '00:39:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(241, 17, 'Logout', '2026-04-27', '00:40:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(242, 12, 'Login: Kert', '2026-04-27', '00:40:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(243, 12, 'Logout', '2026-04-27', '00:41:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(244, 17, 'Login: Mark Owen', '2026-04-27', '00:41:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(245, 17, 'Logout', '2026-04-27', '00:41:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(246, 12, 'Login: Kert', '2026-04-27', '00:41:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(247, 12, 'New User has been added: Kert', '2026-04-27', '00:42:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(248, 12, 'Logout', '2026-04-27', '00:42:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(249, NULL, 'Login: Kert', '2026-04-27', '00:42:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(250, NULL, 'Logout', '2026-04-27', '00:43:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(251, 12, 'Login: Kert', '2026-04-27', '00:43:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(252, 12, 'Delete user', '2026-04-27', '00:43:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETED'),
(253, 12, 'Logout', '2026-04-27', '00:44:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(254, 17, 'Login: Mark Owen', '2026-04-27', '00:44:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(255, 17, 'Logout', '2026-04-27', '00:45:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(256, 12, 'Login: Kert', '2026-04-27', '00:45:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(257, 12, 'New User has been apdated: Mark Owen', '2026-04-27', '00:46:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(258, 12, 'New User has been apdated: Divino', '2026-04-27', '00:46:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(259, 12, 'Logout', '2026-04-27', '00:46:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(260, 17, 'Login: Mark Owen', '2026-04-27', '00:46:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(261, 17, 'Logout', '2026-04-27', '00:46:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(262, 18, 'Login: Divino', '2026-04-27', '00:46:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(263, 18, 'Logout', '2026-04-27', '00:46:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(264, 12, 'Login: Kert', '2026-04-27', '00:46:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(265, 12, 'Logout', '2026-04-27', '00:48:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(266, 17, 'Login: Mark Owen', '2026-04-27', '00:48:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(267, 17, 'Logout', '2026-04-27', '00:48:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(268, 12, 'Login: Kert', '2026-04-27', '00:48:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(269, 12, 'Logout', '2026-04-27', '00:50:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(270, 17, 'Login: Mark Owen', '2026-04-27', '00:50:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(271, 17, 'Logout', '2026-04-27', '00:53:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(272, 12, 'Login: Kert', '2026-04-27', '00:53:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(273, 12, 'Logout', '2026-04-27', '00:53:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(274, 17, 'Login: Mark Owen', '2026-04-27', '00:53:58', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(275, 17, 'Logout', '2026-04-27', '00:58:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(276, 18, 'Login: Divino', '2026-04-27', '00:58:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(277, 18, 'Logout', '2026-04-27', '01:05:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(278, 12, 'Login: Kert', '2026-04-27', '01:05:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(279, 12, 'Logout', '2026-04-27', '01:07:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(280, 17, 'Login: Mark Owen', '2026-04-27', '01:07:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(281, 17, 'Logout', '2026-04-27', '01:07:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(282, 18, 'Login: Divino', '2026-04-27', '01:07:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(283, 18, 'Logout', '2026-04-27', '01:10:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(284, 17, 'Login: Mark Owen', '2026-04-27', '01:10:58', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(285, 17, 'Logout', '2026-04-27', '01:33:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(286, 12, 'Login: Kert', '2026-04-27', '01:33:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(287, 12, 'New Guardian has been added: Maylene', '2026-04-27', '02:31:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(288, 12, 'Logout', '2026-04-27', '02:55:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(289, 12, 'Login: Kert', '2026-04-27', '03:03:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(290, 12, 'New Record has been added: John', '2026-04-27', '03:04:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(291, 12, 'New Record has been apdated: Kert', '2026-04-27', '03:40:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(292, 12, 'New Record has been apdated: Kert', '2026-04-27', '03:40:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(293, 12, 'New Record has been apdated: Kert', '2026-04-27', '03:42:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(294, 12, 'New Record has been apdated: Kaye Ranier', '2026-04-27', '03:42:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(295, 12, 'New Record has been apdated: John', '2026-04-27', '03:42:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(296, 12, 'Logout', '2026-04-27', '03:44:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(297, 17, 'Login: Mark Owen', '2026-04-27', '03:44:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(298, 17, 'New Medicine has been apdated: biogesic', '2026-04-27', '03:51:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(299, 17, 'New Medicine has been apdated: biogesic', '2026-04-27', '03:53:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(300, 17, 'New Medicine has been apdated: Maalox', '2026-04-27', '03:53:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(301, 17, 'New Equipment has been added: Cup', '2026-04-27', '03:59:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'ADD'),
(302, 17, 'New Medicine has been added: Decogesic', '2026-04-27', '04:02:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'ADD'),
(303, 17, 'New Medicine has been apdated: Bioflu', '2026-04-27', '04:02:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(304, 17, 'Delete Equipment', '2026-04-27', '04:06:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'DELETED'),
(305, 17, 'Delete Equipment', '2026-04-27', '04:06:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'DELETED'),
(306, 17, 'Delete Equipment', '2026-04-27', '04:06:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'DELETED'),
(307, 17, 'New Equipment has been added: Folding Bed', '2026-04-27', '04:07:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'ADD'),
(308, 17, 'New Equipment has been apdated: Folding Bed', '2026-04-27', '04:13:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(309, 17, 'New Equipment has been apdated: Folding Bed', '2026-04-27', '04:13:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(310, 17, 'New Equipment has been apdated: Folding Bed', '2026-04-27', '04:13:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(311, 17, 'New Equipment has been apdated: Folding Bed', '2026-04-27', '04:13:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(312, 17, 'Logout', '2026-04-27', '04:14:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(313, 18, 'Login: Divino', '2026-04-27', '04:14:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(314, 18, 'Logout', '2026-04-27', '04:14:23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(315, 18, 'Login: Divino', '2026-04-27', '13:04:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(316, 18, 'Logout', '2026-04-27', '13:04:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(317, 12, 'Login: Kert', '2026-04-27', '14:35:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(318, 12, 'Logout', '2026-04-27', '14:37:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(319, 18, 'Login: Divino', '2026-04-27', '14:37:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(320, 18, 'Logout', '2026-04-27', '14:37:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(321, 17, 'Login: Mark Owen', '2026-04-27', '14:37:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(322, 17, 'Logout', '2026-04-27', '14:43:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(323, 12, 'Login: Kert', '2026-04-27', '14:43:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(324, 12, 'Logout', '2026-04-27', '14:43:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(325, 12, 'Login: Kert', '2026-04-27', '22:28:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(326, 12, 'Logout', '2026-04-27', '22:33:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(327, 12, 'Login: Kert', '2026-04-27', '22:33:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(328, 12, 'Added appointment for patient ID: 3', '2026-04-27', '23:21:58', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(329, 12, 'Deleted appointment ID: 1', '2026-04-27', '23:22:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(330, 12, 'Added appointment for patient ID: 5', '2026-04-27', '23:24:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(331, 12, 'Added appointment for patient ID: 4', '2026-04-27', '23:39:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(332, 12, 'Updated appointment ID: 2', '2026-04-27', '23:49:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATE'),
(333, 12, 'Deleted appointment ID: 2', '2026-04-27', '23:49:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(334, 12, 'Deleted appointment ID: 4', '2026-04-27', '23:50:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(335, 12, 'New User has been added: Nicole', '2026-04-28', '00:23:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(336, 12, 'New User has been apdated: Nicole', '2026-04-28', '00:24:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(337, 12, 'Logout', '2026-04-28', '00:30:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(338, 17, 'Login: Mark Owen', '2026-04-28', '00:30:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(339, 17, 'Logout', '2026-04-28', '00:31:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(340, 12, 'Login: Kert', '2026-04-28', '00:31:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(341, 12, 'Logout', '2026-04-28', '00:37:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(342, 17, 'Login: Mark Owen', '2026-04-28', '00:37:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(343, 17, 'Added appointment for patient ID: 4', '2026-04-28', '00:58:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'ADD'),
(344, 17, 'Logout', '2026-04-28', '01:07:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(345, 12, 'Login: Kert', '2026-04-28', '01:07:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(346, 12, 'New User has been apdated: Kert', '2026-04-28', '01:08:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(347, 12, 'Logout', '2026-04-28', '01:09:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(348, 18, 'Login: Divino', '2026-04-28', '01:09:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(349, 18, 'Logout', '2026-04-28', '01:09:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(350, 17, 'Login: Mark Owen', '2026-04-28', '01:09:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(351, 17, 'Logout', '2026-04-28', '01:11:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT');
INSERT INTO `tbl_logs` (`LOGID`, `USERID`, `ACTION`, `DATELOG`, `TIMELOG`, `user_ip_address`, `device_used`, `USER_NAME`, `identifier`) VALUES
(352, 12, 'Login: Kert', '2026-04-28', '01:11:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(353, 12, 'Added medical record for patient ID: 3', '2026-04-28', '03:00:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(354, 12, 'Updated medical record ID: 1', '2026-04-28', '03:00:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATE'),
(355, 12, 'Logout', '2026-04-28', '03:11:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(356, 12, 'Login: Kert', '2026-04-28', '03:15:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(357, 12, 'Logout', '2026-04-28', '03:36:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(358, 17, 'Login: Mark Owen', '2026-04-28', '03:37:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(359, 17, 'Logout', '2026-04-28', '03:37:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(360, 18, 'Login: Divino', '2026-04-28', '03:37:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(361, 18, 'Logout', '2026-04-28', '03:37:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(362, 17, 'Login: Mark Owen', '2026-04-28', '03:37:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(363, 17, 'Logout', '2026-04-28', '03:39:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(364, 12, 'Login: Kert', '2026-04-28', '03:39:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(365, 12, 'Logout', '2026-04-28', '03:39:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(366, 12, 'Login: Kert', '2026-04-28', '03:39:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(367, 12, 'Logout', '2026-04-28', '03:57:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(368, 12, 'Login: Kert', '2026-04-28', '16:42:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(369, 12, 'New Record has been added: John Carl', '2026-04-28', '16:44:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(370, 12, 'Added appointment for patient ID: 6', '2026-04-28', '16:45:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(371, 12, 'Added medical record for patient ID: 6', '2026-04-28', '16:48:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(372, 12, 'Login: Kert', '2026-04-29', '17:01:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(373, 12, 'Logout', '2026-04-29', '17:05:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(374, 12, 'Login: Kert', '2026-04-29', '17:05:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(375, 17, 'Login: Mark Owen', '2026-04-29', '18:12:16', '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 [FBAN/FBIOS;FBAV/558.2.0.42.110;FBBV/952277649;FBDV/iPhone14,5;FBMD/iPhone;FBSN/iOS;FBSV/26.4.1;FBSS/3;FBCR/;FBID/phone;FBLC/en_US;FBOP/80]', 'Mark Owen', 'LOGIN'),
(376, 12, 'Login: Kert', '2026-05-04', '13:37:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(377, 12, 'New User has been added: Jovelyn', '2026-05-04', '13:37:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(378, 21, 'Login: Jovelyn', '2026-05-04', '13:39:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'LOGIN'),
(379, 21, 'New Record has been added: lexa', '2026-05-04', '13:41:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'ADD'),
(380, 21, 'New Record has been apdated: lexa', '2026-05-04', '13:42:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'UPDATED'),
(381, 12, 'New User has been added: Alexandra', '2026-05-04', '13:42:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(382, 22, 'Login: Alexandra', '2026-05-04', '13:42:42', '::1', 'Mozilla/5.0 (Linux; Android 15; SM-A055F Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/147.0.7727.111 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/559.0.0.49.75;]', 'Alexandra', 'LOGIN'),
(383, 21, 'Delete Record', '2026-05-04', '13:43:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'DELETED'),
(384, 21, 'New Record has been added: lynx', '2026-05-04', '13:45:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'ADD'),
(385, 21, 'Added medical record for patient ID: 8', '2026-05-04', '13:46:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'ADD'),
(386, 21, 'Deleted medical record ID: 3', '2026-05-04', '13:46:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'DELETE'),
(387, 22, 'New Record has been added: elyn', '2026-05-04', '13:47:42', '::1', 'Mozilla/5.0 (Linux; Android 15; SM-A055F Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/147.0.7727.111 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/559.0.0.49.75;]', 'Alexandra', 'ADD'),
(388, 22, 'Added medical record for patient ID: 9', '2026-05-04', '13:49:49', '::1', 'Mozilla/5.0 (Linux; Android 15; SM-A055F Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/147.0.7727.111 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/559.0.0.49.75;]', 'Alexandra', 'ADD'),
(389, 12, 'New Record has been apdated: elyn', '2026-05-04', '13:50:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(390, 12, 'New Record has been apdated: elyn', '2026-05-04', '13:50:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(391, 21, 'Logout', '2026-05-04', '13:53:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'LOGOUT'),
(392, 12, 'Logout', '2026-05-04', '13:53:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(393, 17, 'Login: Mark Owen', '2026-05-04', '13:53:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(394, 17, 'Logout', '2026-05-04', '13:54:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(395, 12, 'Login: Kert', '2026-05-04', '13:54:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(396, 22, 'Login: Alexandra', '2026-05-04', '13:59:09', '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'Alexandra', 'LOGIN'),
(397, 21, 'Login: Jovelyn', '2026-05-04', '13:59:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'LOGIN'),
(398, 22, 'Login: Alexandra', '2026-05-04', '14:00:30', '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'Alexandra', 'LOGIN'),
(399, 22, 'Login: Alexandra', '2026-05-04', '14:00:32', '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'Alexandra', 'LOGIN'),
(400, 21, 'Logout', '2026-05-04', '14:04:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'LOGOUT'),
(401, 12, 'Login: Kert', '2026-05-04', '14:04:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Kert', 'LOGIN'),
(402, 12, 'Logout', '2026-05-04', '14:04:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Kert', 'LOGOUT'),
(403, 21, 'Login: Jovelyn', '2026-05-04', '14:04:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'LOGIN'),
(404, 22, 'New Equipment has been added: Paracetamol', '2026-05-04', '14:07:31', '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'Alexandra', 'ADD'),
(405, 21, 'Logout', '2026-05-04', '14:08:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'LOGOUT'),
(406, 12, 'Logout', '2026-05-04', '14:08:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(407, 12, 'Login: Kert', '2026-05-04', '14:08:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Kert', 'LOGIN'),
(408, 13, 'Login: Admin', '2026-05-04', '14:10:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Admin', 'LOGIN'),
(409, 12, 'Login: Kert', '2026-05-05', '22:46:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(410, 12, 'Updated medical record ID: 1', '2026-05-05', '22:52:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATE'),
(411, 12, 'Added medical record for patient ID: 8', '2026-05-05', '22:53:23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(412, 12, 'Logout', '2026-05-05', '23:06:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(413, 17, 'Login: Mark Owen', '2026-05-05', '23:06:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(414, 17, 'Added medical record for patient ID: 9', '2026-05-05', '23:07:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'ADD'),
(415, 17, 'New Record has been apdated: Kert', '2026-05-05', '23:48:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(416, 17, 'New Record has been apdated: Kert', '2026-05-05', '23:50:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(417, 17, 'New Record has been apdated: Kert', '2026-05-05', '23:55:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'UPDATED'),
(418, 17, 'Logout', '2026-05-05', '23:59:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(419, 12, 'Login: Kert', '2026-05-05', '23:59:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(420, 12, 'Deleted medical record ID: 1', '2026-05-06', '00:59:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(421, 12, 'Deleted medical record ID: 2', '2026-05-06', '00:59:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(422, 12, 'Deleted medical record ID: 4', '2026-05-06', '00:59:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(423, 12, 'Deleted medical record ID: 5', '2026-05-06', '00:59:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(424, 12, 'Deleted medical record ID: 6', '2026-05-06', '00:59:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(425, 12, 'Logout', '2026-05-06', '00:59:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(426, 12, 'Login: Kert', '2026-05-06', '01:01:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(427, 12, 'New Record has been apdated: Kert', '2026-05-06', '01:09:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(428, 12, 'New Record has been apdated: Kert', '2026-05-06', '01:15:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(429, 12, 'New Record has been apdated: Kert', '2026-05-06', '01:19:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(430, 12, 'New Record has been apdated: Kert', '2026-05-06', '01:24:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(431, 12, 'New Record has been apdated: Kert', '2026-05-06', '01:27:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(432, 12, 'New Record has been apdated: Kert', '2026-05-06', '01:28:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(433, 12, 'Delete Record', '2026-05-06', '01:30:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETED'),
(434, 12, 'Delete Record', '2026-05-06', '01:30:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'DELETED'),
(435, 12, 'Added medical record for patient ID: 3', '2026-05-06', '01:31:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(436, 12, 'Logout', '2026-05-06', '01:31:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(437, 12, 'Login: Kert', '2026-05-06', '08:14:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(438, 12, 'Logout', '2026-05-06', '08:14:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(439, 12, 'Login: Kert', '2026-05-06', '08:16:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(440, 12, 'Logout', '2026-05-06', '08:17:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(441, 22, 'Login: Alexandra', '2026-05-06', '08:17:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'LOGIN'),
(442, 22, 'Delete Equipment', '2026-05-06', '08:18:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'DELETED'),
(443, 22, 'New Medicine has been added: Neozep', '2026-05-06', '08:19:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'ADD'),
(444, 22, 'New Medicine has been added: Neozep', '2026-05-06', '08:19:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'ADD'),
(445, 22, 'New Medicine has been added: Neozep', '2026-05-06', '08:19:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'ADD'),
(446, 22, 'Delete Medicine', '2026-05-06', '08:20:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'DELETED'),
(447, 22, 'Delete Medicine', '2026-05-06', '08:20:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'DELETED'),
(448, 22, 'Logout', '2026-05-06', '08:20:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'LOGOUT'),
(449, 22, 'Login: Alexandra', '2026-05-06', '08:24:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'LOGIN'),
(450, 22, 'Logout', '2026-05-06', '08:43:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Alexandra', 'LOGOUT'),
(451, 12, 'Login: Kert', '2026-05-06', '08:43:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(452, 12, 'New Record has been added: Delmar Emman', '2026-05-06', '08:44:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(453, 12, 'Added medical record for patient ID: 10', '2026-05-06', '08:45:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(454, 12, 'Updated medical record ID: 8', '2026-05-06', '08:54:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATE'),
(455, 12, 'Login: Kert', '2026-05-06', '13:01:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(456, 12, 'Logout', '2026-05-06', '13:10:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(457, 12, 'Login: Kert', '2026-05-06', '13:14:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(458, 12, 'Logout', '2026-05-06', '13:15:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(459, 13, 'Login: Admin', '2026-05-06', '14:01:27', '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'Admin', 'LOGIN'),
(460, 12, 'Login: Kert', '2026-05-06', '14:05:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(461, 22, 'Login: Alexandra', '2026-05-06', '14:09:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'LOGIN'),
(462, 22, 'New Record has been added: Lawrence', '2026-05-06', '14:15:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'ADD'),
(463, 22, 'New Record has been apdated: Lawrence', '2026-05-06', '14:16:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'UPDATED'),
(464, 22, 'New Record has been apdated: George', '2026-05-06', '14:30:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'UPDATED'),
(465, 22, 'Added medical record for patient ID: 11', '2026-05-06', '14:33:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'ADD'),
(466, 22, 'Deleted medical record ID: 9', '2026-05-06', '14:34:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'DELETE'),
(467, 22, 'Logout', '2026-05-06', '14:36:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'LOGOUT'),
(468, 22, 'Login: Alexandra', '2026-05-06', '14:38:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'LOGIN'),
(469, 22, 'Delete Guardian', '2026-05-06', '14:40:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'DELETED'),
(470, 22, 'Delete Record', '2026-05-06', '14:41:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'DELETED'),
(471, 22, 'New Record has been added: Kevin', '2026-05-06', '14:43:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'ADD'),
(472, 22, 'Logout', '2026-05-06', '14:47:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'Alexandra', 'LOGOUT'),
(473, 12, 'Login: Kert', '2026-05-06', '15:37:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(474, 12, 'New Record has been apdated: Kert', '2026-05-06', '15:38:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(475, 12, 'New Record has been added: Kert Miles', '2026-05-06', '15:41:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(476, 12, 'New Record has been apdated: Kert Miles', '2026-05-06', '15:42:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(477, 12, 'New Guardian has been added: Robert', '2026-05-06', '15:43:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(478, 12, 'New Record has been apdated: Kert Miles', '2026-05-06', '15:43:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(479, 12, 'Logout', '2026-05-06', '15:43:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(480, 12, 'Login: Kert', '2026-05-06', '18:47:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(481, 12, 'Login: Kert', '2026-05-06', '23:42:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(482, 12, 'Patient record has been updated: Kert Miles', '2026-05-06', '23:43:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(483, 12, 'New Record has been added: Jovelyn', '2026-05-06', '23:51:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(484, 12, 'New Guardian has been added: Lyn', '2026-05-06', '23:51:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(485, 12, 'Patient record has been updated: Jovelyn', '2026-05-06', '23:52:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(486, 12, 'Patient record has been updated: Jovelyn', '2026-05-06', '23:52:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(487, 12, 'Logout', '2026-05-07', '00:05:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(488, 17, 'Login: Mark Owen', '2026-05-07', '00:05:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(489, 17, 'Logout', '2026-05-07', '00:11:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(490, 12, 'Login: Kert', '2026-05-07', '00:11:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(491, 12, 'Logout', '2026-05-07', '00:11:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(492, 17, 'Login: Mark Owen', '2026-05-07', '00:11:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(493, 17, 'Logout', '2026-05-07', '00:22:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(494, 12, 'Login: Kert', '2026-05-07', '00:23:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(495, 12, 'Logout', '2026-05-07', '00:34:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(496, 12, 'Login: Kert', '2026-05-07', '00:40:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(497, 12, 'Logout', '2026-05-07', '00:42:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(498, 12, 'Login: Kert', '2026-05-07', '07:51:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(499, 12, 'Logout', '2026-05-07', '07:51:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(500, 12, 'Login: Kert', '2026-05-08', '16:24:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(501, 21, 'Login: Jovelyn', '2026-05-08', '16:27:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'LOGIN'),
(502, 12, 'Logout', '2026-05-08', '16:30:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(503, 17, 'Login: Mark Owen', '2026-05-08', '16:30:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(504, 17, 'Logout', '2026-05-08', '16:30:58', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(505, 12, 'Login: Kert', '2026-05-08', '16:32:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(506, 21, 'Patient record has been updated: Jovelyn', '2026-05-08', '16:35:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'UPDATED'),
(507, 12, 'Logout', '2026-05-08', '16:38:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(508, 12, 'Login: Kert', '2026-05-08', '16:38:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(509, 21, 'New Record has been added: Rodelyn', '2026-05-08', '16:42:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Jovelyn', 'ADD'),
(510, 12, 'Added appointment for patient ID: 3', '2026-05-08', '16:48:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(511, 12, 'Login: Kert', '2026-05-08', '17:06:32', '::1', 'Mozilla/5.0 (Linux; Android 9; ASUS_I001DA Build/PKQ1.190414.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/138.0.7204.179 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/559.0.0.49.75;]', 'Kert', 'LOGIN'),
(512, 12, 'New User has been added: Nicole', '2026-05-08', '17:08:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(513, 23, 'Login: Nicole', '2026-05-08', '17:08:56', '::1', 'Mozilla/5.0 (Linux; Android 14; RMX3760 Build/UP1A.231005.007; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/148.0.7778.159 Mobile Safari/537.36 Instagram 429.0.0.0.58 Android (34/14; 272dpi; 720x1600; realme; RMX3760; RE58C2; ums9230_hulk; en_US; 963240126; IABMV/1)', 'Nicole', 'LOGIN'),
(514, 12, 'Logout', '2026-05-08', '17:12:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(515, 17, 'Login: Mark Owen', '2026-05-08', '17:12:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(516, 17, 'Logout', '2026-05-08', '17:13:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(517, 18, 'Login: Divino', '2026-05-08', '17:13:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(518, 18, 'Logout', '2026-05-08', '17:13:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(519, 12, 'Login: Kert', '2026-05-08', '17:13:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(520, 12, 'Logout', '2026-05-08', '17:16:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(521, 17, 'Login: Mark Owen', '2026-05-08', '17:16:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(522, 17, 'Logout', '2026-05-08', '17:17:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(523, 18, 'Login: Divino', '2026-05-08', '17:17:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(524, 18, 'Logout', '2026-05-08', '17:17:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(525, 17, 'Login: Mark Owen', '2026-05-08', '17:17:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(526, 17, 'Logout', '2026-05-08', '17:20:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(527, 12, 'Login: Kert', '2026-05-08', '17:20:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(528, 12, 'Logout', '2026-05-08', '17:20:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(529, 18, 'Login: Divino', '2026-05-08', '17:20:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(530, 18, 'Logout', '2026-05-08', '17:21:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(531, 12, 'Login: Kert', '2026-05-08', '17:21:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(532, 12, 'Logout', '2026-05-08', '17:54:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(533, 12, 'Login: Kert', '2026-05-08', '18:42:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(534, 12, 'Logout', '2026-05-08', '19:17:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(535, 18, 'Login: Divino', '2026-05-08', '19:17:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(536, 18, 'Logout', '2026-05-08', '19:25:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(537, 12, 'Login: Kert', '2026-05-08', '19:25:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(538, 12, 'Logout', '2026-05-08', '19:26:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(539, 12, 'Login: Kert', '2026-05-08', '19:26:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(540, 12, 'Logout', '2026-05-08', '20:25:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(541, 18, 'Login: Divino', '2026-05-08', '20:25:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(542, 18, 'Logout', '2026-05-08', '20:33:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(543, 12, 'Login: Kert', '2026-05-08', '20:33:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(544, 12, 'Logout', '2026-05-08', '20:33:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(545, 17, 'Login: Mark Owen', '2026-05-08', '20:34:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(546, 17, 'Logout', '2026-05-08', '20:34:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(547, 12, 'Login: Kert', '2026-05-08', '20:34:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(548, 12, 'Logout', '2026-05-08', '20:34:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(549, 18, 'Login: Divino', '2026-05-08', '20:35:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(550, 18, 'Logout', '2026-05-08', '20:36:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(551, 17, 'Login: Mark Owen', '2026-05-08', '20:36:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(552, 17, 'Logout', '2026-05-08', '20:36:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(553, 12, 'Login: Kert', '2026-05-08', '20:36:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(554, 12, 'Logout', '2026-05-08', '20:36:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(555, 17, 'Login: Mark Owen', '2026-05-08', '20:36:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(556, 17, 'Logout', '2026-05-08', '20:40:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(557, 18, 'Login: Divino', '2026-05-08', '20:40:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(558, 18, 'Logout', '2026-05-08', '20:40:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(559, 13, 'Login: Admin', '2026-05-08', '20:40:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Admin', 'LOGIN'),
(560, 13, 'Logout', '2026-05-08', '20:41:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Admin', 'LOGOUT'),
(561, 17, 'Login: Mark Owen', '2026-05-08', '20:41:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(562, 17, 'Logout', '2026-05-08', '20:50:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(563, 12, 'Login: Kert', '2026-05-08', '20:50:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(564, 12, 'Logout', '2026-05-08', '21:15:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(565, 12, 'Login: Kert', '2026-05-08', '21:15:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(566, 12, 'Added medical record for patient ID: 10', '2026-05-08', '21:27:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(567, 12, 'Logout', '2026-05-08', '22:23:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(568, 17, 'Login: Mark Owen', '2026-05-08', '22:23:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(569, 17, 'Logout', '2026-05-08', '22:24:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(570, 18, 'Login: Divino', '2026-05-08', '22:24:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(571, 18, 'Logout', '2026-05-08', '22:34:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(572, 12, 'Login: Kert', '2026-05-08', '22:34:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(573, 12, 'Logout', '2026-05-08', '22:46:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(574, 12, 'Login: Kert', '2026-05-08', '23:08:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(575, 12, 'Logout', '2026-05-08', '23:43:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(576, 18, 'Login: Divino', '2026-05-08', '23:43:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(577, 18, 'Logout', '2026-05-08', '23:47:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(578, 17, 'Login: Mark Owen', '2026-05-08', '23:47:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(579, 17, 'Logout', '2026-05-08', '23:48:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(580, 12, 'Login: Kert', '2026-05-08', '23:48:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(581, 12, 'Logout', '2026-05-08', '23:48:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(582, 18, 'Login: Divino', '2026-05-08', '23:48:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(583, 18, 'Logout', '2026-05-08', '23:50:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(584, 17, 'Login: Mark Owen', '2026-05-08', '23:50:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(585, 17, 'Logout', '2026-05-08', '23:54:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(586, 12, 'Login: Kert', '2026-05-08', '23:54:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(587, 12, 'Logout', '2026-05-08', '23:55:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(588, 17, 'Login: Mark Owen', '2026-05-08', '23:55:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(589, 17, 'Logout', '2026-05-08', '23:56:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(590, 12, 'Login: Kert', '2026-05-09', '00:12:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(591, 12, 'Delete user', '2026-05-09', '00:16:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'DELETED'),
(592, 12, 'Logout', '2026-05-09', '00:17:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(593, 17, 'Login: Mark Owen', '2026-05-09', '00:17:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(594, 17, 'Logout', '2026-05-09', '00:31:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(595, 12, 'Login: Kert', '2026-05-09', '00:31:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(596, 12, 'Logout', '2026-05-09', '00:32:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(597, 18, 'Login: Divino', '2026-05-09', '00:32:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(598, 12, 'Login: Kert', '2026-05-09', '11:04:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(599, 12, 'Logout', '2026-05-09', '11:13:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(600, 12, 'Login: Kert', '2026-05-09', '13:13:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN');
INSERT INTO `tbl_logs` (`LOGID`, `USERID`, `ACTION`, `DATELOG`, `TIMELOG`, `user_ip_address`, `device_used`, `USER_NAME`, `identifier`) VALUES
(601, 12, 'New Record has been added: Jep', '2026-05-09', '13:16:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(602, 12, 'New Guardian has been added: Jema', '2026-05-09', '13:16:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(603, 12, 'Patient record has been updated: Jep', '2026-05-09', '13:17:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(604, 12, 'Patient record has been updated: Jep', '2026-05-09', '13:18:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(605, 12, 'Login: Kert', '2026-05-09', '15:56:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(606, 12, 'Updated medical record ID: 8', '2026-05-09', '15:59:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'UPDATE'),
(607, 12, 'Updated medical record ID: 10', '2026-05-09', '16:00:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'UPDATE'),
(608, 12, 'Logout', '2026-05-09', '16:12:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(609, 12, 'Logout', '2026-05-09', '16:12:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(610, NULL, 'Logout', '2026-05-09', '16:12:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, 'LOGOUT'),
(611, 17, 'Login: Mark Owen', '2026-05-09', '16:12:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(612, 17, 'Logout', '2026-05-09', '16:17:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(613, 18, 'Login: Divino', '2026-05-09', '16:17:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(614, 18, 'Logout', '2026-05-09', '16:19:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(615, 13, 'Login: Admin', '2026-05-09', '16:19:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Admin', 'LOGIN'),
(616, 13, 'Logout', '2026-05-09', '16:21:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Admin', 'LOGOUT'),
(617, 13, 'Login: Admin', '2026-05-09', '16:26:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'Admin', 'LOGIN'),
(618, 12, 'Login: Kert', '2026-05-09', '16:30:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(619, 21, 'Login: Jovelyn', '2026-05-09', '22:42:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'Jovelyn', 'LOGIN'),
(620, 12, 'Login: Kert', '2026-05-11', '00:38:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(621, 12, 'New Medicine has been added: Biogesic', '2026-05-11', '00:39:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(622, 12, 'Added medical record for patient ID: 14', '2026-05-11', '00:40:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(623, 12, 'Updated medical record ID: 11', '2026-05-11', '00:41:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'UPDATE'),
(624, 12, 'Deleted medical record ID: 11', '2026-05-11', '00:41:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(625, 12, 'Logout', '2026-05-11', '00:50:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(626, 12, 'Login: Kert', '2026-05-11', '01:12:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(627, 12, 'Logout', '2026-05-11', '01:17:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(628, 12, 'Login: Kert', '2026-05-11', '01:20:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(629, 12, 'Logout', '2026-05-11', '01:21:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(630, 12, 'Login: Kert', '2026-05-11', '01:33:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(631, 12, 'Logout', '2026-05-11', '01:35:23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(632, 17, 'Login: Mark Owen', '2026-05-11', '01:35:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGIN'),
(633, 17, 'Logout', '2026-05-11', '01:36:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Mark Owen', 'LOGOUT'),
(634, 18, 'Login: Divino', '2026-05-11', '01:36:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGIN'),
(635, 18, 'Updated medical record ID: 8', '2026-05-11', '01:37:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'UPDATE'),
(636, 18, 'Logout', '2026-05-11', '01:37:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Divino', 'LOGOUT'),
(637, 12, 'Login: Kert', '2026-05-11', '01:42:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(638, 12, 'New User has been added: Kert', '2026-05-11', '01:47:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'ADD'),
(639, 12, 'Logout', '2026-05-11', '01:47:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(640, 12, 'Login: Kert', '2026-05-11', '01:50:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(641, 12, 'Delete Record', '2026-05-11', '01:50:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'DELETED'),
(642, 12, 'Patient record has been updated: Kert', '2026-05-14', '02:04:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'UPDATED'),
(643, 12, 'Logout', '2026-05-14', '02:04:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGOUT'),
(644, 12, 'Login: Kert', '2026-05-14', '02:14:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'LOGIN'),
(645, 12, 'Deleted medical record ID: 12', '2026-05-14', '02:14:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(646, 12, 'Deleted medical record ID: 15', '2026-05-14', '02:14:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'DELETE'),
(647, 12, 'Added medical record for patient ID: 20', '2026-05-14', '02:14:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Kert', 'ADD');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT 'user',
  `status` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `email`, `password`, `role`, `status`, `name`, `phone`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, NULL, 'Kert@gmail.com', '$2y$10$4I7egAI7ruh8OaWj.gFpzOB4XQeYdQg/hoMr1eQgQrKZgpoLstOgq', 'Admin', 'Active', 'Kert', '09636083085', '2026-04-15 03:57:18', '2026-04-27 09:08:45', '2026-04-27 09:08:45'),
(13, NULL, 'admin@gmail.com', '$2y$10$p2BxNnkDCa6FijQWzSpPE.lZl0E8T9Nuv7AQTPkAEWtWWKGohnPjK', 'Admin', 'Active', 'Admin', '09636083085', '2026-04-16 11:00:44', '2026-04-16 03:00:44', '2026-04-16 03:00:44'),
(17, NULL, 'owen@gmail.com', '$2y$10$H3xIT3aSaS6WeD0nkWhY1OMlY1hBEw6E8LMZxJJ/Eh7vZmeuqvnYu', 'Doctor', 'Active', 'Mark Owen', '09262682108210', '2026-04-26 08:07:40', '2026-04-26 08:46:13', '2026-04-26 08:46:13'),
(18, NULL, 'Divino@gmail.com', '$2y$10$zTJkD6lRIEI3Kt/uNgTk9uJS5QsUKQ.aWd.E5tapZnKRAY2Iy1rQO', 'Nurse', 'Active', 'Divino', '09636083085', '2026-04-26 08:38:31', '2026-04-26 08:46:19', '2026-04-26 08:46:19'),
(21, NULL, 'jov@gmail.com', '$2y$10$DbucSGGeU2Hh.0lPzj18fOQy.xtbJc08GPVnST3iGg4F5/7slT7xC', 'Nurse', 'In Active', 'Jovelyn', '09636083085', '2026-05-03 21:37:43', '2026-05-03 21:37:43', '2026-05-03 21:37:43'),
(22, NULL, 'lexa@gmail.com', '$2y$10$iI7/v1XyXx9l/wDAUkzI3.57czQecrC21F7DC59svoJi9oJ0iUvCC', 'Doctor', 'Active', 'Alexandra', '09262682108210', '2026-05-03 21:42:21', '2026-05-03 21:42:21', '2026-05-03 21:42:21'),
(26, NULL, 'Kaye@gmail.com', '$2y$10$n45jIam7VReuwBDSy0gNeOTjLHq8qM.OrhYL3GXvyAd1yzYClTpty', 'Admin', 'Active', 'Kaye', '09262682108210', '2026-05-12 01:39:35', '2026-05-12 01:39:35', NULL),
(27, NULL, 'nurserosa@gmail.com', '0ecf0285c52337d198723ffcb06c19313d1790be40acb6c6887e1810e5ada879', 'Nurse', 'Active', 'Rosa Dela Cruz', '09201234567', '2026-05-13 16:19:53', '2026-05-13 16:19:53', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_login_user` (`user_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `patient_parents`
--
ALTER TABLE `patient_parents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient` (`patient_id`),
  ADD KEY `fk_parent` (`parent_id`);

--
-- Indexes for table `record_medicines`
--
ALTER TABLE `record_medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rm_record` (`record_id`),
  ADD KEY `fk_rm_medicine` (`medicine_id`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`LOGID`),
  ADD KEY `USERID` (`USERID`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `patient_parents`
--
ALTER TABLE `patient_parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `LOGID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=648;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
