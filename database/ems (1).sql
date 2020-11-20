-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2020 at 12:56 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `authorities`
--

CREATE TABLE `authorities` (
  `id` int(11) NOT NULL,
  `authority_name` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authorities`
--

INSERT INTO `authorities` (`id`, `authority_name`, `created_at`, `updated_at`) VALUES
(1, 'nehruajith.k', '2020-11-04 02:37:25', '2020-11-04 03:12:30'),
(2, 'nehru.k', '2020-11-04 03:08:33', '2020-11-04 03:08:33'),
(5, 'nehru.k', '2020-11-04 03:08:44', '2020-11-04 03:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(11) NOT NULL,
  `designation_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `designation_name`) VALUES
(1, 'Sr.Engineer');

-- --------------------------------------------------------

--
-- Table structure for table `emp_attendance`
--

CREATE TABLE `emp_attendance` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `work_time` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_attendance`
--

INSERT INTO `emp_attendance` (`id`, `emp_id`, `project_id`, `date`, `in_time`, `out_time`, `status`, `work_time`, `created_at`, `updated_at`) VALUES
(1, 8, 1, '2020-11-19', '12:01:00', '12:01:00', 'Absent', '0', '2020-11-19 06:48:12', '2020-11-19 06:48:12'),
(2, 8, 1, '2020-11-19', '12:00:00', '12:00:00', 'Absent', '0', '2020-11-19 06:50:03', '2020-11-19 06:50:03');

-- --------------------------------------------------------

--
-- Table structure for table `emp_bankdetails`
--

CREATE TABLE `emp_bankdetails` (
  `id` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `bankname` varchar(250) DEFAULT NULL,
  `acnumber` varchar(16) DEFAULT NULL,
  `branch` varchar(250) DEFAULT NULL,
  `ifsc` char(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_bankdetails`
--

INSERT INTO `emp_bankdetails` (`id`, `empid`, `bankname`, `acnumber`, `branch`, `ifsc`, `created_at`, `updated_at`) VALUES
(1, 6, 'TMB1', '123456789', 'velachery1', '9677925018', '2020-11-05 03:44:53', '2020-11-08 01:06:56'),
(19, 8, 'BOB', '123456789', 'TN', '785214', '2020-11-18 00:49:40', '2020-11-18 00:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `emp_details`
--

CREATE TABLE `emp_details` (
  `id` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `emp_name` varchar(250) NOT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `mail` varchar(250) DEFAULT NULL,
  `mobile` varchar(150) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `date_of_leaving` date DEFAULT NULL,
  `last_appraisal_date` date DEFAULT NULL,
  `reporting_authority_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_details`
--

INSERT INTO `emp_details` (`id`, `emp_code`, `emp_name`, `designation_id`, `project_id`, `location_id`, `mail`, `mobile`, `department_id`, `date_of_joining`, `date_of_leaving`, `last_appraisal_date`, `reporting_authority_id`, `status_id`, `created_at`, `updated_at`) VALUES
(6, 'ghghfdg1234', 'dffddfgfd1', 1, 1, 1, 'nehru97bca@gmail.com1', '96779250181', NULL, '2020-01-01', '2020-01-01', '2020-01-01', 5, 1, '2020-11-04 04:37:44', '2020-11-05 07:27:03'),
(7, '121334', 'dffddfgfd', 1, 2, 1, 'nehru97bca@gmail.com', '09677925018', NULL, '2020-10-11', '2020-09-11', '2020-10-11', 5, 2, '2020-11-09 04:04:29', '2020-11-09 04:04:29'),
(8, 'LnT101', 'jp', 1, 1, 2, 'jp@mail.com', '7894561235', NULL, '2020-01-01', '1970-01-01', '1970-01-01', NULL, 4, '2020-11-18 00:48:55', '2020-11-18 00:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `emp_leaveform`
--

CREATE TABLE `emp_leaveform` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date DEFAULT NULL,
  `reason` varchar(250) DEFAULT NULL,
  `leave_type` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_personal_details`
--

CREATE TABLE `emp_personal_details` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `present_address` text DEFAULT NULL,
  `perment_address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_remuneration_details`
--

CREATE TABLE `emp_remuneration_details` (
  `id` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `salary_structure` varchar(255) DEFAULT NULL,
  `esi_applicability` enum('Yes','No','') DEFAULT NULL,
  `pf_applicablity` enum('Yes','No','') DEFAULT NULL,
  `restrict_pf` enum('Yes','No','') DEFAULT NULL,
  `basic` double DEFAULT NULL,
  `hra` double DEFAULT NULL,
  `splallowance` double DEFAULT NULL,
  `dearness_allowance` double DEFAULT NULL,
  `conveyance` double DEFAULT NULL,
  `lta` double DEFAULT NULL,
  `medical` double DEFAULT NULL,
  `other_allowance` double DEFAULT NULL,
  `gross_salary` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_remuneration_details`
--

INSERT INTO `emp_remuneration_details` (`id`, `empid`, `salary_structure`, `esi_applicability`, `pf_applicablity`, `restrict_pf`, `basic`, `hra`, `splallowance`, `dearness_allowance`, `conveyance`, `lta`, `medical`, `other_allowance`, `gross_salary`, `created_at`, `updated_at`) VALUES
(13, 6, 'Modern', 'Yes', 'Yes', 'Yes', 8400, 4200, 0, 840, 1600, 700, 700, 4560, 21000, '2020-11-04 23:46:10', '2020-11-05 23:58:45'),
(14, 8, 'Modern', 'Yes', 'Yes', 'Yes', 10000, 5000, 0, 1000, 1600, 833, 833, 5734, 25000, '2020-11-18 00:49:15', '2020-11-18 00:49:15');

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary_uploads`
--

CREATE TABLE `emp_salary_uploads` (
  `id` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `staff_type` varchar(20) DEFAULT NULL,
  `month` date NOT NULL,
  `salary_structure` varchar(250) DEFAULT NULL,
  `gross` double DEFAULT NULL,
  `statutory_rate` double DEFAULT NULL,
  `leavedays` float DEFAULT NULL,
  `spl_leave` double DEFAULT NULL,
  `lop_days` float DEFAULT NULL,
  `allowance_paid` double DEFAULT NULL,
  `over_time` double DEFAULT NULL,
  `holiday_pay` double DEFAULT NULL,
  `arrear` double DEFAULT NULL,
  `special_allowance` double DEFAULT NULL,
  `caution_deposit` double DEFAULT NULL,
  `advance` double DEFAULT NULL,
  `mobile` double DEFAULT NULL,
  `loan` double DEFAULT NULL,
  `insurance` double DEFAULT NULL,
  `rent` double DEFAULT NULL,
  `tds` double DEFAULT NULL,
  `lwf` double DEFAULT NULL,
  `others` double DEFAULT NULL,
  `priority` enum('Yes','No') DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `status` enum('Uploaded','Salary Generated') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_staff_pay_scales`
--

CREATE TABLE `emp_staff_pay_scales` (
  `id` int(11) NOT NULL,
  `salarystructure` varchar(50) NOT NULL,
  `basic` double NOT NULL,
  `dearness_allowance` double NOT NULL,
  `hra` double NOT NULL,
  `conveyance_allowance` double NOT NULL,
  `lta` double NOT NULL,
  `medical` double NOT NULL,
  `pli` double NOT NULL,
  `other_allowance` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `emp_staff_pay_scales`
--

INSERT INTO `emp_staff_pay_scales` (`id`, `salarystructure`, `basic`, `dearness_allowance`, `hra`, `conveyance_allowance`, `lta`, `medical`, `pli`, `other_allowance`) VALUES
(1, 'Conventional', 0.4, 0.04, 0.2, 0, 0, 0, 0, ''),
(2, 'Modern', 0.4, 0.04, 0.2, 1600, 0.0833, 0.0833, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `emp_statutorydetails`
--

CREATE TABLE `emp_statutorydetails` (
  `id` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `esino` varchar(20) DEFAULT NULL,
  `esidispensary` varchar(20) DEFAULT NULL,
  `epfno` varchar(20) DEFAULT NULL,
  `epfuanno` char(12) DEFAULT NULL,
  `professionaltax` enum('Yes','No') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_statutorydetails`
--

INSERT INTO `emp_statutorydetails` (`id`, `empid`, `esino`, `esidispensary`, `epfno`, `epfuanno`, `professionaltax`, `created_at`, `updated_at`) VALUES
(2, 6, '1234567', '12345678', '1234567', '1334457', 'No', '2020-11-05 03:33:57', '2020-11-06 00:17:29'),
(3, 8, NULL, NULL, NULL, NULL, 'Yes', '2020-11-18 00:49:23', '2020-11-18 00:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `location` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location`, `created_at`, `updated_at`) VALUES
(1, 'chennai1111', '2020-11-02 06:04:13', '2020-11-02 06:58:00'),
(2, 'chennai', '2020-11-02 06:06:00', '2020-11-02 06:06:00'),
(3, 'chennai', '2020-11-02 06:14:12', '2020-11-02 06:14:12'),
(4, 'chennai', '2020-11-02 06:14:20', '2020-11-02 06:14:20'),
(5, 'chennai', '2020-11-02 06:15:37', '2020-11-02 06:15:37');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2020_10_31_053300_create_sessions_table', 1);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_details`
--

CREATE TABLE `project_details` (
  `id` int(11) NOT NULL,
  `project_name` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_details`
--

INSERT INTO `project_details` (`id`, `project_name`, `created_at`, `updated_at`) VALUES
(1, 'sample project1', '2020-11-02 05:21:53', '2020-11-02 06:37:57'),
(2, 'sample project', '2020-11-02 06:34:59', '2020-11-02 06:34:59'),
(3, 'project1234412345556', '2020-11-02 06:40:25', '2020-11-02 06:40:39');

-- --------------------------------------------------------

--
-- Table structure for table `remunerations`
--

CREATE TABLE `remunerations` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `base_pay` int(11) DEFAULT NULL,
  `hra` int(11) DEFAULT NULL,
  `spl_allowance` int(11) DEFAULT NULL,
  `conveyance` int(11) DEFAULT NULL,
  `medical_allowance` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reporting_authorities`
--

CREATE TABLE `reporting_authorities` (
  `id` int(11) NOT NULL,
  `authority_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salary_months`
--

CREATE TABLE `salary_months` (
  `id` int(11) NOT NULL,
  `month` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RUFHcYucV6nj1HeEpmHNMRnfdQXnsHxagOBwnKDn', 2, '::1', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWDBjbkJ4NzJZcVVlNXJuWG5GMFZLbVVoSnV5SkZaNHFwMXozbXVrViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3QvZW1zL3B1YmxpYy9hdHRlbmRhbmNlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJG9NVUpLTndacW1vZ1V3ZkpyREg1ay5uQmZZUEFZOTUzMDh2NVYyamEuUXlWeU02ZzByRXFXIjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCRvTVVKS053WnFtb2dVd2ZKckRINWsubkJmWVBBWTk1MzA4djVWMmphLlF5VnlNNmcwckVxVyI7fQ==', 1605687882),
('tOiHIXxmTkFANOFmmM0r2W3c2YBpSm9aewKLZ45O', 2, '::1', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoieFgxVklXZVQ3UFpCVXpiaEt5bFdqZm1XMndrMTNuMTdOZ25DZ3YzbiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vbG9jYWxob3N0L2Vtcy9wdWJsaWMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkb01VSktOd1pxbW9nVXdmSnJESDVrLm5CZllQQVk5NTMwOHY1VjJqYS5ReVZ5TTZnMHJFcVciO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJG9NVUpLTndacW1vZ1V3ZkpyREg1ay5uQmZZUEFZOTUzMDh2NVYyamEuUXlWeU02ZzByRXFXIjt9', 1605776191),
('xOKkE0EvDS3Prp0kPfaiyTkdHtQlImPzgM6UPp04', 2, '::1', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiV2tLaUN5clFsN0FHUno1M1owaHRJU2V3NVdVT2w2MXRQVVc1N3B2dSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM4OiJodHRwOi8vbG9jYWxob3N0L2Vtcy9wdWJsaWMvYXR0ZW5kYW5jZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCRvTVVKS053WnFtb2dVd2ZKckRINWsubkJmWVBBWTk1MzA4djVWMmphLlF5VnlNNmcwckVxVyI7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkb01VSktOd1pxbW9nVXdmSnJESDVrLm5CZllQQVk5NTMwOHY1VjJqYS5ReVZ5TTZnMHJFcVciO30=', 1605788753);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `status` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Active11', '2020-11-02 07:41:11', '2020-11-02 07:47:30'),
(2, 'Active1234', '2020-11-02 07:46:28', '2020-11-02 07:47:39'),
(3, 'Active1234', '2020-11-02 07:46:34', '2020-11-02 07:47:55'),
(4, 'Active', '2020-11-02 07:46:46', '2020-11-02 07:46:46'),
(5, 'Active', '2020-11-02 07:46:52', '2020-11-02 07:46:52'),
(6, 'Active', '2020-11-02 07:47:48', '2020-11-02 07:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `emp_id`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Developer', 'dev@mail.com', NULL, '$2y$10$O78xFCFEVBu..Gc0HWjEUe1C250PcnkP31rUdh2dCyAjk3KrLM9Pq', 'Administrator', NULL, NULL, NULL, 'WiGxWrHmrBAodDIWixdrS1LlTZ4RksRAZ1N2QP6t3RkUB3m0itf8EPoTsxyH', NULL, NULL, '2020-10-31 00:07:23', '2020-10-31 00:07:23'),
(2, 'jp', 'jp@mail.com', NULL, '$2y$10$oMUJKNwZqmogUwfJrDH5k.nBfYPAY95308v5V2ja.QyVyM6g0rEqW', 'Employee', 8, NULL, NULL, NULL, NULL, NULL, '2020-11-18 00:34:44', '2020-11-18 00:34:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authorities`
--
ALTER TABLE `authorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_attendance`
--
ALTER TABLE `emp_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index` (`emp_id`,`project_id`) USING BTREE;

--
-- Indexes for table `emp_bankdetails`
--
ALTER TABLE `emp_bankdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_details`
--
ALTER TABLE `emp_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_leaveform`
--
ALTER TABLE `emp_leaveform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_personal_details`
--
ALTER TABLE `emp_personal_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_remuneration_details`
--
ALTER TABLE `emp_remuneration_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_salary_uploads`
--
ALTER TABLE `emp_salary_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_staff_pay_scales`
--
ALTER TABLE `emp_staff_pay_scales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_statutorydetails`
--
ALTER TABLE `emp_statutorydetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `project_details`
--
ALTER TABLE `project_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remunerations`
--
ALTER TABLE `remunerations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reporting_authorities`
--
ALTER TABLE `reporting_authorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_months`
--
ALTER TABLE `salary_months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `authorities`
--
ALTER TABLE `authorities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `emp_attendance`
--
ALTER TABLE `emp_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_bankdetails`
--
ALTER TABLE `emp_bankdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `emp_details`
--
ALTER TABLE `emp_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `emp_leaveform`
--
ALTER TABLE `emp_leaveform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_personal_details`
--
ALTER TABLE `emp_personal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_remuneration_details`
--
ALTER TABLE `emp_remuneration_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `emp_salary_uploads`
--
ALTER TABLE `emp_salary_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `emp_staff_pay_scales`
--
ALTER TABLE `emp_staff_pay_scales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_statutorydetails`
--
ALTER TABLE `emp_statutorydetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_details`
--
ALTER TABLE `project_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `remunerations`
--
ALTER TABLE `remunerations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reporting_authorities`
--
ALTER TABLE `reporting_authorities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_months`
--
ALTER TABLE `salary_months`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
