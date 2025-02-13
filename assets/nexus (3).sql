-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 13, 2025 at 09:30 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nexus`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `post_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(48, 69, 14, 'looks amazing!!🤩 ', '2025-01-10 21:40:28'),
(49, 69, 14, 'heyy!', '2025-01-10 23:34:54'),
(50, 70, 15, 'darkk!', '2025-01-18 04:17:29'),
(51, 74, 14, 'cool', '2025-01-18 04:23:15'),
(52, 70, 16, 'boi', '2025-01-24 12:29:07'),
(53, 75, 14, 'Boys', '2025-01-24 12:36:55'),
(54, 76, 14, 'ho ho', '2025-02-08 17:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
CREATE TABLE IF NOT EXISTS `follows` (
  `follower_id` int NOT NULL,
  `followed_id` int NOT NULL,
  `followed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`follower_id`,`followed_id`),
  KEY `followed_id` (`followed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`follower_id`, `followed_id`, `followed_at`) VALUES
(13, 12, '2025-01-10 23:09:14'),
(13, 14, '2025-01-10 23:09:17'),
(13, 15, '2025-01-10 23:35:36'),
(14, 13, '2025-01-10 23:11:05'),
(14, 16, '2025-01-24 12:28:01'),
(14, 17, '2025-02-08 17:09:36'),
(15, 13, '2025-01-18 04:20:28'),
(15, 14, '2025-01-18 04:16:41'),
(16, 13, '2025-01-24 12:25:02'),
(16, 14, '2025-01-24 12:24:59'),
(16, 15, '2025-01-24 12:39:16'),
(17, 12, '2025-02-08 17:05:52'),
(17, 13, '2025-02-08 17:05:59'),
(17, 14, '2025-02-08 17:06:29'),
(17, 16, '2025-02-08 17:07:16');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `liked_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`post_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `post_id`, `liked_at`) VALUES
(13, 69, '2025-01-10 23:00:06'),
(14, 69, '2025-01-10 23:15:19'),
(14, 70, '2025-01-10 23:13:13'),
(14, 74, '2025-01-18 04:22:05'),
(14, 75, '2025-01-24 12:36:42'),
(14, 76, '2025-02-08 17:24:20'),
(15, 69, '2025-01-18 04:20:44'),
(15, 70, '2025-01-18 04:05:30'),
(16, 69, '2025-01-24 12:43:41'),
(16, 70, '2025-01-24 12:28:42'),
(16, 74, '2025-01-24 12:40:50'),
(17, 70, '2025-02-08 17:06:49'),
(17, 75, '2025-02-08 17:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `content` text,
  `message_type` enum('text','image','audio') DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=326 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `content`, `message_type`, `created_at`) VALUES
(295, 13, 14, 'caq2yQ4Z+QpYoh+SfO7RvlFtVU0vRWQxcWFvd2ZEVFJBNklEZHc9PQ==', 'text', '2025-01-10 21:32:09'),
(296, 14, 13, 'wjTrRF83epKLgQt118tHqFVUSDJ2dW9zSjRoWG9RZnUwdG9nSEE9PQ==', 'text', '2025-01-10 21:37:31'),
(297, 13, 14, 'uQ7Zh0fsi9W5vBOYBO9fXGpLdzMwODFVbW85cGo0TkNiaXVFNUE9PQ==', 'text', '2025-01-10 21:37:44'),
(298, 14, 13, 'romcvCKEG8kQAZfOwpUBcENvRksyb2lQc09Jejh4K09OaktmcXZGYnVCTC9LaTNmQ3NndG90dXlPdk09', 'text', '2025-01-10 21:37:46'),
(299, 14, 13, 'OEOqT6PTdZ1ILpFewT5GcktVa0p5dW1rRmdhTUdZeVczMG5wL3c9PQ==', 'text', '2025-01-10 21:37:52'),
(300, 14, 13, 'O3O6Dlh+XsjVR8UZLjmvHkZLd2xMd1ppWktHNWpXZGo1b0l3UHlueERHd1FYblhwNStXQ0x4QURLK1kwT2IrbzY5YWtTdVJCZlIvZGRvQU0=', 'text', '2025-01-10 21:38:20'),
(301, 14, 13, 'MHY47RO2oIyZ58Ehmk/Sf2JnT2hzZmNHWFpSQndDeEZvdVAvRXBPTytqOGo1STB2RGUyZkFYYm1JZkdac2pSL3dodUkza2pVNGhxZy9xTXU4ZVNwV0ZGWlh4Mm91dmFRWW1CcVNVMVgwNFk3VGJ2ejhodEJrdGVxU2dsZkY1L2o3M1l1YVo1SlRqalh1dG8z', 'text', '2025-01-10 21:38:45'),
(302, 13, 14, 'dNhXm290vEi+G2uabCRz5lhnOVA4WnNvWnkwblplMjZNTVdjUUdsblNHMSs5VEtOQkRPaEt1UnVjOFE9', 'text', '2025-01-10 21:39:20'),
(305, 14, 13, '2MRMKBBqxWUcRZhk2oLvd1Y0ZDVpZUIvd2s0ZCtBVjUzQjBYVkoxY1BmbnJ1WHpEcXdQK1lrLzNEWlk9', 'text', '2025-01-10 22:34:53'),
(316, 14, 15, 'qOZgPKR58sCZBZhjRkBxyUhjQ0dhQXYreHMwYlFnQk5jQyswZEE9PQ==', 'text', '2025-01-18 03:59:36'),
(317, 15, 14, 'ApayF5Iig4hQpNWxRe8HrWJnZ2xEMHBhUHlzNFA4cFdKZ29MSFE9PQ==', 'text', '2025-01-18 04:01:06'),
(318, 15, 14, 'Oh9IjokHC4jJlLF7lFB+IUV4SnBzcTdweWR2RjlUTWUyYmpQbWc9PQ==', 'text', '2025-01-18 04:22:37'),
(319, 14, 15, 'tLZsZBlqzyR10PJ7G2nzGkZQNHJtN0dieXlYNHloRy85QTV6ZUE9PQ==', 'text', '2025-01-18 04:22:45'),
(320, 16, 14, 'CDTt2IobYlEWEAlobjVbxEVuN2xmMDVWVWFKMDR6RU9icm5welE9PQ==', 'text', '2025-01-24 12:37:40'),
(321, 14, 16, 'MhfEflfrdDLgDXiiArY2NElyV1A3dUtUS3JXbTlaMmJrSTZGMnc9PQ==', 'text', '2025-01-24 12:37:47'),
(322, 16, 14, 'ekhGV7NedBhy3UNgu3+XEUhydi9yTHNqMURkSDRmbExSR3Nid2c9PQ==', 'text', '2025-01-24 12:37:54'),
(323, 17, 14, 'zKccSrKplVlXHEN4sSSwNW8rTlZYRlJhT3lGaWZRYnVLZkRyZXc9PQ==', 'text', '2025-02-08 17:08:18'),
(324, 14, 17, 'FCW2YDlugc+HHZvbWYweOGQ0b05RanVOcFFQTzB0RnZ3SXJVakE9PQ==', 'text', '2025-02-08 17:10:05'),
(325, 17, 14, 't/JsAWPQKiPP1sLswru7T3V4QWgzc0R2L3QvVEkvQWtPdzFFMEE9PQ==', 'text', '2025-02-08 17:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1735263562),
('m150214_044831_init_user', 1735263565),
('m250101_040719_add_comment_id_to_notifications', 1735704458),
('m250101_041148_add_comment_id_to_notifications', 1735704721),
('m250101_041509_add_comment_id_to_notifications', 1735704925),
('m250101_042126_add_comment_id_to_notifications', 1735769102),
('m250101_215605_add_active_status_to_usersmain', 1735769102),
('m250101_220740_add_active_status_to_usersmain', 1735769301),
('m250101_220935_add_active_status_to_usersmain', 1735769433);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int DEFAULT NULL,
  `notification_text` text,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(15) DEFAULT NULL,
  `post_id` int NOT NULL,
  `receiver_id` int DEFAULT NULL,
  `comment_id` int DEFAULT NULL,
  PRIMARY KEY (`notification_id`),
  KEY `user_id` (`sender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `sender_id`, `notification_text`, `is_read`, `created_at`, `type`, `post_id`, `receiver_id`, `comment_id`) VALUES
(106, 14, ' liked your post.', 0, '2025-01-10 23:13:13', 'like', 70, 14, NULL),
(110, 14, ' liked your post.', 0, '2025-01-10 23:15:19', 'like', 69, 13, NULL),
(111, 14, ' commented: ', 0, '2025-01-10 23:34:54', 'comment', 69, 13, 49),
(114, 15, ' liked your post.', 0, '2025-01-18 04:05:30', 'like', 70, 14, NULL),
(115, 15, 'Started Following You', 0, '2025-01-18 04:16:41', 'follow', 0, 14, NULL),
(116, 15, ' commented: ', 0, '2025-01-18 04:17:29', 'comment', 70, 14, 50),
(117, 15, ' liked your post.', 0, '2025-01-18 04:20:44', 'like', 69, 13, NULL),
(118, 15, ' added a new post.', 0, '2025-01-18 04:21:48', 'post', 74, NULL, NULL),
(119, 14, ' liked your post.', 0, '2025-01-18 04:22:05', 'like', 74, 15, NULL),
(120, 14, ' commented: ', 0, '2025-01-18 04:23:15', 'comment', 74, 15, 51),
(121, 16, 'Started Following You', 0, '2025-01-24 12:24:59', 'follow', 0, 14, NULL),
(122, 16, 'Started Following You', 0, '2025-01-24 12:25:02', 'follow', 0, 13, NULL),
(123, 16, ' liked your post.', 0, '2025-01-24 12:28:42', 'like', 70, 14, NULL),
(124, 16, ' commented: ', 0, '2025-01-24 12:29:07', 'comment', 70, 14, 52),
(125, 16, ' added a new post.', 0, '2025-01-24 12:32:48', 'post', 75, NULL, NULL),
(126, 14, ' liked your post.', 0, '2025-01-24 12:36:42', 'like', 75, 16, NULL),
(127, 14, ' commented: ', 0, '2025-01-24 12:36:55', 'comment', 75, 16, 53),
(128, 16, ' liked your post.', 0, '2025-01-24 12:40:50', 'like', 74, 15, NULL),
(129, 16, ' liked your post.', 0, '2025-01-24 12:43:41', 'like', 69, 13, NULL),
(130, 17, 'Started Following You', 0, '2025-02-08 17:05:59', 'follow', 0, 13, NULL),
(131, 17, 'Started Following You', 0, '2025-02-08 17:06:29', 'follow', 0, 14, NULL),
(132, 17, ' liked your post.', 0, '2025-02-08 17:06:49', 'like', 70, 14, NULL),
(133, 17, 'Started Following You', 0, '2025-02-08 17:07:16', 'follow', 0, 16, NULL),
(134, 17, ' liked your post.', 0, '2025-02-08 17:07:46', 'like', 75, 16, NULL),
(135, 14, 'Started Following You', 0, '2025-02-08 17:09:36', 'follow', 0, 17, NULL),
(136, 17, ' added a new post.', 0, '2025-02-08 17:23:09', 'post', 76, NULL, NULL),
(137, 14, ' liked your post.', 0, '2025-02-08 17:24:20', 'like', 76, 17, NULL),
(138, 14, ' commented: ', 0, '2025-02-08 17:24:38', 'comment', 76, 17, 54);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `content` text,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `content`, `image_path`, `created_at`) VALUES
(69, 13, 'Project is finally done!!', '/uploads/posts/post_1736544842.jpg', '2025-01-10 21:34:02'),
(70, 14, 'Peace of mind ✌️', '/uploads/posts/post_1736546966.jpeg', '2025-01-10 22:09:26'),
(74, 15, 'Vagabond!', '/uploads/posts/post_1737174108.png', '2025-01-18 04:21:48'),
(75, 16, 'Brothers in arm!!', '/uploads/posts/post_1737721968.jpg', '2025-01-24 12:32:48'),
(76, 17, 'Boka Gang', '/uploads/posts/post_1739035389.jpg', '2025-02-08 17:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `can_admin` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`, `can_admin`) VALUES
(1, 'Admin', '2024-12-27 01:39:25', NULL, 1),
(2, 'User', '2024-12-27 01:39:25', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `status` smallint NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `logged_in_ip` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `logged_in_at` timestamp NULL DEFAULT NULL,
  `created_ip` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  `banned_reason` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `fullname` varchar(45) COLLATE utf8mb3_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `profile_picture` varchar(150) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`email`),
  UNIQUE KEY `user_username` (`username`),
  KEY `user_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role_id`, `status`, `email`, `username`, `password`, `auth_key`, `access_token`, `logged_in_ip`, `logged_in_at`, `created_ip`, `created_at`, `updated_at`, `banned_at`, `banned_reason`, `fullname`, `gender`, `profile_picture`) VALUES
(12, 1, 1, 'kenjikun3289@gmail.com', 'kenjikun3289', '$2y$13$XdS.LqSpN7KJR/Bd3H.fzuB8Gzp6mBz8StVGBiMmkmlscG2OABn1y', 'DdZSMW6SDIg3SqI3k1RpQqAIX6fLl4Ag', 'st0FIaAYGCDeJyZ8OAgYT5gTreJ7-oUZ', '192.168.8.103', '2025-01-10 23:05:49', NULL, '2025-01-10 21:17:15', NULL, NULL, NULL, 'Endo Kenji', 'Male', '/uploads/profile_pictures/profile_kenjikun3289.png'),
(13, 1, 1, 'aradhyathapa47@gmail.com', 'aradhya47', '$2y$13$EFQZjddnN96B0n2d.tm.qeQFgsjyKSmbv0uMufmaS30E2RSvnzQWC', 'AWowwnQMsHPnCWPjGnyezwHlu7-fKPia', 'nLtZ_2ijXOEai0XsX6g8SU8UfdtmRjKJ', '::1', '2025-01-18 04:02:19', NULL, '2025-01-10 21:28:46', '2025-01-10 21:47:17', NULL, NULL, 'Aradhya Thapa', 'Female', '/uploads/profile_pictures/profile_13_1736545926.png'),
(14, 1, 1, 'anzalbartaula0@gmail.com', 'anzal69', '$2y$13$FzIIja8OlfV3ZruvqKggZOyv0yxPhnbdSVG.DgZj02Msf9YQDBtEm', 'WrEdyomJU7Ei6meeMVlUJxFKipNpbCQR', 'kMk5zMQDftM6mqJmOmxb04oChC2i0zBQ', '::1', '2025-02-08 17:24:14', NULL, '2025-01-10 21:29:19', NULL, NULL, NULL, 'Anjal Bartaula', 'Male', '/uploads/profile_pictures/profile_14_1736546110.jpg'),
(15, 1, 1, 'sanjokkandel3@gmail.com', 'sanjogkandel3289', '$2y$13$jATKmRhdRqAkFLG0oY9tZuO8i2j1vbEozLPpJDYzXLKH8E3IpttMS', 'Dmu0kltiKWh8KoEFXV4QExQ9jfbfyVEb', 'g_oqd67u-pJ_-6B9piknVh1L_Kl2VJdw', '::1', '2025-01-18 04:04:16', NULL, '2025-01-10 21:30:37', NULL, NULL, NULL, 'Sanjog Kandel', 'Male', '/uploads/profile_pictures/profile_15_1737172897.png'),
(16, 1, 1, 'arpanraut17@gmail.com', 'arpan3289', '$2y$13$95KjQA2VGnRRR1nx6yzcme8xuWqOFDNS5F3q8wGoTV1qso.t6UmEO', 'wW_IzaWiExvgH8OQQiXMgfkJ5vdgnRke', 'ItorAjPIIOeoUk0Eu4ruv1U4bQmuX-A9', '192.168.8.113', '2025-01-24 12:24:48', NULL, '2025-01-24 12:21:42', NULL, NULL, NULL, 'Arpan Raut', 'Male', '/uploads/profile_pictures/profile_16_1737721864.jpg'),
(17, 1, 1, 'pathaksagar065@gmail.com', 'sagar2004', '$2y$13$WOjUxUhwL9lh4G4vZne9MuKwMZqbBo9feXqj09BVUNw36JVrpbjt6', 'BV76ktHDA3vt9Vmxn2HajKGn3LnutrWQ', 'OvbO7ZUmLmixopSh_FL-a_uERqAz3zU8', '::1', '2025-02-08 17:20:47', NULL, '2025-02-08 17:05:09', NULL, NULL, NULL, 'Sagar Pathak', 'Male', '/uploads/profile_pictures/profile_17_1739034714.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `usersmain`
--

DROP TABLE IF EXISTS `usersmain`;
CREATE TABLE IF NOT EXISTS `usersmain` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `profile_image_path` varchar(255) DEFAULT NULL,
  `bio` text,
  `birthdate` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT 'other',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` tinyint(1) DEFAULT NULL,
  `admin_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usersmain`
--

INSERT INTO `usersmain` (`user_id`, `username`, `email`, `password_hash`, `profile_image_path`, `bio`, `birthdate`, `gender`, `created_at`, `fullname`, `active_status`, `admin_status`) VALUES
(12, 'kenjikun3289', 'kenjikun3289@gmail.com', '$2y$13$27edFtDi72GWwtFynrsRIen4D.gy5IfAJNdD.a/4kYAATSVdyBi6a', '/uploads/profile_pictures/profile_kenjikun3289.png', 'I’m singing a song. I said I’m singing a song. And when someone is singing a song … don’t shoot them', NULL, 'male', '2025-01-10 21:17:15', 'Endo Kenji', 0, 1),
(13, 'aradhya47', 'aradhyathapa47@gmail.com', '$2y$13$9Q6yw74xdx0NRynle5cxwuu.RYrZ6NmY5JCF3CzB2PwWDloahUoBS', '/uploads/profile_pictures/profile_13_1736545926.png', 'feast of grids✨✨', NULL, 'female', '2025-01-10 21:28:46', 'Aradhya Thapa', 0, 1),
(14, 'anzal69', 'anzalbartaula0@gmail.com', '$2y$13$6jCsAoT8oZ1OF.a46S7stONbrx.R94.fFXOQledwi0Vuk/MBkNRB.', '/uploads/profile_pictures/profile_14_1736546110.jpg', 'Do what excites!!', NULL, 'male', '2025-01-10 21:29:19', 'Anjal Bartaula', 1, 1),
(15, 'sanjogkandel3289', 'sanjokkandel3@gmail.com', '$2y$13$IowcYzCVc8xt1KN6RCo5HerVMSECukren0IWJWHjhaB/YJ6.vqFPC', '/uploads/profile_pictures/profile_15_1737172897.png', NULL, NULL, 'male', '2025-01-10 21:30:37', 'Sanjog Kandel', 1, NULL),
(16, 'arpan3289', 'arpanraut17@gmail.com', '$2y$13$KrJh4ScGA/fZ9mmjFrYaV.nNIEKzpsWSfV.JbjahTbHA/BTxbose2', '/uploads/profile_pictures/profile_16_1737721864.jpg', 'Cool boi mo 😎', NULL, 'male', '2025-01-24 12:21:42', 'Arpan Raut', 1, NULL),
(17, 'sagar2004', 'pathaksagar065@gmail.com', '$2y$13$rhMxrBuwzoyujkrVD69cvezXti/9VDtdJUjbZB1pxiRko5gvip8A6', '/uploads/profile_pictures/profile_17_1739034714.jpg', NULL, NULL, 'male', '2025-02-08 17:05:09', 'Sagar Pathak', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `provider` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_auth_provider_id` (`provider_id`),
  KEY `user_auth_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

DROP TABLE IF EXISTS `user_token`;
CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `type` smallint NOT NULL,
  `token` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_token_token` (`token`),
  KEY `user_token_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usersmain` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `usersmain` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `usersmain` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usersmain` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `usersmain` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `usersmain` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `usersmain` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usersmain` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Constraints for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD CONSTRAINT `user_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `user_token_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
