# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.17)
# Database: skyway_db
# Generation Time: 2017-06-22 13:41:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table status_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `status_log`;

CREATE TABLE `status_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `fl511_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table weather_locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `weather_locations`;

CREATE TABLE `weather_locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(30) DEFAULT '',
  `state` varchar(2) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table weather_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `weather_log`;

CREATE TABLE `weather_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `request_datetime` datetime DEFAULT NULL,
  `weather_locations_id` int(11) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `station_id` varchar(30) DEFAULT NULL,
  `observation_time` varchar(40) DEFAULT NULL,
  `observation_epoch` int(11) DEFAULT NULL,
  `local_epoch` int(11) DEFAULT NULL,
  `temp_f` decimal(3,1) DEFAULT NULL,
  `temp_c` decimal(3,1) DEFAULT NULL,
  `relative_humidity` varchar(4) DEFAULT NULL,
  `wind_dir` varchar(6) DEFAULT NULL,
  `wind_degrees` int(4) DEFAULT NULL,
  `wind_mph` decimal(4,1) DEFAULT NULL,
  `wind_gust_mph` decimal(4,1) DEFAULT NULL,
  `wind_kph` decimal(4,1) DEFAULT NULL,
  `wind_gust_kph` decimal(4,1) DEFAULT NULL,
  `pressure_mb` int(6) DEFAULT NULL,
  `pressure_in` decimal(4,2) DEFAULT NULL,
  `pressure_trend` varchar(6) DEFAULT NULL,
  `visibility_mi` decimal(3,1) DEFAULT NULL,
  `visibility_km` decimal(3,1) DEFAULT NULL,
  `precip_1hr_in` decimal(5,4) DEFAULT NULL,
  `precip_1hr_metric` decimal(5,4) DEFAULT NULL,
  `precip_today_in` decimal(5,4) DEFAULT NULL,
  `precip_today_metric` decimal(5,4) DEFAULT NULL,
  `icon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
