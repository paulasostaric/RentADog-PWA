-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2025 at 05:31 PM
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
-- Database: `rentadog`
--

-- --------------------------------------------------------

--
-- Table structure for table `dogs`
--

CREATE TABLE `dogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `breed` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `temperament` varchar(50) NOT NULL,
  `size` varchar(20) NOT NULL,
  `image` varchar(255) NOT NULL,
  `durations` varchar(100) NOT NULL DEFAULT '60',
  `locations` varchar(100) NOT NULL DEFAULT 'park'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dogs`
--

INSERT INTO `dogs` (`id`, `name`, `breed`, `dob`, `temperament`, `size`, `image`, `durations`, `locations`) VALUES
(1, 'Campi', 'Križani terijer', '2018-06-05', 'Energična', 'srednji', 'campi.jpeg', '60', 'park'),
(2, 'Zetta', 'Križani terijer', '2023-06-08', 'Mirna', 'mali', 'zetta.jpeg', '60,90', 'park,suma'),
(3, 'Blanco', 'Križani terijer', '2025-03-03', 'Energičan', 'mali', 'blanco.jpeg', '30,60,90', 'park,suma,grad'),
(4, 'Sniper', 'Križani ovčar', '2018-07-24', 'Miran', 'veliki', 'sniper.jpeg', '60', 'suma'),
(5, 'Tijara', 'Križani terijer', '2025-02-25', 'Energična', 'mali', 'tijara.jpeg', '30,60,90', 'park,suma,grad'),
(6, 'Archy', 'Križani ovčar', '2019-12-10', 'Miran', 'veliki', 'archy.jpeg', '30,60,90', 'park,suma,grad'),
(7, 'Sally', 'Križani pekinezer', '2025-01-10', 'Mirna', 'mali', 'sally.jpeg', '30,60,90', 'park,suma,grad'),
(8, 'Daša', 'Križani gonič', '2023-08-15', 'Energična', 'srednji', 'dasa.jpeg', '60,90', 'suma'),
(9, 'Chico', 'Križani terijer', '2025-03-03', 'Energičan', 'mali', 'chico.jpeg', '30,60', 'park'),
(10, 'Brut', 'Križanac', '2019-10-13', 'Miran', 'srednji', 'brut.jpeg', '60', 'grad'),
(11, 'Maya', 'Križani sibirski husky', '2015-01-16', 'Mirna', 'veliki', 'maya.jpeg', '60,90', 'suma'),
(12, 'Ariel', 'Križana doga', '2022-11-22', 'Energična', 'veliki', 'ariel.jpeg', '60', 'park'),
(13, 'Melly', 'Križani pekinezer', '2015-03-29', 'Mirna', 'mali', 'melly.jpeg', '60', 'grad'),
(14, 'Šime', 'Križani rottweiler', '2023-06-20', 'Energičan', 'veliki', 'sime.jpeg', '60,90', 'suma'),
(15, 'Zora', 'Križani ovčar', '2025-03-01', 'Energična', 'mali', 'zora.jpeg', '30,60', 'park'),
(16, 'Lili', 'Križani šarplaninac', '2017-03-01', 'Mirna', 'veliki', 'lili.jpeg', '60', 'suma'),
(17, 'Ella', 'Križani ptičar', '2012-03-15', 'Mirna', 'srednji', 'ella.jpeg', '60', 'park'),
(18, 'Prometej', 'Križani terijer', '2012-05-07', 'Miran', 'srednji', 'prometej.jpeg', '60', 'grad'),
(19, 'Nelly', 'Križani ovčar', '2011-10-26', 'Mirna', 'veliki', 'nelly.jpeg', '60', 'park'),
(20, 'Lora', 'Križani terijer', '2020-10-04', 'Mirna', 'srednji', 'lora.jpeg', '60', 'suma');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `dog_id` int(10) UNSIGNED NOT NULL,
  `reserved_for` date NOT NULL,
  `time_slot` enum('morning','evening') NOT NULL DEFAULT 'morning',
  `duration` int(10) UNSIGNED NOT NULL DEFAULT 60,
  `location` varchar(50) NOT NULL,
  `reserved_by_user` int(10) UNSIGNED DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `dog_id`, `reserved_for`, `time_slot`, `duration`, `location`, `reserved_by_user`, `completed`, `created_at`) VALUES
(5, 2, '2025-06-10', 'morning', 60, 'park', 2, 0, '2025-06-07 13:24:13'),
(6, 20, '2025-06-17', 'evening', 60, 'suma', 1, 0, '2025-06-07 15:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `reservation_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `email`, `phone`, `is_admin`, `created_at`, `role`) VALUES
(1, 'admin', '$2y$10$LqY1POgJ0QOisS7TqE.UC.NnlN3wjFJSQW.BwswnsFLtlEDVaD3Ha', NULL, NULL, 1, '2025-06-07 10:59:57', 'admin'),
(2, 'paula', '$2y$10$ptlFK.Hq89ETLXaffu3W5OBLLHDodJ6TvrGMHu1IeonXkM/3QwMKu', NULL, NULL, 0, '2025-06-07 12:35:23', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dogs`
--
ALTER TABLE `dogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dog_id` (`dog_id`),
  ADD KEY `reserved_by_user` (`reserved_by_user`);

-- Indexes for table `reviews`
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dogs`
--
ALTER TABLE `dogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- AUTO_INCREMENT for table `reviews`
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`dog_id`) REFERENCES `dogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`reserved_by_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
