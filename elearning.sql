-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2018 at 07:22 PM
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
  `user_id` varchar(255) NOT NULL,
  `program_id` varchar(255) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrolled_programs`
--

INSERT INTO `enrolled_programs` (`id`, `user_id`, `program_id`, `program_name`, `created_at`, `updated_at`) VALUES
(1, '165', '111', 'Networking', '2018-03-03 15:29:03', '2018-03-04 13:50:39'),
(2, '171', '222', 'Cloud Computing', '2018-03-03 15:29:03', '2018-03-04 13:50:48'),
(4, '171', '111', 'Networking', '2018-03-04 13:21:25', '2018-03-04 13:50:16'),
(5, '170', '222', 'Cloud Computing', '2018-03-04 13:21:25', '2018-03-04 13:45:58');

-- --------------------------------------------------------

--
-- Table structure for table `facebook_users`
--

CREATE TABLE `facebook_users` (
  `id` int(11) NOT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facebook_users`
--

INSERT INTO `facebook_users` (`id`, `facebook_id`, `first_name`, `last_name`, `email`, `gender`, `created_at`, `updated_at`) VALUES
(57, NULL, NULL, NULL, 'shekharshashi0989@gmail.com', NULL, '2018-03-04 13:49:18', '2018-03-04 13:49:18');

-- --------------------------------------------------------

--
-- Table structure for table `google_users`
--

CREATE TABLE `google_users` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `google_id` varchar(25) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `google_users`
--

INSERT INTO `google_users` (`id`, `created_at`, `updated_at`, `first_name`, `last_name`, `google_id`, `email`, `gender`) VALUES
(154, '2018-03-04 13:49:11', '2018-03-04 13:49:11', 'Shashi', 'Shekhar', NULL, 'shekharshashi0989@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `program_id` varchar(255) DEFAULT NULL,
  `program_name` varchar(255) DEFAULT NULL,
  `chapters` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `program_id`, `program_name`, `chapters`, `updated_at`, `created_at`) VALUES
(3, '111', 'Networking', '[{\"name\":\"Chapter 1\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=IT1X42D1KeA\"},{\"name\":\"Chapter 2\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=LICA-ILkO4w\"},{\"name\":\"Chapter 3\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=arVoQxjIxUU\"},{\"name\":\"Chapter 4\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=n2D1o-aM-2s\"},{\"name\":\"Chapter 5\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=E9uFNkzIzaw\"},{\"name\":\"Chapter 6\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=DtU8hB-qSPA\"}]', '2018-03-04 05:57:24', '2018-03-04 05:57:24'),
(4, '222', 'Cloud Computing', '[{\"name\":\"Chapter 1\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=IT1X42D1KeA\"},{\"name\":\"Chapter 2\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=LICA-ILkO4w\"},{\"name\":\"Chapter 3\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=arVoQxjIxUU\"},{\"name\":\"Chapter 4\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=n2D1o-aM-2s\"},{\"name\":\"Chapter 5\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=E9uFNkzIzaw\"},{\"name\":\"Chapter 6\",\"content\":\"https:\\/\\/www.youtube.com\\/watch?v=DtU8hB-qSPA\"}]', '2018-03-04 05:57:24', '2018-03-04 05:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `password` text,
  `access_type` varchar(255) DEFAULT NULL,
  `login_source` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gender` varchar(255) DEFAULT NULL,
  `google_user_id` varchar(255) DEFAULT NULL,
  `facebook_user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `email`, `first_name`, `last_name`, `password`, `access_type`, `login_source`, `created_at`, `updated_at`, `gender`, `google_user_id`, `facebook_user_id`) VALUES
(171, '1234', 'shekharshashi0989@gmail.com', 'Shashi', 'Shekhar', '81dc9bdb52d04dc20036dbd8313ed055', 'student', 'google', '2018-03-04 13:49:11', '2018-03-04 13:49:18', NULL, '154', '57');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `facebook_users`
--
ALTER TABLE `facebook_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `google_users`
--
ALTER TABLE `google_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
