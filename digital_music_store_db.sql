-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2026 at 06:53 PM
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
-- Database: `digital_music_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','replied') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Joseph Ndagijimana', 'ndagijimanajoseph937@gmail.com', 'test subject', 'test message', 'read', '2026-07-11 17:40:49'),
(2, 'Joseph Ndagijimana', 'ndagijimanajoseph937@gmail.com', 'test subject', 'test message', 'read', '2026-07-11 17:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

CREATE TABLE `music` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `artist` varchar(100) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` text DEFAULT NULL,
  `audio_file` varchar(255) DEFAULT NULL,
  `status` enum('active','blocked') DEFAULT 'active',
  `release_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `music`
--

INSERT INTO `music` (`id`, `user_id`, `title`, `artist`, `genre`, `price`, `description`, `cover_image`, `audio_file`, `status`, `release_date`, `created_at`) VALUES
(10, 11, 'impande', 'Artist2', 'Hip-Hop', 3.00, 'this a rap song', '1784054904_images (1).jpg', '1784054904_HOLLIX - IMPANDE (OFFICIAL VIDEO) - Juni Quickly.mp3', 'active', '2026-07-14', '2026-07-14 18:48:24'),
(11, 11, 'mayi', 'Artist2', 'Hip-Hop', 3.00, 'rap song', '1784054961_images.jpg', '1784054961_Mayibobo - Babou Tight King, Bushali (Official Video) - BABOU TIGHT KING.mp3', 'active', '2026-07-15', '2026-07-14 18:49:21'),
(12, 11, 'chat', 'Artist2', 'Hip-Hop', 6.00, 'rap song', '1784055100_download (2).jpg', '1784055100_Pop Smoke - Chit Chat ft. XXXTENTACION, NLE Choppa & Lil Uzi Vert (Music Video) Prod by Last Dude - Last- Dude.mp3', 'active', '2026-07-21', '2026-07-14 18:51:40'),
(13, 9, 'Gospel', 'Artist', 'Gospel', 10.00, 'this is a gospel song', '1784055427_download.jpg', '1784055427_UWITEKA HIMBAZWA, Ambassadors of Christ Choir, OFFICIAL VIDEO- 2016, All rights reserved - Ambassadors of Christ Choir.mp3', 'active', '0000-00-00', '2026-07-14 18:57:07'),
(14, 9, 'healing', 'Artist', 'Hip-Hop', 12.00, 'drill song', '1784055542_images.jpg', '1784055542_Russ Millions - ICE TEA (Official Music Video) - Russ Millions.mp3', 'active', '0000-00-00', '2026-07-14 18:59:02'),
(15, 9, 'ce', 'Artist', 'R&B', 12.30, 'jazzz', '1784055649_download (2).jpg', '1784055649_Calema - Te Amo - Klasszik.mp3', 'active', '0000-00-00', '2026-07-14 19:00:49'),
(16, 11, 'world', 'Artist2', 'Afrobeat', 11.90, '', '1784055858_download (1).jpg', '1784055858_Shakira, Burna Boy - Dai Dai (Official Video) - (64 Kbps).mp3', 'active', '0000-00-00', '2026-07-14 19:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('artist','listener','admin') NOT NULL DEFAULT 'listener',
  `status` enum('active','blocked') DEFAULT 'active',
  `bio` text DEFAULT NULL,
  `profile_image` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `bio`, `profile_image`, `created_at`) VALUES
(7, 'super admin', 'superadmin@musicstore.com', '$2y$10$AFbpqVSZca3DqNOA5N9r9ewFz0kGKcTRQUE016G3a.c.HYYPLI6.u', 'admin', 'active', NULL, NULL, '2026-07-11 18:00:52'),
(8, 'Listener', 'listener@music.com', '$2y$10$u2/ckgWYzs3DjrjSFofN0u.QU4wwwYMmQcuafOs1enLtA2vYHQRVC', 'listener', 'active', NULL, NULL, '2026-07-14 18:37:19'),
(9, 'Artist', 'artist@music.com', '$2y$10$ljMMWXHXyl96PWHKk21Oku5seKVy6t6ANg2I0korv3boqnjnvC6G.', 'artist', 'active', NULL, NULL, '2026-07-14 18:39:28'),
(10, 'Listener2', 'listener@test.com', '$2y$10$h/gsA/YMOcSYTKu38IDTluLd56w9ev5Ta0ybqkhvK4frrAP5v.YS2', 'listener', 'active', NULL, NULL, '2026-07-14 18:40:18'),
(11, 'Artist2', 'test@artist.com', '$2y$10$oSsjvW/0/nXi9Yg5V3dSieKT4zXVNV5tCZIG0X1ChbDZNSf6Zvx7i', 'artist', 'active', NULL, NULL, '2026-07-14 18:40:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `music`
--
ALTER TABLE `music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `music`
--
ALTER TABLE `music`
  ADD CONSTRAINT `music_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
