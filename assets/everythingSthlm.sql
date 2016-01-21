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
  `address` varchar(250) COLLATE utf8_bin NOT NULL,
  `date_created` int(10) unsigned NOT NULL,
  `date_updated` int(11) unsigned NOT NULL,
  `date_expire` int(10) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `ad_type` int(10) unsigned NOT NULL,
  `payment` varchar(250) COLLATE utf8_bin NOT NULL,
  `active` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8_bin NOT NULL,
  `latitude` varchar(200) COLLATE utf8_bin NOT NULL,
  `longitude` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ads` (`id`, `title`, `content`, `address`, `date_created`, `date_updated`, `date_expire`, `user_id`, `ad_type`, `payment`, `active`, `image`, `latitude`, `longitude`) VALUES
(18,  'Sparhund', 'Jag lånar ut min Sparhund då jag åker på Semester under en längre tid',  'Varvsgatan 21',  1453200156, 1453200156, 1453804956, 8,  0,  'Va bara försiktig med Hunden', 1,  'sparhund_amanda_1453200156.jpg', '59.3172717', '18.040543'),
(19,  'Prydnadsgiraff', 'Jag byter gärna mina prydnadsgiraffer mot någon annan trevlig prydnad.', 'Varvsgatan 21',  1453200335, 1453200335, 1453805135, 8,  3,  'Trevlig prydnad',  1,  'giraff_1453200335.jpg',  '59.3172717', '18.040543'),
(20,  'Ananas', 'Ananas bortskänkes. Köpte ett stort parti och kommer inte hinna äta allt innan det ruttnar.',  'Borgargatan 8',  1453202585, 1453202585, 1453807385, 9,  0,  'Kramar', 1,  'hanna_annanas_1453202585.jpg', '59.3173177', '18.0343781'),
(21,  'Lysande Jordglob', 'Lysande jordglob bytes mot annan lampa. Fick två stycken likadan i julklapp',  'Borgargatan 8',  1453202890, 1453202890, 1453807690, 9,  0,  'Golvlampa',  1,  'glob_1453202890.jpg',  '59.3173177', '18.0343781'),
(22,  'Döende Växt',  'Döende växt lånas ut till någon med gröna fingrar. Jag vet inte vad jag ska göra, vill inte att den ska dö!',  'Pelargatan 4', 1453202996, 1453202996, 1453807796, 12, 1,  'Betalar den ersättning som efterfrågas', 1,  'per_vaxt_1453202996_1453272862.jpg', '59.2953531', '18.0866078'),
(24,  'Snowjogger', 'Jag efterlyser min andra Snowjogger!  Kom bor runt Stureplan förra helgen. Snälla hjälp!', 'Pelargatan 4', 1453203076, 1453203076, 1453807876, 12, 0,  'Hittelön utbetalas', 1,  'per_snowjogger_1453203076.jpg',  '59.2953531', '18.0866078'),
(25,  'Pizzakartong', 'Orginal Pizzakartong från 1994 bortskänkes till fanatisk pizzakartongsamlare', 'Sköldgatan 13, 118 63 Stockholm, Sverige', 1453203242, 1453203242, 1453808042, 12, 1,  'Pizzakartong från 2001', 1,  'per_pizza_1453203242.jpg', '59.312870597238096', '18.0560302734375'),
(26,  'Random Poster',  'Random poster bytes mot annan radom pposter i grön/blå nyans.',  'Pingstvägen 34', 1453203404, 1453203404, 1453808204, 11, 0,  'Annan random poster',  1,  'sara_poster_1453203404.jpg', '59.3017509', '17.9973865'),
(27,  'Kasse full med mat', 'Icakasse full med mat bortskänks till en hungrig', 'Pingstvägen 34', 1453203467, 1453203467, 1453808267, 11, 4,  'En kram',  1,  'sara_ica_1453203468.jpg',  '59.3017509', '17.9973865'),
(28,  'Surfbräda',  'Surfbräda bytes mot strykbräda då jag nyligen flyttat hem till Sverige från Bali och inte kommer ha så mycket tid till surfen',  'Komunalvägen 14',  1453203575, 1453203575, 1453808375, 10, 3,  'Strykbräda', 1,  'thomas_surf_1453203575.jpg', '', ''),
(29,  'Bollar till ljusslinga', 'Efterlyser bollar till min ljusslinga. Gärna i linkande kulörer.', 'Komunalvägen 14',  1453203715, 1453203715, 1453808515, 10, 0,  'Pengar', 1,  'ljusslinga_bollar_1453203715.jpg', '', ''),
(30,  'Lunch',  'Sökes',  'Borgargatan 8, 117 34 Stockholm, Sverige', 1453373293, 1453373293, 1453978093, 9,  0,  'Hunger', 1,  '', '59.31729721753126',  '18.03433120250702');

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
(8, 6),
(8, 3),
(8, 5),
(18,  5),
(19,  3),
(20,  2),
(21,  6),
(22,  2),
(23,  3),
(23,  1),
(24,  3),
(24,  1),
(25,  4),
(26,  3),
(27,  5),
(28,  1),
(29,  5),
(30,  5);

DROP TABLE IF EXISTS `ad_types`;
CREATE TABLE `ad_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ad_types` (`id`, `name`) VALUES
(1, 'Jag efterlyser'),
(2, 'Jag lånar ut'),
(3, 'Byte'),
(4, 'Bortskänkes');

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

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(100) COLLATE utf8_bin NOT NULL,
  `address` varchar(250) COLLATE utf8_bin NOT NULL,
  `latitude` varchar(50) COLLATE utf8_bin NOT NULL,
  `longitude` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `phone` int(15) unsigned NOT NULL,
  `password` varchar(200) COLLATE utf8_bin NOT NULL,
  `premium` int(10) unsigned NOT NULL COMMENT '1 = TRUE, 0 = FALSE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `user` (`id`, `firstname`, `lastname`, `address`, `latitude`, `longitude`, `email`, `phone`, `password`, `premium`) VALUES
(8, 'Amanda', 'Bouveng',  'Stockholm',  '', '', 'amanda@email.com', 0,  '3eecd40389b27dbe4e3217a306a7f38d4174794b', 0),
(9, 'Hannah', 'Kansell',  'Borgargatan 8, 117 34 Stockholm, Sverige', '59.31729721753126',  '18.03433120250702',  'hannah@email.com', 0,  '7af9d127e3927984301d8dfba6db7bee9e142523', 0),
(10,  'Thomas', 'Kjellberg',  'Huddinge', '', '', 'thomas@email.com', 0,  '5d61992a3897940d030b93cca019c4128f9fc310', 0),
(11,  'Sara', 'Holm', 'Hägersten',  '', '', 'sara@email.com', 0,  'fb8dd15f2d73264367e6f04f6ffaf121b0ba90dd', 0),
(12,  'Per',  'Olsson', 'Pontonjärgatan 18, 112 37 Stockholm, Sverige', '59.32881139533626',  '18.03508758544922',  'per@email.com',  0,  'dd0f3163b0cd70e0e3fc4d49fa9e27a479663abf', 0),
(13,  'John', 'Doe',  'Lilla Allmänna Gränd 9, 115 21 Stockholm, Sverige',  '18.09722900390625',  '18.09722900390625',  'john@doe.nu',  0,  '16b1a2d222bd6efb9b721cfef14f5589a90db6af', 0);

DROP TABLE IF EXISTS `user_has_created_ads`;
CREATE TABLE `user_has_created_ads` (
  `user_id` int(10) unsigned NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `user_has_created_ads` (`user_id`, `ad_id`, `date`) VALUES
(8, 18, 1453200156),
(8, 19, 1453200335),
(9, 20, 1453202585),
(9, 21, 1453202890),
(12,  22, 1453202996),
(12,  25, 1453203242),
(11,  26, 1453203404),
(11,  27, 1453203467),
(10,  28, 1453203575),
(10,  29, 1453203715),
(9, 30, 1453373293);

DROP TABLE IF EXISTS `user_interested_in_ad`;
CREATE TABLE `user_interested_in_ad` (
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `denied` int(11) NOT NULL,
  `new` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `user_interested_in_ad` (`ad_id`, `user_id`, `date`, `denied`, `new`) VALUES
(22,  10, 1453203756, 0,  0),
(27,  10, 1453203778, 0,  0),
(28,  11, 1453203809, 0,  0),
(22,  11, 1453203827, 0,  0);

-- 2016-01-21 12:11:06