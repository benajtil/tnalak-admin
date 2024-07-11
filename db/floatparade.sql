-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2024 at 05:53 AM
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
-- Database: `floatparade`
--

-- --------------------------------------------------------

--
-- Table structure for table `contestant`
--

CREATE TABLE `contestant` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `entry_num` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `scored` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contestant`
--

INSERT INTO `contestant` (`id`, `name`, `entry_num`, `created_at`, `updated_at`, `scored`) VALUES
(1, '1', 1, '2024-06-30 03:43:35', '2024-06-30 03:43:35', 0),
(2, '2', 2, '2024-06-30 03:43:35', '2024-06-30 03:43:35', 0),
(3, '3', 3, '2024-06-30 03:43:35', '2024-06-30 03:45:59', 0),
(4, '4', 4, '2024-06-30 03:46:05', '2024-06-30 03:46:05', 0),
(5, '5', 5, '2024-06-30 03:46:05', '2024-06-30 03:46:05', 0),
(6, '6', 6, '2024-06-30 03:46:05', '2024-06-30 03:46:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `overallscores`
--

CREATE TABLE `overallscores` (
  `id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `entry_num` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `compiled_scores` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `overallscores`
--

INSERT INTO `overallscores` (`id`, `judge_id`, `entry_num`, `score`, `created_at`, `updated_at`, `compiled_scores`) VALUES
(9, 0, 1, 0, '2024-06-30 03:46:38', '2024-06-30 03:46:38', 86),
(10, 0, 1, 0, '2024-06-30 03:46:56', '2024-06-30 03:46:56', 93),
(11, 0, 1, 0, '2024-06-30 03:47:11', '2024-06-30 03:47:11', 93);

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `entry_num` int(11) NOT NULL,
  `judge_name` varchar(255) NOT NULL,
  `overall_appearance` int(11) DEFAULT NULL,
  `artistry_design` int(11) DEFAULT NULL,
  `craftsmanship` int(11) DEFAULT NULL,
  `relevance_theme` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`entry_num`, `judge_name`, `overall_appearance`, `artistry_design`, `craftsmanship`, `relevance_theme`, `created`, `updated`, `total_score`) VALUES
(1, 'ben florence', 23, 20, 23, 20, '2024-06-30 03:46:38', '2024-06-30 03:46:38', NULL),
(1, 'cj buendicho', 23, 20, 30, 20, '2024-06-30 03:47:11', '2024-06-30 03:47:11', NULL),
(1, 'poging nilalang', 30, 20, 30, 20, '2024-06-30 03:46:56', '2024-06-30 03:46:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'administrator', 2, 1, '2024-06-26 00:33:54', '2024-06-26 00:33:54'),
(2, 'judge1', 'password', 'ben florence', 1, 1, '2024-06-26 00:56:09', '2024-06-26 00:56:09'),
(3, 'judge2', 'password', 'cj buendicho', 1, 1, '2024-06-26 00:56:09', '2024-06-26 00:56:09'),
(4, 'judge3', 'password', 'poging nilalang', 1, 1, '2024-06-26 00:56:09', '2024-06-26 00:56:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contestant`
--
ALTER TABLE `contestant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overallscores`
--
ALTER TABLE `overallscores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`entry_num`,`judge_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contestant`
--
ALTER TABLE `contestant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `overallscores`
--
ALTER TABLE `overallscores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
