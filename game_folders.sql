-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 26, 2023 at 07:30 PM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id21583283_orbs4`
--

-- --------------------------------------------------------

--
-- Table structure for table `orbsMirrors`
--

DROP TABLE IF EXISTS orbsMirrors;

CREATE TABLE `orbsMirrors` (
  `id` bigint(11) NOT NULL,
  `topURL` varchar(1024) NOT NULL,
  `actualURL` varchar(1024) NOT NULL,
  `user` varchar(1024) NOT NULL,
  `cred` varchar(1024) NOT NULL,
  `server` varchar(1024) NOT NULL,
  `pass` varchar(1024) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orbsMirrors`
--

INSERT INTO `orbsMirrors` (`id`, `topURL`, `actualURL`, `user`, `cred`, `server`, `pass`, `active`) VALUES
(1, 'https://orbs.work.gd', 'https://fishable-searches.000webhostapp.com/', 'id21284549_user', 'id21284549_fishable', 'localhost', 'Chrome57253!*', 1),
(2, 'https://orbs1.work.gd', 'https://orbs2.000webhostapp.com/', 'id21552617_user', 'id21552617_orbs2', 'localhost', 'Chrome57253!*', 1),
(3, 'https://orbs2.work.gd', 'https://orbs3.000webhostapp.com/', 'id21553412_user', 'id21553412_orbs3', 'localhost', 'Chrome57253!*', 1),
(4, 'https://orbs3.work.gd', 'https://orbs4.000webhostapp.com/', 'id21583283_user', 'id21583283_orbs4', 'localhost', 'Chrome57253!*', 1),
(5, 'https://orbs4.work.gd', 'https://efx2.000webhostapp.com/', 'id21601194_user', 'id21601194_efx2', 'localhost', 'Chrome57253!*', 1),
(6, 'https://blorbs.run.place', 'https://efx3.000webhostapp.com/', 'id21601862_user', 'id21601862_efx3', 'localhost', 'Chrome57253!*', 1),
(7, 'https://warpspeed.publicvm.com', 'https://warpspeed.000webhostapp.com/', 'id21607252_user', 'id21607252_warpspeed', 'localhost', 'Chrome57253!*', 0),
(8, 'https://arena.fairuse.org', 'https://warpspeed.000webhostapp.com/', 'id21607252_user', 'id21607252_warpspeed', 'localhost', 'Chrome57253!*', 1),
(9, 'https://whr.mooo.com', 'https://whr1.000webhostapp.com/', 'id21616125_user', 'id21616125_multiplayer', 'localhost', 'Chrome57253!*', 0),
(10, 'https://orbstools.000webhostapp.com', 'https://orbstools.000webhostapp.com/', 'id21594651_user', 'id21594651_orbstools', 'localhost', 'Chrome57253!*', 1),
(11, 'https://gummier-fish.000webhostapp.com', 'https://gummier-fish.000webhostapp.com/', 'id21257390_user', 'id21257390_default', 'sql3.freemysqlhosting.net', 'yYqaiez9k5', 1),
(12, 'https://whr.rf.gd', 'https://whr.rf.gd/', 'if0_35615011', 'if0_35615011_orbs', 'sql101.infinityfree.com', 'ouVkeSu5FegeH', 0),
(13, 'https://whr.web42.io', 'https://whr.web42.io/', 'if0_35680091', 'if0_35680091_arena', 'sql312.infinityfree.com', 'kjiGQM2DqnhUAuU', 0),
(14, 'https://whr.rf.gd', 'https://whr.rf.gd/', 'if0_35615011', 'if0_35615011_orbs', 'sql101.infinityfree.com', 'ouVkeSu5FegeH', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orbsMirrors`
--
ALTER TABLE `orbsMirrors`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orbsMirrors`
--
ALTER TABLE `orbsMirrors`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
