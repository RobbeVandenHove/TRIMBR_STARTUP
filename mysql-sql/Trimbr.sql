-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mydb
-- ------------------------------------------------------
-- Server version	8.0.22

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categoryproducts`
--

DROP TABLE IF EXISTS `categoryproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoryproducts` (
  `Category_Id` int NOT NULL,
  `Products_Id` int NOT NULL,
  PRIMARY KEY (`Category_Id`,`Products_Id`),
  KEY `fk_Category_has_Products_Products1_idx` (`Products_Id`),
  KEY `fk_Category_has_Products_Category1_idx` (`Category_Id`),
  CONSTRAINT `fk_Category_has_Products_Category1` FOREIGN KEY (`Category_Id`) REFERENCES `category` (`Id`),
  CONSTRAINT `fk_Category_has_Products_Products1` FOREIGN KEY (`Products_Id`) REFERENCES `products` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `OrderDateTime` datetime NOT NULL,
  `ExpectedDateTime` datetime NOT NULL,
  `ShoppingCart_Id` int NOT NULL,
  `Users_Id` int NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_Orders_ShoppingCart1_idx` (`ShoppingCart_Id`),
  KEY `fk_Orders_Users1_idx` (`Users_Id`),
  CONSTRAINT `fk_Orders_ShoppingCart1` FOREIGN KEY (`ShoppingCart_Id`) REFERENCES `shoppingcart` (`Id`),
  CONSTRAINT `fk_Orders_Users1` FOREIGN KEY (`Users_Id`) REFERENCES `users` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Price` int NOT NULL,
  `Description` text NOT NULL,
  `Type` enum('Trousers','Shirt','Vest','Full') NOT NULL,
  `Discount` int DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `productsorders`
--

DROP TABLE IF EXISTS `productsorders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productsorders` (
  `Products_Id` int NOT NULL,
  `Orders_Id` int NOT NULL,
  PRIMARY KEY (`Products_Id`,`Orders_Id`),
  KEY `fk_Products_has_Orders_Orders1_idx` (`Orders_Id`),
  KEY `fk_Products_has_Orders_Products_idx` (`Products_Id`),
  CONSTRAINT `fk_Products_has_Orders_Orders1` FOREIGN KEY (`Orders_Id`) REFERENCES `orders` (`Id`),
  CONSTRAINT `fk_Products_has_Orders_Products` FOREIGN KEY (`Products_Id`) REFERENCES `products` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Naam` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shoppingcart`
--

DROP TABLE IF EXISTS `shoppingcart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shoppingcart` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Count` int NOT NULL,
  `Total` int NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `userrole`
--

DROP TABLE IF EXISTS `userrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userrole` (
  `Role_Id` int NOT NULL,
  `Users_Id` int NOT NULL,
  PRIMARY KEY (`Role_Id`,`Users_Id`),
  KEY `fk_Role_has_Users_Users1_idx` (`Users_Id`),
  KEY `fk_Role_has_Users_Role1_idx` (`Role_Id`),
  CONSTRAINT `fk_Role_has_Users_Role1` FOREIGN KEY (`Role_Id`) REFERENCES `role` (`Id`),
  CONSTRAINT `fk_Role_has_Users_Users1` FOREIGN KEY (`Users_Id`) REFERENCES `users` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `City` varchar(45) NOT NULL,
  `Street` varchar(45) NOT NULL,
  `HouseNumber` varchar(45) NOT NULL,
  `PostalCode` varchar(45) NOT NULL,
  `Password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'mydb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-25 21:01:31
