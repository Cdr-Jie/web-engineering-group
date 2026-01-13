-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2026 at 01:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `solo_project_bi23110228`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `organizer` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `type` enum('Workshop','Seminar','Competition','Festival','Sport','Course') NOT NULL,
  `venue` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `mode` enum('Physical','Online','Hybrid') NOT NULL,
  `registration_close` date NOT NULL,
  `max_participants` int(11) DEFAULT NULL,
  `fee` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `posters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`posters`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `organizer`, `contact_person`, `contact_no`, `type`, `venue`, `date`, `time`, `mode`, `registration_close`, `max_participants`, `fee`, `remarks`, `posters`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'chess', 'tourney', 'fide', 'chan', '012-3456789', 'Competition', 'UMS', '2026-11-11', '23:00:00', 'Physical', '2026-01-31', 150, '10', NULL, '[\"events\\/YEWGMrUwnDH6k29xIdeSA6PQCOfggcFFvSxSyrp3.jpg\"]', '2026-01-12 19:17:31', '2026-01-12 19:17:31', 1),
(2, 'Beach party', 'ODEC beach party', 'CCMM', 'Tan', '0652589976', 'Festival', 'Odec', '2026-02-14', '20:00:00', 'Physical', '2026-02-14', NULL, '0', NULL, '[\"events\\/4t6I5smX5y5xt5YJhICTj8oJFZFAesYvPYBdxqlr.jpg\"]', '2026-01-13 01:25:31', '2026-01-13 01:25:31', 1),
(3, 'Cross country', 'Cross country across KK', 'SUKMA', 'arif', '12349876', 'Competition', 'Kota Kinabalu', '2026-03-01', '07:00:00', 'Physical', '2026-02-12', 400, '30', NULL, '[\"events\\/Uege1URx4Z9dmY1N5em4fTJOYkG4jGJai3nVgAWV.jpg\"]', '2026-01-13 02:28:18', '2026-01-13 02:28:18', 2),
(4, 'Futsal', 'Futsal training', 'KakiKita', 'mohdamin', '0185745502', 'Sport', 'Likas Stadium', '2026-02-02', '17:00:00', 'Physical', '2026-02-02', 30, 'Free', NULL, '[\"events\\/JUbeHDhsnfxzoPaLSC1VWNZ62JbHIaAb712KKvho.jpg\"]', '2026-01-13 02:48:10', '2026-01-13 02:48:10', 1),
(5, '500m Sprint', '500 meter sprint', 'KarKums', 'Chin', '0123459876', 'Competition', 'Padang Kawad UMS', '2026-01-14', '08:00:00', 'Physical', '2026-01-14', NULL, 'Free', NULL, '[\"events\\/mGPgxCM2xCifGpdIHnJxgwy4xVgxo4QntiUFUS5b.jpg\",\"events\\/1qNRSgUB7zI6ooIClLtxoqGplTVHi0m49DC7RvJw.jpg\"]', '2026-01-13 02:57:17', '2026-01-13 02:57:17', 2),
(6, 'Photography workshop', 'Spearheaded by MediaUMS', 'MediaUMS', NULL, NULL, 'Workshop', 'UMS', '2026-02-02', '14:00:00', 'Online', '2026-02-01', NULL, '5', NULL, '[\"events\\/qoFAnv1hWy8CklE2oG4KncGlWqvMBlDbsU4YkppW.jpg\"]', '2026-01-13 02:58:56', '2026-01-13 02:58:56', 2),
(7, 'Art showcase', 'ASTIF art showcase', 'ASTIF', NULL, NULL, 'Seminar', 'ASTIF', '2026-03-01', '10:00:00', 'Hybrid', '2026-02-20', NULL, '0', NULL, '[\"events\\/4Muz1y9p3vK4iBHRrRFT5BdRb99LO4MaEi6zOpE7.jpg\"]', '2026-01-13 03:02:38', '2026-01-13 03:02:38', 1),
(8, 'Office prep course', 'Industry leading in office spaces teaches office interior design', 'Cedec', NULL, NULL, 'Course', 'DKP 1', '2026-02-08', '08:00:00', 'Physical', '2026-01-15', 50, '30', NULL, '[\"events\\/Ufl4xR4BGwNvGExFcW5a75zCmwBnc5eWo35u0ZC4.jpg\"]', '2026-01-13 03:04:23', '2026-01-13 03:04:23', 1),
(9, 'Cleanup', 'Cleanup at aisle 5, try being a janitor for a day to earn some cash', 'GreenLove', NULL, NULL, 'Course', 'Likas', '2026-03-10', '06:00:00', 'Physical', '2026-03-01', 40, '0', NULL, '[\"events\\/Dq42a2VcoVGOD1ePoao5aWwvEHShFAQ6X1EBgLJU.jpg\"]', '2026-01-13 03:12:20', '2026-01-13 03:12:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

CREATE TABLE `event_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_registrations`
--

INSERT INTO `event_registrations` (`id`, `event_id`, `user_id`, `name`, `email`, `payment`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', 10.00, '2026-01-12 19:17:46', '2026-01-12 19:17:46'),
(4, 2, 2, 'John Doe', 'test@gmail.com', 0.00, '2026-01-13 02:28:44', '2026-01-13 02:28:44'),
(5, 3, 1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', 30.00, '2026-01-13 02:40:09', '2026-01-13 02:40:09'),
(6, 2, 1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', 0.00, '2026-01-13 02:40:12', '2026-01-13 02:40:12'),
(7, 4, 1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', 0.00, '2026-01-13 02:49:01', '2026-01-13 02:49:01'),
(8, 6, 1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', 5.00, '2026-01-13 02:59:56', '2026-01-13 02:59:56'),
(9, 5, 1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', 0.00, '2026-01-13 02:59:59', '2026-01-13 02:59:59'),
(10, 7, 1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', 0.00, '2026-01-13 03:02:52', '2026-01-13 03:02:52'),
(11, 8, 1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', 30.00, '2026-01-13 03:04:29', '2026-01-13 03:04:29'),
(12, 9, 1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', 0.00, '2026-01-13 03:12:24', '2026-01-13 03:12:24');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(18, '0001_01_01_000001_create_cache_table', 1),
(19, '0001_01_01_000002_create_jobs_table', 1),
(20, '2026_01_10_074103_create_users_table', 1),
(21, '2026_01_12_102715_create_events_table', 1),
(22, '2026_01_12_111133_create_sessions_table', 1),
(23, '2026_01_12_114729_create_event_registrations_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fgQvNQw8hicYndRsMsGjg1NkeVSx08ggJyDFzxJ0', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 OPR/125.0.0.0 (Edition cdf)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid2RvajhNbUh1Y2d1M0lxSnVJTG9XeE1yd2NsNjE5eWY4WVJQWEV1ayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1768306327);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `category` enum('staff','student','public') NOT NULL,
  `events` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`events`)),
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `category`, `events`, `profile_image`, `created_at`, `updated_at`) VALUES
(1, 'CHAN ZHI JIE', 'CHANZHIJIE_BI23@iluv.ums.edu.my', '$2y$12$jVytHWYpdtcUWQCp9uCNY.yP3qjmRPJwXOGg6N.CZ09CfyEze/a/m', '(+60) 18 571 6608', 'public', '\"Workshop\"', 'profiles/ttzvMHoZ3jxArBsoaUpA7vCg0Ilu1kfAl6RjRW60.jpg', '2026-01-12 19:15:11', '2026-01-13 02:23:08'),
(2, 'John Doe', 'test@gmail.com', '$2y$12$.PPui/WFIIwkMSExr3h5d.qtJTiHdUk85lzmQ9ld4tVfv6PcNBrW6', '987654321', 'student', '\"Competition\"', 'profiles/YBnvPUjT5sRva69qwkm0071phiIyDwjqYrPvEPUg.jpg', '2026-01-13 02:25:58', '2026-01-13 02:26:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_user_id_foreign` (`user_id`);

--
-- Indexes for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_registrations_event_id_foreign` (`event_id`),
  ADD KEY `event_registrations_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD CONSTRAINT `event_registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
