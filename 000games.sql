-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 21, 2024 at 06:31 PM
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
-- Database: `id21601194_efx2`
--

-- --------------------------------------------------------

--
-- Table structure for table `arenaGames`
--

DROP TABLE IF EXISTS `arenaGames`;
CREATE TABLE IF NOT EXISTS `arenaGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `gameDir` varchar(128) NOT NULL,
  `practiceDir` varchar(128) NOT NULL,
  `thumb` varchar(128) NOT NULL,
  `linkThumb` varchar(128) NOT NULL,
  `gameDB` varchar(128) NOT NULL,
  `sessionsDB` varchar(128) NOT NULL,
  `maxPlayers` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `arenaGames`
--

INSERT INTO `arenaGames` (`id`, `name`, `gameDir`, `practiceDir`, `thumb`, `linkThumb`, `gameDB`, `sessionsDB`, `maxPlayers`) VALUES
(1, 'Tic Tac Toe', '/tictactoe', '/tictactoe_practice', '/tictactoeThumb.jpg', '/mirrors/tictactoe.png', 'tictactoeGames', 'tictactoeSessions', 2),
(2, 'Trektris', '/trektris', '/trektris_practice', '/trektrisThumb.jpg', '/mirrors/trektris.png', 'trektrisGames', 'trektrisSessions', 15),
(3, 'ORBS!', '/orbs', '/orbs_practice', '/orbsThumb.jpg', '/mirrors/burst.png', 'platformGames', 'platformSessions', 4),
(4, 'Side to Side', '/sidetoside', '/sidetoside_practice', '/sideToSideThumb.png', '/mirrors/sideToSideThumb.png', 'sideToSideGames', 'sideToSideSessions', 2),
(5, 'Puyo Puyo', '/puyopuyo', '/puyopuyo_practice', '/puyopuyoThumb.jpg', '/mirrors/puyopuyoThumb.png', 'puyopuyoGames', 'puyopuyoSessions', 2),
(6, 'Battle Racer', 'battleracer', 'battleracer_practice', '/battleracerThumb.jpg', '/mirrors/battleracerThumb.png', 'battleracerGames', 'battleracerSessions', 4),
(7, 'Spelunk!', 'spelunk', 'spelunk_practice', '/spelunkThumb.jpg', '/mirrors/spelunkThumb.png', 'spelunkGames', 'spelunkSessions', 4),
(8, 'Battle Jets!', '/battlejets', '/battlejets_practice', '/battlejetsThumb.jpg', '/mirrors/battlejetsThumb.png', 'battlejetsGames', 'battlejetsSessions', 4);

-- --------------------------------------------------------

--
-- Table structure for table `battlejetsGames`
--

DROP TABLE IF EXISTS `battlejetsGames`;
CREATE TABLE IF NOT EXISTS `battlejetsGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `battlejetsSessions`
--

DROP TABLE IF EXISTS `battlejetsSessions`;
CREATE TABLE IF NOT EXISTS `battlejetsSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `battleracerGames`
--

DROP TABLE IF EXISTS `battleracerGames`;
CREATE TABLE IF NOT EXISTS `battleracerGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `battleracerSessions`
--

DROP TABLE IF EXISTS `battleracerSessions`;
CREATE TABLE IF NOT EXISTS `battleracerSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orbsMirrors`
--

INSERT INTO `orbsMirrors` (`id`, `topURL`, `actualURL`, `user`, `cred`, `server`, `pass`, `active`) VALUES
(1, 'https://orbs.work.gd', 'https://fishable-searches.000webhostapp.com/', 'id21284549_user', 'id21284549_fishable', 'localhost', 'Chrome57253!*', 1),
(2, 'https://orbs1.work.gd', 'https://orbs2.000webhostapp.com/', 'id21552617_user', 'id21552617_orbs2', 'localhost', 'Chrome57253!*', 0),
(3, 'https://orbs2.work.gd', 'https://orbs3.000webhostapp.com/', 'id21553412_user', 'id21553412_orbs3', 'localhost', 'Chrome57253!*', 1),
(4, 'https://orbs3.work.gd', 'https://orbs4.000webhostapp.com/', 'id21583283_user', 'id21583283_orbs4', 'localhost', 'Chrome57253!*', 1),
(5, 'https://orbs4.work.gd', 'https://efx2.000webhostapp.com/', 'id21601194_user', 'id21601194_efx2', 'localhost', 'Chrome57253!*', 1),
(6, 'https://blorbs.run.place', 'https://efx3.000webhostapp.com/', 'id21601862_user', 'id21601862_efx3', 'localhost', 'Chrome57253!*', 1),
(7, 'https://warpspeed.publicvm.com', 'https://warpspeed.000webhostapp.com/', 'id21607252_user', 'id21607252_warpspeed', 'localhost', 'Chrome57253!*', 0),
(8, 'https://arena.fairuse.org', 'https://warpspeed.000webhostapp.com/', 'id21607252_user', 'id21607252_warpspeed', 'localhost', 'Chrome57253!*', 1),
(9, 'https://whr.mooo.com', 'https://whr1.000webhostapp.com/', 'id21616125_user', 'id21616125_multiplayer', 'localhost', 'Chrome57253!*', 0),
(10, 'https://orbstools.000webhostapp.com', 'https://orbstools.000webhostapp.com/', 'id21594651_user', 'id21594651_orbstools', 'localhost', 'Chrome57253!*', 0),
(11, 'https://gummier-fish.000webhostapp.com', 'https://gummier-fish.000webhostapp.com/', 'id21257390_user', 'id21257390_default', 'localhost', 'Chrome57253!*', 1),
(12, 'https://whr.rf.gd', 'https://whr.rf.gd/', 'if0_35615011', 'if0_35615011_orbs', 'sql101.infinityfree.com', 'ouVkeSu5FegeH', 0),
(13, 'https://whr.42web.io', 'https://whr.42web.io/', 'if0_35680091', 'if0_35680091_arena', 'sql312.infinityfree.com', 'kjiGQM2DqnhUAuU', 0),
(14, 'https://whr.000.pe', 'https://whr.000.pe/', 'if0_35680402', 'if0_35680402_arena', 'sql200.infinityfree.com', 'nBbQv0M3POyp', 0),
(15, 'https://orb.42web.io', 'https://orb.42web.io/', 'if0_35680488', 'if0_35680488_arena', 'sql213.infinityfree.com', '9K12EE4mmF3yi', 0),
(16, 'https://efx.rf.gd', 'https://efx.rf.gd/', 'if0_35681218', 'if0_35681218_arena', 'sql111.infinityfree.com', 'siann2ji7AGh', 0),
(17, 'https://efx.42web.io', 'https://efx.42web.io/', 'if0_35686192', 'if0_35686192_arena', 'sql106.infinityfree.com', 'iOFWM03Om1SRTI', 0);

-- --------------------------------------------------------

--
-- Table structure for table `platformGames`
--

DROP TABLE IF EXISTS `platformGames`;
CREATE TABLE IF NOT EXISTS `platformGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
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
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
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
  `data` mediumtext NOT NULL,
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
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `puyopuyoSessions`
--

INSERT INTO `puyopuyoSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(5, 'cantelope', '[]', '2023-12-24 01:24:44', 1062184705),
(6, 'BootyPOO', '[]', '2023-12-24 01:26:23', 1062184705);

-- --------------------------------------------------------

--
-- Table structure for table `sideToSideGames`
--

DROP TABLE IF EXISTS `sideToSideGames`;
CREATE TABLE IF NOT EXISTS `sideToSideGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1049606583 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sideToSideSessions`
--

DROP TABLE IF EXISTS `sideToSideSessions`;
CREATE TABLE IF NOT EXISTS `sideToSideSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sideToSideSessions`
--

INSERT INTO `sideToSideSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(2, 'cantelope', '[]', '2023-12-17 23:15:40', 1049606582);

-- --------------------------------------------------------

--
-- Table structure for table `spelunkGames`
--

DROP TABLE IF EXISTS `spelunkGames`;
CREATE TABLE IF NOT EXISTS `spelunkGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1071410436 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spelunkSessions`
--

DROP TABLE IF EXISTS `spelunkSessions`;
CREATE TABLE IF NOT EXISTS `spelunkSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `spelunkSessions`
--

INSERT INTO `spelunkSessions` (`id`, `name`, `data`, `date`, `gameID`) VALUES
(1, 'cantelope', '[]', '2024-02-03 22:29:22', 1035163318),
(2, 'cantelope', '[]', '2024-02-03 22:30:49', 1071410435);

-- --------------------------------------------------------

--
-- Table structure for table `tictactoeGames`
--

DROP TABLE IF EXISTS `tictactoeGames`;
CREATE TABLE IF NOT EXISTS `tictactoeGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tictactoeSessions`
--

DROP TABLE IF EXISTS `tictactoeSessions`;
CREATE TABLE IF NOT EXISTS `tictactoeSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trektrisGames`
--

DROP TABLE IF EXISTS `trektrisGames`;
CREATE TABLE IF NOT EXISTS `trektrisGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trektrisSessions`
--

DROP TABLE IF EXISTS `trektrisSessions`;
CREATE TABLE IF NOT EXISTS `trektrisSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
