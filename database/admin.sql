-- MySQL dump 10.13  Distrib 5.7.18, for osx10.12 (x86_64)
--
-- Host: localhost    Database: api
-- ------------------------------------------------------
-- Server version	5.7.18

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
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES (1,0,1,'首页','fa-bar-chart','/',NULL,NULL,'2018-11-26 05:56:33'),(2,0,2,'超级管理','fa-tasks',NULL,NULL,NULL,'2018-11-26 05:57:07'),(3,2,3,'管理员','fa-users','auth/users',NULL,NULL,'2018-11-26 05:55:37'),(4,2,4,'角色','fa-user','auth/roles',NULL,NULL,'2018-11-26 05:55:31'),(5,2,5,'权限','fa-ban','auth/permissions',NULL,NULL,'2018-11-26 05:55:52'),(6,2,6,'菜单','fa-bars','auth/menu',NULL,NULL,'2018-11-26 05:55:59'),(7,2,7,'后台日志','fa-history','auth/logs',NULL,NULL,'2018-11-26 05:56:11'),(8,0,8,'Redis','fa-database','redis',NULL,'2018-11-26 05:51:23','2018-11-26 05:56:22'),(9,0,0,'错误消息','fa-anchor','/errors',NULL,'2018-11-26 06:04:02','2018-11-26 06:04:02'),(10,0,0,'文章','fa-align-left','/articles',NULL,'2018-11-26 06:42:04','2018-11-26 06:42:04'),(11,0,0,'版本管理','fa-flag','/versions',NULL,'2018-11-26 07:36:22','2018-11-26 07:36:22');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_permissions`
--

LOCK TABLES `admin_permissions` WRITE;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
INSERT INTO `admin_permissions` VALUES (1,'All permission','*','','*',NULL,NULL),(2,'Dashboard','dashboard','GET','/',NULL,NULL),(3,'Login','auth.login','','/auth/login\r\n/auth/logout',NULL,NULL),(4,'User setting','auth.setting','GET,PUT','/auth/setting',NULL,NULL),(5,'Auth management','auth.management','','/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs',NULL,NULL),(6,'Redis Manager','ext.redis-manager',NULL,'/redis*','2018-11-26 05:51:23','2018-11-26 05:51:23');
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_menu`
--

LOCK TABLES `admin_role_menu` WRITE;
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;
INSERT INTO `admin_role_menu` VALUES (1,2,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_permissions`
--

LOCK TABLES `admin_role_permissions` WRITE;
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;
INSERT INTO `admin_role_permissions` VALUES (1,1,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_users`
--

LOCK TABLES `admin_role_users` WRITE;
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;
INSERT INTO `admin_role_users` VALUES (1,1,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_roles`
--

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES (1,'Administrator','administrator','2018-11-26 05:48:33','2018-11-26 05:48:33');
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_user_permissions`
--

LOCK TABLES `admin_user_permissions` WRITE;
/*!40000 ALTER TABLE `admin_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$3srZLFWY1CmKn7y9lq0osO5XBGvWbEd1nn/GnvpM.nvMGcvCM7CXm','Administrator',NULL,NULL,'2018-11-26 05:48:33','2018-11-26 05:48:33');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `errors`
--

LOCK TABLES `errors` WRITE;
/*!40000 ALTER TABLE `errors` DISABLE KEYS */;
INSERT INTO `errors` VALUES (1,0,'zh_CN','成功!!','2018-11-22 11:37:43','2018-11-26 06:23:59'),(2,1,'zh_CN','失败，请重试!','2018-11-22 11:37:43','2018-11-22 11:37:43'),(3,100401,'zh_CN','未登录!','2018-11-22 11:37:43','2018-11-22 11:37:43'),(4,100402,'zh_CN','缺少参数!','2018-11-22 11:37:43','2018-11-22 11:37:43'),(5,100403,'zh_CN','参数格式错误!','2018-11-22 11:37:43','2018-11-22 11:37:43'),(6,100404,'zh_CN','请求方法错误!','2018-11-22 11:37:43','2018-11-22 11:37:43'),(7,100429,'zh_CN','连接次数过多，请稍后再试!','2018-11-22 11:37:43','2018-11-22 11:37:43'),(8,100500,'zh_CN','服务器错误，请联系管理员!','2018-11-22 11:37:43','2018-11-22 11:37:43'),(9,100502,'zh_CN','服务器压力太大，请联系管理员!','2018-11-22 11:37:43','2018-11-22 11:37:43');
/*!40000 ALTER TABLE `errors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-07 14:12:47
