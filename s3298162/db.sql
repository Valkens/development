/*
SQLyog Ultimate v9.51 
MySQL - 5.5.27 : Database - s3298162
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`id`,`categoryname`) values (1,'Headphones'),(2,'Video games'),(3,'Accessories');

/*Table structure for table `deals` */

DROP TABLE IF EXISTS `deals`;

CREATE TABLE `deals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `original_price` decimal(10,0) NOT NULL,
  `group_buy_price` decimal(10,0) NOT NULL,
  `saving` tinyint(3) NOT NULL,
  `buyers` int(11) DEFAULT NULL,
  `maximum_buyers_allowed` int(11) DEFAULT NULL,
  `expired_time` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `conditions` longtext,
  `image` varchar(255) DEFAULT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `deals` */

insert  into `deals`(`id`,`name`,`description`,`original_price`,`group_buy_price`,`saving`,`buyers`,`maximum_buyers_allowed`,`expired_time`,`status`,`conditions`,`image`,`id_category`) values (9,'Headphone 1','Headphone 1','100','50',50,10,90,'2012-12-26 00:00:00',1,'Headphone 1 Desc','public/images/deal/deal_50d95a8617fb63.73948860.jpg',1);

/*Table structure for table `purchases` */

DROP TABLE IF EXISTS `purchases`;

CREATE TABLE `purchases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `id_deal` int(11) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `total_charge` double unsigned NOT NULL,
  `card_holder` varchar(255) NOT NULL,
  `card_number` varchar(30) NOT NULL,
  `expired_date` varchar(5) NOT NULL,
  `secured_code` char(4) NOT NULL,
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `purchases` */

insert  into `purchases`(`id`,`id_user`,`id_deal`,`quantity`,`total_charge`,`card_holder`,`card_number`,`expired_date`,`secured_code`,`createtime`) values (2,2,9,3,150,'Admin','897650','01/18','9876','2012-12-25 17:32:01');

/*Table structure for table `questions` */

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `content` text NOT NULL,
  `answer` text,
  `id_deal` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `questions` */

insert  into `questions`(`id`,`id_user`,`content`,`answer`,`id_deal`) values (2,2,'question 1',NULL,0),(3,2,'question 1','Answer1',9);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`email`) values (2,'admin','5fe7d8e5e16f0c416754aea20a6a2466','admin@gmail.com'),(3,'user1','24c9e15e52afc47c225b757e7bee1f9d','user1@gmail.com'),(5,'user2','7e58d63b60197ceb55a1c487989a3720','user2@gmail.com');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
