/*
SQLyog Ultimate v9.51 
MySQL - 5.5.27 : Database - s3299686
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`s3299686` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `s3299686`;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`id`,`category`) values (1,'FOOD & DRINK'),(2,'MEN CLOTHES'),(3,'WOMAN CLOTHES');

/*Table structure for table `comment` */

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL,
  `content` text NOT NULL,
  `answer` text,
  `dealid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `comment` */

insert  into `comment`(`id`,`userid`,`content`,`answer`,`dealid`) values (8,2,'Hoi 1','Dap 1',5);

/*Table structure for table `deal` */

DROP TABLE IF EXISTS `deal`;

CREATE TABLE `deal` (
  `dealid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) unsigned NOT NULL,
  `dealname` varchar(255) NOT NULL,
  `olprice` double unsigned NOT NULL,
  `price` double unsigned NOT NULL,
  `saving` tinyint(3) unsigned NOT NULL,
  `currentbuyer` int(11) unsigned DEFAULT NULL,
  `maxbuyer` int(11) unsigned DEFAULT NULL,
  `exptime` datetime NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `conditiondescript` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`dealid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `deal` */

insert  into `deal`(`dealid`,`categoryid`,`dealname`,`olprice`,`price`,`saving`,`currentbuyer`,`maxbuyer`,`exptime`,`status`,`conditiondescript`,`img`,`description`) values (1,1,'AL FRESCO',110,55,55,24,40,'2012-12-01 00:00:00',0,'Limit 3 per person, limit 1 per table, 2 per tables of 5 or more, valid only for option purchased, dine-in only, must use promotional value in 1 visit.','pics/6.jpg',''),(2,1,'BUD ICECRE',250,175,75,10,40,'2012-12-01 00:00:00',0,'The coupons will be release at 2012-5-12 ','pics/16.jpg',''),(3,1,'KICHI KICH',120,60,60,50,100,'2012-12-01 00:00:00',0,'Vouchers can be redeemed starting Monday, December 4, through December 19, 2012.  Reservations are required. This deal can be used 7 days a week. Please tip on the full value of the experience. See below for full terms and conditions. ','pics/8.jpg',''),(4,1,'Sushi Bar',300,240,60,10,50,'2012-10-12 00:00:00',0,'This voucher will be included free desert.','pics/logo.png',''),(5,2,'LEE JEANS',230,161,69,40,50,'2012-10-12 00:00:00',0,'This coupon only is valuable in the jean product not in shirt and t-shirt','pics/lee.jpg',''),(6,2,'CK T-Shirt',100,60,40,80,100,'2012-12-01 00:00:00',0,'That will be free for shipping inside Ho Chi Minh City.','pics/cklogo.jpg',''),(7,2,'Gstar-Raw ',250,200,50,10,20,'2012-10-12 00:00:00',0,'Features: This jacket will be your good choice with 20% off for a good quality and famous brand.','pics/gs.jpg',''),(8,2,'LEVI’S SHI',150,75,75,40,50,'2012-12-01 00:00:00',0,'Also, when you come to our store with voucher, you can become more lucky with unexpected present for Christmas Eve.','pics/lev.jpg',''),(9,3,'MANGO',400,160,127,49,50,'2012-11-12 00:00:00',0,'Features: All products in store include dress, jeans, shirts, T-shirt','pics/11.jpg',''),(10,3,'Charles & Keith',600,480,120,4,10,'2012-05-12 00:00:00',0,'This set include one purple leather purse and one shoes.','pics/c&k.jpg',''),(11,3,'Lime Orang',200,120,80,80,100,'2012-12-01 00:00:00',0,'With the voucher, you will have a lot of choice for Korean style T-shirt .','pics/lio.png','dsad'),(12,3,'PETER ALEX',200,100,50,30,50,'2013-01-31 00:00:00',1,'The coupon include a shirt and a pant.','pics/deal_50d803e5325e76.85543849.jpg','Description');

/*Table structure for table `invoice` */

DROP TABLE IF EXISTS `invoice`;

CREATE TABLE `invoice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customername` varchar(255) DEFAULT NULL,
  `totalinvoice` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `invoice` */

/*Table structure for table `purchase` */

DROP TABLE IF EXISTS `purchase`;

CREATE TABLE `purchase` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `dealid` int(11) NOT NULL,
  `dealname` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `totalcharge` int(11) NOT NULL,
  `creholder` varchar(11) NOT NULL,
  `cardnumber` int(11) NOT NULL,
  `expiredate` date NOT NULL,
  `securedcode` int(11) NOT NULL,
  `gift` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `purchase` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`userid`,`username`,`email`,`password`) values (1,'admin','admin@gmail.com','5fe7d8e5e16f0c416754aea20a6a2466'),(2,'user1','user1@gmail.com','24c9e15e52afc47c225b757e7bee1f9d');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
