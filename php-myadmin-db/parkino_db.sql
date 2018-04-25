-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2018 at 08:03 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkino_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(10) UNSIGNED NOT NULL,
  `qr_no` bigint(20) UNSIGNED NOT NULL,
  `rfid_no` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `qr_no`, `rfid_no`, `created_at`, `updated_at`) VALUES
(3, 555555550, 555555550, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(5, 555555552, 555555552, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(6, 555555553, 555555553, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(7, 555555554, 555555554, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(8, 555555555, 555555555, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(9, 555555556, 555555556, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(10, 555555557, 555555557, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(11, 555555558, 555555558, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(12, 555555559, 555555559, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(13, 5555555510, 5555555510, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(14, 5555555511, 5555555511, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(15, 5555555512, 5555555512, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(16, 5555555513, 5555555513, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(17, 5555555514, 5555555514, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(18, 5555555515, 5555555515, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(19, 5555555516, 5555555516, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(20, 5555555517, 5555555517, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(21, 5555555518, 5555555518, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(22, 5555555519, 5555555519, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(23, 5555555520, 5555555520, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(24, 5555555521, 5555555521, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(25, 5555555522, 5555555522, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(26, 5555555523, 5555555523, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(27, 5555555524, 5555555524, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(28, 5555555525, 5555555525, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(29, 5555555526, 5555555526, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(30, 5555555527, 5555555527, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(31, 5555555528, 5555555528, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(32, 5555555529, 5555555529, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(33, 5555555530, 5555555530, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(34, 5555555531, 5555555531, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(35, 5555555532, 5555555532, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(36, 5555555533, 5555555533, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(37, 5555555534, 5555555534, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(38, 5555555535, 5555555535, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(39, 5555555536, 5555555536, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(40, 5555555537, 5555555537, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(41, 5555555538, 5555555538, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(42, 5555555539, 5555555539, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(43, 5555555540, 5555555540, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(44, 5555555541, 5555555541, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(45, 5555555542, 5555555542, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(46, 5555555543, 5555555543, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(47, 5555555544, 5555555544, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(48, 5555555545, 5555555545, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(49, 5555555546, 5555555546, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(50, 5555555547, 5555555547, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(51, 5555555548, 5555555548, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(52, 5555555549, 5555555549, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(53, 5555555550, 5555555550, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(54, 5555555551, 5555555551, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(55, 5555555552, 5555555552, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(56, 5555555553, 5555555553, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(57, 5555555554, 5555555554, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(58, 5555555555, 5555555555, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(59, 5555555556, 5555555556, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(60, 5555555557, 5555555557, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(61, 5555555558, 5555555558, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(62, 5555555559, 5555555559, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(63, 5555555560, 5555555560, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(64, 5555555561, 5555555561, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(65, 5555555562, 5555555562, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(66, 5555555563, 5555555563, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(67, 5555555564, 5555555564, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(68, 5555555565, 5555555565, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(69, 5555555566, 5555555566, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(70, 5555555567, 5555555567, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(71, 5555555568, 5555555568, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(72, 5555555569, 5555555569, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(73, 5555555570, 5555555570, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(74, 5555555571, 5555555571, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(75, 5555555572, 5555555572, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(76, 5555555573, 5555555573, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(77, 5555555574, 5555555574, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(78, 5555555575, 5555555575, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(79, 5555555576, 5555555576, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(80, 5555555577, 5555555577, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(81, 5555555578, 5555555578, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(82, 5555555579, 5555555579, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(83, 5555555580, 5555555580, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(84, 5555555581, 5555555581, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(85, 5555555582, 5555555582, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(86, 5555555583, 5555555583, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(87, 5555555584, 5555555584, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(88, 5555555585, 5555555585, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(89, 5555555586, 5555555586, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(90, 5555555587, 5555555587, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(91, 5555555588, 5555555588, '2018-04-10 08:40:42', '2018-04-10 08:40:42'),
(92, 5555555589, 5555555589, '2018-04-10 08:40:42', '2018-04-10 08:40:42');

-- --------------------------------------------------------

--
-- Table structure for table `make_reservations`
--

CREATE TABLE `make_reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `long` decimal(8,2) NOT NULL,
  `lat` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(20) NOT NULL,
  `annually_tier` tinyint(1) DEFAULT NULL,
  `monthly_tier` tinyint(1) DEFAULT NULL,
  `daily_tier` tinyint(1) DEFAULT NULL,
  `hourly_tier` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `make_reservations`
--

INSERT INTO `make_reservations` (`id`, `long`, `lat`, `created_at`, `updated_at`, `user_id`, `annually_tier`, `monthly_tier`, `daily_tier`, `hourly_tier`) VALUES
(3, '1230.00', '1230.00', '2018-04-24 15:44:05', '2018-04-24 15:44:05', 2, NULL, NULL, NULL, 1),
(4, '1230.00', '1230.00', '2018-04-24 15:44:06', '2018-04-24 15:44:06', 3, NULL, NULL, NULL, 1),
(5, '1230.00', '1230.00', '2018-04-24 15:44:06', '2018-04-24 15:44:06', 4, NULL, NULL, NULL, 1),
(6, '1230.00', '1230.00', '2018-04-24 15:44:06', '2018-04-24 15:44:06', 5, NULL, NULL, NULL, 1),
(7, '1230.00', '1230.00', '2018-04-24 15:44:06', '2018-04-24 15:44:06', 6, NULL, NULL, NULL, 1),
(8, '1230.00', '1230.00', '2018-04-24 15:44:06', '2018-04-24 15:44:06', 7, NULL, NULL, NULL, 1),
(9, '1230.00', '1230.00', '2018-04-24 15:44:06', '2018-04-24 15:44:06', 8, NULL, NULL, NULL, 1),
(10, '1230.00', '1230.00', '2018-04-24 15:44:06', '2018-04-24 15:44:06', 9, NULL, NULL, NULL, 1),
(11, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 10, NULL, NULL, NULL, 1),
(12, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 11, NULL, NULL, NULL, 1),
(13, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 12, NULL, NULL, NULL, 1),
(14, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 13, NULL, NULL, NULL, 1),
(15, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 14, NULL, NULL, NULL, 1),
(16, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 15, NULL, NULL, NULL, 1),
(17, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 16, NULL, NULL, NULL, 1),
(18, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 17, NULL, NULL, NULL, 1),
(19, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 18, NULL, NULL, NULL, 1),
(20, '1231.00', '1231.00', '2018-04-24 15:47:18', '2018-04-24 15:47:18', 19, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(19, '2014_10_12_000000_create_users_table', 1),
(20, '2014_10_12_100000_create_password_resets_table', 1),
(21, '2018_03_16_105806_create_owners_table', 1),
(22, '2018_03_16_105837_create_cards_table', 1),
(23, '2018_03_16_110150_create_parkingareas_table', 1),
(24, '2018_03_16_110320_create_admins_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` int(10) UNSIGNED NOT NULL,
  `ssd` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `ssd`, `name`, `email`, `phone_number`, `created_at`, `updated_at`) VALUES
(15, 9856595662223, 'akkkk', 'aku@hghg.com', 787854512121, '2018-04-02 07:31:30', '2018-04-02 07:31:30'),
(5, 4353454545, 'fdgdsfgdfg', 'iams@laravel.com', 555464565656, '2018-03-18 09:47:50', '2018-03-18 09:47:50'),
(3, 343343, 'anton', 'antony@gmail.com', 343434, '2018-03-17 16:28:36', '2018-03-17 16:28:36'),
(6, 5995959, 'dslfjskfj', 'dfsdfkl@gmail.com', 998888, '2018-03-18 09:48:16', '2018-03-18 09:48:16'),
(9, 6676767, 'dfkkl', 'kdsfjk@rkrk.com', 4444, '2018-03-18 11:17:35', '2018-03-18 11:17:35'),
(13, 345654499, 'saka', 'saka@icloud.com', 56565656, '2018-03-19 09:07:56', '2018-03-19 09:07:56'),
(12, 67876767675, 'anton', 'antonny@sd.com', 3435454545, '2018-03-19 08:47:51', '2018-03-19 08:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `parkingareas`
--

CREATE TABLE `parkingareas` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `owner_ssd` int(10) UNSIGNED NOT NULL,
  `long` decimal(8,2) NOT NULL,
  `lat` decimal(8,2) NOT NULL,
  `slots_no` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parkingareas`
--

INSERT INTO `parkingareas` (`id`, `name`, `admin_id`, `owner_ssd`, `long`, `lat`, `slots_no`, `created_at`, `updated_at`) VALUES
(1, 'Damaris Goyette', 1, 1231231230, '1230.00', '1230.00', 5, '2018-04-24 15:29:27', '2018-04-24 15:29:27'),
(2, 'Dr. Milo Harris V', 1, 1231231231, '1231.00', '1231.00', 6, '2018-04-24 15:29:28', '2018-04-24 15:29:28'),
(3, 'Theodore Renner', 1, 1231231232, '1232.00', '1232.00', 7, '2018-04-24 15:29:28', '2018-04-24 15:29:28'),
(4, 'Nadia Mills', 1, 1231231233, '1233.00', '1233.00', 8, '2018-04-24 15:29:28', '2018-04-24 15:29:28'),
(5, 'Dr. Carrie Stracke', 1, 1231231234, '1234.00', '1234.00', 9, '2018-04-24 15:29:28', '2018-04-24 15:29:28'),
(6, 'Dr. Omari Pouros DVM', 1, 1231231235, '1235.00', '1235.00', 10, '2018-04-24 15:29:28', '2018-04-24 15:29:28'),
(7, 'Colby Kuhlman', 1, 1231231236, '1236.00', '1236.00', 11, '2018-04-24 15:29:28', '2018-04-24 15:29:28'),
(8, 'Ms. Dawn Maggio', 1, 1231231237, '1237.00', '1237.00', 12, '2018-04-24 15:29:28', '2018-04-24 15:29:28'),
(9, 'Liza Carroll', 1, 1231231238, '1238.00', '1238.00', 13, '2018-04-24 15:29:28', '2018-04-24 15:29:28'),
(10, 'Candelario Purdy', 1, 1231231239, '1239.00', '1239.00', 14, '2018-04-24 15:29:28', '2018-04-24 15:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int(10) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone_number`, `points`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'ahmed', 'ahmed@yahoo.com', '123456', '01006031228', 100, NULL, '2018-04-05 11:53:03', '2018-04-05 11:53:03'),
(2, 'mohamed', 'ahmed1@yahoo.com', '654321', '01224124376', 120, NULL, '2018-04-05 11:52:28', '2018-04-24 08:06:47'),
(5, 'ahmed0', 'ahmed00@yahoo.com', '123456', '01006031228', 15, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(6, 'ahmed1', 'ahmed01@yahoo.com', '123456', '01006031228', 14, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(7, 'ahmed2', 'ahmed02@yahoo.com', '123456', '01006031228', 10, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(8, 'ahmed3', 'ahmed03@yahoo.com', '123456', '01006031228', 11, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(9, 'ahmed4', 'ahmed04@yahoo.com', '123456', '01006031228', 25, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(10, 'ahmed5', 'ahmed05@yahoo.com', '123456', '01006031228', 232, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(11, 'ahmed6', 'ahmed06@yahoo.com', '123456', '01006031228', 20, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(12, 'ahmed7', 'ahmed07@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(13, 'ahmed8', 'ahmed08@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(14, 'ahmed9', 'ahmed09@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(15, 'ahmed10', 'ahmed010@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(16, 'ahmed11', 'ahmed011@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(17, 'ahmed12', 'ahmed012@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(18, 'ahmed13', 'ahmed013@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(19, 'ahmed14', 'ahmed014@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(20, 'ahmed15', 'ahmed015@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(21, 'ahmed16', 'ahmed016@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(22, 'ahmed17', 'ahmed017@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(23, 'ahmed18', 'ahmed018@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(24, 'ahmed19', 'ahmed019@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(25, 'ahmed20', 'ahmed020@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(26, 'ahmed21', 'ahmed021@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(27, 'ahmed22', 'ahmed022@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(28, 'ahmed23', 'ahmed023@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(29, 'ahmed24', 'ahmed024@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(30, 'ahmed25', 'ahmed025@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(31, 'ahmed26', 'ahmed026@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(32, 'ahmed27', 'ahmed027@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(33, 'ahmed28', 'ahmed028@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(34, 'ahmed29', 'ahmed029@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(35, 'ahmed30', 'ahmed030@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(36, 'ahmed31', 'ahmed031@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(37, 'ahmed32', 'ahmed032@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(38, 'ahmed33', 'ahmed033@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(39, 'ahmed34', 'ahmed034@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(40, 'ahmed35', 'ahmed035@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(41, 'ahmed36', 'ahmed036@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(42, 'ahmed37', 'ahmed037@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(43, 'ahmed38', 'ahmed038@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(44, 'ahmed39', 'ahmed039@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(45, 'ahmed40', 'ahmed040@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(46, 'ahmed41', 'ahmed041@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(47, 'ahmed42', 'ahmed042@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(48, 'ahmed43', 'ahmed043@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(49, 'ahmed44', 'ahmed044@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(50, 'ahmed45', 'ahmed045@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(51, 'ahmed46', 'ahmed046@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(52, 'ahmed47', 'ahmed047@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(53, 'ahmed48', 'ahmed048@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(54, 'ahmed49', 'ahmed049@yahoo.com', '123456', '01006031228', NULL, NULL, '2018-04-10 08:24:53', '2018-04-10 08:24:53'),
(55, 'ahme1d', 'ashmed@yahoo.com', '123456', '010060312285', NULL, NULL, '2018-04-10 08:45:14', '2018-04-10 08:45:14'),
(56, 'ahmed232', 'ahmed662@yahoo.com', '123456', '01224132571', NULL, NULL, '2018-04-22 20:25:07', '2018-04-22 20:25:07'),
(57, 'Samir', 'samir@yahoo.com', '123456', '01236541236', NULL, NULL, '2018-04-22 20:30:03', '2018-04-22 20:30:03'),
(58, 'samir22', 'samir22@yahoo.com', '123456', '01223645987', NULL, NULL, '2018-04-24 08:29:41', '2018-04-24 08:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_cards`
--

CREATE TABLE `user_cards` (
  `user_id` int(10) NOT NULL,
  `card_no` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_cards`
--

INSERT INTO `user_cards` (`user_id`, `card_no`, `created_at`, `updated_at`) VALUES
(2, '999999999', '2018-04-05 14:51:38', '0000-00-00 00:00:00'),
(2, '888888888', '2018-04-05 14:51:38', '0000-00-00 00:00:00'),
(2, '555555551', '2018-04-10 08:43:39', '2018-04-10 08:43:39'),
(3, '9999999991', '2018-04-24 18:25:48', '0000-00-00 00:00:00'),
(4, '9999999992', '2018-04-24 18:26:34', '0000-00-00 00:00:00'),
(5, '999999553', '2018-04-24 18:26:34', '0000-00-00 00:00:00'),
(24, '9999999995', '2018-04-24 18:27:35', '0000-00-00 00:00:00'),
(6, '999999556', '2018-04-24 18:27:35', '0000-00-00 00:00:00'),
(240, '123123000', '2018-04-24 18:28:09', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`,`qr_no`,`rfid_no`);

--
-- Indexes for table `make_reservations`
--
ALTER TABLE `make_reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`ssd`,`id`),
  ADD UNIQUE KEY `owners_email_unique` (`email`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `parkingareas`
--
ALTER TABLE `parkingareas`
  ADD PRIMARY KEY (`id`,`long`,`lat`),
  ADD KEY `parkingareas_admin_id_foreign` (`admin_id`),
  ADD KEY `parkingareas_owner_ssd_foreign` (`owner_ssd`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `make_reservations`
--
ALTER TABLE `make_reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `parkingareas`
--
ALTER TABLE `parkingareas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
