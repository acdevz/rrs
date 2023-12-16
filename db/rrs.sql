-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 34.93.74.195    Database: rrs
-- ------------------------------------------------------
-- Server version	8.0.31-google

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '96acdd08-865a-11ee-8919-42010a400002:1-443969';

--
-- Table structure for table `CANCEL`
--

DROP TABLE IF EXISTS `CANCEL`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CANCEL` (
  `username` varchar(50) NOT NULL,
  `ticket_id` int NOT NULL,
  `passenger_id` int DEFAULT NULL,
  PRIMARY KEY (`username`,`ticket_id`),
  KEY `cancel_user_username_idx` (`username`),
  KEY `cancel_ticket_ticket_id_idx` (`ticket_id`),
  KEY `cancel_passenger_passenger_id_idx` (`passenger_id`),
  CONSTRAINT `cancel_passenger_passenger_id` FOREIGN KEY (`passenger_id`) REFERENCES `PASSENGER` (`passenger_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cancel_ticket_ticket_id` FOREIGN KEY (`ticket_id`) REFERENCES `TICKET` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cancel_user_username` FOREIGN KEY (`username`) REFERENCES `USER` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PASSENGER`
--

DROP TABLE IF EXISTS `PASSENGER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PASSENGER` (
  `passenger_id` int NOT NULL AUTO_INCREMENT,
  `pnr_no` char(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `class` char(2) DEFAULT NULL,
  `seat_no` varchar(20) DEFAULT NULL,
  `ticket_id` int DEFAULT NULL,
  PRIMARY KEY (`passenger_id`),
  KEY `passenger_user_username_idx` (`username`),
  CONSTRAINT `passenger_user_username` FOREIGN KEY (`username`) REFERENCES `USER` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `STARTS`
--

DROP TABLE IF EXISTS `STARTS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `STARTS` (
  `train_no` int NOT NULL,
  `station_code` varchar(10) NOT NULL,
  PRIMARY KEY (`train_no`,`station_code`),
  KEY `STARTS_ibfk_2` (`station_code`),
  CONSTRAINT `STARTS_ibfk_1` FOREIGN KEY (`train_no`) REFERENCES `TRAIN` (`train_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `STARTS_ibfk_2` FOREIGN KEY (`station_code`) REFERENCES `STATION` (`station_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `STARTS`
--

LOCK TABLES `STARTS` WRITE;
/*!40000 ALTER TABLE `STARTS` DISABLE KEYS */;
INSERT INTO `STARTS` VALUES (12318,'ASR'),(12380,'ASR'),(13006,'ASR'),(19614,'ASR'),(12587,'GKP');
/*!40000 ALTER TABLE `STARTS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `STATION`
--

DROP TABLE IF EXISTS `STATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `STATION` (
  `station_code` varchar(10) NOT NULL,
  `station_name` varchar(50) DEFAULT NULL,
  `train_no` int NOT NULL,
  `arrival_time` time DEFAULT NULL,
  `hault` int DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `dist` int DEFAULT NULL,
  `day` tinyint DEFAULT NULL,
  PRIMARY KEY (`station_code`,`train_no`),
  KEY `station_train_train_no_idx` (`train_no`),
  CONSTRAINT `station_train_train_no` FOREIGN KEY (`train_no`) REFERENCES `TRAIN` (`train_no`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `STATION`
--

LOCK TABLES `STATION` WRITE;
/*!40000 ALTER TABLE `STATION` DISABLE KEYS */;
INSERT INTO `STATION` VALUES ('AII','Ajmer Jn',19614,'09:00:00',0,'00:00:00',848,2),('AME','Amethi',13006,'13:07:00',1,'13:08:00',1022,2),('ARA','Ara',13006,'20:23:00',2,'20:25:00',1330,2),('ASN','Asansol Jn',12318,'11:18:00',10,'11:28:00',1692,2),('ASN','Asansol Jn',12380,'12:53:00',10,'13:03:00',1688,2),('ASN','Asansol Jn',13006,'03:58:00',5,'04:03:00',1710,3),('ASR','Amritsar Jn',12318,'00:00:00',0,'05:55:00',0,1),('ASR','Amritsar Jn',12380,'00:00:00',0,'13:25:00',1,1),('ASR','Amritsar Jn',13006,'00:00:00',0,'18:25:00',64,1),('ASR','Amritsar Jn',19614,'00:00:00',0,'17:45:00',43,1),('AWR','Alwar Jn',19614,'03:50:00',3,'03:53:00',598,2),('BCN','Bachhrawn',13006,'11:33:00',1,'11:34:00',927,2),('BE','Bareilly',12318,'16:20:00',2,'16:22:00',614,1),('BE','Bareilly',12587,'23:21:00',2,'23:23:00',506,1),('BE','Bareilly',13006,'06:21:00',2,'06:23:00',685,2),('BEAS','Beas',12318,'06:23:00',2,'06:25:00',43,1),('BEAS','Beas',12380,'13:53:00',2,'13:55:00',43,1),('BEAS','Beas',13006,'18:53:00',2,'18:55:00',107,1),('BEAS','Beas',19614,'18:13:00',2,'18:15:00',79,1),('BKI','Bandikui Jn',19614,'04:49:00',2,'04:51:00',652,2),('BKP','Bakhtiyarpur Jn',13006,'22:28:00',2,'22:30:00',1424,2),('BLM','Balamau Jn',13006,'08:53:00',2,'08:55:00',849,2),('BNW','Bhiwani',19614,'01:15:00',5,'01:20:00',433,2),('BOY','Bhadohi',13006,'15:21:00',2,'15:23:00',1150,2),('BSB','Varanasi Jn',12318,'00:40:00',10,'00:50:00',1132,2),('BSB','Varanasi Jn',13006,'16:50:00',10,'17:00:00',1156,2),('BSE','Badshahpur',13006,'14:23:00',2,'14:25:00',1075,2),('BST','Basti',12587,'15:19:00',3,'15:22:00',65,1),('BU','Baswa',19614,'04:35:00',2,'04:37:00',623,2),('BWN','Barddhaman',12380,'14:33:00',2,'14:35:00',1793,2),('BWN','Barddhaman',13006,'05:45:00',4,'05:49:00',1816,3),('BXR','Buxar',13006,'19:32:00',2,'19:34:00',1277,2),('CKD','Charkhi Dadri',19614,'01:43:00',2,'01:45:00',488,2),('CNB','Kanpur Central',12380,'01:10:00',5,'01:15:00',880,2),('CRJ','Chittaranjan',13006,'03:12:00',2,'03:14:00',1685,3),('DDU','Dd Upadhyaya Jn',12318,'02:15:00',10,'02:25:00',1149,2),('DDU','Dd Upadhyaya Jn',12380,'06:10:00',10,'06:20:00',1227,2),('DDU','Dd Upadhyaya Jn',13006,'17:55:00',10,'18:05:00',1211,2),('DGR','Durgapur',12380,'13:35:00',2,'13:37:00',1730,2),('DGR','Durgapur',13006,'04:39:00',2,'04:41:00',1752,3),('DHN','Dhanbad Jn',12380,'11:37:00',5,'11:42:00',1629,2),('DLI','Delhi',12380,'20:00:00',15,'20:15:00',447,1),('DLN','Dildarnagar Jn',13006,'18:58:00',2,'19:00:00',1241,2),('DNR','Danapur',13006,'21:00:00',2,'21:02:00',1369,2),('DO','Dausa',19614,'05:13:00',2,'05:15:00',702,2),('DPR','Dhampur',13006,'03:16:00',2,'03:18:00',523,2),('DUI','Dhuri Jn',19614,'21:25:00',10,'21:35:00',214,1),('GADJ','Gandhinagar Jaipur',19614,'06:02:00',3,'06:05:00',713,2),('GAYA','Gaya Jn',12380,'08:40:00',5,'08:45:00',1430,2),('GD','Gonda Jn',12587,'16:45:00',10,'16:55:00',154,1),('GKP','Gorakhpur',12587,'00:00:00',0,'14:20:00',0,1),('GMR','Gahmar',13006,'19:14:00',2,'19:16:00',1261,2),('GNG','Gauriganj',13006,'12:51:00',2,'12:53:00',987,2),('GTJT','Getor Jagatpura',19614,'05:50:00',2,'05:52:00',708,2),('HRI','Hardoi',13006,'08:24:00',2,'08:26:00',780,2),('HSR','Hisar',19614,'23:55:00',20,'00:15:00',406,2),('HWH','Howrah Jn',13006,'07:30:00',0,'00:00:00',1910,3),('JAIS','Jais',13006,'12:34:00',1,'12:35:00',974,2),('JAJ','Jhajha',12318,'09:00:00',5,'09:05:00',1538,2),('JAJ','Jhajha',13006,'01:23:00',5,'01:28:00',1556,3),('JAT','Jammu Tawi',12587,'13:00:00',0,'00:00:00',1248,2),('JHL','Jakhal Jn',19614,'22:37:00',3,'22:40:00',346,2),('JNH','Janghai Jn',13006,'14:46:00',2,'14:48:00',1106,2),('JP','Jaipur',19614,'06:30:00',10,'06:40:00',822,2),('JRC','Jalandhar Cant',12587,'08:24:00',5,'08:29:00',1036,2),('JRC','Jalandhar Cant',13006,'19:49:00',2,'19:51:00',100,1),('JSME','Jasidih Jn',12318,'09:37:00',2,'09:39:00',1582,2),('JSME','Jasidih Jn',13006,'02:00:00',5,'02:05:00',1600,3),('JUC','Jalandhar City',12318,'07:02:00',5,'07:07:00',79,1),('JUC','Jalandhar City',12380,'14:30:00',5,'14:35:00',79,1),('JUC','Jalandhar City',13006,'19:32:00',8,'19:40:00',84,1),('JUC','Jalandhar City',19614,'18:52:00',5,'18:57:00',100,1),('KEI','Kashi',13006,'17:12:00',1,'17:13:00',1167,2),('KIUL','Kiul Jn',12318,'07:56:00',4,'08:00:00',1484,2),('KIUL','Kiul Jn',13006,'23:48:00',2,'23:50:00',1502,2),('KLD','Khalilabad',12587,'14:54:00',2,'14:56:00',35,1),('KMME','Kumardubi',12380,'12:28:00',1,'12:29:00',1668,2),('KOAA','Kolkata',12318,'14:50:00',0,'00:00:00',1894,2),('KQR','Koderma',12380,'09:54:00',2,'09:56:00',1508,2),('KRE','Kartarpur',13006,'19:13:00',1,'19:14:00',79,1),('KRH','Khairthal',19614,'03:28:00',2,'03:30:00',562,2),('KSG','Kishangarh',19614,'08:00:00',2,'08:02:00',822,2),('KTHU','Kathua',12587,'11:04:00',2,'11:06:00',1172,2),('LDH','Ludhiana Jn',12318,'08:02:00',10,'08:12:00',136,1),('LDH','Ludhiana Jn',12380,'15:30:00',8,'15:38:00',136,1),('LDH','Ludhiana Jn',12587,'07:26:00',10,'07:36:00',984,2),('LDH','Ludhiana Jn',13006,'20:40:00',10,'20:50:00',222,1),('LDH','Ludhiana Jn',19614,'20:02:00',10,'20:12:00',181,1),('LKO','Lucknow',12318,'20:05:00',10,'20:15:00',849,1),('LKO','Lucknow',12587,'19:20:00',10,'19:30:00',271,1),('LKO','Lucknow',13006,'10:35:00',5,'10:40:00',896,2),('LRJ','Laksar Jn',12587,'02:54:00',2,'02:56:00',736,2),('LRJ','Laksar Jn',13006,'01:58:00',2,'02:00:00',425,2),('MB','Moradabad',12318,'14:52:00',8,'15:00:00',523,1),('MB','Moradabad',12587,'00:57:00',8,'01:05:00',597,2),('MB','Moradabad',13006,'04:53:00',5,'04:58:00',551,2),('MBDP','Ma Belhadevi Dp',13006,'13:45:00',5,'13:50:00',1059,2),('MDP','Madhupur Jn',12318,'10:04:00',2,'10:06:00',1611,2),('MDP','Madhupur Jn',13006,'02:30:00',4,'02:34:00',1629,3),('MET','Malerkotla',19614,'20:48:00',2,'20:50:00',198,1),('MKA','Mokameh Jn',12318,'07:04:00',2,'07:06:00',1450,2),('MKA','Mokameh Jn',13006,'23:05:00',5,'23:10:00',1468,2),('NBD','Najibabad Jn',12318,'13:04:00',2,'13:06:00',425,1),('NBD','Najibabad Jn',13006,'02:36:00',2,'02:38:00',447,2),('NGG','Nagina',13006,'02:58:00',2,'03:00:00',464,2),('PGW','Phagwara Jn',13006,'20:03:00',2,'20:05:00',136,1),('PGW','Phagwara Jn',19614,'19:15:00',2,'19:17:00',136,1),('PNBE','Patna Jn',12318,'05:35:00',10,'05:45:00',1361,2),('PNBE','Patna Jn',13006,'21:30:00',10,'21:40:00',1379,2),('PNC','Patna Saheb',12318,'06:00:00',5,'06:05:00',1371,2),('PNC','Patna Saheb',13006,'21:55:00',5,'22:00:00',1389,2),('PTKC','Pathankot Cantt',12587,'10:30:00',5,'10:35:00',1149,2),('RBL','Rae Bareli Jn',13006,'12:05:00',5,'12:10:00',956,2),('RE','Rewari',19614,'02:50:00',5,'02:55:00',536,2),('RHG','Rajgarh',19614,'04:21:00',2,'04:23:00',610,2),('RK','Roorkee',12587,'03:16:00',2,'03:18:00',754,2),('RK','Roorkee',13006,'01:37:00',2,'01:39:00',384,2),('RMU','Rampur',13006,'05:25:00',2,'05:27:00',614,2),('RNG','Raniganj',13006,'04:19:00',2,'04:21:00',1728,3),('RPJ','Rajpura Jn',13006,'22:06:00',2,'22:08:00',250,1),('SAG','Sangrur',19614,'21:48:00',2,'21:50:00',264,1),('SDAH','Sealdah',12380,'16:35:00',0,'00:00:00',1894,2),('SIR','Sirhind Jn',12318,'09:09:00',2,'09:11:00',196,1),('SLN','Sultanpur Jn',12318,'22:11:00',2,'22:13:00',989,1),('SPN','Shahjehanpur',12587,'22:20:00',2,'22:22:00',435,1),('SPN','Shahjehanpur',13006,'07:29:00',2,'07:31:00',747,2),('SRE','Saharanpur',12318,'11:20:00',5,'11:25:00',331,1),('SRE','Saharanpur',12587,'04:15:00',10,'04:25:00',789,2),('SRE','Saharanpur',13006,'00:45:00',10,'00:55:00',366,2),('SSM','Sasaram',12380,'07:18:00',2,'07:20:00',1327,2),('UMB','Ambala Cant Jn',12318,'10:00:00',5,'10:05:00',250,1),('UMB','Ambala Cant Jn',12380,'17:15:00',10,'17:25:00',250,1),('UMB','Ambala Cant Jn',12587,'05:45:00',5,'05:50:00',870,2),('UMB','Ambala Cant Jn',13006,'23:00:00',10,'23:10:00',301,1),('YJUD','Yamunanagar Jagadhri',12587,'04:51:00',2,'04:53:00',819,2),('YJUD','Yamunanagar Jagadhri',13006,'23:45:00',5,'23:50:00',331,1),('ZNA','Zamania',13006,'18:43:00',2,'18:45:00',1225,2);
/*!40000 ALTER TABLE `STATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `STOPS`
--

DROP TABLE IF EXISTS `STOPS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `STOPS` (
  `train_no` int NOT NULL,
  `station_code` varchar(10) NOT NULL,
  PRIMARY KEY (`train_no`,`station_code`),
  KEY `STOPS_ibfk_2` (`station_code`),
  CONSTRAINT `STOPS_ibfk_1` FOREIGN KEY (`train_no`) REFERENCES `TRAIN` (`train_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `STOPS_ibfk_2` FOREIGN KEY (`station_code`) REFERENCES `STATION` (`station_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `STOPS`
--

LOCK TABLES `STOPS` WRITE;
/*!40000 ALTER TABLE `STOPS` DISABLE KEYS */;
INSERT INTO `STOPS` VALUES (19614,'AII'),(13006,'HWH'),(12587,'JAT'),(12318,'KOAA'),(12380,'SDAH');
/*!40000 ALTER TABLE `STOPS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TICKET`
--

DROP TABLE IF EXISTS `TICKET`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TICKET` (
  `ticket_id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `no_of_passengers` int DEFAULT NULL,
  `train_no` int DEFAULT NULL,
  `from` varchar(10) DEFAULT NULL,
  `to` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `fare` float DEFAULT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `ticket_user_username_idx` (`username`),
  CONSTRAINT `ticket_user_username` FOREIGN KEY (`username`) REFERENCES `USER` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TRAIN`
--

DROP TABLE IF EXISTS `TRAIN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TRAIN` (
  `train_no` int NOT NULL,
  `train_name` varchar(50) NOT NULL,
  `travel` double DEFAULT NULL,
  `distance` int DEFAULT NULL,
  `mon` char(1) DEFAULT NULL,
  `tue` char(1) DEFAULT NULL,
  `wed` char(1) DEFAULT NULL,
  `thu` char(1) DEFAULT NULL,
  `fri` char(1) DEFAULT NULL,
  `sat` char(1) DEFAULT NULL,
  `sun` char(1) DEFAULT NULL,
  `f_sl` float DEFAULT NULL,
  `f_3a` float DEFAULT NULL,
  `f_2a` float DEFAULT NULL,
  `f_1a` float DEFAULT NULL,
  PRIMARY KEY (`train_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TRAIN`
--

LOCK TABLES `TRAIN` WRITE;
/*!40000 ALTER TABLE `TRAIN` DISABLE KEYS */;
INSERT INTO `TRAIN` VALUES (12318,'AKAL TAKHAT EXP',32.55,1894,'x','Y','x','x','Y','x','x',0.4,1.5,1.85,3.5),(12380,'JALIANWALA B EX',27.1,1894,'x','x','x','x','x','x','Y',0.4,1.2,1.5,2.8),(12587,'AMARNATH EXP',22.4,1248,'Y','x','x','x','x','x','x',0.46,1.22,1.7,3),(13006,'ASR HWH MAIL',37.05,1910,'Y','Y','Y','Y','Y','Y','Y',0.5,1.3,1.75,3.2),(19614,'ASR AII EXP',12.45,848,'x','x','x','x','Y','x','Y',0.5,1.3,1.75,3.2);
/*!40000 ALTER TABLE `TRAIN` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TRAIN_STATUS`
--

DROP TABLE IF EXISTS `TRAIN_STATUS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TRAIN_STATUS` (
  `train_no` int NOT NULL,
  `_1A` varchar(10) DEFAULT NULL,
  `_2A` varchar(10) DEFAULT NULL,
  `_3A` varchar(10) DEFAULT NULL,
  `_SL` varchar(10) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`train_no`,`date`),
  CONSTRAINT `train_status_train_no` FOREIGN KEY (`train_no`) REFERENCES `TRAIN` (`train_no`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TRAIN_STATUS`
--

LOCK TABLES `TRAIN_STATUS` WRITE;
/*!40000 ALTER TABLE `TRAIN_STATUS` DISABLE KEYS */;
INSERT INTO `TRAIN_STATUS` VALUES (12318,'AVL5','AVL5','NO_AVL','GNWL8','2023-12-15'),(12318,'AVL2','AVL10','AVL3','GNWL6','2023-12-19'),(12380,'AVL10','AVL9','AVL4','NO_AVL','2023-12-17'),(12587,'GNWL10','GNWL11','GNWL38','GNWL96','2023-12-18'),(13006,'GNWL3','AVL8','AVL2','NO_AVL','2023-12-15'),(13006,'GNWL10','AVL8','AVL3','GNWL1','2023-12-16'),(13006,'GNWL5','AVL6','AVL4','AVL2L','2023-12-17'),(13006,'AVL2','AVL8','AVL1','AVL5','2023-12-18'),(13006,'AVL20','AVL9','AVL5','AVL1','2023-12-19'),(19614,'AVL5','AVL2','AVL1','GNWL2','2023-12-15'),(19614,'AVL10','AVL12','AVL8','GNWL2','2023-12-17');
/*!40000 ALTER TABLE `TRAIN_STATUS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USER`
--

DROP TABLE IF EXISTS `USER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `USER` (
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `mobile_no` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-16 22:31:31
