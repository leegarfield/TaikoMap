-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: www.brs-craft.cn    Database: taiko_map
-- ------------------------------------------------------
-- Server version	5.5.47-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `drum`
--

DROP TABLE IF EXISTS `drum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drum` (
  `NUM` int(11) NOT NULL AUTO_INCREMENT,
  `gamecenter` int(11) DEFAULT NULL,
  `overall_cond_1p` varchar(10) DEFAULT NULL,
  `overall_cond_2p` varchar(10) DEFAULT NULL,
  `1p_x_l` varchar(10) DEFAULT NULL,
  `1p_o_l` varchar(10) DEFAULT NULL,
  `1p_o_r` varchar(10) DEFAULT NULL,
  `1p_x_r` varchar(10) DEFAULT NULL,
  `2p_x_l` varchar(10) DEFAULT NULL,
  `2p_o_l` varchar(10) DEFAULT NULL,
  `2p_o_r` varchar(10) DEFAULT NULL,
  `2p_x_r` varchar(10) DEFAULT NULL,
  `score` int(3) DEFAULT NULL,
  `frame_version` varchar(10) DEFAULT NULL,
  `os_changed` tinyint(4) DEFAULT '0',
  `os_version` varchar(10) DEFAULT NULL,
  `1p_audio` varchar(2) DEFAULT NULL,
  `2p_audio` varchar(2) DEFAULT NULL,
  `env` varchar(2) DEFAULT NULL,
  `pos` varchar(100) DEFAULT NULL,
  `screen` varchar(45) DEFAULT 'nom',
  `coin` varchar(2) DEFAULT NULL,
  `track_no` varchar(2) DEFAULT NULL,
  `change_no` varchar(45) DEFAULT NULL,
  `comm` longtext,
  `last_change` varchar(20) DEFAULT NULL,
  `last_card` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`NUM`),
  UNIQUE KEY `num_UNIQUE` (`NUM`)
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drum`
--

LOCK TABLES `drum` WRITE;
/*!40000 ALTER TABLE `drum` DISABLE KEYS */;

/*!40000 ALTER TABLE `drum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gamecenter`
--

DROP TABLE IF EXISTS `gamecenter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gamecenter` (
  `NUM` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(45) NOT NULL,
  `area` varchar(45) NOT NULL,
  `place` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `drum_num` varchar(3) DEFAULT '0',
  `lng` varchar(10) DEFAULT NULL,
  `lat` varchar(10) DEFAULT NULL,
  `info` longtext,
  `change_no` int(11) DEFAULT NULL,
  `card` int(11) DEFAULT '0',
  `cloud_card` int(15) DEFAULT '0',
  `score` int(3) DEFAULT NULL,
  `best_drum` int(11) DEFAULT NULL,
  `comm` varchar(100) DEFAULT NULL,
  `lastchangeType` varchar(45) DEFAULT NULL,
  `lastchangeTime` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`NUM`),
  UNIQUE KEY `NUM_UNIQUE` (`NUM`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gamecenter`
--

LOCK TABLES `gamecenter` WRITE;
/*!40000 ALTER TABLE `gamecenter` DISABLE KEYS */;

/*!40000 ALTER TABLE `gamecenter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `NUM` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(30) DEFAULT NULL,
  `time` varchar(45) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `log` varchar(100) DEFAULT NULL,
  `log2` varchar(100) DEFAULT NULL,
  `log3` varchar(100) DEFAULT NULL,
  `log_long` longtext,
  PRIMARY KEY (`NUM`),
  UNIQUE KEY `NUM_UNIQUE` (`NUM`)
) ENGINE=InnoDB AUTO_INCREMENT=1145 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;

/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `player_table`
--

DROP TABLE IF EXISTS `player_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `player_table` (
  `NUM` int(10) NOT NULL AUTO_INCREMENT,
  `nickname` char(30) CHARACTER SET utf8 NOT NULL,
  `rec_tick` int(10) DEFAULT '0',
  `rec_cloud_tick` int(10) DEFAULT '0',
  `rec_change` int(10) DEFAULT '0',
  `password` varchar(64) CHARACTER SET utf8 NOT NULL,
  `email` char(40) CHARACTER SET utf8 DEFAULT NULL,
  `head_img` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `info_is_black` tinyint(4) DEFAULT '0',
  `info_black_reason` mediumtext CHARACTER SET utf8,
  `info_is_admin` tinyint(4) DEFAULT '0',
  `token` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `login_time` char(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`NUM`),
  UNIQUE KEY `NUM_UNIQUE` (`NUM`),
  UNIQUE KEY `nickname_UNIQUE` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player_table`
--

LOCK TABLES `player_table` WRITE;
/*!40000 ALTER TABLE `player_table` DISABLE KEYS */;

/*!40000 ALTER TABLE `player_table` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-04 19:28:30
