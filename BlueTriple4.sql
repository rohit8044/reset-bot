-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 07, 2023 at 12:10 PM
-- Server version: 5.6.38
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Blue Triple 4`
--

-- --------------------------------------------------------

--
-- Table structure for table `apks`
--

CREATE TABLE `apks` (
  `id` int(11) NOT NULL,
  `apk_name` varchar(255) DEFAULT NULL,
  `apk_name_show` varchar(255) DEFAULT NULL,
  `apk_version` varchar(255) DEFAULT NULL,
  `apk_size` varchar(255) NOT NULL,
  `apk_downloads` varchar(255) DEFAULT NULL,
  `apk_path` varchar(255) DEFAULT NULL,
  `apk_status` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lib`
--

CREATE TABLE `lib` (
  `id` int(11) NOT NULL,
  `lib_name` varchar(255) DEFAULT NULL,
  `lib_name_show` varchar(255) DEFAULT NULL,
  `lib_version` varchar(255) DEFAULT NULL,
  `lib_size` varchar(255) NOT NULL,
  `lib_downloads` varchar(255) DEFAULT NULL,
  `lib_path` varchar(255) DEFAULT NULL,
  `lib_status` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nt`
--

CREATE TABLE `nt` (
  `id` int(11) NOT NULL,
  `n` varchar(30) NOT NULL,
  `nt` varchar(30) NOT NULL,
  `dt` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `panel`
--

CREATE TABLE `panel` (
  `_user_id` int(11) NOT NULL,
  `_username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `_password` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `_token` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `_v_status` text COLLATE utf8_unicode_ci NOT NULL,
  `_status` text COLLATE utf8_unicode_ci NOT NULL,
  `_reg_date` timestamp NULL DEFAULT NULL,
  `_exp_date` timestamp NULL DEFAULT NULL,
  `_curr_time` timestamp NULL DEFAULT NULL,
  `_uid` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `_user_type` text COLLATE utf8_unicode_ci NOT NULL,
  `_registrar` text COLLATE utf8_unicode_ci NOT NULL,
  `_version` text COLLATE utf8_unicode_ci NOT NULL,
  `_p_status` text COLLATE utf8_unicode_ci NOT NULL,
  `_credits` int(11) NOT NULL,
  `_resets` int(11) NOT NULL,
  `_r_resets` int(11) NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verification_code` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_verified` int(11) DEFAULT NULL,
  `profile` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '../assets/img/avatars/1.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `panel`
--

INSERT INTO `panel` (`_user_id`, `_username`, `_password`, `_token`, `_v_status`, `_status`, `_reg_date`, `_exp_date`, `_curr_time`, `_uid`, `_user_type`, `_registrar`, `_version`, `_p_status`, `_credits`, `_resets`, `_r_resets`, `email`, `verification_code`, `is_verified`, `profile`) VALUES
(1, 'BlueTriple4', '414', 'BlueTriple4_444', 'verified', 'active', NULL, NULL, NULL, NULL, 'owner', 'Owner', 'injector', 'paid', 999999939, 0, 999999, NULL, NULL, 1, '../assets/img/avatars/1.png'),
(2, '', '', '', '', '', NULL, NULL, NULL, NULL, '', '', '', '', 0, 0, 0, NULL, NULL, NULL, '../assets/img/avatars/1.png');

-- --------------------------------------------------------

--
-- Table structure for table `script`
--

CREATE TABLE `script` (
  `id` int(11) NOT NULL,
  `script_name` varchar(255) DEFAULT NULL,
  `script_name_show` varchar(255) DEFAULT NULL,
  `script_version` varchar(255) DEFAULT NULL,
  `script_size` varchar(255) NOT NULL,
  `script_downloads` varchar(255) DEFAULT NULL,
  `script_path` varchar(255) DEFAULT NULL,
  `script_status` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE `server` (
  `srv_id` int(11) NOT NULL,
  `server_name` text COLLATE utf8_unicode_ci NOT NULL,
  `total_sessions` int(11) NOT NULL,
  `server_status` text COLLATE utf8_unicode_ci NOT NULL,
  `server_h_status` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `server`
--

INSERT INTO `server` (`srv_id`, `server_name`, `total_sessions`, `server_status`, `server_h_status`) VALUES
(1, 'panel', 0, 'online', 'online');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apks`
--
ALTER TABLE `apks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib`
--
ALTER TABLE `lib`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panel`
--
ALTER TABLE `panel`
  ADD PRIMARY KEY (`_user_id`);

--
-- Indexes for table `script`
--
ALTER TABLE `script`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`srv_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apks`
--
ALTER TABLE `apks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel`
--
ALTER TABLE `panel`
  MODIFY `_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `server`
--
ALTER TABLE `server`
  MODIFY `srv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;