SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE IF NOT EXISTS `orbsMirrors` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `topURL` varchar(1024) NOT NULL,
  `actualURL` varchar(1024) NOT NULL,
  `user` varchar(1024) NOT NULL,
  `cred` varchar(1024) NOT NULL,
  `server` varchar(1024) NOT NULL,
  `pass` varchar(1024) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `platformGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `platformSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `sideToSideGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `sideToSideSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `tetrisGames` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gamedataA` text NOT NULL,
  `gamedataB` text NOT NULL,
  `gamedataC` text NOT NULL,
  `gamedataD` text NOT NULL,
  `playing` tinyint(1) NOT NULL DEFAULT 0,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `tictactoeGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `tictactoeSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `puyopuyoGames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `puyopuyoSessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `passhash` varchar(1024) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `avatar` varchar(2048) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `has_hosting` tinyint(1) NOT NULL DEFAULT 0,
  `escaped_name` varchar(256) NOT NULL,
  `audiocloudNumTracksPerPage` int(11) NOT NULL DEFAULT 6,
  `audiocloudPlayAll` tinyint(1) NOT NULL DEFAULT 0,
  `audiocloudShuffle` tinyint(1) NOT NULL DEFAULT 0,
  `audiocloudDisco` tinyint(1) NOT NULL DEFAULT 0,
  `wordsPostsPerPage` int(11) NOT NULL DEFAULT 6,
  `demoPostsPerPage` int(11) NOT NULL DEFAULT 6,
  `gamesPostsPerPage` int(11) NOT NULL DEFAULT 6,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
