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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ads` (`id`, `title`, `content`, `address_street`, `address_zip`, `address_city`, `date_created`, `date_updated`, `date_expire`, `user_id`) VALUES
(1,	'Test ad 1',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ornare lacinia sapien sed congue. Suspendisse dignissim eros non nisl rhoncus convallis. Sed consequat venenatis lobortis. Sed luctus auctor nisl ut posuere. Mauris tincidunt maximus risus, ac dignissim ipsum dignissim eu. Integer pharetra leo nec luctus cursus. Nunc ut lobortis nulla, ac pulvinar massa. Phasellus sit amet arcu a metus accumsan egestas id non ante. Aenean at massa dapibus, convallis quam in, cursus metus. Nunc venenatis ante eu congue porta. Praesent ac velit a massa viverra sollicitudin. Sed accumsan dolor sed turpis tincidunt facilisis. Phasellus ut rutrum tortor, quis volutpat odio. Donec porta purus nunc, in faucibus sem hendrerit eu.',	'',	0,	'',	0,	0,	0,	1),
(2,	'Test ad 2',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ornare lacinia sapien sed congue. Suspendisse dignissim eros non nisl rhoncus convallis. Sed consequat venenatis lobortis. Sed luctus auctor nisl ut posuere. Mauris tincidunt maximus risus, ac dignissim ipsum dignissim eu. Integer pharetra leo nec luctus cursus. Nunc ut lobortis nulla, ac pulvinar massa. Phasellus sit amet arcu a metus accumsan egestas id non ante. Aenean at massa dapibus, convallis quam in, cursus metus. Nunc venenatis ante eu congue porta. Praesent ac velit a massa viverra sollicitudin. Sed accumsan dolor sed turpis tincidunt facilisis. Phasellus ut rutrum tortor, quis volutpat odio. Donec porta purus nunc, in faucibus sem hendrerit eu.',	'',	0,	'',	0,	0,	0,	1),
(3,	'Test ad 3',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ornare lacinia sapien sed congue. Suspendisse dignissim eros non nisl rhoncus convallis. Sed consequat venenatis lobortis. Sed luctus auctor nisl ut posuere. Mauris tincidunt maximus risus, ac dignissim ipsum dignissim eu. Integer pharetra leo nec luctus cursus. Nunc ut lobortis nulla, ac pulvinar massa. Phasellus sit amet arcu a metus accumsan egestas id non ante. Aenean at massa dapibus, convallis quam in, cursus metus. Nunc venenatis ante eu congue porta. Praesent ac velit a massa viverra sollicitudin. Sed accumsan dolor sed turpis tincidunt facilisis. Phasellus ut rutrum tortor, quis volutpat odio. Donec porta purus nunc, in faucibus sem hendrerit eu.',	'',	0,	'',	0,	0,	0,	2),
(6,	'hej hej test',	'nu tar jag helg',	'',	0,	'',	0,	0,	0,	1),
(7,	'Ny annons',	'Jag lÃ¥nar ut min ljusslinga under Ã¥ret.',	'',	0,	'',	0,	0,	0,	1),
(8,	'Kaffekopp sÃ¶kes',	'Jag Ã¤r kaffesugen och behÃ¶ver mer koffein. Helst fÃ¶r en halvtimme sedan. ',	'Pelargatan 4',	68432,	'Munkfors',	0,	0,	1452297600,	1),
(9,	'Ã„nnu en annons',	'hej hej hej hej hej',	'Pelargatan 4',	68432,	'Munkfors',	0,	0,	1452470400,	1);

DROP TABLE IF EXISTS `ad_has_tag`;
CREATE TABLE `ad_has_tag` (
  `ad_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


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

-- 2016-01-04 14:42:11
