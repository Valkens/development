/*
SQLyog Enterprise - MySQL GUI v8.12 
MySQL - 5.5.27 : Database - phong
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `deals` */

insert  into `deals`(`id`,`name`,`description`,`original_price`,`group_buy_price`,`saving_percent`,`buyers`,`maximum_buyers_allowed`,`expired_time`,`status`,`conditions`,`background_image`,`summary_image`,`image1`,`image2`,`image3`,`image4`,`id_category`) values (2,'Máy tính bảng MOMO8','Thỏa Thích Lướt Web, Chơi Game Cùng Máy Tính Bảng MOMO8','50','25',50,99,99,'2012-11-29 00:00:00',1,'Máy tính bảng MOMO8 8 inch sử dụng hệ điều hành Androi 4.0.3 với tốc độ xử lý lên đến 1.2Ghz. Sản phẩm có thiết kế siêu mỏng, màn hình trong suốt, cùng màu trắng trang nhã, hiện đại. Sử dụng màn hình LED cảm ứng rộng 8 inch với độ phân giải tối đa lên đến 1024 x 768, MOMO8 cho hình ảnh sắc nét, kể cả khi nhìn trực diện lẫn khi nằm nghiêng để bạn thỏa sức chơi game, đọc báo, xem phim hay chat cùng bè bạn. Chỉ với trọng lượng 1.2kg, sản phẩm vừa tầm tay người sử dụng để bạn có thể mang đi làm hay đến bất cứ nơi đâu như du lịch, công tác…','public/images/upload/deals/2/bg_50b63f736e1cd5.51270566.jpg','public/images/upload/deals/2/sm_50b63f7374d754.48834238.jpg','public/images/upload/deals/2/im1_50b63f7375cd17.06230849.jpg','public/images/upload/deals/2/im2_50b63f7376de95.47024033.jpg','public/images/upload/deals/2/im3_50b63f737d8b55.83936348.jpg','public/images/upload/deals/2/im4_50b63f737e7f78.85316285.jpg',2),(3,'Set Menu Nhà Hàng Song Nam','Thưởng Thức 1 Trong 3 Set Menu Nhà Hàng Song Nam Gồm Những Món Ăn Thơm Ngon Được Chế Tác Từ Tinh Túy Ẩm ... ','70','60',10,10,1000,'2012-11-30 00:00:00',1,'Thưởng Thức 1 Trong 3 Set Menu Nhà Hàng Song Nam Gồm Những Món Ăn Thơm Ngon Được Chế Tác Từ Tinh Túy Ẩm ... ','public/images/upload/deals/3/bg_50b640949f1d24.29771899.jpg','public/images/upload/deals/3/sm_50b64094a023c0.28738602.jpg','public/images/upload/deals/3/im1_50b64094a10153.37306716.jpg','public/images/upload/deals/3/im2_50b64094a20e28.53170490.jpg','public/images/upload/deals/3/im3_50b64094a304e0.78769550.jpg','public/images/upload/deals/3/im4_50b64094a3eaf4.87457623.jpg',3);

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
