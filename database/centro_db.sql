/*
SQLyog Community v10.5 Beta1
MySQL - 5.5.27 : Database - centro_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`centro_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `centro_db`;

/*Table structure for table `account_group` */

DROP TABLE IF EXISTS `account_group`;

CREATE TABLE `account_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `is_active` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `account_group` */

insert  into `account_group`(`id`,`name`,`is_active`) values (1,'Current Assets',1),(2,'Indirect Expences',1),(3,'Current Liabilities',1),(4,'Fixed Assets',1),(5,'Direct Incomes',1),(6,'Indirect Incomes',1),(7,'Bank Accounts',1),(8,'Loans & Liabilities',1),(9,'Bank OD',1),(10,'Branch & Divisions',1),(11,'Capital Account',1),(12,'Cash In Hand',1),(13,'Stock In Hand',1),(14,'Sundry Creditors',1),(15,'Sundry Debtors',1),(16,'Suspense Accounts',1),(17,'Sales Accounts',1),(18,'Duties & Taxes',1),(19,'Investments',1),(20,'Purchase Account',1),(21,'Direct Expence',1),(22,'Indirect Expence',1),(23,'Cash Account',1),(24,'Sales Return Accounts',1),(25,'Miscellaneous Account',1);

/*Table structure for table `account_reg` */

DROP TABLE IF EXISTS `account_reg`;

CREATE TABLE `account_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(200) DEFAULT NULL,
  `account_group` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

/*Data for the table `account_reg` */

insert  into `account_reg`(`id`,`account_name`,`account_group`,`created_by`,`created_at`,`updated_by`,`updated_at`,`is_active`) values (1,'cash_book','Cash In Hand',NULL,NULL,NULL,NULL,1),(2,'Bank','Bank Accounts',NULL,NULL,NULL,NULL,1),(3,'Cash','Sales Accounts',NULL,NULL,NULL,NULL,1),(4,'Sale','Sales Accounts',NULL,NULL,NULL,NULL,1),(5,'Opening Balance','Cash In Hand',NULL,NULL,NULL,NULL,1),(6,'Vat Sale','Sales Accounts',NULL,NULL,NULL,NULL,1),(7,'Input tax paid','Duties & Taxes',NULL,NULL,NULL,NULL,1),(8,'Output tax collected','Duties & Taxes',NULL,NULL,NULL,NULL,1);

/*Table structure for table `account_txn` */

DROP TABLE IF EXISTS `account_txn`;

CREATE TABLE `account_txn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(200) DEFAULT NULL,
  `account_group` varchar(100) DEFAULT NULL,
  `txn_id` int(11) DEFAULT '0',
  `amount` double DEFAULT NULL,
  `description` text,
  `txn_date` date DEFAULT NULL,
  `txn_type` varchar(15) DEFAULT NULL,
  `from_or_to` varchar(50) DEFAULT 'cash_book',
  `purchase_id` int(11) DEFAULT '0',
  `sale_id` int(11) DEFAULT '0',
  `sale_return_id` int(11) DEFAULT '0',
  `purchase_return_id` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `account_txn` */

/*Table structure for table `bill_sale` */

DROP TABLE IF EXISTS `bill_sale`;

CREATE TABLE `bill_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) DEFAULT NULL,
  `sale_order_invoice_no` double DEFAULT NULL,
  `invoice_number` double DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sale_date` varchar(20) DEFAULT NULL,
  `sale_type` varchar(20) DEFAULT NULL,
  `dc_no` varchar(100) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sale_total` double DEFAULT NULL,
  `cash_recieved` double DEFAULT NULL,
  `real_customer_id` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `remarks` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bill_sale` */

/*Table structure for table `billed_sale_inventory` */

DROP TABLE IF EXISTS `billed_sale_inventory`;

CREATE TABLE `billed_sale_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `description` varchar(999) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `sale_tax` float DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `billed_sale_inventory` */

/*Table structure for table `brand_reg` */

DROP TABLE IF EXISTS `brand_reg`;

CREATE TABLE `brand_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `brand_reg` */

/*Table structure for table `customer_reg` */

DROP TABLE IF EXISTS `customer_reg`;

CREATE TABLE `customer_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `land_mark` varchar(500) DEFAULT NULL,
  `pin_code` int(6) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `phone_no` varchar(30) DEFAULT NULL,
  `email_id` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `pin_no` varchar(50) DEFAULT NULL,
  `tin_no` varchar(50) DEFAULT NULL,
  `kgst` varchar(50) DEFAULT NULL,
  `cst` varchar(50) DEFAULT NULL,
  `opening_balance` float DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `customer_reg` */

/*Table structure for table `faq` */

DROP TABLE IF EXISTS `faq`;

CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qn` text,
  `ans` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `faq` */

/*Table structure for table `firm_reg` */

DROP TABLE IF EXISTS `firm_reg`;

CREATE TABLE `firm_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_name` varchar(1000) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `pin_code` int(6) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `phone_no` varchar(25) DEFAULT NULL,
  `email_id` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `pin_no` varchar(50) DEFAULT NULL,
  `tin_no` varchar(50) DEFAULT NULL,
  `kgst` varchar(50) DEFAULT NULL,
  `cst` varchar(50) DEFAULT NULL,
  `troll` varchar(50) DEFAULT NULL,
  `icu` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `bank_details` int(2) DEFAULT '0',
  `is_active` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `firm_reg` */

insert  into `firm_reg`(`id`,`firm_name`,`address1`,`address2`,`pin_code`,`district`,`phone_no`,`email_id`,`website`,`pin_no`,`tin_no`,`kgst`,`cst`,`troll`,`icu`,`created_by`,`created_at`,`updated_by`,`updated_at`,`bank_details`,`is_active`) values (1,'Easy Fit Marketing','Pathadipalam, Near Metro Station, Metro Piller No. 354','Metro Piller No. 354',680004,'Ernakulam','8606077555','easyfit.ekm@gmail.com','www.chirippa.in','1234','1234','32AUXPB5510H1ZS','1234','1105499407742','1115061757797',NULL,NULL,1,'2017-07-16 23:19:29',0,1);

/*Table structure for table `group_reg` */

DROP TABLE IF EXISTS `group_reg`;

CREATE TABLE `group_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(75) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `group_reg` */

insert  into `group_reg`(`id`,`group_name`,`created_by`,`created_at`,`updated_by`,`updated_at`,`is_active`) values (1,'Default',1,'2016-07-25 21:26:51',NULL,NULL,1),(2,'Service',1,'2016-08-05 10:30:20',NULL,NULL,1);

/*Table structure for table `interstate_sale` */

DROP TABLE IF EXISTS `interstate_sale`;

CREATE TABLE `interstate_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) DEFAULT NULL,
  `sale_order_invoice_no` double DEFAULT NULL,
  `invoice_number` double DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sale_date` varchar(20) DEFAULT NULL,
  `sale_type` varchar(20) DEFAULT NULL,
  `dc_no` varchar(100) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sale_total` double DEFAULT NULL,
  `cash_recieved` double DEFAULT NULL,
  `real_customer_id` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `remarks` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `interstate_sale` */

/*Table structure for table `interstate_sold_inventory` */

DROP TABLE IF EXISTS `interstate_sold_inventory`;

CREATE TABLE `interstate_sold_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `sale_tax` float DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `interstate_sold_inventory` */

/*Table structure for table `inventory_reg` */

DROP TABLE IF EXISTS `inventory_reg`;

CREATE TABLE `inventory_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `hsn` varchar(50) DEFAULT NULL,
  `item_desc` varchar(150) DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `group` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `mrp` float DEFAULT NULL,
  `wholesale_price` float DEFAULT NULL,
  `retail_price` float DEFAULT NULL,
  `branch_price` float DEFAULT NULL,
  `purchase_price` float DEFAULT NULL,
  `opening_stock` varchar(50) DEFAULT NULL,
  `current_stock` varchar(50) DEFAULT '0',
  `minimum_stock` varchar(50) DEFAULT '1',
  `max_stock` varchar(50) DEFAULT NULL,
  `default_unit` varchar(50) DEFAULT 'Nos',
  `alternative_unit` varchar(50) DEFAULT 'Nos',
  `alternative_unit_number` float DEFAULT '1',
  `damaged_stock` varchar(50) DEFAULT '0',
  `service_stock` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `sgst` float DEFAULT NULL,
  `cgst` float DEFAULT NULL,
  `igst` float DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  `pay_inv` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `inventory_reg` */

/*Table structure for table `purchase` */

DROP TABLE IF EXISTS `purchase`;

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) DEFAULT NULL,
  `reference_number` double DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `invoice_number` varchar(25) DEFAULT NULL,
  `purchase_date` varchar(20) DEFAULT NULL,
  `stock_date` varchar(20) DEFAULT NULL,
  `purchase_type` varchar(15) DEFAULT NULL,
  `purchase_total` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `status` int(2) DEFAULT '3',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchase` */

/*Table structure for table `purchase_return` */

DROP TABLE IF EXISTS `purchase_return`;

CREATE TABLE `purchase_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) DEFAULT NULL,
  `reference_number` varchar(25) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `invoice_number` varchar(25) DEFAULT NULL,
  `purchase_date` varchar(20) DEFAULT NULL,
  `stock_date` varchar(20) DEFAULT NULL,
  `purchase_type` varchar(15) DEFAULT NULL,
  `purchase_total` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchase_return` */

/*Table structure for table `purchased_inventory` */

DROP TABLE IF EXISTS `purchased_inventory`;

CREATE TABLE `purchased_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `purchase_tax` float DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `profit_per` float DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  `purchase_date` date DEFAULT NULL,
  `purchase_type` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchased_inventory` */

/*Table structure for table `purchased_return_inventory` */

DROP TABLE IF EXISTS `purchased_return_inventory`;

CREATE TABLE `purchased_return_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `purchase_tax` float DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `profit_per` float DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchased_return_inventory` */

/*Table structure for table `real_customer_reg` */

DROP TABLE IF EXISTS `real_customer_reg`;

CREATE TABLE `real_customer_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `real_customer_name` varchar(200) DEFAULT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `pin_code` int(6) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email_id` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `pin_no` varchar(50) DEFAULT NULL,
  `tin_no` varchar(50) DEFAULT NULL,
  `kgst` varchar(50) DEFAULT NULL,
  `cst` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `real_customer_reg` */

insert  into `real_customer_reg`(`id`,`real_customer_name`,`address1`,`address2`,`pin_code`,`district`,`phone_no`,`email_id`,`website`,`pin_no`,`tin_no`,`kgst`,`cst`,`created_by`,`created_at`,`updated_by`,`updated_at`,`is_active`) values (1,'Customer','ffff','',0,'Thrissur','9526924330','','','','','','',2,'2016-07-18 22:52:55',NULL,NULL,1);

/*Table structure for table `sale` */

DROP TABLE IF EXISTS `sale`;

CREATE TABLE `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) DEFAULT NULL,
  `sale_order_invoice_no` double DEFAULT NULL,
  `invoice_number` double DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sale_date` varchar(20) DEFAULT NULL,
  `sale_type` varchar(20) DEFAULT NULL,
  `dc_no` varchar(100) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `round_off` float DEFAULT NULL,
  `sale_total` double DEFAULT NULL,
  `cash_recieved` double DEFAULT NULL,
  `real_customer_id` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `remarks` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sale` */

/*Table structure for table `sale_return` */

DROP TABLE IF EXISTS `sale_return`;

CREATE TABLE `sale_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) DEFAULT NULL,
  `sale_order_invoice_no` double DEFAULT NULL,
  `invoice_number` double DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sale_date` varchar(20) DEFAULT NULL,
  `sale_type` varchar(20) DEFAULT NULL,
  `dc_no` varchar(100) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sale_total` double DEFAULT NULL,
  `cash_recieved` double DEFAULT NULL,
  `real_customer_id` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `remarks` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sale_return` */

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `printer` int(2) DEFAULT '1' COMMENT '1 for thermal, 2 for laser',
  `save_bill` int(2) DEFAULT '1' COMMENT '1 for save, 2 for not save',
  `is_active` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `settings` */

insert  into `settings`(`id`,`printer`,`save_bill`,`is_active`) values (1,1,1,1);

/*Table structure for table `sold_inventory` */

DROP TABLE IF EXISTS `sold_inventory`;

CREATE TABLE `sold_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `sale_tax` float DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  `sale_type` int(2) DEFAULT NULL,
  `hsn` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sold_inventory` */

/*Table structure for table `sold_return_inventory` */

DROP TABLE IF EXISTS `sold_return_inventory`;

CREATE TABLE `sold_return_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `sale_tax` float DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sold_return_inventory` */

/*Table structure for table `state_reg` */

DROP TABLE IF EXISTS `state_reg`;

CREATE TABLE `state_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `state_code` varchar(10) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_active` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Data for the table `state_reg` */

insert  into `state_reg`(`id`,`name`,`state_code`,`created_by`,`is_active`) values (1,'Kerala','32',NULL,1),(2,'Jammu & Kashmitr','01',NULL,1),(3,'Himachal Pradesh','02',NULL,1),(4,'Punjab','03',NULL,1),(5,'Chandigarh','04',NULL,1),(6,'Uttarakhand','05',NULL,1),(7,'Haryana','06',NULL,1),(8,'Delhi','07',NULL,1),(9,'Rajastan','08',NULL,1),(10,'Uttar Pradesh','09',NULL,1),(11,'Bihar','10',NULL,1),(12,'Sikkim','11',NULL,1),(13,'Arunachal Pradesh','12',NULL,1),(14,'Nagaland','13',NULL,1),(15,'Manippur','14',NULL,1),(16,'Mizoram','15',NULL,1),(17,'Tripura','16',NULL,1),(18,'Meghalaya','17',NULL,1),(19,'Assam','18',NULL,1),(20,'West Bengal','19',NULL,1),(21,'Jharkhand','20',NULL,1),(22,'Oddisha','21',NULL,1),(23,'Chattisgarh','22',NULL,1),(24,'Madhya Pradesh','23',NULL,1),(25,'Gujarat','24',NULL,1),(26,'Daman & Diu','25',NULL,1),(27,'Dadra & Nagarhaveli','26',NULL,1),(28,'Maharashtra','27',NULL,1),(29,'Andhra Pradesh (Before Division)','28',NULL,1),(30,'Karnataka','29',NULL,1),(31,'Goa','30',NULL,1),(32,'Lakshadweep','31',NULL,1),(33,'Tamil Nadu','33',NULL,1),(34,'Puduchery','34',NULL,1),(35,'Andaman Nikobar Island','35',NULL,1),(36,'Telugana','36',NULL,1),(37,'Andra Pradesh (New)','37',NULL,1);

/*Table structure for table `user_reg` */

DROP TABLE IF EXISTS `user_reg`;

CREATE TABLE `user_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_type` int(2) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `user_reg` */

insert  into `user_reg`(`id`,`firm_id`,`user_name`,`password`,`user_type`,`created_by`,`updated_by`,`created_at`,`updated_at`,`is_active`) values (1,1,'Admin','827ccb0eea8a706c4c34a16891f84e7b',3,NULL,NULL,NULL,NULL,1);

/*Table structure for table `vendor_reg` */

DROP TABLE IF EXISTS `vendor_reg`;

CREATE TABLE `vendor_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(200) DEFAULT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `pin_code` int(6) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email_id` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `pin_no` varchar(50) DEFAULT NULL,
  `tin_no` varchar(50) DEFAULT NULL,
  `kgst` varchar(50) DEFAULT NULL,
  `cst` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `customer_vendor` int(2) DEFAULT '1' COMMENT '1 for customer, 2 for vendor',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

/*Data for the table `vendor_reg` */

insert  into `vendor_reg`(`id`,`vendor_name`,`address1`,`address2`,`pin_code`,`district`,`phone_no`,`email_id`,`website`,`pin_no`,`tin_no`,`kgst`,`cst`,`state`,`customer_vendor`,`created_by`,`created_at`,`updated_by`,`updated_at`,`is_active`) values (1,'Cash',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,1),(2,'NIL',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,1);

/*Table structure for table `whole_sale` */

DROP TABLE IF EXISTS `whole_sale`;

CREATE TABLE `whole_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_id` int(11) DEFAULT NULL,
  `sale_order_invoice_no` double DEFAULT NULL,
  `invoice_number` double DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sale_date` varchar(20) DEFAULT NULL,
  `sale_type` varchar(20) DEFAULT NULL,
  `dc_no` varchar(100) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sale_total` double DEFAULT NULL,
  `cash_recieved` double DEFAULT NULL,
  `real_customer_id` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `remarks` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `whole_sale` */

/*Table structure for table `whole_sold_inventory` */

DROP TABLE IF EXISTS `whole_sold_inventory`;

CREATE TABLE `whole_sold_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `sale_tax` float DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `whole_sold_inventory` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
