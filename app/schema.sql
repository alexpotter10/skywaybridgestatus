# ************************************************************
# Generation Time: 2019-01-11 17:12:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table active_statuses
# ------------------------------------------------------------

CREATE TABLE `active_statuses` (
   `source` VARCHAR(5) NOT NULL DEFAULT '',
   `location` VARCHAR(255) NULL DEFAULT NULL,
   `message` VARCHAR(255) NULL DEFAULT NULL,
   `last_fetched` DATETIME NULL DEFAULT NULL
) ENGINE=MyISAM;



# Dump of table fl511_log
# ------------------------------------------------------------

CREATE TABLE `fl511_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `region` varchar(55) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `last_updated` varchar(55) DEFAULT NULL,
  `request_datetime` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table flhsmv_log
# ------------------------------------------------------------

CREATE TABLE `flhsmv_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` varchar(24) DEFAULT '',
  `object_id` int(8) DEFAULT NULL,
  `dispatch_center` varchar(5) DEFAULT NULL,
  `incident_date` varchar(11) DEFAULT NULL,
  `incident_time` varchar(11) DEFAULT NULL,
  `urgency` varchar(4) DEFAULT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `lon` decimal(11,8) DEFAULT NULL,
  `event_type` varchar(200) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `dispatch_time` varchar(8) DEFAULT NULL,
  `arrival_time` varchar(10) DEFAULT NULL,
  `geometry_x` decimal(11,8) DEFAULT NULL,
  `geometry_y` decimal(11,8) DEFAULT NULL,
  `request_datetime` datetime NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table planned_closures
# ------------------------------------------------------------

CREATE TABLE `planned_closures` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `reason` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(225) DEFAULT NULL,
  `closed_direction` varchar(120) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table skywaywx_log
# ------------------------------------------------------------

CREATE TABLE `skywaywx_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `wind_speed` decimal(3,1) DEFAULT NULL,
  `wind_direction` int(3) DEFAULT NULL,
  `wind_gust` decimal(3,1) DEFAULT NULL,
  `air_temperature` decimal(3,1) DEFAULT NULL,
  `relative_humidity` decimal(3,1) DEFAULT NULL,
  `pressure_mb` varchar(5) DEFAULT '',
  `precip_1h` decimal(2,1) DEFAULT NULL,
  `precip_today` decimal(2,1) DEFAULT NULL,
  `observation_datetime` datetime DEFAULT NULL,
  `request_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table status_log
# ------------------------------------------------------------

CREATE TABLE `status_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `fl511_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table weather_locations
# ------------------------------------------------------------

CREATE TABLE `weather_locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(30) DEFAULT '',
  `state` varchar(2) DEFAULT '',
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table weather_log
# ------------------------------------------------------------

CREATE TABLE `weather_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `request_datetime` datetime DEFAULT NULL,
  `weather_locations_id` int(11) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `station_id` varchar(30) DEFAULT NULL,
  `observation_time` varchar(40) DEFAULT NULL,
  `observation_epoch` int(11) DEFAULT NULL,
  `local_epoch` int(11) DEFAULT NULL,
  `weather` varchar(40) DEFAULT NULL,
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





# Replace placeholder table for active_statuses with correct view syntax
# ------------------------------------------------------------

DROP TABLE `active_statuses`;

CREATE VIEW `active_statuses`
AS SELECT
   'FHP' AS `source`,
   `flhsmv_log`.`county` AS `location`,
   `flhsmv_log`.`remarks` AS `message`,
   `flhsmv_log`.`request_datetime` AS `last_fetched`
FROM `flhsmv_log` where (`flhsmv_log`.`active` = 1) union select 'FL511' AS `source`,`fl511_log`.`county` AS `location`,`fl511_log`.`message` AS `message`,`fl511_log`.`request_datetime` AS `last_fetched` from `fl511_log` where (`fl511_log`.`active` = 1);

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
