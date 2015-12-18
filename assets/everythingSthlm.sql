-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `everythingSthlm` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `everythingSthlm`;

CREATE TABLE `ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `img_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `img_filetype` varchar(10) COLLATE utf8_bin NOT NULL,
  `date_created` date NOT NULL,
  `date_expire` date NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adress_city` varchar(50) COLLATE utf8_bin NOT NULL,
  `adress_street` varchar(100) COLLATE utf8_bin NOT NULL,
  `adress_zip` int(10) unsigned NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `phone` int(15) unsigned NOT NULL,
  `username` varchar(30) COLLATE utf8_bin NOT NULL,
  `password` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- 2015-12-18 15:05:25