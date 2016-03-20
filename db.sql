-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2016 at 01:01 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `filter` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_time` int(10) NOT NULL,
  `link` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `likes` int(11) NOT NULL,
  `low_resolution` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `standard_resolution` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_in_photo` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_low_bandwidth` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_standard_resolution` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_low_resolution` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` int(11) NOT NULL,
  `latitude` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `username`
--

CREATE TABLE IF NOT EXISTS `username` (
  `username` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` varchar(700) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media` int(11) NOT NULL,
  `followed_by` int(11) NOT NULL,
  `follows` int(11) NOT NULL,
  `id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user`), ADD UNIQUE KEY `tag` (`user`);

--
-- Indexes for table `username`
--
ALTER TABLE `username`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
