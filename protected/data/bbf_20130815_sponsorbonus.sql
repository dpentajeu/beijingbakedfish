-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: bbf
-- ------------------------------------------------------
-- Server version	5.5.31-0ubuntu0.12.04.2

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
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `message` mediumtext COLLATE utf8_bin NOT NULL,
  `dateCreated` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcement`
--

LOCK TABLES `announcement` WRITE;
/*!40000 ALTER TABLE `announcement` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package`
--

DROP TABLE IF EXISTS `package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `packageName` varchar(255) NOT NULL,
  `value` double NOT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package`
--

LOCK TABLES `package` WRITE;
/*!40000 ALTER TABLE `package` DISABLE KEYS */;
INSERT INTO `package` VALUES (1,'Alpha package',500,2),(2,'Beta package',1500,5),(3,'Gamma package',3500,10);
/*!40000 ALTER TABLE `package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `walletId` int(10) unsigned NOT NULL,
  `amount` float(13,4) NOT NULL,
  `balance` float(13,4) NOT NULL,
  `tranDate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `walletId` (`walletId`),
  CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`walletId`) REFERENCES `wallet` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase`
--

LOCK TABLES `purchase` WRITE;
/*!40000 ALTER TABLE `purchase` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sponsorlevel`
--

DROP TABLE IF EXISTS `sponsorlevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sponsorlevel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `rate` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sponsorlevel`
--

LOCK TABLES `sponsorlevel` WRITE;
/*!40000 ALTER TABLE `sponsorlevel` DISABLE KEYS */;
INSERT INTO `sponsorlevel` VALUES (1,1,0.075),(2,2,0.05),(3,3,0.04),(4,4,0.035),(5,5,0.03),(6,6,0.025),(7,7,0.015),(8,8,0.01),(9,9,0.01),(10,10,0.01);
/*!40000 ALTER TABLE `sponsorlevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `walletId` int(10) unsigned NOT NULL,
  `tranType` enum('DEBIT','CREDIT') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `amount` float(13,4) NOT NULL,
  `balance` float(13,4) DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `promoCode` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tranDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transaction_wallet_idx` (`walletId`),
  CONSTRAINT `fk_transaction_wallet_idx` FOREIGN KEY (`walletId`) REFERENCES `wallet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (1,6,'DEBIT',37.5000,3887.5000,'Sponsor bonus from Lim Chia Lee. (Level 1)',NULL,'2013-07-31 06:23:11'),(2,5,'DEBIT',25.0000,625.0000,'Sponsor bonus from Lim Chia Lee. (Level 2)',NULL,'2013-07-31 06:23:11'),(3,10,'DEBIT',262.5000,862.5000,'Sponsor bonus from lim chia lee. (Level 1)',NULL,'2013-07-31 06:23:11'),(4,6,'DEBIT',175.0000,4062.5000,'Sponsor bonus from lim chia lee. (Level 2)',NULL,'2013-07-31 06:23:11'),(5,5,'DEBIT',140.0000,765.0000,'Sponsor bonus from lim chia lee. (Level 3)',NULL,'2013-07-31 06:23:11'),(6,9,'DEBIT',37.5000,3887.5000,'Sponsor bonus from GOH KAR HOE. (Level 1)',NULL,'2013-07-31 06:23:11'),(7,4,'DEBIT',25.0000,625.0000,'Sponsor bonus from GOH KAR HOE. (Level 2)',NULL,'2013-07-31 06:23:11'),(8,7,'DEBIT',112.5000,3962.5000,'Sponsor bonus from Chia Chin Kang. (Level 1)',NULL,'2013-07-31 06:23:11'),(9,3,'DEBIT',75.0000,675.0000,'Sponsor bonus from Chia Chin Kang. (Level 2)',NULL,'2013-07-31 06:23:11'),(10,6,'DEBIT',112.5000,4175.0000,'Sponsor bonus from ALKEND SOH. (Level 1)',NULL,'2013-07-31 06:23:11'),(11,5,'DEBIT',75.0000,840.0000,'Sponsor bonus from ALKEND SOH. (Level 2)',NULL,'2013-07-31 06:23:11'),(12,4,'DEBIT',262.5000,887.5000,'Sponsor bonus from WEY YONG SIANG. (Level 1)',NULL,'2013-07-31 06:23:11'),(13,10,'DEBIT',262.5000,1125.0000,'Sponsor bonus from HAU WAN BAN. (Level 1)',NULL,'2013-07-31 06:23:11'),(14,6,'DEBIT',175.0000,4350.0000,'Sponsor bonus from HAU WAN BAN. (Level 2)',NULL,'2013-07-31 06:23:11'),(15,5,'DEBIT',140.0000,980.0000,'Sponsor bonus from HAU WAN BAN. (Level 3)',NULL,'2013-07-31 06:23:11'),(16,7,'DEBIT',262.5000,4225.0000,'Sponsor bonus from HAU WAN BAN. (Level 1)',NULL,'2013-07-31 06:23:11'),(17,3,'DEBIT',175.0000,850.0000,'Sponsor bonus from HAU WAN BAN. (Level 2)',NULL,'2013-07-31 06:23:11'),(18,20,'DEBIT',262.5000,4112.5000,'Sponsor bonus from THAM YIT YEAN. (Level 1)',NULL,'2013-08-05 09:31:53'),(19,4,'DEBIT',175.0000,1062.5000,'Sponsor bonus from THAM YIT YEAN. (Level 2)',NULL,'2013-08-05 09:31:53'),(20,7,'DEBIT',262.5000,4487.5000,'Sponsor bonus from ANSON LEE. (Level 1)',NULL,'2013-08-05 09:31:56'),(21,3,'DEBIT',175.0000,1025.0000,'Sponsor bonus from ANSON LEE. (Level 2)',NULL,'2013-08-05 09:31:56'),(22,12,'DEBIT',262.5000,862.5000,'Sponsor bonus from GOH KAR HOE. (Level 1)',NULL,'2013-08-05 09:32:03'),(23,9,'DEBIT',175.0000,4062.5000,'Sponsor bonus from GOH KAR HOE. (Level 2)',NULL,'2013-08-05 09:32:03'),(24,4,'DEBIT',140.0000,1202.5000,'Sponsor bonus from GOH KAR HOE. (Level 3)',NULL,'2013-08-05 09:32:03'),(25,20,'DEBIT',262.5000,4375.0000,'Sponsor bonus from LEONG KOK HUA. (Level 1)',NULL,'2013-08-05 09:32:08'),(26,4,'DEBIT',175.0000,1377.5000,'Sponsor bonus from LEONG KOK HUA. (Level 2)',NULL,'2013-08-05 09:32:08'),(27,5,'DEBIT',262.5000,1242.5000,'Sponsor bonus from lim jun hao. (Level 1)',NULL,'2013-08-05 09:32:16'),(28,49,'DEBIT',262.5000,862.5000,'Sponsor bonus from TAN WEE CHONG. (Level 1)',NULL,'2013-08-05 09:32:23'),(29,18,'DEBIT',175.0000,775.0000,'Sponsor bonus from TAN WEE CHONG. (Level 2)',NULL,'2013-08-05 09:32:23'),(30,9,'DEBIT',140.0000,4202.5000,'Sponsor bonus from TAN WEE CHONG. (Level 3)',NULL,'2013-08-05 09:32:23'),(31,4,'DEBIT',122.5000,1500.0000,'Sponsor bonus from TAN WEE CHONG. (Level 4)',NULL,'2013-08-05 09:32:23'),(32,18,'DEBIT',37.5000,812.5000,'Sponsor bonus from TAN WEE CHONG. (Level 1)',NULL,'2013-08-05 09:32:30'),(33,9,'DEBIT',25.0000,4227.5000,'Sponsor bonus from TAN WEE CHONG. (Level 2)',NULL,'2013-08-05 09:32:30'),(34,4,'DEBIT',262.5000,1762.5000,'Sponsor bonus from PAUL TAY. (Level 1)',NULL,'2013-08-05 09:32:44'),(35,8,'DEBIT',262.5000,4112.5000,'Sponsor bonus from Raymond Chou Ching Siang. (Level 1)',NULL,'2013-08-05 09:32:50'),(36,7,'DEBIT',175.0000,4662.5000,'Sponsor bonus from Raymond Chou Ching Siang. (Level 2)',NULL,'2013-08-05 09:32:50'),(37,3,'DEBIT',140.0000,1165.0000,'Sponsor bonus from Raymond Chou Ching Siang. (Level 3)',NULL,'2013-08-05 09:32:50'),(38,6,'DEBIT',112.5000,4462.5000,'Sponsor bonus from WANG GUO CHANG. (Level 1)',NULL,'2013-08-05 09:32:59'),(39,5,'DEBIT',75.0000,1317.5000,'Sponsor bonus from WANG GUO CHANG. (Level 2)',NULL,'2013-08-05 09:32:59'),(40,8,'DEBIT',262.5000,4375.0000,'Sponsor bonus from WONG LING PING. (Level 1)',NULL,'2013-08-05 09:33:05'),(41,7,'DEBIT',175.0000,4837.5000,'Sponsor bonus from WONG LING PING. (Level 2)',NULL,'2013-08-05 09:33:05'),(42,3,'DEBIT',140.0000,1305.0000,'Sponsor bonus from WONG LING PING. (Level 3)',NULL,'2013-08-05 09:33:05'),(43,3,'DEBIT',262.5000,1567.5000,'Sponsor bonus from woon chin siang. (Level 1)',NULL,'2013-08-05 09:33:31'),(44,9,'DEBIT',37.5000,4265.0000,'Sponsor bonus from YONG SEET SIONG. (Level 1)',NULL,'2013-08-05 09:33:39'),(45,4,'DEBIT',25.0000,1787.5000,'Sponsor bonus from YONG SEET SIONG. (Level 2)',NULL,'2013-08-05 09:33:39'),(46,18,'DEBIT',262.5000,1075.0000,'Sponsor bonus from Yong SEET SIONG. (Level 1)',NULL,'2013-08-05 09:33:44'),(47,9,'DEBIT',175.0000,4440.0000,'Sponsor bonus from Yong SEET SIONG. (Level 2)',NULL,'2013-08-05 09:33:44'),(48,4,'DEBIT',140.0000,1927.5000,'Sponsor bonus from Yong SEET SIONG. (Level 3)',NULL,'2013-08-05 09:33:44'),(49,21,'DEBIT',262.5000,1912.5000,'Sponsor bonus from ANDREW LIM TZE XIANG. (Level 1)',NULL,'2013-08-05 14:20:07'),(50,6,'DEBIT',175.0000,4637.5000,'Sponsor bonus from ANDREW LIM TZE XIANG. (Level 2)',NULL,'2013-08-05 14:20:07'),(51,5,'DEBIT',140.0000,1457.5000,'Sponsor bonus from ANDREW LIM TZE XIANG. (Level 3)',NULL,'2013-08-05 14:20:07'),(52,18,'DEBIT',262.5000,1337.5000,'Sponsor bonus from CHEONG MEI THENG. (Level 1)',NULL,'2013-08-05 14:20:14'),(53,9,'DEBIT',175.0000,4615.0000,'Sponsor bonus from CHEONG MEI THENG. (Level 2)',NULL,'2013-08-05 14:20:14'),(54,4,'DEBIT',140.0000,2067.5000,'Sponsor bonus from CHEONG MEI THENG. (Level 3)',NULL,'2013-08-05 14:20:14'),(55,57,'DEBIT',112.5000,3962.5000,'Sponsor bonus from TONY SNG ENG KEONG. (Level 1)',NULL,'2013-08-05 14:20:29'),(56,56,'DEBIT',75.0000,3925.0000,'Sponsor bonus from TONY SNG ENG KEONG. (Level 2)',NULL,'2013-08-05 14:20:29'),(57,21,'DEBIT',60.0000,1972.5000,'Sponsor bonus from TONY SNG ENG KEONG. (Level 3)',NULL,'2013-08-05 14:20:29'),(58,6,'DEBIT',52.5000,4690.0000,'Sponsor bonus from TONY SNG ENG KEONG. (Level 4)',NULL,'2013-08-05 14:20:29'),(59,5,'DEBIT',45.0000,1502.5000,'Sponsor bonus from TONY SNG ENG KEONG. (Level 5)',NULL,'2013-08-05 14:20:29'),(60,48,'DEBIT',262.5000,4112.5000,'Sponsor bonus from XAVIER LOW YONG SOON. (Level 1)',NULL,'2013-08-07 13:29:20'),(61,20,'DEBIT',175.0000,4550.0000,'Sponsor bonus from XAVIER LOW YONG SOON. (Level 2)',NULL,'2013-08-07 13:29:20'),(62,4,'DEBIT',140.0000,2207.5000,'Sponsor bonus from XAVIER LOW YONG SOON. (Level 3)',NULL,'2013-08-07 13:29:20'),(63,20,'DEBIT',37.5000,3850.0000,'Sponsor bonus from YEO WENG KEONG. (Level 1)',NULL,'2013-08-14 18:06:58'),(64,4,'DEBIT',25.0000,600.0000,'Sponsor bonus from YEO WENG KEONG. (Level 2)',NULL,'2013-08-14 18:06:58'),(65,17,'DEBIT',112.5000,1650.0000,'Sponsor bonus from TIOW MEI CHEN. (Level 1)',NULL,'2013-08-14 18:06:58'),(66,6,'DEBIT',75.0000,3850.0000,'Sponsor bonus from TIOW MEI CHEN. (Level 2)',NULL,'2013-08-14 18:06:58'),(67,5,'DEBIT',60.0000,600.0000,'Sponsor bonus from TIOW MEI CHEN. (Level 3)',NULL,'2013-08-14 18:06:58'),(68,57,'DEBIT',112.5000,3850.0000,'Sponsor bonus from TE MING REN. (Level 1)',NULL,'2013-08-14 18:06:58'),(69,56,'DEBIT',75.0000,3850.0000,'Sponsor bonus from TE MING REN. (Level 2)',NULL,'2013-08-14 18:06:58'),(70,21,'DEBIT',60.0000,1650.0000,'Sponsor bonus from TE MING REN. (Level 3)',NULL,'2013-08-14 18:06:58'),(71,6,'DEBIT',52.5000,3850.0000,'Sponsor bonus from TE MING REN. (Level 4)',NULL,'2013-08-14 18:06:58'),(72,5,'DEBIT',45.0000,600.0000,'Sponsor bonus from TE MING REN. (Level 5)',NULL,'2013-08-14 18:06:58'),(73,21,'DEBIT',112.5000,1650.0000,'Sponsor bonus from LIM LEE HONG. (Level 1)',NULL,'2013-08-14 18:06:58'),(74,6,'DEBIT',75.0000,3850.0000,'Sponsor bonus from LIM LEE HONG. (Level 2)',NULL,'2013-08-14 18:06:58'),(75,5,'DEBIT',60.0000,600.0000,'Sponsor bonus from LIM LEE HONG. (Level 3)',NULL,'2013-08-14 18:06:58'),(76,65,'DEBIT',37.5000,600.0000,'Sponsor bonus from Lee huay min. (Level 1)',NULL,'2013-08-14 18:34:05'),(77,64,'DEBIT',25.0000,1650.0000,'Sponsor bonus from Lee huay min. (Level 2)',NULL,'2013-08-14 18:34:05'),(78,64,'DEBIT',37.5000,1650.0000,'Sponsor bonus from Ngow eugune. (Level 1)',NULL,'2013-08-14 18:34:25'),(79,21,'DEBIT',25.0000,1650.0000,'Sponsor bonus from Ngow eugune. (Level 2)',NULL,'2013-08-14 18:34:25'),(80,65,'DEBIT',37.5000,600.0000,'Sponsor bonus from Yeap soon jau. (Level 1)',NULL,'2013-08-14 18:35:13'),(81,64,'DEBIT',25.0000,1650.0000,'Sponsor bonus from Yeap soon jau. (Level 2)',NULL,'2013-08-14 18:35:13');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `acc_num` varchar(45) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `referral` int(11) NOT NULL,
  `packageId` int(11) NOT NULL,
  `password` varchar(512) NOT NULL,
  `bankAcc` varchar(100) DEFAULT NULL,
  `bankName` varchar(50) DEFAULT NULL,
  `pin` int(6) DEFAULT NULL,
  `tac` int(6) DEFAULT NULL,
  `isApproved` tinyint(1) DEFAULT '0',
  `isActivated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'','BBF','info@beijingbakedfish.com','062815070','','1970-01-01',NULL,'0000-00-00 00:00:00','2013-07-22 08:46:26',0,0,'a22d7cf9ecff864656d04afe41694bcc','','',NULL,588973,1,0),(3,NULL,'FRANCIS YEO','chyeo55@yahoo.com','0162656983',NULL,'1955-03-12',NULL,'2013-07-08 14:29:20','2013-07-08 14:29:20',1,3,'39c8b4b532a97325282d2633f44c1631',NULL,NULL,NULL,NULL,1,0),(4,NULL,'LONG SHUI SHENG','lss20071022@163.com','0173136826',NULL,'1970-01-01',NULL,'2013-07-08 14:33:01','2013-07-08 14:33:01',1,3,'ede46119be3ede6eccc2fb17843713e0',NULL,NULL,NULL,NULL,1,0),(5,NULL,'WOON CHIN SIANG','woon@ezlinkgroups.com','0127227810',NULL,'1970-01-01',NULL,'2013-07-08 14:34:31','2013-07-08 14:34:31',1,1,'92b81af8eea2b78d80cd90b2d1dd9134',NULL,NULL,NULL,NULL,1,0),(6,NULL,'PAUL TAY','paultay@yahoo.com','0166156560',NULL,'1975-12-01',NULL,'2013-07-08 14:43:02','2013-07-08 14:43:02',1,1,'9d2ebbbfa3a188833aa973208a181c36',NULL,NULL,NULL,NULL,1,0),(7,NULL,'Lim Jun Hao','roy7664@qq.com','0123696719',NULL,'1970-01-01',NULL,'2013-07-08 15:18:04','2013-07-08 15:18:04',1,1,'434aa092522228b6cf0714c110b12ecc',NULL,NULL,NULL,NULL,1,0),(8,NULL,'lim jun hao','roy@qq.com','0163056337',NULL,'1970-01-01',NULL,'2013-07-08 15:21:32','2013-07-08 15:21:32',7,3,'c01c0950d3e3f5090eb5d06ebebff428',NULL,NULL,NULL,NULL,1,0),(9,NULL,'woon chin siang','info@ezlinkgroups.com','0126237810',NULL,'1970-01-01',NULL,'2013-07-08 15:23:12','2013-07-08 15:23:12',5,3,'9295c67fb2e2264424b9be35da625485',NULL,NULL,NULL,NULL,1,0),(10,NULL,'ANSON LEE','lhg.anson@gmail.com','0123452797',NULL,'1987-03-09',NULL,'2013-07-08 15:24:10','2013-07-08 15:24:10',9,3,'03a20577c2fc4740a1c0808ca7c1140e',NULL,NULL,NULL,NULL,1,0),(11,NULL,'PAUL TAY','basicventure@gmail.com','0164897279',NULL,'1975-12-01',NULL,'2013-07-08 15:26:14','2013-07-08 15:26:14',6,3,'8873609ddc399f8d7d349a01fac684b5',NULL,NULL,NULL,NULL,1,0),(12,NULL,'Lim Chia Lee','jesslim7898@gmail.com','0136991996',NULL,'1970-01-01',NULL,'2013-07-08 15:29:18','2013-07-08 15:29:18',8,1,'88ad02293c44346716efa39586f65456',NULL,NULL,NULL,NULL,1,0),(13,NULL,'lim chia lee','jesslim7899@gmail.com','01253052211',NULL,'1970-01-01',NULL,'2013-07-08 15:30:18','2013-07-08 15:30:18',12,3,'613c31e58c728efc57cd634865811a47',NULL,NULL,NULL,NULL,1,0),(14,NULL,'GOH KAR HOE','dannygoh888@yahoo.com','0143298923',NULL,'1970-01-01',NULL,'2013-07-08 15:37:52','2013-07-08 15:37:52',11,1,'3095641376ad70ca7eb036ec9846acdb',NULL,NULL,NULL,NULL,1,0),(15,NULL,'GOH KAR HOE','dannygoh888@gmail.com','0166605665',NULL,'1970-01-01',NULL,'2013-07-08 15:39:35','2013-07-08 15:39:35',14,3,'c8d9bbe978dc1fd0c86fcda6e2b47b47',NULL,NULL,NULL,NULL,1,0),(16,NULL,'WONG LING PING','studyworld@yahoo.com','0176808828',NULL,'1988-03-05',NULL,'2013-07-08 16:02:32','2013-07-08 16:02:32',10,3,'99f35ca2a6e4f4b0056a3ecc3af1c0eb',NULL,NULL,NULL,NULL,1,0),(17,NULL,'Raymond Chou Ching Siang','raymondchou87@gmail.com','0163353665',NULL,'1970-01-01',NULL,'2013-07-08 16:04:08','2013-07-08 16:04:08',10,3,'2b439af91e8d3c490986c681fba6278d',NULL,NULL,NULL,NULL,1,0),(18,NULL,'Chia Chin Kang','chinkang84@gmail.com','0126781555',NULL,'1984-03-07',NULL,'2013-07-08 16:05:18','2013-07-08 16:05:18',9,2,'e08a4021696ab50b9171534d1597db58',NULL,NULL,NULL,NULL,1,0),(19,NULL,'ALKEND SOH','extraordinary.alkendsoh@hotmail.com','0162225836',NULL,'1970-01-01',NULL,'2013-07-08 16:21:44','2013-07-08 16:21:44',8,2,'2f1e7de47eb623ae30753cd6dde07d6b',NULL,NULL,NULL,NULL,1,0),(20,NULL,'YONG SEET SIONG','seetsiong.yong@gmail.com','0162321745',NULL,'1979-11-08',NULL,'2013-07-08 16:24:36','2013-07-08 16:24:36',11,1,'3463d975ab4ba8f617c1d6385e6915bd',NULL,NULL,NULL,NULL,1,0),(21,NULL,'Yong SEET SIONG','easongoh@gmail.com','0166067606',NULL,'1979-11-08',NULL,'2013-07-08 16:27:03','2013-07-08 16:27:03',20,3,'4d3878197715880a329065bb7890ad05',NULL,NULL,NULL,NULL,1,0),(22,NULL,'WEY YONG SIANG','yswey88@gmail.com','0162773619',NULL,'1972-10-11',NULL,'2013-07-08 16:37:43','2013-07-08 16:37:43',6,3,'e51ed2233c076242aeea5f5cd36942d1',NULL,NULL,NULL,NULL,1,0),(23,NULL,'WANG GUO CHANG','calvinwang87@yahoo.com','0166478407',NULL,'1987-04-09',NULL,'2013-07-10 08:43:30','2013-07-10 08:43:30',8,2,'ec854a3f0ca193f77afa382da8b17569','','',NULL,NULL,1,0),(24,NULL,'HAU WAN BAN','hauwanban@gmail.com','0183636222',NULL,'1975-10-15',NULL,'2013-07-14 09:52:22','2013-07-14 09:52:22',12,3,'adc252b629d4868fdf20118733a28bc9',NULL,NULL,NULL,NULL,1,0),(25,NULL,'HAU WAN BAN','hauwanban@yahoo.com','0166512100',NULL,'1975-10-15',NULL,'2013-07-14 11:55:01','2013-07-14 11:55:01',9,3,'05004611efb2c226e7482a1bd50d12e6',NULL,NULL,NULL,NULL,1,0),(26,NULL,'LEONG KOK HUA','ahseng123@ab.com','0126565334',NULL,'1968-12-26',NULL,'2013-07-24 04:41:42','2013-07-24 04:41:42',22,3,'47d2fa9dfcbdc2d880173c229022e0d6',NULL,NULL,NULL,NULL,1,0),(27,NULL,'THAM YIT YEAN','yytham@hotmail.com','0123377120',NULL,'1970-09-17',NULL,'2013-07-24 04:45:36','2013-07-24 04:45:36',22,3,'945d80785c9fcd9d6732a8860f2192e9','','',NULL,NULL,1,0),(28,NULL,'TAN WEE CHONG','cutiepig6097@live.co.uk','0136131303',NULL,'1983-06-25',NULL,'2013-08-01 14:24:49','2013-08-01 14:24:49',20,1,'795160b920725de7186d9a24d4de0dcd',NULL,NULL,NULL,NULL,1,0),(29,NULL,'TAN WEE CHONG','abc@def.com','0132061303',NULL,'1983-06-25',NULL,'2013-08-01 14:46:56','2013-08-01 14:46:56',28,3,'66e9add18e074fa0522b12c9bffba33a',NULL,NULL,NULL,NULL,1,0),(30,NULL,'XAVIER LOW YONG SOON','xlys.roqstar@live.com','0167201100',NULL,'1981-10-26',NULL,'2013-08-05 09:56:15','2013-08-05 09:56:15',27,3,'db81f74811b066feb35873d4e5663e72',NULL,NULL,NULL,NULL,1,0),(31,NULL,'XAVIER LOW YONG SOON','xlys.roqstar18@live.com','0126071919',NULL,'1981-10-26',NULL,'2013-08-05 10:03:35','2013-08-05 10:03:35',27,3,'e8d7e1804c8bb8d8578167f79a7fec31',NULL,NULL,NULL,NULL,1,1),(32,NULL,'RUBY YEW ZU PIN','ruby.yew@hotmail.com','0126358155',NULL,'1975-08-16',NULL,'2013-08-05 10:07:37','2013-08-05 10:07:37',22,1,'835dbe9f96bf139fd99eba276fb27ece',NULL,NULL,NULL,NULL,1,1),(33,NULL,'CHEONG MEI THENG','meiting0409@gmail.com','0176467611',NULL,'1993-04-09',NULL,'2013-08-05 10:10:14','2013-08-05 10:10:14',20,3,'727b5fd1e7c956cccfccfebcf1acb56a',NULL,NULL,NULL,NULL,1,0),(34,NULL,'LOW MEI CHING','kokhualeong@kimo.com','0166762991',NULL,'1975-07-05',NULL,'2013-08-05 10:12:03','2013-08-05 10:12:03',26,3,'ab4721ced31cb3f1796bb62030f84df3',NULL,NULL,NULL,NULL,1,1),(35,NULL,'ANDREW LIM TZE XIANG','andrewlim65@gmail.com','0167416366',NULL,'1989-02-14',NULL,'2013-08-05 10:18:08','2013-08-05 10:18:08',23,3,'ae6e92e486ff47b01b62b5490c4fc400',NULL,NULL,112233,900465,1,0),(36,NULL,'LEE WEN DER','821212nel@gmail.com','0126398661',NULL,'1988-12-12',NULL,'2013-08-05 10:19:36','2013-08-05 10:19:36',35,3,'2bed64834d3bd81ed7da2f882d64edbb',NULL,NULL,881212,888124,1,1),(37,NULL,'TONY SNG ENG KEONG','tonysng1111@gmail.com','0196799319',NULL,'1987-10-13',NULL,'2013-08-05 10:20:59','2013-08-05 10:20:59',36,2,'df12702d0c3507b8e0fbbf4cd02b5acb',NULL,NULL,NULL,NULL,1,0),(39,NULL,'Chee Yik Keong','darren@pentajeu.com','0175922315',NULL,'2013-08-09',NULL,'2013-08-09 15:08:07','2013-08-09 15:11:27',1,1,'a7b42feb3c5cd9af64f62765b8ebefc6',NULL,NULL,888888,316607,1,1),(40,NULL,'YEO WENG KEONG','wk2202@gmail.com','0126312202',NULL,'1982-08-05',NULL,'2013-08-13 11:25:30','2013-08-13 11:25:30',22,1,'e99a18c428cb38d5f260853678922e03',NULL,NULL,NULL,NULL,1,1),(41,NULL,'TIOW MEI CHEN','tmc@q.com','0167229041',NULL,'2013-02-02',NULL,'2013-08-13 11:31:04','2013-08-13 11:31:04',19,2,'b7b20e356e1535be2b6332da5199b146',NULL,NULL,25150,127939,1,1),(42,NULL,'TE MING REN','TMG@A.COM','0127823325',NULL,'1992-02-02',NULL,'2013-08-13 11:34:32','2013-08-13 11:34:32',36,2,'e99a18c428cb38d5f260853678922e03',NULL,NULL,NULL,NULL,1,1),(43,NULL,'LIM LEE HONG','crystallim1123@hotmail.com','0199392117',NULL,'1989-07-12',NULL,'2013-08-13 11:38:35','2013-08-13 11:38:35',23,2,'eaafec8bc4251511738c50105e37be01',NULL,NULL,NULL,NULL,1,1),(44,NULL,'Ngow eugune','Ngoweugene@hotmail.com','0105668651',NULL,'1989-06-01',NULL,'2013-08-14 17:57:31','2013-08-14 17:57:31',43,1,'e99a18c428cb38d5f260853678922e03',NULL,NULL,NULL,NULL,1,1),(45,NULL,'Yeap soon jau','Ysoonjau@facebook.com','0126816998',NULL,'1995-01-20',NULL,'2013-08-14 18:06:11','2013-08-14 18:06:11',44,1,'e99a18c428cb38d5f260853678922e03',NULL,NULL,NULL,NULL,1,1),(46,NULL,'Lee huay min','Coolangel_min@hotmail.com','0176755697',NULL,'1989-09-01',NULL,'2013-08-14 18:08:29','2013-08-14 18:08:29',44,1,'e99a18c428cb38d5f260853678922e03',NULL,NULL,NULL,NULL,1,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet`
--

DROP TABLE IF EXISTS `wallet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wallet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foodPoint` double NOT NULL,
  `cashPoint` double DEFAULT NULL,
  `userId` bigint(10) unsigned NOT NULL,
  `modifiedDate` datetime NOT NULL,
  `bonusAmount` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wallet_user_idx` (`userId`),
  CONSTRAINT `fk_wallet_user_idx` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet`
--

LOCK TABLES `wallet` WRITE;
/*!40000 ALTER TABLE `wallet` DISABLE KEYS */;
INSERT INTO `wallet` VALUES (1,3850,NULL,3,'2013-07-22 08:34:32',NULL),(2,3850,NULL,4,'2013-07-22 08:34:32',NULL),(3,600,967.5,5,'2013-08-05 09:33:31',NULL),(4,600,1632.5,6,'2013-08-14 18:06:58',NULL),(5,600,1067.5,7,'2013-08-14 18:06:58',NULL),(6,3850,1042.5,8,'2013-08-14 18:06:58',NULL),(7,3850,987.5,9,'2013-08-05 09:33:05',NULL),(8,3850,525,10,'2013-08-05 09:33:05',NULL),(9,3850,765,11,'2013-08-05 14:20:14',NULL),(10,600,525,12,'2013-07-31 06:23:11',NULL),(11,3850,NULL,13,'2013-07-22 08:34:32',NULL),(12,600,262.5,14,'2013-08-05 09:32:03',NULL),(13,3850,NULL,15,'2013-07-22 08:34:32',NULL),(14,3850,NULL,16,'2013-07-22 08:34:32',NULL),(15,3850,NULL,17,'2013-07-22 08:34:32',NULL),(16,1650,NULL,18,'2013-07-22 08:34:32',NULL),(17,1650,112.5,19,'2013-08-14 18:06:58',NULL),(18,600,737.5,20,'2013-08-05 14:20:14',NULL),(19,3850,NULL,21,'2013-07-22 08:34:32',NULL),(20,3850,737.5,22,'2013-08-14 18:06:58',NULL),(21,1650,520,23,'2013-08-14 18:34:25',NULL),(22,3850,NULL,24,'2013-07-22 08:34:32',NULL),(23,3850,NULL,25,'2013-07-22 08:34:32',NULL),(24,0,0,1,'2013-08-14 16:57:10',NULL),(47,3850,NULL,26,'2013-07-24 04:41:42',NULL),(48,3850,262.5,27,'2013-08-07 13:29:20',NULL),(49,600,262.5,28,'2013-08-05 09:32:23',NULL),(50,3850,NULL,29,'2013-08-01 14:46:56',NULL),(51,3850,NULL,30,'2013-08-05 09:56:15',NULL),(52,3850,NULL,31,'2013-08-05 10:03:35',NULL),(53,600,NULL,32,'2013-08-05 10:07:37',NULL),(54,3850,NULL,33,'2013-08-05 10:10:14',NULL),(55,3850,NULL,34,'2013-08-05 10:12:03',NULL),(56,3850,150,35,'2013-08-14 18:06:58',NULL),(57,3850,225,36,'2013-08-14 18:06:58',NULL),(58,1650,NULL,37,'2013-08-05 10:20:59',NULL),(60,600,NULL,39,'2013-08-09 15:08:07',NULL),(61,600,NULL,40,'2013-08-13 11:25:30',NULL),(62,1650,NULL,41,'2013-08-13 11:31:04',NULL),(63,1650,NULL,42,'2013-08-13 11:34:32',NULL),(64,1650,87.5,43,'2013-08-14 18:35:13',NULL),(65,600,75,44,'2013-08-14 18:35:13',NULL),(66,600,NULL,45,'2013-08-14 18:06:11',NULL),(67,600,NULL,46,'2013-08-14 18:08:29',NULL);
/*!40000 ALTER TABLE `wallet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdrawal`
--

DROP TABLE IF EXISTS `withdrawal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdrawal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `walletId` int(10) unsigned NOT NULL,
  `amount` float(13,4) NOT NULL,
  `balance` float(13,4) NOT NULL,
  `tranDate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `walletId` (`walletId`),
  CONSTRAINT `withdrawal_ibfk_1` FOREIGN KEY (`walletId`) REFERENCES `wallet` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdrawal`
--

LOCK TABLES `withdrawal` WRITE;
/*!40000 ALTER TABLE `withdrawal` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdrawal` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-08-15  5:02:06
