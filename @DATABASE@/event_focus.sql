-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2017 at 10:15 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `virtualdm`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_focus`
--

CREATE TABLE `event_focus` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `weight` float NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_focus`
--

INSERT INTO `event_focus` (`id`, `title`, `weight`, `status`, `created_date`) VALUES
(1, 'Remote Event', 1, 1, '2017-12-27 10:13:19'),
(2, 'NPC Action', 2, 1, '2017-12-27 10:13:19'),
(3, 'Introduce a new character', 1, 1, '2017-12-27 10:13:55'),
(4, 'Thread related event', 2, 1, '2017-12-27 10:13:55'),
(5, 'Open or Close a thread', 1, 1, '2017-12-27 10:14:12'),
(6, 'PC Negative', 1, 1, '2017-12-27 10:14:12'),
(7, 'PC Positive', 1, 1, '2017-12-27 10:14:33'),
(8, 'Ambiguous Event', 3, 1, '2017-12-27 10:14:33'),
(9, 'NPC Negative', 1, 1, '2017-12-27 10:14:52'),
(10, 'NPC Positive', 1, 1, '2017-12-27 10:14:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_focus`
--
ALTER TABLE `event_focus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_focus`
--
ALTER TABLE `event_focus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
