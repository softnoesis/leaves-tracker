-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 09:48 AM
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
-- Database: `adminsns_leaves`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `total_duration` varchar(255) NOT NULL,
  `month_year` varchar(255) NOT NULL,
  `employee_code` varchar(255) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `p` int(11) NOT NULL,
  `a` int(11) NOT NULL,
  `h` int(11) NOT NULL,
  `h_p` int(11) NOT NULL,
  `w_o` int(11) NOT NULL,
  `w_o_p` int(11) NOT NULL,
  `p_l` int(11) NOT NULL,
  `c_l` int(11) NOT NULL,
  `s_l` int(11) NOT NULL,
  `total_ot` int(11) NOT NULL,
  `t_duration` int(11) NOT NULL,
  `early_by` int(11) NOT NULL,
  `late_by` int(11) NOT NULL,
  `total_leave` int(11) NOT NULL,
  `pay_days` int(11) NOT NULL,
  `total_present` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `company_name` varchar(250) NOT NULL,
  `website_name` varchar(250) DEFAULT NULL,
  `emailid` varchar(250) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_no` varchar(250) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company`
--

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `holidays`
--

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `leave_type` int(11) DEFAULT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `half_day` varchar(200) DEFAULT NULL,
  `full_day` varchar(200) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `reason` varchar(200) NOT NULL,
  `reject_reason` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `leave_status` int(11) NOT NULL COMMENT '0=pending leave1=approved leave2=rejected leave 3=cancel_leave',
  `approved_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leaves`
--

-- --------------------------------------------------------

--
-- Table structure for table `leaves_policy`
--

CREATE TABLE `leaves_policy` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `year` varchar(200) NOT NULL,
  `leavetyps` varchar(200) NOT NULL,
  `duration` int(11) NOT NULL,
  `crated_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leaves_policy`
--

-- --------------------------------------------------------

--
-- Table structure for table `leaves_type`
--

CREATE TABLE `leaves_type` (
  `id` int(11) NOT NULL,
  `leavetype` varchar(200) NOT NULL,
  `company_id` int(11) NOT NULL,
  `crated_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leaves_type`
--
 
-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `user_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `image` varchar(200) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `phone_no` varchar(200) DEFAULT NULL,
  `member_color` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `forgot_code` varchar(255) DEFAULT NULL,
  `isActive` int(11) DEFAULT NULL,
  `is_admin` int(11) DEFAULT NULL COMMENT '0-Member,1-Admin,2-HR,3-SuperAdmin'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `member`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2020-11-20 17:45:58', '2020-11-20 17:45:58'),
(2, 'HR Executive', '2020-11-20 17:45:58', '2020-11-20 17:45:58'),
(3, 'Member', '2020-11-20 17:46:57', '2020-11-20 17:46:57'),
(4, 'Super Admin', '2021-02-10 17:18:12', '2021-02-10 17:18:12'),
(5, 'Company', '2021-02-10 17:45:42', '2021-02-10 17:45:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves_policy`
--
ALTER TABLE `leaves_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves_type`
--
ALTER TABLE `leaves_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves_policy`
--
ALTER TABLE `leaves_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves_type`
--
ALTER TABLE `leaves_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
