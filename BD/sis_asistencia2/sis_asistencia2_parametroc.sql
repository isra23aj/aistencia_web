CREATE DATABASE  IF NOT EXISTS `sis_asistencia2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sis_asistencia2`;
-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: sis_asistencia2
-- ------------------------------------------------------
-- Server version	8.0.30

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

--
-- Table structure for table `parametroc`
--

DROP TABLE IF EXISTS `parametroc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parametroc` (
  `id_parametroc` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `entrada` varchar(10) DEFAULT NULL,
  `salida` varchar(10) DEFAULT NULL,
  `habilitar` varchar(10) DEFAULT NULL,
  `limite` varchar(10) DEFAULT NULL,
  `tolerancia` int DEFAULT NULL,
  `area` int DEFAULT NULL,
  `empleado` int DEFAULT NULL,
  PRIMARY KEY (`id_parametroc`),
  KEY `fk5_idx` (`empleado`),
  KEY `fk4_idx` (`area`),
  CONSTRAINT `fk4` FOREIGN KEY (`area`) REFERENCES `area` (`id_area`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk5` FOREIGN KEY (`empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametroc`
--

LOCK TABLES `parametroc` WRITE;
/*!40000 ALTER TABLE `parametroc` DISABLE KEYS */;
INSERT INTO `parametroc` VALUES (9,'seguridad pm_pm','15:00','23:00','14:30','23:30',10,3,17),(10,'seguridad pm_am','23:00','07:00','22:30','07:30',10,3,15),(12,'seguridad am_pm','07:00','15:00','06:00','15:30',10,3,14);
/*!40000 ALTER TABLE `parametroc` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-09 22:54:00
