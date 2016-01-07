-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `address_street` varchar(200) COLLATE utf8_bin NOT NULL,
  `address_zip` int(11) NOT NULL,
  `address_city` varchar(100) COLLATE utf8_bin NOT NULL,
  `date_created` int(10) unsigned NOT NULL,
  `date_updated` int(11) unsigned NOT NULL,
  `date_expire` int(10) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `ad_type` int(10) unsigned NOT NULL,
  `payment` varchar(250) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ads` (`id`, `title`, `content`, `address_street`, `address_zip`, `address_city`, `date_created`, `date_updated`, `date_expire`, `user_id`, `ad_type`, `payment`) VALUES
(2,	'Test ad 2',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ornare lacinia sapien sed congue. Suspendisse dignissim eros non nisl rhoncus convallis. Sed consequat venenatis lobortis. Sed luctus auctor nisl ut posuere. Mauris tincidunt maximus risus, ac dignissim ipsum dignissim eu. Integer pharetra leo nec luctus cursus. Nunc ut lobortis nulla, ac pulvinar massa. Phasellus sit amet arcu a metus accumsan egestas id non ante. Aenean at massa dapibus, convallis quam in, cursus metus. Nunc venenatis ante eu congue porta. Praesent ac velit a massa viverra sollicitudin. Sed accumsan dolor sed turpis tincidunt facilisis. Phasellus ut rutrum tortor, quis volutpat odio. Donec porta purus nunc, in faucibus sem hendrerit eu.',	'',	0,	'',	0,	0,	1452384000,	1,	1,	'Vinflaska'),
(3,	'Test ad 3',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ornare lacinia sapien sed congue. Suspendisse dignissim eros non nisl rhoncus convallis. Sed consequat venenatis lobortis. Sed luctus auctor nisl ut posuere. Mauris tincidunt maximus risus, ac dignissim ipsum dignissim eu. Integer pharetra leo nec luctus cursus. Nunc ut lobortis nulla, ac pulvinar massa. Phasellus sit amet arcu a metus accumsan egestas id non ante. Aenean at massa dapibus, convallis quam in, cursus metus. Nunc venenatis ante eu congue porta. Praesent ac velit a massa viverra sollicitudin. Sed accumsan dolor sed turpis tincidunt facilisis. Phasellus ut rutrum tortor, quis volutpat odio. Donec porta purus nunc, in faucibus sem hendrerit eu.',	'',	0,	'',	0,	0,	0,	2,	0,	''),
(6,	'hej hej test',	'nu tar jag helg',	'',	0,	'',	0,	0,	0,	1,	0,	''),
(7,	'Ljusslinga',	'Jag lÃ¥nar ut min ljusslinga under Ã¥ret.',	'',	0,	'',	0,	0,	1452384000,	1,	2,	''),
(8,	'Kaffekopp sÃ¶kes',	'Jag Ã¤r kaffesugen och behÃ¶ver mer koffein. Helst fÃ¶r en halvtimme sedan. ',	'Pelargatan 4',	68432,	'Munkfors',	0,	0,	1452297600,	1,	0,	''),
(9,	'Ã„nnu en annons',	'hej hej hej hej hej',	'Pelargatan 4',	68432,	'Munkfors',	0,	0,	1452470400,	1,	0,	''),
(10,	'hejhej',	'hejehjeheejjej jkjkj',	'Pelargatan 4',	68432,	'Munkfors',	0,	0,	1452556800,	1,	0,	''),
(12,	'testar dropdown',	'hej hej hello',	'Pelargatan 4',	68432,	'Munkfors',	1451992722,	0,	1452556800,	1,	0,	''),
(14,	'testar igen',	'hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej och sÃ¥ vidare',	'Pelargatan 4',	68432,	'Munkfors',	1452075801,	0,	1452556800,	1,	0,	''),
(15,	'Litet test igen',	'Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test .',	'Pelargatan 4',	68432,	'Munkfors',	1452092204,	0,	1452643200,	1,	3,	''),
(16,	'Limpa',	'Halv limpa lÃ¥nas ut till helgen.',	'Pelargatan 4',	68432,	'Hornstull',	1452162435,	0,	1452729600,	1,	3,	'');

DROP TABLE IF EXISTS `ad_has_tag`;
CREATE TABLE `ad_has_tag` (
  `ad_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ad_has_tag` (`ad_id`, `tag_id`) VALUES
(16,	5),
(16,	4),
(2,	3);

DROP TABLE IF EXISTS `ad_types`;
CREATE TABLE `ad_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ad_types` (`id`, `name`) VALUES
(1,	'Jag efterlyser'),
(2,	'Jag lånar ut'),
(3,	'Byte');

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `tags` (`id`, `name`) VALUES
(1,	'Fordon'),
(2,	'Trädgård'),
(3,	'Fest'),
(4,	'Verktyg'),
(5,	'Diverse'),
(6,	'Usla julklappar');

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_id` int(10) unsigned NOT NULL,
  `name` varchar(200) COLLATE utf8_bin NOT NULL,
  `ext` varchar(4) COLLATE utf8_bin NOT NULL,
  `folder` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(100) COLLATE utf8_bin NOT NULL,
  `address_city` varchar(50) COLLATE utf8_bin NOT NULL,
  `address_street` varchar(100) COLLATE utf8_bin NOT NULL,
  `address_zip` int(10) unsigned NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `phone` int(15) unsigned NOT NULL,
  `password` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `user` (`id`, `firstname`, `lastname`, `address_city`, `address_street`, `address_zip`, `email`, `phone`, `password`) VALUES
(1,	'Per',	'i Hagen',	'Munkfors',	'Pelargatan 4',	68432,	'nacho@taco.com',	0,	'58ecff21ea6428c821b117958339a14fcfe63320'),
(2,	'',	'',	'',	'',	12147,	'',	0,	'');

-- 2016-01-07 11:58:39
