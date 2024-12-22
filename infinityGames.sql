-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql213.infinityfree.com
-- Generation Time: Mar 21, 2024 at 02:22 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_35680488_arena`
--

-- --------------------------------------------------------

--
-- Table structure for table `battlejetsGames`
--

DROP TABLE IF EXISTS `battlejetsGames`;
CREATE TABLE IF NOT EXISTS `battlejetsGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1039742078 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `battlejetsSessions`
--

DROP TABLE IF EXISTS `battlejetsSessions`;
CREATE TABLE IF NOT EXISTS `battlejetsSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `battlejetsSessions`
--

INSERT INTO `battlejetsSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(1, 'cantelope', '[]', '2024-03-19 19:33:51', 1039742077);

-- --------------------------------------------------------

--
-- Table structure for table `battleracerGames`
--

DROP TABLE IF EXISTS `battleracerGames`;
CREATE TABLE IF NOT EXISTS `battleracerGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1065902328 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `battleracerSessions`
--

DROP TABLE IF EXISTS `battleracerSessions`;
CREATE TABLE IF NOT EXISTS `battleracerSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `battleracerSessions`
--

INSERT INTO `battleracerSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(1, 'cantelope', '[]', '2024-02-22 18:49:29', 1065902327);

-- --------------------------------------------------------

--
-- Table structure for table `orbsMirrors`
--

DROP TABLE IF EXISTS `orbsMirrors`;
CREATE TABLE IF NOT EXISTS `orbsMirrors` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `topURL` varchar(1024) NOT NULL,
  `actualURL` varchar(1024) NOT NULL,
  `user` varchar(1024) NOT NULL,
  `cred` varchar(1024) NOT NULL,
  `server` varchar(1024) NOT NULL,
  `pass` varchar(1024) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orbsMirrors`
--

INSERT INTO `orbsMirrors` (`id`, `topURL`, `actualURL`, `user`, `cred`, `server`, `pass`, `active`) VALUES
(1, 'https://orbs.work.gd', 'https://fishable-searches.000webhostapp.com/', 'id21284549_user', 'id21284549_fishable', 'localhost', 'Chrome57253!*', 0),
(2, 'https://orbs1.work.gd', 'https://orbs2.000webhostapp.com/', 'id21552617_user', 'id21552617_orbs2', 'localhost', 'Chrome57253!*', 0),
(3, 'https://orbs2.work.gd', 'https://orbs3.000webhostapp.com/', 'id21553412_user', 'id21553412_orbs3', 'localhost', 'Chrome57253!*', 0),
(4, 'https://orbs3.work.gd', 'https://orbs4.000webhostapp.com/', 'id21583283_user', 'id21583283_orbs4', 'localhost', 'Chrome57253!*', 0),
(5, 'https://orbs4.work.gd', 'https://efx2.000webhostapp.com/', 'id21601194_user', 'id21601194_efx2', 'localhost', 'Chrome57253!*', 0),
(6, 'https://blorbs.run.place', 'https://efx3.000webhostapp.com/', 'id21601862_user', 'id21601862_efx3', 'localhost', 'Chrome57253!*', 0),
(7, 'https://warpspeed.publicvm.com', 'https://warpspeed.000webhostapp.com/', 'id21607252_user', 'id21607252_warpspeed', 'localhost', 'Chrome57253!*', 0),
(8, 'https://arena.fairuse.org', 'https://warpspeed.000webhostapp.com/', 'id21607252_user', 'id21607252_warpspeed', 'localhost', 'Chrome57253!*', 0),
(9, 'https://whr.mooo.com', 'https://whr1.000webhostapp.com/', 'id21616125_user', 'id21616125_multiplayer', 'localhost', 'Chrome57253!*', 0),
(10, 'https://orbstools.000webhostapp.com', 'https://orbstools.000webhostapp.com/', 'id21594651_user', 'id21594651_orbstools', 'localhost', 'Chrome57253!*', 0),
(11, 'https://gummier-fish.000webhostapp.com', 'https://gummier-fish.000webhostapp.com/', 'id21257390_user', 'id21257390_default', 'localhost', 'Chrome57253!*', 0),
(12, 'https://whr.rf.gd', 'https://whr.rf.gd/', 'if0_35615011', 'if0_35615011_orbs', 'sql101.infinityfree.com', 'ouVkeSu5FegeH', 1),
(13, 'https://whr.42web.io', 'https://whr.42web.io/', 'if0_35680091', 'if0_35680091_arena', 'sql312.infinityfree.com', 'kjiGQM2DqnhUAuU', 1),
(14, 'https://whr.66ghz.com', 'https://whr.66ghz.com/', 'if0_35680402', 'if0_35680402_arena', 'sql200.infinityfree.com', 'nBbQv0M3POyp', 1),
(15, 'https://orb.42web.io', 'https://orb.42web.io/', 'if0_35680488', 'if0_35680488_arena', 'sql213.infinityfree.com', '9K12EE4mmF3yi', 1),
(16, 'https://efx.rf.gd', 'https://efx.rf.gd/', 'if0_35681218', 'if0_35681218_arena', 'sql111.infinityfree.com', 'siann2ji7AGh', 1),
(17, 'https://efx.42web.io', 'https://efx.42web.io/', 'if0_35686192', 'if0_35686192_arena', 'sql106.infinityfree.com', 'iOFWM03Om1SRTI', 1);

-- --------------------------------------------------------

--
-- Table structure for table `platformGames`
--

DROP TABLE IF EXISTS `platformGames`;
CREATE TABLE IF NOT EXISTS `platformGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1099037907 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platformSessions`
--

DROP TABLE IF EXISTS `platformSessions`;
CREATE TABLE IF NOT EXISTS `platformSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=355 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `platformSessions`
--

INSERT INTO `platformSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(353, 'cantelope', '[]', '2023-12-09 23:45:53', 1019415255),
(354, 'herp', '[]', '2023-12-09 23:46:02', 1019415255);

-- --------------------------------------------------------

--
-- Table structure for table `puyopuyoGames`
--

DROP TABLE IF EXISTS `puyopuyoGames`;
CREATE TABLE IF NOT EXISTS `puyopuyoGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1062184706 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `puyopuyoSessions`
--

DROP TABLE IF EXISTS `puyopuyoSessions`;
CREATE TABLE IF NOT EXISTS `puyopuyoSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `puyopuyoSessions`
--

INSERT INTO `puyopuyoSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(7, 'cantelope', '[]', '2024-03-03 01:12:05', 1009627325);

-- --------------------------------------------------------

--
-- Table structure for table `sideToSideGames`
--

DROP TABLE IF EXISTS `sideToSideGames`;
CREATE TABLE IF NOT EXISTS `sideToSideGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1093600581 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sideToSideSessions`
--

DROP TABLE IF EXISTS `sideToSideSessions`;
CREATE TABLE IF NOT EXISTS `sideToSideSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sideToSideSessions`
--

INSERT INTO `sideToSideSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(4, 'honiler', '[]', '2024-03-14 18:29:05', 1005653691),
(5, '666', '[]', '2024-03-14 18:29:30', 1005653691);

-- --------------------------------------------------------

--
-- Table structure for table `spelunkGames`
--

DROP TABLE IF EXISTS `spelunkGames`;
CREATE TABLE IF NOT EXISTS `spelunkGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spelunkSessions`
--

DROP TABLE IF EXISTS `spelunkSessions`;
CREATE TABLE IF NOT EXISTS `spelunkSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tictactoeGames`
--

DROP TABLE IF EXISTS `tictactoeGames`;
CREATE TABLE IF NOT EXISTS `tictactoeGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1081547496 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tictactoeSessions`
--

DROP TABLE IF EXISTS `tictactoeSessions`;
CREATE TABLE IF NOT EXISTS `tictactoeSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tictactoeSessions`
--

INSERT INTO `tictactoeSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(19, 'honiler', '[]', '2024-03-14 18:21:25', 1077719056),
(20, '666', '[]', '2024-03-14 18:21:52', 1077719056);

-- --------------------------------------------------------

--
-- Table structure for table `trektrisGames`
--

DROP TABLE IF EXISTS `trektrisGames`;
CREATE TABLE IF NOT EXISTS `trektrisGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1087856572 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trektrisSessions`
--

DROP TABLE IF EXISTS `trektrisSessions`;
CREATE TABLE IF NOT EXISTS `trektrisSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `trektrisSessions`
--

INSERT INTO `trektrisSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(11, 'S-class', '[]', '2024-03-18 21:13:33', 1069061967);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
