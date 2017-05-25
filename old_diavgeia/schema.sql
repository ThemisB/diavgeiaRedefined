-- MySQL dump 10.11
--
-- Host: localhost    Database: apofaseis
-- ------------------------------------------------------
-- Server version	5.0.51a-24+lenny5

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `apofaseis`
--

DROP TABLE IF EXISTS `apofaseis`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis` (
  `id` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) NOT NULL,
  `arithmos_protokolou` varchar(255) NOT NULL,
  `apofasi_date` date NOT NULL,
  `koinopoiiseis` text NOT NULL,
  `eidos_apofasis` int(11) NOT NULL,
  `thematiki` varchar(255) NOT NULL,
  `submission_timestamp` datetime NOT NULL,
  `comments` text NOT NULL,
  `thema` text NOT NULL,
  `monada` int(11) NOT NULL,
  `lastlevel` int(11) NOT NULL,
  `levelsCSV` text NOT NULL,
  `telikos_ypografwn` int(11) NOT NULL,
  `isET_Apofasi` int(11) NOT NULL,
  `is_orthi_epanalipsi` varchar(255) NOT NULL,
  `ETURL` text NOT NULL,
  `tags` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `ET_FEK` varchar(255) NOT NULL,
  `ET_FEK_tefxos` varchar(255) NOT NULL,
  `ET_FEK_etos` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `syntaktis_email` varchar(255) NOT NULL,
  `related_ADAs` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ada` (`ada`),
  KEY `lastlevel` (`lastlevel`),
  KEY `eidos_apofasis` (`eidos_apofasis`),
  KEY `monada` (`monada`),
  KEY `telikos_ypografwn` (`telikos_ypografwn`),
  KEY `status` (`status`),
  KEY `submission_timestamp` (`submission_timestamp`),
  KEY `apofasi_date` (`apofasi_date`),
  KEY `is_orthi_epanalipsi` (`is_orthi_epanalipsi`)
) ENGINE=InnoDB AUTO_INCREMENT=571816 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `apofaseis_batchids`
--

DROP TABLE IF EXISTS `apofaseis_batchids`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis_batchids` (
  `ID` int(11) NOT NULL,
  `ada` varchar(255) NOT NULL,
  `batch_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `apofaseis_deleted`
--

DROP TABLE IF EXISTS `apofaseis_deleted`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis_deleted` (
  `id` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) NOT NULL,
  `arithmos_protokolou` varchar(255) NOT NULL,
  `apofasi_date` date NOT NULL,
  `koinopoiiseis` text NOT NULL,
  `eidos_apofasis` int(11) NOT NULL,
  `thematiki` varchar(255) NOT NULL,
  `submission_timestamp` datetime NOT NULL,
  `comments` text NOT NULL,
  `thema` text NOT NULL,
  `monada` int(11) NOT NULL,
  `lastlevel` int(11) NOT NULL,
  `levelsCSV` text NOT NULL,
  `telikos_ypografwn` int(11) NOT NULL,
  `isET_Apofasi` int(11) NOT NULL,
  `ETURL` text NOT NULL,
  `tags` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `ET_FEK` varchar(255) NOT NULL,
  `ET_FEK_tefxos` varchar(255) NOT NULL,
  `ET_FEK_etos` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `syntaktis_email` varchar(255) NOT NULL,
  `related_ADAs` text NOT NULL,
  `deletion_reason` text NOT NULL,
  `deletion_timestamp` datetime NOT NULL,
  `deletion_user` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ada` (`ada`),
  KEY `lastlevel` (`lastlevel`),
  KEY `eidos_apofasis` (`eidos_apofasis`),
  KEY `monada` (`monada`),
  KEY `telikos_ypografwn` (`telikos_ypografwn`),
  KEY `status` (`status`),
  KEY `submission_timestamp` (`submission_timestamp`),
  KEY `apofasi_date` (`apofasi_date`)
) ENGINE=InnoDB AUTO_INCREMENT=851 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `apofaseis_deleted_old`
--

DROP TABLE IF EXISTS `apofaseis_deleted_old`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis_deleted_old` (
  `id` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) NOT NULL,
  `arithmos_protokolou` varchar(255) NOT NULL,
  `apofasi_date` date NOT NULL,
  `koinopoiiseis` text NOT NULL,
  `eidos_apofasis` int(11) NOT NULL,
  `thematiki` varchar(255) NOT NULL,
  `submission_timestamp` datetime NOT NULL,
  `comments` text NOT NULL,
  `thema` text NOT NULL,
  `monada` int(11) NOT NULL,
  `lastlevel` int(11) NOT NULL,
  `levelsCSV` text NOT NULL,
  `telikos_ypografwn` int(11) NOT NULL,
  `isET_Apofasi` int(11) NOT NULL,
  `ETURL` text NOT NULL,
  `tags` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `ET_FEK` varchar(255) NOT NULL,
  `ET_FEK_tefxos` varchar(255) NOT NULL,
  `ET_FEK_etos` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `syntaktis_email` varchar(255) NOT NULL,
  `related_ADAs` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ada` (`ada`),
  KEY `lastlevel` (`lastlevel`),
  KEY `eidos_apofasis` (`eidos_apofasis`),
  KEY `monada` (`monada`),
  KEY `telikos_ypografwn` (`telikos_ypografwn`),
  KEY `status` (`status`),
  KEY `submission_timestamp` (`submission_timestamp`),
  KEY `apofasi_date` (`apofasi_date`)
) ENGINE=InnoDB AUTO_INCREMENT=716 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `apofaseis_dynamic_fields_list`
--

DROP TABLE IF EXISTS `apofaseis_dynamic_fields_list`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis_dynamic_fields_list` (
  `ID` int(11) NOT NULL auto_increment,
  `eidi_apofaseon_ID` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `label` text NOT NULL,
  `extra_label` text NOT NULL,
  `fieldname` varchar(255) NOT NULL,
  `voc_table` varchar(255) NOT NULL,
  `validation_type` varchar(255) NOT NULL,
  `required` int(11) NOT NULL,
  UNIQUE KEY `ID` (`ID`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `apofaseis_dynamic_fields_values`
--

DROP TABLE IF EXISTS `apofaseis_dynamic_fields_values`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis_dynamic_fields_values` (
  `ID` int(11) NOT NULL auto_increment,
  `ada` varchar(255) NOT NULL,
  `dynamic_field_ID` int(11) NOT NULL,
  `field_value` text NOT NULL,
  `field_value_number` double NOT NULL,
  KEY `ID` (`ID`),
  KEY `ada` (`ada`),
  KEY `dynamic_field_ID` (`dynamic_field_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1034784 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `apofaseis_dynamic_fields_values_temp`
--

DROP TABLE IF EXISTS `apofaseis_dynamic_fields_values_temp`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis_dynamic_fields_values_temp` (
  `ID` int(11) NOT NULL,
  `ada` varchar(255) NOT NULL,
  `dynamic_field_ID` int(11) NOT NULL,
  `field_value` text NOT NULL,
  `field_value_number` double NOT NULL,
  KEY `ada` (`ada`),
  KEY `dynamic_field_ID` (`dynamic_field_ID`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `apofaseis_errors`
--

DROP TABLE IF EXISTS `apofaseis_errors`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis_errors` (
  `id` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) NOT NULL,
  `arithmos_protokolou` varchar(255) NOT NULL,
  `apofasi_date` date NOT NULL,
  `koinopoiiseis` text NOT NULL,
  `eidos_apofasis` int(11) NOT NULL,
  `thematiki` text NOT NULL,
  `submission_timestamp` datetime NOT NULL,
  `comments` text NOT NULL,
  `thema` text NOT NULL,
  `monada` int(11) NOT NULL,
  `lastlevel` int(11) NOT NULL,
  `levelsCSV` text NOT NULL,
  `telikos_ypografwn` int(11) NOT NULL,
  `isET_Apofasi` int(11) NOT NULL,
  `ETURL` text NOT NULL,
  `tags` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `ET_FEK` varchar(255) NOT NULL,
  `ET_FEK_tefxos` varchar(255) NOT NULL,
  `ET_FEK_etos` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `syntaktis_email` varchar(255) NOT NULL,
  `related_ADAs` text NOT NULL,
  `error_location` varchar(255) NOT NULL,
  `error_exception_message` varchar(255) NOT NULL,
  `error_headers` longtext NOT NULL,
  `error_timestamp` datetime NOT NULL,
  PRIMARY KEY  (`id`,`ada`),
  KEY `lastlevel` (`lastlevel`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `apofaseis_script_progress`
--

DROP TABLE IF EXISTS `apofaseis_script_progress`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis_script_progress` (
  `ID` int(11) NOT NULL,
  `last_ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `apofaseis_temp`
--

DROP TABLE IF EXISTS `apofaseis_temp`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `apofaseis_temp` (
  `id` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) NOT NULL,
  `arithmos_protokolou` varchar(255) NOT NULL,
  `apofasi_date` date NOT NULL,
  `koinopoiiseis` text NOT NULL,
  `eidos_apofasis` int(11) NOT NULL,
  `thematiki` varchar(255) NOT NULL,
  `submission_timestamp` datetime NOT NULL,
  `comments` text NOT NULL,
  `thema` text NOT NULL,
  `monada` int(11) NOT NULL,
  `lastlevel` int(11) NOT NULL,
  `levelsCSV` text NOT NULL,
  `telikos_ypografwn` int(11) NOT NULL,
  `isET_Apofasi` int(11) NOT NULL,
  `is_orthi_epanalipsi` varchar(255) NOT NULL,
  `ETURL` text NOT NULL,
  `tags` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `ET_FEK` varchar(255) NOT NULL,
  `ET_FEK_tefxos` varchar(255) NOT NULL,
  `ET_FEK_etos` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `syntaktis_email` varchar(255) NOT NULL,
  `related_ADAs` text NOT NULL,
  PRIMARY KEY  (`id`,`ada`),
  UNIQUE KEY `ada_2` (`ada`),
  KEY `ada` (`ada`),
  KEY `lastlevel` (`lastlevel`)
) ENGINE=InnoDB AUTO_INCREMENT=136174 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `auth`
--

DROP TABLE IF EXISTS `auth`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `auth` (
  `ID` int(11) NOT NULL auto_increment,
  `ypografontes_IDs` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `realm` varchar(255) NOT NULL,
  `ypourgeio_table` varchar(255) NOT NULL,
  `start_pb_id` varchar(255) NOT NULL,
  `ypourgeia_pb_id` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone_yp` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `last_login_timestamp` datetime NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `username` (`username`),
  KEY `password` (`password`),
  KEY `realm` (`realm`),
  KEY `ypourgeio_table` (`ypourgeio_table`),
  KEY `start_pb_id` (`start_pb_id`),
  KEY `ypourgeia_pb_id` (`ypourgeia_pb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12381 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `backup_apofaseis_dynamic_fields_values`
--

DROP TABLE IF EXISTS `backup_apofaseis_dynamic_fields_values`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `backup_apofaseis_dynamic_fields_values` (
  `ID` int(11) NOT NULL auto_increment,
  `ada` varchar(255) NOT NULL,
  `dynamic_field_ID` int(11) NOT NULL,
  `field_value` text NOT NULL,
  KEY `ID` (`ID`),
  KEY `ada` (`ada`),
  KEY `dynamic_field_ID` (`dynamic_field_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=637330 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `cpv`
--

DROP TABLE IF EXISTS `cpv`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cpv` (
  `ID` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `eidi_apofaseon`
--

DROP TABLE IF EXISTS `eidi_apofaseon`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eidi_apofaseon` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `hidden` int(11) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `et_fek_tefxos_names`
--

DROP TABLE IF EXISTS `et_fek_tefxos_names`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `et_fek_tefxos_names` (
  `ET_FEK_tefxos_ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `files` (
  `ID` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) character set utf8 NOT NULL,
  `original_filename` text character set utf8 NOT NULL,
  `signed_filename` text character set utf8 NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `ada` (`ada`)
) ENGINE=InnoDB AUTO_INCREMENT=280174 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `files_errors`
--

DROP TABLE IF EXISTS `files_errors`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `files_errors` (
  `ID` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) NOT NULL,
  `original` longblob NOT NULL,
  `original_filename` text NOT NULL,
  `signed` longblob NOT NULL,
  `signed_filename` text NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `files_temp`
--

DROP TABLE IF EXISTS `files_temp`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `files_temp` (
  `ID` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) character set utf8 NOT NULL,
  `original_filename` text character set utf8 NOT NULL,
  `signed_filename` text character set utf8 NOT NULL,
  `original` longblob NOT NULL,
  `signed` longblob NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `ada` (`ada`)
) ENGINE=InnoDB AUTO_INCREMENT=135846 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `files_text`
--

DROP TABLE IF EXISTS `files_text`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `files_text` (
  `ID` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `ada` (`ada`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM AUTO_INCREMENT=283281 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `foreis`
--

DROP TABLE IF EXISTS `foreis`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `foreis` (
  `id` int(11) NOT NULL auto_increment,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL,
  KEY `id` (`id`),
  KEY `pb_id` (`pb_id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=35737 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `foreis_all_editable_VIEW`
--

DROP TABLE IF EXISTS `foreis_all_editable_VIEW`;
/*!50001 DROP VIEW IF EXISTS `foreis_all_editable_VIEW`*/;
/*!50001 CREATE TABLE `foreis_all_editable_VIEW` (
  `id` int(11),
  `pb_id` varchar(255),
  `name` text,
  `pb_supervisor_id` varchar(255),
  `LEVEL` int(11),
  `hidden` int(11),
  `table_name` varchar(18)
) */;

--
-- Table structure for table `foreis_level0`
--

DROP TABLE IF EXISTS `foreis_level0`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `foreis_level0` (
  `id` int(11) NOT NULL auto_increment,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL,
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `level_2` (`level`),
  KEY `hidden` (`hidden`),
  KEY `ordering` (`ordering`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `foreis_mt`
--

DROP TABLE IF EXISTS `foreis_mt`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `foreis_mt` (
  `id` int(11) NOT NULL auto_increment,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL,
  KEY `id` (`id`),
  KEY `pb_id` (`pb_id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=22976 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `foreis_mt_backup`
--

DROP TABLE IF EXISTS `foreis_mt_backup`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `foreis_mt_backup` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL,
  KEY `id` (`id`),
  KEY `pb_id` (`pb_id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `kapodistrias`
--

DROP TABLE IF EXISTS `kapodistrias`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `kapodistrias` (
  `id` int(11) NOT NULL,
  `regionid` int(11) NOT NULL,
  `region` varchar(63) character set utf8 collate utf8_unicode_ci NOT NULL,
  `prefectureid` int(11) NOT NULL,
  `prefecture` varchar(63) NOT NULL,
  `adminprefectureid` int(11) NOT NULL,
  `adminprefecture` varchar(63) NOT NULL,
  `lgoid` int(11) NOT NULL,
  `lgotype` varchar(63) NOT NULL,
  `lgo` varchar(63) NOT NULL,
  KEY `regionid` (`regionid`),
  KEY `prefectureid` (`prefectureid`),
  KEY `adminprefectureid` (`adminprefectureid`),
  KEY `lgoid` (`lgoid`),
  KEY `lgotype` (`lgotype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `monades`
--

DROP TABLE IF EXISTS `monades`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `monades` (
  `ID` int(11) NOT NULL auto_increment,
  `ypourgeio_table_name` varchar(255) NOT NULL,
  `parent_pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `parent_pb_id` (`parent_pb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7675 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `monades_types`
--

DROP TABLE IF EXISTS `monades_types`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `monades_types` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `oda_master_members_ALL_VIEW`
--

DROP TABLE IF EXISTS `oda_master_members_ALL_VIEW`;
/*!50001 DROP VIEW IF EXISTS `oda_master_members_ALL_VIEW`*/;
/*!50001 CREATE TABLE `oda_master_members_ALL_VIEW` (
  `foreis_mt_name` text,
  `ID` int(11),
  `ypourgeia_pb_id` int(11),
  `foreas_pb_id` int(11),
  `foreas_allos` text,
  `dimos_lgoid` int(11),
  `diefthinsi` text,
  `arithmos` varchar(255),
  `TK` varchar(255),
  `timestamp` datetime,
  `uid` varchar(255),
  `contact_email` varchar(255),
  `foreas_afm` varchar(255),
  `foreas_url` varchar(255),
  `foreas_latin_name` varchar(255),
  `ypourgeio_to_check` varchar(255),
  `oda_members_foreas_type` int(11),
  `foreas_new_name` text,
  `support_contact_phone` varchar(255),
  `desired_password` varchar(255),
  `status` varchar(255),
  `foreas_label` text
) */;

--
-- Temporary table structure for view `oda_members_NOACTIVATION_VIEW`
--

DROP TABLE IF EXISTS `oda_members_NOACTIVATION_VIEW`;
/*!50001 DROP VIEW IF EXISTS `oda_members_NOACTIVATION_VIEW`*/;
/*!50001 CREATE TABLE `oda_members_NOACTIVATION_VIEW` (
  `ypourgeio_name` text,
  `name` text,
  `foreas_pb_id` int(11),
  `contact_email` varchar(255),
  `support_contact_phone` varchar(255)
) */;

--
-- Temporary table structure for view `oda_members_NOLOGIN_VIEW`
--

DROP TABLE IF EXISTS `oda_members_NOLOGIN_VIEW`;
/*!50001 DROP VIEW IF EXISTS `oda_members_NOLOGIN_VIEW`*/;
/*!50001 CREATE TABLE `oda_members_NOLOGIN_VIEW` (
  `ypourgeio_name` text,
  `name` text,
  `foreas_pb_id` int(11),
  `contact_email` varchar(255),
  `support_contact_phone` varchar(255)
) */;

--
-- Temporary table structure for view `oda_members_VIEW`
--

DROP TABLE IF EXISTS `oda_members_VIEW`;
/*!50001 DROP VIEW IF EXISTS `oda_members_VIEW`*/;
/*!50001 CREATE TABLE `oda_members_VIEW` (
  `ID` int(11),
  `foreas_pb_id` int(11),
  `name` text,
  `ypourgeio_name` text,
  `ypourgeio_pb_id` int(11),
  `foreas_url` varchar(255),
  `diefthinsi` text,
  `arithmos` varchar(255),
  `TK` varchar(255),
  `contact_email` varchar(255),
  `support_contact_phone` varchar(255),
  `onoma` varchar(255),
  `eponymo` varchar(255)
) */;

--
-- Table structure for table `oda_members_foreas_types`
--

DROP TABLE IF EXISTS `oda_members_foreas_types`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `oda_members_foreas_types` (
  `ID` int(11) NOT NULL auto_increment,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `oda_members_master`
--

DROP TABLE IF EXISTS `oda_members_master`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `oda_members_master` (
  `ID` int(11) NOT NULL auto_increment,
  `ypourgeia_pb_id` int(11) NOT NULL,
  `foreas_pb_id` int(11) NOT NULL,
  `foreas_allos` text NOT NULL,
  `dimos_lgoid` int(11) NOT NULL,
  `diefthinsi` text NOT NULL,
  `arithmos` varchar(255) NOT NULL,
  `TK` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL,
  `uid` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `foreas_afm` varchar(255) NOT NULL,
  `foreas_url` varchar(255) NOT NULL,
  `foreas_latin_name` varchar(255) NOT NULL,
  `ypourgeio_to_check` varchar(255) NOT NULL,
  `oda_members_foreas_type` int(11) NOT NULL,
  `foreas_new_name` text NOT NULL,
  `support_contact_phone` varchar(255) NOT NULL,
  `desired_password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `foreas_pb_id` (`foreas_pb_id`),
  KEY `ID` (`ID`),
  KEY `foreas_latin_name` (`foreas_latin_name`)
) ENGINE=MyISAM AUTO_INCREMENT=1295 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ode_members_files`
--

DROP TABLE IF EXISTS `ode_members_files`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ode_members_files` (
  `ID` int(11) NOT NULL auto_increment,
  `ode_members_master_ID` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_contents` longblob NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `ode_members_master_ID` (`ode_members_master_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=653 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ode_members_members`
--

DROP TABLE IF EXISTS `ode_members_members`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ode_members_members` (
  `ID` int(11) NOT NULL auto_increment,
  `ode_members_master_ID` int(11) NOT NULL,
  `onoma` varchar(255) NOT NULL,
  `eponymo` varchar(255) NOT NULL,
  `yphresia` text NOT NULL,
  `ypiresiako_til` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `idiotita` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `ID` (`ID`),
  KEY `ode_members_master_ID` (`ode_members_master_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4418 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `progress`
--

DROP TABLE IF EXISTS `progress`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `progress` (
  `ID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `RQUERY` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `sha2`
--

DROP TABLE IF EXISTS `sha2`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sha2` (
  `ID` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) character set utf8 NOT NULL,
  `sha2` varchar(255) character set utf8 NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `ada` (`ada`)
) ENGINE=InnoDB AUTO_INCREMENT=279924 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `sha2_temp`
--

DROP TABLE IF EXISTS `sha2_temp`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sha2_temp` (
  `ID` bigint(20) NOT NULL auto_increment,
  `ada` varchar(255) character set utf8 NOT NULL,
  `sha2` varchar(255) character set utf8 NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `ada` (`ada`)
) ENGINE=InnoDB AUTO_INCREMENT=249554 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `thematikes`
--

DROP TABLE IF EXISTS `thematikes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `thematikes` (
  `ID` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `hidden` int(11) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=584 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `top10_eidi_apofasewn`
--

DROP TABLE IF EXISTS `top10_eidi_apofasewn`;
/*!50001 DROP VIEW IF EXISTS `top10_eidi_apofasewn`*/;
/*!50001 CREATE TABLE `top10_eidi_apofasewn` (
  `Name` text,
  `PostCount` bigint(21)
) */;

--
-- Temporary table structure for view `top10_ypografontes`
--

DROP TABLE IF EXISTS `top10_ypografontes`;
/*!50001 DROP VIEW IF EXISTS `top10_ypografontes`*/;
/*!50001 CREATE TABLE `top10_ypografontes` (
  `ForeasID` int(11),
  `Title` varchar(255),
  `FirstName` varchar(255),
  `LastName` varchar(255),
  `PostCount` bigint(21)
) */;

--
-- Table structure for table `voc_dapanes_type`
--

DROP TABLE IF EXISTS `voc_dapanes_type`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `voc_dapanes_type` (
  `ID` int(11) NOT NULL auto_increment,
  `itemname` text NOT NULL,
  `itemvalue` text NOT NULL,
  `isSelected` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `voc_test`
--

DROP TABLE IF EXISTS `voc_test`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `voc_test` (
  `ID` int(11) NOT NULL auto_increment,
  `itemname` text NOT NULL,
  `itemvalue` text NOT NULL,
  `isSelected` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `yme`
--

DROP TABLE IF EXISTS `yme`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `yme` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `yp_xwris_ypourgeio`
--

DROP TABLE IF EXISTS `yp_xwris_ypourgeio`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `yp_xwris_ypourgeio` (
  `id` int(11) NOT NULL auto_increment,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=12756 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypaat`
--

DROP TABLE IF EXISTS `ypaat`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypaat` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypamyn`
--

DROP TABLE IF EXISTS `ypamyn`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypamyn` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypdik`
--

DROP TABLE IF EXISTS `ypdik`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypdik` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypeka`
--

DROP TABLE IF EXISTS `ypeka`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypeka` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypepikr`
--

DROP TABLE IF EXISTS `ypepikr`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypepikr` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypepth`
--

DROP TABLE IF EXISTS `ypepth`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypepth` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `yperg`
--

DROP TABLE IF EXISTS `yperg`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `yperg` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypes`
--

DROP TABLE IF EXISTS `ypes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypes` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL,
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypex`
--

DROP TABLE IF EXISTS `ypex`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypex` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypoan`
--

DROP TABLE IF EXISTS `ypoan`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypoan` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypografontes`
--

DROP TABLE IF EXISTS `ypografontes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypografontes` (
  `ID` int(11) NOT NULL auto_increment,
  `ypourgeio_table_name` varchar(255) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `monada_id` int(11) NOT NULL,
  `title_name` text NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `telephone_yp` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `en_energeia` int(11) NOT NULL,
  `monades_ID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `ypourgeio_table_name` (`ypourgeio_table_name`),
  KEY `pb_id` (`pb_id`),
  KEY `type_id` (`type_id`),
  KEY `en_energeia` (`en_energeia`),
  KEY `monades_ID` (`monades_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8580 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypografontes_types`
--

DROP TABLE IF EXISTS `ypografontes_types`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypografontes_types` (
  `ID` int(11) NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `importance` int(11) NOT NULL,
  `servicetype` varchar(255) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `type` (`type`),
  KEY `importance` (`importance`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypoiko`
--

DROP TABLE IF EXISTS `ypoiko`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypoiko` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypothyn`
--

DROP TABLE IF EXISTS `ypothyn`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypothyn` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ypourgeia`
--

DROP TABLE IF EXISTS `ypourgeia`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ypourgeia` (
  `ID` int(11) NOT NULL auto_increment,
  `pb_id` int(11) NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `ypourgeio_label` text NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `ID` (`ID`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `table_name` (`table_name`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `yppo`
--

DROP TABLE IF EXISTS `yppo`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `yppo` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `yppot`
--

DROP TABLE IF EXISTS `yppot`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `yppot` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `yyka`
--

DROP TABLE IF EXISTS `yyka`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `yyka` (
  `id` int(11) NOT NULL,
  `pb_id` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `pb_supervisor_id` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pb_id`),
  UNIQUE KEY `pb_id` (`pb_id`),
  UNIQUE KEY `id` (`id`),
  KEY `pb_supervisor_id` (`pb_supervisor_id`),
  KEY `level` (`level`),
  KEY `hidden` (`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `foreis_all_editable_VIEW`
--

/*!50001 DROP TABLE `foreis_all_editable_VIEW`*/;
/*!50001 DROP VIEW IF EXISTS `foreis_all_editable_VIEW`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`gkaramanolis`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `foreis_all_editable_VIEW` AS (select `apofaseis`.`foreis_mt`.`id` AS `id`,`apofaseis`.`foreis_mt`.`pb_id` AS `pb_id`,`apofaseis`.`foreis_mt`.`name` AS `name`,`apofaseis`.`foreis_mt`.`pb_supervisor_id` AS `pb_supervisor_id`,`apofaseis`.`foreis_mt`.`level` AS `LEVEL`,`apofaseis`.`foreis_mt`.`hidden` AS `hidden`,_utf8'foreis_mt' AS `table_name` from `foreis_mt`) union (select `apofaseis`.`yp_xwris_ypourgeio`.`id` AS `id`,`apofaseis`.`yp_xwris_ypourgeio`.`pb_id` AS `pb_id`,`apofaseis`.`yp_xwris_ypourgeio`.`name` AS `name`,`apofaseis`.`yp_xwris_ypourgeio`.`pb_supervisor_id` AS `pb_supervisor_id`,`apofaseis`.`yp_xwris_ypourgeio`.`level` AS `LEVEL`,`apofaseis`.`yp_xwris_ypourgeio`.`hidden` AS `hidden`,_utf8'yp_xwris_ypourgeio' AS `table_name` from `yp_xwris_ypourgeio`) order by `pb_id` */;

--
-- Final view structure for view `oda_master_members_ALL_VIEW`
--

/*!50001 DROP TABLE `oda_master_members_ALL_VIEW`*/;
/*!50001 DROP VIEW IF EXISTS `oda_master_members_ALL_VIEW`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`gkaramanolis`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `oda_master_members_ALL_VIEW` AS (select `apofaseis`.`foreis_mt`.`name` AS `foreis_mt_name`,`apofaseis`.`oda_members_master`.`ID` AS `ID`,`apofaseis`.`oda_members_master`.`ypourgeia_pb_id` AS `ypourgeia_pb_id`,`apofaseis`.`oda_members_master`.`foreas_pb_id` AS `foreas_pb_id`,`apofaseis`.`oda_members_master`.`foreas_allos` AS `foreas_allos`,`apofaseis`.`oda_members_master`.`dimos_lgoid` AS `dimos_lgoid`,`apofaseis`.`oda_members_master`.`diefthinsi` AS `diefthinsi`,`apofaseis`.`oda_members_master`.`arithmos` AS `arithmos`,`apofaseis`.`oda_members_master`.`TK` AS `TK`,`apofaseis`.`oda_members_master`.`timestamp` AS `timestamp`,`apofaseis`.`oda_members_master`.`uid` AS `uid`,`apofaseis`.`oda_members_master`.`contact_email` AS `contact_email`,`apofaseis`.`oda_members_master`.`foreas_afm` AS `foreas_afm`,`apofaseis`.`oda_members_master`.`foreas_url` AS `foreas_url`,`apofaseis`.`oda_members_master`.`foreas_latin_name` AS `foreas_latin_name`,`apofaseis`.`oda_members_master`.`ypourgeio_to_check` AS `ypourgeio_to_check`,`apofaseis`.`oda_members_master`.`oda_members_foreas_type` AS `oda_members_foreas_type`,`apofaseis`.`oda_members_master`.`foreas_new_name` AS `foreas_new_name`,`apofaseis`.`oda_members_master`.`support_contact_phone` AS `support_contact_phone`,`apofaseis`.`oda_members_master`.`desired_password` AS `desired_password`,`apofaseis`.`oda_members_master`.`status` AS `status`,`apofaseis`.`oda_members_master`.`foreas_allos` AS `foreas_label` from (`oda_members_master` join `foreis_mt`) where ((`apofaseis`.`oda_members_master`.`status` <> _utf8'2') and (`apofaseis`.`oda_members_master`.`foreas_pb_id` = `apofaseis`.`foreis_mt`.`pb_id`))) union (select `apofaseis`.`yp_xwris_ypourgeio`.`name` AS `yp_xwris_ypourgeio_name`,`apofaseis`.`oda_members_master`.`ID` AS `ID`,`apofaseis`.`oda_members_master`.`ypourgeia_pb_id` AS `ypourgeia_pb_id`,`apofaseis`.`oda_members_master`.`foreas_pb_id` AS `foreas_pb_id`,`apofaseis`.`oda_members_master`.`foreas_allos` AS `foreas_allos`,`apofaseis`.`oda_members_master`.`dimos_lgoid` AS `dimos_lgoid`,`apofaseis`.`oda_members_master`.`diefthinsi` AS `diefthinsi`,`apofaseis`.`oda_members_master`.`arithmos` AS `arithmos`,`apofaseis`.`oda_members_master`.`TK` AS `TK`,`apofaseis`.`oda_members_master`.`timestamp` AS `timestamp`,`apofaseis`.`oda_members_master`.`uid` AS `uid`,`apofaseis`.`oda_members_master`.`contact_email` AS `contact_email`,`apofaseis`.`oda_members_master`.`foreas_afm` AS `foreas_afm`,`apofaseis`.`oda_members_master`.`foreas_url` AS `foreas_url`,`apofaseis`.`oda_members_master`.`foreas_latin_name` AS `foreas_latin_name`,`apofaseis`.`oda_members_master`.`ypourgeio_to_check` AS `ypourgeio_to_check`,`apofaseis`.`oda_members_master`.`oda_members_foreas_type` AS `oda_members_foreas_type`,`apofaseis`.`oda_members_master`.`foreas_new_name` AS `foreas_new_name`,`apofaseis`.`oda_members_master`.`support_contact_phone` AS `support_contact_phone`,`apofaseis`.`oda_members_master`.`desired_password` AS `desired_password`,`apofaseis`.`oda_members_master`.`status` AS `status`,`apofaseis`.`oda_members_master`.`foreas_allos` AS `foreas_label` from (`oda_members_master` join `yp_xwris_ypourgeio`) where ((`apofaseis`.`oda_members_master`.`status` <> _utf8'2') and (`apofaseis`.`oda_members_master`.`foreas_pb_id` = `apofaseis`.`yp_xwris_ypourgeio`.`pb_id`))) union (select `apofaseis`.`ypourgeia`.`ypourgeio_label` AS `ypourgeia`,`apofaseis`.`oda_members_master`.`ID` AS `ID`,`apofaseis`.`oda_members_master`.`ypourgeia_pb_id` AS `ypourgeia_pb_id`,`apofaseis`.`oda_members_master`.`foreas_pb_id` AS `foreas_pb_id`,`apofaseis`.`oda_members_master`.`foreas_allos` AS `foreas_allos`,`apofaseis`.`oda_members_master`.`dimos_lgoid` AS `dimos_lgoid`,`apofaseis`.`oda_members_master`.`diefthinsi` AS `diefthinsi`,`apofaseis`.`oda_members_master`.`arithmos` AS `arithmos`,`apofaseis`.`oda_members_master`.`TK` AS `TK`,`apofaseis`.`oda_members_master`.`timestamp` AS `timestamp`,`apofaseis`.`oda_members_master`.`uid` AS `uid`,`apofaseis`.`oda_members_master`.`contact_email` AS `contact_email`,`apofaseis`.`oda_members_master`.`foreas_afm` AS `foreas_afm`,`apofaseis`.`oda_members_master`.`foreas_url` AS `foreas_url`,`apofaseis`.`oda_members_master`.`foreas_latin_name` AS `foreas_latin_name`,`apofaseis`.`oda_members_master`.`ypourgeio_to_check` AS `ypourgeio_to_check`,`apofaseis`.`oda_members_master`.`oda_members_foreas_type` AS `oda_members_foreas_type`,`apofaseis`.`oda_members_master`.`foreas_new_name` AS `foreas_new_name`,`apofaseis`.`oda_members_master`.`support_contact_phone` AS `support_contact_phone`,`apofaseis`.`oda_members_master`.`desired_password` AS `desired_password`,`apofaseis`.`oda_members_master`.`status` AS `status`,`apofaseis`.`oda_members_master`.`foreas_allos` AS `foreas_label` from (`oda_members_master` join `ypourgeia`) where ((`apofaseis`.`oda_members_master`.`status` <> _utf8'2') and (`apofaseis`.`oda_members_master`.`foreas_pb_id` = `apofaseis`.`ypourgeia`.`pb_id`))) order by _utf8'status',`timestamp` */;

--
-- Final view structure for view `oda_members_NOACTIVATION_VIEW`
--

/*!50001 DROP TABLE `oda_members_NOACTIVATION_VIEW`*/;
/*!50001 DROP VIEW IF EXISTS `oda_members_NOACTIVATION_VIEW`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`gkaramanolis`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `oda_members_NOACTIVATION_VIEW` AS select `apofaseis`.`oda_members_VIEW`.`ypourgeio_name` AS `ypourgeio_name`,`apofaseis`.`oda_members_VIEW`.`name` AS `name`,`apofaseis`.`oda_members_VIEW`.`foreas_pb_id` AS `foreas_pb_id`,`apofaseis`.`oda_members_VIEW`.`contact_email` AS `contact_email`,`apofaseis`.`oda_members_VIEW`.`support_contact_phone` AS `support_contact_phone` from (`oda_members_VIEW` join `oda_members_master`) where ((`apofaseis`.`oda_members_master`.`ID` = `apofaseis`.`oda_members_VIEW`.`ID`) and (`apofaseis`.`oda_members_master`.`status` <> 1) and (`apofaseis`.`oda_members_master`.`status` <> 2)) */;

--
-- Final view structure for view `oda_members_NOLOGIN_VIEW`
--

/*!50001 DROP TABLE `oda_members_NOLOGIN_VIEW`*/;
/*!50001 DROP VIEW IF EXISTS `oda_members_NOLOGIN_VIEW`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`gkaramanolis`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `oda_members_NOLOGIN_VIEW` AS select `apofaseis`.`oda_members_VIEW`.`ypourgeio_name` AS `ypourgeio_name`,`apofaseis`.`oda_members_VIEW`.`name` AS `name`,`apofaseis`.`oda_members_VIEW`.`foreas_pb_id` AS `foreas_pb_id`,`apofaseis`.`oda_members_VIEW`.`contact_email` AS `contact_email`,`apofaseis`.`oda_members_VIEW`.`support_contact_phone` AS `support_contact_phone` from (`oda_members_VIEW` join `foreis_mt`) where ((`apofaseis`.`foreis_mt`.`pb_id` = `apofaseis`.`oda_members_VIEW`.`foreas_pb_id`) and ((select `apofaseis`.`auth`.`username` AS `username` from `auth` where ((`apofaseis`.`auth`.`username` = concat(`apofaseis`.`oda_members_VIEW`.`foreas_pb_id`,_utf8'_admin')) and (`apofaseis`.`auth`.`last_login_timestamp` = _utf8'0000-00-00 00:00:00'))) = concat(`apofaseis`.`oda_members_VIEW`.`foreas_pb_id`,_utf8'_admin'))) union select `apofaseis`.`oda_members_VIEW`.`ypourgeio_name` AS `ypourgeio_name`,`apofaseis`.`oda_members_VIEW`.`name` AS `name`,`apofaseis`.`oda_members_VIEW`.`foreas_pb_id` AS `foreas_pb_id`,`apofaseis`.`oda_members_VIEW`.`contact_email` AS `contact_email`,`apofaseis`.`oda_members_VIEW`.`support_contact_phone` AS `support_contact_phone` from (`oda_members_VIEW` join `yp_xwris_ypourgeio`) where ((`apofaseis`.`yp_xwris_ypourgeio`.`pb_id` = `apofaseis`.`oda_members_VIEW`.`foreas_pb_id`) and ((select `apofaseis`.`auth`.`username` AS `username` from `auth` where ((`apofaseis`.`auth`.`username` = concat(`apofaseis`.`oda_members_VIEW`.`foreas_pb_id`,_utf8'_admin')) and (`apofaseis`.`auth`.`last_login_timestamp` = _utf8'0000-00-00 00:00:00'))) = concat(`apofaseis`.`oda_members_VIEW`.`foreas_pb_id`,_utf8'_admin'))) */;

--
-- Final view structure for view `oda_members_VIEW`
--

/*!50001 DROP TABLE `oda_members_VIEW`*/;
/*!50001 DROP VIEW IF EXISTS `oda_members_VIEW`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`gkaramanolis`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `oda_members_VIEW` AS (select `apofaseis`.`oda_members_master`.`ID` AS `ID`,`apofaseis`.`oda_members_master`.`foreas_pb_id` AS `foreas_pb_id`,`apofaseis`.`foreis_mt`.`name` AS `name`,`apofaseis`.`ypourgeia`.`ypourgeio_label` AS `ypourgeio_name`,`apofaseis`.`ypourgeia`.`pb_id` AS `ypourgeio_pb_id`,`apofaseis`.`oda_members_master`.`foreas_url` AS `foreas_url`,`apofaseis`.`oda_members_master`.`diefthinsi` AS `diefthinsi`,`apofaseis`.`oda_members_master`.`arithmos` AS `arithmos`,`apofaseis`.`oda_members_master`.`TK` AS `TK`,`apofaseis`.`oda_members_master`.`contact_email` AS `contact_email`,`apofaseis`.`oda_members_master`.`support_contact_phone` AS `support_contact_phone`,`apofaseis`.`ode_members_members`.`onoma` AS `onoma`,`apofaseis`.`ode_members_members`.`eponymo` AS `eponymo` from (((`oda_members_master` join `ode_members_members`) join `foreis_mt`) join `ypourgeia`) where ((`apofaseis`.`ode_members_members`.`ode_members_master_ID` = `apofaseis`.`oda_members_master`.`ID`) and (`apofaseis`.`ode_members_members`.`ID` = (select min(`apofaseis`.`ode_members_members`.`ID`) AS `min(ID)` from `ode_members_members` where (`apofaseis`.`ode_members_members`.`ode_members_master_ID` = `apofaseis`.`oda_members_master`.`ID`))) and (`apofaseis`.`foreis_mt`.`pb_id` = `apofaseis`.`oda_members_master`.`foreas_pb_id`) and (`apofaseis`.`ypourgeia`.`pb_id` = `apofaseis`.`oda_members_master`.`ypourgeia_pb_id`))) union (select `apofaseis`.`oda_members_master`.`ID` AS `ID`,`apofaseis`.`oda_members_master`.`foreas_pb_id` AS `foreas_pb_id`,`apofaseis`.`yp_xwris_ypourgeio`.`name` AS `name`,`apofaseis`.`ypourgeia`.`ypourgeio_label` AS `ypourgeio_name`,`apofaseis`.`ypourgeia`.`pb_id` AS `ypourgeio_pb_id`,`apofaseis`.`oda_members_master`.`foreas_url` AS `foreas_url`,`apofaseis`.`oda_members_master`.`diefthinsi` AS `diefthinsi`,`apofaseis`.`oda_members_master`.`arithmos` AS `arithmos`,`apofaseis`.`oda_members_master`.`TK` AS `TK`,`apofaseis`.`oda_members_master`.`contact_email` AS `contact_email`,`apofaseis`.`oda_members_master`.`support_contact_phone` AS `support_contact_phone`,`apofaseis`.`ode_members_members`.`onoma` AS `onoma`,`apofaseis`.`ode_members_members`.`eponymo` AS `eponymo` from (((`oda_members_master` join `ode_members_members`) join `yp_xwris_ypourgeio`) join `ypourgeia`) where ((`apofaseis`.`ode_members_members`.`ode_members_master_ID` = `apofaseis`.`oda_members_master`.`ID`) and (`apofaseis`.`ode_members_members`.`ID` = (select min(`apofaseis`.`ode_members_members`.`ID`) AS `min(ID)` from `ode_members_members` where (`apofaseis`.`ode_members_members`.`ode_members_master_ID` = `apofaseis`.`oda_members_master`.`ID`))) and (`apofaseis`.`yp_xwris_ypourgeio`.`pb_id` = `apofaseis`.`oda_members_master`.`foreas_pb_id`) and (`apofaseis`.`ypourgeia`.`pb_id` = `apofaseis`.`oda_members_master`.`ypourgeia_pb_id`))) union (select `apofaseis`.`oda_members_master`.`ID` AS `ID`,`apofaseis`.`oda_members_master`.`foreas_pb_id` AS `foreas_pb_id`,`apofaseis`.`ypourgeia`.`ypourgeio_label` AS `name`,`apofaseis`.`ypourgeia`.`ypourgeio_label` AS `ypourgeio_name`,`apofaseis`.`ypourgeia`.`pb_id` AS `ypourgeio_pb_id`,`apofaseis`.`oda_members_master`.`foreas_url` AS `foreas_url`,`apofaseis`.`oda_members_master`.`diefthinsi` AS `diefthinsi`,`apofaseis`.`oda_members_master`.`arithmos` AS `arithmos`,`apofaseis`.`oda_members_master`.`TK` AS `TK`,`apofaseis`.`oda_members_master`.`contact_email` AS `contact_email`,`apofaseis`.`oda_members_master`.`support_contact_phone` AS `support_contact_phone`,`apofaseis`.`ode_members_members`.`onoma` AS `onoma`,`apofaseis`.`ode_members_members`.`eponymo` AS `eponymo` from ((`oda_members_master` join `ode_members_members`) join `ypourgeia`) where ((`apofaseis`.`ode_members_members`.`ode_members_master_ID` = `apofaseis`.`oda_members_master`.`ID`) and (`apofaseis`.`ode_members_members`.`ID` = (select min(`apofaseis`.`ode_members_members`.`ID`) AS `min(ID)` from `ode_members_members` where (`apofaseis`.`ode_members_members`.`ode_members_master_ID` = `apofaseis`.`oda_members_master`.`ID`))) and (`apofaseis`.`ypourgeia`.`pb_id` = `apofaseis`.`oda_members_master`.`foreas_pb_id`))) order by `ID` */;

--
-- Final view structure for view `top10_eidi_apofasewn`
--

/*!50001 DROP TABLE `top10_eidi_apofasewn`*/;
/*!50001 DROP VIEW IF EXISTS `top10_eidi_apofasewn`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`gkaramanolis`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `top10_eidi_apofasewn` AS select `apofaseis`.`eidi_apofaseon`.`name` AS `Name`,count(`apofaseis`.`apofaseis`.`eidos_apofasis`) AS `PostCount` from (`apofaseis` join `eidi_apofaseon`) where (`apofaseis`.`apofaseis`.`eidos_apofasis` = `apofaseis`.`eidi_apofaseon`.`ID`) group by `apofaseis`.`apofaseis`.`eidos_apofasis` order by count(`apofaseis`.`apofaseis`.`eidos_apofasis`) desc limit 0,10 */;

--
-- Final view structure for view `top10_ypografontes`
--

/*!50001 DROP TABLE `top10_ypografontes`*/;
/*!50001 DROP VIEW IF EXISTS `top10_ypografontes`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`gkaramanolis`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `top10_ypografontes` AS select `apofaseis`.`apofaseis`.`lastlevel` AS `ForeasID`,`apofaseis`.`ypografontes_types`.`name` AS `Title`,`apofaseis`.`ypografontes`.`firstname` AS `FirstName`,`apofaseis`.`ypografontes`.`lastname` AS `LastName`,count(`apofaseis`.`apofaseis`.`telikos_ypografwn`) AS `PostCount` from ((`apofaseis` join `ypografontes`) join `ypografontes_types`) where ((`apofaseis`.`apofaseis`.`telikos_ypografwn` = `apofaseis`.`ypografontes`.`ID`) and (`apofaseis`.`ypografontes`.`type_id` = `apofaseis`.`ypografontes_types`.`ID`)) group by `apofaseis`.`apofaseis`.`telikos_ypografwn` order by count(`apofaseis`.`apofaseis`.`telikos_ypografwn`) desc limit 0,10 */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-02-07  6:43:01
