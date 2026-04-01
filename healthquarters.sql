-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2026 at 06:26 AM
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
-- Database: `healthquarters`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `sex` varchar(10) NOT NULL,
  `age` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `service` varchar(100) NOT NULL,
  `location` varchar(50) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending',
  `cancelled_by` enum('user') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `fullname`, `email`, `contact_number`, `address`, `sex`, `age`, `birthday`, `service`, `location`, `appointment_date`, `appointment_time`, `created_at`, `status`, `cancelled_by`) VALUES
(1, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:23:00', 'Pending', NULL),
(2, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:30:33', 'Pending', NULL),
(3, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:36:00', 'Pending', NULL),
(4, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:38:09', 'Pending', NULL),
(5, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:39:17', 'Pending', NULL),
(6, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:39:49', 'Pending', NULL),
(7, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:42:50', 'Pending', NULL),
(8, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:46:16', 'Pending', NULL),
(9, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:50:12', 'Pending', NULL),
(10, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:51:20', 'Pending', NULL),
(11, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:54:31', 'Pending', NULL),
(12, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:56:10', 'Pending', NULL),
(13, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:56:43', 'Pending', NULL),
(14, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:57:52', 'Pending', NULL),
(15, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 14:59:46', 'Pending', NULL),
(16, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:00:14', 'Pending', NULL),
(17, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:00:57', 'Pending', NULL),
(18, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:01:30', 'Pending', NULL),
(19, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:01:34', 'Pending', NULL),
(20, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:01:53', 'Pending', NULL),
(21, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:02:27', 'Pending', NULL),
(22, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:03:43', 'Pending', NULL),
(23, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:04:20', 'Pending', NULL),
(24, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:04:43', 'Pending', NULL),
(25, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:05:24', 'Pending', NULL),
(26, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:05:45', 'Pending', NULL),
(27, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:07:25', 'Pending', NULL),
(28, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:08:42', 'Pending', NULL),
(29, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:10:53', 'Pending', NULL),
(30, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 19, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '09:00:00', '2025-09-11 15:44:31', 'Pending', NULL),
(31, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', '', 20, '0000-00-00', 'Imaging', 'Ligao Branch', '0000-00-00', '00:00:00', '2025-09-11 15:52:55', 'Pending', NULL),
(32, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 20, '2005-02-19', 'Lab Test', 'Ligao', '2025-09-12', '11:00:00', '2025-09-11 15:54:17', 'Pending', NULL),
(33, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', '', 20, '0000-00-00', 'Lab Tests', 'Ligao Branch', '0000-00-00', '00:00:00', '2025-09-11 15:56:42', 'Pending', NULL),
(34, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', '', 20, '0000-00-00', 'Lab Tests', 'Ligao Branch', '0000-00-00', '00:00:00', '2025-09-11 15:58:13', 'Pending', NULL),
(35, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', '', 20, '0000-00-00', 'Lab Tests', 'Ligao Branch', '0000-00-00', '00:00:00', '2025-09-11 16:07:12', 'Pending', NULL),
(36, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', '', 20, '0000-00-00', 'Lab Tests', 'Ligao Branch', '0000-00-00', '00:00:00', '2025-09-11 16:08:19', 'Pending', NULL),
(37, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', '', 20, '0000-00-00', 'Imaging', 'Ligao Branch', '0000-00-00', '00:00:00', '2025-09-11 16:08:49', 'Pending', NULL),
(38, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 20, '2005-02-19', 'Imaging', 'Polangui Branch', '2025-09-13', '14:00:00', '2025-09-11 16:16:10', 'Pending', NULL),
(39, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 20, '2005-02-19', 'Imaging', 'Polangui Branch', '2025-09-13', '10:00:00', '2025-09-11 16:34:11', 'Pending', NULL),
(40, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 20, '2005-02-19', 'Lab Tests', 'Ligao Branch', '2025-09-15', '07:00:00', '2025-09-11 16:37:00', 'Pending', NULL),
(41, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 20, '2005-02-19', 'Imaging', 'Polangui Branch', '2025-09-13', '10:00:00', '2025-09-11 16:41:32', 'Pending', NULL),
(42, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 20, '2005-02-19', 'Imaging', 'Ligao Branch', '2025-09-13', '11:00:00', '2025-09-11 16:42:33', 'Pending', NULL),
(43, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 20, '2005-02-19', 'Imaging', 'Polangui Branch', '2025-09-20', '11:00:00', '2025-09-11 16:54:04', 'Pending', NULL),
(44, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 20, '2005-02-19', 'Lab Tests', 'Ligao Branch', '2025-09-15', '13:00:00', '2025-09-11 16:59:04', 'Pending', NULL),
(45, 2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '09123456788', 'Alomon, Polangui Albay', 'Female', 20, '2005-02-19', 'Lab Tests', 'Polangui Branch', '2025-09-15', '10:00:00', '2025-09-11 17:02:45', 'Pending', NULL),
(46, 3, 'Patient One', 'patientone@gmail.com', '09987456123', 'Polangui,Albay', 'Male', 21, '2004-01-22', 'Drug Test', 'Ligao Branch', '2025-09-12', '22:30:00', '2025-09-12 15:36:27', 'Pending', NULL),
(47, 4, 'Mariz Bata', 'marizbata14@gmail.com', '09999999999', 'P1, Obaliw-Rinas, Oas, Albay', 'Female', 19, '2005-12-11', 'X-ray', 'Ligao Branch', '2025-09-21', '09:30:00', '2025-09-21 13:27:38', 'Pending', NULL),
(48, 4, 'Mariz Bata', 'marizbata14@gmail.com', '09999999999', 'P1, Obaliw-Rinas, Oas, Albay', 'Female', 19, '2005-12-11', 'Blood test', 'Ligao Branch', '2025-09-21', '11:00:00', '2025-09-21 13:38:26', 'Pending', NULL),
(49, 4, 'Mariz Bata', 'marizbata14@gmail.com', '09999999999', 'P1, Obaliw-Rinas, Oas, Albay', 'Female', 19, '2005-12-11', 'Urinalysis', 'Ligao Branch', '2025-09-21', '13:00:00', '2025-09-21 13:39:58', 'Pending', NULL),
(50, 4, 'Mariz Bata', 'marizbata14@gmail.com', '09999999999', 'P1, Obaliw-Rinas, Oas, Albay', 'Female', 19, '2005-12-11', 'Blood test', 'Ligao Branch', '2025-09-21', '13:41:00', '2025-09-21 13:47:05', 'Pending', NULL),
(51, 4, 'Mariz Bata', 'marizbata14@gmail.com', '09999999999', 'P1, Obaliw-Rinas, Oas, Albay', 'Female', 19, '2005-12-11', 'Complete blood count', 'Ligao Branch', '2025-09-21', '14:50:00', '2025-09-21 13:49:33', 'Pending', NULL),
(52, 5, 'Patient Two', 'patient2@gmail.com', '09123456789', 'P2, Obaliw-Rinas, Oas, Albay', 'Female', 20, '2004-02-01', 'X-ray', 'Ligao Branch', '2025-09-22', '13:00:00', '2025-09-22 04:05:15', 'Pending', NULL),
(53, 5, 'Patient Two', 'patient2@gmail.com', '09123456789', 'P2, Obaliw-Rinas, Oas, Albay', 'Female', 20, '2004-11-01', 'Complete blood count', 'Ligao Branch', '2025-09-22', '14:30:00', '2025-09-22 04:29:04', 'Pending', NULL),
(54, 5, 'Patient Two', 'patient2@gmail.com', '09123456789', 'P2, Obaliw-Rinas, Oas, Albay', 'Female', 20, '2004-11-01', 'Cancer Marker Test', 'Ligao Branch', '2025-09-23', '13:05:00', '2025-09-23 04:06:13', 'Pending', NULL),
(55, 6, 'Shanley Resentes', 'shanley19@gmail.com', '09075193156', 'Bongoran, Oas, Albay', 'Female', 21, '2004-10-19', 'Blood Typing', 'Ligao Branch', '2025-09-23', '13:00:00', '2025-09-23 04:14:56', 'Pending', NULL),
(56, 6, 'Shanley Resentes', 'shanley19@gmail.com', '09075193156', 'Bongoran, Oas, Albay', 'Female', 21, '2004-10-19', 'X-ray', 'Ligao', '2025-09-23', '11:00:00', '2025-09-23 05:49:25', 'Confirmed', NULL),
(57, 4, 'Mariz Bata', 'marizbata14@gmail.com', '09999999999', 'P1, Obaliw-Rinas, Oas, Albay', 'Female', 19, '2005-11-21', 'Urinalysis', 'Ligao', '2025-09-28', '11:00:00', '2025-09-27 03:23:36', 'Pending', NULL),
(58, 5, 'Patient Two', 'patient2@gmail.com', '09123456789', 'P2, Obaliw-Rinas, Oas, Albay', 'Female', 20, '2004-09-11', 'Urinalysis', 'Ligao', '2025-09-29', '10:00:00', '2025-09-29 02:47:03', 'Pending', NULL),
(59, 5, 'Patient Two', 'patient2@gmail.com', '09123456789', 'P2, Obaliw-Rinas, Oas, Albay', 'Female', 20, '2004-09-11', 'Dengue Test', 'Ligao', '2025-09-29', '12:30:00', '2025-09-29 02:53:00', 'Pending', NULL),
(60, 5, 'Patient Two', 'patient2@gmail.com', '09123456789', 'P2, Obaliw-Rinas, Oas, Albay', 'Female', 20, '2004-09-01', 'Urinalysis', 'Ligao', '2025-09-29', '12:00:00', '2025-09-29 02:55:44', 'Pending', NULL),
(61, 9, 'Resentes', 'rsnts@gmail.com', '09008572196', 'Bongoran, Oas Albay', 'Female', 21, '2004-10-19', 'Dengue Test', 'Ligao', '2025-12-22', '01:00:00', '2025-12-20 02:57:17', 'Pending', NULL),
(62, 12, 'celly rave', 'clrv@gmail.com', '09123456789', 'bu polangui', 'Female', 21, '2004-12-16', 'X-ray', 'Polangui Branch', '2025-12-22', '09:00:00', '2025-12-20 03:13:40', 'Cancelled', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `corporate_inquiries`
--

CREATE TABLE `corporate_inquiries` (
  `id` int(11) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `company_number` varchar(50) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `company_size` varchar(50) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `contact_person` varchar(100) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(30) NOT NULL,
  `service_type` varchar(150) DEFAULT NULL,
  `emp_count` int(11) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `hmo_provider` varchar(120) DEFAULT NULL,
  `hmo_code` varchar(80) DEFAULT NULL,
  `hmo_coverage` varchar(80) DEFAULT NULL,
  `hmo_covered_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `corporate_inquiries`
--

INSERT INTO `corporate_inquiries` (`id`, `company_name`, `company_number`, `industry`, `company_size`, `company_address`, `contact_person`, `designation`, `email`, `contact_number`, `service_type`, `emp_count`, `schedule`, `message`, `status`, `created_at`, `user_id`, `hmo_provider`, `hmo_code`, `hmo_coverage`, `hmo_covered_count`) VALUES
(1, 'J&T Express', '02-1425-3389', 'Transportation & Logistics', '11–50 employees', 'Miranda Street, Legazpi City, Albay', 'Maria Reyes', 'HR Manager', 'mariarys.01@gmail.com', '09641257983', 'Drug Testing (DOLE-compliant)', 100, 'Within this week', 'Needed as early as possible', 'Pending', '2026-03-08 20:21:42', NULL, NULL, NULL, NULL, NULL),
(2, 'J&T Express', '02-1425-3389', 'Transportation & Logistics', '11–50 employees', 'Miranda Street, Legazpi City, Albay', 'Maria Reyes', 'HR Manager', 'marizsabaterbata@gmail.com', '09641257983', 'Drug Testing (DOLE-compliant)', 100, 'Within this week', 'Needed as soon as possible', 'Pending', '2026-03-15 09:52:17', NULL, NULL, NULL, NULL, NULL),
(3, 'J&T Express', '02-1425-3389', 'Transportation & Logistics', '11–50 employees', 'Miranda Street, Legazpi City, Albay', 'Maria Reyes', 'HR Manager', 'marizsabaterbata@gmail.com', '09641257983', 'Drug Testing (DOLE-compliant)', 100, 'Within this week', 'Please respond as early as possible', 'In Progress', '2026-03-15 10:12:00', 21, NULL, NULL, NULL, NULL),
(4, 'J&T Express', '02-1425-3389', 'Transportation & Logistics', '11–50 employees', 'Miranda Street, Legazpi City, Albay', 'Maria Reyes', 'HR Manager', 'marizsabaterbata@gmail.com', '09641257983', 'Annual Physical Examination (APE)', 100, 'Within this week', 'As early as possible', 'In Progress', '2026-03-15 15:08:14', 32, NULL, NULL, NULL, NULL),
(5, 'J&T Express', '02-1425-3389', 'Transportation & Logistics', '11–50 employees', 'Miranda Street, Legazpi City, Albay', 'Maria Reyes', 'HR Manager', 'marizsabaterbata@gmail.com', '09641257983', 'Occupational Health Services', 100, 'Within this week', 'dsjdwfieu', 'Pending', '2026-03-15 15:37:07', 32, NULL, NULL, NULL, NULL),
(6, 'J&T Express', '02-1425-3389', 'Transportation & Logistics', '11–50 employees', 'Miranda Street, Legazpi City, Albay', 'Maria Reyes', 'HR Manager', 'marizsabaterbata@gmail.com', '09641257983', 'Drug Testing (DOLE-compliant)', 100, 'Within this week', 'tyfygsdftgyhuikojhgfdxcvbhjn', 'In Progress', '2026-03-15 15:42:03', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_otps`
--

CREATE TABLE `email_otps` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_otps`
--

INSERT INTO `email_otps` (`id`, `email`, `otp`, `expires_at`, `verified`, `created_at`) VALUES
(6, 'charlsbarquin2@gmail.com', '336786', '2026-03-30 08:45:32', 1, '2026-03-30 14:35:32'),
(7, 'charlsemilbarquin@gmail.com', '985528', '2026-03-30 14:27:21', 1, '2026-03-30 20:17:21');

-- --------------------------------------------------------

--
-- Table structure for table `home_service_appointments`
--

CREATE TABLE `home_service_appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `preferred_time` varchar(20) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(10) UNSIGNED DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `contact_num` varchar(30) DEFAULT NULL,
  `alt_contact` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Pending',
  `appointment_type` varchar(50) DEFAULT 'Home Service',
  `created_at` datetime DEFAULT current_timestamp(),
  `reminder_sent` tinyint(1) DEFAULT 0,
  `fasting_reminder_sent` tinyint(1) DEFAULT 0,
  `confirmation_sent` tinyint(1) DEFAULT 0,
  `lab_result` text DEFAULT NULL,
  `result_notes` varchar(500) DEFAULT NULL,
  `result_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reschedule_requests`
--

CREATE TABLE `reschedule_requests` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `requested_date` date NOT NULL,
  `requested_time` varchar(20) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_service_appointments`
--

INSERT INTO `home_service_appointments` (`id`, `user_id`, `appointment_date`, `preferred_time`, `service_type`, `branch`, `notes`, `first_name`, `last_name`, `middle_name`, `dob`, `age`, `gender`, `contact_num`, `alt_contact`, `email`, `address`, `status`, `appointment_type`, `created_at`, `reminder_sent`, `fasting_reminder_sent`, `confirmation_sent`, `lab_result`, `result_notes`, `result_date`) VALUES
(1, 15, '2026-03-17', '9:00 AM', 'Blood Collection / Lab Test', NULL, '', 'Marites', 'Bata', '', '1974-01-01', NULL, 'Female', '09641257983', '', 'mariarys.01@gmail.com', '1234, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-08 15:56:49', 0, 0, 0, NULL, NULL, NULL),
(2, 15, '2026-03-17', '8:00 AM', 'Blood Collection / Lab Test', NULL, '', 'Marites', 'Bata', '', '1974-01-01', NULL, 'Female', '09641257983', '', 'mariarys.01@gmail.com', '1234, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-08 15:57:25', 0, 0, 0, NULL, NULL, NULL),
(3, 15, '2026-03-26', '10:00 AM', 'Wound Care / Dressing', NULL, '', 'Marites', 'Bata', '', '1974-01-01', NULL, 'Female', '09641257983', '', 'mariarys.01@gmail.com', '1234, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-08 16:18:55', 0, 0, 0, NULL, NULL, NULL),
(4, 16, '2026-03-20', '8:00 AM', 'General Check-up', NULL, '', 'Charmie', 'Dela Paz', '', '2026-03-10', NULL, 'Female', '09123456789', '', 'cdp@gmail.com', 'N/A, Zone 3, Obaliw, Oas, Albay', 'Pending', 'Home Service', '2026-03-08 16:54:50', 0, 0, 0, NULL, NULL, NULL),
(5, 17, '2026-03-09', '10:00 AM', 'Blood Collection / Lab Test', NULL, '', 'Charmie', 'Dela Paz', '', '2026-03-10', NULL, 'Female', '09123456789', '', 'cdp@gmail.com', 'N/A, Zone 3, Obaliw, Oas, Albay', 'Pending', 'Home Service', '2026-03-08 22:11:00', 0, 0, 0, NULL, NULL, NULL),
(6, 21, '2026-03-09', '11:00 AM', 'General Check-up', NULL, '', 'Mariz', 'Bata', '', '2005-11-21', NULL, 'Female', '09614417105', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-08 22:21:25', 0, 0, 1, NULL, NULL, NULL),
(7, 21, '2026-03-11', '9:00 AM', 'Blood Collection / Lab Test', NULL, '', 'Mariz', 'Bata', '', '2005-11-21', NULL, 'Female', '09614417105', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-08 22:22:28', 0, 0, 0, NULL, NULL, NULL),
(8, 21, '2026-03-12', '9:00 AM', 'General Check-up', NULL, '', 'Mariz', 'Bata', '', '2005-11-21', NULL, 'Female', '09614417105', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-08 22:34:00', 0, 0, 0, NULL, NULL, NULL),
(9, 21, '2026-03-10', '9:00 AM', 'Blood Collection / Lab Test', NULL, '', 'Mariz', 'Bata', '', '2005-11-21', NULL, 'Female', '09614417105', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-09 08:21:53', 0, 0, 0, NULL, NULL, NULL),
(10, 21, '2026-03-10', '9:00 AM', 'Wound Care / Dressing', NULL, '', 'Mariz', 'Bata', '', '2005-11-21', NULL, 'Female', '09614417105', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-09 08:59:44', 0, 0, 0, NULL, NULL, NULL),
(11, 21, '2026-03-10', '10:00 AM', 'Post-Surgery Care', NULL, '', 'Mariz', 'Bata', '', '2005-11-21', NULL, 'Female', '09614417105', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-09 09:09:19', 0, 0, 0, NULL, NULL, NULL),
(12, 21, '2026-03-12', '11:00 AM', 'COVID-19 Monitoring', NULL, '', 'Mariz Bata', 'Bata', '', '2026-03-10', NULL, 'Female', '09123456789', '', 'marizbata14@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-09 09:29:18', 0, 0, 0, NULL, NULL, NULL),
(13, 21, '2026-03-16', '9:00 AM', 'Blood Collection / Lab Test', NULL, '', 'Mariz Bata', 'Bata', '', '2026-03-10', NULL, 'Female', '09123456789', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-12 21:51:13', 0, 0, 1, NULL, NULL, NULL),
(14, 21, '2026-03-13', '11:00 AM', 'Wound Care / Dressing', NULL, '', 'Mariz Bata', 'Bata', '', '2026-03-10', NULL, 'Female', '09123456789', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-12 22:12:20', 0, 0, 1, NULL, NULL, NULL),
(15, 21, '2026-03-17', '9:00 AM', 'Post-Surgery Care', NULL, '', 'Mariz Bata', 'Bata', '', '2026-03-10', NULL, 'Female', '09123456789', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-12 22:32:01', 0, 0, 1, NULL, NULL, NULL),
(16, 33, '2026-03-14', '10:00 AM', 'General Check-up', NULL, '', 'Charmy', 'Reyes', '', '2003-01-15', 23, 'Female', '09123456789', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-13 10:20:56', 0, 0, 1, NULL, NULL, NULL),
(17, 33, '2026-03-15', '9:00 AM', 'Blood Collection / Lab Test', NULL, '', 'Charmy', 'Reyes', '', '2003-01-15', 23, 'Female', '09123456789', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-13 11:15:21', 0, 0, 1, NULL, NULL, NULL),
(18, 33, '2026-03-16', '11:00 AM', 'Post-Surgery Care', NULL, '', 'Mariz Bata', 'Bata', '', '2026-03-10', NULL, 'Female', '09123456789', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-13 11:25:16', 0, 0, 1, NULL, NULL, NULL),
(19, 33, '2026-03-14', '1:00 PM', 'Elderly Care', NULL, '', 'Charmy', 'Reyes', '', '2003-01-15', 23, 'Female', '09123456789', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-13 12:49:36', 0, 0, 1, NULL, NULL, NULL),
(20, 21, '2026-03-20', '9:00 AM', 'COVID-19 Monitoring', NULL, '', 'Mariz', 'Bata', '', '2005-11-21', 20, 'Female', '09123456789', '', 'mrzbt.21@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-13 15:00:52', 0, 0, 1, NULL, NULL, NULL),
(21, 33, '2026-03-14', '1:00 PM', 'Blood Collection / Lab Test', NULL, '', 'Mary Ann', 'Santos', '', '2010-05-19', 15, 'Female', '09123456789', '', 'marizsabaterbata@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-13 15:06:48', 0, 0, 1, NULL, NULL, NULL),
(22, 33, '2026-03-14', '3:00 PM', 'Blood Collection / Lab Test', NULL, '', 'Mary Ann', 'Santos', '', '2010-05-19', 15, 'Female', '09123456789', '', 'marizsabaterbata@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-13 15:25:06', 0, 0, 1, NULL, NULL, NULL),
(23, 33, '2026-03-17', '4:00 PM', 'IV Therapy / Infusion', NULL, '', 'Mary Ann', 'Santos', '', '2010-05-19', 15, 'Female', '09123456789', '', 'marizsabaterbata@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Approved', 'Home Service', '2026-03-15 09:27:31', 0, 0, 1, NULL, NULL, NULL),
(24, 21, '2026-03-24', '9:00 AM', 'Post-Surgery Care', NULL, '', 'Penelope', 'Sablayan', '', '2004-02-09', 22, 'Female', '09123456789', '', 'marizsabaterbata@gmail.com', 'N/A, Zone 3, Barangay 124, Lanigay, Albay', 'Approved', 'Home Service', '2026-03-15 14:00:18', 0, 0, 1, NULL, NULL, NULL),
(25, 34, '2026-03-16', '9:00 AM', 'General Check-up', NULL, '', 'Rose Angela', 'Canon', '', '2005-10-26', 20, 'Female', '09357356284', '', 'roseangelamarie05@gmail.com', 'N/A, Zone 3, Gamot, Polangui, Albay', 'Approved', 'Home Service', '2026-03-15 14:29:55', 0, 0, 1, NULL, NULL, NULL),
(26, 21, '2026-03-22', '8:00 AM', 'General Check-up', NULL, '', 'Penelope', 'Sablayan', '', '2006-02-14', 20, 'Female', '09123456789', '', 'pen@gmail.com', 'N/A, zone 5, napo, polangui, albay', 'Pending', 'Home Service', '2026-03-21 17:59:51', 0, 0, 0, NULL, NULL, NULL),
(27, 21, '2026-03-23', '8:00 AM', 'Blood Collection / Lab Test', NULL, '', 'Penelope', 'Sablayan', '', '2005-05-17', 20, 'Female', '09123456789', '', 'pen@gmail.com', 'n/a, zone 5, napo, polangui, albay', 'Approved', 'Home Service', '2026-03-21 18:10:16', 0, 0, 1, NULL, NULL, NULL),
(28, 21, '2026-03-31', '8:00 AM', 'Wound Care / Dressing', 'Polangui Branch', '', 'Mariz', 'Bata', 'Sabater', '2004-11-21', 21, 'Female', '09614417105', '', 'mrzbt.21@gmail.com', 'n/a, zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-24 08:50:53', 0, 0, 0, NULL, NULL, NULL),
(29, 37, '2026-03-31', '10:00 AM', 'WBC Count', 'Polangui Branch', '', 'Mariz', 'Bata', 'S.', '2005-11-21', 20, 'Female', '09994719859', '', 'mariza02105@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-29 12:13:39', 0, 0, 0, NULL, NULL, NULL),
(30, 37, '2026-04-02', '8:00 AM', 'Urinalysis', 'Ligao Branch', '', 'Mariz', 'Bata', 'S.', '2005-11-21', 20, 'Female', '09994719859', '', 'mariza02105@gmail.com', 'N/A, Zone 1, Obaliw-Rinas, Oas, Albay', 'Pending', 'Home Service', '2026-03-30 10:55:09', 0, 0, 0, NULL, NULL, NULL),
(31, 40, '2026-04-03', '10:00 AM', 'Urinalysis', 'Tabaco Branch', '', 'Charls', 'Barquin', 'Emil C.', '2005-05-26', 20, 'Male', '09564231532', '', 'charlsbarquin2@gmail.com', 'N/A, Moran Estate Subdivision, Matagbac, Tabaco, Albay', 'Approved', 'Home Service', '2026-03-30 14:48:47', 0, 0, 1, NULL, NULL, NULL),
(32, 40, '2026-04-03', '9:00 AM', 'CBC, Urinalysis', 'Tabaco Branch', '', 'Charls', 'Barquin', 'Emil C.', '2005-05-26', 20, 'Male', '09564231532', '', 'charlsbarquin2@gmail.com', 'N/A, Moran Estate, Matagbac, Tabaco, Albay', 'Approved', 'Home Service', '2026-03-30 20:00:09', 0, 0, 1, NULL, NULL, NULL),
(33, 40, '2026-04-01', '11:00 AM', 'WBC Count, ECG', 'Polangui Branch', '', 'Charls', 'Barquin', 'Emil C.', '2005-05-26', 20, 'Male', '09564231532', '', 'charlsbarquin2@gmail.com', 'N/A, Moran Estate Subdivision, Matagbac, Tabaco, Albay', 'Approved', 'Home Service', '2026-03-30 21:04:41', 0, 0, 1, NULL, NULL, NULL),
(34, 40, '2026-04-06', '8:00 AM', 'CBC, Urinalysis', 'Tabaco Branch', '', 'Charls', 'Barquin', 'Emil C.', '2005-05-26', 20, 'Male', '09564231532', '', 'charlsbarquin2@gmail.com', 'Blk 50, Lot basta, Moran Estate Subdivision, Matagbac, Tabaco, Albay', 'Approved', 'Home Service', '2026-04-01 09:55:10', 0, 0, 1, NULL, NULL, NULL),
(35, 40, '2026-04-02', '10:00 AM', 'CBC, Platelet Count, WBC Count', 'Tabaco Branch', '', 'Charls', 'Barquin', 'Emil C.', '2005-05-26', 20, 'Male', '09564231532', '', 'charlsbarquin2@gmail.com', 'Blk 50, Moran Sstate Subdivision, Matagbac, Tabaco, Albay', 'Approved', 'Home Service', '2026-04-01 10:42:11', 0, 0, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reminder_logs`
--

CREATE TABLE `reminder_logs` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `appointment_table` varchar(60) NOT NULL DEFAULT 'home_service_appointments',
  `reminder_type` varchar(30) NOT NULL DEFAULT 'general',
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `message`, `rating`, `is_approved`, `created_at`) VALUES
(1, 'Charmie Dela Paz', 'My home service booking experience became more convenient and efficient. Plus, the staffs are really accommodating and gentle.', 1, 1, '2026-03-08 20:01:48'),
(2, 'Juan Dela Cruz', 'The home service is great, the team arrived on time.', 5, 1, '2026-03-08 20:36:00'),
(3, 'Mark Reyes', 'The staffs are well trained and accomodating', 5, 1, '2026-03-08 22:31:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `sex` char(1) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('patient') NOT NULL DEFAULT 'patient',
  `age` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `email`, `password`, `address`, `sex`, `contact_number`, `created_at`, `role`, `age`, `dob`) VALUES
(1, 'Admin', 'admin@gmailcom', '$2y$10$I6pu.kR2TSAT6CMQnsnXEOe8EN9TlNRSrOHXgOcEtZGcPyjeCAioO', 'Alomon, Polangui Albay', 'F', '09123456789', '2025-09-11 06:43:56', 'patient', NULL, NULL),
(2, 'Jaennie Fetil', 'jaenniecyrellfetil@gmail.com', '$2y$10$41cMdTydN2BEm/8ljcYw3.dXEQxyyExpN8hCqNAj/z3VZP8qW5Y3a', 'Alomon, Polangui Albay', 'F', '09123456788', '2025-09-11 07:23:33', 'patient', NULL, NULL),
(3, 'Patient One', 'patientone@gmail.com', '$2y$10$H5Siwx/pQ7T7ADgC6QSgJ.YbJEPctbTKxUkuqrnOBG1capdZvP2FW', 'Polangui,Albay', 'M', '09987456123', '2025-09-12 15:03:51', 'patient', NULL, NULL),
(4, 'Mariz Bata', 'marizbata14@gmail.com', '$2y$10$EYz1pTcA9FmgzMjQskwsHu1OMAQGjblp5LlFD7VpeIsTUYa647i8K', 'P1, Obaliw-Rinas, Oas, Albay', 'F', '09999999999', '2025-09-18 04:05:33', 'patient', NULL, NULL),
(5, 'Patient Two', 'patient2@gmail.com', '$2y$10$HjOTvFfvSb3sS03N9s67oO6a.Z.wqlw6mpxFauG9G0dUC2/EEKdyK', 'P2, Obaliw-Rinas, Oas, Albay', 'F', '09123456789', '2025-09-22 03:47:55', 'patient', NULL, NULL),
(6, 'Shanley Resentes', 'shanley19@gmail.com', '$2y$10$dBgZZW1w1iXnOBcHqk2xUuEE1RjX7Yeu/lBzDBErD7clNJ94OGIvW', 'Bongoran, Oas, Albay', 'F', '09075193156', '2025-09-23 04:13:06', 'patient', NULL, NULL),
(7, 'Penelope Sablayan', 'pen@gmail.com', '$2y$10$grl7xew0muPxPCbjDZR8S.2VkyhfjHQF6GKzloeWaCmSkPY17dObC', 'Napo, Polangui, Albay', 'F', '09123456789', '2025-12-09 02:48:20', 'patient', NULL, NULL),
(8, 'Shanley', 'shanleyresentes19@gmail.com', '$2y$10$LnjxTIjB440VjV.BwhDsWuW7eeZwts6.3cRf6aAvwaiwVlkIGJaKm', 'Bongoran, Oas Albay', 'F', '0907 519 31', '2025-12-20 02:37:06', 'patient', NULL, NULL),
(9, 'Resentes', 'rsnts@gmail.com', '$2y$10$bV6FmoSiXnYAIeUCPcluWO25LuPG2UjsADRsadYNCy5JoFW71IpY6', 'Bongoran', 'F', '09008572196', '2025-12-20 02:50:02', 'patient', NULL, NULL),
(11, 'Jaennie Fetil', 'jaenniefetil@gmail.com', '$2y$10$G73y/tSbsI8TBy19XhHtb.BMiTr/hfK1x/Qc8cZp3M8s8NFInxaa2', 'Alomon, Polangui Albay', 'F', '09100345388', '2025-12-20 03:06:17', 'patient', NULL, NULL),
(12, 'celly rave', 'clrv@gmail.com', '$2y$10$0AWuZ8rpWMdW1OKow3atFOHfJh7WBD.YVAWHL3UNOupHwUNayqXVa', 'bu polangui', 'F', '09123456789', '2025-12-20 03:10:00', 'patient', NULL, NULL),
(13, 'Admin', 'admin1@gmail.com', '$2y$10$kci95OeatvfvFxCgRmY4ZesfBcGX3pdSZGin/Q5vZbzSduSzDDLiy', 'Alomon', 'F', '09876543212', '2025-12-20 07:33:21', 'patient', NULL, NULL),
(14, 'Maria B.  Reyes', 'mariarys.01@gmail.com', '$2y$10$cxDYZv0h6cM3IKSdLr6Dme0NFiLMZmmIje1HBEYXyMl4PhuWdEIJu', 'Centro Occidental, Polangui, Albay', 'F', '09641257983', '2026-03-07 11:24:21', 'patient', NULL, NULL),
(15, 'Marites Bata', 'mrtsbata@gmail.com', '$2y$10$SwOZw/MfxlwcJ6stwuFJHuXpF8xd91wzEBi9LA160r8OW8SSFSnG6', 'P1 Obaliw-Rinas, Oas, Albay', 'F', '09123456789', '2026-03-08 06:58:33', 'patient', NULL, NULL),
(16, 'Charmie Dela Paz', 'cdp@gmail.com', '$2y$10$Hnwk5c6/ZlB1N4bAihMmRuePrVAHCy5rGFleuEXjCc6KYQYCRLFv2', 'Obaliw', 'F', '09123456789', '2026-03-08 08:52:40', 'patient', NULL, NULL),
(17, 'AdminOne', 'adminone@gmail.com', '$2y$10$Mn8GkGJUpSFdN7RHHHfK1etPOaaeIFQdmrCz.1klaHyIepRcg4L92', '', 'F', '09123456789', '2026-03-08 12:04:09', 'patient', NULL, NULL),
(21, 'Mariz Sabater Bata', 'mrzbt.21@gmail.com', '$2y$10$FKMk.0vthSoGhyyPzbFhq.teSb4e5ii9CSCzOgp61QNEKGZIMxQ2y', 'Obaliw-Rinas, Oas, Albay', 'F', '09614417105', '2026-03-08 14:19:19', 'patient', NULL, NULL),
(32, 'Admin Two', 'admintwo@gmail.com', '$2y$10$a.hdI6IaOuVN4kc6RQRF.usQFSHrA9F/iJa/xbQufxBTwP8RKnTZK', '', 'F', '09123467532', '2026-03-09 07:59:20', 'patient', NULL, NULL),
(33, 'Mary Rellon', 'maryrellon@gmail.com', '$2y$10$eI7YsC8bWSGkHHEGZ0GM4upUJbzWv7gTL2F6YC8QKP/x7OQzAMjZG', 'Napo, Polangui, Albay', 'F', '09987563241', '2026-03-12 15:08:42', 'patient', 20, NULL),
(34, 'Rose Angela Canon', 'roseangelamarie05@gmail.com', '$2y$10$ytEmcuZMobYdggkTXwPV7uft0qgr1KdTrWGPoFkCqbfkI8F3pEElm', 'Gamot, Polangui, Albay', 'F', '09452376676', '2026-03-15 06:21:05', 'patient', 20, NULL),
(35, 'Penelope Sablayan', 'penelopesablayan@gmail.com', '$2y$10$OgBf2XMgiOicJmvkz44Dn.TanFw4ZKICbJfC0gzPoAoNhRGNsK1ky', 'Napo, Polangui, Albay', 'F', '09123456789', '2026-03-15 06:26:14', 'patient', NULL, NULL),
(36, 'Armando Bata', 'armandobata@gmail.com', '$2y$10$Jfl4q/dy6i3f4/5SIgVn1eWnmX0fTgteEcHavPrRrBfKE41NDELJq', 'Obaliw-Rinas, Oas, Albay', 'M', '09994719859', '2026-03-20 06:04:51', 'patient', NULL, NULL),
(37, 'Mariz S. Bata', 'mariza02105@gmail.com', '$2y$10$qqA/Bdd3CcTK6A.RzCvtF.1e2xiHCYcPo9ABLu6to8UAs.0cLD6kW', 'Obaliw-Rinas, Oas, Albay', 'F', '09994719859', '2026-03-29 04:11:26', 'patient', NULL, '2005-11-21'),
(38, 'Maria Mercedes', 'mariamercedes@gmail.com', '$2y$10$jRaYi5TOc1MPpS2.dC1mauJilB97jfN3P8C1oySTNDPj1krzGhPYa', 'Zone 1 Lanigay, Polangui, Albay', 'F', '09876543212', '2026-03-30 05:15:59', 'patient', NULL, NULL),
(39, 'Mimoe Reyes', 'mimoereyes@gmail.com', '$2y$10$JkYBdbEa0Hn1pKS8y6DMOO/587kxikHpOcR4TFBYXnj/VScONuFkS', 'Zone 1 Lanigay, Polangui, Albay', 'M', '09876543212', '2026-03-30 05:19:54', 'patient', NULL, NULL),
(40, 'Charls Emil C. Barquin', 'charlsbarquin2@gmail.com', '$2y$10$sO8X/KHpP3Yu.xFVN/k5V.BPscgZ7cM8N2QPSbwii0k2E.OzJq3oS', 'Tabaco City', 'F', '09564231532', '2026-03-30 06:36:37', 'patient', NULL, '2005-05-26'),
(41, 'Charls Barquin', 'charlsemilbarquin@gmail.com', '$2y$10$RxmSUDT/Qk.Y.U3MPwVV5uwARWY3.rFrNw6zJ1XfDkhW0d/coaNGm', 'Tabaco City', 'M', '09994719859', '2026-03-30 12:23:36', 'patient', NULL, '2005-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `source_type` varchar(40) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `category` varchar(40) NOT NULL DEFAULT 'general',
  `type` varchar(40) NOT NULL DEFAULT 'general',
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `email_sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `appointment_id`, `type`, `title`, `message`, `is_read`, `created_at`, `email_sent`) VALUES
(1, 17, 5, 'tomorrow', '🔔 Appointment Tomorrow', 'You have a <strong>Blood Collection / Lab Test</strong> appointment <strong>tomorrow (March 9, 2026) at 10:00 AM</strong>. Make sure you are prepared!', 1, '2026-03-08 22:11:04', 0),
(2, 21, 6, 'tomorrow', '🔔 Appointment Tomorrow', 'You have a <strong>General Check-up</strong> appointment <strong>tomorrow (March 9, 2026) at 11:00 AM</strong>. Make sure you are prepared!', 1, '2026-03-08 22:21:30', 0),
(3, 21, 7, '3day', '🗓️ Upcoming in 3 Days', 'Reminder: You have a <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 11, 2026 at 9:00 AM</strong>. Please make sure your schedule is clear.', 1, '2026-03-08 22:22:31', 0),
(9, 21, 6, 'today', '📅 Appointment Today!', 'Your <strong>General Check-up</strong> is scheduled <strong>today at 11:00 AM</strong>. Please arrive 10–15 minutes early and bring a valid ID.', 1, '2026-03-09 09:43:13', 0),
(10, 21, 9, 'tomorrow', '🔔 Appointment Tomorrow', 'You have a <strong>Blood Collection / Lab Test</strong> appointment <strong>tomorrow (March 10, 2026) at 9:00 AM</strong>. Make sure you are prepared!', 1, '2026-03-09 09:43:20', 0),
(11, 21, 10, 'tomorrow', '🔔 Appointment Tomorrow', 'You have a <strong>Wound Care / Dressing</strong> appointment <strong>tomorrow (March 10, 2026) at 9:00 AM</strong>. Make sure you are prepared!', 1, '2026-03-09 09:43:27', 0),
(12, 21, 11, 'tomorrow', '🔔 Appointment Tomorrow', 'You have a <strong>Post-Surgery Care</strong> appointment <strong>tomorrow (March 10, 2026) at 10:00 AM</strong>. Make sure you are prepared!', 1, '2026-03-09 09:43:35', 0),
(13, 21, 8, '3day', '🗓️ Upcoming in 3 Days', 'Reminder: You have a <strong>General Check-up</strong> appointment on <strong>March 12, 2026 at 9:00 AM</strong>. Please make sure your schedule is clear.', 1, '2026-03-09 09:43:41', 0),
(14, 21, 12, '3day', '🗓️ Upcoming in 3 Days', 'Reminder: You have a <strong>COVID-19 Monitoring</strong> appointment on <strong>March 12, 2026 at 11:00 AM</strong>. Please make sure your schedule is clear.', 1, '2026-03-09 09:43:47', 0),
(15, 21, 8, 'today', '📅 Appointment Today!', 'Your <strong>General Check-up</strong> is scheduled <strong>today at 9:00 AM</strong>. Please arrive 10–15 minutes early and bring a valid ID.', 1, '2026-03-12 20:56:09', 0),
(16, 21, 12, 'today', '📅 Appointment Today!', 'Your <strong>COVID-19 Monitoring</strong> is scheduled <strong>today at 11:00 AM</strong>. Please arrive 10–15 minutes early and bring a valid ID.', 1, '2026-03-12 20:56:49', 0),
(17, 21, 12, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>COVID-19 Monitoring</strong> appointment on <strong>March 12, 2026 at 11:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 1, '2026-03-12 21:47:11', 0),
(18, 21, 11, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Post-Surgery Care</strong> appointment on <strong>March 10, 2026 at 10:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 1, '2026-03-12 21:47:11', 0),
(19, 21, 10, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Wound Care / Dressing</strong> appointment on <strong>March 10, 2026 at 9:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 1, '2026-03-12 21:47:11', 0),
(20, 21, 9, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 10, 2026 at 9:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-12 21:47:11', 0),
(21, 21, 8, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>General Check-up</strong> appointment on <strong>March 12, 2026 at 9:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-12 21:47:11', 0),
(22, 21, 7, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 11, 2026 at 9:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-12 21:47:11', 0),
(23, 21, 6, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>General Check-up</strong> appointment on <strong>March 9, 2026 at 11:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-12 21:47:11', 0),
(24, 21, 13, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 16, 2026 at 9:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-12 21:51:17', 0),
(25, 21, 13, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 16, 2026 at 9:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-12 21:52:39', 0),
(26, 21, 14, 'confirmed', '⏳ Appointment Pending Confirmation', 'Your <strong>Wound Care / Dressing</strong> appointment on <strong>March 13, 2026 at 11:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-12 22:12:22', 0),
(27, 21, 15, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Post-Surgery Care</strong> appointment on <strong>March 17, 2026 at 9:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-12 22:32:04', 0),
(28, 21, 14, 'tomorrow', '🔔 Appointment Tomorrow', 'Your confirmed <strong>Wound Care / Dressing</strong> appointment is <strong>tomorrow (March 13, 2026) at 11:00 AM</strong>. Make sure you are prepared!', 0, '2026-03-12 22:32:04', 1),
(29, 21, 15, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Post-Surgery Care</strong> appointment on <strong>March 17, 2026 at 9:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-12 22:34:52', 1),
(30, 33, 16, 'confirmed', '⏳ Appointment Pending Confirmation', 'Your <strong>General Check-up</strong> appointment on <strong>March 14, 2026 at 10:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-13 10:20:59', 1),
(31, 33, 16, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>General Check-up</strong> appointment on <strong>March 14, 2026 at 10:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-13 10:21:54', 1),
(32, 33, 17, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 15, 2026 at 9:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-13 11:15:29', 0),
(33, 33, 16, 'tomorrow', '🔔 Appointment Tomorrow', 'Your confirmed <strong>General Check-up</strong> appointment is <strong>tomorrow (March 14, 2026) at 10:00 AM</strong>. Make sure you are prepared!', 1, '2026-03-13 11:15:36', 1),
(34, 33, 17, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 15, 2026 at 9:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-13 11:17:31', 1),
(35, 33, 18, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Post-Surgery Care</strong> appointment on <strong>March 16, 2026 at 11:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 1, '2026-03-13 11:29:05', 1),
(36, 33, 18, '3day', '🗓️ Appointment in 3 Days', 'Reminder: Your confirmed <strong>Post-Surgery Care</strong> appointment is on <strong>March 16, 2026 at 11:00 AM</strong>. Please make sure your schedule is clear.', 0, '2026-03-13 11:40:21', 1),
(37, 33, 19, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Elderly Care</strong> appointment on <strong>March 14, 2026 at 1:00 PM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-13 12:49:39', 0),
(38, 33, 19, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Elderly Care</strong> appointment on <strong>March 14, 2026 at 1:00 PM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 1, '2026-03-13 12:50:13', 0),
(39, 33, 19, 'tomorrow', '🔔 Appointment Tomorrow', 'Your confirmed <strong>Elderly Care</strong> appointment is <strong>tomorrow (March 14, 2026) at 1:00 PM</strong>. Make sure you are prepared!', 0, '2026-03-13 12:52:05', 1),
(40, 21, 20, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>COVID-19 Monitoring</strong> appointment on <strong>March 20, 2026 at 9:00 AM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-13 15:00:55', 0),
(41, 21, 14, 'today', '📅 Appointment Today!', 'Your <strong>Wound Care / Dressing</strong> is scheduled <strong>today at 11:00 AM</strong>. Please arrive 10–15 minutes early and bring a valid ID.', 0, '2026-03-13 15:00:55', 1),
(42, 21, 13, '3day', '🗓️ Appointment in 3 Days', 'Reminder: Your confirmed <strong>Blood Collection / Lab Test</strong> appointment is on <strong>March 16, 2026 at 9:00 AM</strong>. Please make sure your schedule is clear.', 0, '2026-03-13 15:01:01', 1),
(43, 21, 20, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>COVID-19 Monitoring</strong> appointment on <strong>March 20, 2026 at 9:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-13 15:02:53', 1),
(44, 33, 21, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 14, 2026 at 1:00 PM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-13 15:06:51', 0),
(45, 33, 21, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 14, 2026 at 1:00 PM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-13 15:07:17', 1),
(46, 33, 22, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 14, 2026 at 3:00 PM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-13 15:25:08', 0),
(47, 33, 21, 'tomorrow', '🔔 Appointment Tomorrow', 'Your confirmed <strong>Blood Collection / Lab Test</strong> appointment is <strong>tomorrow (March 14, 2026) at 1:00 PM</strong>. Make sure you are prepared!', 0, '2026-03-13 15:25:08', 1),
(48, 33, 22, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 14, 2026 at 3:00 PM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-13 15:26:13', 1),
(49, 33, 22, 'tomorrow', '🔔 Appointment Tomorrow', 'Your confirmed <strong>Blood Collection / Lab Test</strong> appointment is <strong>tomorrow (March 14, 2026) at 3:00 PM</strong>. Make sure you are prepared!', 1, '2026-03-13 15:26:45', 1),
(50, 33, 17, 'today', '📅 Appointment Today!', 'Your <strong>Blood Collection / Lab Test</strong> is scheduled <strong>today at 9:00 AM</strong>. Please arrive 10–15 minutes early and bring a valid ID.', 0, '2026-03-15 09:23:25', 1),
(51, 33, 18, 'tomorrow', '🔔 Appointment Tomorrow', 'Your confirmed <strong>Post-Surgery Care</strong> appointment is <strong>tomorrow (March 16, 2026) at 11:00 AM</strong>. Make sure you are prepared!', 0, '2026-03-15 09:23:31', 1),
(52, 33, 23, 'pending', '⏳ Appointment Pending Confirmation', 'Your <strong>IV Therapy / Infusion</strong> appointment on <strong>March 17, 2026 at 4:00 PM</strong> has been received and is <strong>awaiting admin confirmation</strong>. You will be notified once it is approved.', 0, '2026-03-15 09:27:41', 0),
(53, 33, 23, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>IV Therapy / Infusion</strong> appointment on <strong>March 17, 2026 at 4:00 PM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-15 09:28:51', 1),
(54, 21, 13, 'tomorrow', '🔔 Appointment Tomorrow', 'Your confirmed <strong>Blood Collection / Lab Test</strong> appointment is <strong>tomorrow (March 16, 2026) at 9:00 AM</strong>. Make sure you are prepared!', 0, '2026-03-15 09:50:50', 1),
(55, 21, 3, 'corp_pending', '⏳ Corporate Inquiry Received', 'Your corporate inquiry for <strong>Drug Testing (DOLE-compliant)</strong> on behalf of <strong>J&T Express</strong> has been received and is <strong>awaiting review</strong>. We will contact you within 1–2 business days.', 0, '2026-03-15 10:12:00', 0),
(56, 21, 3, 'corp_confirmed', '✅ Corporate Inquiry In Progress', 'Your corporate inquiry for <strong>Drug Testing (DOLE-compliant)</strong> on behalf of <strong>J&T Express</strong> has been reviewed and is now <strong>In Progress</strong>. A clinic staff member will contact you shortly with further details.', 0, '2026-03-15 10:12:36', 1),
(57, 21, 24, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Post-Surgery Care</strong> appointment on <strong>March 24, 2026 at 9:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-15 14:00:46', 1),
(58, 34, 25, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>General Check-up</strong> appointment on <strong>March 16, 2026 at 9:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-15 14:30:22', 1),
(59, 32, 4, 'corp_pending', '⏳ Corporate Inquiry Received', 'Your corporate inquiry for <strong>Annual Physical Examination (APE)</strong> on behalf of <strong>J&T Express</strong> has been received and is <strong>awaiting review</strong>. We will contact you within 1–2 business days.', 0, '2026-03-15 15:08:14', 0),
(60, 32, 4, 'corp_confirmed', '✅ Corporate Inquiry In Progress', 'Your corporate inquiry for <strong>Annual Physical Examination (APE)</strong> on behalf of <strong>J&T Express</strong> has been reviewed and is now <strong>In Progress</strong>. A clinic staff member will contact you shortly.', 0, '2026-03-15 15:09:51', 1),
(61, 32, 5, 'corp_pending', '⏳ Corporate Inquiry Received', 'Your corporate inquiry for <strong>Occupational Health Services</strong> on behalf of <strong>J&T Express</strong> has been received and is <strong>awaiting review</strong>. We will contact you within 1–2 business days.', 0, '2026-03-15 15:37:07', 0),
(62, 21, 24, '3day', '🗓️ Appointment in 3 Days', 'Reminder: Your confirmed <strong>Post-Surgery Care</strong> appointment is on <strong>March 24, 2026 at 9:00 AM</strong>. Please make sure your schedule is clear.', 0, '2026-03-21 17:59:59', 0),
(63, 21, 27, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Blood Collection / Lab Test</strong> appointment on <strong>March 23, 2026 at 8:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 0, '2026-03-22 10:50:01', 1),
(64, 21, 27, 'today', '📅 Appointment Today!', 'Your <strong>Blood Collection / Lab Test</strong> is scheduled <strong>today at 8:00 AM</strong>. Please arrive 10–15 minutes early and bring a valid ID.', 0, '2026-03-23 23:18:26', 0),
(65, 21, 24, 'tomorrow', '🔔 Appointment Tomorrow', 'Your confirmed <strong>Post-Surgery Care</strong> appointment is <strong>tomorrow (March 24, 2026) at 9:00 AM</strong>. Make sure you are prepared!', 0, '2026-03-23 23:18:34', 0),
(66, 40, 32, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>CBC, Urinalysis</strong> appointment on <strong>April 3, 2026 at 9:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 1, '2026-03-30 20:25:05', 1),
(67, 40, 33, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>WBC Count, ECG</strong> appointment on <strong>April 1, 2026 at 11:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 1, '2026-03-30 21:05:37', 1),
(68, 40, 33, 'today', '📅 Appointment Today!', 'Your <strong>WBC Count, ECG</strong> is scheduled <strong>today at 11:00 AM</strong>. Please arrive 10–15 minutes early and bring a valid ID.', 1, '2026-04-01 09:55:18', 0),
(69, 40, 34, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>CBC, Urinalysis</strong> appointment on <strong>April 6, 2026 at 8:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 1, '2026-04-01 09:57:34', 0),
(70, 40, 31, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>Urinalysis</strong> appointment on <strong>April 3, 2026 at 10:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 1, '2026-04-01 10:39:43', 1),
(71, 40, 35, 'confirmed', '✅ Appointment Confirmed!', 'Your <strong>CBC, Platelet Count, WBC Count</strong> appointment on <strong>April 2, 2026 at 10:00 AM</strong> has been <strong>confirmed</strong> by our team. We look forward to seeing you!', 1, '2026-04-01 10:42:59', 1),
(72, 40, 35, 'tomorrow', '🔔 Appointment Tomorrow', 'Your confirmed <strong>CBC, Platelet Count, WBC Count</strong> appointment is <strong>tomorrow (April 2, 2026) at 10:00 AM</strong>. Make sure you are prepared!', 1, '2026-04-01 10:43:39', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `corporate_inquiries`
--
ALTER TABLE `corporate_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_otps`
--
ALTER TABLE `email_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `home_service_appointments`
--
ALTER TABLE `home_service_appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

-- Indexes for table `reminder_logs`
--
ALTER TABLE `reminder_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reminder` (`appointment_id`,`appointment_table`,`reminder_type`);

--
-- Indexes for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_appointment` (`appointment_id`),
  ADD KEY `idx_user_status` (`user_id`,`status`);

-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_read` (`user_id`,`is_read`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `corporate_inquiries`
--
ALTER TABLE `corporate_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `email_otps`
--
ALTER TABLE `email_otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `home_service_appointments`
--
ALTER TABLE `home_service_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

-- AUTO_INCREMENT for table `reminder_logs`
--
ALTER TABLE `reminder_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `home_service_appointments`
--
ALTER TABLE `home_service_appointments`
  ADD CONSTRAINT `home_service_appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
