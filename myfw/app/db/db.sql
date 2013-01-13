/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.27 : Database - dev_blog
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `category` */

CREATE TABLE `category` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL DEFAULT '',
  `id_parent` tinyint(4) NOT NULL,
  `meta_description` text,
  `order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `post` */

CREATE TABLE `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_category` tinyint(3) unsigned NOT NULL,
  `id_user` tinyint(3) unsigned DEFAULT NULL,
  `created_time` int(11) unsigned NOT NULL,
  `modified_time` int(11) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `meta_description` text,
  `description` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `comment_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `slug` varchar(255) NOT NULL,
  `comment_count` int(11) unsigned NOT NULL,
  `featured_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `thumbnail` text NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

/*Table structure for table `user` */

CREATE TABLE `user` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
