/*
SQLyog Ultimate v11.33 (32 bit)
MySQL - 5.1.73 : Database - ltfhc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ltfhc` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ltfhc`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` enum('admin') NOT NULL DEFAULT 'admin',
  `sub_type` enum('admin','supper_admin','ltfhc_admin') DEFAULT NULL,
  `auth_path` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `data_entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_entry_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `login_id` (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `admin` */

insert  into `admin`(`id`,`login_id`,`password`,`name`,`type`,`sub_type`,`auth_path`,`status`,`data_entry_time`,`data_entry_id`) values (1,'admin','U2FsdGVkX18i0xE5F8seAzVH6ixi3JvG8ANDeLIruGc=','Admin','admin','admin',NULL,1,'2016-04-08 16:35:58',''),(2,'ltfhcadmin','ltfhcdmin123','LTFHC Admin','admin','ltfhc_admin',NULL,1,'2016-05-04 12:01:27','');

/*Table structure for table `config_component` */

DROP TABLE IF EXISTS `config_component`;

CREATE TABLE `config_component` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(110) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `save_value` tinyint(4) NOT NULL DEFAULT '0',
  `options` text,
  `default_value` varchar(30) DEFAULT NULL,
  `attribute` varchar(1000) DEFAULT NULL,
  `sequence` tinyint(4) DEFAULT '0',
  `onclick_target` enum('screen','alert') DEFAULT NULL,
  `onclick_target_value_id` int(11) DEFAULT NULL,
  `layout_id` tinyint(4) DEFAULT '1',
  `screen_id` tinyint(4) DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `data_entry_id` varchar(30) DEFAULT NULL,
  `data_entry_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `config_component` */

/*Table structure for table `config_layout` */

DROP TABLE IF EXISTS `config_layout`;

CREATE TABLE `config_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `type` enum('linear','relative','absolute') DEFAULT 'linear',
  `orientation` enum('vertical','horizontal') DEFAULT 'vertical',
  `attribute` text,
  `sequence` tinyint(4) DEFAULT '0',
  `screen_id` tinyint(4) DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `data_entry_id` varchar(30) DEFAULT NULL,
  `data_entry_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `config_layout` */

/*Table structure for table `config_screen` */

DROP TABLE IF EXISTS `config_screen`;

CREATE TABLE `config_screen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `sequence` tinyint(4) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `data_entry_id` varchar(30) DEFAULT NULL,
  `data_entry_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `config_screen` */

/*Table structure for table `hcw` */

DROP TABLE IF EXISTS `hcw`;

CREATE TABLE `hcw` (
  `hcw_first_name` varchar(50) NOT NULL COMMENT 'HCW last name',
  `hcw_last_name` varchar(50) NOT NULL COMMENT 'HCW last name',
  `hcw_loc` varchar(100) NOT NULL COMMENT 'HCW location',
  `hcw_clinic_id` int(7) NOT NULL COMMENT 'HCW clinci id',
  `hcw_username` varchar(50) NOT NULL COMMENT 'HCW username',
  `hcw_pass` varchar(100) NOT NULL COMMENT 'HCW password',
  `hcw_device_id` varchar(50) NOT NULL COMMENT 'mac address of the device',
  `hcw_last_login` datetime NOT NULL COMMENT 'Timestamp for HCW last login',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'To activate or deactivate the user',
  `data_entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Last modyfied time',
  `data_entry_id` varchar(20) NOT NULL COMMENT 'last login id through which it has been modified',
  PRIMARY KEY (`hcw_username`),
  KEY `hcw_clinic_id` (`hcw_clinic_id`),
  KEY `hcw_device_id` (`hcw_device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';

/*Data for the table `hcw` */

insert  into `hcw`(`hcw_first_name`,`hcw_last_name`,`hcw_loc`,`hcw_clinic_id`,`hcw_username`,`hcw_pass`,`hcw_device_id`,`hcw_last_login`,`status`,`data_entry_time`,`data_entry_id`) values ('yifyguk','yuify','kuyf',0,'c@f.m','asdfghjkl','fac745969540d110','2016-07-30 14:02:48',1,'0000-00-00 00:00:00',''),('fname','lname','Loc',3423,'k1','123','sdf345sd2','2016-07-30 13:59:16',1,'0000-00-00 00:00:00',''),('kamal','talreja','test',100,'kamal@worldhealthpartners.org','kamal123','ebcb0a3b0cedac84','0000-00-00 00:00:00',1,'2016-08-03 18:08:05',''),('Test','','',0,'test','123','','2016-07-18 11:05:30',1,'2016-07-18 11:05:30','');

/*Table structure for table `patient_detail` */

DROP TABLE IF EXISTS `patient_detail`;

CREATE TABLE `patient_detail` (
  `patient_id` varchar(30) NOT NULL,
  `visit` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `component_value` text,
  `data_entry_id` varchar(30) DEFAULT NULL,
  `data_entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`patient_id`,`visit`,`component_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `patient_detail` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
