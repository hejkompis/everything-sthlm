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
  `active` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ads` (`id`, `title`, `content`, `address_street`, `address_zip`, `address_city`, `date_created`, `date_updated`, `date_expire`, `user_id`, `ad_type`, `payment`, `active`, `image`) VALUES
(3, 'Test ad 3',  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ornare lacinia sapien sed congue. Suspendisse dignissim eros non nisl rhoncus convallis. Sed consequat venenatis lobortis. Sed luctus auctor nisl ut posuere. Mauris tincidunt maximus risus, ac dignissim ipsum dignissim eu. Integer pharetra leo nec luctus cursus. Nunc ut lobortis nulla, ac pulvinar massa. Phasellus sit amet arcu a metus accumsan egestas id non ante. Aenean at massa dapibus, convallis quam in, cursus metus. Nunc venenatis ante eu congue porta. Praesent ac velit a massa viverra sollicitudin. Sed accumsan dolor sed turpis tincidunt facilisis. Phasellus ut rutrum tortor, quis volutpat odio. Donec porta purus nunc, in faucibus sem hendrerit eu.',  '', 0,  '', 0,  0,  0,  2,  0,  '', 1,  ''),
(6, 'Weekend trading',  'Nu tar jag helg. JorÃ¥satte.', 'Borgargatan 8',  12345,  'Hornstull',  0,  0,  1454630400, 1,  2,  'GÃ¤rna en chokladkaka.', 1,  ''),
(7, 'Hannah Ã¤r smart', 'She apparently grew a brain at last',  '', 0,  '', 0,  0,  1452902400, 1,  1,  'Amanda', 0,  ''),
(8, 'Kaffekopp sökes',  'Jag är kaffesugen och behöver mer koffein. Helst för en halvtimme sedan. ',  'Pelargatan 4', 68432,  'Munkfors', 0,  1453051459, 1453656259, 1,  1,  '', 1,  '71ETlOSCNlL._SL1500__1453053219.jpg'),
(9, 'Ã„nnu en annons',  'hej hej hej hej hej',  'Pelargatan 4', 68432,  'Munkfors', 0,  0,  1455148800, 1,  0,  '', 1,  ''),
(10,  'hejhej', 'hejehjeheejjej jkjkj', 'Pelargatan 4', 68432,  'Munkfors', 0,  0,  1455235200, 1,  0,  '', 0,  ''),
(12,  'testar dropdown',  'hej hej hello',  'Pelargatan 4', 68432,  'Munkfors', 1451992722, 0,  1452556800, 1,  0,  '', 0,  ''),
(14,  'testar igen',  'hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej hej och sÃ¥ vidare', 'Pelargatan 4', 68432,  'Munkfors', 1452075801, 0,  1452556800, 1,  0,  '', 0,  ''),
(15,  'Litet test igen',  'Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test Teeest test test .', 'Pelargatan 4', 68432,  'Munkfors', 1452092204, 0,  1452643200, 1,  3,  '', 0,  ''),
(17,  'Kaffe bytes',  'hjhjs ashdjashdjasd askasjdhjsad \r\nhej hej', 'PingstvÃ¤gen 34',  12636,  'HÃ¤gersten', 1452250035, 0,  1453248000, 3,  3,  'Te', 1,  '');

DROP TABLE IF EXISTS `ad_has_tag`;
CREATE TABLE `ad_has_tag` (
  `ad_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ad_has_tag` (`ad_id`, `tag_id`) VALUES
(16,  5),
(16,  4),
(2, 3),
(6, 3),
(17,  4),
(17,  3),
(18,  2),
(18,  5),
(8, 5);

DROP TABLE IF EXISTS `ad_types`;
CREATE TABLE `ad_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ad_types` (`id`, `name`) VALUES
(1, 'Jag efterlyser'),
(2, 'Jag lånar ut'),
(3, 'Byte');

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'Fordon'),
(2, 'Trädgård'),
(3, 'Fest'),
(4, 'Verktyg'),
(5, 'Diverse'),
(6, 'Usla julklappar');

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sortid` int(11) unsigned DEFAULT NULL,
  `category` int(11) unsigned DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `filename` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `ext` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `page` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `pid` int(11) unsigned DEFAULT NULL,
  `size` int(11) unsigned DEFAULT NULL,
  `online` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


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
  `premium` int(10) unsigned NOT NULL COMMENT '1 = TRUE, 0 = FALSE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `user` (`id`, `firstname`, `lastname`, `address_city`, `address_street`, `address_zip`, `email`, `phone`, `password`, `premium`) VALUES
(1, 'Per',  'i Hagen',  'Munkfors', 'Pelargatan 4', 68432,  'nacho@taco.com', 0,  '58ecff21ea6428c821b117958339a14fcfe63320', 0),
(3, 'Sara', 'Holm', 'HÃ¤gersten', 'PingstvÃ¤gen 34',  12636,  'saraholm82@yahoo.se',  0,  '831a86811ae88b637ac51e8769e4d2b52e537405', 0),
(4, '', '', '', '', 0,  '', 0,  'c8d5a74c897c8d7406c1c3c01c657b5c12515b52', 0),
(5, 'Thomas', 'Kjellberg',  'Jönköping',  'Skuggaliden 1',  55312,  'thomas.kjellberg@gmail.com', 0,  '831a86811ae88b637ac51e8769e4d2b52e537405', 0),
(6, 'Hannahnas',  'Bananas',  'Stockholm',  'Borgargatan 8',  11734,  'hannahnas@bananas.com',  0,  '831a86811ae88b637ac51e8769e4d2b52e537405', 0),
(7, 'Bajs-Mandish', 'Kokobeng', 'Skarpis',  'Cannabisvägen 14', 66666,  'bajs-mandish.cannabisforever@freespirit.com',  0,  '831a86811ae88b637ac51e8769e4d2b52e537405', 0);

DROP TABLE IF EXISTS `user_has_created_ads`;
CREATE TABLE `user_has_created_ads` (
  `user_id` int(10) unsigned NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `user_has_created_ads` (`user_id`, `ad_id`, `date`) VALUES
(1, 17, 0);

DROP TABLE IF EXISTS `user_interested_in_ad`;
CREATE TABLE `user_interested_in_ad` (
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `denied` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `user_interested_in_ad` (`ad_id`, `user_id`, `date`, `denied`) VALUES
(7, 1,  1452781023, 0),
(6, 1,  1452782475, 0),
(6, 3,  1452782475, 0),
(6, 5,  1452782475, 0),
(6, 7,  1452782475, 0),
(6, 6,  1452782475, 0);

-- 2016-01-17 18:07:02