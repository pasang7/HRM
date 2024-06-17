-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2022 at 06:32 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hr`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_leaves`
--

CREATE TABLE `accepted_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `leave_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `accepted_by` int(11) NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_holiday` tinyint(1) NOT NULL DEFAULT 0,
  `holiday_type` tinyint(1) DEFAULT NULL,
  `holiday_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_absent` tinyint(1) NOT NULL DEFAULT 0,
  `is_leave` tinyint(1) NOT NULL DEFAULT 0,
  `leave_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `leave_day` decimal(8,2) DEFAULT NULL,
  `leave_id` bigint(20) UNSIGNED DEFAULT NULL,
  `clockin` time DEFAULT NULL,
  `clockout` time DEFAULT NULL,
  `clockin_verification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clockout_verification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_clockout` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blood_groups`
--

CREATE TABLE `blood_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blood_groups`
--

INSERT INTO `blood_groups` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'A+', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'A-', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(3, 'B+', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(4, 'B-', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(5, 'O+', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(6, 'O-', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(7, 'AB+', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(8, 'AB-', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `changes`
--

CREATE TABLE `changes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `changes`
--

INSERT INTO `changes` (`id`, `department_id`, `user_id`, `from`, `to`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, '2022/01/23', NULL, 1, '2022-01-23 05:28:05', '2022-01-23 05:28:05'),
(2, 3, NULL, '2022/01/23', NULL, 1, '2022-01-23 05:28:24', '2022-01-23 05:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `normal_overtime_rate` double NOT NULL DEFAULT 1.5,
  `special_overtime_rate` double DEFAULT 2,
  `pf_facility` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `gratuity_facility` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `ssf_facility` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `bank_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_contact` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_types`
--

CREATE TABLE `contract_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contract_types`
--

INSERT INTO `contract_types` (`id`, `name`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Fixed', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'Rolling', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(3, 'Project Based', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(4, 'Zero Hour', 'no', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(5, 'Hourly', 'no', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(6, 'Project Based', 'no', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `default_clockouts`
--

CREATE TABLE `default_clockouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `slug`, `status`, `created_by`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Default', 'default', 1, 1, 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'Top Level Management', 'top-level-management', 0, 1, 0, '2022-01-23 05:28:05', '2022-01-23 05:28:05'),
(3, 'HR & Admin', 'hr-admin', 0, 1, 0, '2022-01-23 05:28:24', '2022-01-23 05:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `department_holidays`
--

CREATE TABLE `department_holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `change_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `day` int(11) NOT NULL,
  `active_from` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department_holidays`
--

INSERT INTO `department_holidays` (`id`, `department_id`, `change_id`, `status`, `day`, `active_from`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 6, '2022-01-23', '2022-01-23 05:28:05', '2022-01-23 05:28:05'),
(2, 3, 2, 1, 6, '2022-01-23', '2022-01-23 05:28:24', '2022-01-23 05:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `created_by` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `slug`, `is_active`, `created_by`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'superadmin', 'yes', 1, 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'CEO', 'ceo', 'yes', 1, 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(3, 'HR Manager', 'hr-manager', 'yes', 1, 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(4, 'Project Manager', 'project-manager', 'yes', 1, 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(5, 'Finance Officer', 'finance-officer', 'yes', 1, 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(6, 'Marketing Manger', 'marketing-manger', 'yes', 1, 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(7, 'Support Staff', 'support-staff', 'yes', 1, 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `province_id`, `name`, `slug`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bhojpur', 'bhojpur', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 1, 'Dhankuta', 'dhankuta', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(3, 1, 'Ilam', 'ilam', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(4, 1, 'Jhapa', 'jhapa', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(5, 1, 'Khotang', 'khotang', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(6, 1, 'Morang', 'morang', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(7, 1, 'Okhaldhunga', 'okhaldhunga', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(8, 1, 'Pachthar', 'pachthar', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(9, 1, 'Sankhuwasabha', 'sankhuwasabha', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(10, 1, 'Solukhumbu', 'solukhumbu', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(11, 1, 'Sunsari', 'sunsari', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(12, 1, 'Taplejung', 'taplejung', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(13, 1, 'Terathum', 'terathum', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(14, 1, 'Udaypur', 'udaypur', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(15, 2, 'Bara', 'bara', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(16, 2, 'Dhanusa', 'dhanusa', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(17, 2, 'Mahottari', 'mahottari', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(18, 2, 'Parsa', 'parsa', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(19, 2, 'Rautahat', 'rautahat', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(20, 2, 'Saptari', 'saptari', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(21, 2, 'Sarlahi', 'sarlahi', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(22, 2, 'Siraha', 'siraha', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(23, 3, 'Bhaktapur', 'bhaktapur', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(24, 3, 'Chitwan', 'chitwan', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(25, 3, 'Dhading', 'dhading', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(26, 3, 'Dolka', 'dolka', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(27, 3, 'Kathmandu', 'kathmandu', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(28, 3, 'Kavrepalanchok', 'kavrepalanchok', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(29, 3, 'Lalitpur', 'lalitpur', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(30, 3, 'Makwanpur', 'makwanpur', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(31, 3, 'Nuwakot', 'nuwakot', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(32, 3, 'Ramechap', 'ramechap', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(33, 3, 'Rasuwa', 'rasuwa', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(34, 3, 'Sindhuli', 'sindhuli', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(35, 3, 'Sindhupalchowk', 'sindhupalchowk', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(36, 4, 'Baglung', 'baglung', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(37, 4, 'Gorkha', 'gorkha', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(38, 4, 'Kaski', 'kaski', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(39, 4, 'Lamjung', 'lamjung', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(40, 4, 'Manag', 'manag', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(41, 4, 'Mustang', 'mustang', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(42, 4, 'Myagdi', 'myagdi', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(43, 4, 'Nawalpur', 'nawalpur', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(44, 4, 'Parbat', 'parbat', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(45, 4, 'Syangja', 'syangja', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(46, 4, 'Tanahu', 'tanahu', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(47, 5, 'Arghakhachi', 'arghakhachi', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(48, 5, 'Banke', 'banke', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(49, 5, 'Bardiya', 'bardiya', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(50, 5, 'Dang', 'dang', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(51, 5, 'Eastern Rukum', 'eastern-rukum', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(52, 5, 'Gulmi', 'gulmi', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(53, 5, 'Kapilvastu', 'kapilvastu', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(54, 5, 'Palpa', 'palpa', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(55, 5, 'Parasi', 'parasi', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(56, 5, 'Pyuthan', 'pyuthan', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(57, 5, 'Rolpa', 'rolpa', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(58, 5, 'Rubandehi', 'rubandehi', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(59, 6, 'Dolpa', 'dolpa', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(60, 6, 'Humla', 'humla', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(61, 6, 'Jajarkot', 'jajarkot', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(62, 6, 'Jumla', 'jumla', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(63, 6, 'Kalikot', 'kalikot', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(64, 6, 'Mugu', 'mugu', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(65, 6, 'Salyan', 'salyan', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(66, 6, 'Surkhet', 'surkhet', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(67, 6, 'Western Rukum', 'western-rukum', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(68, 7, 'Aacham', 'aacham', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(69, 7, 'Baitadi', 'baitadi', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(70, 7, 'Bajhang', 'bajhang', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(71, 7, 'Bajura', 'bajura', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(72, 7, 'Dadeldhura', 'dadeldhura', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(73, 7, 'Darchula', 'darchula', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(74, 7, 'Doti', 'doti', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(75, 7, 'Kailali', 'kailali', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(76, 7, 'Kanchanpur', 'kanchanpur', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `employee_ids`
--

CREATE TABLE `employee_ids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_ids`
--

INSERT INTO `employee_ids` (`id`, `employee_id`, `created_at`, `updated_at`) VALUES
(1, 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Male', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'Female', 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_multiple` tinyint(1) NOT NULL DEFAULT 0,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income_taxes`
--

CREATE TABLE `income_taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_married` tinyint(1) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `income_taxes`
--

INSERT INTO `income_taxes` (`id`, `name`, `is_married`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'Married Male', 1, 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'Unmarried Male', 0, 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(3, 'Unmarried Female', 0, 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(4, 'Married Female', 1, 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_full` tinyint(1) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `is_rejected` tinyint(1) NOT NULL DEFAULT 0,
  `is_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `days`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Annual Leave', 15, 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'Sick Leave', 6, 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2012_01_05_111921_create_contract_types_table', 1),
(2, '2012_01_05_121241_create_roles_table', 1),
(3, '2012_01_05_152708_create_employee_ids_table', 1),
(4, '2012_01_06_164437_create_designations_table', 1),
(5, '2012_01_06_181507_create_provinces_table', 1),
(6, '2012_01_06_181522_create_districts_table', 1),
(7, '2012_01_06_194752_create_blood_groups_table', 1),
(8, '2012_01_06_194917_create_religions_table', 1),
(9, '2012_01_06_204547_create_genders_table', 1),
(10, '2012_12_05_065216_create_departments_table', 1),
(11, '2012_12_12_144444_create_users_table', 1),
(12, '2012_12_12_163108_create_holidays_table', 1),
(13, '2012_12_13_140509_create_leave_types_table', 1),
(14, '2012_12_13_144446_create_leaves_table', 1),
(15, '2014_10_12_100000_create_password_resets_table', 1),
(16, '2019_08_19_000000_create_failed_jobs_table', 1),
(17, '2019_12_05_092127_create_shifts_table', 1),
(18, '2019_12_05_155459_create_user_permissions_table', 1),
(19, '2019_12_05_162307_create_department_holidays_table', 1),
(20, '2019_12_05_162723_create_changes_table', 1),
(21, '2019_12_05_164740_create_user_holidays_table', 1),
(22, '2019_12_08_033620_create_projects_table', 1),
(23, '2019_12_10_152627_create_attendances_table', 1),
(24, '2019_12_11_054108_create_default_clockouts_table', 1),
(25, '2019_12_12_052622_create_reports_table', 1),
(26, '2019_12_15_093546_create_settings_table', 1),
(27, '2019_12_15_142846_create_accepted_leaves_table', 1),
(28, '2019_12_15_224149_create_tasks_table', 1),
(29, '2019_12_18_220806_create_income_taxes_table', 1),
(30, '2019_12_18_221008_create_tax_slabs_table', 1),
(31, '2019_12_19_154707_create_user_leave_types_table', 1),
(32, '2019_12_26_141209_create_salaries_table', 1),
(33, '2019_12_29_210347_create_salary_paids_table', 1),
(34, '2020_01_07_151410_create_salary_payment_details_table', 1),
(35, '2022_01_06_200814_create_pivot_user_contracts_table', 1),
(36, '2022_01_20_141210_create_company_settings_table', 1),
(37, '2022_01_20_171331_create_payroll_incomes_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_incomes`
--

CREATE TABLE `payroll_incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calculation_method` enum('percent','amount') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percent_rate` double NOT NULL DEFAULT 0,
  `status` enum('active','in_active') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pivot_user_contracts`
--

CREATE TABLE `pivot_user_contracts` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deadline` date NOT NULL,
  `is_other` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `department_id`, `slug`, `deadline`, `is_other`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Other', 2, 'other', '2022-01-23', 1, 0, 1, '2022-01-23 05:28:05', '2022-01-23 05:28:05'),
(2, 'Other', 3, 'other-1', '2022-01-23', 1, 0, 1, '2022-01-23 05:28:24', '2022-01-23 05:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `slug`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Province No. 1', 'province-no-1', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'Province No. 2', 'province-no-2', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(3, 'Bagmati Province', 'bagmati-province', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(4, 'Gandaki Province', 'gandaki-province', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(5, 'Lumbini Province', 'lumbini-province', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(6, 'Karnali Province', 'karnali-province', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(7, 'Sudurpaschim Province', 'sudurpaschim-province', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `religions`
--

CREATE TABLE `religions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `religions`
--

INSERT INTO `religions` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Hinduism', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'Buddhism', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(3, 'Islam', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(4, 'Kirat', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(5, 'Christianity', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(6, 'Others', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` decimal(8,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `files` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `is_active`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'superadmin', 'yes', 1, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'CEO', 'ceo', 'yes', 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(3, 'HR', 'hr', 'yes', 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(4, 'Department Head', 'department-head', 'yes', 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(5, 'Staff', 'staff', 'yes', 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(6, 'Intern', 'intern', 'no', 0, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `salary` decimal(13,2) NOT NULL,
  `from` date NOT NULL,
  `to` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_paids`
--

CREATE TABLE `salary_paids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `paid_at` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_payment_details`
--

CREATE TABLE `salary_payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `salary_paid_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `expected_yearly_income` decimal(13,2) NOT NULL,
  `salary` decimal(13,2) NOT NULL,
  `total_days` decimal(8,2) NOT NULL,
  `present_days` decimal(8,2) NOT NULL,
  `paid_leave` decimal(8,2) NOT NULL,
  `unpaid_leave` decimal(8,2) NOT NULL,
  `payable_days` decimal(8,2) NOT NULL,
  `gross_salary_payable` decimal(8,2) NOT NULL,
  `total_payable` decimal(8,2) NOT NULL,
  `tds` decimal(8,2) NOT NULL,
  `net_payable` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'master-pin', '$2y$10$1/iuNiNIqUxvMPlqICZIDu89OOaLvockhYi/w2Xm7saNI4GYELthW', '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(2, 'fiscal-year-start', '06-15', '2022-01-23 05:27:12', '2022-01-23 05:27:39'),
(3, 'fiscal-year-end', '06-14', '2022-01-23 05:27:12', '2022-01-23 05:27:39'),
(4, 'company-name', 'HR Software', '2022-01-23 05:27:12', '2022-01-23 05:27:12'),
(5, 'new-setup', 'yes', '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `clockin` time NOT NULL,
  `clockout` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `department_id`, `clockin`, `clockout`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 2, '10:00:00', '17:00:00', 0, 1, '2022-01-23 05:28:05', '2022-01-23 05:28:05'),
(2, 3, '10:00:00', '17:00:00', 0, 1, '2022-01-23 05:28:24', '2022-01-23 05:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `task` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` tinyint(1) NOT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `is_removed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_slabs`
--

CREATE TABLE `tax_slabs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `income_tax_id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_slabs`
--

INSERT INTO `tax_slabs` (`id`, `income_tax_id`, `position`, `amount`, `percent`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 450000, 1, 1, '2022-01-23 05:29:10', '2022-01-23 05:29:10'),
(2, 1, 2, 100000, 10, 1, '2022-01-23 05:29:22', '2022-01-23 05:29:22'),
(3, 1, 2, 200000, 20, 1, '2022-01-23 05:29:29', '2022-01-23 05:29:29'),
(4, 1, 2, 1300000, 30, 1, '2022-01-23 05:30:04', '2022-01-23 05:30:04'),
(5, 1, 2, 2000000, 36, 1, '2022-01-23 05:30:15', '2022-01-23 05:30:15'),
(6, 2, 1, 400000, 1, 1, '2022-01-23 05:30:27', '2022-01-23 05:30:27'),
(7, 2, 2, 100000, 10, 1, '2022-01-23 05:30:34', '2022-01-23 05:30:34'),
(8, 2, 2, 200000, 20, 1, '2022-01-23 05:30:44', '2022-01-23 05:30:44'),
(9, 2, 2, 1300000, 30, 1, '2022-01-23 05:30:49', '2022-01-23 05:30:49'),
(10, 2, 2, 2000000, 36, 1, '2022-01-23 05:31:02', '2022-01-23 05:31:02'),
(11, 4, 1, 450000, 1, 1, '2022-01-23 05:29:10', '2022-01-23 05:29:10'),
(12, 4, 2, 100000, 10, 1, '2022-01-23 05:29:22', '2022-01-23 05:29:22'),
(13, 4, 2, 200000, 20, 1, '2022-01-23 05:29:29', '2022-01-23 05:29:29'),
(14, 4, 2, 1300000, 30, 1, '2022-01-23 05:30:04', '2022-01-23 05:30:04'),
(15, 4, 2, 2000000, 36, 1, '2022-01-23 05:30:15', '2022-01-23 05:30:15'),
(16, 3, 1, 400000, 1, 1, '2022-01-23 05:30:27', '2022-01-23 05:30:27'),
(17, 3, 2, 100000, 10, 1, '2022-01-23 05:30:34', '2022-01-23 05:30:34'),
(18, 3, 2, 200000, 20, 1, '2022-01-23 05:30:44', '2022-01-23 05:30:44'),
(19, 3, 2, 1300000, 30, 1, '2022-01-23 05:30:49', '2022-01-23 05:30:49'),
(20, 3, 2, 2000000, 36, 1, '2022-01-23 05:31:02', '2022-01-23 05:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_head` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int(11) NOT NULL,
  `role` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `designation` bigint(20) UNSIGNED NOT NULL,
  `is_married` tinyint(1) NOT NULL DEFAULT 0,
  `province` bigint(20) NOT NULL,
  `district` bigint(20) NOT NULL,
  `municipality_vdc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temp_province` bigint(20) DEFAULT NULL,
  `temp_district` bigint(20) DEFAULT NULL,
  `temp_municipality_vdc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temp_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` bigint(20) UNSIGNED NOT NULL,
  `religion` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `interview_date` date NOT NULL,
  `joined` date NOT NULL,
  `profile_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `citizenship` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_overtime` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `has_pan` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_ssf` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `ssf_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_pf` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `pf_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_slip` enum('show','hide') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'show',
  `tax_calculate` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `first_approval_id` int(11) DEFAULT NULL,
  `sec_approval_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `is_head`, `name`, `slug`, `gender`, `role`, `department_id`, `designation`, `is_married`, `province`, `district`, `municipality_vdc`, `address`, `temp_province`, `temp_district`, `temp_municipality_vdc`, `temp_address`, `phone`, `phone_2`, `blood_group`, `religion`, `email`, `email_2`, `email_verified_at`, `password`, `pin`, `dob`, `interview_date`, `joined`, `profile_image`, `citizenship`, `cv`, `allow_overtime`, `has_pan`, `pan_no`, `has_ssf`, `ssf_no`, `has_pf`, `pf_no`, `salary_slip`, `tax_calculate`, `first_approval_id`, `sec_approval_id`, `created_by`, `is_deleted`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '0', 'no', 'Admin', 'admin', 1, 1, 1, 1, 0, 3, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'ceo@hr.com', NULL, NULL, '$2y$10$Gwws0Gc1RBAt9so4vJ3nwurtDJ/nPH7Inl60FUUhSabi4DE99WAwG', '$2y$10$zb7ILmevQNJp7WQisJskkejp6UzIz5hcL2rLLnjOfZDdTUq5ArY5i', '2022-01-23', '2021-01-23', '2021-01-23', NULL, NULL, NULL, 'yes', 'no', NULL, 'no', NULL, 'no', NULL, 'show', 'yes', NULL, NULL, 1, 0, NULL, '2022-01-23 05:27:12', '2022-01-23 05:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_holidays`
--

CREATE TABLE `user_holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `change_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `day` int(11) NOT NULL,
  `active_from` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_leave_types`
--

CREATE TABLE `user_leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `days` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permission` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_leaves`
--
ALTER TABLE `accepted_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accepted_leaves_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `accepted_leaves_leave_id_foreign` (`leave_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_user_id_foreign` (`user_id`),
  ADD KEY `attendances_shift_id_foreign` (`shift_id`),
  ADD KEY `attendances_holiday_id_foreign` (`holiday_id`),
  ADD KEY `attendances_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `attendances_leave_id_foreign` (`leave_id`);

--
-- Indexes for table `blood_groups`
--
ALTER TABLE `blood_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `changes`
--
ALTER TABLE `changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `changes_department_id_foreign` (`department_id`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract_types`
--
ALTER TABLE `contract_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_clockouts`
--
ALTER TABLE `default_clockouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_holidays`
--
ALTER TABLE `department_holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_holidays_department_id_foreign` (`department_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_province_id_index` (`province_id`);

--
-- Indexes for table `employee_ids`
--
ALTER TABLE `employee_ids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_taxes`
--
ALTER TABLE `income_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_user_id_index` (`user_id`),
  ADD KEY `leaves_leave_type_id_index` (`leave_type_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payroll_incomes`
--
ALTER TABLE `payroll_incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pivot_user_contracts`
--
ALTER TABLE `pivot_user_contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pivot_user_contracts_user_id_foreign` (`user_id`),
  ADD KEY `pivot_user_contracts_contract_id_foreign` (`contract_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_department_id_foreign` (`department_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `religions`
--
ALTER TABLE `religions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`),
  ADD KEY `reports_project_id_foreign` (`project_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salaries_user_id_foreign` (`user_id`);

--
-- Indexes for table `salary_paids`
--
ALTER TABLE `salary_paids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_payment_details`
--
ALTER TABLE `salary_payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_payment_details_user_id_foreign` (`user_id`),
  ADD KEY `salary_payment_details_salary_paid_id_foreign` (`salary_paid_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shifts_department_id_foreign` (`department_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_foreign` (`user_id`);

--
-- Indexes for table `tax_slabs`
--
ALTER TABLE `tax_slabs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tax_slabs_income_tax_id_foreign` (`income_tax_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_foreign` (`role`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_designation_foreign` (`designation`),
  ADD KEY `users_blood_group_foreign` (`blood_group`),
  ADD KEY `users_religion_foreign` (`religion`);

--
-- Indexes for table `user_holidays`
--
ALTER TABLE `user_holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_holidays_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_leave_types`
--
ALTER TABLE `user_leave_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_leave_types_user_id_foreign` (`user_id`),
  ADD KEY `user_leave_types_leave_type_id_foreign` (`leave_type_id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_permissions_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accepted_leaves`
--
ALTER TABLE `accepted_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_groups`
--
ALTER TABLE `blood_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `changes`
--
ALTER TABLE `changes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_types`
--
ALTER TABLE `contract_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `default_clockouts`
--
ALTER TABLE `default_clockouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `department_holidays`
--
ALTER TABLE `department_holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `employee_ids`
--
ALTER TABLE `employee_ids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income_taxes`
--
ALTER TABLE `income_taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `payroll_incomes`
--
ALTER TABLE `payroll_incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `religions`
--
ALTER TABLE `religions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_paids`
--
ALTER TABLE `salary_paids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_payment_details`
--
ALTER TABLE `salary_payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_slabs`
--
ALTER TABLE `tax_slabs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_holidays`
--
ALTER TABLE `user_holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_leave_types`
--
ALTER TABLE `user_leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accepted_leaves`
--
ALTER TABLE `accepted_leaves`
  ADD CONSTRAINT `accepted_leaves_leave_id_foreign` FOREIGN KEY (`leave_id`) REFERENCES `leaves` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accepted_leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_holiday_id_foreign` FOREIGN KEY (`holiday_id`) REFERENCES `holidays` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_leave_id_foreign` FOREIGN KEY (`leave_id`) REFERENCES `leaves` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `changes`
--
ALTER TABLE `changes`
  ADD CONSTRAINT `changes_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `department_holidays`
--
ALTER TABLE `department_holidays`
  ADD CONSTRAINT `department_holidays_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pivot_user_contracts`
--
ALTER TABLE `pivot_user_contracts`
  ADD CONSTRAINT `pivot_user_contracts_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contract_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pivot_user_contracts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_payment_details`
--
ALTER TABLE `salary_payment_details`
  ADD CONSTRAINT `salary_payment_details_salary_paid_id_foreign` FOREIGN KEY (`salary_paid_id`) REFERENCES `salary_paids` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `salary_payment_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tax_slabs`
--
ALTER TABLE `tax_slabs`
  ADD CONSTRAINT `tax_slabs_income_tax_id_foreign` FOREIGN KEY (`income_tax_id`) REFERENCES `income_taxes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_blood_group_foreign` FOREIGN KEY (`blood_group`) REFERENCES `blood_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_designation_foreign` FOREIGN KEY (`designation`) REFERENCES `designations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_religion_foreign` FOREIGN KEY (`religion`) REFERENCES `religions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_foreign` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_holidays`
--
ALTER TABLE `user_holidays`
  ADD CONSTRAINT `user_holidays_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_leave_types`
--
ALTER TABLE `user_leave_types`
  ADD CONSTRAINT `user_leave_types_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_leave_types_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
