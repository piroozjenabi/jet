-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: jet
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB-1:10.4.17+maria~bionic

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `jet_alerts`
--

DROP TABLE IF EXISTS `jet_alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `readed` int(1) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `type_id` int(11) NOT NULL,
  `params` text NOT NULL COMMENT 'json',
  `user_id` int(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `user` (`user_id`),
  CONSTRAINT `alert_type` FOREIGN KEY (`type_id`) REFERENCES `jet_alerts_type` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `alert_user` FOREIGN KEY (`user_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='alerts for eemployers';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_alerts`
--

LOCK TABLES `jet_alerts` WRITE;
/*!40000 ALTER TABLE `jet_alerts` DISABLE KEYS */;
INSERT INTO `jet_alerts` VALUES (5,'تست',1,'2020-02-23 13:46:47',5,'{\"id\":\"2\"}',16);
/*!40000 ALTER TABLE `jet_alerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_alerts_type`
--

DROP TABLE IF EXISTS `jet_alerts_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_alerts_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(20) NOT NULL,
  `function` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `des` varchar(255) NOT NULL,
  `order_by` varchar(5) NOT NULL,
  `def_message` varchar(255) NOT NULL,
  `delay` int(10) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `function` (`function`),
  KEY `order_by` (`order_by`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_alerts_type`
--

LOCK TABLES `jet_alerts_type` WRITE;
/*!40000 ALTER TABLE `jet_alerts_type` DISABLE KEYS */;
INSERT INTO `jet_alerts_type` VALUES (1,'#FF99CC','expire_factor','expire_factor','سررسید فاکتور','1','هشدار سر رسید فاکتور',0),(2,'#54EBFF','period_tracking','period_tracking','مشتریان بلفعل','2','هشدار پیگیری مشتری',0),(3,'#C3FF00','alert_new_factor','alert_new_factor','ثبت فاکتور جدید','3','فاکتور جدید ثبت شد ',0),(4,'#D9534F','checku','checku','هشدار چک','4','هشدار تاریخ سررسید چک',48),(5,'#66BB6A','refer','refer','ارجاع جدید','5','فرمی جدید برای شما ارجاع گردید',0),(6,'#FFCDD2','reject','reject','مرجوع جدید','6','ارجاعی شما مرجوع گردید',0),(7,'#FFCDD2','','stack_alert','هشدار اتمام کالا','7','کالای شما در حال اتمام است',0);
/*!40000 ALTER TABLE `jet_alerts_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_auto_auto_refer_user`
--

DROP TABLE IF EXISTS `jet_auto_auto_refer_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_auto_auto_refer_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` int(11) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `params` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_auto_refer_user_tbl_user_eemploy_id_fk` (`user_id`),
  KEY `tbl_auto_refer_user_tbl_auto_forms_id_fk` (`form_id`),
  CONSTRAINT `tbl_auto_refer_user_tbl_auto_forms_id_fk` FOREIGN KEY (`form_id`) REFERENCES `jet_auto_forms` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_auto_refer_user_tbl_user_eemploy_id_fk` FOREIGN KEY (`user_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_auto_auto_refer_user`
--

LOCK TABLES `jet_auto_auto_refer_user` WRITE;
/*!40000 ALTER TABLE `jet_auto_auto_refer_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_auto_auto_refer_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_auto_fields_value`
--

DROP TABLE IF EXISTS `jet_auto_fields_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_auto_fields_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `maker_id` int(40) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `params` text DEFAULT NULL,
  `form_value_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_auto_fields_value_tbl_auto_forms_fiel1ds_id_fk` (`field_id`),
  KEY `tbl_auto_fields_value_tbl_auto_forms_value_id_fk` (`form_value_id`),
  KEY `maker_id` (`maker_id`),
  KEY `date` (`date`),
  CONSTRAINT `tbl_auto_fields_value_tbl_auto_forms_fiel1ds_id_fk` FOREIGN KEY (`field_id`) REFERENCES `jet_auto_forms_fields` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_auto_fields_value_tbl_auto_forms_value_id_fk` FOREIGN KEY (`form_value_id`) REFERENCES `tbl_auto_forms_value` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='value of fields in auto';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_auto_fields_value`
--

LOCK TABLES `jet_auto_fields_value` WRITE;
/*!40000 ALTER TABLE `jet_auto_fields_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_auto_fields_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_auto_forms`
--

DROP TABLE IF EXISTS `jet_auto_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_auto_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `tree_id` int(11) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `maker_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `params` text DEFAULT NULL,
  `enable` int(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_auto_forms_name_en_uindex` (`name_en`),
  KEY `tbl_auto_forms_tbl_auto_forms_tree_id_fk` (`tree_id`),
  KEY `tbl_auto_forms_tbl_user_eemploy_id_fk` (`maker_id`),
  CONSTRAINT `tbl_auto_forms_tbl_auto_forms_tree_id_fk` FOREIGN KEY (`tree_id`) REFERENCES `jet_auto_forms_tree` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `tbl_auto_forms_tbl_user_eemploy_id_fk` FOREIGN KEY (`maker_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='list forms';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_auto_forms`
--

LOCK TABLES `jet_auto_forms` WRITE;
/*!40000 ALTER TABLE `jet_auto_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_auto_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_auto_forms_fields`
--

DROP TABLE IF EXISTS `jet_auto_forms_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_auto_forms_fields` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `width` int(5) DEFAULT NULL,
  `order_by` int(10) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `show_list` tinyint(1) DEFAULT 0,
  `params` text DEFAULT NULL,
  `parent_class` varchar(100) DEFAULT NULL,
  `style` varchar(255) DEFAULT NULL COMMENT 'css style',
  `required` tinyint(1) DEFAULT 0,
  `min` int(11) DEFAULT NULL,
  `max` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_auto_forms_fields_name_uindex` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_auto_forms_fields`
--

LOCK TABLES `jet_auto_forms_fields` WRITE;
/*!40000 ALTER TABLE `jet_auto_forms_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_auto_forms_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_auto_forms_tree`
--

DROP TABLE IF EXISTS `jet_auto_forms_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_auto_forms_tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_maker_id` int(11) DEFAULT NULL,
  `params` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='tree af forms for auto';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_auto_forms_tree`
--

LOCK TABLES `jet_auto_forms_tree` WRITE;
/*!40000 ALTER TABLE `jet_auto_forms_tree` DISABLE KEYS */;
INSERT INTO `jet_auto_forms_tree` VALUES (1,'default','',NULL,NULL,NULL);
/*!40000 ALTER TABLE `jet_auto_forms_tree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_auto_froms_refer`
--

DROP TABLE IF EXISTS `jet_auto_froms_refer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_auto_froms_refer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_value_id` int(11) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `subject_id` int(11) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `read` datetime NOT NULL DEFAULT current_timestamp(),
  `show` tinyint(1) DEFAULT 1,
  `state` int(11) DEFAULT 0,
  `params` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_auto_froms_refer_tbl_auto_forms_value_id_fk` (`form_value_id`),
  CONSTRAINT `tbl_auto_froms_refer_tbl_auto_forms_value_id_fk` FOREIGN KEY (`form_value_id`) REFERENCES `tbl_auto_forms_value` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='refers';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_auto_froms_refer`
--

LOCK TABLES `jet_auto_froms_refer` WRITE;
/*!40000 ALTER TABLE `jet_auto_froms_refer` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_auto_froms_refer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_auto_refer_subject`
--

DROP TABLE IF EXISTS `jet_auto_refer_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_auto_refer_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `des` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_auto_refer_subject`
--

LOCK TABLES `jet_auto_refer_subject` WRITE;
/*!40000 ALTER TABLE `jet_auto_refer_subject` DISABLE KEYS */;
INSERT INTO `jet_auto_refer_subject` VALUES (1,'accepted',''),(2,'edit',NULL);
/*!40000 ALTER TABLE `jet_auto_refer_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_country`
--

DROP TABLE IF EXISTS `jet_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `des` varchar(100) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='countries';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_country`
--

LOCK TABLES `jet_country` WRITE;
/*!40000 ALTER TABLE `jet_country` DISABLE KEYS */;
INSERT INTO `jet_country` VALUES (1,'Iran',NULL,'IR'),(2,'Afghanistan',NULL,'AF'),(3,'Albania',NULL,'AL'),(4,'Algeria',NULL,'DZ'),(5,'American Samoa',NULL,'DS'),(6,'Andorra',NULL,'AD'),(7,'Angola',NULL,'AO'),(8,'Anguilla',NULL,'AI'),(9,'Antarctica',NULL,'AQ'),(10,'Antigua and Barbuda',NULL,'AG'),(11,'Argentina',NULL,'AR'),(12,'Armenia',NULL,'AM'),(13,'Aruba',NULL,'AW'),(14,'Australia',NULL,'AU'),(15,'Austria',NULL,'AT'),(16,'Azerbaijan',NULL,'AZ'),(17,'Bahamas',NULL,'BS'),(18,'Bahrain',NULL,'BH'),(19,'Bangladesh',NULL,'BD'),(20,'Barbados',NULL,'BB'),(21,'Belarus',NULL,'BY'),(22,'Belgium',NULL,'BE'),(23,'Belize',NULL,'BZ'),(24,'Benin',NULL,'BJ'),(25,'Bermuda',NULL,'BM'),(26,'Bhutan',NULL,'BT'),(27,'Bolivia',NULL,'BO'),(28,'Bosnia and Herzegovina',NULL,'BA'),(29,'Botswana',NULL,'BW'),(30,'Bouvet Island',NULL,'BV'),(31,'Brazil',NULL,'BR'),(32,'British Indian Ocean Territory',NULL,'IO'),(33,'Brunei Darussalam',NULL,'BN'),(34,'Bulgaria',NULL,'BG'),(35,'Burkina Faso',NULL,'BF'),(36,'Burundi',NULL,'BI'),(37,'Cambodia',NULL,'KH'),(38,'Cameroon',NULL,'CM'),(39,'Canada',NULL,'CA'),(40,'Cape Verde',NULL,'CV'),(41,'Cayman Islands',NULL,'KY'),(42,'Central African Republic',NULL,'CF'),(43,'Chad',NULL,'TD'),(44,'Chile',NULL,'CL'),(45,'China',NULL,'CN'),(46,'Christmas Island',NULL,'CX'),(47,'Cocos (Keeling) Islands',NULL,'CC'),(48,'Colombia',NULL,'CO'),(49,'Comoros',NULL,'KM'),(50,'Democratic Republic of the Congo',NULL,'CD'),(51,'Republic of Congo',NULL,'CG'),(52,'Cook Islands',NULL,'CK'),(53,'Costa Rica',NULL,'CR'),(54,'Croatia (Hrvatska)',NULL,'HR'),(55,'Cuba',NULL,'CU'),(56,'Cyprus',NULL,'CY'),(57,'Czech Republic',NULL,'CZ'),(58,'Denmark',NULL,'DK'),(59,'Djibouti',NULL,'DJ'),(60,'Dominica',NULL,'DM'),(61,'Dominican Republic',NULL,'DO'),(62,'East Timor',NULL,'TP'),(63,'Ecuador',NULL,'EC'),(64,'Egypt',NULL,'EG'),(65,'El Salvador',NULL,'SV'),(66,'Equatorial Guinea',NULL,'GQ'),(67,'Eritrea',NULL,'ER'),(68,'Estonia',NULL,'EE'),(69,'Ethiopia',NULL,'ET'),(70,'Falkland Islands (Malvinas)',NULL,'FK'),(71,'Faroe Islands',NULL,'FO'),(72,'Fiji',NULL,'FJ'),(73,'Finland',NULL,'FI'),(74,'France',NULL,'FR'),(75,'France, Metropolitan',NULL,'FX'),(76,'French Guiana',NULL,'GF'),(77,'French Polynesia',NULL,'PF'),(78,'French Southern Territories',NULL,'TF'),(79,'Gabon',NULL,'GA'),(80,'Gambia',NULL,'GM'),(81,'Georgia',NULL,'GE'),(82,'Germany',NULL,'DE'),(83,'Ghana',NULL,'GH'),(84,'Gibraltar',NULL,'GI'),(85,'Guernsey',NULL,'GK'),(86,'Greece',NULL,'GR'),(87,'Greenland',NULL,'GL'),(88,'Grenada',NULL,'GD'),(89,'Guadeloupe',NULL,'GP'),(90,'Guam',NULL,'GU'),(91,'Guatemala',NULL,'GT'),(92,'Guinea',NULL,'GN'),(93,'Guinea-Bissau',NULL,'GW'),(94,'Guyana',NULL,'GY'),(95,'Haiti',NULL,'HT'),(96,'Heard and Mc Donald Islands',NULL,'HM'),(97,'Honduras',NULL,'HN'),(98,'Hong Kong',NULL,'HK'),(99,'Hungary',NULL,'HU'),(100,'Iceland',NULL,'IS'),(101,'India',NULL,'IN'),(102,'Isle of Man',NULL,'IM'),(103,'Indonesia',NULL,'ID'),(105,'Iraq',NULL,'IQ'),(106,'Ireland',NULL,'IE'),(107,'Israel',NULL,'IL'),(108,'Italy',NULL,'IT'),(109,'Ivory Coast',NULL,'CI'),(110,'Jersey',NULL,'JE'),(111,'Jamaica',NULL,'JM'),(112,'Japan',NULL,'JP'),(113,'Jordan',NULL,'JO'),(114,'Kazakhstan',NULL,'KZ'),(115,'Kenya',NULL,'KE'),(116,'Kiribati',NULL,'KI'),(117,'Korea, Democratic People\'s Republic of',NULL,'KP'),(118,'Korea, Republic of',NULL,'KR'),(119,'Kosovo',NULL,'XK'),(120,'Kuwait',NULL,'KW'),(121,'Kyrgyzstan',NULL,'KG'),(122,'Lao People\'s Democratic Republic',NULL,'LA'),(123,'Latvia',NULL,'LV'),(124,'Lebanon',NULL,'LB'),(125,'Lesotho',NULL,'LS'),(126,'Liberia',NULL,'LR'),(127,'Libyan Arab Jamahiriya',NULL,'LY'),(128,'Liechtenstein',NULL,'LI'),(129,'Lithuania',NULL,'LT'),(130,'Luxembourg',NULL,'LU'),(131,'Macau',NULL,'MO'),(132,'North Macedonia',NULL,'MK'),(133,'Madagascar',NULL,'MG'),(134,'Malawi',NULL,'MW'),(135,'Malaysia',NULL,'MY'),(136,'Maldives',NULL,'MV'),(137,'Mali',NULL,'ML'),(138,'Malta',NULL,'MT'),(139,'Marshall Islands',NULL,'MH'),(140,'Martinique',NULL,'MQ'),(141,'Mauritania',NULL,'MR'),(142,'Mauritius',NULL,'MU'),(143,'Mayotte',NULL,'TY'),(144,'Mexico',NULL,'MX'),(145,'Micronesia, Federated States of',NULL,'FM'),(146,'Moldova, Republic of',NULL,'MD'),(147,'Monaco',NULL,'MC'),(148,'Mongolia',NULL,'MN'),(149,'Montenegro',NULL,'ME'),(150,'Montserrat',NULL,'MS'),(151,'Morocco',NULL,'MA'),(152,'Mozambique',NULL,'MZ'),(153,'Myanmar',NULL,'MM'),(154,'Namibia',NULL,'NA'),(155,'Nauru',NULL,'NR'),(156,'Nepal',NULL,'NP'),(157,'Netherlands',NULL,'NL'),(158,'Netherlands Antilles',NULL,'AN'),(159,'New Caledonia',NULL,'NC'),(160,'New Zealand',NULL,'NZ'),(161,'Nicaragua',NULL,'NI'),(162,'Niger',NULL,'NE'),(163,'Nigeria',NULL,'NG'),(164,'Niue',NULL,'NU'),(165,'Norfolk Island',NULL,'NF'),(166,'Northern Mariana Islands',NULL,'MP'),(167,'Norway',NULL,'NO'),(168,'Oman',NULL,'OM'),(169,'Pakistan',NULL,'PK'),(170,'Palau',NULL,'PW'),(171,'Palestine',NULL,'PS'),(172,'Panama',NULL,'PA'),(173,'Papua New Guinea',NULL,'PG'),(174,'Paraguay',NULL,'PY'),(175,'Peru',NULL,'PE'),(176,'Philippines',NULL,'PH'),(177,'Pitcairn',NULL,'PN'),(178,'Poland',NULL,'PL'),(179,'Portugal',NULL,'PT'),(180,'Puerto Rico',NULL,'PR'),(181,'Qatar',NULL,'QA'),(182,'Reunion',NULL,'RE'),(183,'Romania',NULL,'RO'),(184,'Russian Federation',NULL,'RU'),(185,'Rwanda',NULL,'RW'),(186,'Saint Kitts and Nevis',NULL,'KN'),(187,'Saint Lucia',NULL,'LC'),(188,'Saint Vincent and the Grenadines',NULL,'VC'),(189,'Samoa',NULL,'WS'),(190,'San Marino',NULL,'SM'),(191,'Sao Tome and Principe',NULL,'ST'),(192,'Saudi Arabia',NULL,'SA'),(193,'Senegal',NULL,'SN'),(194,'Serbia',NULL,'RS'),(195,'Seychelles',NULL,'SC'),(196,'Sierra Leone',NULL,'SL'),(197,'Singapore',NULL,'SG'),(198,'Slovakia',NULL,'SK'),(199,'Slovenia',NULL,'SI'),(200,'Solomon Islands',NULL,'SB'),(201,'Somalia',NULL,'SO'),(202,'South Africa',NULL,'ZA'),(203,'South Georgia South Sandwich Islands',NULL,'GS'),(204,'South Sudan',NULL,'SS'),(205,'Spain',NULL,'ES'),(206,'Sri Lanka',NULL,'LK'),(207,'St. Helena',NULL,'SH'),(208,'St. Pierre and Miquelon',NULL,'PM'),(209,'Sudan',NULL,'SD'),(210,'Suriname',NULL,'SR'),(211,'Svalbard and Jan Mayen Islands',NULL,'SJ'),(212,'Swaziland',NULL,'SZ'),(213,'Sweden',NULL,'SE'),(214,'Switzerland',NULL,'CH'),(215,'Syrian Arab Republic',NULL,'SY'),(216,'Taiwan',NULL,'TW'),(217,'Tajikistan',NULL,'TJ'),(218,'Tanzania, United Republic of',NULL,'TZ'),(219,'Thailand',NULL,'TH'),(220,'Togo',NULL,'TG'),(221,'Tokelau',NULL,'TK'),(222,'Tonga',NULL,'TO'),(223,'Trinidad and Tobago',NULL,'TT'),(224,'Tunisia',NULL,'TN'),(225,'Turkey',NULL,'TR'),(226,'Turkmenistan',NULL,'TM'),(227,'Turks and Caicos Islands',NULL,'TC'),(228,'Tuvalu',NULL,'TV'),(229,'Uganda',NULL,'UG'),(230,'Ukraine',NULL,'UA'),(231,'United Arab Emirates',NULL,'AE'),(232,'United Kingdom',NULL,'GB'),(233,'United States',NULL,'US'),(234,'United States minor outlying islands',NULL,'UM'),(235,'Uruguay',NULL,'UY'),(236,'Uzbekistan',NULL,'UZ'),(237,'Vanuatu',NULL,'VU'),(238,'Vatican City State',NULL,'VA'),(239,'Venezuela',NULL,'VE'),(240,'Vietnam',NULL,'VN'),(241,'Virgin Islands (British)',NULL,'VG'),(242,'Virgin Islands (U.S.)',NULL,'VI'),(243,'Wallis and Futuna Islands',NULL,'WF'),(244,'Western Sahara',NULL,'EH'),(245,'Yemen',NULL,'YE'),(246,'Zambia',NULL,'ZM'),(247,'Zimbabwe',NULL,'ZW');
/*!40000 ALTER TABLE `jet_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_crm_Promoter`
--

DROP TABLE IF EXISTS `jet_crm_Promoter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_crm_Promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `meli_id` varchar(20) DEFAULT NULL COMMENT 'national number',
  `birth` datetime DEFAULT NULL,
  `tell` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `hour_daily` varchar(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sallari` varchar(100) DEFAULT NULL,
  `father` varchar(100) DEFAULT NULL,
  `maker_id` int(11) NOT NULL,
  `datecreate` datetime NOT NULL DEFAULT current_timestamp(),
  `group_id` int(40) NOT NULL,
  `extra1` text DEFAULT NULL,
  `extra2` text DEFAULT NULL,
  `extra3` text DEFAULT NULL,
  `state` int(1) NOT NULL DEFAULT 1,
  `email` varchar(100) DEFAULT NULL,
  `weekly_alert1` int(1) NOT NULL DEFAULT 0,
  `weekly_alert2` int(1) NOT NULL DEFAULT 0,
  `weekly_alert3` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `maker_id` (`maker_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `group` FOREIGN KEY (`group_id`) REFERENCES `jet_crm_Promoter_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `shop` FOREIGN KEY (`user_id`) REFERENCES `jet_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_promoter_tbl_user_eemploy_id_fk` FOREIGN KEY (`maker_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='promater details';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_crm_Promoter`
--

LOCK TABLES `jet_crm_Promoter` WRITE;
/*!40000 ALTER TABLE `jet_crm_Promoter` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_crm_Promoter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_crm_Promoter_group`
--

DROP TABLE IF EXISTS `jet_crm_Promoter_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_crm_Promoter_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `params` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_crm_Promoter_group`
--

LOCK TABLES `jet_crm_Promoter_group` WRITE;
/*!40000 ALTER TABLE `jet_crm_Promoter_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_crm_Promoter_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_crm_Promoter_track`
--

DROP TABLE IF EXISTS `jet_crm_Promoter_track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_crm_Promoter_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promoter_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` varchar(250) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `replay` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_promotor_track_tbl_user_eemploy_id_fk` (`user_id`),
  KEY `tbl_Promoter_track_tbl_Promoter_id_fk` (`promoter_id`),
  CONSTRAINT `tbl_Promoter_track_tbl_Promoter_id_fk` FOREIGN KEY (`promoter_id`) REFERENCES `jet_crm_Promoter` (`id`),
  CONSTRAINT `tbl_promotor_track_tbl_user_eemploy_id_fk` FOREIGN KEY (`user_id`) REFERENCES `jet_user_admin` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_crm_Promoter_track`
--

LOCK TABLES `jet_crm_Promoter_track` WRITE;
/*!40000 ALTER TABLE `jet_crm_Promoter_track` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_crm_Promoter_track` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_crm_company`
--

DROP TABLE IF EXISTS `jet_crm_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_crm_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` int(1) NOT NULL DEFAULT 1,
  `group_ref` int(11) DEFAULT NULL,
  `country_ref` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_crm_company`
--

LOCK TABLES `jet_crm_company` WRITE;
/*!40000 ALTER TABLE `jet_crm_company` DISABLE KEYS */;
INSERT INTO `jet_crm_company` VALUES (2,1,2,0,'jet',' ','2019-03-16 07:10:37');
/*!40000 ALTER TABLE `jet_crm_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_crm_company_group`
--

DROP TABLE IF EXISTS `jet_crm_company_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_crm_company_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `des` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_crm_company_group`
--

LOCK TABLES `jet_crm_company_group` WRITE;
/*!40000 ALTER TABLE `jet_crm_company_group` DISABLE KEYS */;
INSERT INTO `jet_crm_company_group` VALUES (2,'technology','');
/*!40000 ALTER TABLE `jet_crm_company_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_crm_rival_prd`
--

DROP TABLE IF EXISTS `jet_crm_rival_prd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_crm_rival_prd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `group_rival_prd` int(11) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `prd_name` varchar(100) DEFAULT NULL,
  `prd_country` varchar(100) DEFAULT NULL,
  `prd_company` varchar(100) DEFAULT NULL,
  `prd_website` varchar(150) DEFAULT NULL,
  `prd_contact` varchar(255) DEFAULT NULL,
  `maker_id` int(11) DEFAULT NULL,
  `prd_realated` int(11) DEFAULT NULL,
  `prd_price` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_crm_rival_prd_tbl_prd_group_id_fk` (`group_rival_prd`),
  KEY `tbl_crm_rival_prd_tbl_prd_id_fk` (`prd_realated`),
  CONSTRAINT `tbl_crm_rival_prd_tbl_prd_group_id_fk` FOREIGN KEY (`group_rival_prd`) REFERENCES `jet_prd_group` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `tbl_crm_rival_prd_tbl_prd_id_fk` FOREIGN KEY (`prd_realated`) REFERENCES `jet_prd` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_crm_rival_prd`
--

LOCK TABLES `jet_crm_rival_prd` WRITE;
/*!40000 ALTER TABLE `jet_crm_rival_prd` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_crm_rival_prd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_factor`
--

DROP TABLE IF EXISTS `jet_factor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_factor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'fk for user',
  `maker_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `expire_date` datetime DEFAULT NULL,
  `des` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `maker_id` (`maker_id`),
  KEY `level_id` (`level_id`),
  CONSTRAINT `factor_clientid` FOREIGN KEY (`user_id`) REFERENCES `jet_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `factor_maker_id` FOREIGN KEY (`maker_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_factor`
--

LOCK TABLES `jet_factor` WRITE;
/*!40000 ALTER TABLE `jet_factor` DISABLE KEYS */;
INSERT INTO `jet_factor` VALUES (16,2,220,16,'0000-00-00 00:00:00','0000-00-00 00:00:00',''),(17,2,220,16,'0000-00-00 00:00:00','0000-00-00 00:00:00',''),(18,1,220,16,'0000-00-00 00:00:00','0000-00-00 00:00:00',''),(19,2,220,16,'0000-00-00 00:00:00','0000-00-00 00:00:00',''),(20,2,220,16,'0000-00-00 00:00:00','0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `jet_factor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_factor_additions`
--

DROP TABLE IF EXISTS `jet_factor_additions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_factor_additions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `mode` varchar(1) NOT NULL COMMENT '+,-',
  `persent` int(11) DEFAULT NULL,
  `value` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='tax and other added to factor price';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_factor_additions`
--

LOCK TABLES `jet_factor_additions` WRITE;
/*!40000 ALTER TABLE `jet_factor_additions` DISABLE KEYS */;
INSERT INTO `jet_factor_additions` VALUES (1,'_TAX','+',NULL,NULL),(2,'_OFF_PRICE','-',NULL,NULL);
/*!40000 ALTER TABLE `jet_factor_additions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_factor_level`
--

DROP TABLE IF EXISTS `jet_factor_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_factor_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `des` varchar(255) DEFAULT NULL,
  `get_id` tinyint(1) NOT NULL,
  `expirable` tinyint(1) DEFAULT 0,
  `editable` tinyint(1) DEFAULT 0,
  `removable` tinyint(1) DEFAULT 0,
  `show_details` tinyint(1) DEFAULT 0,
  `next_levels` tinyint(1) DEFAULT 0,
  `alert_self_make` tinyint(1) DEFAULT 0,
  `alert_usergroups_make` varchar(255) DEFAULT '0',
  `alert_self_expire` tinyint(1) DEFAULT 0,
  `alert_usergroup_expire` varchar(100) DEFAULT '0',
  `stock_in` tinyint(1) NOT NULL,
  `stock_out` tinyint(1) NOT NULL,
  `factor_preview_id` int(11) NOT NULL,
  `reject_form` tinyint(1) NOT NULL,
  `bed` tinyint(1) NOT NULL,
  `bes` tinyint(1) NOT NULL,
  `other_pay` tinyint(10) NOT NULL DEFAULT 0,
  `stock_in_recepie` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `factor_preview_id` (`factor_preview_id`),
  CONSTRAINT `jet_factor_level_ibfk_1` FOREIGN KEY (`factor_preview_id`) REFERENCES `tbl_factor_preview` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_factor_level`
--

LOCK TABLES `jet_factor_level` WRITE;
/*!40000 ALTER TABLE `jet_factor_level` DISABLE KEYS */;
INSERT INTO `jet_factor_level` VALUES (1,'sale',NULL,1,1,0,0,1,NULL,1,'1',1,'1',1,0,1,1,1,0,1,1),(2,'pre-sale',NULL,0,1,1,1,1,1,0,'0',0,'0',0,0,1,0,0,0,0,0);
/*!40000 ALTER TABLE `jet_factor_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_factor_prd`
--

DROP TABLE IF EXISTS `jet_factor_prd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_factor_prd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `radif` varchar(10) NOT NULL,
  `id_prd` int(11) NOT NULL COMMENT 'fk for prd id',
  `id_factor` int(11) NOT NULL COMMENT 'fk for factor',
  `takhfif` varchar(100) NOT NULL DEFAULT '0' COMMENT 'line off price',
  `price` varchar(100) NOT NULL COMMENT 'mablagh nahaii',
  `price_client` varchar(100) DEFAULT NULL,
  `num` int(11) NOT NULL COMMENT 'number of prd',
  PRIMARY KEY (`id`),
  KEY `id_prd` (`id_prd`),
  KEY `id_factor` (`id_factor`),
  CONSTRAINT `factor_factor_prd` FOREIGN KEY (`id_prd`) REFERENCES `jet_prd` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `factor_prd` FOREIGN KEY (`id_factor`) REFERENCES `jet_factor` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_factor_prd`
--

LOCK TABLES `jet_factor_prd` WRITE;
/*!40000 ALTER TABLE `jet_factor_prd` DISABLE KEYS */;
INSERT INTO `jet_factor_prd` VALUES (17,'[1]',13,16,'0','100',NULL,1),(18,'[1]',13,17,'10','150',NULL,5),(19,'[1]',14,18,'0','200',NULL,1),(20,'[1]',15,19,'0','300',NULL,1),(21,'[1]',15,20,'0','300',NULL,1);
/*!40000 ALTER TABLE `jet_factor_prd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_log`
--

DROP TABLE IF EXISTS `jet_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'if login user id',
  `user_name` text NOT NULL,
  `url` text NOT NULL COMMENT 'url',
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `des` text NOT NULL COMMENT 'database query and other',
  `ip` varchar(40) NOT NULL COMMENT 'ip of user',
  `agent` varchar(255) NOT NULL COMMENT 'platform+browser',
  `system` text NOT NULL COMMENT 'full system info.',
  `post` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=432 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='log system';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_log`
--

LOCK TABLES `jet_log` WRITE;
/*!40000 ALTER TABLE `jet_log` DISABLE KEYS */;
INSERT INTO `jet_log` VALUES (1,0,'','http://localhost/jet/jet/','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(2,0,'','http://localhost/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"username\":\"administrator\",\"password\":\"123456\"}'),(3,0,'','http://localhost/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(4,16,'admin','http://localhost/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(5,16,'admin','http://localhost/jet/jet/Dashboard/change_pass_view','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(6,16,'admin','http://localhost/jet/jet/Dashboard/fill_profile','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(7,16,'admin','http://localhost/jet/jet/Dashboard/fill_profilep','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"name\":\"administrator\",\"email\":\"jenabi.pirooz@gmail.com\",\"mobile\":\"09130878009\",\"tell\":\"03136736744\",\"postal_code\":\"123\",\"address\":\"\\u0627\\u0635\\u0641\\u0647\\u0627\\u0646 \\u0628\\u0647\\u0627\\u0631\\u0633\\u062a\\u0627\\u0646 \\u062e\\u06cc\\u0627\\u0628\\u0627\\u0646 \\u0645\\u0647\\u062a\\u0627\\u062810 \\u062e\\u06cc\\u0627\\u0628\\u0627\\u0646 \\u0628\\u062f\\u0631 8 \\u067e\\u0644\\u0627\\u06a9 557\",\"birthday\":\"2020\\/02\\/25\",\"id\":\"16\"}'),(8,16,'admin','http://localhost/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(9,16,'admin','http://localhost/jet/jet/Backup_main','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(10,16,'admin','http://localhost/jet/jet/Setting','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(11,16,'admin','http://localhost/jet/jet/Setting/manage/1','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"noheader\":\"true\"}'),(12,16,'admin','http://localhost/jet/jet/ajax/save_edit_text','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"value\":\"  jet  \",\"id\":\"{\\\"vq\\\":\\\"78\\\",\\\"ct\\\":\\\"frggvat\\\",\\\"svryq\\\":\\\"inyhr\\\"}\"}'),(13,16,'admin','http://localhost/jet/jet/ajax/save_edit_text','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"value\":\"  jet  \",\"id\":\"{\\\"vq\\\":\\\"78\\\",\\\"ct\\\":\\\"frggvat\\\",\\\"svryq\\\":\\\"inyhr\\\"}\"}'),(14,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(15,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(16,16,'admin','http://localhost/jet/jet/Project/todolist','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"8\"}'),(17,16,'admin','http://localhost/jet/jet/Project/comments','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"8\"}'),(18,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(19,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/index/private','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(20,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(21,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(22,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(23,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"delete\",\"id\":\"8\"}'),(24,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(25,16,'admin','http://localhost/jet/jet/project/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"[[id]]\"}'),(26,16,'admin','http://localhost/jet/jet/Project/addp','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"name\":\"test project\",\"status\":\"todo\",\"des\":\"test project\"}'),(27,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"3\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(28,16,'admin','http://localhost/jet/jet/Project/view','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"9\",\"noheader\":\"true\"}'),(29,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(30,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__vip\":\"0\",\"f__name\":\"\",\"f__tell\":\"\",\"f__mobile\":\"\",\"f__usergroup\":\"\",\"f__price\":\"\"}'),(31,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"delete\",\"id\":\"218\"}'),(32,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__vip\":\"0\",\"f__name\":\"\",\"f__tell\":\"\",\"f__mobile\":\"\",\"f__usergroup\":\"\",\"f__price\":\"\"}'),(33,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"delete\",\"id\":\"217\"}'),(34,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"3\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__vip\":\"0\",\"f__name\":\"\",\"f__tell\":\"\",\"f__mobile\":\"\",\"f__usergroup\":\"\",\"f__price\":\"\"}'),(35,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"delete\",\"id\":\"219\"}'),(36,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"4\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__vip\":\"0\",\"f__name\":\"\",\"f__tell\":\"\",\"f__mobile\":\"\",\"f__usergroup\":\"\",\"f__price\":\"\"}'),(37,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_usergroup','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(38,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_usergroup','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(39,0,'','http://localhost/jet/jet/MaLi/pusers/users/manage_usergroup','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(40,0,'','http://localhost/jet/jet/','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(41,0,'','http://localhost/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(42,16,'admin','http://localhost/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(43,16,'admin','http://localhost/jet/jet/CRM/my_client','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(44,16,'admin','http://localhost/jet/jet/CRM/my_client/belfel','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(45,16,'admin','http://localhost/jet/jet/CRM/my_client','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(46,16,'admin','http://localhost/jet/jet/CRM/Tmp_users/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(47,16,'admin','http://localhost/jet/jet/CRM/Tmp_users/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"where\":\"maker_id=16 AND state=1\"}'),(48,0,'','http://localhost/jet/jet/','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(49,0,'','http://localhost/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(50,16,'admin','http://localhost/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(51,16,'admin','http://localhost/jet/jet/AUTO/add_form','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(52,0,'','http://localhost/jet/jet/CRM/alerts','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(53,0,'','http://localhost/jet/jet/login','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(54,0,'','http://localhost/jet/jet/login','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(55,0,'','http://localhost/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(56,16,'admin','http://localhost/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(57,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(58,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(59,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__vip\":\"0\",\"f__name\":\"\",\"f__tell\":\"\",\"f__mobile\":\"\",\"f__usergroup\":\"\",\"f__price\":\"\"}'),(60,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"state\":\"1\",\"vip\":\"0\",\"name\":\"jet\",\"tell\":\"\",\"mobile\":\"\",\"usergroup\":\"\",\"parent\":\"\",\"price\":\"\",\"birth\":\"2020\\/03\\/29\",\"maker_id\":\"16\",\"typeIn\":\"add\"}'),(61,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"state\":\"1\",\"vip\":\"0\",\"name\":\"jet\",\"tell\":\"\",\"mobile\":\"\",\"usergroup\":\"6\",\"parent\":\"\",\"price\":\"\",\"birth\":\"2020\\/03\\/29\",\"maker_id\":\"16\",\"typeIn\":\"add\"}'),(62,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__vip\":\"0\",\"f__name\":\"\",\"f__tell\":\"\",\"f__mobile\":\"\",\"f__usergroup\":\"\",\"f__price\":\"\"}'),(63,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(64,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(65,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__vip\":\"0\",\"f__name\":\"\",\"f__tell\":\"\",\"f__mobile\":\"\",\"f__usergroup\":\"\",\"f__price\":\"\"}'),(66,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(67,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(68,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__vip\":\"0\",\"f__name\":\"\",\"f__tell\":\"\",\"f__mobile\":\"\",\"f__usergroup\":\"\",\"f__price\":\"\"}'),(69,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(70,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(71,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(72,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(73,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(74,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(75,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"edit\",\"id\":\"11\"}'),(76,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(77,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage_group','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(78,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage_group','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(79,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage_group','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"name\":\"group\",\"state\":\"1\",\"des\":\"test\",\"parent\":\"\",\"typeIn\":\"add\"}'),(80,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage_group','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(81,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(82,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(83,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"edit\",\"id\":\"11\"}'),(84,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(85,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"delete\",\"id\":\"11\"}'),(86,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"3\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(87,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"11\",\"state\":\"0\",\"name\":\"pack1\",\"group_id\":\"6\",\"out_stack_alert\":\"10\",\"price1\":\"100\",\"vahed_asli\":\"2\",\"vahed_fari\":\"\",\"per_karton\":\"\",\"order_by\":\"1\",\"row_plus\":\"\",\"typeIn\":\"add\"}'),(88,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"4\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(89,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(90,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(91,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"state\":\"1\",\"name\":\"pack2\",\"group_id\":\"6\",\"out_stack_alert\":\"\",\"price1\":\"200\",\"vahed_asli\":\"\",\"vahed_fari\":\"\",\"per_karton\":\"\",\"order_by\":\"\",\"row_plus\":\"\",\"typeIn\":\"add\"}'),(92,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(93,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"state\":\"1\",\"name\":\"pack3\",\"group_id\":\"\",\"out_stack_alert\":\"\",\"price1\":\"300\",\"vahed_asli\":\"2\",\"vahed_fari\":\"\",\"per_karton\":\"\",\"order_by\":\"\",\"row_plus\":\"\",\"typeIn\":\"add\"}'),(94,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"state\":\"1\",\"name\":\"pack3\",\"group_id\":\"\",\"out_stack_alert\":\"\",\"price1\":\"300\",\"vahed_asli\":\"2\",\"vahed_fari\":\"\",\"per_karton\":\"\",\"order_by\":\"\",\"row_plus\":\"\",\"typeIn\":\"add\"}'),(95,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"state\":\"1\",\"name\":\"pack3\",\"group_id\":\"\",\"out_stack_alert\":\"\",\"price1\":\"300\",\"vahed_asli\":\"2\",\"vahed_fari\":\"\",\"per_karton\":\"\",\"order_by\":\"\",\"row_plus\":\"\",\"typeIn\":\"add\"}'),(96,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"state\":\"1\",\"name\":\"pack3\",\"group_id\":\"\",\"out_stack_alert\":\"\",\"price1\":\"300\",\"vahed_asli\":\"2\",\"vahed_fari\":\"\",\"per_karton\":\"\",\"order_by\":\"\",\"row_plus\":\"\",\"typeIn\":\"add\"}'),(97,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"state\":\"1\",\"name\":\"pack3\",\"group_id\":\"\",\"out_stack_alert\":\"\",\"price1\":\"300\",\"vahed_asli\":\"2\",\"vahed_fari\":\"\",\"per_karton\":\"\",\"order_by\":\"\",\"row_plus\":\"\",\"typeIn\":\"add\"}'),(98,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"state\":\"1\",\"name\":\"pack3\",\"group_id\":\"6\",\"out_stack_alert\":\"\",\"price1\":\"300\",\"vahed_asli\":\"2\",\"vahed_fari\":\"\",\"per_karton\":\"\",\"order_by\":\"\",\"row_plus\":\"\",\"typeIn\":\"add\"}'),(99,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"3\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(100,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"edit\",\"id\":\"13\"}'),(101,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"4\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(102,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"13\",\"state\":\"1\",\"name\":\"pack1\",\"group_id\":\"6\",\"out_stack_alert\":\"10\",\"price1\":\"100\",\"vahed_asli\":\"2\",\"vahed_fari\":\"\",\"per_karton\":\"\",\"order_by\":\"1\",\"row_plus\":\"\",\"typeIn\":\"update\"}'),(103,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"5\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(104,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(105,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(106,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(107,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"edit\",\"id\":\"15\"}'),(108,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"6\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(109,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"15\",\"state\":\"1\",\"name\":\"pack3\",\"group_id\":\"6\",\"out_stack_alert\":\"\",\"price1\":\"300\",\"vahed_asli\":\"2\",\"vahed_fari\":\"10\",\"per_karton\":\"\",\"order_by\":\"\",\"row_plus\":\"\",\"typeIn\":\"update\"}'),(110,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"7\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(111,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"edit\",\"id\":\"14\"}'),(112,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"8\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(113,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"14\",\"state\":\"1\",\"name\":\"pack2\",\"group_id\":\"6\",\"out_stack_alert\":\"\",\"price1\":\"200\",\"vahed_asli\":\"2\",\"vahed_fari\":\"20\",\"per_karton\":\"\",\"order_by\":\"\",\"row_plus\":\"\",\"typeIn\":\"update\"}'),(114,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"9\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(115,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"edit\",\"id\":\"13\"}'),(116,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"10\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(117,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"13\",\"state\":\"1\",\"name\":\"pack1\",\"group_id\":\"6\",\"out_stack_alert\":\"10\",\"price1\":\"100\",\"vahed_asli\":\"2\",\"vahed_fari\":\"12\",\"per_karton\":\"\",\"order_by\":\"1\",\"row_plus\":\"\",\"typeIn\":\"update\"}'),(118,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"11\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(119,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(120,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(121,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(122,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(123,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(124,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(125,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(126,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(127,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(128,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(129,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(130,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(131,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(132,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(133,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(134,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(135,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(136,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(137,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(138,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(139,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(140,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/index/public','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(141,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(142,16,'admin','http://localhost/jet/jet/MaLi/pprd/prd/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__name\":\"\",\"f__group_id\":\"\",\"f__vahed_asli\":\"\"}'),(143,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/index/public','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(144,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(145,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(146,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(147,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(148,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(149,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(150,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(151,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(152,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(153,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(154,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(155,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(156,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(157,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"12\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(158,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(159,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"12\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(160,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(161,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"12\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(162,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(163,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"12\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(164,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(165,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"12\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(166,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"name\":\"sale\",\"des\":\"\",\"next_levels\":\"\",\"get_id\":\"1\",\"expirable\":\"1\",\"removable\":\"0\",\"editable\":\"0\",\"show_details\":\"1\",\"alert_self_make\":\"1\",\"alert_usergroups_make\":\"1\",\"alert_self_expire\":\"1\",\"alert_usergroup_expire\":\"1\",\"stock_in\":\"1\",\"stock_out\":\"0\",\"bed\":\"1\",\"bes\":\"0\",\"factor_preview_id\":\"1\",\"reject_form\":\"1\",\"other_pay\":\"1\",\"stock_in_recepie\":\"1\",\"typeIn\":\"add\"}'),(167,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"12\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(168,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"typeIn\":\"view\",\"id\":\"1\"}'),(169,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"3\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"12\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(170,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(171,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"12\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(172,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"id\":\"\",\"name\":\"pre-sale\",\"des\":\"\",\"next_levels\":\"1\",\"get_id\":\"0\",\"expirable\":\"1\",\"removable\":\"1\",\"editable\":\"1\",\"show_details\":\"1\",\"alert_self_make\":\"0\",\"alert_usergroups_make\":\"0\",\"alert_self_expire\":\"0\",\"alert_usergroup_expire\":\"0\",\"stock_in\":\"0\",\"stock_out\":\"0\",\"bed\":\"0\",\"bes\":\"0\",\"factor_preview_id\":\"1\",\"reject_form\":\"0\",\"other_pay\":\"0\",\"stock_in_recepie\":\"0\",\"typeIn\":\"add\"}'),(173,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/manage_level','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"12\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(174,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(175,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"des\":\"\",\"user\":\"220\",\"level_id\":\"2\",\"factor_date\":\"2020\\/03\\/29\",\"expire_factor\":\"2020\\/05\\/28\",\"radif\":{\"1\":\"[1]\"},\"prd\":{\"1\":\"13\"},\"numprd\":{\"1\":\"1\"},\"price\":{\"1\":\"100\"},\"takhfif\":{\"1\":\"0\"},\"total_num_end\":\"\",\"total_prd_end\":\"\",\"adds\":{\"2\":\"0\",\"1\":\"0\"}}'),(176,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/main','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(177,0,'','http://localhost/jet/jet/jet/','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(178,0,'','http://localhost/jet/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"username\":\"admin\",\"password\":\"admin\"}'),(179,0,'','http://localhost/jet/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(180,16,'admin','http://localhost/jet/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(181,16,'admin','http://localhost/jet/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(182,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"des\":\"\",\"user\":\"220\",\"level_id\":\"2\",\"factor_date\":\"2020\\/03\\/30\",\"expire_factor\":\"2020\\/05\\/29\",\"radif\":{\"1\":\"[1]\",\"2\":\"[2]\"},\"prd\":{\"1\":\"13\",\"2\":\"-1\"},\"numprd\":{\"1\":\"5\",\"2\":\"1\"},\"price\":{\"1\":\"150\",\"2\":\"\"},\"takhfif\":{\"1\":\"10\",\"2\":\"0\"},\"total_num_end\":\"6\",\"total_prd_end\":\"790\",\"adds\":{\"2\":\"100\",\"1\":\"150\"}}'),(183,16,'admin','http://localhost/jet/jet/jet/MaLi/factor_sell/manage_factor/main','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(184,16,'admin','http://localhost/jet/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(185,16,'admin','http://localhost/jet/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(186,16,'admin','http://localhost/jet/jet/jet/MaLi/factor_sell/manage_factor/index/private','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(187,16,'admin','http://localhost/jet/jet/jet/MaLi/factor_sell/manage_factor/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(188,16,'admin','http://localhost/jet/jet/jet/MaLi/factor_sell/manage_factor/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(189,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(190,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"des\":\"\",\"user\":\"220\",\"level_id\":\"1\",\"factor_date\":\"2020\\/03\\/30\",\"expire_factor\":\"2020\\/05\\/29\",\"radif\":{\"1\":\"[1]\"},\"prd\":{\"1\":\"14\"},\"numprd\":{\"1\":\"1\"},\"price\":{\"1\":\"200\"},\"takhfif\":{\"1\":\"0\"},\"total_num_end\":\"\",\"total_prd_end\":\"\",\"adds\":{\"2\":\"0\",\"1\":\"0\"}}'),(191,16,'admin','http://localhost/jet/jet/jet/MaLi/factor_sell/manage_factor/main','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(192,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(193,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(194,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(195,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"des\":\"\",\"user\":\"220\",\"level_id\":\"2\",\"factor_date\":\"2020\\/03\\/30\",\"expire_factor\":\"2020\\/05\\/29\",\"radif\":{\"1\":\"[1]\"},\"prd\":{\"1\":\"15\"},\"numprd\":{\"1\":\"1\"},\"price\":{\"1\":\"300\"},\"takhfif\":{\"1\":\"0\"},\"total_num_end\":\"\",\"total_prd_end\":\"\",\"adds\":{\"2\":\"0\",\"1\":\"0\"}}'),(196,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"des\":\"\",\"user\":\"220\",\"level_id\":\"2\",\"factor_date\":\"2020\\/03\\/30\",\"expire_factor\":\"2020\\/05\\/29\",\"radif\":{\"1\":\"[1]\"},\"prd\":{\"1\":\"15\"},\"numprd\":{\"1\":\"1\"},\"price\":{\"1\":\"300\"},\"takhfif\":{\"1\":\"0\"},\"total_num_end\":\"\",\"total_prd_end\":\"\",\"adds\":{\"2\":\"0\",\"1\":\"0\"}}'),(197,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(198,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(199,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(200,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','[]'),(201,16,'admin','http://localhost/jet/jet/jet/MaLi/factor/manage','0000-00-00 00:00:00','','::1','Chrome 80.0.3987.87--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.87 Chrome/80.0.3987.87 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(202,0,'','http://localhost/jet/jet/','0000-00-00 00:00:00','login','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(203,0,'','http://localhost/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"username\":\"admin\",\"password\":\"12345\"}'),(204,0,'','http://localhost/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(205,16,'admin','http://localhost/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(206,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(207,16,'admin','http://localhost/jet/jet/eemploy/eemploy/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(208,16,'admin','http://localhost/jet/jet/eemploy/eemploy/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(209,0,'','http://localhost/jet/jet/','0000-00-00 00:00:00','login','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(210,0,'','http://localhost/jet/jet/login/auth','0000-00-00 00:00:00','login','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(211,16,'admin','http://localhost/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(212,16,'admin','http://localhost/jet/jet/Setting','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(213,16,'admin','http://localhost/jet/jet/Setting/manage/1','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"noheader\":\"true\"}'),(214,16,'admin','http://localhost/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(215,16,'admin','http://localhost/jet/jet/CRM/my_employ','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(216,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(217,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(218,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/index/private','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(219,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(220,16,'admin','http://localhost/jet/jet/MaLi/factor_sell/manage_factor/expire_all','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(221,16,'admin','http://localhost/jet/jet/MaLi/Factor/add','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(222,16,'admin','http://localhost/jet/jet/Stock/Stock','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(223,16,'admin','http://localhost/jet/jet/Stock/Stock/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(224,16,'admin','http://localhost/jet/jet/Stock/Stock/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(225,16,'admin','http://localhost/jet/jet/Stock/Stock/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(226,16,'admin','http://localhost/jet/jet/Stock/Stock/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(227,16,'admin','http://localhost/jet/jet/Stock/Stock/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"id\":\"\",\"name\":\"\\u0645\\u0631\\u06a9\\u0632\\u06cc\",\"def\":\"1\",\"des\":\"\\u0627\\u0646\\u0628\\u0627\\u0631 \\u0645\\u0631\\u06a9\\u0632\\u06cc\",\"parent\":\"\",\"typeIn\":\"add\"}'),(228,16,'admin','http://localhost/jet/jet/Stock/Stock/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(229,16,'admin','http://localhost/jet/jet/Stock/Stock/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(230,16,'admin','http://localhost/jet/jet/Stock/Stock','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(231,16,'admin','http://localhost/jet/jet/Stock/Stock','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(232,16,'admin','http://localhost/jet/jet/Stock/Stock/Stock_check','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(233,16,'admin','http://localhost/jet/jet/Stock/Stock/Stock_check','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(234,16,'admin','http://localhost/jet/jet/Stock/Stock','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(235,16,'admin','http://localhost/jet/jet/Stock/Stock_in/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(236,16,'admin','http://localhost/jet/jet/Stock/Stock_in/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(237,16,'admin','http://localhost/jet/jet/Stock/Stock_in/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"id\":\"\",\"stock_id\":\"1\",\"prd_id\":\"14\",\"num\":\"10\",\"des\":\"test ecare\",\"date\":\"2020\\/07\\/10\",\"pro_forma\":\"\",\"lot\":\"\",\"user_id\":\"16\",\"typeIn\":\"add\"}'),(238,16,'admin','http://localhost/jet/jet/Stock/Stock_in/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(239,16,'admin','http://localhost/jet/jet/Stock/Stock','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(240,16,'admin','http://localhost/jet/jet/Stock/Stock/transfer','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(241,16,'admin','http://localhost/jet/jet/MaLi/factor/add','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(242,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(243,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_all','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\",\"f__state\":\"0\",\"f__vip\":\"0\",\"f__name\":\"\",\"f__tell\":\"\",\"f__mobile\":\"\",\"f__usergroup\":\"\",\"f__price\":\"\"}'),(244,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_usergroup','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(245,16,'admin','http://localhost/jet/jet/MaLi/pusers/users/manage_usergroup','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(246,16,'admin','http://localhost/jet/jet/eemploy/eemploy/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(247,16,'admin','http://localhost/jet/jet/eemploy/eemploy/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(248,16,'admin','http://localhost/jet/jet/eemploy/eemploy_user_group/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(249,16,'admin','http://localhost/jet/jet/eemploy/eemploy/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(250,16,'admin','http://localhost/jet/jet/eemploy/eemploy/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(251,16,'admin','http://localhost/jet/jet/Media/manage/0/rival','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"id\":\"16\",\"noheader\":\"true\"}'),(252,16,'admin','http://localhost/jet/jet/media/load/0/rival/16','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(253,16,'admin','http://localhost/jet/jet/media/upload/rival/16','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(254,16,'admin','http://localhost/jet/jet/Dashboard','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(255,16,'admin','http://localhost/jet/jet/CRM/my_employ','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(256,16,'admin','http://localhost/jet/jet/AUTO/add_form','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(257,16,'admin','http://localhost/jet/jet/CRM/my_employ','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(258,16,'admin','http://localhost/jet/jet/AUTO/kartable','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(259,16,'admin','http://localhost/jet/jet/CRM/my_employ','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(260,16,'admin','http://localhost/jet/jet/AUTO/report/report_main','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(261,16,'admin','http://localhost/jet/jet/AUTO/manage_form/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(262,16,'admin','http://localhost/jet/jet/AUTO/manage_form/manage/index','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(263,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(264,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"1\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(265,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"typeIn\":\"edit\",\"id\":\"9\"}'),(266,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"2\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(267,16,'admin','http://localhost/jet/jet/Project/view','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"id\":\"9\",\"noheader\":\"true\"}'),(268,16,'admin','http://localhost/jet/jet/Project/comments','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"id\":\"9\"}'),(269,16,'admin','http://localhost/jet/jet/Project/todolist','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"id\":\"9\"}'),(270,16,'admin','http://localhost/jet/jet/Project/todolist','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"todo\":\"\\u062a\\u0633\\u062a\",\"id\":\"9\"}'),(271,16,'admin','http://localhost/jet/jet/Project/manage','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"draw\":\"3\",\"columns\":[{\"data\":\"0\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"1\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"2\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"3\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"4\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"5\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"6\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"7\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"8\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"9\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"10\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"11\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"typeIn\":\"json\"}'),(272,16,'admin','http://localhost/jet/jet/Project/todolist','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"id\":\"9\"}'),(273,16,'admin','http://localhost/jet/jet/project/op_todo/done/1','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','[]'),(274,16,'admin','http://localhost/jet/jet/Project/todolist','0000-00-00 00:00:00','','::1','Chrome 83.0.4103.61--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/83.0.4103.61 Chrome/83.0.4103.61 Safari/537.36','{\"id\":\"9\"}'),(275,0,'','http://localhost:8000/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(276,0,'','http://localhost:8000/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(277,0,'','http://localhost:8000/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(278,0,'','http://localhost:8000/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(279,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"admin\"}'),(280,0,'','http://localhost:8000/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(281,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(282,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(283,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(284,16,'admin','http://localhost:8000/Dashboard/change_pass_view','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(285,0,'','http://localhost:8000/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(286,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(287,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(288,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(289,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(290,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(291,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(292,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(293,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(294,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(295,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(296,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(297,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(298,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(299,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(300,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(301,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(302,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(303,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(304,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(305,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(306,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(307,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(308,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(309,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(310,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(311,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(312,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(313,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(314,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(315,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(316,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(317,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(318,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(319,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(320,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(321,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(322,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(323,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(324,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(325,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(326,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(327,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(328,0,'','http://localhost:8000/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(329,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(330,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(331,0,'','http://localhost:8000/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(332,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(333,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(334,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(335,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(336,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(337,0,'','http://localhost:8000/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(338,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(339,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(340,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(341,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(342,0,'','http://localhost:8000/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(343,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(344,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(345,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(346,0,'','http://localhost:8000/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(347,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(348,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(349,0,'','http://localhost:8000/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(350,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(351,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(352,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(353,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(354,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(355,0,'','http://localhost:8000/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(356,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(357,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(358,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(359,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(360,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(361,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(362,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(363,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(364,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(365,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(366,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(367,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(368,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(369,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(370,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(371,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(372,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(373,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(374,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(375,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(376,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(377,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(378,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(379,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(380,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(381,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(382,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(383,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(384,0,'','http://localhost:8080/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(385,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(386,0,'','http://localhost:8080/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(387,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(388,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(389,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(390,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(391,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(392,0,'','http://localhost:8080/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(393,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(394,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(395,0,'','http://localhost:8080/Dashboard','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(396,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(397,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(398,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(399,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(400,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(401,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(402,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(403,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(404,0,'','http://localhost:8080/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(405,16,'admin','http://localhost:8080/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(406,16,'admin','http://localhost:8080/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(407,16,'admin','http://localhost:8080/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(408,16,'admin','http://localhost:8080/login/logout','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(409,0,'','http://localhost:8080/login','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(410,0,'','http://localhost:8000/','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(411,0,'','http://localhost:8000/login/auth','0000-00-00 00:00:00','login','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','{\"username\":\"admin\",\"password\":\"123456\"}'),(412,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(413,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(414,16,'admin','http://localhost:8000/Dashboard/change_pass_view','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(415,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(416,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(417,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(418,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(419,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(420,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(421,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(422,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(423,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(424,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(425,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(426,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(427,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(428,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(429,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(430,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]'),(431,16,'admin','http://localhost:8000/Dashboard','0000-00-00 00:00:00','','127.0.0.1','Chrome 87.0.4280.66--Linux','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36','[]');
/*!40000 ALTER TABLE `jet_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_mali_banks`
--

DROP TABLE IF EXISTS `jet_mali_banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_mali_banks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `des` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `public` int(1) DEFAULT NULL,
  `private` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='bank_acounts';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_mali_banks`
--

LOCK TABLES `jet_mali_banks` WRITE;
/*!40000 ALTER TABLE `jet_mali_banks` DISABLE KEYS */;
INSERT INTO `jet_mali_banks` VALUES (1,'paypal',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `jet_mali_banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_mali_commision`
--

DROP TABLE IF EXISTS `jet_mali_commision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_mali_commision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prd_id` int(11) DEFAULT NULL,
  `fromc` varchar(100) NOT NULL,
  `toc` varchar(100) NOT NULL,
  `value_percent` int(3) DEFAULT NULL,
  `value_num` varchar(100) DEFAULT NULL,
  `groupc` int(11) NOT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupc` (`groupc`),
  KEY `tbl_mali_commision_tbl_prd_id_fk` (`prd_id`),
  CONSTRAINT `groupc` FOREIGN KEY (`groupc`) REFERENCES `jet_mali_commision_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_mali_commision_tbl_prd_id_fk` FOREIGN KEY (`prd_id`) REFERENCES `jet_prd` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_mali_commision`
--

LOCK TABLES `jet_mali_commision` WRITE;
/*!40000 ALTER TABLE `jet_mali_commision` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_mali_commision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_mali_commision_group`
--

DROP TABLE IF EXISTS `jet_mali_commision_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_mali_commision_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_mali_commision_group`
--

LOCK TABLES `jet_mali_commision_group` WRITE;
/*!40000 ALTER TABLE `jet_mali_commision_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_mali_commision_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_mali_prd_unit`
--

DROP TABLE IF EXISTS `jet_mali_prd_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_mali_prd_unit` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_mali_prd_unit`
--

LOCK TABLES `jet_mali_prd_unit` WRITE;
/*!40000 ALTER TABLE `jet_mali_prd_unit` DISABLE KEYS */;
INSERT INTO `jet_mali_prd_unit` VALUES (1,'متر'),(2,'عدد'),(3,'شیشه'),(4,'کارتن'),(5,'دستگاه'),(8,'مگابایت');
/*!40000 ALTER TABLE `jet_mali_prd_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_media`
--

DROP TABLE IF EXISTS `jet_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `file_name` varchar(85) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `accepted` int(11) DEFAULT 0,
  `group_id` int(11) DEFAULT NULL,
  `maker_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `des` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `maker_id` (`maker_id`),
  KEY `type_id` (`type_id`,`accepted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='manage media ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_media`
--

LOCK TABLES `jet_media` WRITE;
/*!40000 ALTER TABLE `jet_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_media_group`
--

DROP TABLE IF EXISTS `jet_media_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_media_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `des` varchar(100) DEFAULT NULL,
  `params` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_media_group`
--

LOCK TABLES `jet_media_group` WRITE;
/*!40000 ALTER TABLE `jet_media_group` DISABLE KEYS */;
INSERT INTO `jet_media_group` VALUES (1,'default','default',NULL);
/*!40000 ALTER TABLE `jet_media_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_module`
--

DROP TABLE IF EXISTS `jet_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `permision_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `show_name` varchar(100) DEFAULT NULL,
  `des` varchar(100) DEFAULT NULL,
  `propertis` text DEFAULT NULL,
  `state` int(1) NOT NULL DEFAULT 1,
  `position` varchar(100) DEFAULT NULL,
  `width` varchar(10) DEFAULT NULL COMMENT 'bootstrap class',
  `load_type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mod_group` (`group_id`),
  KEY `permision_id` (`permision_id`),
  CONSTRAINT `module_group` FOREIGN KEY (`group_id`) REFERENCES `jet_module_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `permision` FOREIGN KEY (`permision_id`) REFERENCES `jet_permision` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='ماژول ها';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_module`
--

LOCK TABLES `jet_module` WRITE;
/*!40000 ALTER TABLE `jet_module` DISABLE KEYS */;
INSERT INTO `jet_module` VALUES (3,'مشتریان من',37,1,'0','مشتریان من','{\"icon\":\"fa fa-users  fa-5x\",\"css\":\"panel panel-info\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"/CRM/my_client\"}',1,'3','4','panel_btn'),(7,'کمیسیون کارشناسان',41,1,'0','کمیسیون','{\"icon\":\"fa fa-shopping-cart fa-5x\",\"css\":\"panel panel-red\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"/MaLi/comision/Comisions\"}',1,'3','4','panel_btn'),(8,'فاکتورهای فروش',42,1,'0','فاکتورهای فروش','{\"icon\":\"fa fa-diamond fa-5x\",\"css\":\"panel panel-red\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"/MaLi/factor_sell/manage_factor/level/1\"}',1,'3','4','panel_btn'),(10,'فاکتور های فروش تمامی کاربران',44,1,'0','فاکتور های فروش تمامی کاربران','{\"icon\":\"fa fa-money fa-5x\",\"css\":\"panel panel-primary\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"/MaLi/factor_sell/manage_factor/index/public/1\"}',1,'3','4','panel_btn'),(12,'مدیریت انبار',46,1,'0','مدیریت انبار','{\"icon\":\"fa fa-cube fa-5x\",\"css\":\"panel panel-info\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"Stock/Stock\"}',1,'3','4','panel_btn'),(14,' مدیریت کارشناسان فروش  ',48,1,'0','کارشناسان فروش','{\"icon\":\"fa fa-line-chart fa-5x\",\"css\":\"panel panel-info\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"/CRM/my_employ\"}',1,'3','4','panel_btn'),(17,'مدیریت کل کاربران',51,1,'0','مدیریت کاربران','{\"icon\":\"fa fa-support fa-5x\",\"css\":\"panel panel-red\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"/MaLi/pusers/users/manage_all/manage\"}',1,'3','4','panel_btn'),(18,' مانده حداقل فروش',52,1,'0','  مانده حداقل فروش تا','{\"icon\":\"fa fa-info fa-5x\",\"css\":\"panel panel-yellow\",\"root_css\":\"col-lg-9 col-md-6\",\"link\":\"/MaLi/factor_sell/manage_factor/this_month/0/0/private\"}',1,'7','9','panel_btn'),(19,'فاکتور های بدهکار',53,1,'0','فاکتورهای بدهکار','{\"icon\":\"fa fa-dollar fa-5x\",\"css\":\"panel panel-red\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"/MaLi/factor_sell/manage_factor/list_bedehkar\"}',1,'8','4','panel_btn'),(20,'هزینه حمل',54,1,'0','هزینه حمل','{\"icon\":\"fa fa-dollar fa-5x\",\"css\":\"panel panel-red\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"/MaLi/factor_sell/manage_factor/list_trans\"}',1,'5','4','panel_btn'),(21,'پروماتور',55,1,'0','پروماتور','{\"icon\":\"fa fa-user fa-5x\",\"css\":\"panel panel-red\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"/CRM/Promoter/manage\"}',1,'5','4','panel_btn'),(22,'فاکتورهای سررسید شده',56,1,'0','سررسیدها','{\"icon\":\"fa fa-clock-o  fa-5x\",\"css\":\"panel panel-primary\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"MaLi/factor_sell/manage_factor/expire_all\"}',1,'5','4','panel_btn'),(23,'عملیات حسابداری مشتریان',57,1,'0','عملیات حسابداری مشتریان','{\"icon\":\"fa fa-dollar fa-5x\",\"css\":\"panel panel-yellow\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"CRM/my_client/acounting\"}',1,'5','4','panel_btn'),(26,'مشاهده چکها',63,1,'0','مشاهده چکها','{\"icon\":\"fa fa-bank fa-5x\",\"css\":\"panel panel-red\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"MaLi/Bed_bes/list_checks\"}',1,'5','4','panel_btn'),(27,'ورود اطللاعات فرمها',64,1,'0','ورود اطلاعات','{\"icon\":\"fa fa-plus fa-5x\",\"css\":\"panel panel-green\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"AUTO/add_form\"}',1,'1','4','panel_btn'),(28,'کارتابل دریافتی',76,1,'0','کارتابل دریافتی','{\"icon\":\"fa fa-th fa-5x\",\"css\":\"panel panel-info\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"AUTO/kartable\"}',1,'1','4','panel_btn'),(29,'کارتابل ارجاعی',77,1,'0','کارتابل ارجاعی','{\"icon\":\"fa fa-arrow-circle-o-right fa-5x\",\"css\":\"panel panel-info\",\"root_css\":\"col-lg-3 col-md-6\",\"link\":\"AUTO/refer\"}',1,'1','4','panel_btn');
/*!40000 ALTER TABLE `jet_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_module_group`
--

DROP TABLE IF EXISTS `jet_module_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_module_group` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `des` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_module_group`
--

LOCK TABLES `jet_module_group` WRITE;
/*!40000 ALTER TABLE `jet_module_group` DISABLE KEYS */;
INSERT INTO `jet_module_group` VALUES (1,'icons','');
/*!40000 ALTER TABLE `jet_module_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_module_usergroup`
--

DROP TABLE IF EXISTS `jet_module_usergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_module_usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_group_id` (`user_group_id`),
  KEY `module_id` (`module_id`),
  KEY `position` (`position`),
  CONSTRAINT `module` FOREIGN KEY (`module_id`) REFERENCES `jet_module` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_group` FOREIGN KEY (`user_group_id`) REFERENCES `jet_usergroup_eemploy` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_module_usergroup`
--

LOCK TABLES `jet_module_usergroup` WRITE;
/*!40000 ALTER TABLE `jet_module_usergroup` DISABLE KEYS */;
INSERT INTO `jet_module_usergroup` VALUES (13,1,14,2),(14,1,12,3),(16,1,17,5);
/*!40000 ALTER TABLE `jet_module_usergroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_pay`
--

DROP TABLE IF EXISTS `jet_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maker_id` int(11) NOT NULL,
  `factor_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mode` varchar(1) NOT NULL COMMENT '+,-',
  `type` int(11) NOT NULL,
  `price` int(255) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `des` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maker_id` (`maker_id`),
  KEY `factor_id` (`factor_id`),
  KEY `tbl_pay_ibfk_1` (`user_id`),
  CONSTRAINT `factor-pay` FOREIGN KEY (`factor_id`) REFERENCES `jet_factor` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `jet_pay_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `jet_user` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_pay`
--

LOCK TABLES `jet_pay` WRITE;
/*!40000 ALTER TABLE `jet_pay` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_permision`
--

DROP TABLE IF EXISTS `jet_permision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_permision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `des` text DEFAULT NULL,
  `permision_group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `menu` int(11) DEFAULT 0,
  `menu_link` varchar(255) DEFAULT NULL,
  `menu_text` varchar(100) DEFAULT NULL,
  `menu_icon` varchar(50) DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  `params` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permision_group_id` (`permision_group_id`),
  KEY `order_by` (`order_by`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_permision`
--

LOCK TABLES `jet_permision` WRITE;
/*!40000 ALTER TABLE `jet_permision` DISABLE KEYS */;
INSERT INTO `jet_permision` VALUES (2,'افزودن فاکتور',1,'factor_add',1,'MaLi/Factor/add','','fa fa-plus',1,''),(3,'ویرایش فاکتور',1,'factor_edit',0,NULL,NULL,NULL,2,''),(4,'حذف فاکتور',1,'factor_delete',0,NULL,NULL,NULL,3,''),(5,'ثبت هزینه حمل',1,'factor_add_transfer_pay',0,NULL,NULL,NULL,4,''),(6,'مشاهده همه فاکتورها',1,'factor_view_all',1,'MaLi/factor_sell/manage_factor/index/public',' مشاهده همه فاکتورها ی کاربران   ','fa fa-table',5,''),(7,'ویرایش هزینه حمل',1,'factor_add_transfer_pay',0,NULL,NULL,NULL,6,''),(8,'ثبت پرداخت فاکتور',1,'factor_add_pay',0,NULL,NULL,NULL,7,''),(9,'ویرایش پرداخت فاکتور',1,'factor_edit_pay',0,NULL,NULL,NULL,8,''),(10,'ثبت سریع بازگشت فروش پنجره بازشو سریع جهت ثبت فاکتور بازگشت در خصوص همان فاکتور ',1,'factor_reject',0,NULL,NULL,NULL,9,''),(11,'چاپ فاکتور خروجی pdf',1,'factor_pdf',0,NULL,NULL,NULL,10,''),(16,'افزودن کاربر',3,'user_add',0,NULL,NULL,NULL,1,''),(17,'وبرایش کاربر',3,'user_edit',0,NULL,NULL,NULL,2,''),(18,'حذف کاربر',3,'user_delete',0,NULL,NULL,NULL,3,''),(19,'مشاهده همه کاربران در قسمتها از جمله افزودن فاکتور',3,'user_view_all',0,NULL,NULL,NULL,4,''),(20,'افزودن کارمند',4,'eemploy_add',0,NULL,NULL,NULL,1,''),(21,'ویرایش کارمندان',4,'eemploy_edit',0,NULL,NULL,NULL,2,NULL),(22,'حذف کارمندان',4,'eemploy_delete',0,NULL,NULL,NULL,3,NULL),(23,'مدیریت سطح دسترسی',4,'eemploy_permision',0,NULL,NULL,NULL,4,NULL),(24,'افزودن محصولات',1,'prd_add',0,NULL,NULL,NULL,11,NULL),(25,'ویرایش محصولات',1,'prd_edit',0,NULL,NULL,NULL,12,NULL),(26,'حذف محصولات',1,'prd_delete',0,NULL,NULL,NULL,13,NULL),(28,'فروش',1,'menu_sell',0,NULL,NULL,NULL,14,NULL),(29,'محصولات و کمیسیون',2,'menu_prd_com',1,'MaLi/pprd/Prd_commision','نحوه محاسبه کمیسیونها',NULL,4,NULL),(30,'گزارشات',7,'menu_report',0,NULL,NULL,NULL,1,NULL),(31,'مشتریان من',3,'crm_my_client',1,'CRM/my_client','پنل مشتریان من(بلفل و بلقوه)','fa fa-users',5,NULL),(32,'کارشناسان فروش',3,'crm_my_seller',1,'CRM/my_employ','پنل کارشناسان فروش','fa fa-bank',7,NULL),(33,'تعاریف',4,'menu_define',0,NULL,NULL,NULL,6,NULL),(34,'تاریخ',4,'menu_date',0,NULL,NULL,NULL,7,NULL),(35,'مدیریت پیغامها',9,'message_manage',0,NULL,NULL,NULL,1,NULL),(36,'مدیریت کارها',10,'dashboard_task',0,NULL,NULL,NULL,2,NULL),(37,'مشتریان من ',3,'dashboard_myclient',0,NULL,NULL,NULL,6,NULL),(39,'مشتریان بالقوه ',3,'dashboard_belghove',0,NULL,NULL,NULL,7,NULL),(40,'مشتریان بالفغل ',3,'dashboard_belfel',0,NULL,NULL,NULL,8,NULL),(41,'کمیسیون کارشناسان (لیست مبلغ کمیسیون کارشناسان)',2,'dashboard_com',0,NULL,NULL,NULL,1,NULL),(42,'فاکتورهای فروش ',1,'dashboard_factor',0,NULL,NULL,NULL,17,NULL),(44,'فاکتور های فروش تمامی کاربران ',1,'dashboard_factorallfactor',0,NULL,NULL,NULL,18,NULL),(45,'انبار ',1,'dashboard_stock',0,NULL,NULL,NULL,1,NULL),(46,'مدیریت انبار',1,'stock_manage',1,'Stock/Stock',' موجودی و انبار  ','fa fa-cubes',11,NULL),(47,'سررسیدها شخص ',2,'dashboard_expirefactor',0,NULL,NULL,NULL,3,NULL),(48,' مدیریت کارشناسان فروش   ',1,'dashboard_sellerhesabdar',0,NULL,NULL,NULL,8,NULL),(49,'مدیریت کمیسیونها',2,'dashboard_comhesabdar',1,'MaLi/comision/Manage_comision','',NULL,5,NULL),(50,'در خواست ها مدیریت ',10,'dashboard_request',0,NULL,NULL,NULL,1,NULL),(51,'مدیریت کل کاربران ',3,'dashboad_alluser',0,NULL,NULL,NULL,9,NULL),(52,' مانده حداقل فروش ',2,'dashboard_min_pay',0,NULL,NULL,NULL,5,NULL),(53,'فاکتور های بدهکار ',2,'dashboard_bedehkar_factor',0,NULL,NULL,NULL,6,NULL),(54,'هزینه حمل ',2,'dashboard_hazine_haml',0,NULL,NULL,NULL,7,NULL),(55,'پروماتور',3,'crm_manage_promator',1,'/CRM/Promoter/manage',NULL,NULL,10,NULL),(56,'سررسیدهای کل با رنگ بندی خاص ',2,'dashboard_expireall',0,NULL,NULL,NULL,8,NULL),(57,'عملیات حسابداری مشتریان ',2,'sell_accounting_clients',1,'CRM/my_client/acounting','','fa fa-dollar',1,NULL),(58,'عملیات پایه پرداخت و دریافت پول',1,'base_accounting',0,'','',NULL,2,NULL),(59,'تنظیمات کلی برنامه',7,'base_setting',1,'setting','',NULL,1,NULL),(60,'عملیات بکاپ',7,'base_backup',1,'Backup_main','برون ریزی','fa fa-download',4,NULL),(62,'پنل کارکشتگان',10,'base_karkoshtegan',0,NULL,NULL,NULL,1,NULL),(63,'مدیریت چکها',2,'sell_listchecks',1,'MaLi/Bed_bes/list_checks','','fa fa-bank',3,NULL),(64,'پنل ورود اطلاعات',8,'auto_form_add',1,'AUTO/add_form','ورود اطلاعات','fa fa-plus',1,''),(65,'ویرایش نمودن فرم',8,'auto_form_edit',0,NULL,NULL,NULL,2,''),(66,'حذف نمودن فرم',8,'auto_form_delete',0,NULL,NULL,NULL,3,''),(67,'لیست فاکتور های شخص',1,'factor_my',1,'MaLi/factor_sell/manage_factor/index/private',' فاکتور های من    ','fa fa-bars',1,''),(68,'لیست فاکتور های سررسید شده',1,'factor_expired',1,'MaLi/factor_sell/manage_factor/expire_all',NULL,NULL,10,''),(69,'مدیریت کالا و محصولات',7,'prd_manage',1,'MaLi/pprd/prd/manage','','fa fa-cube',12,NULL),(70,'مدیریت مشتریان من',3,'crm_manage_client',1,'MaLi/pusers/users/manage','','fa fa-user',6,NULL),(71,'مدیریت همه اشخاص',3,'crm_manage_client_all',1,'MaLi/pusers/users/manage_all','','fa fa-users',6,NULL),(72,'مدیریت کاربران و کارمندان',7,'eemploy_manage',1,'eemploy/eemploy/manage','','fa fa-users',3,NULL),(73,'لاگ سیستمی کاربران',7,'base_user_log',1,'CRM/Report_system_log','لاگ سیستمی کاربران','fa fa-list-alt',5,NULL),(74,'لیست گزارش کار کاربران',3,'base_user_reports',1,'CRM/Report_work/report_list','مدیریت گزارش کار کارمندان','fa fa-list',11,NULL),(75,'افزودن گزارش کار من',3,'base_user_reports_add',1,'CRM/Report_work/report_add','افزودن گزارش کار من','fa fa-plus',12,NULL),(76,'کارتابل دریافتی',8,'auto_manage_kartable',1,'AUTO/kartable','',NULL,3,''),(77,'کارتابل ارجاعی',8,'auto_manage_refers',1,'AUTO/refer','','fa fa-arrow-circle-o-right',3,''),(78,'انبار گردانی',1,'stock_check',0,'','','',0,NULL),(79,'مدیریت ورودی انبار',1,'stock_in',0,'','','',0,NULL),(80,'مدیریت خروجی انبار',1,'stock_out',0,'','','',0,NULL),(81,'تولید و چاپ حواله انبار',1,'stock_recipe',0,'','','',0,NULL),(82,'ارسال پیغام',9,'message_send',0,NULL,NULL,NULL,1,NULL),(83,'همه پیغامهای سیستم',9,'message_all',0,NULL,NULL,NULL,1,NULL),(84,'لیست پیغامهای ارسالی',9,'message_outbox',0,NULL,NULL,NULL,1,NULL),(85,'گزارش گیری',8,'auto_report',1,'AUTO/report/report_main','گزارش گیری عمومی اتوماسیون','fa fa-list',4,''),(86,'امکان تغییر اطلاعات پس از تایید',8,'auto_edit_after_accepted',0,'','','',4,''),(87,'امکان ارجاع اطلاعات',8,'auto_refer',0,'','','',4,''),(88,'امکان مرجوع اطلاعات',8,'auto_reject',0,'','','',4,''),(89,'امکان تایید و دسترسی اطلاعات واحد  درکارتابل',8,'auto_accept',0,'','','',4,''),(90,'امکان تایید و دسترسی اطلاعات همه واحد ها \nدرکارتابل',8,'auto_accept_all',0,'','','',4,''),(91,'امکان مشاهده همه ارجاع ها در کارتابل',8,'auto_view_all',0,'','','',4,''),(92,'مدیریت فرمها',8,'auto_manage_form',1,'AUTO/manage_form/manage','مدیریت فرم ساز','fa fa-list',4,''),(93,'افزودن رقیبان',3,'rival_add',0,NULL,NULL,NULL,13,NULL),(94,'ویرایش رقیبان',3,'rival_edit',0,NULL,NULL,NULL,13,NULL),(95,'حذف رقیبان',3,'rival_delete',0,NULL,NULL,NULL,13,NULL),(96,'مدیریت رقیبان',3,'rival_manage',1,'CRM/Rival/manage','مدیریت رقیبان','fa fa-users',13,NULL),(97,'امکان حذف همه ارجاعات',8,'auto_refer_delete',0,'','','',4,''),(98,'افزودن مشتری بالقوه',3,'tmp_user_add',0,NULL,NULL,NULL,5,''),(99,'ویرایش مشتری بالقوه',3,'tmp_user_edit',0,NULL,NULL,NULL,5,''),(100,'حذف مشتری بالقوه',3,'tmp_user_delete',0,NULL,NULL,NULL,5,''),(101,'مدیریت تعاریف مشتریان بالقوه(نوع و وضعیتها و...)',3,'tmp_user_manage_define',0,NULL,NULL,NULL,5,''),(102,'آپلود کاربر',3,'user_upload',0,NULL,NULL,NULL,1,''),(103,'مدیدریت تولید کنندگان و شرکتها',3,'crm_manage_company',1,'CRM/Company/manage','','fa fa-users',6,NULL),(104,'مدیریت کشورها',7,'country_manage',1,'Setting/manage_country','','fa fa-users',3,NULL),(105,'مدیریت رسانه ها',11,'media_manage',1,'Media/manage','مدیریت همه رسانه ها','fa fa-upload',1,NULL),(106,'رسانه های من',11,'media_my_manage',1,'Media/manage/my','مدیریت رسانه های من','fa fa-upload',1,NULL),(107,'افزودن رسانه',11,'media_add',NULL,'',NULL,NULL,NULL,NULL),(108,'ویرایش و حذف همه رسانه ها',11,'media_edit',NULL,'',NULL,NULL,NULL,NULL),(109,'مدیریت پروژه',12,'project_manage',1,'Project/manage','مدیریت پروژه ها','fa fa-sitemap',1,NULL),(110,'پروژه جدید',12,'project_add',NULL,NULL,NULL,NULL,NULL,NULL),(111,'ویرایش پروژه',12,'project_edit',NULL,NULL,NULL,NULL,NULL,NULL),(112,'حذف پروژه',12,'project_delete',NULL,NULL,NULL,NULL,NULL,NULL),(113,'مدیریت لیست انجام ',12,'project_todo',1,'project/list_todo','مدیریت لیست انجام پروژه ها','fa fa-list-ol',10,NULL),(114,'مدیریت لیست کامنتها ',12,'project_comments',1,'project/list_comments','لیست کامنتهای پروژهها','fa fa-comments',11,NULL),(115,'مدیریت دسته بندی رسانه ها',11,'media_manage_group',1,'media/manage_group','مدیریت دسته بندی رسانه ها','fa fa-object-group',10,NULL);
/*!40000 ALTER TABLE `jet_permision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_permision_group`
--

DROP TABLE IF EXISTS `jet_permision_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_permision_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `des` varchar(200) DEFAULT NULL,
  `lisence` int(11) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `menu` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_permision_group`
--

LOCK TABLES `jet_permision_group` WRITE;
/*!40000 ALTER TABLE `jet_permision_group` DISABLE KEYS */;
INSERT INTO `jet_permision_group` VALUES (1,'__SELL','فروش و مالی',1,'fa fa-shopping-cart',1),(2,'__SELL_ACCOUNTING','حسابداری',1,'fa fa-money',1),(3,'__CRM',' مدیریت اشخاص  و روابط اشخاص',1,'fa fa-star',1),(4,'__EEMPLOYERS','کاربران و کارمندان',1,'fa fa-bank',0),(7,'__BASE','تنظیمات پایه',1,'fa fa-cogs',1),(8,'__BPM','اتوماسیون و فرم ها',1,'fa fa-file',1),(9,'__MESSAGE','پیغام',1,'fa fa-comment',0),(10,'__TASK','کار',1,'fa fa-tasks',0),(11,'__MEDIA','مدیریت رسانه',1,'fa fa-upload',1),(12,'__PROJECT','مدیریت پروژه',1,'fa fa-sitemap',1);
/*!40000 ALTER TABLE `jet_permision_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_permision_usergroup`
--

DROP TABLE IF EXISTS `jet_permision_usergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_permision_usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usergroup_id` int(11) NOT NULL,
  `permision_id` int(11) NOT NULL,
  `expire` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`usergroup_id`),
  KEY `permision_id` (`permision_id`),
  CONSTRAINT `permision_fk` FOREIGN KEY (`permision_id`) REFERENCES `jet_permision` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `usergroup_permisoion` FOREIGN KEY (`usergroup_id`) REFERENCES `jet_usergroup_eemploy` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5882 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_permision_usergroup`
--

LOCK TABLES `jet_permision_usergroup` WRITE;
/*!40000 ALTER TABLE `jet_permision_usergroup` DISABLE KEYS */;
INSERT INTO `jet_permision_usergroup` VALUES (4790,5,2,NULL),(4791,5,3,NULL),(4792,5,4,NULL),(4793,5,45,NULL),(4794,5,46,NULL),(4795,5,69,NULL),(4796,5,78,NULL),(4797,5,79,NULL),(4798,5,80,NULL),(4799,5,16,NULL),(4800,5,17,NULL),(4801,5,18,NULL),(4802,5,19,NULL),(4803,5,71,NULL),(4804,5,98,NULL),(4805,5,34,NULL),(5790,1,2,NULL),(5791,1,3,NULL),(5792,1,4,NULL),(5793,1,5,NULL),(5794,1,6,NULL),(5795,1,7,NULL),(5796,1,8,NULL),(5797,1,9,NULL),(5798,1,10,NULL),(5799,1,11,NULL),(5800,1,24,NULL),(5801,1,25,NULL),(5802,1,26,NULL),(5803,1,28,NULL),(5804,1,44,NULL),(5805,1,45,NULL),(5806,1,46,NULL),(5807,1,48,NULL),(5808,1,58,NULL),(5809,1,67,NULL),(5810,1,68,NULL),(5811,1,69,NULL),(5812,1,78,NULL),(5813,1,79,NULL),(5814,1,80,NULL),(5815,1,81,NULL),(5816,1,16,NULL),(5817,1,17,NULL),(5818,1,18,NULL),(5819,1,19,NULL),(5820,1,31,NULL),(5821,1,32,NULL),(5822,1,37,NULL),(5823,1,39,NULL),(5824,1,51,NULL),(5825,1,71,NULL),(5826,1,74,NULL),(5827,1,75,NULL),(5828,1,93,NULL),(5829,1,94,NULL),(5830,1,95,NULL),(5831,1,96,NULL),(5832,1,98,NULL),(5833,1,99,NULL),(5834,1,100,NULL),(5835,1,101,NULL),(5836,1,102,NULL),(5837,1,103,NULL),(5838,1,20,NULL),(5839,1,21,NULL),(5840,1,22,NULL),(5841,1,23,NULL),(5842,1,33,NULL),(5843,1,34,NULL),(5844,1,30,NULL),(5845,1,59,NULL),(5846,1,60,NULL),(5847,1,72,NULL),(5848,1,73,NULL),(5849,1,104,NULL),(5850,1,64,NULL),(5851,1,65,NULL),(5852,1,66,NULL),(5853,1,76,NULL),(5854,1,77,NULL),(5855,1,85,NULL),(5856,1,86,NULL),(5857,1,87,NULL),(5858,1,88,NULL),(5859,1,89,NULL),(5860,1,90,NULL),(5861,1,91,NULL),(5862,1,92,NULL),(5863,1,97,NULL),(5864,1,35,NULL),(5865,1,82,NULL),(5866,1,83,NULL),(5867,1,84,NULL),(5868,1,36,NULL),(5869,1,50,NULL),(5870,1,62,NULL),(5871,1,105,NULL),(5872,1,106,NULL),(5873,1,107,NULL),(5874,1,108,NULL),(5875,1,115,NULL),(5876,1,109,NULL),(5877,1,110,NULL),(5878,1,111,NULL),(5879,1,112,NULL),(5880,1,113,NULL),(5881,1,114,NULL);
/*!40000 ALTER TABLE `jet_permision_usergroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_prd`
--

DROP TABLE IF EXISTS `jet_prd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_prd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '0' COMMENT 'name',
  `price1` varchar(100) DEFAULT '0',
  `price2` varchar(100) DEFAULT '0',
  `price3` varchar(100) DEFAULT '0',
  `price4` varchar(100) DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT 0 COMMENT 'fk for group',
  `state` tinyint(1) DEFAULT 1,
  `vahed_asli` int(11) DEFAULT NULL COMMENT 'fk for vahed(unit)',
  `url` varchar(150) DEFAULT '#' COMMENT 'web site addres for this prd',
  `tax` int(11) DEFAULT 0 COMMENT 'fk for tax',
  `company` varchar(100) DEFAULT NULL COMMENT 'company name',
  `pic` varchar(255) DEFAULT NULL COMMENT 'src picture',
  `file` varchar(255) DEFAULT NULL COMMENT 'file  for prd',
  `barcode` varchar(255) DEFAULT NULL COMMENT 'barcode',
  `country` int(11) DEFAULT NULL COMMENT 'fk',
  `order_by` int(5) DEFAULT 0,
  `row_plus` varchar(255) DEFAULT NULL COMMENT 'add to factor for other des of prd',
  `out_stack_alert` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group-id` (`group_id`),
  KEY `vahed_asli` (`vahed_asli`),
  CONSTRAINT `unit` FOREIGN KEY (`vahed_asli`) REFERENCES `jet_mali_prd_unit` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_prd`
--

LOCK TABLES `jet_prd` WRITE;
/*!40000 ALTER TABLE `jet_prd` DISABLE KEYS */;
INSERT INTO `jet_prd` VALUES (13,'pack1','100','0','0','0',6,1,2,'#',0,NULL,NULL,NULL,NULL,NULL,1,'',10),(14,'pack2','200','0','0','0',6,1,2,'#',0,NULL,NULL,NULL,NULL,NULL,0,'',0),(15,'pack3','300','0','0','0',6,1,2,'#',0,NULL,NULL,NULL,NULL,NULL,0,'',0);
/*!40000 ALTER TABLE `jet_prd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_prd_group`
--

DROP TABLE IF EXISTS `jet_prd_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_prd_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `parent` int(11) DEFAULT NULL COMMENT 'parent group',
  `state` int(11) NOT NULL DEFAULT 1 COMMENT 'publish or unpublish',
  `des` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_prd_group_tbl_prd_group_id_fk` (`parent`),
  CONSTRAINT `tbl_prd_group_tbl_prd_group_id_fk` FOREIGN KEY (`parent`) REFERENCES `jet_prd_group` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_prd_group`
--

LOCK TABLES `jet_prd_group` WRITE;
/*!40000 ALTER TABLE `jet_prd_group` DISABLE KEYS */;
INSERT INTO `jet_prd_group` VALUES (6,'group',NULL,1,'test');
/*!40000 ALTER TABLE `jet_prd_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_project`
--

DROP TABLE IF EXISTS `jet_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `des` text DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `maker_id` int(11) NOT NULL,
  `todo_date` datetime DEFAULT NULL,
  `doing_date` datetime DEFAULT NULL,
  `done_date` datetime DEFAULT NULL,
  `point_date` datetime DEFAULT NULL,
  `trash` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='manage project table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_project`
--

LOCK TABLES `jet_project` WRITE;
/*!40000 ALTER TABLE `jet_project` DISABLE KEYS */;
INSERT INTO `jet_project` VALUES (9,'test project','2020-03-23 19:23:54','test project','todo',16,'2020-03-23 02:53:54',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `jet_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_project_comments`
--

DROP TABLE IF EXISTS `jet_project_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_project_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `maker_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `replay` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `maker_id` (`maker_id`),
  KEY `date` (`date`),
  KEY `replay` (`replay`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_project_comments`
--

LOCK TABLES `jet_project_comments` WRITE;
/*!40000 ALTER TABLE `jet_project_comments` DISABLE KEYS */;
INSERT INTO `jet_project_comments` VALUES (10,7,16,'پروژه مدیریت پروژه','2019-03-16 15:50:02',NULL),(11,9,16,'سلام انجام شد','2019-03-21 23:08:04',NULL);
/*!40000 ALTER TABLE `jet_project_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_project_company`
--

DROP TABLE IF EXISTS `jet_project_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_project_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_project_company`
--

LOCK TABLES `jet_project_company` WRITE;
/*!40000 ALTER TABLE `jet_project_company` DISABLE KEYS */;
INSERT INTO `jet_project_company` VALUES (1,7,2,'2019-03-16 10:41:26'),(2,8,2,'2019-03-20 03:42:44'),(3,9,2,'2019-03-21 23:10:02');
/*!40000 ALTER TABLE `jet_project_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_project_prd`
--

DROP TABLE IF EXISTS `jet_project_prd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_project_prd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `prd_id` int(11) NOT NULL,
  `des` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_project_prd`
--

LOCK TABLES `jet_project_prd` WRITE;
/*!40000 ALTER TABLE `jet_project_prd` DISABLE KEYS */;
INSERT INTO `jet_project_prd` VALUES (1,3,0,NULL,'2019-03-13 09:23:17'),(2,7,9,NULL,'2019-03-16 10:39:47'),(3,8,9,NULL,'2019-03-20 03:42:34'),(4,9,8,NULL,'2019-03-21 23:09:53');
/*!40000 ALTER TABLE `jet_project_prd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_project_todo`
--

DROP TABLE IF EXISTS `jet_project_todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_project_todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(100) NOT NULL,
  `des` text DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `to_user` int(11) DEFAULT NULL,
  `maker_id` int(11) NOT NULL,
  `done` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_project_todo`
--

LOCK TABLES `jet_project_todo` WRITE;
/*!40000 ALTER TABLE `jet_project_todo` DISABLE KEYS */;
INSERT INTO `jet_project_todo` VALUES (1,9,'2020-07-10 05:14:03','تست',NULL,NULL,NULL,16,1);
/*!40000 ALTER TABLE `jet_project_todo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_project_user`
--

DROP TABLE IF EXISTS `jet_project_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_project_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `maker_id` int(11) NOT NULL,
  `share` varchar(50) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_project_user`
--

LOCK TABLES `jet_project_user` WRITE;
/*!40000 ALTER TABLE `jet_project_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_project_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_sessions`
--

DROP TABLE IF EXISTS `jet_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`),
  KEY `ip_address` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_sessions`
--

LOCK TABLES `jet_sessions` WRITE;
/*!40000 ALTER TABLE `jet_sessions` DISABLE KEYS */;
INSERT INTO `jet_sessions` VALUES ('7mhgqn2f65a06hk72pem6ebk6t2ied8p','127.0.0.1',1611262177,'__ci_last_regenerate|i:1611262177;'),('n05urcrosq3qfv4o0jafu768hncado0s','127.0.0.1',1611347528,'__ci_last_regenerate|i:1611347528;user|O:8:\"stdClass\":24:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:13:\"administrator\";s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:32:\"1855054556aee87ee2d81afe4120a58e\";s:7:\"reagent\";s:21:\"پیروز جنابی\";s:5:\"email\";s:23:\"jenabi.pirooz@gmail.com\";s:6:\"mobile\";s:11:\"09130878009\";s:4:\"tell\";s:11:\"03136736744\";s:3:\"sex\";s:1:\"1\";s:7:\"profile\";s:0:\"\";s:11:\"date_create\";s:19:\"2020-02-25 00:00:00\";s:11:\"date_expire\";N;s:7:\"address\";s:90:\"اصفهان بهارستان خیابان مهتاب10 خیابان بدر 8 پلاک 557\";s:11:\"postal_code\";s:3:\"123\";s:9:\"usergroup\";s:1:\"1\";s:8:\"maker_id\";s:2:\"16\";s:6:\"parent\";N;s:5:\"state\";s:1:\"1\";s:7:\"meli_id\";s:10:\"1270550365\";s:5:\"extra\";N;s:7:\"last_ip\";N;s:9:\"last_time\";N;s:8:\"birthday\";s:19:\"0000-00-00 00:00:00\";s:10:\"limit_sell\";s:1:\"0\";}'),('nmumcltbvrk3etuao6hrdr8ratfl4fvc','127.0.0.1',1611348970,'__ci_last_regenerate|i:1611348970;user|O:8:\"stdClass\":24:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:13:\"administrator\";s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:32:\"1855054556aee87ee2d81afe4120a58e\";s:7:\"reagent\";s:21:\"پیروز جنابی\";s:5:\"email\";s:23:\"jenabi.pirooz@gmail.com\";s:6:\"mobile\";s:11:\"09130878009\";s:4:\"tell\";s:11:\"03136736744\";s:3:\"sex\";s:1:\"1\";s:7:\"profile\";s:0:\"\";s:11:\"date_create\";s:19:\"2020-02-25 00:00:00\";s:11:\"date_expire\";N;s:7:\"address\";s:90:\"اصفهان بهارستان خیابان مهتاب10 خیابان بدر 8 پلاک 557\";s:11:\"postal_code\";s:3:\"123\";s:9:\"usergroup\";s:1:\"1\";s:8:\"maker_id\";s:2:\"16\";s:6:\"parent\";N;s:5:\"state\";s:1:\"1\";s:7:\"meli_id\";s:10:\"1270550365\";s:5:\"extra\";N;s:7:\"last_ip\";N;s:9:\"last_time\";N;s:8:\"birthday\";s:19:\"0000-00-00 00:00:00\";s:10:\"limit_sell\";s:1:\"0\";}'),('o1jia7438e3j0lrci2fkda8c715tp72c','127.0.0.1',1611348351,'__ci_last_regenerate|i:1611348351;user|O:8:\"stdClass\":24:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:13:\"administrator\";s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:32:\"1855054556aee87ee2d81afe4120a58e\";s:7:\"reagent\";s:21:\"پیروز جنابی\";s:5:\"email\";s:23:\"jenabi.pirooz@gmail.com\";s:6:\"mobile\";s:11:\"09130878009\";s:4:\"tell\";s:11:\"03136736744\";s:3:\"sex\";s:1:\"1\";s:7:\"profile\";s:0:\"\";s:11:\"date_create\";s:19:\"2020-02-25 00:00:00\";s:11:\"date_expire\";N;s:7:\"address\";s:90:\"اصفهان بهارستان خیابان مهتاب10 خیابان بدر 8 پلاک 557\";s:11:\"postal_code\";s:3:\"123\";s:9:\"usergroup\";s:1:\"1\";s:8:\"maker_id\";s:2:\"16\";s:6:\"parent\";N;s:5:\"state\";s:1:\"1\";s:7:\"meli_id\";s:10:\"1270550365\";s:5:\"extra\";N;s:7:\"last_ip\";N;s:9:\"last_time\";N;s:8:\"birthday\";s:19:\"0000-00-00 00:00:00\";s:10:\"limit_sell\";s:1:\"0\";}'),('rlc3okf40cvbedtmivhl53jj6nrak5s7','127.0.0.1',1611349172,'__ci_last_regenerate|i:1611348970;user|O:8:\"stdClass\":24:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:13:\"administrator\";s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:32:\"1855054556aee87ee2d81afe4120a58e\";s:7:\"reagent\";s:21:\"پیروز جنابی\";s:5:\"email\";s:23:\"jenabi.pirooz@gmail.com\";s:6:\"mobile\";s:11:\"09130878009\";s:4:\"tell\";s:11:\"03136736744\";s:3:\"sex\";s:1:\"1\";s:7:\"profile\";s:0:\"\";s:11:\"date_create\";s:19:\"2020-02-25 00:00:00\";s:11:\"date_expire\";N;s:7:\"address\";s:90:\"اصفهان بهارستان خیابان مهتاب10 خیابان بدر 8 پلاک 557\";s:11:\"postal_code\";s:3:\"123\";s:9:\"usergroup\";s:1:\"1\";s:8:\"maker_id\";s:2:\"16\";s:6:\"parent\";N;s:5:\"state\";s:1:\"1\";s:7:\"meli_id\";s:10:\"1270550365\";s:5:\"extra\";N;s:7:\"last_ip\";N;s:9:\"last_time\";N;s:8:\"birthday\";s:19:\"0000-00-00 00:00:00\";s:10:\"limit_sell\";s:1:\"0\";}');
/*!40000 ALTER TABLE `jet_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_setting`
--

DROP TABLE IF EXISTS `jet_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'name of setting',
  `value` text DEFAULT NULL COMMENT 'value of setting',
  `des` varchar(255) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `type` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_settings` (`group_id`),
  CONSTRAINT `group_settings` FOREIGN KEY (`group_id`) REFERENCES `jet_setting_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_setting`
--

LOCK TABLES `jet_setting` WRITE;
/*!40000 ALTER TABLE `jet_setting` DISABLE KEYS */;
INSERT INTO `jet_setting` VALUES (1,'login_title','JET','هدر در لوگین',3,'{\"type\":\"text\"} '),(2,'home','Dashboard','کنترلر پیش فرض',1,'{\"type\":\"text\"} '),(3,'homename',' داشبورد مدیریت','نام خانه در منو ها',1,'{\"type\":\"text\"} '),(4,'perfix_factor',' j ','پیش وند فاکتور',2,'{\"type\":\"text\"} '),(5,'perfix_user','J-','پیش وند مشتریان',5,'{\"type\":\"text\"} '),(8,'perfix_peigiri','J-','پیشوند پیگیری',1,'{\"type\":\"text\"} '),(9,'show_per_carton','0','نمایش تعداد در هر کارتن ',2,'{\"type\":\"select_bool\"} '),(10,'show_unit','0','نمایش واحد  ',2,'{\"type\":\"select_bool\"} '),(11,'show_unit_alt','1','نمایش تعداد',2,'{\"type\":\"select_bool\"} '),(12,'show_code_prd','1','نمایش کد کالا در فاکتور',2,'{\"type\":\"select_bool\"} '),(13,'show_des_prd','1','نمایش شرح کالا',2,'{\"type\":\"select_bool\"} '),(14,'show_price','1','نمایش قیمت واحد',2,'{\"type\":\"select_bool\"} '),(15,'show_total_price','1','نمایش قیمت کل',2,'{\"type\":\"select_bool\"} '),(16,'show_unit_main','1','نمایش تعداد اصلی',2,'{\"type\":\"select_bool\"} '),(17,'perfix_main_unit_fa','(عدد)','پسوند تعداد  فارسی',2,'{\"type\":\"text\"}'),(18,'perfix_main_unit_en','(num)',' پسوند تعداد  انگلیسی ',2,'{\"type\":\"text\"}'),(19,'title_fa','1','نمایش سرتیتر جداول در محصولات',2,'{\"type\":\"select_bool\"} '),(20,'title_en','1','نمایش سرتیتر جداول در محصولات',2,'{\"type\":\"select_bool\"} '),(21,'perfix_alt_unit_en','(carton)','پسوند واحد فرعی انگلیسی',2,'{\"type\":\"text\"}'),(22,'perfix_alt_unit_fa','(کارتن)','پسوند واحد فرعی فارسی',2,'{\"type\":\"text\"}'),(23,'show_off','1','نمایش تخفیف',2,'{\"type\":\"select_bool\"} '),(26,'company_url','http://www.piero.ir','آدرس سایت سازمان',1,'{\"type\":\"text\"}'),(27,'company_name','JET','نام سازمان',1,'{\"type\":\"textarea\"}'),(29,'enable_admin_see_all_emply','1',' مشاهده تمامی کارشناسان توسط مدیر ',1,'{\"type\":\"select_bool\"} '),(30,'defualt_selluser_group','[3,8]','گروه پیش فرض کارشناسان فروش',3,'{\"type\":\"text\"}'),(31,'enabel_alert_expire_factor','1','فعال بودن هشدار سررسید فاکتور برای کاربران خاص',2,'{\"type\":\"select_bool\"} '),(32,'expire_alerts_users_group','[4]','کاربرای برای هشدار سررسید فاکتور',2,'{\"type\":\"text\"}'),(33,'enable_commision','1','فعال بودن کمیسیون',2,'{\"type\":\"select_bool\"} '),(34,'commision_mode_overflow','3','محاسبه بالابود کمیسیون\r\n1-حساب نشود\r\n2-طبق حداکثر حساب شود\r\n3-کل بالا بود به کمیسیون اضافه شود',2,'{\"type\":\"text\"}'),(35,'def_user_group_after_convert','2','گروه کاربری پیش فرض بعد از تبدیل از مشتری بالفعل به بلقوه',3,'{\"type\":\"text\"}'),(36,'max_user_time_period','5','حداکثر تعداد بازه زمانی برای پیگیری مشتریان بالفعل ',3,'{\"type\":\"text\"}'),(37,'new_factor_alerts_users_group','[4,8]','گروه های کاربری برای هشدار فاکتور جدید',2,'{\"type\":\"text\"}'),(38,'backup_db','ftb,email','حالتهای بکاپ گیری بانک اطلاعاتی ftp و email',1,'{\"type\":\"text\"}'),(39,'mail_type','server','حالت ایمیل',1,'{\"type\":\"text\"}'),(40,'deafult_factor_level','0','سطح پیش فرض فاکتور',2,'{\"type\":\"text\"}'),(41,'deafult_reject_factor_level','4','پیش فرض سطح فاکتور برای بازگشت از خرید',2,'{\"type\":\"text\"}'),(42,'deafult_folder_img','ImG','فولدر پیشفرض تصاویر',2,'{\"type\":\"text\"}'),(43,'main_factor_level','1','نوع فاکتور اصلی',2,'{\"type\":\"text\"}'),(44,'show_client_price','1','مشاهده قیمت مصرف کننده در فاکتور',2,'{\"type\":\"select_bool\"}'),(45,'enable_factor_id_on_addfactor','1','فعال بودن شماره فاکتور در افزودن فاکتور',2,'{\"type\":\"select_bool\"} '),(46,'enable_ezafat','1','فعال بودن اضافات',2,'{\"type\":\"select_bool\"} '),(47,'enable_kosoorat','1','فعال بودن کسورات',2,'{\"type\":\"select_bool\"} '),(48,'limit_show_list','100','نعداد نمایش سطر در جداول',2,'{\"type\":\"text\"}'),(49,'dashboard_target','_parent ','باز شدن موارد داشبورد در تب جدید',1,'{\"type\":\"text\"}'),(50,'my_eemploy_target','_parent ','نحوه باز شدن موارد کارشناس فروش',1,'{\"type\":\"text\"}'),(51,'show_comision_list_factor','1','مشاهده شدن جمع کمیسیون در لیست فاکتورها',2,'{\"type\":\"select_bool\"}'),(52,'show_zero_on_acounting_clients','1','مشاهده شدن مقادیر صفر در لیست حسابداری مشتریان',2,'{\"type\":\"select_bool\"} '),(53,'show_pay_on_factor_list','1',' مشاهده پرداخت در فاکتور ',2,'{\"type\":\"select_bool\"} '),(54,'disolay_stock_by_stock','1','مشاهده لیست انبار بر اساس طبقه بندی',4,'{\"type\":\"select_bool\"} '),(55,'display_eemployer_on_print_client_detials','0',' مشاهده نام کارمند در چاپ اطلاعات مشتری درصفحه لیست حسابداری ',6,'{\"type\":\"select_bool\"} '),(56,'print_logo','  <center> مثل جت سریع باش </center>     ','سربرگ چاپ',7,'{\"type\":\"textarea\"}'),(57,'start_day_week','friday',' روز قبل از شروع هفته به زبا انگلیسی ',1,'{\"type\":\"text\"}'),(58,'salary_this_mount_percent','0.037','میزان حقوق بر اساس فروش ماهیانه',3,'{\"type\":\"text\"}'),(59,'def_usergroup_recive_checku_alert','[8]','گرو های کاربری پیش فرض دریافت کننده هشدار چک',2,'{\"type\":\"text\"}'),(60,'deafult_checku_group','8','گروه کاربری پیش فرض چک در پرداخت',4,'{\"type\":\"text\"}'),(61,'deafult_pay_client_group','9','گروه پرداخت پیش فرض پرداخت نقدی مشتری',2,'{\"type\":\"text\"}'),(62,'update_link','http://www.piero.ir/crm/update','منبع بروز رسانی',1,'{\"type\":\"text\"}'),(63,'curent_version','1','نسخه جاری',1,'{\"type\":\"label\"}'),(64,'form_number_mode','iso','حالت گرفتن شماره فرم در اتوماسیون (iso = همه شماره ها پشت سر هم) (normal= هر نوع پشت سر هم)',8,'{\"type\":\"text\"}'),(65,'login_random_texts','   [\"در افزودن فاکتور لطفا دقت نمایید\",\"کاغذ های باطله را دور نریزید!!!\",\"لطفا در هنگام خروج از خاموش بودن سیستم خود اطمینان حاصل فرمایید\"] ','متن تصادفی در صفحه ورود',4,'{\"type\":\"textarea\"}'),(66,'login_slide_show','{\"0\":[\"/assets/img/slide1.jpg\",\"cando\",\"Free open source BPM / CRM\"],\"1\":[\"/assets/img/slide2.jpg\",\"always free\",\"use candoo free\"]}','اسلاید شو صفحه اول',4,'{\"type\":\"textarea\"}'),(67,'login_html_footer','<a class=\'btn2\' href=\'http://www.piero.ir\' >  گروه نرم افزاری پیرو </a> ','اجزای صفحه اول html',4,'{\"type\":\"textarea\"}'),(68,'auto_field_width','3','پیش فرض عرض برای ساخت فیلد',8,'{\"type\":\"text\"}'),(69,'auto_field_class','form-control ','کلاس پیش فرض برای ساخت فیلد',8,'{\"type\":\"text\"}'),(70,'auto_field_parent_class','row col-sm-4 ','کلاس پیش فرض برای ساخت طول کلی فیلد (row : برای حاشیه دادن)(col-sm-num طول فیلد که به جای num عدد 1 تا 12قرار می گیرد)',8,'{\"type\":\"text\"}'),(71,'auto_field_style','width:100% ','کدهای css جهت سفارشی سازی المنت',8,'{\"type\":\"text\"}'),(72,'def_upload_path','./uploads/','مکان پیش فرض جهت آپلود فایلها',1,'{\"type\":\"text\"}'),(73,'def_upload_type','gif|jpg|png|zip|rar|tiff|jpeg|pdf','نوع فایلهای قابل آپلود',1,'{\"type\":\"text\"}'),(74,'def_upload_max_size',' 100000 ','حداکثر حجم آپلود',1,'{\"type\":\"text\"}'),(75,'def_upload_max_width',' 3000  ','حداکثر عرض آپلود',1,'{\"type\":\"text\"}'),(76,'def_upload_max_height','2000','حداکثر طول آپلود',1,'{\"type\":\"text\"}'),(77,'def_comision_group','4','گروه پیش فرض کمیسیون',2,'{\"type\":\"text\"}'),(78,'company_name_min','  jet  ','نام مخفف سازمان',1,'{\"type\":\"text\"}'),(79,'main_factor_levels','[1,7]','انواع فاکتور اصلی (توانای انتخاب جمعی)',2,'{\"type\":\"text\"}'),(80,'enable_limit_sell','1','فعال بودن حداقل فروش برای کارمندان و کاربران',2,'{\"type\":\"select_bool\"}'),(81,'enable_auto_refer','1','فعال شدن سیستم اتوماتیک ارجاع (پس از ذخیره برای همه ارجاع شود)',8,'{\"type\":\"select_bool\"}'),(82,'dashboard_bg','ImG/dashboardbg.jpg','عکس پس زمینه داشبورد',8,'{\"type\":\"text\"}'),(83,'max_lenght_number','17','حداکثر تعداد طول ورودی اعداد',8,'{\"type\":\"text\"}'),(84,'shpw_ci_render_time','1','نمایش زمان رندر صفحه در پایین صفحات',1,'{\"type\":\"select_bool\"}'),(85,'enable_prd_pricing','1','فعال شدن قیمت گزاری در محصولات',2,'{\"type\":\"select_bool\"}'),(86,'default_status_project','todo','نوع پیش فرض پروژه',9,'{\"type\":\"select_bool\"}'),(88,'enable_factor_expire_date','1','فعال بودن تاریخ سررسید فاکتور',2,'{\"type\":\"select_bool\"}'),(89,'factor_day_expire_date',' 60','زمان پیشفرض تاریخ سررسید در فاکتور برحسب روز',2,'{\"type\":\"text\"}');
/*!40000 ALTER TABLE `jet_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_setting_group`
--

DROP TABLE IF EXISTS `jet_setting_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_setting_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `permision_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_setting_group_tbl_permision_group_id_fk` (`permision_group`),
  CONSTRAINT `tbl_setting_group_tbl_permision_group_id_fk` FOREIGN KEY (`permision_group`) REFERENCES `jet_permision_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_setting_group`
--

LOCK TABLES `jet_setting_group` WRITE;
/*!40000 ALTER TABLE `jet_setting_group` DISABLE KEYS */;
INSERT INTO `jet_setting_group` VALUES (1,'  تنظیمات عمومی سیستم و روند اجرایی',7),(2,' کلیه تنظیمات مالی و حسابداری',1),(3,'  تنظیمات crm مدیریت مشتریان',3),(4,'  تنظیمات صفحه ورود ',7),(5,' تنظیمات مشتریان و اشخاص',3),(6,'  تنظیمات انبار  ،  ورود و خروج کالا ',1),(7,' تنظیمات چاپ و خروجی  ',7),(8,' تنظیمات اتوماسیون ومدیریت کارها ',8),(9,'تنظیمات مدیریت پروژه',12);
/*!40000 ALTER TABLE `jet_setting_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_stock`
--

DROP TABLE IF EXISTS `jet_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `des` varchar(150) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tbl_stock_tbl_stock_id_fk` (`parent`),
  CONSTRAINT `tbl_stock_tbl_stock_id_fk` FOREIGN KEY (`parent`) REFERENCES `jet_stock` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='manage stocks';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_stock`
--

LOCK TABLES `jet_stock` WRITE;
/*!40000 ALTER TABLE `jet_stock` DISABLE KEYS */;
INSERT INTO `jet_stock` VALUES (1,'تست','تست',NULL,'2020-03-16 17:59:29');
/*!40000 ALTER TABLE `jet_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_stock_check`
--

DROP TABLE IF EXISTS `jet_stock_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_stock_check` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prd_id` int(11) NOT NULL,
  `des` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `num` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prd_id` (`prd_id`),
  KEY `date` (`date`,`user_id`,`stock_id`),
  CONSTRAINT `prd` FOREIGN KEY (`prd_id`) REFERENCES `jet_prd` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_stock_check`
--

LOCK TABLES `jet_stock_check` WRITE;
/*!40000 ALTER TABLE `jet_stock_check` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_stock_check` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_stock_in`
--

DROP TABLE IF EXISTS `jet_stock_in`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_stock_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prd_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `date_expire` datetime DEFAULT NULL,
  `pro_forma` varchar(50) DEFAULT NULL,
  `des` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `params` text NOT NULL,
  `lot` varchar(100) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prd_id` (`prd_id`),
  KEY `user_id` (`user_id`),
  KEY `tbl_stock_in_tbl_stock_id_fk` (`stock_id`),
  CONSTRAINT `prd_stock_in` FOREIGN KEY (`prd_id`) REFERENCES `jet_prd` (`id`),
  CONSTRAINT `tbl_stock_in_tbl_stock_id_fk` FOREIGN KEY (`stock_id`) REFERENCES `jet_stock` (`id`),
  CONSTRAINT `user_stock_in` FOREIGN KEY (`user_id`) REFERENCES `jet_user_admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_stock_in`
--

LOCK TABLES `jet_stock_in` WRITE;
/*!40000 ALTER TABLE `jet_stock_in` DISABLE KEYS */;
INSERT INTO `jet_stock_in` VALUES (1,14,10,'2020-07-10 00:00:00',NULL,NULL,'test ecare',16,'',NULL,1);
/*!40000 ALTER TABLE `jet_stock_in` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_stock_out`
--

DROP TABLE IF EXISTS `jet_stock_out`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_stock_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prd_id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `des` text DEFAULT NULL,
  `params` text DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `user_reciver_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prd_id` (`prd_id`),
  KEY `user_id` (`user_id`),
  KEY `tbl_stock_out_tbl_stock_id_fk` (`stock_id`),
  KEY `tbl_stock_out_tbl_user_id_fk` (`user_reciver_id`),
  CONSTRAINT `prd_stock` FOREIGN KEY (`prd_id`) REFERENCES `jet_prd` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_stock_out_tbl_stock_id_fk` FOREIGN KEY (`stock_id`) REFERENCES `jet_stock` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tbl_stock_out_tbl_user_id_fk` FOREIGN KEY (`user_reciver_id`) REFERENCES `jet_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_stock` FOREIGN KEY (`user_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_stock_out`
--

LOCK TABLES `jet_stock_out` WRITE;
/*!40000 ALTER TABLE `jet_stock_out` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_stock_out` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_tmp_client`
--

DROP TABLE IF EXISTS `jet_tmp_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_tmp_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maker_id` int(11) NOT NULL,
  `tmp_client_type` int(11) NOT NULL,
  `tmp_client_peyment` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `tell` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `des` varchar(100) DEFAULT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modify` datetime DEFAULT NULL,
  `date_expire` datetime DEFAULT NULL,
  `extra1` varchar(100) DEFAULT NULL,
  `extra2` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index` (`maker_id`),
  KEY `tmp_client_type` (`tmp_client_type`),
  KEY `tmp_client_peyment` (`tmp_client_peyment`),
  KEY `state` (`state`),
  KEY `date_create` (`date_create`),
  KEY `date_create_2` (`date_create`,`date_modify`,`date_expire`),
  KEY `mobile` (`mobile`),
  CONSTRAINT `maker_id` FOREIGN KEY (`maker_id`) REFERENCES `jet_user_admin` (`id`),
  CONSTRAINT `tmp_payment` FOREIGN KEY (`tmp_client_peyment`) REFERENCES `jet_tmp_client_peyment_type` (`id`),
  CONSTRAINT `tmp_state` FOREIGN KEY (`state`) REFERENCES `jet_tmp_client_state` (`id`),
  CONSTRAINT `tmp_type` FOREIGN KEY (`tmp_client_type`) REFERENCES `jet_tmp_client_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='temp clients';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_tmp_client`
--

LOCK TABLES `jet_tmp_client` WRITE;
/*!40000 ALTER TABLE `jet_tmp_client` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_tmp_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_tmp_client_peyment_type`
--

DROP TABLE IF EXISTS `jet_tmp_client_peyment_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_tmp_client_peyment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `des` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_tmp_client_peyment_type`
--

LOCK TABLES `jet_tmp_client_peyment_type` WRITE;
/*!40000 ALTER TABLE `jet_tmp_client_peyment_type` DISABLE KEYS */;
INSERT INTO `jet_tmp_client_peyment_type` VALUES (1,'credit',''),(2,'cash','');
/*!40000 ALTER TABLE `jet_tmp_client_peyment_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_tmp_client_state`
--

DROP TABLE IF EXISTS `jet_tmp_client_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_tmp_client_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `enable_edit` int(1) NOT NULL,
  `enable_commenting` int(1) NOT NULL,
  `disable_converting` int(1) NOT NULL,
  `limit` int(11) NOT NULL,
  `submit` int(1) NOT NULL COMMENT 'enable to convet to user',
  `css` varchar(255) NOT NULL,
  `order_by` int(10) NOT NULL,
  `deafult` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_tmp_client_state`
--

LOCK TABLES `jet_tmp_client_state` WRITE;
/*!40000 ALTER TABLE `jet_tmp_client_state` DISABLE KEYS */;
INSERT INTO `jet_tmp_client_state` VALUES (1,'doing',1,1,0,20,0,'btn-primary',1,1),(2,'expire',0,0,0,0,0,'btn-danger',2,0),(3,'usered',0,0,1,0,1,'btn-info',3,0);
/*!40000 ALTER TABLE `jet_tmp_client_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_tmp_client_tracking`
--

DROP TABLE IF EXISTS `jet_tmp_client_tracking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_tmp_client_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` int(11) NOT NULL,
  `replay` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `tmp_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_from` (`from_user`),
  KEY `tmp_user` (`tmp_user`),
  CONSTRAINT `from_user` FOREIGN KEY (`from_user`) REFERENCES `jet_user_admin` (`id`),
  CONSTRAINT `tmp_user` FOREIGN KEY (`tmp_user`) REFERENCES `jet_tmp_client` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='temp client tracking';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_tmp_client_tracking`
--

LOCK TABLES `jet_tmp_client_tracking` WRITE;
/*!40000 ALTER TABLE `jet_tmp_client_tracking` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_tmp_client_tracking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_tmp_client_type`
--

DROP TABLE IF EXISTS `jet_tmp_client_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_tmp_client_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `des` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='temporary client type';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_tmp_client_type`
--

LOCK TABLES `jet_tmp_client_type` WRITE;
/*!40000 ALTER TABLE `jet_tmp_client_type` DISABLE KEYS */;
INSERT INTO `jet_tmp_client_type` VALUES (1,'عمده فروشی',''),(2,'خرده فروشی',''),(3,'فروشگاه زنجیره ای',''),(4,'شخصی',''),(5,'شرکت پخش','شرکت پخش');
/*!40000 ALTER TABLE `jet_tmp_client_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_user`
--

DROP TABLE IF EXISTS `jet_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id for user',
  `vip` int(1) DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `agent` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `tell` varchar(50) DEFAULT '0',
  `profile` text DEFAULT NULL COMMENT 'json',
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `date_expire` datetime DEFAULT current_timestamp(),
  `address` text DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL COMMENT 'code posti',
  `usergroup` int(11) DEFAULT NULL COMMENT 'fk',
  `max_buy_limit` varchar(100) DEFAULT NULL COMMENT 'hadaksar kharid',
  `min_buy_limit` varchar(100) DEFAULT NULL COMMENT 'hadaghal kharid',
  `privacy` tinyint(20) DEFAULT NULL COMMENT 'public or private',
  `setting` text DEFAULT NULL COMMENT 'json',
  `maker_id` int(11) DEFAULT NULL COMMENT 'fk for user maker',
  `parent` int(11) DEFAULT NULL COMMENT 'fk for user group',
  `state` tinyint(1) DEFAULT NULL COMMENT 'publish or unpublish',
  `comerical_type` tinyint(10) DEFAULT NULL COMMENT 'haghighi ya hoghooghi',
  `comerical_id` varchar(20) DEFAULT NULL COMMENT 'nation formal code',
  `laghab` int(20) DEFAULT NULL COMMENT 'name perfix',
  `extra1` varchar(255) DEFAULT NULL,
  `extra2` varchar(255) DEFAULT NULL,
  `extra3` varchar(255) DEFAULT NULL,
  `extra4` varchar(255) DEFAULT NULL,
  `extra5` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL COMMENT 'web site of client',
  `perfix_code` varchar(255) DEFAULT NULL COMMENT 'perfix serial for codes',
  `status_id` int(11) DEFAULT NULL,
  `tmp_user` int(11) DEFAULT NULL,
  `folow_interval` int(11) DEFAULT NULL,
  `birth` datetime DEFAULT current_timestamp(),
  `price` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usergroup` (`usergroup`),
  KEY `maker_id` (`maker_id`),
  KEY `parent` (`parent`),
  KEY `laghab` (`laghab`),
  KEY `status_id` (`status_id`),
  KEY `tmp_user` (`tmp_user`),
  CONSTRAINT `maker` FOREIGN KEY (`maker_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `status` FOREIGN KEY (`status_id`) REFERENCES `jet_user_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user group` FOREIGN KEY (`usergroup`) REFERENCES `jet_usergroup` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='full information about user client';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_user`
--

LOCK TABLES `jet_user` WRITE;
/*!40000 ALTER TABLE `jet_user` DISABLE KEYS */;
INSERT INTO `jet_user` VALUES (220,0,'jet',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-03-29 00:12:34','2020-03-29 00:12:34',NULL,NULL,6,NULL,NULL,NULL,NULL,16,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-03-29 00:00:00',NULL);
/*!40000 ALTER TABLE `jet_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_user_admin`
--

DROP TABLE IF EXISTS `jet_user_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_user_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id for user',
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `reagent` varchar(100) NOT NULL COMMENT 'agent',
  `email` varchar(100) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `tell` varchar(20) NOT NULL DEFAULT '0',
  `sex` int(1) NOT NULL,
  `profile` text NOT NULL COMMENT 'json',
  `date_create` datetime NOT NULL DEFAULT current_timestamp(),
  `date_expire` datetime DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(20) NOT NULL COMMENT 'code posti',
  `usergroup` int(11) NOT NULL COMMENT 'fk',
  `maker_id` int(11) DEFAULT NULL COMMENT 'fk for user maker',
  `parent` int(11) DEFAULT NULL COMMENT 'fk for user group',
  `state` int(1) NOT NULL COMMENT 'publish or unpublish',
  `meli_id` varchar(40) NOT NULL COMMENT 'nation code',
  `extra` varchar(255) DEFAULT NULL COMMENT 'additional data',
  `last_ip` varchar(55) DEFAULT NULL,
  `last_time` datetime DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `limit_sell` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tell` (`tell`),
  KEY `maker_id` (`maker_id`),
  KEY `meli_id` (`meli_id`),
  KEY `date_create` (`date_create`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='full information about user to login and do any thing = maker_id';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_user_admin`
--

LOCK TABLES `jet_user_admin` WRITE;
/*!40000 ALTER TABLE `jet_user_admin` DISABLE KEYS */;
INSERT INTO `jet_user_admin` VALUES (16,'administrator','admin','1855054556aee87ee2d81afe4120a58e','پیروز جنابی','jenabi.pirooz@gmail.com','09130878009','03136736744',1,'','2020-02-25 00:00:00',NULL,'اصفهان بهارستان خیابان مهتاب10 خیابان بدر 8 پلاک 557','123',1,16,NULL,1,'1270550365',NULL,NULL,NULL,'0000-00-00 00:00:00','0');
/*!40000 ALTER TABLE `jet_user_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_user_employ_report`
--

DROP TABLE IF EXISTS `jet_user_employ_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_user_employ_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `des` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `report_user` FOREIGN KEY (`user_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT=' employer daily report';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_user_employ_report`
--

LOCK TABLES `jet_user_employ_report` WRITE;
/*!40000 ALTER TABLE `jet_user_employ_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_user_employ_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_user_status`
--

DROP TABLE IF EXISTS `jet_user_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_user_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `des` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_user_status`
--

LOCK TABLES `jet_user_status` WRITE;
/*!40000 ALTER TABLE `jet_user_status` DISABLE KEYS */;
INSERT INTO `jet_user_status` VALUES (1,'active',''),(2,'deactive',''),(3,'trash','');
/*!40000 ALTER TABLE `jet_user_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_user_track_period`
--

DROP TABLE IF EXISTS `jet_user_track_period`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_user_track_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `des` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_client` (`id_client`),
  CONSTRAINT `id_client` FOREIGN KEY (`id_client`) REFERENCES `jet_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `jet_user_admin` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='temp client track period ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_user_track_period`
--

LOCK TABLES `jet_user_track_period` WRITE;
/*!40000 ALTER TABLE `jet_user_track_period` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_user_track_period` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_user_tracking`
--

DROP TABLE IF EXISTS `jet_user_tracking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_user_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `client` int(11) NOT NULL,
  `replay` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `from_user` (`from_user`),
  KEY `client` (`client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='tracking for users';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_user_tracking`
--

LOCK TABLES `jet_user_tracking` WRITE;
/*!40000 ALTER TABLE `jet_user_tracking` DISABLE KEYS */;
/*!40000 ALTER TABLE `jet_user_tracking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_usergroup`
--

DROP TABLE IF EXISTS `jet_usergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `state` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_usergroup`
--

LOCK TABLES `jet_usergroup` WRITE;
/*!40000 ALTER TABLE `jet_usergroup` DISABLE KEYS */;
INSERT INTO `jet_usergroup` VALUES (6,'خریداران',0,1),(7,'‌فروشندگان',0,1),(11,'فروشندگان ویژه',NULL,1);
/*!40000 ALTER TABLE `jet_usergroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jet_usergroup_eemploy`
--

DROP TABLE IF EXISTS `jet_usergroup_eemploy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jet_usergroup_eemploy` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '_ID',
  `name` varchar(100) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `state` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jet_usergroup_eemploy`
--

LOCK TABLES `jet_usergroup_eemploy` WRITE;
/*!40000 ALTER TABLE `jet_usergroup_eemploy` DISABLE KEYS */;
INSERT INTO `jet_usergroup_eemploy` VALUES (1,'مدیر کل',0,1),(5,'کارمندان',0,1);
/*!40000 ALTER TABLE `jet_usergroup_eemploy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_auto_form_history`
--

DROP TABLE IF EXISTS `tbl_auto_form_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_auto_form_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `params` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='record history of forms operations';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_auto_form_history`
--

LOCK TABLES `tbl_auto_form_history` WRITE;
/*!40000 ALTER TABLE `tbl_auto_form_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_auto_form_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_auto_forms_field_data`
--

DROP TABLE IF EXISTS `tbl_auto_forms_field_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_auto_forms_field_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_auto_forms_field_data_tbl_auto_forms_field_data_group_id_fk` (`group_id`),
  CONSTRAINT `tbl_auto_forms_field_data_tbl_auto_forms_field_data_group_id_fk` FOREIGN KEY (`group_id`) REFERENCES `tbl_auto_forms_field_data_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='select value of field of auto';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_auto_forms_field_data`
--

LOCK TABLES `tbl_auto_forms_field_data` WRITE;
/*!40000 ALTER TABLE `tbl_auto_forms_field_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_auto_forms_field_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_auto_forms_field_data_group`
--

DROP TABLE IF EXISTS `tbl_auto_forms_field_data_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_auto_forms_field_data_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `params` text DEFAULT NULL,
  `parent` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `filed_data_group` (`parent`),
  CONSTRAINT `filed_data_group` FOREIGN KEY (`parent`) REFERENCES `tbl_auto_forms_field_data_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_auto_forms_field_data_group`
--

LOCK TABLES `tbl_auto_forms_field_data_group` WRITE;
/*!40000 ALTER TABLE `tbl_auto_forms_field_data_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_auto_forms_field_data_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_auto_forms_value`
--

DROP TABLE IF EXISTS `tbl_auto_forms_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_auto_forms_value` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `maker_id` int(11) DEFAULT NULL,
  `number` int(255) DEFAULT NULL,
  `params` text DEFAULT NULL,
  `modify_date` datetime NOT NULL DEFAULT current_timestamp(),
  `modifire_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_auto_forms_value_tbl_auto_forms_id_fk` (`form_id`),
  KEY `tbl_auto_forms_value_tbl_user_eemploy_id_fk` (`maker_id`),
  CONSTRAINT `tbl_auto_forms_value_tbl_auto_forms_id_fk` FOREIGN KEY (`form_id`) REFERENCES `jet_auto_forms` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_auto_forms_value_tbl_user_eemploy_id_fk` FOREIGN KEY (`maker_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_auto_forms_value`
--

LOCK TABLES `tbl_auto_forms_value` WRITE;
/*!40000 ALTER TABLE `tbl_auto_forms_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_auto_forms_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_factor_other_pay`
--

DROP TABLE IF EXISTS `tbl_factor_other_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_factor_other_pay` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `des` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `user_id` int(40) NOT NULL,
  `eemploy_id` int(40) NOT NULL,
  `factor_id` int(40) NOT NULL,
  `maker_id` int(40) NOT NULL,
  `date` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`eemploy_id`,`factor_id`,`maker_id`),
  KEY `eemploy` (`eemploy_id`),
  KEY `factor_other` (`factor_id`),
  KEY `maker_other` (`maker_id`),
  CONSTRAINT `eemploy` FOREIGN KEY (`eemploy_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `factor_other` FOREIGN KEY (`factor_id`) REFERENCES `jet_factor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maker_other` FOREIGN KEY (`maker_id`) REFERENCES `jet_user_admin` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `jet_user` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='سایر پرداختای فاکتور';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_factor_other_pay`
--

LOCK TABLES `tbl_factor_other_pay` WRITE;
/*!40000 ALTER TABLE `tbl_factor_other_pay` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_factor_other_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_factor_preview`
--

DROP TABLE IF EXISTS `tbl_factor_preview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_factor_preview` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `header_pic` varchar(255) NOT NULL COMMENT 'url for header pic',
  `footer_pic` varchar(255) NOT NULL COMMENT 'url for footer pic',
  `des` varchar(255) NOT NULL,
  `propertis` text NOT NULL COMMENT 'json decode propertis',
  `state` tinyint(10) NOT NULL COMMENT 'publish or unpublish',
  `size` varchar(100) NOT NULL DEFAULT 'a4',
  `encoding` varchar(100) NOT NULL DEFAULT 'UTF-8',
  `title` varchar(255) DEFAULT NULL,
  `Author` varchar(255) NOT NULL,
  `url_header` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_factor_preview`
--

LOCK TABLES `tbl_factor_preview` WRITE;
/*!40000 ALTER TABLE `tbl_factor_preview` DISABLE KEYS */;
INSERT INTO `tbl_factor_preview` VALUES (1,'فاکتور فروش','sell.jpg','','','',1,'a4','UTF-8','factor_sell','piero','http://www.piero.ir'),(2,'فاکتور برگشت از فروش','reject.jpg','','','',1,'a4','UTF-8','reject_factor','piero','http://www.piero.ir'),(3,'فاکتور نمونه','sell.jpg','','','',1,'a4','UTF-8','factor','piero','http://www.piero.ir'),(4,'قبض انبار','anbar1.jpg','','','',1,'a4','UTF-8','factor','piero','http://www.piero.ir'),(5,'فاکتور غیر رسمی','sell.jpg','','','',1,'a4','UTF-8','factor_sell','piero','http://www.piero.ir'),(6,'پیش فاکتور','presell.jpg','','','',1,'a4','UTF-8','factor_preesell','piero','http://www.piero.ir'),(7,'فاکتور خرید','buy.jpg','buyf.jpg','فاکتور خرید',' ',1,'a4','UTF-8','factor_buy','piero','http://www.piero.ir');
/*!40000 ALTER TABLE `tbl_factor_preview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_factor_preview_element`
--

DROP TABLE IF EXISTS `tbl_factor_preview_element`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_factor_preview_element` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `factor_preview_id` int(40) NOT NULL COMMENT 'fk for factor id',
  `name` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `dir` varchar(100) NOT NULL DEFAULT 'rtl',
  `propertis` text NOT NULL COMMENT 'json',
  `state` tinyint(10) NOT NULL,
  `position` tinyint(10) NOT NULL COMMENT 'tartib chideman',
  `width` varchar(100) NOT NULL COMMENT 'responsive max 12',
  `height` varchar(100) NOT NULL,
  `x` varchar(100) NOT NULL,
  `y` varchar(100) NOT NULL,
  `load_type` varchar(255) NOT NULL COMMENT 'function load',
  PRIMARY KEY (`id`),
  KEY `factor_preview_id` (`factor_preview_id`),
  CONSTRAINT `factor_element` FOREIGN KEY (`factor_preview_id`) REFERENCES `tbl_factor_preview` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_factor_preview_element`
--

LOCK TABLES `tbl_factor_preview_element` WRITE;
/*!40000 ALTER TABLE `tbl_factor_preview_element` DISABLE KEYS */;
INSERT INTO `tbl_factor_preview_element` VALUES (1,1,'مشخصات خریدار','client info far','rtl','{\"css\":\"factor_pre_client_fa\",\"values\":{\"نام خریدار\":\"name\",\"نماینده قانونی\":\"agent\",\"آدرس\":\"address\",\"کد اقتصادی\":\"comerical_id\",\"تلفن\":\"tell\",\"همراه\":\"mobile\",\"کد مشتری\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\",\"factor_replace\":\"address\", \"factor_role_params\":\"delivery_address1\"}',1,1,'95px','50px','10px','29px','load_db'),(2,1,'BILL TO','client info en','ltr','{\"css\":\"factor_pre_client_en\",\"values\":{\"Name\":\"extra1\",\"Contact person\":\"extra2\",\"Address\":\"extra3\",\"city,state,zip\":\"extra4\",\"Country\":\"extra5\",\"Email\":\"email\",\"Business ID\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\" , \"factor_replace\":\"extra3\", \"factor_role_params\":\"delivery_address2\"}',1,2,'95px','50px','105px','29px','load_db'),(3,1,'شماره فاکتور:','factor number fa','rtl','{\"css\":\"factor_first_col_fa\"}',1,3,'35px','10px','10px','82px','factor_num'),(4,1,'تاریخ فاکتور:','date factor en','rtl','{\"type\":\"shamsi\",\"css\":\"factor_first_col_fa\"}',1,4,'35px','10px','45px','82px','factor_date'),(5,1,'تاریخ سررسید فاکتور:','expire faxtor','rtl','{\"type\":\"shamsi\",\"css\":\"factor_first_col_fa\"}',1,5,'65px','10px','10px','240px','expire_factor'),(6,1,'INVOICE NUMBER:','factor number en','rtl','{\"css\":\"factor_first_col_en\"}',1,6,'35px','10px','125px','82px','factor_num'),(7,1,'INVOICE DATE:','dactor date en','rtl','{\"type\":\"\",\"css\":\"factor_first_col_en\"}',1,7,'40px','10px','160px','82px','factor_date'),(9,1,'','product byed','rtl','{\"db\":{\"factor_prd.radif\":\"1\",\"prd.id as prd_id \":\"2\",\"prd.name\":\"-3\",\n\"factor_prd.takhfif\":\"-2\",\n\"factor_prd.num\":\"1\",\"factor_prd.price_client\":\"2\",\"factor_prd.price\":\"2\",\"mali_prd_vahed.name as vahed_asli_name\":\"-1\",\"prd.vahed_fari\":\"2\",\"prd.row_plus as row_plus\":\"3\"},\"css\":\"factor_prd\",\"free\":\"0\"}\n',1,9,'190px','80px','10px','90px','factor_prd'),(11,1,'طریقه تسویه حساب:','description','rtl','{\"css\":\"factor_des\"}',1,11,'85px','50px','10px','225px','des_factor'),(15,1,'','list of bank acount fa','rtl','{\"css\":\"factor_hesabha_fa\",\"body\":\"<table>\n<tr>\n<td class=\'tit\' >شماره حساب:</td>\n</tr>\n<tr>\n<td  >شماره حساب بانک سپه:</td>\n</tr>\n<tr>\n<td  >شماره  حساب بانک تجارت:</td>\n</tr>\n</table>\"}',1,13,'50px','20px','100px','226px','text_html'),(16,1,'','address fa','rtl','{\"css\":\"factor_text_fa_wl\",\"body\":\"<b>مشخصات فروشنده :</b><br />\n<b>شرکت تجارت گستر لوتوس</b>\n<br />اصفهان -خیابان هزار جریب بعد از هتل جهانگردی مجتمع پردیس\n<br />ورودی3 واحد ۴ --کدپستی:8174663913\n<br />شناسه ملی: 10260669710--کد اقتصادی:411481131189\n<br />تلفن:36736744-5 031 فکس:03136736441 \n\"}\n',1,14,'95px','40px','10px','245px','text_html'),(18,1,'','address en','rtl','{\"css\":\"factor_text_en\",\"body\":\"\r\n<b>ORDER ISSUED BY:</b>\r\n<br />LOTUS BUSINESS DEVELOPMENT CO.\r\n<br />No 4 , entrance 3, Pardis Complex,Hezarjrib Ave.,Esfahan\r\n<br />NATIONAL ID NUMBER:10260669710\r\n<br />ECONOMICAL CODE:411481131189\r\n<br />Phone number:009803136736744\r\n\"}',1,15,'95px','50px','105px','245px','text_html'),(20,1,'','tahvil girande','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\n<br /><br /> <b>تحویل گیرنده:</b>\n<br />نام و نام خانوادگی:\"}',1,16,'95px','10px','110px','265px','text_html'),(21,1,'','bank acount en','rtl','{\"css\":\"factor_hesabha_en\",\"body\":\"<table><tr><td >ACOUNTS NUMBER: </td></tr><tr><td  >  576303081104\n      -- کارت:          \n      5892-1011-6514-3401  </td>\n  </tr>\n  <tr>\n    <td  >  690079801\n     -- کارت:    \n      6273-5399-9166-8020 </td>\n  </tr>\n</table>\"}',1,13,'89px','20px','110px','226px','text_html'),(22,1,'','end of acount bank','rtl','{\"css\":\"factor_hesabha_fa_des\",\"body\":\"<div> تمامی حسابها به نام شرکت تجارت گستر لوتوس می باشد </div>\"}',1,13,'98px','10px','100px','235px','text_html'),(23,1,'','tahvil dahande','rtl','{\"css\":\"factor_text_fa\",\"body\":\"<br /><br /> <b>تایید کننده</b><br />امور مالی وحسابداری:\"}',1,1,'95px','10px','10px','265px','text_html'),(24,2,'مشخصات خریدار','client info far','rtl','{\"css\":\"factor_pre_client_fa\",\"values\":{\"نام خریدار\":\"name\",\"نماینده قانونی\":\"agent\",\"آدرس\":\"address\",\"کد اقتصادی\":\"comerical_id\",\"تلفن\":\"tell\",\"همراه\":\"mobile\",\"کد مشتری\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\" , \"factor_replace\":\"address\", \"factor_role_params\":\"delivery_address1\"}',1,1,'95px','50px','10px','29px','load_db'),(25,2,'BILL TO','client info en','ltr','{\"css\":\"factor_pre_client_en\",\"values\":{\"Name\":\"extra1\",\"Contact person\":\"extra2\",\"Address\":\"extra3\",\"city,state,zip\":\"extra4\",\"Country\":\"extra5\",\"Email\":\"email\",\"Business ID\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\", \"factor_replace\":\"extra3\", \"factor_role_params\":\"delivery_address2\"}',1,2,'95px','50px','105px','29px','load_db'),(26,2,'شماره فاکتور:','factor number fa','rtl','{\"css\":\"factor_first_col_fa\"}',1,3,'35px','10px','10px','82px','factor_num'),(27,2,'تاریخ فاکتور:','date factor en','rtl','{\"type\":\"shamsi\",\"css\":\"factor_first_col_fa\"}',1,4,'35px','10px','45px','82px','factor_date'),(28,2,'INVOICE NUMBER:','factor number en','rtl','{\"css\":\"factor_first_col_en\"}',1,6,'35px','10px','125px','82px','factor_num'),(29,2,'INVOICE DATE:','dactor date en','rtl','{\"type\":\"\",\"css\":\"factor_first_col_en\"}',1,7,'40px','10px','160px','82px','factor_date'),(30,2,'','product byed','rtl','{\"db\":{\"factor_prd.radif\":\"1\",\"prd.id as prd_id \":\"2\",\"prd.name\":\"-3\",\r\n\"factor_prd.takhfif\":\"-2\",\r\n\"factor_prd.num\":\"1\",\"factor_prd.price\":\"2\",\"mali_prd_vahed.name as vahed_asli_name\":\"-1\",\"prd.vahed_fari\":\"2\",\"prd.row_plus as row_plus\":\"3\"},\"css\":\"factor_prd\"}\r\n',1,9,'190px','80px','10px','90px','factor_prd'),(31,2,'توضیحات:','description','rtl','{\"css\":\"factor_des\"}',1,11,'195px','50px','10px','225px','des_factor'),(32,2,'','return signs','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\n<br /><br /> <b>تایید کننده:</b>\n<br />امضای کارشناس فروش:\"}\n',1,14,'50px','40px','10px','253px','text_html'),(33,2,'','return signs2','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\n<br /><br /> <b>تایید کننده:</b>\n<br />امضای حسابدار:\"}\n',1,15,'50px','40px','60px','253px','text_html'),(34,2,'','return signs3','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\n<br /><br /> <b>تایید کننده:</b>\n<br />امضای تحویل دهنده:\"}\n',1,14,'50px','40px','120px','253px','text_html'),(35,2,'','return signs4','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\r\n<br /><br /> <b>تایید کننده:</b>\r\n<br />امضای انباردار:\"}\r\n',1,14,'50px','40px','170px','253px','text_html'),(36,2,'','end text','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\r\n<b> بدین وسیله گواهی می شود کالا ها به شرح و مبلغ فوق به شرکت تجارت گستر لوتوس برگشت داده شده است. </b>\"}\r\n',1,15,'190px','40px','10px','243px','text_html'),(37,3,'مشخصات خریدار','client info far','rtl','{\"css\":\"factor_pre_client_fa\",\"values\":{\"نام خریدار\":\"name\",\"نماینده قانونی\":\"agent\",\"آدرس\":\"address\",\"کد اقتصادی\":\"comerical_id\",\"تلفن\":\"tell\",\"همراه\":\"mobile\",\"کد مشتری\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\",\"factor_replace\":\"address\", \"factor_role_params\":\"delivery_address1\"}',1,1,'95px','50px','10px','29px','load_db'),(38,3,'BILL TO','client info en','ltr','{\"css\":\"factor_pre_client_en\",\"values\":{\"Name\":\"extra1\",\"Contact person\":\"extra2\",\"Address\":\"extra3\",\"city,state,zip\":\"extra4\",\"Country\":\"extra5\",\"Email\":\"email\",\"Business ID\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\" , \"factor_replace\":\"extra3\", \"factor_role_params\":\"delivery_address2\"}',1,2,'95px','50px','105px','29px','load_db'),(39,3,'شماره فاکتور:','factor number fa','rtl','{\"css\":\"factor_first_col_fa\"}',1,3,'35px','10px','10px','82px','factor_num'),(40,3,'تاریخ فاکتور:','date factor en','rtl','{\"type\":\"shamsi\",\"css\":\"factor_first_col_fa\"}',1,4,'35px','10px','45px','82px','factor_date'),(42,3,'INVOICE NUMBER:','factor number en','rtl','{\"css\":\"factor_first_col_en\"}',1,6,'35px','10px','125px','82px','factor_num'),(43,3,'INVOICE DATE:','dactor date en','rtl','{\"type\":\"\",\"css\":\"factor_first_col_en\"}',1,7,'40px','10px','160px','82px','factor_date'),(44,3,'','product byed','rtl','{\"free\":\"1\",\n\"db\":{\"factor_prd.radif\":\"1\",\"prd.id as prd_id \":\"2\",\"prd.name\":\"-3\",\n\"factor_prd.takhfif\":\"-2\",\n\"factor_prd.num\":\"1\",\"factor_prd.price\":\"2\",\"mali_prd_vahed.name as vahed_asli_name\":\"-1\",\"prd.vahed_fari\":\"2\",\"prd.row_plus as row_plus\":\"3\"},\"css\":\"factor_prd\"}\n',1,9,'190px','80px','10px','90px','factor_prd'),(45,3,'توضیحات:','description','rtl','{\"css\":\"factor_des\"}',1,11,'85px','50px','10px','225px','des_factor'),(46,3,'','list of bank acount fa','rtl','{\"css\":\"factor_hesabha_fa\",\"body\":\"<table>\r\n<tr>\r\n<td class=\'tit\' >شماره حساب:</td>\r\n</tr>\r\n<tr>\r\n<td  >شماره حساب بانک سپه:</td>\r\n</tr>\r\n<tr>\r\n<td  >شماره کارت تجارت:</td>\r\n</tr>\r\n</table>\"}',1,13,'50px','20px','100px','226px','text_html'),(47,3,'','address fa','rtl','{\"css\":\"factor_text_fa_wl\",\"body\":\"\r\n<b>شرکت تجارت گستر لوتوس</b>\r\n<br />اصفهان -خیابان هزار جریب بعد از هتل جهانگردی مجتمع پردیس\r\n<br />ورودی3 واحد ۴ --کدپستی:8174663913\r\n<br />شناسه ملی: 10260669710--کد اقتصادی:411481131189\r\n<br />تلفن:36736744-5 031 فکس:03136736441 \r\n\"}\r\n',1,14,'95px','40px','10px','249px','text_html'),(48,3,'','address en','rtl','{\"css\":\"factor_text_en\",\"body\":\"\r\n<b>ORDER ISSUED BY:</b>\r\n<br />LOTUS BUSINESS DEVELOPMENT CO.\r\n<br />No 4 , entrance 3, Pardis Complex,Hezarjrib Ave.,Esfahan\r\n<br />NATIONAL ID NUMBER:10260669710\r\n<br />ECONOMICAL CODE:411481131189\r\n<br />Phone number:009803136736744\r\n\"}',1,15,'95px','50px','105px','245px','text_html'),(50,3,'','bank acount en','rtl','{\"css\":\"factor_hesabha_en\",\"body\":\"<table>\r\n<tr>\r\n<td>  </td>\r\n<td >ACOUNTS NUMBER: </td>\r\n\r\n</tr>\r\n<tr>\r\n<td  >576303081104</td>\r\n<td> IBAN:IR </td>\r\n</tr>\r\n<tr>\r\n<td  >6273-5399-9166-8020</td>\r\n<td> IBAN:IR </td>\r\n</tr>\r\n</table>\"}',1,13,'89px','20px','110px','226px','text_html'),(51,3,'','end of acount bank','rtl','{\"css\":\"factor_hesabha_fa_des\",\"body\":\"<div> تمامی حسابها به نام شرکت تجارت گستر لوتوس می باشد </div>\"}',1,14,'98px','10px','100px','235px','text_html'),(52,3,'','tahvil dahande','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\n<br /><br /> <b>تایید کننده:</b>\n<br />امور مالی وحسابداری:\"}',1,1,'95px','10px','10px','265px','text_html'),(53,4,'مشخصات خریدار','client info far','rtl','{\"css\":\"factor_pre_client_fa\",\"values\":{\"نام خریدار\":\"name\",\"نماینده قانونی\":\"agent\",\"آدرس\":\"address\",\"کد اقتصادی\":\"comerical_id\",\"تلفن\":\"tell\",\"همراه\":\"mobile\",\"کد مشتری\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\",\"factor_replace\":\"address\", \"factor_role_params\":\"delivery_address1\"}',1,1,'95px','50px','10px','29px','load_db'),(54,4,'BILL TO','client info en','ltr','{\"css\":\"factor_pre_client_en\",\"values\":{\"Name\":\"extra1\",\"Contact person\":\"extra2\",\"Address\":\"extra3\",\"city,state,zip\":\"extra4\",\"Country\":\"extra5\",\"Email\":\"email\",\"Business ID\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\", \"factor_replace\":\"extra3\", \"factor_role_params\":\"delivery_address2\"}',1,2,'95px','50px','105px','29px','load_db'),(55,4,'شماره فاکتور:','factor number fa','rtl','{\"css\":\"factor_first_col_fa\"}',1,3,'35px','10px','10px','82px','factor_num'),(56,4,'تاریخ فاکتور:','date factor en','rtl','{\"type\":\"shamsi\",\"css\":\"factor_first_col_fa\"}',1,4,'35px','10px','45px','82px','factor_date'),(58,4,'INVOICE NUMBER:','factor number en','rtl','{\"css\":\"factor_first_col_en\"}',1,6,'35px','10px','125px','82px','factor_num'),(59,4,'INVOICE DATE:','dactor date en','rtl','{\"type\":\"\",\"css\":\"factor_first_col_en\"}',1,7,'40px','10px','160px','82px','factor_date'),(60,4,'','product byed','rtl','{\"db\":{\"factor_prd.radif\":\"1\",\"prd.id as prd_id \":\"2\",\"prd.name\":\"-3\",\r\n\"factor_prd.takhfif\":\"-2\",\r\n\"factor_prd.num\":\"1\",\"factor_prd.price_client\":\"2\",\"factor_prd.price\":\"2\",\"mali_prd_vahed.name as vahed_asli_name\":\"-1\",\"prd.vahed_fari\":\"2\",\"prd.row_plus as row_plus\":\"3\"},\"css\":\"factor_prd\",\"free\":\"0\",\"show_total\":\"off\"}\r\n',1,9,'190px','80px','10px','90px','factor_prd'),(63,4,'','tahvil dahanade','rtl','{\"css\":\"factor_text_fa_wl bordered\",\"body\":\"\r\n<br/><b>کارشناس فروش:</b><br/><br/><br/><br/>\r\n<b>شماره حواله انبار:</b><br/><br/><br/><br/>\r\n<b>تاریخ:</b><br/><br/>\r\n\"}\r\n',1,14,'95px','40px','10px','205px','text_html'),(64,4,'','tahvil girande','rtl','{\"css\":\"factor_text_fa_wl bordered\",\"body\":\"\r\n<br/><b>تحویل گیرنده:</b><br/><br/><br/><br/>\r\n<b>تاریخ تحویل:</b><br/><br/><br/><br/>\r\n<b>ساعت تحویل:</b><br/><br/>\r\n\"}',1,15,'95px','50px','105px','205px','text_html'),(65,4,'','anbardar emza','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\n<br /><br /> <b>امضای انباردار:</b>\"}',1,16,'95px','10px','110px','255px','text_html'),(68,4,'','tahvil dahande','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\r\n<br /><br /> <b> امضای کارشناس فروش</b>\"}',1,1,'95px','10px','10px','255px','text_html'),(69,5,'مشخصات خریدار','client info far','rtl','{\"css\":\"factor_pre_client_fa\",\"values\":{\"نام خریدار\":\"name\",\"نماینده قانونی\":\"agent\",\"آدرس\":\"address\",\"کد اقتصادی\":\"0000\",\"تلفن\":\"tell\",\"همراه\":\"mobile\",\"کد مشتری\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\",\"factor_replace\":\"address\", \"factor_role_params\":\"delivery_address1\"}',1,1,'95px','50px','10px','29px','load_db'),(70,5,'BILL TO','client info en','ltr','{\"css\":\"factor_pre_client_en\",\"values\":{\"Name\":\"extra1\",\"Contact person\":\"extra2\",\"Address\":\"extra3\",\"city,state,zip\":\"extra4\",\"Country\":\"extra5\",\"Email\":\"email\",\"Business ID\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\" , \"factor_replace\":\"extra3\", \"factor_role_params\":\"delivery_address2\"}',1,2,'95px','50px','105px','29px','load_db'),(71,5,'شماره فاکتور:','factor number fa','rtl','{\"css\":\"factor_first_col_fa\"}',1,3,'35px','10px','10px','82px','factor_num'),(72,5,'تاریخ فاکتور:','date factor en','rtl','{\"type\":\"shamsi\",\"css\":\"factor_first_col_fa\"}',1,4,'35px','10px','45px','82px','factor_date'),(73,5,'تاریخ سررسید فاکتور:','expire faxtor','rtl','{\"type\":\"shamsi\",\"css\":\"factor_first_col_fa\"}',1,5,'65px','10px','10px','240px','expire_factor'),(74,5,'INVOICE NUMBER:','factor number en','rtl','{\"css\":\"factor_first_col_en\"}',1,6,'35px','10px','125px','82px','factor_num'),(75,5,'INVOICE DATE:','dactor date en','rtl','{\"type\":\"\",\"css\":\"factor_first_col_en\"}',1,7,'40px','10px','160px','82px','factor_date'),(76,5,'','product byed','rtl','{\"db\":{\"factor_prd.radif\":\"1\",\"prd.id as prd_id \":\"2\",\"prd.name\":\"-3\",\r\n\"factor_prd.takhfif\":\"-2\",\r\n\"factor_prd.num\":\"1\",\"factor_prd.price_client\":\"2\",\"factor_prd.price\":\"2\",\"mali_prd_vahed.name as vahed_asli_name\":\"-1\",\"prd.vahed_fari\":\"2\",\"prd.row_plus as row_plus\":\"3\"},\"css\":\"factor_prd\",\"free\":\"0\"}\r\n',1,9,'190px','80px','10px','90px','factor_prd'),(77,5,'طریقه تسویه حساب:','description','rtl','{\"css\":\"factor_des\"}',1,11,'85px','50px','10px','225px','des_factor'),(78,5,'','tahvil girande','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\n<br /><br /> <b>تحویل گیرنده:</b>\n<br />نام و نام خانوادگی:\"}',1,16,'95px','10px','110px','265px','text_html'),(79,5,'','tahvil dahande','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\n<br /><br /> <b>تایید کننده:</b>\n<br />امور مالی وحسابداری:\"}',1,1,'95px','10px','10px','265px','text_html'),(80,6,'مشخصات خریدار','client info far','rtl','{\"css\":\"factor_pre_client_fa\",\"values\":{\"نام خریدار\":\"name\",\"نماینده قانونی\":\"agent\",\"آدرس\":\"address\",\"کد اقتصادی\":\"comerical_id\",\"تلفن\":\"tell\",\"همراه\":\"mobile\",\"کد مشتری\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\",\"factor_replace\":\"address\", \"factor_role_params\":\"delivery_address1\"}',1,1,'95px','50px','10px','29px','load_db'),(81,6,'BILL TO','client info en','ltr','{\"css\":\"factor_pre_client_en\",\"values\":{\"Name\":\"extra1\",\"Contact person\":\"extra2\",\"Address\":\"extra3\",\"city,state,zip\":\"extra4\",\"Country\":\"extra5\",\"Email\":\"email\",\"Business ID\":\"perfix_code+id\"},\"data_base\":\"user\",\"where\":\"user_id\" , \"factor_replace\":\"extra3\", \"factor_role_params\":\"delivery_address2\"}',1,2,'95px','50px','105px','29px','load_db'),(82,6,'شماره فاکتور:','factor number fa','rtl','{\"css\":\"factor_first_col_fa\"}',1,3,'35px','10px','10px','82px','factor_num'),(83,6,'تاریخ فاکتور:','date factor en','rtl','{\"type\":\"shamsi\",\"css\":\"factor_first_col_fa\"}',1,4,'35px','10px','45px','82px','factor_date'),(84,6,'تاریخ سررسید فاکتور:','expire faxtor','rtl','{\"type\":\"shamsi\",\"css\":\"factor_first_col_fa\"}',1,5,'65px','10px','10px','240px','expire_factor'),(85,6,'INVOICE NUMBER:','factor number en','rtl','{\"css\":\"factor_first_col_en\"}',1,6,'35px','10px','125px','82px','factor_num'),(86,6,'INVOICE DATE:','dactor date en','rtl','{\"type\":\"\",\"css\":\"factor_first_col_en\"}',1,7,'40px','10px','160px','82px','factor_date'),(87,6,'','product byed','rtl','{\"db\":{\"factor_prd.radif\":\"1\",\"prd.id as prd_id \":\"2\",\"prd.name\":\"-3\",\r\n\"factor_prd.takhfif\":\"-2\",\r\n\"factor_prd.num\":\"1\",\"factor_prd.price_client\":\"2\",\"factor_prd.price\":\"2\",\"mali_prd_vahed.name as vahed_asli_name\":\"-1\",\"prd.vahed_fari\":\"2\",\"prd.row_plus as row_plus\":\"3\"},\"css\":\"factor_prd\",\"free\":\"0\"}\r\n',1,9,'190px','80px','10px','90px','factor_prd'),(88,6,'طریقه تسویه حساب:','description','rtl','{\"css\":\"factor_des\"}',1,11,'85px','50px','10px','225px','des_factor'),(89,6,'','list of bank acount fa','rtl','{\"css\":\"factor_hesabha_fa\",\"body\":\"<table>\n<tr>\n<td class=\'tit\' >شماره حساب:</td>\n</tr>\n<tr>\n<td  >شماره حساب بانک سپه:</td>\n</tr>\n<tr>\n<td  >شماره  حساب بانک تجارت:</td>\n</tr>\n</table>\"}',1,13,'50px','20px','100px','226px','text_html'),(90,6,'','address fa','rtl','{\"css\":\"factor_text_fa_wl\",\"body\":\"<b>مشخصات فروشنده :</b><br />\n<b>شرکت تجارت گستر لوتوس</b>\n<br />اصفهان -خیابان هزار جریب بعد از هتل جهانگردی مجتمع پردیس\n<br />ورودی3 واحد ۴ --کدپستی:8174663913\n<br />شناسه ملی: 10260669710--کد اقتصادی:411481131189\n<br />تلفن:36736744-5 031 فکس:03136736441 \n\"}\n',1,14,'95px','40px','10px','245px','text_html'),(91,6,'','address en','rtl','{\"css\":\"factor_text_en\",\"body\":\"\r\n<b>ORDER ISSUED BY:</b>\r\n<br />LOTUS BUSINESS DEVELOPMENT CO.\r\n<br />No 4 , entrance 3, Pardis Complex,Hezarjrib Ave.,Esfahan\r\n<br />NATIONAL ID NUMBER:10260669710\r\n<br />ECONOMICAL CODE:411481131189\r\n<br />Phone number:009803136736744\r\n\"}',1,15,'95px','50px','105px','245px','text_html'),(92,6,'','tahvil girande','rtl','{\"css\":\"factor_text_fa\",\"body\":\"\n<br /><br /> <b>تحویل گیرنده:</b>\n<br />نام و نام خانوادگی:\"}',1,16,'95px','10px','110px','265px','text_html'),(93,6,'','bank acount en','rtl','{\"css\":\"factor_hesabha_en\",\"body\":\"<table><tr><td >ACOUNTS NUMBER: </td></tr><tr><td  >  576303081104\n      -- کارت:          \n      5892-1011-6514-3401  </td>\n  </tr>\n  <tr>\n    <td  >  690079801\n     -- کارت:    \n      6273-5399-9166-8020 </td>\n  </tr>\n</table>\"}',1,13,'89px','20px','110px','226px','text_html'),(94,6,'','end of acount bank','rtl','{\"css\":\"factor_hesabha_fa_des\",\"body\":\"<div> تمامی حسابها به نام شرکت تجارت گستر لوتوس می باشد </div>\"}',1,13,'98px','10px','100px','235px','text_html'),(95,6,'','tahvil dahande','rtl','{\"css\":\"factor_text_fa\",\"body\":\"<br /><br /> <b>تایید کننده</b><br />امور مالی وحسابداری:\"}',1,1,'95px','10px','10px','265px','text_html');
/*!40000 ALTER TABLE `tbl_factor_preview_element` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mali_bed_bes`
--

DROP TABLE IF EXISTS `tbl_mali_bed_bes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mali_bed_bes` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `group_id` int(40) NOT NULL,
  `price` varchar(255) NOT NULL,
  `date` varchar(100) NOT NULL,
  `maker_id` int(40) NOT NULL,
  `user_id` int(40) NOT NULL,
  `factor_id` int(40) DEFAULT NULL,
  `des` text DEFAULT NULL,
  `params` text DEFAULT NULL,
  `date_enter` datetime NOT NULL DEFAULT current_timestamp(),
  `enable` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `maker_id` (`maker_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `bed_bes_group` FOREIGN KEY (`group_id`) REFERENCES `tbl_mali_bed_bes_group` (`id`),
  CONSTRAINT `maker_user` FOREIGN KEY (`maker_id`) REFERENCES `jet_user_admin` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='دریافتها و پرداختها';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mali_bed_bes`
--

LOCK TABLES `tbl_mali_bed_bes` WRITE;
/*!40000 ALTER TABLE `tbl_mali_bed_bes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mali_bed_bes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mali_bed_bes_group`
--

DROP TABLE IF EXISTS `tbl_mali_bed_bes_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mali_bed_bes_group` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `bed` tinyint(10) NOT NULL COMMENT '-',
  `bes` tinyint(10) NOT NULL COMMENT '+',
  `user_tbl` varchar(255) NOT NULL COMMENT 'tbl_user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='نوع دریافت و پرداخت';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mali_bed_bes_group`
--

LOCK TABLES `tbl_mali_bed_bes_group` WRITE;
/*!40000 ALTER TABLE `tbl_mali_bed_bes_group` DISABLE KEYS */;
INSERT INTO `tbl_mali_bed_bes_group` VALUES (1,'صدور فاکتور',1,0,'user'),(2,'پرداخت فاکتور',0,1,'user'),(3,'کمیسیون کارمندان',0,1,'user_eemploy'),(4,'واریز کارمندان',1,0,'user_eemploy'),(7,'حقوق',0,1,'user_eemploy'),(8,'دریافت چک مشتری',0,1,'user'),(9,'پرداخت مشتری',0,1,'user');
/*!40000 ALTER TABLE `tbl_mali_bed_bes_group` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-23  0:31:28
