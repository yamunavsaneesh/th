/*
SQLyog Community v12.09 (32 bit)
MySQL - 5.1.41 : Database - treasurehunt
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`treasurehunt` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `treasurehunt`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_id` int(11) NOT NULL DEFAULT '0',
  `hunt_id` int(11) DEFAULT '0',
  `huntkey` char(25) COLLATE latin1_general_ci DEFAULT '0',
  `name` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `username` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `admin` */

insert  into `admin`(`id`,`roles_id`,`hunt_id`,`huntkey`,`name`,`email`,`username`,`password`,`status`) values (1,1,0,'0','Super Admin','varun@webchannel.ae','admin','0192023a7bbd73250516f069df18b500','Y'),(2,2,1,'TH1','Rakesh Kavil','rakesh@webchannel.ae','rakesh','67a05e3822ce48a6386746388e6c81f5','Y'),(3,2,1,'TH1','Yamuna V','yamuna@webchannel.ae','yamuna','20c7a04933e58436b9367d8a04472812','Y'),(4,2,1,'TH1','Abdul Azim Ansari','azim@webchannel.ae','azim','1cdc05891432c130a2108fb01a472cb8','Y');

/*Table structure for table `admin_logins` */

DROP TABLE IF EXISTS `admin_logins`;

CREATE TABLE `admin_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `login_date` datetime NOT NULL,
  `login_ip` varchar(300) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `admin_logins` */

insert  into `admin_logins`(`id`,`admin_id`,`login_date`,`login_ip`) values (1,NULL,'2017-03-28 20:08:28','::1'),(2,NULL,'2017-03-29 06:43:42','::1'),(3,NULL,'2017-03-30 18:21:27','::1'),(4,NULL,'2017-03-31 10:07:56','::1'),(5,NULL,'2017-03-31 13:53:39','::1');

/*Table structure for table `admin_menu` */

DROP TABLE IF EXISTS `admin_menu`;

CREATE TABLE `admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `link` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `admin_menu` */

insert  into `admin_menu`(`id`,`class`,`name`,`link`,`parent_id`,`status`,`sort_order`) values (1,'fa-home','Dashboard','admin/home',0,'Y',1),(2,'view_page','View Site','home',1,'N',1),(3,'block_users','Logout','admin/home/logout',1,'N',4),(8,'','Contents','admin/contents',0,'N',3),(9,'','Menus','admin/menus',0,'N',2),(10,'','FAQs','admin/faqs',0,'N',9),(11,'','Contacts','admin/contacts',0,'N',11),(12,'fa-file','Status','admin/status',0,'Y',10),(13,'config','Settings','admin/home/settings',1,'N',2),(14,'page','Menus','admin/menus/lists',9,'Y',0),(15,'add_page','Add Menu','admin/menus/add',9,'Y',1),(16,'page','Menu Items','admin/menus/menuitems',9,'N',2),(17,'add_page','Add Menu Item','admin/menu/addmenuitem',9,'N',3),(18,'page','Contents','admin/contents/lists',8,'Y',1),(19,'add_page','Add Content','admin/contents/add',8,'Y',2),(26,'page','FAQs','admin/faqs/lists',10,'Y',1),(27,'add_page','Add FAQ','admin/faqs/add',10,'Y',2),(28,'category','Categories','admin/faqs/categories',10,'Y',3),(29,'category','Add Category','admin/faqs/addcategory',10,'Y',4),(30,'page','Contacts','admin/contacts/lists',11,'Y',1),(31,'add_page','Add Contact','admin/contacts/add',11,'Y',2),(32,'category','Categories','admin/contacts/categories',11,'Y',3),(33,'category','Add Category','admin/contacts/addcategory',11,'Y',4),(34,'report','Invoice','admin/careers/invoices',12,'N',1),(35,'users','Applications','admin/careers/applications',12,'N',3),(36,'','Languages','admin/languages',0,'N',12),(37,'page','Languages','admin/languages/lists',36,'Y',1),(38,'add_page','Add Language','admin/languages/add',36,'Y',2),(39,'fa-user','Admins','admin/admins',0,'Y',13),(40,'users','All Admins','admin/admins/lists',39,'Y',3),(41,'add_user','New Admin','admin/admins/add',39,'Y',4),(42,'config','Change Password','admin/home/changepwd',1,'N',3),(43,'fa-user','Users','admin/users',0,'Y',3),(44,'page','All Users','admin/users/lists',43,'Y',1),(45,'add_page','New User','admin/users/add',43,'Y',2),(46,'fa-users','Groups','admin/groups',0,'Y',4),(47,'page','List Groups','admin/groups/lists',46,'Y',1),(48,'add_page','Add Groups','admin/groups/add',46,'Y',2),(49,'page','Branches','admin/business/branches',46,'N',3),(50,'add_page','Add Branches','admin/business/addbranches',46,'N',4),(51,'report','Add Job','admin/careers/add',12,'N',2),(56,'category','Categories','admin/contents/categories',8,'Y',3),(57,'category','Add Category','admin/contents/addcategory',8,'Y',4),(58,'config','Localization','admin/home/localization',1,'N',2),(59,'fa-tag','Questions','admin/qas',0,'Y',4),(60,'page','List Question','admin/qas/lists',59,'Y',1),(61,'add_page','Add Question','admin/qas/add',59,'Y',2),(88,'page','Permission','admin/admins/permission',39,'N',2),(63,'category','Callback Request','admin/enquires/lists',62,'Y',1),(5,'fa-tag','Hunts','admin/hunts',0,'Y',2),(65,'page','All Hunts','admin/hunts/lists',5,'Y',1),(66,'add_page','New Hunt','admin/hunts/add',5,'Y',2),(67,'page','Banners','admin/banners/lists',69,'Y',11),(68,'add_page','Add Banner','admin/banners/add',69,'Y',12),(69,'','Banners','admin/banners',0,'N',10),(87,'users','Roles','admin/admins/roles',39,'N',1),(73,'','Page Metas','admin/pages',0,'N',10),(74,'page','Page Metas','admin/pages/lists',73,'Y',1),(75,'add_page','Add Page Meta','admin/pages/add',73,'Y',2),(79,'category','Categories','admin/downloads/categories',59,'N',3),(80,'category','Sort Question','admin/qas/sort',59,'Y',4);

/*Table structure for table `answers` */

DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hunt_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer` text,
  `start_time` timestamp NULL DEFAULT NULL,
  `submision_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `taken_time` timestamp NULL DEFAULT NULL,
  `penatly_time` timestamp NULL DEFAULT NULL,
  `is_penalty` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `answers` */

/*Table structure for table `contact_category` */

DROP TABLE IF EXISTS `contact_category`;

CREATE TABLE `contact_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `contact_category` */

/*Table structure for table `contact_category_desc` */

DROP TABLE IF EXISTS `contact_category_desc`;

CREATE TABLE `contact_category_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_category_id` int(11) NOT NULL,
  `name` varchar(300) CHARACTER SET utf8 NOT NULL,
  `language` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`desc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `contact_category_desc` */

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `latitude` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `longitude` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `contacts` */

/*Table structure for table `contacts_desc` */

DROP TABLE IF EXISTS `contacts_desc`;

CREATE TABLE `contacts_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `contacts_id` int(11) NOT NULL,
  `address` text CHARACTER SET utf8 NOT NULL,
  `language` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`desc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `contacts_desc` */

/*Table structure for table `content_category` */

DROP TABLE IF EXISTS `content_category`;

CREATE TABLE `content_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) CHARACTER SET utf8 NOT NULL,
  `short_desc` text COLLATE latin1_general_ci NOT NULL,
  `keywords` text COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `slug` char(200) COLLATE latin1_general_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` enum('Y') COLLATE latin1_general_ci DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `content_category` */

/*Table structure for table `content_category_desc` */

DROP TABLE IF EXISTS `content_category_desc`;

CREATE TABLE `content_category_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_category_id` int(11) NOT NULL,
  `name` varchar(300) CHARACTER SET utf8 NOT NULL,
  `short_desc` text COLLATE latin1_general_ci NOT NULL,
  `keywords` text COLLATE latin1_general_ci NOT NULL,
  `language` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`desc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `content_category_desc` */

/*Table structure for table `contents` */

DROP TABLE IF EXISTS `contents`;

CREATE TABLE `contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `slug` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `short_desc` text COLLATE latin1_general_ci,
  `keywords` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `description` text COLLATE latin1_general_ci,
  `sort_order` int(11) DEFAULT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `contents` */

/*Table structure for table `contents_desc` */

DROP TABLE IF EXISTS `contents_desc`;

CREATE TABLE `contents_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `contents_id` int(11) NOT NULL,
  `title` varchar(300) CHARACTER SET utf8 NOT NULL,
  `short_desc` text CHARACTER SET utf8 NOT NULL,
  `desc` text CHARACTER SET utf8 NOT NULL,
  `keywords` text COLLATE latin1_general_ci NOT NULL,
  `meta_desc` text COLLATE latin1_general_ci NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `banner_text` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `banner_image` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `language` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`desc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `contents_desc` */

/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `isocode` varchar(20) DEFAULT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=858 DEFAULT CHARSET=utf8;

/*Data for the table `countries` */

insert  into `countries`(`id`,`name`,`isocode`,`status`) values (1,'Afghanistan','AF','Y'),(2,'Albania','AL','Y'),(3,'Algeria','DZ','Y'),(4,'Andorra','AD','Y'),(5,'Angola','AO','Y'),(6,'Anguilla','AI','Y'),(7,'Antarctica','AQ','Y'),(8,'Antigua and Barbuda','AG','Y'),(9,'Argentina','AR','Y'),(10,'Armenia','AM','Y'),(11,'Aruba','AW','Y'),(12,'Australia','AU','Y'),(13,'Austria','AT','Y'),(14,'Azerbaidjan','AZ','Y'),(15,'Bahamas','BS','Y'),(16,'Bahrain','BH','Y'),(17,'Bangladesh','BD','Y'),(18,'Barbados','BB','Y'),(19,'Belarus','BY','Y'),(20,'Belgium','BE','Y'),(21,'Belize','BZ','Y'),(22,'Benin','BJ','Y'),(23,'Bermuda','BM','Y'),(24,'Bhutan','BT','Y'),(25,'Bolivia','BO','Y'),(26,'Bosnia-Herzegovina','BA','Y'),(27,'Botswana','BW','Y'),(28,'Bouvet Island','BV','Y'),(29,'Brazil','BR','Y'),(30,'Brunei Darussalam','BN','Y'),(31,'Bulgaria','BG','Y'),(32,'Burkina Faso','BF','Y'),(33,'Burundi','BI','Y'),(34,'Cambodia','KH','Y'),(35,'Cameroon','CM','Y'),(36,'Cape Verde','CV','Y'),(37,'Cayman Islands','KY','Y'),(38,'Central African Republic','CF','Y'),(39,'Chad','TD','Y'),(40,'Chile','CL','Y'),(41,'China','CN','Y'),(42,'Christmas Island','CX','Y'),(43,'Cocos (Keeling) Islands','CC','Y'),(44,'Colombia','CO','Y'),(45,'Commercial','COM','Y'),(46,'Comoros','KM','Y'),(47,'Congo','CG','Y'),(48,'Cook Islands','CK','Y'),(49,'Costa Rica','CR','Y'),(50,'Croatia','HR','Y'),(51,'Cuba','CU','Y'),(52,'Cyprus','CY','Y'),(53,'Czech Republic','CZ','Y'),(54,'Denmark','DK','Y'),(55,'Djibouti','DJ','Y'),(56,'Dominica','DM','Y'),(57,'East Timor','TP','Y'),(58,'Ecuador','EC','Y'),(59,'Egypt','EG','Y'),(60,'El Salvador','SV','Y'),(61,'Equatorial Guinea','GQ','Y'),(62,'Eritrea','ER','Y'),(63,'Estonia','EE','Y'),(64,'Ethiopia','ET','Y'),(65,'Falkland Islands','FK','Y'),(66,'Faroe Islands','FO','Y'),(67,'Fiji','FJ','Y'),(68,'Finland','FI','Y'),(69,'France','FR','Y'),(70,'Gabon','GA','Y'),(71,'Gambia','GM','Y'),(72,'Georgia','GE','Y'),(73,'Germany','DE','Y'),(74,'Ghana','GH','Y'),(75,'Gibraltar','GI','Y'),(76,'Great Britain','GB','Y'),(77,'Greece','GR','Y'),(78,'Greenland','GL','Y'),(79,'Grenada','GD','Y'),(80,'Guatemala','GT','Y'),(81,'Guinea','GN','Y'),(82,'Guinea Bissau','GW','Y'),(83,'Guyana','GY','Y'),(84,'Haiti','HT','Y'),(85,'Honduras','HN','Y'),(86,'Hong Kong','HK','Y'),(87,'Hungary','HU','Y'),(88,'Iceland','IS','Y'),(89,'India','IN','Y'),(90,'Indonesia','ID','Y'),(91,'International','INT','Y'),(92,'Iran','IR','Y'),(93,'Iraq','IQ','Y'),(94,'Ireland','IE','Y'),(95,'Italy','IT','Y'),(96,'Ivory Coast','CI','Y'),(97,'Jamaica','JM','Y'),(98,'Japan','JP','Y'),(99,'Jordan','JO','Y'),(100,'Kazakhstan','KZ','Y'),(101,'Kenya','KE','Y'),(102,'Kiribati','KI','Y'),(103,'Kuwait','KW','Y'),(104,'Kyrgyzstan','KG','Y'),(105,'Laos','LA','Y'),(106,'Latvia','LV','Y'),(107,'Lebanon','LB','Y'),(108,'Lesotho','LS','Y'),(109,'Liberia','LR','Y'),(110,'Libya','LY','Y'),(111,'Liechtenstein','LI','Y'),(112,'Lithuania','LT','Y'),(113,'Luxembourg','LU','Y'),(114,'Macau','MO','Y'),(115,'Macedonia','MK','Y'),(116,'Madagascar','MG','Y'),(117,'Malawi','MW','Y'),(118,'Malaysia','MY','Y'),(119,'Maldives','MV','Y'),(120,'Malii','ML','Y'),(121,'Malta','MT','Y'),(122,'Marshall Islands','MH','Y'),(123,'Mauritania','MR','Y'),(124,'Mauritius','MU','Y'),(125,'Mayotte','YT','Y'),(126,'Mexico','MX','Y'),(127,'Micronesia','FM','Y'),(128,'Moldavia','MD','Y'),(129,'Monaco','MC','Y'),(130,'Mongolia','MN','Y'),(131,'Montserrat','MS','Y'),(132,'Morocco','MA','Y'),(133,'Mozambique','MZ','Y'),(134,'Myanmar','MM','Y'),(135,'Namibia','NA','Y'),(136,'Nauru','NR','Y'),(137,'Nepal','NP','Y'),(138,'Netherlands','NL','Y'),(139,'New Zealand','NZ','Y'),(140,'Nicaragua','NI','Y'),(141,'Niger','NE','Y'),(142,'Nigeria','NG','Y'),(143,'Niue','NU','Y'),(144,'Norfolk Island','NF','Y'),(145,'North Korea','KP','Y'),(146,'Norway','NO','Y'),(147,'Oman','OM','Y'),(148,'Pakistan','PK','Y'),(149,'Palau','PW','Y'),(150,'Panama','PA','Y'),(151,'Papua New Guinea','PG','Y'),(152,'Paraguay','PY','Y'),(153,'Peru','PE','Y'),(154,'Philippines','PH','Y'),(155,'Pitcairn Island','PN','Y'),(156,'Poland','PL','Y'),(157,'Portugal','PT','Y'),(158,'Puerto Rico','PR','Y'),(159,'Qatar','QA','Y'),(160,'Romania','RO','Y'),(161,'Russian Federation','RU','Y'),(162,'Rwanda','RW','Y'),(163,'Samoa','WS','Y'),(164,'San Marino','SM','Y'),(165,'Saudi Arabia','SA','Y'),(166,'Senegal','SN','Y'),(167,'Seychelles','SC','Y'),(168,'Sierra Leone','SL','Y'),(169,'Singapore','SG','Y'),(170,'Slovak Republic','SK','Y'),(171,'Slovenia','SI','Y'),(172,'Solomon Islands','SB','Y'),(173,'Somalia','SO','Y'),(174,'South Africa','ZA','Y'),(175,'South Korea','KR','Y'),(176,'Spain','ES','Y'),(177,'Sri Lanka','LK','Y'),(178,'Sudan','SD','Y'),(179,'Suriname','SR','Y'),(180,'Swaziland','SZ','Y'),(181,'Sweden','SE','Y'),(182,'Switzerland','CH','Y'),(183,'Syria','SY','Y'),(184,'Tadjikistan','TJ','Y'),(185,'Taiwan','TW','Y'),(186,'Tanzania','TZ','Y'),(187,'Thailand','TH','Y'),(188,'Togo','TG','Y'),(189,'Tokelau','TK','Y'),(190,'Tonga','TO','Y'),(191,'Trinidad and Tobago','TT','Y'),(192,'Tunisia','TN','Y'),(193,'Turkey','TR','Y'),(194,'Turkmenistan','TM','Y'),(195,'Tuvalu','TV','Y'),(196,'Uganda','UG','Y'),(197,'Ukraine','UA','Y'),(198,'UAE','AE','Y'),(199,'United Kingdom','UK','Y'),(200,'United States','US','Y'),(201,'Uruguay','UY','Y'),(202,'Uzbekistan','UZ','Y'),(203,'Vanuatu','VU','Y'),(204,'Vatican City State','VA','Y'),(205,'Venezuela','VE','Y'),(206,'Vietnam','VN','Y'),(207,'Palestine','PAL','Y'),(208,'Western Sahara','EH','Y'),(209,'Yemen','YE','Y'),(210,'Yugoslavia','YU','Y'),(211,'Zaire','ZR','Y'),(212,'Zambia','ZM','Y'),(213,'Zimbabwe','ZW','Y'),(215,'Canada',NULL,'Y');

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hunt_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_desc` text,
  `status` enum('Y','N') DEFAULT 'Y',
  `added_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `groups` */

insert  into `groups`(`id`,`hunt_id`,`name`,`short_desc`,`status`,`added_date`) values (1,1,'Group1',NULL,'Y','2017-03-16 16:49:16'),(2,1,'Group2',NULL,'Y','2017-03-19 12:12:41'),(3,1,'Group3',NULL,'Y','2017-03-19 12:12:48'),(4,1,'Group4',NULL,'N','2017-03-19 18:25:00'),(5,1,'Group5',NULL,'N','2017-03-19 18:25:07'),(6,1,'Group6',NULL,'N','2017-03-20 10:51:41'),(7,1,'Group7',NULL,'N','2017-03-20 10:52:44'),(8,1,'Group 8','','N','2017-03-20 14:55:21'),(9,1,'Group 10','','N','2017-03-20 14:55:31');

/*Table structure for table `huntlog` */

DROP TABLE IF EXISTS `huntlog`;

CREATE TABLE `huntlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `huntlog` */

insert  into `huntlog`(`id`,`user_id`,`start_time`) values (1,1,'2017-03-31 19:27:42');

/*Table structure for table `hunts` */

DROP TABLE IF EXISTS `hunts`;

CREATE TABLE `hunts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `huntkey` char(100) COLLATE latin1_general_ci NOT NULL,
  `logo` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `username` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `hunts` */

insert  into `hunts`(`id`,`name`,`huntkey`,`logo`,`email`,`username`,`password`,`status`) values (1,'Treasure Hunt 2017','TH1','avatar1.png','yamuna@webchannel.ae','yamuna@webchannel.ae','20c7a04933e58436b9367d8a04472812','Y'),(2,'Treasure Hunt 2018','TH2','','saifu@webchannel.ae','saifu@webchannel.ae','94a2e0f0e6520c5bcb9895d95e182340','Y');

/*Table structure for table `languages` */

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `class` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `code` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `languages` */

insert  into `languages`(`id`,`name`,`class`,`code`,`status`) values (1,'English','','en','Y');

/*Table structure for table `localization` */

DROP TABLE IF EXISTS `localization`;

CREATE TABLE `localization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_key` text CHARACTER SET utf8 NOT NULL,
  `lang_value` text CHARACTER SET utf8 NOT NULL,
  `language` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `localization` */

/*Table structure for table `locations` */

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `latitude` char(25) DEFAULT NULL,
  `longitude` char(25) DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `locations` */

/*Table structure for table `locations_desc` */

DROP TABLE IF EXISTS `locations_desc`;

CREATE TABLE `locations_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `locations_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `gps_address` varchar(255) DEFAULT NULL,
  `langiage` char(10) DEFAULT 'en',
  PRIMARY KEY (`desc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `locations_desc` */

/*Table structure for table `menuitems` */

DROP TABLE IF EXISTS `menuitems`;

CREATE TABLE `menuitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `link_type` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `link_object` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `show_subitems` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `target_type` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `menuitems` */

/*Table structure for table `menuitems_desc` */

DROP TABLE IF EXISTS `menuitems_desc`;

CREATE TABLE `menuitems_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `menuitems_id` int(11) NOT NULL,
  `class` varchar(300) CHARACTER SET utf8 NOT NULL,
  `name` varchar(300) CHARACTER SET utf8 NOT NULL,
  `link` varchar(500) CHARACTER SET utf8 NOT NULL,
  `attachment` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `language` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`desc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `menuitems_desc` */

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `class` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `code` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `menus` */

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `widgets` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `pages` */

/*Table structure for table `pages_desc` */

DROP TABLE IF EXISTS `pages_desc`;

CREATE TABLE `pages_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pages_id` int(11) NOT NULL,
  `title` varchar(300) CHARACTER SET utf8 NOT NULL,
  `short_desc` text CHARACTER SET utf8 NOT NULL,
  `desc` text CHARACTER SET utf8 NOT NULL,
  `keywords` text COLLATE latin1_general_ci NOT NULL,
  `banner_text` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `banner_image` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `language` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`desc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `pages_desc` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permissions_id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`permissions_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `permissions` */

insert  into `permissions`(`permissions_id`,`page`,`url`) values (1,'Dashboard','admin/home/settings'),(2,'List Hunt','admin/hunts/lists'),(3,'Add Hunt','admin/hunts/add'),(4,'Edit Hunt','admin/hunts/edit'),(5,'Delete Hunt','admin/hunts/delete'),(6,'List User','admin/users/lists'),(7,'Add User','admin/users/add'),(8,'Edit User','admin/users/edit'),(9,'Delete User','admin/users/delete'),(10,'List Groups','admin/groups/lists'),(11,'Add Groups','admin/groups/add'),(12,'Edit Groups','admin/groups/edit'),(13,'Delete Groups','admin/groups/delete'),(14,'List Questions','admin/qas/lists'),(15,'Add Questions','admin/qas/add'),(16,'Edit Questions','admin/qas/edit'),(17,'Delete Questions','admin/qas/delete'),(18,'Sort Questions','admin/qas/sort'),(19,'Status','admin/status');

/*Table structure for table `question_orders` */

DROP TABLE IF EXISTS `question_orders`;

CREATE TABLE `question_orders` (
  `group_id` int(11) NOT NULL,
  `hunt_id` int(11) DEFAULT NULL,
  `question_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `duration` time DEFAULT NULL,
  `penalty` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `question_orders` */

insert  into `question_orders`(`group_id`,`hunt_id`,`question_id`,`sort_order`,`duration`,`penalty`) values (1,1,1,1,'00:50:20','00:25:00'),(1,1,2,2,'00:00:10','00:10:49'),(1,1,3,3,'00:00:30','00:05:40'),(1,1,4,4,'00:00:40','00:05:34'),(1,1,5,5,'00:00:20','00:05:24'),(2,1,1,3,'00:00:00','00:00:00'),(2,1,2,4,'00:00:00','00:00:00'),(2,1,3,5,'00:00:00','00:00:00'),(2,1,4,1,'00:00:00','00:00:00'),(2,1,5,2,'00:00:00','00:00:00'),(3,1,1,0,'00:00:00','00:00:00'),(3,1,2,0,'00:00:00','00:00:00'),(3,1,3,0,'00:00:00','00:00:00'),(3,1,4,0,'00:00:00','00:00:00'),(3,1,5,0,'00:00:00','00:00:00'),(4,1,1,0,NULL,NULL),(4,1,2,0,NULL,NULL),(4,1,3,0,NULL,NULL),(4,1,4,0,NULL,NULL),(4,1,5,0,NULL,NULL),(5,1,1,0,NULL,NULL),(5,1,2,0,NULL,NULL),(5,1,3,0,NULL,NULL),(5,1,4,0,NULL,NULL),(5,1,5,0,NULL,NULL),(6,1,1,0,NULL,NULL),(6,1,2,0,NULL,NULL),(6,1,3,0,NULL,NULL),(6,1,4,0,NULL,NULL),(6,1,5,0,NULL,NULL),(7,1,1,0,NULL,NULL),(7,1,2,0,NULL,NULL),(7,1,3,0,NULL,NULL),(7,1,4,0,NULL,NULL),(7,1,5,0,NULL,NULL),(8,1,1,0,NULL,NULL),(8,1,2,0,NULL,NULL),(8,1,3,0,NULL,NULL),(8,1,4,0,NULL,NULL),(8,1,5,0,NULL,NULL),(9,1,1,0,NULL,NULL),(9,1,2,0,NULL,NULL),(9,1,3,0,NULL,NULL),(9,1,4,0,NULL,NULL),(9,1,5,0,NULL,NULL),(1,NULL,8,6,'00:05:00','00:05:18'),(1,NULL,9,7,'00:05:00','00:05:08'),(3,NULL,8,0,'00:00:00','00:00:00'),(3,NULL,9,0,'00:00:00','00:00:00'),(2,NULL,8,0,'00:00:00','00:00:00'),(2,NULL,9,0,'00:00:00','00:00:00');

/*Table structure for table `questions` */

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hunt_id` int(11) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `label` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `time_duration` time DEFAULT NULL,
  `penalty_duration` time DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y',
  `added_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `answer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `questions` */

insert  into `questions`(`id`,`hunt_id`,`question`,`label`,`location`,`time_duration`,`penalty_duration`,`status`,`added_date`,`answer`) values (1,1,'Find Tallest Tower',198,'Burj Khalifa','00:00:00','00:00:00','Y',NULL,'0000'),(2,1,'Meet in Lulu',NULL,'lulu','00:00:00','00:00:00','Y','2017-03-19 10:36:16','0000'),(3,1,'Where is Burj Khalifa? ',NULL,'Burj Khalifa','00:00:00','00:00:00','Y','2017-03-19 18:05:13','0000'),(4,1,'Go to MOE',NULL,'Burj Khalifa','00:00:00','00:00:00','Y','2017-03-19 18:08:38','0000'),(5,1,'Where is Burj Al Arab?',NULL,'Burj Khalifa','00:00:00','00:00:00','Y','2017-03-20 10:53:53','0000'),(8,1,'next',NULL,'next',NULL,NULL,'Y','2017-03-31 10:18:12','0000'),(9,1,'last',NULL,'last',NULL,NULL,'Y','2017-03-31 10:18:15','0000');

/*Table structure for table `role_access` */

DROP TABLE IF EXISTS `role_access`;

CREATE TABLE `role_access` (
  `roles_id` int(11) NOT NULL DEFAULT '0',
  `permissions_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `role_access` */

insert  into `role_access`(`roles_id`,`permissions_id`) values (2,19),(2,18),(2,17),(2,16),(2,15),(2,14),(2,13),(2,12),(2,11),(2,10),(2,9),(2,8),(2,7),(2,6),(2,1);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `roles_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`roles_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `roles` */

insert  into `roles`(`roles_id`,`role`,`status`) values (1,'Super Admin','Y'),(2,'Admin','Y'),(3,'Editor','Y');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `settingkey` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `settingtype` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `inputclass` char(200) COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `hunt_id` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `settings` */

insert  into `settings`(`id`,`title`,`settingkey`,`settingtype`,`inputclass`,`status`,`hunt_id`) values (1,'Admin email address','ADMIN_EMAIL','text',NULL,'Y',1),(2,'From email address','FROM_EMAIL','text',NULL,'Y',1),(3,'Facebook Link. ','FACEBOOK_LINK','text',NULL,'Y',1),(4,'Twitter Link. ','TWITTER_LINK','text',NULL,'Y',1),(5,'YouTube Link. ','YOUTUBE_LINK','text',NULL,'Y',1),(6,'LinkedIn Link.','LINKEDIN_LINK','text',NULL,'Y',1),(7,'Google Plus Link.','GOOGLEPLUS_LINK','text',NULL,'Y',1),(8,'Site Name','SITE_NAME','text',NULL,'Y',1),(9,'Default Meta Title','DEFAULT_META_TITLE','text',NULL,'Y',1),(10,'Default Meta Description','DEFAULT_META_DESCRIPTION','textarea',NULL,'Y',1),(11,'Default Meta Keywords','DEFAULT_META_KEYWORDS','textarea',NULL,'Y',1),(12,'Hunt Total Time','HUNT_TIME','text','timepicker','Y',1),(15,'Start Date','START_DATE','text','datepicker','Y',1),(16,'Contact Number','PHONE','text',NULL,'Y',1),(17,'Contact Number','PHONE','text',NULL,'Y',1),(18,'Hunt Begin Code','HUNT_CODE','text',NULL,'Y',1);

/*Table structure for table `settings_desc` */

DROP TABLE IF EXISTS `settings_desc`;

CREATE TABLE `settings_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `settings_id` int(11) NOT NULL,
  `settingvalue` text CHARACTER SET utf8 NOT NULL,
  `language` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`desc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `settings_desc` */

insert  into `settings_desc`(`desc_id`,`settings_id`,`settingvalue`,`language`) values (1,1,'yamuna@webchannel.ae','en'),(5,2,'yamuna@webchannel.ae','en'),(24,7,'https://www.google.com','en'),(9,3,'https://www.facebook.com','en'),(13,4,'https://twitter.com','en'),(17,5,'https://www.youtube.com','en'),(21,6,'https://linkedin.com','en'),(27,8,'Treasure Hunt','en'),(30,9,'Treasure Hunt','en'),(33,10,'Treasure Hunt','en'),(36,11,'Treasure Hunt','en'),(39,12,'05:05:05','en'),(85,17,'123','en'),(82,15,'04/04/2017 04:04:30','en'),(86,18,'2017','en');

/*Table structure for table `tasklog` */

DROP TABLE IF EXISTS `tasklog`;

CREATE TABLE `tasklog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NULL DEFAULT NULL,
  `penalty_start_time` timestamp NULL DEFAULT NULL,
  `penalty_end_time` timestamp NULL DEFAULT NULL,
  `answer_submit_time` timestamp NULL DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tasklog` */

/*Table structure for table `user_logins` */

DROP TABLE IF EXISTS `user_logins`;

CREATE TABLE `user_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `login_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `login_ip` varchar(300) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `user_logins` */

insert  into `user_logins`(`id`,`user_id`,`login_date`,`login_ip`) values (1,1,'2017-03-28 23:27:52','::1'),(2,1,'2017-03-28 23:31:10','::1'),(3,1,'2017-03-29 06:43:14','::1'),(4,1,'2017-03-30 18:33:01','::1'),(5,1,'2017-03-31 09:51:38','::1'),(6,1,'2017-03-31 11:18:18','::1'),(7,1,'2017-03-31 13:23:51','::1'),(8,1,'2017-03-31 19:27:37','::1');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hunt_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `shirtsize` char(255) DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y',
  `delete_status` enum('Y','N') DEFAULT 'N',
  `last_login` datetime DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_caption` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`hunt_id`,`group_id`,`firstname`,`lastname`,`email`,`mobile`,`gender`,`username`,`password`,`shirtsize`,`status`,`delete_status`,`last_login`,`added_date`,`profile_picture`,`is_caption`) values (1,1,1,'yamuna v','saneesh','yamuna@webchannel.ae','05045545451','female','yamuna@webchannel.ae','20c7a04933e58436b9367d8a04472812','L','Y','N','2017-03-31 19:27:37','2017-03-16 15:45:46',NULL,'N'),(2,1,3,'ganga','pranesh','ganaga@gmail.com','0501725431','female','ganaga@gmail.com','71934b60ae13ac658efc35ed4055a934','M','Y','N',NULL,'2017-03-16 15:48:46',NULL,'N'),(3,1,1,'Sumi','S','sumi@webchannel.ae','05045545451','female','sumi','41008f06b76981093c7aa369d83c08ea','M','Y','N',NULL,'2017-03-20 10:53:34',NULL,'N');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
