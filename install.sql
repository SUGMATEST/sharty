-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: sharty
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `antispam`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `antispam` (
  `board` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `thread` int DEFAULT NULL,
  `hash` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `created` int NOT NULL,
  `expires` int DEFAULT NULL,
  `passed` smallint NOT NULL,
  PRIMARY KEY (`hash`),
  KEY `board` (`board`,`thread`),
  KEY `expires` (`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ban_appeals`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `ban_appeals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ban_id` int unsigned NOT NULL,
  `time` int unsigned NOT NULL,
  `message` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `denied` tinyint(1) NOT NULL,
  `deny_reason` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'No reason provided',
  PRIMARY KEY (`id`),
  KEY `ban_id` (`ban_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ban_requests`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `ban_requests` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `time` int NOT NULL,
  `creator` int NOT NULL,
  `temp_ban` int unsigned DEFAULT NULL,
  `ip` varchar(39) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `board` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `post` blob NOT NULL,
  `reason` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bans`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `bans` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ipstart` varbinary(16) NOT NULL,
  `ipend` varbinary(16) DEFAULT NULL,
  `created` int unsigned NOT NULL,
  `expires` int unsigned DEFAULT NULL,
  `board` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `creator` int NOT NULL,
  `reason` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `seen` tinyint(1) NOT NULL,
  `post` blob,
  `pass_id` int unsigned DEFAULT NULL,
  `unappealable` tinyint DEFAULT '0',
  `hide_post_from_ban_list` tinyint DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `expires` (`expires`),
  KEY `ipstart` (`ipstart`,`ipend`),
  KEY `pass_id` (`pass_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `boards`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `boards` (
  `uri` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subtitle` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`uri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `boards` VALUES
('news', 'News', NULL);

--
-- Table structure for table `captchas`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `captchas` (
  `cookie` varchar(50) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `extra` varchar(200) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `text` varchar(255) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`cookie`,`extra`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cites`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `cites` (
  `board` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `post` int NOT NULL,
  `target_board` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `target` int NOT NULL,
  KEY `target` (`target_board`,`target`),
  KEY `post` (`board`,`post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `file_approval`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `file_approval` (
  `board` varchar(58) NOT NULL,
  `postid` int NOT NULL,
  `hash` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `time` int NOT NULL,
  PRIMARY KEY (`board`,`postid`,`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `file_whitelist`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `file_whitelist` (
  `hash` varchar(255) NOT NULL,
  `modid` int NOT NULL,
  `time` int NOT NULL,
  PRIMARY KEY (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `board` varchar(58) NOT NULL,
  `post_id` int unsigned NOT NULL,
  `file_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_post` (`board`,`post_id`),
  KEY `idx_file_path` (`file_path`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filters`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `filters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `regex` varchar(255) NOT NULL,
  `action` enum('move','ban','reject') NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `message` text,
  `board` varchar(58) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `flood`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `flood` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(39) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `board` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `time` int NOT NULL,
  `posthash` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `filehash` varchar(1000) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL,
  `isreply` tinyint(1) NOT NULL,
  `sharty_browser_hash` text CHARACTER SET ascii COLLATE ascii_general_ci,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`),
  KEY `posthash` (`posthash`),
  KEY `filehash` (`filehash`),
  KEY `time` (`time`),
  KEY `sharty_browser_hash` (`sharty_browser_hash`(64)),
  KEY `idx_ip` (`ip`),
  KEY `idx_posthash` (`posthash`),
  KEY `idx_filehash` (`filehash`),
  KEY `idx_ip_posthash` (`ip`,`posthash`),
  KEY `idx_sharty_browser_hash` (`sharty_browser_hash`(255))
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=ascii COLLATE=ascii_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hashbans`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `hashbans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filehash` varchar(1024) NOT NULL,
  `reason` text NOT NULL,
  `creator` int NOT NULL,
  `timestamp` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `integrity`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `integrity` (
  `ap` int DEFAULT NULL,
  `arch` int DEFAULT NULL,
  `cd` int DEFAULT NULL,
  `dm` int DEFAULT NULL,
  `hc` int DEFAULT NULL,
  `ww` int DEFAULT NULL,
  `wh` int DEFAULT NULL,
  `tz` int DEFAULT NULL,
  `ti` varchar(256) NOT NULL,
  `tei` varchar(256) DEFAULT NULL,
  `uhd` tinyint DEFAULT NULL,
  `uhblwc` tinyint DEFAULT NULL,
  `tfvce` tinyint DEFAULT NULL,
  `tfvw` tinyint DEFAULT NULL,
  `ts` int unsigned DEFAULT NULL,
  `istr` tinyint DEFAULT NULL,
  `iseh` tinyint DEFAULT NULL,
  `isc` tinyint DEFAULT NULL,
  `isdwk` tinyint DEFAULT NULL,
  `isswk` tinyint DEFAULT NULL,
  `isg` tinyint DEFAULT NULL,
  `isc86` tinyint DEFAULT NULL,
  `isw606` tinyint DEFAULT NULL,
  `lsf` varchar(256) DEFAULT NULL,
  `cf` varchar(256) DEFAULT NULL,
  `inc` tinyint DEFAULT NULL,
  `lan` text,
  `ur` text,
  `f` tinyint DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `loc` varchar(256) DEFAULT NULL,
  `ss` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`ti`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ip_notes`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `ip_notes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(39) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod` int DEFAULT NULL,
  `time` int NOT NULL,
  `body` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `ip_lookup` (`ip`,`time`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modlogs`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `modlogs` (
  `mod` int NOT NULL,
  `ip` varchar(39) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `board` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `time` int NOT NULL,
  `text` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  KEY `time` (`time`),
  KEY `mod` (`mod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mods`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `mods` (
  `id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'SHA256',
  `version` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type` smallint NOT NULL,
  `boards` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO `mods` VALUES
(1, 'admin', 'cedad442efeef7112fed0f50b011b2b9bf83f6898082f995f69dd7865ca19fb7', '4a44c6c55df862ae901b413feecb0d49', 30, '*');

--
-- Table structure for table `mutes`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `mutes` (
  `ip` varchar(39) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `time` int NOT NULL,
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `news`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` int NOT NULL,
  `subject` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `body` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `time` (`time`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nntp_references`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `nntp_references` (
  `board` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id` int unsigned NOT NULL,
  `message_id` varchar(255) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `message_id_digest` varchar(40) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `own` tinyint(1) NOT NULL,
  `headers` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`message_id_digest`),
  UNIQUE KEY `message_id` (`message_id`),
  UNIQUE KEY `u_board_id` (`board`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `noticeboard`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `noticeboard` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mod` int NOT NULL,
  `time` int NOT NULL,
  `subject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `time` (`time`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `board` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_pages` (`name`,`board`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `passes`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `passes` (
  `pass_id` int NOT NULL AUTO_INCREMENT,
  `contact` varchar(128) NOT NULL,
  `passkey` varchar(128) NOT NULL,
  `registration_date` datetime NOT NULL,
  `expiration_date` datetime NOT NULL,
  PRIMARY KEY (`pass_id`)
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pms`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `pms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sender` int NOT NULL,
  `to` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` int NOT NULL,
  `unread` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `to` (`to`,`unread`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `poll_options`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `poll_options` (
  `poll_id` int unsigned NOT NULL,
  `option_id` int unsigned NOT NULL,
  `option_text` text NOT NULL,
  PRIMARY KEY (`poll_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `poll_votes`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `poll_votes` (
  `poll_id` int unsigned NOT NULL,
  `option_id` int unsigned NOT NULL,
  `ip` varchar(39) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `pass_id` int unsigned DEFAULT NULL,
  `time` int NOT NULL,
  UNIQUE KEY `poll_id` (`poll_id`,`option_id`,`ip`),
  UNIQUE KEY `poll_id_2` (`poll_id`,`option_id`,`pass_id`),
  KEY `poll_id_3` (`poll_id`,`ip`),
  KEY `poll_id_4` (`poll_id`,`pass_id`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `polls`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `polls` (
  `poll_id` int unsigned NOT NULL AUTO_INCREMENT,
  `time` int NOT NULL,
  `creator_ip` varchar(39) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `expires` int DEFAULT NULL,
  `hide_results` tinyint(1) NOT NULL DEFAULT '0',
  `reveal_on_expiration` tinyint(1) NOT NULL DEFAULT '0',
  `multiple_choice` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`poll_id`),
  KEY `creator_ip` (`creator_ip`),
  KEY `time` (`time`),
  KEY `expires` (`expires`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reports`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `time` int NOT NULL,
  `ip` varchar(39) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `board` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `post` int NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `robot`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `robot` (
  `hash` varchar(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'SHA1',
  PRIMARY KEY (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `robotv2`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `robotv2` (
  `id` int NOT NULL AUTO_INCREMENT,
  `embedding` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_queries`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `search_queries` (
  `ip` varchar(39) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` int NOT NULL,
  `query` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `telegrams`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `telegrams` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mod_id` int unsigned NOT NULL,
  `ip` varchar(39) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `theme_settings`
--


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `theme_settings` (
  `theme` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  KEY `theme` (`theme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-10  0:12:47
