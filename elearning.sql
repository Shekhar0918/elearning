-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2018 at 03:29 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_programs`
--

CREATE TABLE `enrolled_programs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `program_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrolled_programs`
--

INSERT INTO `enrolled_programs` (`id`, `user_id`, `program_id`, `created_at`, `updated_at`) VALUES
(1, 197, '1', '2018-03-09 08:44:33', '2018-03-11 16:13:31'),
(2, 197, '2', '2018-03-09 08:44:33', '2018-03-11 16:13:35'),
(3, 197, '3', '2018-03-09 08:46:15', '2018-03-11 16:13:38'),
(4, 197, '4', '2018-03-09 08:46:15', '2018-03-11 16:13:41'),
(5, 197, '5', '2018-03-09 08:46:36', '2018-03-11 16:13:44'),
(6, 197, '6', '2018-03-09 08:46:36', '2018-03-11 16:13:47'),
(7, 174, '1', '2018-03-09 08:47:05', '2018-03-09 08:47:05'),
(8, 174, '4', '2018-03-09 08:47:05', '2018-03-09 08:51:37'),
(9, 174, '2', '2018-03-09 08:47:32', '2018-03-09 08:47:32'),
(10, 174, '3', '2018-03-09 08:47:32', '2018-03-09 08:47:32'),
(11, 174, '5', '2018-03-09 08:51:59', '2018-03-09 08:51:59'),
(12, 174, '6', '2018-03-09 08:51:59', '2018-03-09 08:51:59'),
(14, 207, '1', '2018-03-17 10:48:23', '2018-03-17 10:48:23'),
(15, 207, '1', '2018-03-17 10:52:11', '2018-03-17 10:52:11'),
(16, 207, '3', '2018-03-17 10:55:50', '2018-03-17 10:55:50'),
(17, 207, '3', '2018-03-17 11:05:29', '2018-03-17 11:05:29'),
(18, 208, '5', '2018-03-17 12:27:26', '2018-03-17 12:27:26'),
(19, 208, '4', '2018-03-17 12:27:45', '2018-03-17 12:27:45'),
(20, 207, '4', '2018-03-17 12:44:00', '2018-03-17 12:44:00'),
(21, 207, '4', '2018-03-21 04:46:49', '2018-03-21 04:46:49'),
(22, 207, '5', '2018-03-21 04:46:51', '2018-03-21 04:46:51'),
(23, 207, '1', '2018-03-22 18:28:32', '2018-03-22 18:28:32'),
(24, 207, '2', '2018-03-22 18:28:33', '2018-03-22 18:28:33'),
(25, 207, '3', '2018-03-22 18:28:33', '2018-03-22 18:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `facebook_users`
--

CREATE TABLE `facebook_users` (
  `id` int(11) NOT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facebook_users`
--

INSERT INTO `facebook_users` (`id`, `facebook_id`, `name`, `email`, `gender`, `created_at`, `updated_at`) VALUES
(79, NULL, 'Shashi Shekhar', 'shekharshashi0989@gmail.com', NULL, '2018-03-12 04:35:49', '2018-03-12 04:35:49'),
(80, NULL, NULL, 'shashi.shekhar0918@gmail.com', NULL, '2018-03-17 12:26:44', '2018-03-17 12:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `google_users`
--

CREATE TABLE `google_users` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `google_id` varchar(25) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `verification_status` tinyint(4) NOT NULL DEFAULT '0',
  `verification_code` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `google_users`
--

INSERT INTO `google_users` (`id`, `created_at`, `updated_at`, `name`, `google_id`, `email`, `gender`, `verification_status`, `verification_code`) VALUES
(188, '2018-03-12 04:36:53', '2018-03-12 04:36:53', NULL, NULL, 'shekharshashi0989@gmail.com', NULL, 0, NULL),
(189, '2018-03-17 12:25:56', '2018-03-17 12:25:56', 'Shashi Shekhar', NULL, 'shashi.shekhar0918@gmail.com', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `program_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `chapters` text,
  `content` text,
  `duration` int(11) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `program_name`, `category`, `chapters`, `content`, `duration`, `cost`, `updated_at`, `created_at`, `type`) VALUES
(1, 'Certified Scrum Master', 'Classroom Programs', NULL, 'https://www.youtube.com/embed/cTLU4BbYLUE', 60, 1000, '2018-03-12 03:22:47', '2018-03-09 08:33:54', 'free'),
(2, 'Safe Agilist', 'Classroom Programs', NULL, 'https://www.youtube.com/embed/AxOKoG58gNE', 30, 1500, '2018-03-12 03:22:51', '2018-03-09 08:33:54', 'free'),
(3, 'Kanban System Training', 'Classroom Programs', NULL, 'https://www.youtube.com/embed/GZH5qC2dYTg', 45, 2000, '2018-03-09 08:38:34', '2018-03-09 08:35:55', NULL),
(4, 'PMP', 'Online Programs', NULL, 'https://www.youtube.com/embed/CxzU5RgyejI', 7, 750, '2018-03-09 08:38:38', '2018-03-09 08:35:55', NULL),
(5, 'PMI ACP', 'Online Programs', NULL, 'https://www.youtube.com/embed/eAfOE4coRh8', 10, 1200, '2018-03-09 08:38:42', '2018-03-09 08:37:30', NULL),
(6, 'PMI PBA', 'Online Programs', NULL, 'https://www.youtube.com/embed/4c4A6pjk3Hk', 90, 6000, '2018-03-09 08:38:49', '2018-03-09 08:37:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `city` text,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `business_email` varchar(255) DEFAULT NULL,
  `access_type` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `login_source` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `google_user_id` varchar(255) DEFAULT NULL,
  `facebook_user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `designation`, `organization`, `city`, `country`, `phone`, `business_email`, `access_type`, `password`, `login_source`, `created_at`, `updated_at`, `google_user_id`, `facebook_user_id`) VALUES
(207, 'shekharshashi0989@gmail.com', 'Shashi', 'desgination 1', 'Organization 1', 'city 1', 'country 1', '8123456345', 'abc@gmail.com', 'student', NULL, 'facebook', '2018-03-12 04:35:49', '2018-03-12 04:36:53', '188', '79'),
(208, 'shashi.shekhar0918@gmail.com', 'Shashi', 'Software engg', 'Company', 'Bangalre', 'India', '9739085285', 'shekhar.shashi61@gmail.com', 'student', NULL, 'google', '2018-03-17 12:25:56', '2018-03-17 12:26:44', '189', '80'),
(209, 'admin@elearning.com', 'Admin', 'Administrator', 'iZenbridge', 'Bangalore', 'India', NULL, NULL, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', NULL, '2018-03-23 18:44:57', '2018-03-23 18:46:08', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enrolled_programs`
--
ALTER TABLE `enrolled_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facebook_users`
--
ALTER TABLE `facebook_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `google_users`
--
ALTER TABLE `google_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enrolled_programs`
--
ALTER TABLE `enrolled_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `facebook_users`
--
ALTER TABLE `facebook_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `google_users`
--
ALTER TABLE `google_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
