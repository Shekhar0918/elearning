-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2018 at 04:44 AM
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
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `course_description` text,
  `course_overview` text,
  `price` varchar(255) DEFAULT NULL,
  `instructors` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `course_description`, `course_overview`, `price`, `instructors`, `created_at`, `last_updated_at`) VALUES
(4, 'Untitled Course 4', NULL, NULL, NULL, NULL, '2018-04-17 22:41:31', '2018-04-17 22:41:31'),
(5, 'Untitled Course 5', NULL, NULL, NULL, NULL, '2018-04-17 22:42:14', '2018-04-17 22:42:14'),
(6, 'Untitled Course 6', NULL, NULL, NULL, NULL, '2018-04-17 22:43:39', '2018-04-17 22:43:39'),
(7, 'Untitled Course 7', NULL, NULL, NULL, NULL, '2018-04-17 22:43:50', '2018-04-17 22:43:50'),
(8, 'Untitled Course 8', NULL, NULL, NULL, NULL, '2018-04-17 22:44:42', '2018-04-17 22:44:42'),
(9, 'Untitled Course 9', NULL, NULL, NULL, NULL, '2018-04-17 22:45:55', '2018-04-17 22:45:55'),
(10, 'Untitled Course 10', NULL, NULL, NULL, NULL, '2018-04-17 22:46:26', '2018-04-17 22:46:26'),
(11, 'Untitled Course 11', NULL, NULL, NULL, NULL, '2018-04-17 22:47:31', '2018-04-17 22:47:31'),
(12, 'Untitled Course 12', NULL, NULL, NULL, NULL, '2018-04-17 22:48:24', '2018-04-17 22:48:24'),
(13, 'Untitled Course 13', NULL, NULL, NULL, NULL, '2018-04-17 22:49:17', '2018-04-17 22:49:17'),
(14, 'Untitled Course 14', NULL, NULL, NULL, NULL, '2018-04-17 22:50:03', '2018-04-17 22:50:04'),
(15, 'Untitled Course 15', NULL, NULL, NULL, NULL, '2018-04-17 22:50:46', '2018-04-17 22:50:46'),
(16, 'Untitled Course 16', NULL, NULL, NULL, NULL, '2018-04-17 22:51:14', '2018-04-17 22:51:14'),
(17, 'Untitled Course 17', NULL, NULL, NULL, NULL, '2018-04-17 22:51:30', '2018-04-17 22:51:30'),
(18, 'Untitled Course 18', NULL, NULL, NULL, NULL, '2018-04-17 22:53:27', '2018-04-17 22:53:27'),
(19, 'Untitled Course 19', NULL, NULL, NULL, NULL, '2018-04-17 22:53:37', '2018-04-17 22:53:37'),
(20, 'Untitled Course 20', NULL, NULL, NULL, NULL, '2018-04-17 22:54:13', '2018-04-17 22:54:13'),
(21, 'Untitled Course 21', NULL, NULL, NULL, NULL, '2018-04-17 22:54:55', '2018-04-17 22:54:55'),
(22, 'Untitled Course 22', NULL, NULL, NULL, NULL, '2018-04-17 22:55:45', '2018-04-17 22:55:45'),
(23, 'Untitled Course 23', NULL, NULL, NULL, NULL, '2018-04-17 22:56:05', '2018-04-17 22:56:05'),
(24, 'Untitled Course 24', NULL, NULL, NULL, NULL, '2018-04-17 22:56:56', '2018-04-17 22:56:57'),
(25, 'Untitled Course 25', NULL, NULL, NULL, NULL, '2018-04-17 22:57:19', '2018-04-17 22:57:19'),
(26, 'Untitled Course 26', NULL, NULL, NULL, NULL, '2018-04-17 22:59:14', '2018-04-17 22:59:15'),
(27, 'Untitled Course 27', NULL, NULL, NULL, NULL, '2018-04-17 23:02:19', '2018-04-17 23:02:19'),
(28, 'Untitled Course 28', NULL, NULL, NULL, NULL, '2018-04-17 23:04:58', '2018-04-17 23:04:58'),
(29, 'Untitled Course 29', NULL, NULL, NULL, NULL, '2018-04-17 23:07:04', '2018-04-17 23:07:04'),
(30, 'Untitled Course 30', NULL, NULL, NULL, NULL, '2018-04-17 23:08:43', '2018-04-17 23:08:43'),
(31, 'Untitled Course 31', NULL, NULL, NULL, NULL, '2018-04-17 23:10:35', '2018-04-17 23:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_programs`
--

CREATE TABLE `enrolled_programs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `program_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrolled_programs`
--

INSERT INTO `enrolled_programs` (`id`, `user_id`, `program_id`, `created_at`, `last_updated_at`) VALUES
(1, 210, '3', '2018-04-06 17:02:40', '2018-04-06 17:02:40'),
(2, 210, '4', '2018-04-06 17:02:48', '2018-04-06 17:02:48'),
(3, 210, '5', '2018-04-06 17:02:52', '2018-04-06 17:02:52'),
(4, 210, '6', '2018-04-06 17:03:09', '2018-04-06 17:03:09'),
(5, 207, '3', '2018-04-08 19:27:27', '2018-04-08 19:27:27');

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
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facebook_users`
--

INSERT INTO `facebook_users` (`id`, `facebook_id`, `name`, `email`, `gender`, `created_at`, `last_updated_at`) VALUES
(79, NULL, 'Shashi Shekhar', 'shekharshashi0989@gmail.com', NULL, '2018-03-12 04:35:49', '2018-03-12 04:35:49'),
(81, NULL, NULL, 'shashi.shekhar0918@gmail.com', NULL, '2018-04-06 08:50:58', '2018-04-06 08:50:58');

-- --------------------------------------------------------

--
-- Table structure for table `google_users`
--

CREATE TABLE `google_users` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

INSERT INTO `google_users` (`id`, `created_at`, `last_updated_at`, `name`, `google_id`, `email`, `gender`, `verification_status`, `verification_code`) VALUES
(188, '2018-03-12 04:36:53', '2018-03-12 04:36:53', NULL, NULL, 'shekharshashi0989@gmail.com', NULL, 0, NULL),
(190, '2018-04-06 08:50:00', '2018-04-06 08:50:00', 'Shashi Shekhar', NULL, 'shashi.shekhar0918@gmail.com', NULL, 0, NULL);

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
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(255) DEFAULT NULL,
  `provider` text,
  `is_published` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `program_name`, `category`, `chapters`, `content`, `duration`, `cost`, `last_updated_at`, `created_at`, `type`, `provider`, `is_published`) VALUES
(2, 'Safe Agilist', 'Classroom Programs', '[{\"title\":\"PMP\",\"type\":\"video\",\"chapterUrl\":\"<iframe width=\\\"345\\\" height=\\\"200\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/CxzU5RgyejI\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\"},{\"title\":\"PMI ACP\",\"type\":\"video\",\"chapterUrl\":\"<iframe width=\\\"336\\\" height=\\\"200\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/eAfOE4coRh8\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\"},{\"title\":\"PMI PBA\",\"type\":\"video\",\"chapterUrl\":\"<iframe width=\\\"341\\\" height=\\\"200\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/4c4A6pjk3Hk\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\"}]', NULL, 30, 1500, '2018-04-08 19:29:06', '2018-03-09 08:33:54', 'free', 'iZen Bridge', 1),
(3, 'Kanban System Training', 'Classroom Programs', NULL, NULL, 45, 2000, '2018-04-08 19:38:07', '2018-03-09 08:35:55', NULL, NULL, 1),
(4, 'PMP', 'Online Programs', NULL, NULL, 7, 750, '2018-04-04 06:50:25', '2018-03-09 08:35:55', NULL, NULL, 0),
(5, 'PMI ACP', 'Online Programs', NULL, NULL, 10, 1200, '2018-04-16 19:47:51', '2018-03-09 08:37:30', NULL, NULL, 1),
(6, 'PMI PBA', 'Online Programs', '[{\"title\":\"test chapter\",\"type\":\"pdf\",\"chapterUrl\":\"msfff\"},{\"title\":\"test 2\",\"type\":\"video\",\"chapterUrl\":\"adlkjsd\"}]', NULL, 90, 6000, '2018-04-15 22:52:30', '2018-03-09 08:37:30', NULL, NULL, 1);

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
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `google_user_id` varchar(255) DEFAULT NULL,
  `facebook_user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `designation`, `organization`, `city`, `country`, `phone`, `business_email`, `access_type`, `password`, `login_source`, `created_at`, `last_updated_at`, `google_user_id`, `facebook_user_id`) VALUES
(207, 'shekharshashi0989@gmail.com', 'Shashi', 'desgination 1', 'Organization 1', 'city 1', 'country 1', '8123456345', 'abc@gmail.com', 'student', NULL, 'facebook', '2018-03-12 04:35:49', '2018-03-12 04:36:53', '188', '79'),
(209, 'admin@elearning.com', 'ELearning Admin', 'Administrator', 'iZenbridge', 'Bangalore', 'India', NULL, NULL, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', NULL, '2018-03-23 18:44:57', '2018-03-24 06:42:01', NULL, NULL),
(210, 'shashi.shekhar0918@gmail.com', 'Shashi', 'Software Engineer', 'e-learning', 'Bangalore', 'India', '9739085285', 'shashi.shekhar0918@gmail.com', 'student', NULL, 'google', '2018-04-06 08:50:00', '2018-04-06 08:50:58', '190', '81');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `enrolled_programs`
--
ALTER TABLE `enrolled_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `facebook_users`
--
ALTER TABLE `facebook_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `google_users`
--
ALTER TABLE `google_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
