/*
SQLyog Ultimate v9.51 
MySQL - 5.5.27 : Database - phong
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`phong` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `phong`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`) values (1,'Clothes'),(2,'Laptop - Pc'),(3,'Food');

/*Table structure for table `deals` */

DROP TABLE IF EXISTS `deals`;

CREATE TABLE `deals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `original_price` decimal(10,0) NOT NULL,
  `group_buy_price` decimal(10,0) NOT NULL,
  `saving_percent` tinyint(3) NOT NULL,
  `buyers` int(11) DEFAULT NULL,
  `maximum_buyers_allowed` int(11) DEFAULT NULL,
  `expired_time` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `conditions` longtext,
  `background_image` varchar(255) DEFAULT NULL,
  `summary_image` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `deals` */

insert  into `deals`(`id`,`name`,`description`,`original_price`,`group_buy_price`,`saving_percent`,`buyers`,`maximum_buyers_allowed`,`expired_time`,`status`,`conditions`,`background_image`,`summary_image`,`image1`,`image2`,`image3`,`image4`,`id_category`) values (1,'Laptop 1','Laptop 1','100','50',50,0,NULL,'2012-11-29 17:22:00',1,'Laptop 1','public/images/upload/deals/1/bg_50b5e5eebe5389.60371307.jpg','public/images/upload/deals/1/sm_50b5e5eebff7a5.10091481.jpg','public/images/upload/deals/1/im1_50b5e5eec9afb1.16997265.jpg','public/images/upload/deals/1/im2_50b5e5eed340d7.72911749.jpg','public/images/upload/deals/1/im3_50b5e5eedf9a63.10114526.jpg','public/images/upload/deals/1/im4_50b5e5eeec1cc0.41537076.jpg',2);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`) values (1,'admin','5fe7d8e5e16f0c416754aea20a6a2466');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
