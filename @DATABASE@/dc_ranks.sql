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
-- Table structure for table `dc_ranks`
--

CREATE TABLE `dc_ranks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `weight` float NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dc_ranks`
--

INSERT INTO `dc_ranks` (`id`, `title`, `weight`, `status`, `created_date`) VALUES
(1, 'Almost Impossible', 1, 1, '2017-12-27 10:35:44'),
(2, 'Very Unlikely', 1, 1, '2017-12-27 10:35:44'),
(3, 'Unlikely', 1, 1, '2017-12-27 10:36:12'),
(4, 'Somewhat Unlikely', 1, 1, '2017-12-27 10:36:12'),
(5, 'Average', 1, 1, '2017-12-27 10:36:23'),
(6, 'Somewhat Likely', 1, 1, '2017-12-27 10:36:23'),
(7, 'Likely', 1, 1, '2017-12-27 10:36:33'),
(8, 'very Likely', 1, 1, '2017-12-27 10:36:33'),
(9, 'Almost Certain', 1, 1, '2017-12-27 10:36:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dc_ranks`
--
ALTER TABLE `dc_ranks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dc_ranks`
--
ALTER TABLE `dc_ranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
