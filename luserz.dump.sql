-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: saami
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `luserz`
--

DROP TABLE IF EXISTS `luserz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `luserz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `ddn` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luserz`
--

LOCK TABLES `luserz` WRITE;
/*!40000 ALTER TABLE `luserz` DISABLE KEYS */;
INSERT INTO `luserz` VALUES (9,'Norimaki','Senbei','2018-10-18'),(14,'Son','Goku','2018-10-10'),(15,'Son','Gohan','2018-02-14'),(17,'Toriyama','Akira','2018-10-03'),(21,'Yamabuki','Midori','2018-10-11'),(24,'Norimaki','Gatchan','2018-10-04'),(29,'Son','Goten','2018-10-05'),(32,'Saotome','Ranma','2018-10-01'),(33,'Saotome','Genma','2018-10-17'),(34,'Tendo','Akane','2018-10-16'),(35,'Tendo','Nabiki','2018-10-02'),(36,'Tendo','Kasumi','2018-10-13'),(37,'Takahashi','Rumiko','2018-10-17'),(74,'Masako','Nazawa','1936-10-25'),(75,'Norimaki','Arale','1985-12-21'),(76,'Moustique','Jules-Edouard','1985-12-21'),(77,'Johnny','Be Good','1985-12-21'),(78,'Grand-Mère','D\'Abdel-Krim','1985-12-21');
/*!40000 ALTER TABLE `luserz` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-26 12:07:41
