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
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id_cargo` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `hora_entrada_am` varchar(10) DEFAULT NULL,
  `hora_salida_am` varchar(10) DEFAULT NULL,
  `habilitar_am` varchar(10) DEFAULT NULL,
  `limite_salam` varchar(10) DEFAULT NULL,
  `habilitar_pm` varchar(10) DEFAULT NULL,
  `hora_entrada_pm` varchar(10) DEFAULT NULL,
  `hora_salida_pm` varchar(10) DEFAULT NULL,
  `limite_salpm` varchar(10) DEFAULT NULL,
  `tolerancia` int DEFAULT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES (1,'cirujano','08:00','12:00','07:40','12:30','13:40','14:00','18:00','18:30',10),(2,'odontologo','08:00','12:00','07:40','12:15','13:30','14:00','18:00','18:30',10),(3,'farmacia','07:00','12:00','06:30','12:15','12:45','13:00','22:00','22:30',5),(4,'limpieza','08:00','12:00','07:30','12:15','13:30','14:00','18:00','18:30',10),(5,'enfermera','08:00','13:00','07:40','13:20','13:30','14:00','21:00','21:30',5),(12,'seguridad','08:00','12:00','07:30','12:10','13:40','14:00','18:00','18:30',5),(13,'ejemplo','08:00','12:00','07:30','12:30','13:40','14:00','18:00','18:30',5),(14,'pasante','08:00','12:00','07:30','12:30','13:40','14:00','18:00','18:30',10);
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
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
