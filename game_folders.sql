-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 16, 2023 at 08:49 PM
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
-- Database: `id21284549_videodemos2`
--

-- --------------------------------------------------------

--
-- Table structure for table `applets`
--

CREATE TABLE `applets` (
  `userID` int(11) DEFAULT NULL,
  `code` mediumtext DEFAULT NULL,
  `rating` float NOT NULL DEFAULT 0,
  `votes` int(11) NOT NULL DEFAULT 0,
  `date` datetime DEFAULT NULL,
  `id` int(11) NOT NULL,
  `formerUserID` int(11) DEFAULT NULL,
  `formerAppletID` int(11) NOT NULL,
  `bytes` int(11) DEFAULT NULL,
  `webgl` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audiocloudComments`
--

CREATE TABLE `audiocloudComments` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `text` text NOT NULL,
  `trackID` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audiocloudPlaylists`
--

CREATE TABLE `audiocloudPlaylists` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `author` varchar(256) NOT NULL,
  `trackIDs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audiocloudTracks`
--

CREATE TABLE `audiocloudTracks` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `author` varchar(256) NOT NULL,
  `trackName` varchar(256) NOT NULL,
  `playlists` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `private` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  `audioFile` varchar(2048) NOT NULL,
  `plays` int(11) NOT NULL,
  `allowDownload` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `audiocloudTrackViews`
--

CREATE TABLE `audiocloudTrackViews` (
  `decIP` bigint(20) NOT NULL,
  `trackID` int(11) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `codegolfComments`
--

CREATE TABLE `codegolfComments` (
  `appletID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `codegolfUsers`
--

CREATE TABLE `codegolfUsers` (
  `name` varchar(20) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `rating` decimal(11,0) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `lastSeen` datetime DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `IP` varchar(16) DEFAULT NULL,
  `emailVerified` tinyint(1) NOT NULL DEFAULT 0,
  `emailKey` varchar(32) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT 0,
  `newHash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demoComments`
--

CREATE TABLE `demoComments` (
  `id` int(11) NOT NULL,
  `text` text DEFAULT NULL,
  `demoID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dweet_links`
--

CREATE TABLE `dweet_links` (
  `id` int(11) NOT NULL,
  `slug` varchar(16) NOT NULL,
  `code` varchar(16300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dweet_links_bak`
--

CREATE TABLE `dweet_links_bak` (
  `id` int(11) NOT NULL,
  `slug` varchar(16) NOT NULL,
  `code` varchar(16300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `author` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `allowDownload` tinyint(1) NOT NULL,
  `tags` varchar(1024) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesComments`
--

CREATE TABLE `gamesComments` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `text` text NOT NULL,
  `postID` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesViews`
--

CREATE TABLE `gamesViews` (
  `decIP` bigint(20) NOT NULL,
  `postID` int(11) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `videoLink` varchar(2048) NOT NULL,
  `demoJS` mediumtext NOT NULL,
  `demoCSS` mediumtext NOT NULL,
  `demoHTML` mediumtext NOT NULL,
  `title` varchar(1024) NOT NULL,
  `userID` int(11) NOT NULL,
  `author` varchar(256) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `forkHistory` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `videoThumb` varchar(2048) NOT NULL DEFAULT '',
  `videoViews` int(11) NOT NULL DEFAULT 0,
  `private` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` bigint(11) NOT NULL,
  `slug` varchar(16) NOT NULL,
  `target` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orbsMirrors`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `pageJS` mediumtext NOT NULL,
  `pageCSS` mediumtext NOT NULL,
  `pageHTML` mediumtext NOT NULL,
  `title` varchar(1024) NOT NULL,
  `userID` int(11) NOT NULL,
  `author` varchar(256) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `views` int(11) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `escaped_name` varchar(256) NOT NULL,
  `favicon` varchar(2048) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pageViews`
--

CREATE TABLE `pageViews` (
  `decIP` bigint(20) NOT NULL,
  `pageID` int(11) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platformGames`
--

CREATE TABLE `platformGames` (
  `id` int(11) NOT NULL,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platformSessions`
--

CREATE TABLE `platformSessions` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  `db_name` varchar(256) NOT NULL DEFAULT 'videodemos',
  `item_ids` varchar(4096) NOT NULL,
  `user_ids` varchar(4096) NOT NULL,
  `db_table_name` varchar(256) NOT NULL DEFAULT 'items',
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sideToSideGames`
--

CREATE TABLE `sideToSideGames` (
  `id` int(11) NOT NULL,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sideToSideSessions`
--

CREATE TABLE `sideToSideSessions` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tetrisGames`
--

CREATE TABLE `tetrisGames` (
  `id` bigint(20) NOT NULL,
  `gamedataA` text NOT NULL,
  `gamedataB` text NOT NULL,
  `gamedataC` text NOT NULL,
  `gamedataD` text NOT NULL,
  `playing` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tictactoeGames`
--

CREATE TABLE `tictactoeGames` (
  `id` int(11) NOT NULL,
  `data` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tictactoeSessions`
--

CREATE TABLE `tictactoeSessions` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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
  `gamesPostsPerPage` int(11) NOT NULL DEFAULT 6
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `videoViews`
--

CREATE TABLE `videoViews` (
  `decIP` bigint(20) NOT NULL,
  `demoID` int(11) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `decIP` bigint(20) NOT NULL,
  `demoID` int(11) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `appletID` int(11) NOT NULL,
  `IP` bigint(20) NOT NULL,
  `vote` tinyint(4) NOT NULL,
  `userID` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `author` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `allowDownload` tinyint(1) NOT NULL,
  `tags` varchar(1024) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wordsComments`
--

CREATE TABLE `wordsComments` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `text` text NOT NULL,
  `postID` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wordsViews`
--

CREATE TABLE `wordsViews` (
  `decIP` bigint(20) NOT NULL,
  `postID` int(11) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applets`
--
ALTER TABLE `applets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audiocloudComments`
--
ALTER TABLE `audiocloudComments`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `audiocloudPlaylists`
--
ALTER TABLE `audiocloudPlaylists`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `audiocloudTracks`
--
ALTER TABLE `audiocloudTracks`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `codegolfComments`
--
ALTER TABLE `codegolfComments`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `codegolfUsers`
--
ALTER TABLE `codegolfUsers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demoComments`
--
ALTER TABLE `demoComments`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `dweet_links`
--
ALTER TABLE `dweet_links`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `dweet_links_bak`
--
ALTER TABLE `dweet_links_bak`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gamesComments`
--
ALTER TABLE `gamesComments`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `orbsMirrors`
--
ALTER TABLE `orbsMirrors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `platformGames`
--
ALTER TABLE `platformGames`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `platformSessions`
--
ALTER TABLE `platformSessions`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `sideToSideGames`
--
ALTER TABLE `sideToSideGames`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `sideToSideSessions`
--
ALTER TABLE `sideToSideSessions`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tetrisGames`
--
ALTER TABLE `tetrisGames`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tictactoeGames`
--
ALTER TABLE `tictactoeGames`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tictactoeSessions`
--
ALTER TABLE `tictactoeSessions`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wordsComments`
--
ALTER TABLE `wordsComments`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applets`
--
ALTER TABLE `applets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audiocloudComments`
--
ALTER TABLE `audiocloudComments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audiocloudPlaylists`
--
ALTER TABLE `audiocloudPlaylists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audiocloudTracks`
--
ALTER TABLE `audiocloudTracks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `codegolfComments`
--
ALTER TABLE `codegolfComments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `codegolfUsers`
--
ALTER TABLE `codegolfUsers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demoComments`
--
ALTER TABLE `demoComments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dweet_links`
--
ALTER TABLE `dweet_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dweet_links_bak`
--
ALTER TABLE `dweet_links_bak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamesComments`
--
ALTER TABLE `gamesComments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orbsMirrors`
--
ALTER TABLE `orbsMirrors`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platformGames`
--
ALTER TABLE `platformGames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platformSessions`
--
ALTER TABLE `platformSessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sideToSideGames`
--
ALTER TABLE `sideToSideGames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sideToSideSessions`
--
ALTER TABLE `sideToSideSessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tetrisGames`
--
ALTER TABLE `tetrisGames`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tictactoeGames`
--
ALTER TABLE `tictactoeGames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tictactoeSessions`
--
ALTER TABLE `tictactoeSessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wordsComments`
--
ALTER TABLE `wordsComments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
