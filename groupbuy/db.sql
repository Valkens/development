/*
SQLyog Enterprise - MySQL GUI v8.12 
MySQL - 5.5.27 : Database - s3222629
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`s3222629` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `s3222629`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`) values (1,'Clothes'),(2,'Laptop - Pc'),(3,'Food');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` char(32) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `customers` */

insert  into `customers`(`id`,`email`,`password`,`fullname`) values (1,'legiaphong@gmail.com','1dc70d29697300dca662e859e7b56d06','le gia phong');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `deals` */

insert  into `deals`(`id`,`name`,`description`,`original_price`,`group_buy_price`,`saving_percent`,`buyers`,`maximum_buyers_allowed`,`expired_time`,`status`,`conditions`,`background_image`,`summary_image`,`image1`,`image2`,`image3`,`image4`,`id_category`) values (2,'Cheap Ipad deal','Apple\'s iPads are, without doubt, the world\'s most popular tablets. Like all Apple products, though, they don\'t come cheap, so think long and hard before parting with your cash.','399','299',30,59,99,'2012-12-30 00:00:00',1,'10-30/11/2012','public/images/upload/deals/2/bg_50b8b8456fcf95.14561612.jpg','public/images/upload/deals/2/sm_50b8b8456ff5b9.14514477.jpg','public/images/upload/deals/2/im1_50b8b845701338.74359908.jpg','public/images/upload/deals/2/im2_50b8b845702e33.98404883.jpg','public/images/upload/deals/2/im3_50b8b8457049a2.09620994.jpg','public/images/upload/deals/2/im4_50b8b845706437.26384046.jpg',2),(3,'Saigon Deals','Delicious, authentic-tasting Vietnamese food. You can have it with very low price and delicious taste. Great for a meal with friends or family. ','30','20',30,10,50,'2013-01-01 00:00:00',1,'10-30/11/2012','public/images/upload/deals/3/bg_50b8b4b5a421c1.50959105.jpg','public/images/upload/deals/3/sm_50b8b4b5a44b34.13909106.jpg','public/images/upload/deals/3/im1_50b8b4b5a46d72.18655041.jpg','public/images/upload/deals/3/im2_50b8b4b5a48f22.82049935.jpg','public/images/upload/deals/3/im3_50b8b4b5a4b041.78106538.jpg','public/images/upload/deals/3/im4_50b8b4b5a4d189.73634518.jpg',3);

/*Table structure for table `questions` */

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) unsigned NOT NULL,
  `content` text NOT NULL,
  `answer` text,
  `id_deal` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `questions` */

insert  into `questions`(`id`,`id_customer`,`content`,`answer`,`id_deal`) values (1,1,'Bạn nên dừng lại ở việc thích, chứ đừng ở mức yêu\r\nVì giai đoạn này, hooc môn sinh dục của bạn đang phát triển, nên các bạn có nhu cầu tìm hiểu nhau, thích yêu lẫn lộn.','Hay qua la hay luon !!!',2);

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) unsigned NOT NULL,
  `id_deal` int(11) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `total_charge` double unsigned NOT NULL,
  `card_holder` varchar(255) NOT NULL,
  `card_number` varchar(30) NOT NULL,
  `expired_date` varchar(5) NOT NULL,
  `secured_code` char(4) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `transactions` */

insert  into `transactions`(`id`,`id_customer`,`id_deal`,`quantity`,`total_charge`,`card_holder`,`card_number`,`expired_date`,`secured_code`,`timestamp`) values (1,1,2,5,1495,'le hoang duc','0123','03/16','0987','2012-12-18 00:06:07');

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
