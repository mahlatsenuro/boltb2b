-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 13, 2019 at 07:57 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posibolt`
--

-- --------------------------------------------------------

--
-- Table structure for table `abandon_cart`
--

DROP TABLE IF EXISTS `abandon_cart`;
CREATE TABLE IF NOT EXISTS `abandon_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `sku` varchar(250) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `options` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `user_id` int(11) NOT NULL COMMENT 'Forign key to users table',
  `address_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL COMMENT 'Contact id from collivery',
  `company_name` varchar(100) NOT NULL COMMENT 'name of the company',
  `street` varchar(150) NOT NULL,
  `location_type` int(11) NOT NULL COMMENT 'from collivery client',
  `location_type_name` varchar(200) NOT NULL,
  `suburb_id` int(11) NOT NULL COMMENT 'from collivery client',
  `suburb_name` varchar(200) NOT NULL,
  `town_id` int(11) NOT NULL COMMENT 'from collivery client',
  `town_name` varchar(200) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `cellphone` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `unique` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'mds',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`unique`),
  KEY `fk_user_addresses` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `address_delivery`
--

DROP TABLE IF EXISTS `address_delivery`;
CREATE TABLE IF NOT EXISTS `address_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `address_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL COMMENT 'Contact id from collivery',
  `company_name` varchar(100) NOT NULL COMMENT 'name of the company',
  `street` varchar(150) NOT NULL,
  `location_type` int(11) NOT NULL COMMENT 'from collivery client',
  `suburb_id` int(11) NOT NULL COMMENT 'from collivery client',
  `town_id` int(11) NOT NULL COMMENT 'from collivery client',
  `zip_code` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `cellphone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `free_delivery_above` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address_delivery`
--

INSERT INTO `address_delivery` (`id`, `address_id`, `contact_id`, `company_name`, `street`, `location_type`, `suburb_id`, `town_id`, `zip_code`, `full_name`, `phone`, `cellphone`, `email`, `free_delivery_above`, `date`) VALUES
(1, 1666049, 1730331, 'Nuro', 'Prakuxhiyil, Ottappalam', 13, 5105, 2, '679515', 'Mijoe', '8809178703', '8809178703', 'mijoepm@gmail.com', 0, '2017-03-09 05:22:24');

-- --------------------------------------------------------

--
-- Table structure for table `app_sessions`
--

DROP TABLE IF EXISTS `app_sessions`;
CREATE TABLE IF NOT EXISTS `app_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
CREATE TABLE IF NOT EXISTS `attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `index` varchar(50) NOT NULL COMMENT 'Index to check attribute names',
  `type` varchar(10) NOT NULL,
  `name` varchar(150) NOT NULL COMMENT 'product attribute display text',
  `system_name` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'created date',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index` (`index`),
  KEY `text` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2869 DEFAULT CHARSET=utf8 COMMENT='Products attributes';

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `index`, `type`, `name`, `system_name`, `date`) VALUES
(2867, 'color_5d5234feb1ae6', 'size', 'Color', 'Color', '2019-08-13 03:56:46'),
(2868, 'size_5d5241c9f1eed', 'size', 'Size', 'Size', '2019-08-13 04:51:21');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_groups`
--

DROP TABLE IF EXISTS `attribute_groups`;
CREATE TABLE IF NOT EXISTS `attribute_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2595 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attribute_groups`
--

INSERT INTO `attribute_groups` (`id`, `name`, `date`) VALUES
(2593, '17750', '2019-08-13 03:57:21'),
(2594, '17752', '2019-08-13 04:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_images`
--

DROP TABLE IF EXISTS `attribute_images`;
CREATE TABLE IF NOT EXISTS `attribute_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_attribute_id` (`attribute_id`),
  KEY `fk_image_id` (`image_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_options`
--

DROP TABLE IF EXISTS `attribute_options`;
CREATE TABLE IF NOT EXISTS `attribute_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '1',
  `hex` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_attribute` (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16381 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attribute_options`
--

INSERT INTO `attribute_options` (`id`, `attribute_id`, `name`, `sort`, `hex`) VALUES
(16376, 2867, 'Champgane Bronze', 1, ''),
(16377, 2867, 'Brushed Nickel', 2, ''),
(16378, 2868, 'Small', 1, ''),
(16379, 2868, 'Medium', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_option_groups`
--

DROP TABLE IF EXISTS `attribute_option_groups`;
CREATE TABLE IF NOT EXISTS `attribute_option_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_attributes` (`attribute_id`),
  KEY `fk_groups` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3782 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attribute_option_groups`
--

INSERT INTO `attribute_option_groups` (`id`, `attribute_id`, `group_id`, `sort`) VALUES
(3780, 2867, 2594, 0),
(3781, 2868, 2593, 0);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `content` longtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `status`, `date`) VALUES
(1, 'Software', '<p>This is a test attributed thing!</p>', 1, '2016-10-15 10:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

DROP TABLE IF EXISTS `captcha`;
CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` int(11) NOT NULL AUTO_INCREMENT,
  `captcha_time` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `word` varchar(50) NOT NULL,
  PRIMARY KEY (`captcha_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Captcha save table';

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `code` varchar(200) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'parent category id',
  `name` varchar(150) NOT NULL COMMENT 'category name',
  `display_name` varchar(150) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '5',
  `in_menu` int(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `code`, `parent_id`, `name`, `display_name`, `active`, `sort`, `in_menu`, `date`) VALUES
(1, '', 0, 'Availability', 'Availability', 1, 1, 1, '2019-08-05 12:20:44'),
(2, 'seasonal', 1, 'Seasonal', 'Seasonal', 1, 10, 1, '2019-08-05 12:23:12'),
(3, 'replen', 1, 'Replen', 'Replen', 1, 2, 1, '2019-08-05 12:23:12'),
(4, 'closeout', 1, 'Closeout', 'Closeout', 1, 3, 1, '2019-08-05 12:23:48'),
(5, 'product-type', 0, 'PRODUCT TYPE', 'PRODUCT TYPE', 1, 2, 1, '2019-08-05 12:25:04'),
(6, 'equipment', 5, 'Equipment', 'Equipment', 1, 1, 1, '2019-08-05 12:28:09'),
(7, 'apparel', 5, 'Apparel', 'Apparel', 1, 2, 0, '2019-08-05 12:28:09'),
(8, 'footwear', 5, 'Footwear', 'Footwear', 1, 3, 1, '2019-08-05 12:28:43'),
(9, 'bags', 6, 'Bags', 'Bags', 1, 1, 1, '2019-08-05 12:29:59'),
(10, 'balls', 6, 'Balls', 'Balls', 1, 2, 1, '2019-08-05 12:29:59'),
(11, 'bottom', 7, 'Bottom', 'Bottom', 1, 1, 1, '2019-08-05 12:31:14'),
(12, 'headwear', 7, 'Head Wear', 'Head Wear', 1, 2, 1, '2019-08-05 12:31:14');

-- --------------------------------------------------------

--
-- Table structure for table `collivery_location_types`
--

DROP TABLE IF EXISTS `collivery_location_types`;
CREATE TABLE IF NOT EXISTS `collivery_location_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `collivery_location_types`
--

INSERT INTO `collivery_location_types` (`id`, `type_id`, `name`) VALUES
(2, 1, 'Business Premises'),
(3, 13, 'Chain Store'),
(4, 11, 'Embassy / Consulate'),
(5, 3, 'Farm / Plot'),
(6, 10, 'Game Reserve / Resort'),
(7, 16, 'Gated Suburb'),
(8, 4, 'Government Building'),
(9, 2, 'Government Hospital'),
(10, 5, 'Mine'),
(11, 9, 'Office Park'),
(12, 6, 'Power Station'),
(13, 15, 'Private House'),
(14, 12, 'Shopping Centre'),
(15, 8, 'Township'),
(16, 7, 'Trust Area'),
(17, 14, 'University');

-- --------------------------------------------------------

--
-- Table structure for table `collivery_parcel_types`
--

DROP TABLE IF EXISTS `collivery_parcel_types`;
CREATE TABLE IF NOT EXISTS `collivery_parcel_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `type_text` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_id` (`type_text`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `collivery_parcel_types`
--

INSERT INTO `collivery_parcel_types` (`id`, `type_text`, `name`) VALUES
(1, 'Envelope', 'Documents less than 2Kg and A4 size'),
(2, 'Package', 'Parcel Exceeding 2Kg and any dimension above 20cm'),
(3, 'Tender Documents', 'Documents for lodging Tenders');

-- --------------------------------------------------------

--
-- Table structure for table `collivery_sevices`
--

DROP TABLE IF EXISTS `collivery_sevices`;
CREATE TABLE IF NOT EXISTS `collivery_sevices` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `service_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_id` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `collivery_sevices`
--

INSERT INTO `collivery_sevices` (`id`, `service_id`, `name`) VALUES
(1, 1, 'Overnight before 10:00'),
(2, 2, 'Overnight before 16:00'),
(3, 5, 'Road Freight Express'),
(4, 3, 'Road Freight');

-- --------------------------------------------------------

--
-- Table structure for table `collivery_suburbs`
--

DROP TABLE IF EXISTS `collivery_suburbs`;
CREATE TABLE IF NOT EXISTS `collivery_suburbs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `town_id` int(11) NOT NULL COMMENT 'town id from collivery',
  `suburb_id` int(11) NOT NULL COMMENT 'suburb id from collivery',
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `collivery_towns`
--

DROP TABLE IF EXISTS `collivery_towns`;
CREATE TABLE IF NOT EXISTS `collivery_towns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `town_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `town_id` (`town_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1221 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `collivery_towns`
--

INSERT INTO `collivery_towns` (`id`, `town_id`, `name`) VALUES
(1, 2, 'Aberdeen'),
(2, 472, 'Acornhoek'),
(3, 746, 'Adams Mission'),
(4, 425, 'Addo'),
(5, 4, 'Adelaide'),
(6, 473, 'Afguns'),
(7, 474, 'Aggeneys'),
(8, 475, 'Agulhas'),
(9, 11667, 'Akron'),
(10, 9, 'Albert Falls'),
(11, 5, 'Albertinia'),
(12, 476, 'Albinia'),
(13, 3, 'Alexander Bay'),
(14, 8, 'Alexandria EC'),
(15, 6, 'Alice'),
(16, 12438, 'Alicedale'),
(17, 20, 'Aliwal North'),
(18, 848, 'Alkmaar'),
(19, 10, 'Allanridge'),
(20, 7, 'Alldays'),
(21, 12588, 'Allemansdrift-C'),
(22, 845, 'Alma'),
(23, 477, 'Amabeli'),
(24, 940, 'Amalia'),
(25, 478, 'Amandabult'),
(26, 11, 'Amanzimtoti'),
(27, 479, 'Amatikulu'),
(28, 12, 'Amersfoort'),
(29, 13, 'Amsterdam'),
(30, 11981, 'Andriesvale'),
(31, 14, 'Anerley'),
(32, 901, 'Apel'),
(33, 15, 'Arlington'),
(34, 16, 'Arniston'),
(35, 480, 'Arnot'),
(36, 482, 'Arthur Taylor Mine'),
(37, 17, 'Ashton'),
(38, 18, 'Askham'),
(39, 11934, 'Aston Bay'),
(40, 11017, 'Atamelang'),
(41, 11668, 'Athole'),
(42, 701, 'Atlantic Beach Estate'),
(43, 1030, 'Atlantis'),
(44, 902, 'Atok'),
(45, 980, 'Augrabies'),
(46, 19, 'Aurora'),
(47, 11718, 'Austrey'),
(48, 11753, 'Avondster'),
(49, 483, 'Avontuur'),
(50, 11998, 'Azaadville'),
(51, 21, 'Babanango'),
(52, 492, 'Babelegie'),
(53, 22, 'Badplaas'),
(54, 668, 'Bainsvlei'),
(55, 12416, 'Bakerville'),
(56, 37, 'Balfour'),
(57, 10445, 'Balfour, Eastern Cape'),
(58, 29, 'Balgowan'),
(59, 24, 'Ballito'),
(60, 12367, 'Balmoral'),
(61, 11945, 'Baltimore'),
(62, 747, 'Banana Beach'),
(63, 903, 'Bandalierskop'),
(64, 12538, 'Bapong'),
(65, 414, 'Bapsfontein'),
(66, 941, 'Barberspan'),
(67, 26, 'Barberton'),
(68, 669, 'Barkly East'),
(69, 376, 'Barkly West'),
(70, 725, 'Barrydale'),
(71, 11615, 'Bashewa AH'),
(72, 11690, 'Batho-Batho'),
(73, 27, 'Bathurst'),
(74, 898, 'Bazley Beach'),
(75, 520, 'Beaufort West'),
(76, 30, 'Bedford'),
(77, 10602, 'Beeshoek'),
(78, 871, 'Beestekraal'),
(79, 433, 'Beit Bridge'),
(80, 32, 'Bela Bela'),
(81, 31, 'Belfast'),
(82, 34, 'Bergville'),
(83, 808, 'Berlin'),
(84, 50, 'Bethal'),
(85, 872, 'Bethanie'),
(86, 366, 'Bethlehem'),
(87, 35, 'Bethulie'),
(88, 405, 'Bettys Bay'),
(89, 942, 'Biesiesvlei'),
(90, 524, 'Bisho'),
(91, 724, 'Bitterfontein'),
(92, 495, 'Bizana'),
(93, 576, 'Black Rock '),
(94, 11893, 'Blinkpan'),
(95, 670, 'Bloemanda'),
(96, 791, 'Bloemedale'),
(97, 38, 'Bloemfontein'),
(98, 39, 'Bloemhof'),
(99, 672, 'Bloemspruit'),
(100, 794, 'Blue Horison Bay'),
(101, 943, 'Blyvooruitsig'),
(102, 10804, 'Bochum'),
(103, 944, 'Bodenstein'),
(104, 674, 'Boesmanskop'),
(105, 994, 'Boggoms Bay'),
(106, 11657, 'Boikhutso'),
(107, 11653, 'Boitekong'),
(108, 11654, 'Bojanala'),
(109, 976, 'Boknes'),
(110, 1060, 'Boknes Strand'),
(111, 11660, 'Bollantlokwe'),
(112, 551, 'Bonnievale '),
(113, 873, 'Boons'),
(114, 40, 'Bosbokrand'),
(115, 604, 'Boschkop'),
(116, 890, 'Boshoek'),
(117, 48, 'Boshof'),
(118, 11741, 'Boskuil'),
(119, 867, 'Bosplaas'),
(120, 945, 'Bospoort'),
(121, 748, 'Bothas Hill'),
(122, 41, 'Bothaville'),
(123, 713, 'Botrivier'),
(124, 673, 'Botshabelo'),
(125, 865, 'Bourkes Luck'),
(126, 946, 'Brakspruit'),
(127, 42, 'Brandfort'),
(128, 10619, 'Brandvlei'),
(129, 11663, 'Bray'),
(130, 43, 'Bredasdorp'),
(131, 12426, 'Breerivier'),
(132, 10423, 'Brenton-on-Sea'),
(133, 525, 'Breyten'),
(134, 11994, 'Britannia Bay'),
(135, 44, 'Brits'),
(136, 46, 'Britstown'),
(137, 569, 'Broerderstroom'),
(138, 849, 'Brondal'),
(139, 45, 'Bronkhorstspruit'),
(140, 12323, 'Buffeljagsrivier'),
(141, 12507, 'Buffels Bay'),
(142, 12385, 'Buffelspoort'),
(143, 11923, 'Buhrmansdrif'),
(144, 51, 'Bultfontein'),
(145, 53, 'Bulwer'),
(146, 52, 'Burgersdorp'),
(147, 377, 'Burgersfort'),
(148, 563, 'Bushbuckridge'),
(149, 516, 'Bushmans River'),
(150, 611, 'Butterworth'),
(151, 54, 'Byrne'),
(152, 538, 'Cala'),
(153, 55, 'Caledon'),
(154, 408, 'Calitzdorp'),
(155, 396, 'Calvinia'),
(156, 893, 'Camden'),
(157, 601, 'Camperdown'),
(158, 10436, 'Cape St Francis'),
(159, 68, 'Cape Town'),
(160, 57, 'Carletonville'),
(161, 568, 'Carnarvon'),
(162, 56, 'Carolina'),
(163, 67, 'Cathcart'),
(164, 12265, 'Cathedral Peak'),
(165, 499, 'Cato Ridge'),
(166, 1013, 'Cedara'),
(167, 58, 'Cedarville'),
(168, 59, 'Ceres'),
(169, 660, 'Charl Cilliers'),
(170, 60, 'Charlestown'),
(171, 12150, 'Chatsworth, WC'),
(172, 12107, 'Chintsa East'),
(173, 61, 'Chrissiesmeer'),
(174, 415, 'Christiana'),
(175, 11889, 'Christmas Rock'),
(176, 809, 'Cintsa'),
(177, 423, 'Citrusdal'),
(178, 438, 'Clanwilliam'),
(179, 62, 'Clarens'),
(180, 10595, 'Clewer'),
(181, 993, 'Cliffdale'),
(182, 63, 'Clocolan'),
(183, 648, 'Coalville'),
(184, 596, 'Cofimvaba'),
(185, 1008, 'Colchester'),
(186, 64, 'Colenso'),
(187, 383, 'Colesberg'),
(188, 371, 'Coligny'),
(189, 12424, 'Concordia'),
(190, 796, 'Cookhouse'),
(191, 65, 'Cornelia'),
(192, 66, 'Cradock'),
(193, 12397, 'Cramond'),
(194, 750, 'Creighton'),
(195, 69, 'Cullinan'),
(196, 751, 'Currys Post'),
(197, 1059, 'Cyferfontein'),
(198, 12545, 'Da Noon'),
(199, 11014, 'Daantjie'),
(200, 647, 'Daggakraal'),
(201, 905, 'Dalmada'),
(202, 752, 'Dalton'),
(203, 402, 'Dana Bay'),
(204, 422, 'Danielskuil'),
(205, 11875, 'Danielsrus'),
(206, 70, 'Dannhauser'),
(207, 71, 'Dargle'),
(208, 599, 'Darling'),
(209, 567, 'Darnall '),
(210, 12111, 'Dassiefontein'),
(211, 646, 'Davel'),
(212, 12304, 'Dayizenza Plaza'),
(213, 73, 'De Aar'),
(214, 676, 'De brug'),
(215, 726, 'De Doorns'),
(216, 11719, 'De Grens'),
(217, 11881, 'De Kelders'),
(218, 828, 'De Rust'),
(219, 12422, 'De Wildt (Pretoria)'),
(220, 677, 'Dealesville'),
(221, 454, 'Delareyville'),
(222, 75, 'Delmas'),
(223, 633, 'Delportshoop'),
(224, 11913, 'Dendron'),
(225, 76, 'Deneysville'),
(226, 455, 'Dennilton'),
(227, 427, 'Derby'),
(228, 634, 'Despatch'),
(229, 581, 'Devon '),
(230, 77, 'Dewetsdorp'),
(231, 11989, 'Dibeng'),
(232, 12491, 'Didima Ezemvelo KZNW Camp'),
(233, 10618, 'Die Oog'),
(234, 11652, 'Dihatshwane'),
(235, 11720, 'Dihibidung'),
(236, 11659, 'Dikebu'),
(237, 810, 'Dimbaza'),
(238, 11664, 'Dingateng'),
(239, 1052, 'Dinokana'),
(240, 11665, 'Dipetlelwane'),
(241, 11666, 'Disaneng'),
(242, 12630, 'Dominionville'),
(243, 753, 'Donnybrook'),
(244, 78, 'Doonside'),
(245, 11721, 'Doornlaagte'),
(246, 11744, 'Doornpan'),
(247, 811, 'Dordrecht'),
(248, 12137, 'Doringbaai'),
(249, 444, 'Douglas'),
(250, 12566, 'Driefontein'),
(251, 1062, 'Driekop'),
(252, 79, 'Drummond'),
(253, 12510, 'Dudfield'),
(254, 80, 'Duduza'),
(255, 81, 'Dullstroom'),
(256, 82, 'Dundee'),
(257, 661, 'Dundonald'),
(258, 83, 'Durban'),
(259, 12399, 'Durnacol'),
(260, 703, 'Duynefontein'),
(261, 606, 'Dwaalboom '),
(262, 728, 'Dwarskersbos'),
(263, 907, 'Dzanani'),
(264, 948, 'East Driefonten'),
(265, 91, 'East London'),
(266, 84, 'Edenburg'),
(267, 85, 'Edenville'),
(268, 1035, 'EENDEKUIL'),
(269, 11270, 'Eeram Station'),
(270, 616, 'Eersterivier '),
(271, 12308, 'Eersterivierstrand'),
(272, 874, 'Ekandustria'),
(273, 11007, 'Ekangala'),
(274, 729, 'Elands Bay'),
(275, 389, 'Elandsdoorn'),
(276, 87, 'Elandslaagte'),
(277, 704, 'Elgin'),
(278, 10598, 'Elim, Limpopo'),
(279, 908, 'Elim, Western Cape'),
(280, 812, 'Elliot'),
(281, 1056, 'Elliotdale'),
(282, 12483, 'Elsenburg'),
(283, 864, 'Elukwatini'),
(284, 12287, 'Elysium'),
(285, 12261, 'EMangweni'),
(286, 642, 'Embalenhle'),
(287, 10830, 'Embekweni'),
(288, 88, 'Empangeni'),
(289, 1064, 'Empuluzi'),
(290, 11874, 'Emzinoni'),
(291, 813, 'Engcobo'),
(292, 89, 'Ermelo'),
(293, 90, 'Eshowe'),
(294, 973, 'Esikhawini'),
(295, 92, 'Estcourt'),
(296, 613, 'Eston '),
(297, 578, 'Evander '),
(298, 93, 'Evaton'),
(299, 94, 'Excelsior'),
(300, 552, 'Ezakheni '),
(301, 95, 'Fauresmith'),
(302, 754, 'Felixton'),
(303, 662, 'Fernie'),
(304, 96, 'Ficksburg'),
(305, 705, 'Fisantekraal'),
(306, 11962, 'Fish River'),
(307, 97, 'Fisherhaven'),
(308, 640, 'Flagstaff'),
(309, 436, 'Fochville'),
(310, 98, 'Fort Beaufort'),
(311, 814, 'Fort Jackson'),
(312, 99, 'Fouriesburg'),
(313, 101, 'Frankfort'),
(314, 100, 'Franklin'),
(315, 12364, 'Franschoek'),
(316, 526, 'Franskraal'),
(317, 837, 'Fraserburg'),
(318, 1044, 'Ga-Masemola'),
(319, 11661, 'Ga-Mathako'),
(320, 11722, 'Ga-Montshonyana'),
(321, 11957, 'Ga-Mothiba'),
(322, 11691, 'Ga-Motle'),
(323, 463, 'Ga-Rankuwa'),
(324, 11692, 'Ga-Rantlapane'),
(325, 555, 'Gamalake '),
(326, 909, 'Gamatlala'),
(327, 10603, 'Gamtoos'),
(328, 420, 'Gansbaai'),
(329, 949, 'Ganyesa'),
(330, 679, 'Gariepdam'),
(331, 730, 'Garies'),
(332, 12365, 'Gelukspan'),
(333, 11750, 'Gemsbokvlakte'),
(334, 719, 'Genadendal'),
(335, 103, 'George'),
(336, 950, 'Gerdau'),
(337, 755, 'Gingindlovu'),
(338, 507, 'Giyani'),
(339, 680, 'Glen'),
(340, 910, 'Glen Cowie'),
(341, 104, 'Glencoe'),
(342, 896, 'Glenharvie'),
(343, 11637, 'Glenmore Beach'),
(344, 10593, 'Glentana'),
(345, 866, 'Glenthorpe'),
(346, 681, 'Goedemoed'),
(347, 12264, 'Golden Valley'),
(348, 12497, 'Golela'),
(349, 11745, 'Goodwood'),
(350, 12115, 'Gordons Bay'),
(351, 712, 'Gouda'),
(352, 1045, 'Gouritsmond'),
(353, 107, 'Graaff-Reinet'),
(354, 717, 'Graafwater'),
(355, 494, 'Grabouw'),
(356, 105, 'Grahamstown'),
(357, 109, 'Graskop'),
(358, 911, 'Gravelotte'),
(359, 11693, 'Greenside'),
(360, 106, 'Greylingstad'),
(361, 540, 'Greyton'),
(362, 110, 'Greytown'),
(363, 558, 'Griekwastad'),
(364, 846, 'Groblersbrug'),
(365, 108, 'Groblersdal'),
(366, 557, 'Groblershoop'),
(367, 500, 'Groot Brak Rivier'),
(368, 951, 'Groot Marico'),
(369, 12355, 'Groot-Jongensfontein'),
(370, 12316, 'Grootdrink'),
(371, 1022, 'Grootvlei'),
(372, 11238, 'Grotto Bay'),
(373, 12336, 'Grovedale Farm'),
(374, 12549, 'Gugulethu'),
(375, 12391, 'Guguletu'),
(376, 11676, 'Haakdoornbult'),
(377, 797, 'Haarlem'),
(378, 111, 'Haenertsburg'),
(379, 12286, 'Haga Haga'),
(380, 12356, 'Hamburg'),
(381, 112, 'Hammanskraal'),
(382, 547, 'Hammersdale '),
(383, 614, 'Hankey'),
(384, 798, 'Hanover'),
(385, 12547, 'Happy Valley'),
(386, 756, 'Harburg'),
(387, 514, 'Harding'),
(388, 1061, 'Harkerville'),
(389, 130, 'Harrismith'),
(390, 952, 'Hartbeesfontein'),
(391, 113, 'Hartebeespoort'),
(392, 12305, 'Hartebeesthoek RAO'),
(393, 359, 'Hartenbos'),
(394, 374, 'Hartswater'),
(395, 114, 'Hattingspruit'),
(396, 716, 'Hawston'),
(397, 115, 'Hazyview'),
(398, 1038, 'Hebron'),
(399, 116, 'Hectorspruit'),
(400, 120, 'Heidelberg - Gauteng'),
(401, 133, 'Heidelberg - WC'),
(402, 117, 'Heilbron'),
(403, 424, 'Hekpoort'),
(404, 597, 'Hendrina'),
(405, 127, 'Henley on Klip'),
(406, 118, 'Hennenman'),
(407, 836, 'Herbertsdale'),
(408, 119, 'Hermanus'),
(409, 607, 'Hermon '),
(410, 615, 'Herolds Bay '),
(411, 131, 'Hertzogville'),
(412, 121, 'Hibberdene'),
(413, 757, 'Highflats'),
(414, 124, 'Hilton'),
(415, 123, 'Himeville'),
(416, 11956, 'Hlabisa'),
(417, 431, 'Hluhluwe'),
(418, 125, 'Hobhouse'),
(419, 126, 'Hoedspruit'),
(420, 467, 'Hoekwil'),
(421, 799, 'Hofmeyer'),
(422, 1057, 'Hogsback'),
(423, 11964, 'Hollandsdrift'),
(424, 128, 'Hoopstad'),
(425, 537, 'Hopefield'),
(426, 541, 'Hopetown'),
(427, 731, 'Hotagterklip'),
(428, 471, 'Hotazel'),
(429, 129, 'Howick'),
(430, 132, 'Humansdorp'),
(431, 134, 'Idutywa'),
(432, 135, 'Ifafa Beach'),
(433, 136, 'Illovo Beach'),
(434, 137, 'Impendle'),
(435, 138, 'Inanda'),
(436, 760, 'Inchanga'),
(437, 548, 'Indwe '),
(438, 139, 'Ingwavuma'),
(439, 761, 'Inzigolweni'),
(440, 632, 'Isithebe'),
(441, 11672, 'Itireleng'),
(442, 953, 'Itsoseng'),
(443, 144, 'Ixopo'),
(444, 991, 'Jacobs Bay'),
(445, 602, 'Jacobsdal '),
(446, 146, 'Jagersfontein'),
(447, 841, 'Jagersrust'),
(448, 683, 'Jamestown'),
(449, 590, 'Jan Kempdorp'),
(450, 528, 'Jane Furse'),
(451, 148, 'Jansenville'),
(452, 149, 'Jeffreys Bay'),
(453, 862, 'Jeppes Reef'),
(454, 12546, 'Joe Slovo Park'),
(455, 147, 'Johannesburg'),
(456, 577, 'Joubertina'),
(457, 10713, 'Jouberton'),
(458, 573, 'Jozini'),
(459, 150, 'Kaapmuiden'),
(460, 11723, 'Kabe'),
(461, 462, 'Kabokweni'),
(462, 395, 'Kakamas'),
(463, 12370, 'Kalbaskraal'),
(464, 912, 'Kalkbank'),
(465, 623, 'Kamaqhekeza'),
(466, 12339, 'Kamberg'),
(467, 954, 'Kameel'),
(468, 995, 'Kameeldrift'),
(469, 732, 'Kamieskroon'),
(470, 1029, 'Kampersrus'),
(471, 530, 'Kanon Eiland'),
(472, 10686, 'KaNyamazane'),
(473, 12360, 'Karatara'),
(474, 621, 'Kareedouw'),
(475, 850, 'Karino'),
(476, 151, 'Karridene'),
(477, 410, 'Kathu'),
(478, 981, 'Kaysers Beach'),
(479, 1033, 'Kei Mouth'),
(480, 629, 'Keimoes'),
(481, 1043, 'Keiskammahoek'),
(482, 655, 'Kendal'),
(483, 11008, 'Kenhardt'),
(484, 684, 'Kenilworth'),
(485, 636, 'Kentani'),
(486, 565, 'Kenton-on-Sea'),
(487, 155, 'Kestell'),
(488, 12145, 'Keurboomstrand'),
(489, 913, 'Kgapane'),
(490, 11674, 'Kgokgojane'),
(491, 11675, 'Kgokgole'),
(492, 12550, 'Khayalitsha'),
(493, 12392, 'Khayelitsha'),
(494, 11694, 'Khunkwe'),
(495, 156, 'Khutsong'),
(496, 11984, 'Kidds Beach'),
(497, 11272, 'Kiepersol'),
(498, 368, 'Kimberley'),
(499, 169, 'King Williams Town'),
(500, 157, 'Kingsburgh'),
(501, 12346, 'Kini Bay'),
(502, 160, 'Kinross'),
(503, 511, 'Kirkwood'),
(504, 974, 'Klapmuts'),
(505, 851, 'Klaserie'),
(506, 585, 'Klawer'),
(507, 625, 'Klein Brak River'),
(508, 12459, 'Kleinemonde'),
(509, 875, 'Kleinfontein'),
(510, 447, 'Kleinmond'),
(511, 718, 'Kleinzee'),
(512, 158, 'Klerksdorp'),
(513, 876, 'Klipfontein'),
(514, 1055, 'Klipheuwel'),
(515, 515, 'Kliprivier'),
(516, 161, 'Knysna'),
(517, 12435, 'Koedoeskop'),
(518, 720, 'Koekenap'),
(519, 162, 'Koffiefontein'),
(520, 11285, 'Koingnaas'),
(521, 163, 'Kokstad'),
(522, 11677, 'Kokwane'),
(523, 1018, 'Komati'),
(524, 852, 'Komatiepoort'),
(525, 626, 'Komga '),
(526, 12105, 'Koopmansfontein'),
(527, 1049, 'Kopfontein'),
(528, 165, 'Koppies'),
(529, 12325, 'Koringberg'),
(530, 762, 'Kosi Bay'),
(531, 806, 'Koster'),
(532, 830, 'Krakeel'),
(533, 519, 'Kranskop'),
(534, 10597, 'Krantshoek'),
(535, 446, 'Kriel'),
(536, 167, 'Kromdraai'),
(537, 11746, 'Kromellenboog'),
(538, 12442, 'Kromfontein'),
(539, 391, 'Kroondal'),
(540, 367, 'Kroonstad'),
(541, 11680, 'Kudunkwane'),
(542, 428, 'Kuruman'),
(543, 763, 'Kwa Mashu'),
(544, 764, 'Kwa Mbonambi'),
(545, 588, 'Kwa-Dlangezwa'),
(546, 12109, 'KwaDabeka'),
(547, 153, 'KwaDukuza'),
(548, 505, 'Kwaggafontein'),
(549, 685, 'Kwaggafontein'),
(550, 600, 'Kwahlabisa'),
(551, 466, 'Kwamahlanga'),
(552, 12496, 'Kwambonambi'),
(553, 501, 'KwaNgwanase'),
(554, 10062, 'Kwelera'),
(555, 603, 'Laaiplek '),
(556, 497, 'Ladismith - Cape'),
(557, 815, 'Lady Frere'),
(558, 686, 'Lady Grey'),
(559, 171, 'Ladybrand'),
(560, 170, 'Ladysmith - KZN'),
(561, 587, 'Laingsburg'),
(562, 721, 'Lamberts Bay'),
(563, 595, 'Lambertsbay '),
(564, 12548, 'Langa'),
(565, 393, 'Langebaan'),
(566, 651, 'Leandra'),
(567, 652, 'Lebohang'),
(568, 11671, 'Lebotloane'),
(569, 529, 'Lebowakgomo'),
(570, 838, 'Leeu Gamka'),
(571, 536, 'Leeudoringstad'),
(572, 842, 'Leeupoort'),
(573, 1040, 'Leeuwfontein'),
(574, 1053, 'Lehurutse'),
(575, 12556, 'Leipoldtville'),
(576, 765, 'Leisure Bay'),
(577, 11681, 'Lekgolo'),
(578, 914, 'Lenyenye'),
(579, 429, 'Lephalale'),
(580, 653, 'Leslie'),
(581, 915, 'Letaba'),
(582, 12274, 'Lethlabile'),
(583, 469, 'Letsitele'),
(584, 916, 'Levubu'),
(585, 687, 'Libertas'),
(586, 816, 'Libode'),
(587, 173, 'Lichtenburg'),
(588, 12450, 'Lidgetton'),
(589, 388, 'Lime Acres'),
(590, 174, 'Lindley'),
(591, 766, 'Lions River'),
(592, 11682, 'Little'),
(593, 12552, 'Loerie'),
(594, 733, 'Loeriesfontein'),
(595, 11747, 'Logagane'),
(596, 11683, 'Logageng'),
(597, 663, 'Lothair'),
(598, 11724, 'Lotlapakgoro'),
(599, 419, 'Louis Trichardt'),
(600, 510, 'Louterwater'),
(601, 853, 'Louws Creek'),
(602, 177, 'Louwsburg'),
(603, 839, 'Loxton'),
(604, 178, 'Luckhoff'),
(605, 11915, 'Lulekani'),
(606, 617, 'Lusikisiki'),
(607, 722, 'Lutzville'),
(608, 179, 'Lydenburg'),
(609, 1031, 'Maake'),
(610, 11695, 'Mabalstad'),
(611, 426, 'Mabopane'),
(612, 11684, 'Mabule'),
(613, 180, 'Machadodorp'),
(614, 817, 'Macleantown'),
(615, 534, 'Maclear'),
(616, 181, 'Madadeni'),
(617, 955, 'Madibogo'),
(618, 11685, 'Madibogo Pan'),
(619, 589, 'Madikwe'),
(620, 11689, 'Maeng'),
(621, 11749, 'Maeyaeyane'),
(622, 182, 'Mafikeng'),
(623, 183, 'Magaliesburg'),
(624, 624, 'Magoebaskloof'),
(625, 12371, 'Magogong'),
(626, 184, 'Mahlabatini'),
(627, 12570, 'Mahushu'),
(628, 917, 'Mahwelereng'),
(629, 11686, 'Maipeng'),
(630, 11743, 'Majaneng'),
(631, 11648, 'Majuba Power Station'),
(632, 879, 'Makapanstad'),
(633, 11696, 'Makgori'),
(634, 185, 'Makhado (Airforce Base)'),
(635, 956, 'Makokskraal'),
(636, 957, 'Makwassie'),
(637, 556, 'Malamulele'),
(638, 186, 'Malelane'),
(639, 375, 'Malmesbury'),
(640, 12632, 'Maluti'),
(641, 464, 'Mamre'),
(642, 767, 'Manaba Beach'),
(643, 12625, 'Mananga'),
(644, 445, 'Mandeni'),
(645, 187, 'Mandini'),
(646, 10821, 'Manguzi'),
(647, 918, 'Mankweng'),
(648, 1011, 'Maphumulo'),
(649, 847, 'Marapong'),
(650, 189, 'Marble Hall'),
(651, 977, 'Marchand'),
(652, 958, 'Mareetsane'),
(653, 196, 'Margate'),
(654, 880, 'Marikana'),
(655, 591, 'Marina Beach'),
(656, 11643, 'Marken'),
(657, 861, 'Marloth Park'),
(658, 188, 'Marquard'),
(659, 689, 'Marseilles'),
(660, 1020, 'Marydale'),
(661, 11697, 'Masamane'),
(662, 12544, 'Masipumelele'),
(663, 854, 'Mataffin'),
(664, 190, 'Matatiele'),
(665, 11725, 'Mathibestad'),
(666, 11742, 'Mathopestad'),
(667, 387, 'Matjiesfontein'),
(668, 11748, 'Matlhabatlhaba'),
(669, 618, 'Matoks '),
(670, 11662, 'Maubane'),
(671, 11698, 'Mazista'),
(672, 572, 'Mbazwana'),
(673, 12633, 'Mbizana'),
(674, 605, 'McGregor'),
(675, 899, 'Mdantsane'),
(676, 649, 'Meerlus'),
(677, 192, 'Melmoth'),
(678, 193, 'Memel'),
(679, 194, 'Merrivale'),
(680, 834, 'Merweville'),
(681, 195, 'Meyerton'),
(682, 768, 'Mhlabatini'),
(683, 919, 'Mica'),
(684, 191, 'Middelburg - EC'),
(685, 200, 'Middelburg - MP'),
(686, 1002, 'Middledrift'),
(687, 645, 'Midlands estate -MP'),
(688, 959, 'Migdol'),
(689, 644, 'Mineralia'),
(690, 831, 'Misgund'),
(691, 12144, 'Mkhuhlu'),
(692, 378, 'Mkondeni'),
(693, 198, 'Mkuze'),
(694, 432, 'Mmabatho'),
(695, 11687, 'Mmagabue'),
(696, 11699, 'Mmakaunyana'),
(697, 11714, 'Mmakaunyane'),
(698, 11700, 'Mmatlhwaela'),
(699, 11701, 'Mmukubyane'),
(700, 11246, 'Modderrivier'),
(701, 201, 'Modimolle'),
(702, 579, 'Modjadjiskloof'),
(703, 11726, 'Moeka'),
(704, 11658, 'Mogogelo'),
(705, 11727, 'Mogogolelo'),
(706, 11713, 'Mogohlwaneng'),
(707, 488, 'Mogwase'),
(708, 11656, 'Mokgobistad'),
(709, 202, 'Mokopane'),
(710, 920, 'Moletji'),
(711, 506, 'Moloto'),
(712, 580, 'Molteno '),
(713, 11688, 'Monetsi'),
(714, 921, 'Monsterlus'),
(715, 517, 'Montagu '),
(716, 203, 'Mooi River'),
(717, 532, 'Mooinooi'),
(718, 922, 'Mooketsi'),
(719, 12455, 'Mookgopong'),
(720, 706, 'Moorreesburg'),
(721, 630, 'Moorreesburg '),
(722, 923, 'Morebeng'),
(723, 11702, 'Moretele'),
(724, 11878, 'Morgan Bay'),
(725, 204, 'Morgenzon'),
(726, 961, 'Morokweng'),
(727, 11756, 'Morotsi'),
(728, 12116, 'Moruleng'),
(729, 205, 'Mossel Bay'),
(730, 11673, 'Moswana'),
(731, 882, 'Motetema'),
(732, 843, 'Moteti'),
(733, 10443, 'Mothibistad'),
(734, 12164, 'Motlhabeng Village'),
(735, 10701, 'Motswedi'),
(736, 769, 'Mount Ayliff'),
(737, 770, 'Mount Fletcher'),
(738, 539, 'Mount Frere'),
(739, 664, 'Mpuluzi'),
(740, 1051, 'Mqanduli'),
(741, 771, 'Mseleni'),
(742, 400, 'Mthatha'),
(743, 206, 'Mtubatuba'),
(744, 208, 'Mtunzini'),
(745, 628, 'Mtwalume'),
(746, 209, 'Muden'),
(747, 559, 'Munster '),
(748, 800, 'Murraysburg'),
(749, 379, 'Musina'),
(750, 925, 'Mutale'),
(751, 734, 'Nababeep'),
(752, 212, 'Naboomspruit'),
(753, 926, 'Namakgale'),
(754, 574, 'Napier '),
(755, 835, 'Natures Valley'),
(756, 12579, 'Nautilus Bay'),
(757, 11243, 'Ndwedwe'),
(758, 927, 'Nebo'),
(759, 12393, 'Nelspoort'),
(760, 214, 'Nelspruit'),
(761, 213, 'New Hanover'),
(762, 11678, 'New Kraaipan'),
(763, 962, 'New Machavie'),
(764, 215, 'Newcastle'),
(765, 216, 'Ngcobo'),
(766, 11703, 'Ngobi'),
(767, 855, 'Ngodwana'),
(768, 10690, 'Ngqeleni'),
(769, 963, 'Nietverdien'),
(770, 11639, 'Nieuwoudtville'),
(771, 450, 'Nigel'),
(772, 772, 'Nkandla'),
(773, 856, 'Nkomazi'),
(774, 773, 'Nkonjeni'),
(775, 11914, 'Nkowankowa'),
(776, 832, 'Noll'),
(777, 218, 'Nongoma'),
(778, 857, 'Noordkaap, Mpumalanga'),
(779, 774, 'Noordsberg'),
(780, 12400, 'Nora Falls'),
(781, 11704, 'Noroki'),
(782, 533, 'Northam'),
(783, 690, 'Norvalspont'),
(784, 219, 'Nottingham Road'),
(785, 801, 'Noupoort'),
(786, 978, 'Nqutu'),
(787, 775, 'Nseleni'),
(788, 12530, 'Nyanga'),
(789, 361, 'Nylstroom'),
(790, 1024, 'Oberholzer'),
(791, 220, 'Odendaalsrus'),
(792, 221, 'Ogies'),
(793, 222, 'Ohrigstad'),
(794, 370, 'Okiep'),
(795, 11679, 'Old Kraaipan'),
(796, 824, 'Olifantshoek'),
(797, 11705, 'Olverton'),
(798, 412, 'Onrus Rivier'),
(799, 844, 'Onverwacht'),
(800, 11758, 'Op-Die-Berg'),
(801, 11728, 'Opperman'),
(802, 1005, 'Orania'),
(803, 223, 'Oranjeville'),
(804, 224, 'Orkney'),
(805, 665, 'Oshoek'),
(806, 744, 'Ottosdal'),
(807, 964, 'Ottoshoop'),
(808, 386, 'Oudtshoorn'),
(809, 691, 'Ovistone'),
(810, 12437, 'Ozwathini'),
(811, 226, 'Paarl'),
(812, 12557, 'Paarl Farms'),
(813, 11729, 'Pachsdraai'),
(814, 776, 'Paddock'),
(815, 227, 'Palm Beach'),
(816, 928, 'Palmietfontein - LP'),
(817, 10611, 'Pampierstad'),
(818, 666, 'Panbult'),
(819, 735, 'Papendorp'),
(820, 10698, 'Paradise Beach'),
(821, 239, 'Park Rynie'),
(822, 228, 'Parys'),
(823, 401, 'Patensie'),
(824, 639, 'Paternoster'),
(825, 627, 'Paterson'),
(826, 230, 'Paul Roux'),
(827, 229, 'Paulpietersburg'),
(828, 12140, 'Pearly Beach'),
(829, 802, 'Pearston'),
(830, 460, 'Peddie'),
(831, 1004, 'Pelindaba'),
(832, 12406, 'Pella'),
(833, 11706, 'Pembroke'),
(834, 231, 'Pennington'),
(835, 1046, 'Perdeberg'),
(836, 232, 'Perdekop'),
(837, 249, 'Petrus Steyn'),
(838, 234, 'Petrusburg'),
(839, 1047, 'Petrusville'),
(840, 233, 'Phalaborwa'),
(841, 11755, 'Phaposane'),
(842, 736, 'Philadelphia'),
(843, 12551, 'Philippi'),
(844, 12464, 'Philipstown'),
(845, 692, 'Phillipolis'),
(846, 12520, 'Phinda Private Game Reserve'),
(847, 12394, 'Phokeng'),
(848, 929, 'Phokwane'),
(849, 12129, 'Phola'),
(850, 236, 'Phuthaditjhaba'),
(851, 897, 'Pienaarsrivier'),
(852, 9318, 'Piet Plessis'),
(853, 237, 'Piet Retief'),
(854, 357, 'Pietermaritzburg'),
(855, 490, 'Piketberg'),
(856, 1058, 'Pilanesburg'),
(857, 562, 'Pilgrims Rest '),
(858, 240, 'Plettenberg Bay'),
(859, 10548, 'Pniel'),
(860, 737, 'Pofadder'),
(861, 930, 'Politsi'),
(862, 241, 'Polokwane'),
(863, 242, 'Pomeroy'),
(864, 11651, 'Pomfret'),
(865, 243, 'Pongola'),
(866, 362, 'Port Alfred'),
(867, 245, 'Port Edward'),
(868, 244, 'Port Elizabeth'),
(869, 485, 'Port Nolloth'),
(870, 612, 'Port Owen '),
(871, 247, 'Port Shepstone'),
(872, 777, 'Port St Johns'),
(873, 778, 'Port Zimbali'),
(874, 571, 'Porterville'),
(875, 449, 'Postmasburg'),
(876, 360, 'Potchefstroom'),
(877, 11730, 'Povall'),
(878, 248, 'Pretoria'),
(879, 12284, 'Pretoria Rural'),
(880, 12581, 'Pretoriuskop Camp, Kruger'),
(881, 246, 'Prieska'),
(882, 570, 'Prince Albert'),
(883, 641, 'Prince Alfred Hamlet'),
(884, 707, 'Pringle Bay'),
(885, 11242, 'Pudumong'),
(886, 650, 'Pullenshope'),
(887, 631, 'Pumula'),
(888, 931, 'Punda Maria'),
(889, 250, 'Queenstown'),
(890, 818, 'Qumbu'),
(891, 435, 'Qwa-Qwa'),
(892, 549, 'Radium '),
(893, 11731, 'Ramabesa'),
(894, 12302, 'Ramatlabama'),
(895, 251, 'Ramsgate'),
(896, 1017, 'Randfontein'),
(897, 11707, 'Ratsiepane'),
(898, 708, 'Rawsonville'),
(899, 693, 'Rayton'),
(900, 496, 'Rayton - Gauteng'),
(901, 256, 'Reddersburg'),
(902, 11999, 'Redelinghuys'),
(903, 498, 'Reebok'),
(904, 884, 'Refilwe'),
(905, 257, 'Reitz'),
(906, 459, 'Reivilo'),
(907, 11921, 'Rennshaw'),
(908, 12361, 'Rheenendal'),
(909, 254, 'Richards Bay'),
(910, 255, 'Richmond - EC'),
(911, 779, 'Richmond - KZN'),
(912, 12158, 'Richmond - NC'),
(913, 738, 'Riebeeck Kasteel'),
(914, 975, 'Riebeeckstad'),
(915, 609, 'Riebeek Wes '),
(916, 643, 'Rietkuil'),
(917, 740, 'Rietpoel'),
(918, 997, 'Rietspruit'),
(919, 11255, 'Rietspruit Mine'),
(920, 932, 'Rita'),
(921, 11234, 'Ritchie'),
(922, 566, 'Riversdale - WC'),
(923, 598, 'Riviersonderend'),
(924, 409, 'Robertson'),
(925, 10437, 'Rocky Drift'),
(926, 979, 'Roedtan'),
(927, 12113, 'Roodepan'),
(928, 12296, 'Roodeplaat'),
(929, 694, 'Roodewal'),
(930, 398, 'Rooi Els'),
(931, 12143, 'Rooiberg'),
(932, 863, 'Roossenekal'),
(933, 258, 'Rosendal'),
(934, 780, 'Rosetta'),
(935, 259, 'Rouxville'),
(936, 11708, 'Ruigtesloot'),
(937, 12623, 'Rust De Winter'),
(938, 260, 'Rustenburg'),
(939, 261, 'Sabie'),
(940, 392, 'Saldanha Bay'),
(941, 262, 'Salt Rock'),
(942, 781, 'San Lameer'),
(943, 545, 'Sandbaai'),
(944, 468, 'Sannieshof'),
(945, 998, 'Santoy'),
(946, 12398, 'Saron'),
(947, 263, 'Sasolburg'),
(948, 869, 'Saulspoort'),
(949, 11011, 'Schagen'),
(950, 859, 'Schoemansdal'),
(951, 885, 'Schoemansville'),
(952, 11645, 'Schoongezicht'),
(953, 264, 'Schweizer-Reneke'),
(954, 265, 'Scottburgh'),
(955, 404, 'Scottsville'),
(956, 803, 'Sea View'),
(957, 1021, 'Seafield'),
(958, 266, 'Secunda'),
(959, 434, 'Sedgefield'),
(960, 933, 'Sekhukhune'),
(961, 11709, 'Selepe'),
(962, 965, 'Sendelingsfontein'),
(963, 267, 'Senekal'),
(964, 904, 'Senwabarwana'),
(965, 11732, 'Sesane'),
(966, 542, 'Seshego'),
(967, 11716, 'Sespond'),
(968, 11752, 'Setabeng'),
(969, 10063, 'Setaria'),
(970, 11670, 'Setlagole'),
(971, 1014, 'Settlers'),
(972, 782, 'Seven Oaks'),
(973, 268, 'Sezela'),
(974, 1019, 'Shakaskraal'),
(975, 448, 'Shayandima'),
(976, 667, 'Sheepmoor'),
(977, 10440, 'Sheffield Beach'),
(978, 390, 'Shelly Beach'),
(979, 592, 'Shongweni '),
(980, 503, 'Sibasa'),
(981, 987, 'Sidbury'),
(982, 12128, 'Silkaatsnek'),
(983, 11655, 'Silverkrans'),
(984, 11717, 'Silwerkrans'),
(985, 11231, 'Simondium'),
(986, 11245, 'Sir Lowrys Pass'),
(987, 544, 'Siyabuswa'),
(988, 886, 'Skeerpoort'),
(989, 619, 'Skuinsdrif'),
(990, 860, 'Skukuza'),
(991, 1028, 'Slabberts'),
(992, 967, 'Slurry'),
(993, 270, 'Smithfield'),
(994, 620, 'Sodwana Bay '),
(995, 465, 'Somerset East'),
(996, 1000, 'Somerset West'),
(997, 421, 'Soshanguve'),
(998, 272, 'Southbroom'),
(999, 11733, 'Southey'),
(1000, 783, 'Southport'),
(1001, 696, 'Soutpan'),
(1002, 697, 'Spitskop'),
(1003, 273, 'Springbok'),
(1004, 274, 'Springfontein'),
(1005, 418, 'St Francis Bay'),
(1006, 741, 'St Helena Bay'),
(1007, 279, 'St Lucia'),
(1008, 280, 'St Michaels-on-Sea'),
(1009, 784, 'Staffords Post'),
(1010, 276, 'Standerton'),
(1011, 1026, 'Stanford'),
(1012, 451, 'Stanger'),
(1013, 416, 'Steelpoort'),
(1014, 868, 'Stella'),
(1015, 277, 'Stellenbosch'),
(1016, 12572, 'Sterkfontein'),
(1017, 564, 'Sterkspruit'),
(1018, 819, 'Sterkstroom'),
(1019, 489, 'Steynsburg'),
(1020, 278, 'Steynsrus'),
(1021, 804, 'Steytlerville'),
(1022, 523, 'Stilfontein'),
(1023, 381, 'Stillbaai'),
(1024, 380, 'Stoffberg'),
(1025, 1003, 'Stompneusbaai'),
(1026, 508, 'Stormsrivier'),
(1027, 281, 'Strand'),
(1028, 486, 'Struisbaai'),
(1029, 11260, 'Strydenburg'),
(1030, 282, 'Stutterheim'),
(1031, 594, 'Sun City '),
(1032, 440, 'Sundra'),
(1033, 535, 'Sundumbili'),
(1034, 11907, 'Sunland'),
(1035, 785, 'Sunwich Port'),
(1036, 584, 'Sutherland'),
(1037, 283, 'Swartberg'),
(1038, 11711, 'Swartboom'),
(1039, 586, 'Swartklip '),
(1040, 891, 'Swartruggens'),
(1041, 12626, 'Swartwater'),
(1042, 284, 'Swellendam'),
(1043, 285, 'Swinburne'),
(1044, 11751, 'Syferkuil'),
(1045, 968, 'Taaibosbult'),
(1046, 786, 'Tabankulu'),
(1047, 892, 'Tafelkop'),
(1048, 12349, 'Tala Valey'),
(1049, 286, 'Tarkastad'),
(1050, 1016, 'Tarlton'),
(1051, 10685, 'Tau Lekoa Mine'),
(1052, 456, 'Taung'),
(1053, 9320, 'Tekwane'),
(1054, 1032, 'Temba'),
(1055, 10617, 'Tergniet'),
(1056, 287, 'Thaba Nchu'),
(1057, 288, 'Thabazimbi'),
(1058, 12402, 'The Crags'),
(1059, 289, 'Theunissen'),
(1060, 291, 'Thohoyandou'),
(1061, 522, 'Thornhill, EC'),
(1062, 787, 'Thornville'),
(1063, 996, 'Thulamahashe - A'),
(1064, 11734, 'Thutlwane'),
(1065, 1012, 'Tinley Manor'),
(1066, 11710, 'Tladistad'),
(1067, 11669, 'Tlakgameng'),
(1068, 12401, 'Tlaseng'),
(1069, 11735, 'Tlholwe'),
(1070, 12353, 'Tolwe'),
(1071, 11966, 'Tom Burke'),
(1072, 12466, 'Tonga Village'),
(1073, 292, 'Tongaat'),
(1074, 610, 'Touws River '),
(1075, 11980, 'Trafalgar'),
(1076, 714, 'Trawal'),
(1077, 934, 'Trichardsdall'),
(1078, 293, 'Trichardt'),
(1079, 294, 'Trompsburg'),
(1080, 11736, 'Tseng'),
(1081, 11737, 'Tseoge'),
(1082, 11738, 'Tshetshu'),
(1083, 11739, 'Tshidilamolomo'),
(1084, 935, 'Tshikondeni'),
(1085, 936, 'Tshipise'),
(1086, 10633, 'Tsitsikamma'),
(1087, 820, 'Tsolo'),
(1088, 452, 'Tsomo'),
(1089, 295, 'Tugela Ferry'),
(1090, 985, 'Tugela Mouth'),
(1091, 296, 'Tulbagh'),
(1092, 11990, 'Tweefontein - Limpopo'),
(1093, 297, 'Tweeling'),
(1094, 298, 'Tweespruit'),
(1095, 437, 'Tzaneen'),
(1096, 300, 'Ubombo'),
(1097, 821, 'Ugie'),
(1098, 301, 'Uitenhage'),
(1099, 11715, 'Uitkyk'),
(1100, 11860, 'Ulco'),
(1101, 302, 'Ulundi'),
(1102, 303, 'Umdloti'),
(1103, 304, 'Umgababa'),
(1104, 582, 'Umhlali'),
(1105, 306, 'Umkomaas'),
(1106, 457, 'Umtata'),
(1107, 382, 'Umtentweni'),
(1108, 788, 'Umzimkulu'),
(1109, 307, 'Umzinto'),
(1110, 299, 'Umzumbe'),
(1111, 308, 'Underberg'),
(1112, 833, 'Uniondale'),
(1113, 369, 'Upington'),
(1114, 310, 'Utrecht'),
(1115, 311, 'Uvongo'),
(1116, 11884, 'Vaal Marina'),
(1117, 394, 'Vaal Reef'),
(1118, 313, 'Vaalbank'),
(1119, 12269, 'Vaalharts Nedersetting'),
(1120, 583, 'Vaalpark'),
(1121, 312, 'Vaalwater'),
(1122, 12453, 'Valtaki'),
(1123, 1037, 'Van Der Kloof'),
(1124, 10613, 'Van Dyksdrif'),
(1125, 314, 'Van Reenen'),
(1126, 715, 'Van Ryns Dorp'),
(1127, 11982, 'Van Zylsrus'),
(1128, 316, 'Vanderbijlpark'),
(1129, 698, 'Vanstadensrus'),
(1130, 12002, 'VanWyksdorp'),
(1131, 12372, 'Vanwyksvlei'),
(1132, 593, 'Velddrif'),
(1133, 318, 'Ventersburg'),
(1134, 442, 'Ventersdorp'),
(1135, 699, 'Venterstad'),
(1136, 330, 'Vereeniging'),
(1137, 894, 'Verena'),
(1138, 969, 'Vergelee'),
(1139, 317, 'Verkeerdevlei'),
(1140, 825, 'Verkykerskop'),
(1141, 970, 'Vermaas'),
(1142, 11887, 'Vermont'),
(1143, 638, 'Victoria West'),
(1144, 1006, 'Viedgesville'),
(1145, 971, 'Vierfontein'),
(1146, 320, 'Viljoenskroon'),
(1147, 323, 'Villiers'),
(1148, 407, 'Villiersdorp'),
(1149, 502, 'Virginia'),
(1150, 322, 'Vivo'),
(1151, 11988, 'Vlottenburg'),
(1152, 324, 'Volksrust'),
(1153, 11991, 'Vondwe'),
(1154, 11283, 'Vosburg'),
(1155, 527, 'Vrede'),
(1156, 328, 'Vredefort'),
(1157, 487, 'Vredenburg'),
(1158, 411, 'Vredendal'),
(1159, 326, 'Vryburg'),
(1160, 329, 'Vryheid'),
(1161, 561, 'Vulindlela'),
(1162, 937, 'Vuwani'),
(1163, 1036, 'Vyeboom'),
(1164, 659, 'Waburton'),
(1165, 332, 'Wakkerstroom'),
(1166, 11712, 'Walman'),
(1167, 504, 'Walmansthal'),
(1168, 331, 'Warden'),
(1169, 333, 'Warner Beach'),
(1170, 372, 'Warrenton'),
(1171, 335, 'Wartburg'),
(1172, 334, 'Wasbank'),
(1173, 10425, 'Waterfall'),
(1174, 350, 'Waterval Boven'),
(1175, 351, 'Waterval Onder'),
(1176, 336, 'Weenen'),
(1177, 337, 'Welkom'),
(1178, 745, 'Wellington'),
(1179, 710, 'Weltevrede'),
(1180, 12584, 'Welverdiend'),
(1181, 12585, 'Welverdiend Mine'),
(1182, 12373, 'Wemmershoek'),
(1183, 338, 'Wepener'),
(1184, 339, 'Wesselsbron'),
(1185, 700, 'Westminister'),
(1186, 348, 'Westonaria'),
(1187, 349, 'Westville'),
(1188, 789, 'Weza'),
(1189, 340, 'White River'),
(1190, 822, 'Whittlesea'),
(1191, 341, 'Widenham'),
(1192, 342, 'Wilderness'),
(1193, 11754, 'Wilgeboomspruit'),
(1194, 840, 'Williston'),
(1195, 546, 'Willowmore '),
(1196, 823, 'Willowvale'),
(1197, 543, 'Wilsonia'),
(1198, 343, 'Winburg'),
(1199, 12138, 'Windsorton'),
(1200, 345, 'Winkelspruit'),
(1201, 1054, 'Winterskloof'),
(1202, 346, 'Winterton'),
(1203, 1063, 'Winterveld'),
(1204, 344, 'Witbank'),
(1205, 1065, 'Witsand'),
(1206, 575, 'Wittedrif'),
(1207, 1027, 'Witteklip'),
(1208, 458, 'Wolmaranstad'),
(1209, 711, 'Wolseley'),
(1210, 895, 'Wolwehoek'),
(1211, 858, 'Wonderfontein'),
(1212, 347, 'Worcester'),
(1213, 608, 'Yzerfontein '),
(1214, 353, 'Zastron'),
(1215, 938, 'Zebediela'),
(1216, 354, 'Zeerust'),
(1217, 12290, 'Zinkwazi'),
(1218, 790, 'Zinkwazi Beach'),
(1219, 889, 'Zithobeni'),
(1220, 992, 'Zwelitsha');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `product_id` int(11) NOT NULL COMMENT 'product id, foreign key from products table',
  `user_id` int(11) NOT NULL COMMENT 'user id, foreign key from user table',
  `comment` mediumtext NOT NULL COMMENT 'comment text',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'commented date',
  PRIMARY KEY (`id`),
  KEY `FK_product_comments` (`product_id`),
  KEY `FK_user_comments` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Comments for the product';

-- --------------------------------------------------------

--
-- Table structure for table `coupon_codes`
--

DROP TABLE IF EXISTS `coupon_codes`;
CREATE TABLE IF NOT EXISTS `coupon_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `offer` int(11) NOT NULL,
  `offer_type` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `limit` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon_codes`
--

INSERT INTO `coupon_codes` (`id`, `code`, `start_date`, `end_date`, `offer`, `offer_type`, `status`, `limit`, `access`, `created`) VALUES
(2, '208527', '2017-05-01 00:00:00', '2018-02-16 00:00:00', 10, 'percentage', 1, 10000, 86, '2017-05-07 12:21:02'),
(3, 'adam77', '2017-06-19 00:00:00', '2017-07-31 00:00:00', 20, 'percentage', 1, 10000, 120, '2017-06-13 09:52:05');

-- --------------------------------------------------------

--
-- Table structure for table `email_subscription_list`
--

DROP TABLE IF EXISTS `email_subscription_list`;
CREATE TABLE IF NOT EXISTS `email_subscription_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Table to hold emails who subscribed to mailing list';

--
-- Dumping data for table `email_subscription_list`
--

INSERT INTO `email_subscription_list` (`id`, `email`, `created`) VALUES
(1, 'mijoemathew@gmail.com', '2018-08-07 07:38:00'),
(2, 'mijoepm@gmail.com', '2018-08-07 07:38:19'),
(3, 'mijoepm@gmail.com', '2018-08-07 07:38:24'),
(4, 'ajojosephkc@gmail.com', '2018-08-07 07:40:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(4, 'Group 1', ''),
(6, 'Group 2', '');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique_id',
  `product_id` int(11) NOT NULL COMMENT 'product id, foreign key from products table',
  `image` varchar(200) NOT NULL COMMENT 'image name with extension',
  `featured` int(1) NOT NULL DEFAULT '0' COMMENT '0 or 1, 1 for images loaded in home page',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'image added date',
  PRIMARY KEY (`id`),
  KEY `FK_product_images` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32499 DEFAULT CHARSET=utf8 COMMENT='Images realated with products';

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `product_id`, `image`, `featured`, `date`) VALUES
(32493, 17750, '1.jpg', 1, '2019-08-13 03:54:35'),
(32494, 17750, '19.jpg', 0, '2019-08-13 03:54:35'),
(32495, 17751, '10.jpg', 1, '2019-08-13 04:47:42'),
(32496, 17751, '11.jpg', 0, '2019-08-13 04:47:42'),
(32497, 17752, '749747-141-PHCFH001.jpg', 1, '2019-08-13 04:50:18'),
(32498, 17752, 'AQ4224-100-PHCFH001.jpg', 0, '2019-08-13 04:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `errno` int(2) NOT NULL,
  `errtype` varchar(32) NOT NULL,
  `errstr` text NOT NULL,
  `errfile` varchar(255) NOT NULL,
  `errline` int(4) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`,`ip_address`,`user_agent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mail_queue`
--

DROP TABLE IF EXISTS `mail_queue`;
CREATE TABLE IF NOT EXISTS `mail_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` varchar(150) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 - Not send. 1- Send',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `index` varchar(150) NOT NULL COMMENT 'unique identifier',
  `name` varchar(150) NOT NULL COMMENT 'name of manufacturer',
  `details` text NOT NULL COMMENT 'Description about manufacturer',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `index`, `name`, `details`, `date`) VALUES
(1, 'nuro-manu-58b54e723565e', 'Nuro', '7 Street, Midrand', '2017-02-28 10:18:26'),
(2, 'hello-plastic5c10c76344143', 'HELLO PLASTIC', '', '2018-12-12 08:31:31'),
(3, 'ntro5c1a2129e465c', 'NTRO', '', '2018-12-19 10:44:57'),
(4, 'sz5c1a212cebbcf', 'SZ', '', '2018-12-19 10:45:00'),
(5, 'otx5c1a213339e6f', 'OTX', '', '2018-12-19 10:45:07'),
(6, 'otsz5c1a213b62245', 'OTSZ', '', '2018-12-19 10:45:15'),
(7, 'fng5c1a213c2b388', 'FNG', '', '2018-12-19 10:45:16'),
(8, 'nan5c1a213d79701', 'NAN', '', '2018-12-19 10:45:17'),
(9, 'sw5c1a214330b57', 'SW', '', '2018-12-19 10:45:23'),
(10, 'changing-tides5c1a214ad9a41', 'CHANGING TIDES', '', '2018-12-19 10:45:30'),
(11, 'mv5c1a214d7f913', 'MV', '', '2018-12-19 10:45:33'),
(12, 'buy-more-wsalers5c1a214ec4ddf', 'BUY MORE W/SALERS', '', '2018-12-19 10:45:34'),
(13, 'season-star-trading5c1a215807fbf', 'SEASON STAR TRADING', '', '2018-12-19 10:45:44'),
(14, 'tariq-glass5c1a2182661ff', 'TARIQ GLASS', '', '2018-12-19 10:46:26'),
(15, 'kim-glass5c1a21864bf08', 'KIM GLASS', '', '2018-12-19 10:46:30'),
(16, 'test-manu-5d417ae0b0e92', 'TEst', 'Test', '2019-07-31 11:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `mygate_logs`
--

DROP TABLE IF EXISTS `mygate_logs`;
CREATE TABLE IF NOT EXISTS `mygate_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `data` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mygate_transactions`
--

DROP TABLE IF EXISTS `mygate_transactions`;
CREATE TABLE IF NOT EXISTS `mygate_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `result` varchar(150) NOT NULL,
  `transaction_index` varchar(250) NOT NULL,
  `acquire_time` varchar(250) NOT NULL,
  `auth_id` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `order_reference` varchar(100) NOT NULL COMMENT 'unique string identifier',
  `user_id` int(11) NOT NULL COMMENT 'Forign key to users table',
  `price` float NOT NULL COMMENT 'total price of orders',
  `coupon` text NOT NULL,
  `ship_address_id` int(11) NOT NULL COMMENT 'address to which item should send.',
  `ship_contact_id` int(11) NOT NULL,
  `shipping_address` text NOT NULL,
  `pos_shipping_price` float NOT NULL,
  `paid` int(1) NOT NULL DEFAULT '0' COMMENT '0 if not paid, 1 if paid',
  `transaction_id` varchar(150) NOT NULL COMMENT 'transaction id from gateway',
  `payment_method` varchar(50) NOT NULL DEFAULT 'mygate' COMMENT 'paypal/eft/mygate etc',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'order placed date time',
  `courier` varchar(50) NOT NULL,
  `courier_id1` varchar(100) NOT NULL,
  `courier_id2` varchar(100) NOT NULL,
  `courier_id3` varchar(100) NOT NULL,
  `courier_status` varchar(250) NOT NULL,
  `courier_delivery` varchar(30) NOT NULL,
  `order_placed` int(1) NOT NULL DEFAULT '0',
  `delivered` int(1) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `payment_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_reference` (`order_reference`),
  KEY `fk_user_orders` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_collivery_log`
--

DROP TABLE IF EXISTS `order_collivery_log`;
CREATE TABLE IF NOT EXISTS `order_collivery_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT 'collivery action type',
  `log` text NOT NULL COMMENT 'return from collivery',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_order_collivery` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='collivery logs for different orders';

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `order_id` int(11) NOT NULL COMMENT 'Forign key to orders table',
  `product_sku` varchar(150) NOT NULL COMMENT 'SKU of bought product',
  `product_name` varchar(250) NOT NULL COMMENT 'name of product purchased',
  `quantity` int(11) NOT NULL COMMENT 'quantity of products purchased',
  `price` float NOT NULL COMMENT 'price of product',
  `delivery_price` float NOT NULL,
  `weight` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `hight` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `option1` varchar(50) NOT NULL,
  `option2` varchar(50) NOT NULL,
  `option3` varchar(50) NOT NULL,
  `option4` varchar(50) NOT NULL,
  `option5` varchar(50) NOT NULL,
  `options` text NOT NULL,
  `status` varchar(150) NOT NULL COMMENT 'collivery status',
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_details` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posibolt_customer_code`
--

DROP TABLE IF EXISTS `posibolt_customer_code`;
CREATE TABLE IF NOT EXISTS `posibolt_customer_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `posibolt_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posibolt_logs`
--

DROP TABLE IF EXISTS `posibolt_logs`;
CREATE TABLE IF NOT EXISTS `posibolt_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_method` varchar(20) NOT NULL,
  `request_url` varchar(255) NOT NULL,
  `request_data` text NOT NULL,
  `response_data` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posibolt_logs`
--

INSERT INTO `posibolt_logs` (`id`, `request_method`, `request_url`, `request_data`, `response_data`, `date`) VALUES
(20, 'POST', 'http://osbro.posibolt.com/AdempiereService/PosiboltRest/customermaster/11893595', '{\"customerCode\":\"CUSTPOSposecom3\",\"name\":\"Adam Viles\",\"address1\":\"Adam Viles, NURO\",\"address2\":\"7th Street\",\"city\":\"Johannesburg\",\"mobile\":\"666666666666\",\"phone\":\"55555555555\",\"postalCode\":\"2001\",\"region\":\"Midrand\",\"email\":\"adam@nuro.co.za\",\"country\":\"South Africa\",\"active\":true,\"action\":\"update\"}', '{\"responseCode\":200,\"detailedMessage\":\"Entry Updated Successfully\",\"record\":\"Customer\",\"recordNo\":\"11893595\",\"message\":\"Sucess\"}', '2019-05-22 12:38:00'),
(19, 'POST', 'http://osbro.posibolt.com/AdempiereService/PosiboltRest/customermaster/11893595', '{\"customerCode\":\"CUSTPOSposecom3\",\"name\":\"Adam Viles\",\"address1\":\"Adam Viles, NURO\",\"address2\":\"7th Street\",\"city\":\"Johannesburg\",\"mobile\":\"666666666666\",\"phone\":\"55555555555\",\"postalCode\":\"2001\",\"region\":\"Midrand\",\"email\":\"adam@nuro.co.za\",\"country\":\"South Africa\",\"active\":true,\"action\":\"update\"}', '{\"responseCode\":200,\"detailedMessage\":\"Entry Updated Successfully\",\"record\":\"Customer\",\"recordNo\":\"11893595\",\"message\":\"Sucess\"}', '2019-05-22 12:37:55'),
(18, 'POST', 'http://osbro.posibolt.com/AdempiereService/PosiboltRest/salesorder/createorder', '{\"orderNo\":\"ORDPOSposecom87\",\"customerCode\":\"CUSTPOSposecom3\",\"description\":\" - \",\"dateOrdered\":\"22-05-2019\",\"invoiceRule\":\"After Delivery\",\"paymentType\":\"EFT\",\"orderLineList\":[{\"productId\":\"1010566\",\"qty\":\"1\",\"price\":\"3995\",\"uom\":\"Each\"}]}', '{\"responseCode\":400,\"detailedMessage\":\"Product is not active\",\"record\":null,\"recordNo\":null,\"message\":\"Bad Request\"}', '2019-05-22 12:37:15'),
(17, 'POST', 'http://osbro.posibolt.com/AdempiereService/PosiboltRest/customermaster/11893595', '{\"customerCode\":\"CUSTPOSposecom3\",\"name\":\"Adam Viles\",\"address1\":\"Adam Viles, NURO\",\"address2\":\"7th Street\",\"city\":\"Johannesburg\",\"mobile\":\"666666666666\",\"phone\":\"55555555555\",\"postalCode\":\"2001\",\"region\":\"Midrand\",\"email\":\"adam@nuro.co.za\",\"country\":\"South Africa\",\"active\":true,\"action\":\"update\"}', '{\"responseCode\":200,\"detailedMessage\":\"Entry Updated Successfully\",\"record\":\"Customer\",\"recordNo\":\"11893595\",\"message\":\"Sucess\"}', '2019-05-22 12:37:14'),
(16, 'POST', 'http://osbro.posibolt.com/AdempiereService/PosiboltRest/customermaster/11893595', '{\"customerCode\":\"CUSTPOSposecom3\",\"name\":\"Adam Viles\",\"address1\":\"Adam Viles, NURO\",\"address2\":\"7th Street\",\"city\":\"Johannesburg\",\"mobile\":\"666666666666\",\"phone\":\"55555555555\",\"postalCode\":\"2001\",\"region\":\"Midrand\",\"email\":\"adam@nuro.co.za\",\"country\":\"South Africa\",\"active\":true,\"action\":\"update\"}', '{\"responseCode\":200,\"detailedMessage\":\"Entry Updated Successfully\",\"record\":\"Customer\",\"recordNo\":\"11893595\",\"message\":\"Sucess\"}', '2019-05-22 12:36:54'),
(15, 'POST', 'http://osbro.posibolt.com/AdempiereService/PosiboltRest/customermaster/11893595', '{\"customerCode\":\"CUSTPOSposecom3\",\"name\":\"Adam Viles\",\"address1\":\"Adam Viles, NURO\",\"address2\":\"7th Street\",\"city\":\"Johannesburg\",\"mobile\":\"666666666666\",\"phone\":\"55555555555\",\"postalCode\":\"2001\",\"region\":\"Midrand\",\"email\":\"adam@nuro.co.za\",\"country\":\"South Africa\",\"active\":true,\"action\":\"update\"}', '{\"responseCode\":200,\"detailedMessage\":\"Entry Updated Successfully\",\"record\":\"Customer\",\"recordNo\":\"11893595\",\"message\":\"Sucess\"}', '2019-05-16 11:07:01'),
(13, 'POST', 'http://osbro.posibolt.com/AdempiereService/PosiboltRest/customermaster/11893595', '{\"customerCode\":\"CUSTPOSposecom3\",\"name\":\"Adam Viles\",\"address1\":\"Adam Viles, NURO\",\"address2\":\"7th Street\",\"city\":\"Johannesburg\",\"mobile\":\"666666666666\",\"phone\":\"55555555555\",\"postalCode\":\"2001\",\"region\":\"Midrand\",\"email\":\"adam@nuro.co.za\",\"country\":\"South Africa\",\"active\":true,\"action\":\"update\"}', '{\"responseCode\":200,\"detailedMessage\":\"Entry Updated Successfully\",\"record\":\"Customer\",\"recordNo\":\"11893595\",\"message\":\"Sucess\"}', '2019-05-16 10:24:28'),
(14, 'POST', 'http://osbro.posibolt.com/AdempiereService/PosiboltRest/salesorder/createorder', '{\"orderNo\":\"ORDPOSposecom86\",\"customerCode\":\"CUSTPOSposecom3\",\"description\":\" - \",\"dateOrdered\":\"16-05-2019\",\"invoiceRule\":\"After Delivery\",\"paymentType\":\"EFT\",\"orderLineList\":[{\"productId\":\"1010566\",\"qty\":\"2\",\"price\":\"3995\",\"uom\":\"Each\"}]}', '{\"responseCode\":400,\"detailedMessage\":\"Product is not active\",\"record\":null,\"recordNo\":null,\"message\":\"Bad Request\"}', '2019-05-16 10:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `posibolt_product_code`
--

DROP TABLE IF EXISTS `posibolt_product_code`;
CREATE TABLE IF NOT EXISTS `posibolt_product_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `posibolt_pooduct_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `short_name` varchar(50) DEFAULT NULL COMMENT 'product short name displayed - Required',
  `long_name` varchar(250) NOT NULL COMMENT 'product longname displayed - Optional',
  `model` varchar(20) NOT NULL COMMENT 'Model string',
  `short_description` varchar(250) NOT NULL COMMENT 'sort description-(Max 250 chars)',
  `long_description` mediumtext NOT NULL COMMENT 'Long description',
  `status` int(1) NOT NULL COMMENT '0 - Not active, 1- Active and visible',
  `featured` int(1) NOT NULL COMMENT '0-Not featured, 1-featured',
  `last_modified` datetime NOT NULL COMMENT 'last modified',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'created date',
  `views` int(11) NOT NULL COMMENT 'total views to product',
  `code` varchar(50) NOT NULL,
  `sku` varchar(250) NOT NULL COMMENT 'unique product identifier',
  `page_title` varchar(250) NOT NULL,
  `meta_keys` varchar(250) NOT NULL,
  `meta_description` varchar(250) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `strike_price` decimal(10,2) NOT NULL,
  `strike_status` int(11) NOT NULL,
  `weight` float NOT NULL,
  `height` float NOT NULL,
  `length` float NOT NULL,
  `width` float NOT NULL,
  `envelop_type` int(11) NOT NULL COMMENT 'Envelop type based on dimension from collivery',
  `inventory` int(11) NOT NULL DEFAULT '1' COMMENT '1-Do not track, 2-Track, 3-Option based track ',
  `stock_min` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `sync` int(1) NOT NULL DEFAULT '0' COMMENT 'Whether its created from admin or through sync 1 - sync, 0-system',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`),
  KEY `short_name` (`short_name`)
) ENGINE=InnoDB AUTO_INCREMENT=17753 DEFAULT CHARSET=utf8 COMMENT='Products table';

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `short_name`, `long_name`, `model`, `short_description`, `long_description`, `status`, `featured`, `last_modified`, `date`, `views`, `code`, `sku`, `page_title`, `meta_keys`, `meta_description`, `price`, `strike_price`, `strike_status`, `weight`, `height`, `length`, `width`, `envelop_type`, `inventory`, `stock_min`, `stock`, `sync`) VALUES
(17750, 'V.KLO Tailored cut suit', 'V.KLO Tailored cut suit', 'MT6645', '', '<p>Test description</p>', 1, 1, '0000-00-00 00:00:00', '2019-08-13 03:47:20', 0, '', 'MT6645', 'V.KLO Tailored cut suit', 'V.KLO Tailored cut suit', 'V.KLO Tailored cut suit', '1450.00', '2450.00', 1, 0, 0, 0, 0, 1, 3, 0, 0, 0),
(17751, 'D.KLO Tailored cut suit', 'D.KLO Tailored cut suit', 'MT6646', '', '<p>Test product</p>', 1, 1, '0000-00-00 00:00:00', '2019-08-13 04:45:20', 0, '', 'MT6646', 'D.KLO Tailored cut suit', 'D.KLO Tailored cut suit', 'D.KLO Tailored cut suit', '1345.00', '1825.00', 1, 0, 0, 0, 0, 1, 3, 0, 0, 0),
(17752, 'C.KLO Tailored cut suit', 'C.KLO Tailored cut suit', 'MT6647', '', '<p>New other test</p>', 1, 1, '0000-00-00 00:00:00', '2019-08-13 04:48:50', 0, '', 'MT6647', 'C.KLO Tailored cut suit', 'C.KLO Tailored cut suit', 'C.KLO Tailored cut suit', '1670.00', '2400.00', 1, 0, 0, 0, 0, 1, 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

DROP TABLE IF EXISTS `product_attributes`;
CREATE TABLE IF NOT EXISTS `product_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `product_id` int(11) NOT NULL COMMENT 'product id, foreign key from products table',
  `group_id` int(11) NOT NULL COMMENT 'attribute id, foreign key from attributes table',
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_unique_product_id_attribute_id_value` (`product_id`,`group_id`),
  KEY `fk_products_attributes` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2664 DEFAULT CHARSET=utf8 COMMENT='Attribute details for products';

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `group_id`) VALUES
(2661, 17750, 2594),
(2662, 17751, 2593),
(2663, 17752, 2594);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `product_id` int(11) NOT NULL COMMENT 'product id, foreign key from products table',
  `category_id` int(11) NOT NULL COMMENT 'category id, foreign key from categoriestable',
  PRIMARY KEY (`id`),
  UNIQUE KEY `my_unique_key_with_nulls` (`product_id`,`category_id`),
  KEY `fk_category_categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32514 DEFAULT CHARSET=utf8 COMMENT='Categories details for products';

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `product_id`, `category_id`) VALUES
(32506, 17750, 1),
(32507, 17750, 2),
(32508, 17751, 5),
(32509, 17751, 7),
(32510, 17751, 11),
(32511, 17752, 5),
(32512, 17752, 7),
(32513, 17752, 11);

-- --------------------------------------------------------

--
-- Table structure for table `product_discounts`
--

DROP TABLE IF EXISTS `product_discounts`;
CREATE TABLE IF NOT EXISTS `product_discounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity_from` int(11) NOT NULL,
  `quantity_to` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1-Price discount, 2-Percentage Discount, 3-Fixed Price',
  `discount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_dicounts` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_manufacurer`
--

DROP TABLE IF EXISTS `product_manufacurer`;
CREATE TABLE IF NOT EXISTS `product_manufacurer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `product_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_manufactures` (`product_id`),
  KEY `fk_manu_manufactures` (`manufacturer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_usergroups`
--

DROP TABLE IF EXISTS `product_usergroups`;
CREATE TABLE IF NOT EXISTS `product_usergroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL DEFAULT '0' COMMENT 'unique identifier',
  `product_id` int(11) NOT NULL COMMENT 'product id, foreign key from products table',
  `user_id` int(11) NOT NULL COMMENT 'user id, foreign key from user table',
  `star` int(11) NOT NULL DEFAULT '0' COMMENT 'comment text',
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'commented date',
  KEY `fk_products_rating` (`product_id`),
  KEY `fk_user_rating` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rest_keys`
--

DROP TABLE IF EXISTS `rest_keys`;
CREATE TABLE IF NOT EXISTS `rest_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rest_logs`
--

DROP TABLE IF EXISTS `rest_logs`;
CREATE TABLE IF NOT EXISTS `rest_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `errno` int(2) NOT NULL,
  `errtype` varchar(32) NOT NULL,
  `errstr` text NOT NULL,
  `errfile` varchar(255) NOT NULL,
  `errline` int(4) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`,`ip_address`,`user_agent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `index` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `index`, `value`) VALUES
(1, 'banner_1', 'test'),
(2, 'store_name', 'Posecom'),
(3, 'store_owner', 'Jackson'),
(4, 'store_email', 'adam@nuro.co.za'),
(5, 'store_address', '7 Test street'),
(6, 'store_number', 'ddddddddd'),
(7, 'store_collivery', '1234'),
(8, 'show_price', '0'),
(9, 'use_catalogue', 'catalogue_and_request'),
(10, 'free_amount', '1000'),
(11, 'payment_method', '[\"credit card\",\"EFT\",\"On credit\"]'),
(12, 'store_logo', 'wholesalerlogo.png'),
(13, 'link1', 'https://posecom.co.za/install/'),
(14, 'banner1', 'DSC_00917.JPG'),
(15, 'link2', 'https://posecom.co.za/install/'),
(16, 'banner2', 'rawpixel-777267-unsplash7.jpg'),
(17, 'link3', 'https://posecom.co.za/install/'),
(18, 'banner3', 'green.jpeg'),
(19, 'link4', 'https://posecom.co.za/install/'),
(20, 'banner4', 'green1.jpeg'),
(21, 'link5', 'https://posecom.co.za/install/'),
(22, 'banner5', 'green2.jpeg'),
(23, 'link6', 'https://posecom.co.za/install/'),
(24, 'sub_banner1', 'green3.jpeg'),
(25, 'link7', 'https://posecom.co.za/install//products/all.html'),
(26, 'sub_banner2', 'green4.jpeg'),
(27, 'link8', 'https://posecom.co.za/install//products/all.html'),
(28, 'terms', '<h1>TERMS AND CONDITIONS</h1>\r\n\r\n<p><br />\r\n<strong>Definitions</strong><br />\r\n&quot;Supplier/Store&quot; means a third party seller of goods and services from whom the Customer will receive their purchased product. &nbsp;<br />\r\n&quot;Purchase&quot; means the purchase of a product offered on the website.<br />\r\n&quot;Products&quot; means goods and/or services offered by a particular Supplier/Store which are described as part of an offer on the website.<br />\r\n&ldquo;Website&quot; means the www.XXXXXXXX.co.za&nbsp;website and any Microsite.<br />\r\n&ldquo;Customer&rdquo; means any person who purchases a Product from the website.<br />\r\n<br />\r\n<strong>Introduction</strong><br />\r\nThis Agreement contains the complete terms and conditions that apply to you in joining, buying, and participating (and all other related activities) in our website. By utilising or purchasing products from this Website, you agree to be bound by its terms of use and shall comply with same as if it comprised a binding contract.&nbsp;<br />\r\n<br />\r\nThis Agreement describes and encompasses the entire agreement between us and you, and supersedes all prior or contemporaneous agreements, representations, warranties and understandings with respect to the Site, the content and computer programs provided by or through the Site, and the subject matter of this Agreement. Amendments to this agreement can be made and effected by us from time to time without specific notice to you.<br />\r\n<br />\r\nThe agreement posted on the Site reflects the latest agreement and you should carefully review the same before you use our site. We reserve the right to amend these Terms and Conditions at any time and without any prior notice being given to Customers. You may terminate this Agreement by written notice to us (by post or by email) if you do not wish to be bound by such new terms and conditions.<br />\r\n<br />\r\nHowever, continued use of the Service or the Website will be deemed to constitute acceptance of the new terms and conditions.<br />\r\n<br />\r\n<strong>Use of the site and prohibitions</strong><br />\r\nThe Site allows you to shop online. However, you are prohibited to use our site, including its services and/or tools if you are not able to form legally binding contracts, are under the age of 18, or are temporarily or indefinitely suspended from using our sites, services or tools. By using the Website and/or the Service you warrant that you are 18 years of age or older and that you have legal capacity to conclude this Agreement with us.<br />\r\n<br />\r\nFor you to complete the sign-up process on our site, you must provide your full legal name, a valid email address, and any other information needed in order to complete the sign-up process. You confirm that you are 18 years or older and will be responsible for keeping your password secure and be responsible for all activities and contents that are uploaded under your account. Please note that you are entirely responsible for any loss or damage you may suffer if you do not maintain the confidentiality of your password and an unauthorised person is able to access your account.<br />\r\n<br />\r\nYou must not transmit any worms or viruses or any code of a destructive nature. We reserve the right to prevent you using the Website and the Service (or any part of them) and to prevent you from making any Purchase.<br />\r\n<br />\r\n<strong>TRANSACTION CURRENCY</strong><br />\r\nAll transactions on this site are in Rands/ZAR.<br />\r\n<br />\r\n<strong>ORDERING</strong><br />\r\nWhilst we try and ensure that all details, descriptions and prices which appear on this Website are accurate, errors may occur. If we discover an error in the price of any goods which you have ordered we will inform you of this as soon as possible and give you the option of reconfirming your order at the correct price or cancelling it. If we are unable to contact you we will treat the order as cancelled. If you cancel and you have already paid for the goods, you will receive a full refund.<br />\r\n<br />\r\nDelivery costs will be charged in addition; such additional charges are clearly displayed where applicable and included in the &#39;Total Cost&#39;.<br />\r\n<br />\r\n<strong>STOCK AVAILABILITY</strong><br />\r\nWe cannot always ensure stock availability at the time of the Purchase however we will ensure we provide the Customer with their purchased product once the product is in stock and within a reasonable time. Should the purchased product fail to come into stock within a reasonable period, you will receive a full refund.<br />\r\n<br />\r\n<strong>PRIVACY NOTICE</strong><br />\r\nThis policy covers all users who register to use the website. It is not necessary to purchase anything in order to gain access to the searching facilities of the site. Please read it here.<br />\r\n<br />\r\n<strong>SECURITY</strong><br />\r\nWe have taken the appropriate measures to ensure that your personal information is not unlawfully processed. XXXXXXXX uses industry standard practices to safeguard the confidentiality of your personal identifiable information, including &lsquo;firewalls&rsquo; and secure socket layers.&nbsp;<br />\r\n<br />\r\nDuring the payment process, we ask for personal information that is used purely to process your order.<br />\r\n<br />\r\nXXXXXXXX DOES NOT store any of your credit card information.&nbsp;<br />\r\n<br />\r\n<strong>CONDITIONS OF USE</strong><br />\r\nXXXXXXXX and its affiliates provide their services to you subject to these Terms and conditions. If you visit our shop at www.XXXXXXXX.co.za you accept these conditions. Please read them carefully, XXXXXXXX controls and operates this site from its offices within South Africa. The laws of South Africa govern claims relating to and including the use of, this site and materials contained.<br />\r\n<br />\r\n<strong>COPYRIGHTS</strong><br />\r\nAll content included on the site such as text, graphics logos, button icons, images, audio clips, digital downloads and software are all owned by XXXXXXXX and are protected by international copyright laws.<br />\r\n<br />\r\n<strong>LICENSE AND SITE ACCESS</strong><br />\r\nXXXXXXXX grants you a limited license to access and make personal use of this site. This license does not include any resale for commercial use of this site or its contents, any collection and use of any products, any collection and use of any product listings, descriptions or prices, any derivative use of this site or its contents, any downloading or copying of account information for the benefit of another merchant or any use of data mining, robots or similar data gathering and extraction tools.<br />\r\n<br />\r\nThis site may not be reproduced, duplicated, copied, sold, resold or otherwise exploited for any commercial reason without the express written consent of XXXXXXXX.<br />\r\n<br />\r\nWe do not warrant that your use of the Service or the Website will be uninterrupted and we do not warrant that any information (or messages) transmitted via the Service or the Website will be transmitted accurately, reliably, in a timely manner or at all.<br />\r\n<br />\r\nWe do not give any warranty that the Service or the Website is free from viruses or anything else which may have a harmful effect on any technology.<br />\r\n<br />\r\n<strong>PRICES</strong><br />\r\nPrices for all products on this site include VAT.<br />\r\n<br />\r\n<strong>PAYMENTS AND PROCESSES OF INVIOCES</strong><br />\r\nXXXXXXXX has the sole discretion to provide the terms of payment. Unless otherwise agreed, payment must first be received by XXXXXXXX prior to the acceptance of a product order.<br />\r\n<br />\r\nA payment confirmation will be sent to the customer once payment has been made and an order confirmation will be sent to you once the order has been processed.<br />\r\n<br />\r\nAn order may be invoiced separately. XXXXXXXX has the discretion to cancel or deny orders without any reason being provided to the Customer. XXXXXXXX is not responsible for pricing, typographical or other related errors in any offer by XXXXXXXXX and reserves the right to cancel any orders arising from such errors.<br />\r\n<br />\r\n<strong>Online Payments:</strong> MyGate Payment Gateway<br />\r\nAll online payments are processed by the MyGate Payment Gateway. Consumers may go to <a href=\"http://www.mygate.co.za\" target=\"_blank\">www.mygate.co.za</a> to view MyGate&rsquo;s security policies.<br />\r\n<br />\r\n<strong>PRODUCT PRICING &amp; DESCRIPTIONS</strong><br />\r\nThe List Price displayed for products on our website represents the full retail price listed on the product itself. We do not warrant that product descriptions or other content of this site is accurate, complete, reliable, current, or error-free. We reserve the right to correct any errors, inaccuracies or omissions and to change or update information at any time without prior notice. &nbsp;If a product offered in our website is not as described, it is the customer&rsquo;s responsibility to query this with XXXXXXXX via our contact details.<br />\r\n<br />\r\n<strong>EDITING, DELETING AND MODIFICATION</strong><br />\r\nWe may edit, delete or modify any of the terms and conditions contained in this Agreement, at any time and in our sole discretion, by posting a notice or a new agreement on our site. Your continued participation in our program, visit and shopping in our site following our posting of a change notice or new agreement on our site will constitute binding acceptance of the change.<br />\r\n<br />\r\n<strong>ACKNOWLEDGMENT OF RIGHTS</strong><br />\r\nYou hereby acknowledge that all rights, titles and interests, including but not limited to rights covered by the Intellectual Property Rights, in and to the site, and that you will not acquire any right, title or interest in or to the Site except as expressly set forth in this Agreement.<br />\r\n<br />\r\nYou will not modify, adapt, translate or prepare derivative works from, decompile, reverse engineer, disassemble or otherwise attempt to derive source code from any of our services, software, or documentation, or create or attempt to create a substitute or similar service or product through use of or access to the Program or proprietary information related thereto.<br />\r\n<br />\r\n<strong>THE CUSTOMER&rsquo;S OBLIGATIONS</strong><br />\r\nYou warrant that all information provided during the course of this Agreement is true, complete and accurate and that you will promptly inform us of any changes.<br />\r\n<br />\r\nIt is your responsibility to ensure that any products, services or information available through the Website or the Service meet your specific requirements.<br />\r\n<br />\r\n<strong>Without limitation, you undertake not to use or permit anyone else to use the Service or Website:</strong><br />\r\nto send or receive any material which is not civil or tasteful;<br />\r\nto send or receive any material which is threatening, grossly offensive, of an indecent, obscene or menacing character, blasphemous or defamatory of any person, in contempt of court or in breach of confidence, copyright, rights of personality, publicity or privacy or any other third party rights;<br />\r\nto send or receive any material for which you have not obtained all necessary licences and/or approvals (from us or third parties); or which constitutes or encourages conduct that would be considered a criminal offence, give rise to civil liability, or otherwise be contrary to the law of or infringe the rights of any third party in any country in the world;<br />\r\nto send or receive any material which is technically harmful (including computer viruses, logic bombs, Trojan horses, worms, harmful components, corrupted data or other malicious software or harmful data);<br />\r\nto cause annoyance, inconvenience or needless anxiety;<br />\r\nto intercept or attempt to intercept any communications transmitted by way of a telecommunications system;<br />\r\nfor a purpose other than which we have designed them or intended them to be used;<br />\r\nfor any fraudulent purpose;<br />\r\nother than in conformance with accepted Internet practices and practices of any connected networks; or<br />\r\nin any way which is calculated to incite hatred against any ethnic, religious or any other minority or is otherwise calculated to adversely affect any individual, group or entity.<br />\r\n<br />\r\nThe following uses of the Service (and Website) are expressly prohibited and you undertake not to do (or to permit anyone else to do) any of the following:<br />\r\nfurnishing false data including false names, addresses and contact details and fraudulent use of credit/debit card numbers;<br />\r\nattempting to circumvent our security or network including accessing data not intended for you, logging into a server or account you are not expressly authorised to access, or probing the security of other networks (such as running a port scan);<br />\r\nexecuting any form of network monitoring which will intercept data not intended for you;<br />\r\nsending unsolicited mail messages, including the sending of &quot;junk mail&quot; or other advertising material to individuals who did not specifically request such material. You are explicitly prohibited from sending unsolicited bulk mail messages. This includes bulk mailing of commercial advertising, promotional, or informational announcements, and political or religious tracts. Such material may only be sent to those who have explicitly requested it. If a recipient asks to stop receiving email of this nature, you may not send that person any further email;<br />\r\ncreating or forwarding &quot;chain letters&quot; or other &quot;pyramid schemes&quot; of any type, whether or not the recipient wishes to receive such mailings;<br />\r\nsending malicious email, including flooding a user or site with very large or numerous emails;<br />\r\nentering into fraudulent interactions or transactions with us or a Supplier (which shall include entering into interactions or transactions purportedly on behalf of a third party where you have no authority to bind that third party or you are pretending to be a third party);<br />\r\nengage in any conduct which, in our exclusive reasonable opinion, restricts or inhibits any other customer from properly using or enjoying the Website and Service.<br />\r\n<br />\r\n<strong>FRAUD</strong><br />\r\nFraudulent activities are highly monitored in our site and if fraud is detected XXXXXXXX shall utilise all remedies available to us to prevent or stop such fraud and shall pursue legal action against the fraudulent customer/s and you shall be responsible for all costs and legal fees arising from these fraudulent activities.<br />\r\n<br />\r\n<strong>CONFIDENTIALITY</strong><br />\r\nYou agree not to disclose information you obtain from us and/or from our clients, advertisers and suppliers. All information submitted to us by an end-user customer pursuant to a Program is proprietary information of XXXXXXXX.<br />\r\n<br />\r\nSuch customer information is confidential and may not be disclosed. The publisher agrees not to reproduce, disseminate, sell, distribute or commercially exploit any such proprietary information in any manner.<br />\r\n<br />\r\n<strong>NON-WAIVER</strong><br />\r\nFailure of XXXXXXXX to insist upon strict performance of any of the terms, conditions and covenants hereof shall not be deemed a relinquishment or waiver of any rights or remedy that the we may have, nor shall it be construed as a waiver of any subsequent breach of the terms, conditions or covenants hereof, which terms, conditions and covenants shall continue to be in full force and effect.<br />\r\n<br />\r\nNo waiver by either party of any breach of any provision hereof shall be deemed a waiver of any subsequent or prior breach of the same or any other provision.<br />\r\n<br />\r\n<strong>MISCELLANEOUS</strong><br />\r\nThis Agreement shall be governed by and construed in accordance with the substantive laws of South Africa, without any reference to conflict-of-laws principles.<br />\r\n<br />\r\nAny dispute, controversy or difference which may arise between the parties out of, in relation to or in connection with this Agreement is hereby irrevocably submitted to the exclusive jurisdiction of the courts of South Africa, to the exclusion of any other courts without giving effect to its conflict of law&rsquo;s provisions or your actual state or country of residence.<br />\r\n<br />\r\nThe entire agreement between the parties with respect to the subject matter hereof is embodied on this agreement and no other agreement relative hereto shall bind either party herein.<br />\r\n<br />\r\nYour rights of whatever nature cannot be assigned nor transferred to anybody, and any such attempt may result in termination of this Agreement, without liability to us. However, we may assign this Agreement to any person at any time without notice.<br />\r\n<br />\r\nIn the event that any provision of these Terms and Conditions is found invalid or unenforceable pursuant to any judicial decree or decision, such provision shall be deemed to apply only to the maximum extent permitted by law, and the remainder of these Terms and Conditions shall remain valid and enforceable according to its terms.<br />\r\n<br />\r\nIf any provision of this Agreement is held to be unlawful, invalid or unenforceable, that provision shall be deemed severed and where capable the validity and enforceability of the remaining provisions of this agreement shall not be affected.<br />\r\n<br />\r\nExcept as expressly stated in this Agreement, all warranties, conditions and other terms, whether express or implied, by statute, common law or otherwise are hereby excluded to the fullest extent permitted by law.<br />\r\n<br />\r\nThis Agreement (and our Privacy Policy) contains all the terms agreed between the parties regarding its subject matter and supersedes and excludes any prior agreement, understanding or arrangement between the parties, whether oral or in writing. No representation, undertaking or promise shall be taken to have been given or be implied from anything said or written in negotiations between the parties prior to this Agreement except as expressly stated in this Agreement.<br />\r\n<br />\r\nNeither party shall have any remedy in respect of any untrue statement made by the other upon which that party relied in entering into this Agreement (unless such untrue statement was made fraudulently or was as to a matter fundamental to a party&rsquo;s ability to perform this Agreement) and that party&rsquo;s only remedies shall be for breach of contract as provided in this Agreement. However, the Service is provided to you under our operating rules, policies, and procedures as published from time to time on the Website.<br />\r\n<br />\r\n<strong>OUTBOUND LINKS</strong><br />\r\nThe website may contain links to third-party websites and resources (&ldquo;linked sites&rdquo;). These linked sites are provided solely as a convenience to you and not as an endorsement by XXXXXXXX. XXXXXXXX makes no representations or warranties regarding the availability, correctness, accuracy, performance or quality of the linked site or any content, software, service or application found at any linked site. XXXXXXXX may receive payments and/or commissions from operators of linked sites in relation to goods or services supplied by the operator as a result of you linking to the third party website from the XXXXXXXX website.<br />\r\n<br />\r\n<strong>INBOUND LINKS</strong><br />\r\nXXXXXXXX encourages and agrees to your linking to the Home page through a plain text link on your website or any other page or social networking website without the need for agreement between yourself and XXXXXXXX.<br />\r\n<br />\r\n<strong>LIMITATION OF LIABILITY</strong><br />\r\nIf XXXXXXXX is found responsible for any damages, XXXXXXXX is responsible for actual damages suffered only and only such damages that were suffered as a direct result of XXXXXXXX&rsquo;s conduct or negligence. In no event shall XXXXXXXX be liable for any incidental, indirect, exemplary, punitive and/or consequential damages, lost profits, or damages resulting from lost data or business interruption resulting from the use of or inability to use the website.<br />\r\n<br />\r\nYou shall indemnify us against each loss, liability or cost incurred by us arising out of:<br />\r\nany claims or legal proceedings which are brought or threatened against us by any person arising from your use of the Service or Website, the purchasing of a product, the use of the Service or Website through your password or any breach of this Agreement by you. These losses include but are not limited to loss of revenue, loss of actual or anticipated profits, loss of contracts, loss of the use of money, loss of anticipated savings, loss of business, loss of opportunity, loss of good will, loss of reputation, loss of damage to or corruption of data; or any indirect or consequential loss.<br />\r\n<br />\r\n<strong>GENERAL CONDITIONS OF SALE</strong><br />\r\nThe following Conditions of Sale shall apply to any product sold on this website. These Conditions of Sale constitute a complete and exclusive statement of the agreement and understanding between you and XXXXXXXX with respect to the subject matter hereof.<br />\r\n<br />\r\na. The products offered under this Agreement shall be of normal quality.<br />\r\n<br />\r\nb. The products available on the website for sale under these Conditions of Sale are only available for sale to individuals who can make legally binding contracts. The products are not available to persons under the age of 18 years nor any other person legally prohibited from entering into a binding contract. By placing your order you are verifying to XXXXXXXX that you are able to make a legally binding contract.<br />\r\n<br />\r\nc. Your order is an offer by you to purchase a particular product for the price specified on the website at the time of offer and shall be understood to be placed under these Conditions of Sale.<br />\r\n<br />\r\nd. These Conditions of Sale may change from time to time and you are required within reason to revisit these before placing your order to ensure that these Conditions of Sale have not changed.<br />\r\n<br />\r\ne. XXXXXXXX reserves the right to accept or reject your offer for any reason, including, without limitation, an error in the product description or an error in your order. Your contract with XXXXXXXX only comes into existence when XXXXXXXX forwards you an email containing a receipt of your order in the form of the &quot;Payment confirmation&quot; and &quot;Order confirmation&quot; containing your payment details and order details.<br />\r\n<br />\r\nf. This contract shall be governed by and construed in accordance with the law in effect in South Africa and by entering into contract both parties are accepting the jurisdiction of the courts of South Africa in relation to any dispute between them.<br />\r\n<br />\r\ng. You are required to inspect the goods immediately upon collection.<br />\r\n<br />\r\nh. Ownership and property in the goods supplied/delivered shall pass from the store to you when XXXXXXXX accepts payment. Risk passes to you upon collection of your product.<br />\r\n<br />\r\ni. You assume all risks and liabilities for consequences arising from the use of the goods whether singly or in combination with other goods and indemnify XXXXXXXX in respect of any such use. XXXXXXXX is not liable for any infringement of patent rights arising out of the use of such goods by you or your instructions, expressed or implied, and it is your responsibility of to ensure that the goods when used by you are not damaged and no liability will be accepted by XXXXXXXX for the consequences of the use of damaged goods by you.</p>'),
(29, 'policy', '<h1>RETURNS POLICY</h1>\r\n\r\n<p><br />\r\nIf you are not entirely satisfied with your purchase, we&#39;re here to help.<br />\r\n<br />\r\n<strong>Returns</strong><br />\r\nYou have 30 calendar days to return an item from the date you received it.<br />\r\nTo be eligible for a return, your item must be unused and in the same condition that you received it.<br />\r\nYour item must be in the original packaging. Your item needs to have the receipt or proof of purchase.<br />\r\n<br />\r\n<strong>Refunds</strong><br />\r\nUpon receipt of the goods and provided they are returned unused in their original packing in perfect condition, we will refund the full amount of the cost of the goods only, less a 20% handling charge. All costs incurred in sending the goods to you will not be refunded. Once we receive your item, we will inspect it and notify you that we have received your returned item. We will immediately notify you on the status of your refund after inspecting the item.<br />\r\n<br />\r\nIf your return is approved, we will initiate a refund to your credit card (or original method of payment). You will receive the credit within a certain amount of days, depending on your card issuer&#39;s policies.<br />\r\n<br />\r\n<strong>Shipping</strong><br />\r\nYou will be responsible for paying for your own shipping costs for returning your item. Shipping costs are non-refundable. If you receive a refund, the cost of return shipping will be deducted from your refund.<br />\r\n<br />\r\n<strong>Contact Us</strong><br />\r\nIf you have any questions on how to return your item to us, contact us.<br />\r\n&nbsp;</p>'),
(30, 'meta_title', 'xxxxxxx'),
(31, 'meta_description', 'xxxxxxxxx'),
(32, 'keywords', 'xxxxxxxxxxxx'),
(33, 'collivery_email', 'api@collivery.co.za'),
(34, 'collivery_password', 'api123'),
(35, 'mygate_merchant_id', '722e564e-62d5-41fe-a1e5-cf1fb2c199a8'),
(36, 'mygate_application_id', 'c433d13d-9f88-4781-8177-6b777aaa7875'),
(37, 'email_link', ''),
(38, 'email_store_logo', 'vvcwlogo.jpg'),
(39, 'facebook_url', 'https://www.ds.com'),
(40, 'twitter_url', 'http://www.dd.com'),
(41, 'google_url', 'http://www.sd.com'),
(42, 'social', '[\"\"]'),
(43, 'fav_icon', 'green5.jpeg'),
(44, 'submitForm', 'formSave'),
(45, 'faq', '<p>Test faq</p>'),
(46, 'phone_number', '0110235164'),
(47, 'google_fonts', 'https://fonts.googleapis.com/css?family=Open+Sans'),
(48, 'body_text_colour', '#3c291b'),
(49, 'buy_now_button_colour', '#ffffff'),
(50, 'add_cart_button_colour', '#ffffff'),
(51, 'attributes_border_colour', '#c0c0c0'),
(52, 'attributes_active_colour', '#c0c0c0'),
(53, 'h1', '\'Open Sans\', sans-serif::::#3c291b::::20px::::bold'),
(54, 'h2', '\'Open Sans\', sans-serif::::#3c291b::::20px::::bold'),
(55, 'h3', '\'Open Sans\', sans-serif::::#3c291b::::20px::::bold'),
(56, 'h4', '\'Open Sans\', sans-serif::::#3c291b::::20px::::bold'),
(57, 'h5', '\'Open Sans\', sans-serif::::#3c291b::::20px::::bold'),
(58, 'h6', '\'Open Sans\', sans-serif::::#3c291b::::20px::::bold'),
(59, 'main_menu_colour', '#3c291b'),
(60, 'menu_hover_colour', '#ffffff'),
(61, 'menu_active_colour', '#ffffff'),
(62, 'menu_font_size', '12'),
(63, 'menu_background_colour', '#ffffff'),
(64, 'menu_underline', '0'),
(65, 'sub_menu_colour', '#3c291b'),
(66, 'sub_hover_colour', '#be171f'),
(67, 'sub_active_colour', '#be171f'),
(68, 'sub_font_size', '15'),
(69, 'sub_background_colour', '#ffffff'),
(70, 'sub_underline', '0'),
(71, 'our_menu_colour', '#3c291b'),
(72, 'our_hover_colour', '#ffffff'),
(73, 'our_active_colour', '#ffffff'),
(74, 'our_font_size', '14'),
(75, 'our_background_colour', '#f0eeee'),
(76, 'our_underline', '0'),
(77, 'oursub_menu_colour', '#be171f'),
(78, 'oursub_hover_colour', '#ffffff'),
(79, 'oursub_active_colour', '#ffffff'),
(80, 'oursub_font_size', '13'),
(81, 'oursub_background_colour', '#ffffff'),
(82, 'oursub_underline', '0'),
(83, 'menu_background_active_colour', '#be171f'),
(84, 'menu_background_hover_colour', '#be171f'),
(85, 'sub_background_active_colour', '#ffffff'),
(86, 'sub_background_hover_colour', '#ffffff'),
(87, 'our_background_active_colour', '#be171f'),
(88, 'our_background_hover_colour', '#be171f'),
(89, 'oursub_background_active_colour', '#be171f'),
(90, 'oursub_background_hover_colour', '#1db85f'),
(91, 'left_section_title', 'FEATURED CATEGORY 1'),
(92, 'left_section_link', 'https://posecom.co.za/install'),
(93, 'right_section_title', 'FEATURED CATEGORY 2'),
(94, 'right_section_link', 'https://posecom.co.za/install'),
(95, 'right_textsection_title', 'FEATURED CATEGORY 4'),
(96, 'right_textsection_link', 'https://posecom.co.za/install'),
(97, 'left_textsection_title', 'FEATURED CATEGORY 3'),
(98, 'left_textsection_link', 'https://posecom.co.za/install'),
(99, 'buy_now_button_hover_colour', '#ffffff'),
(100, 'buy_now_button_bgcolour', '#be171f'),
(101, 'buy_now_button_hover_bgcolour', '#e1111b'),
(102, 'left_section_title_colour', '#3c291b'),
(103, 'right_section_title_colour', '#ffffff'),
(104, 'product_title_colour', '#3c291b'),
(105, 'add_cart_button_hover_colour', '#ffffff'),
(106, 'add_cart_button_bgcolour', '#be171f'),
(107, 'add_cart_button_hover_bgcolour', '#e1111b'),
(108, 'privacy', '<h1>PRIVACY POLICY FOR XXXXXXX</h1>\r\n\r\n<p><br />\r\nThis website is the property of XXXXXXX. We take the privacy of all visitors to this Website very seriously and therefore set out in this privacy policy our position regarding certain privacy matters.<br />\r\nThis privacy policy covers all data that is shared with us by a visitor to this website whether via www.XXXXXXX.sslsec.co.za&nbsp;directly or indirectly via email or other communication channels.&nbsp;</p>\r\n\r\n<p>Our Privacy Policy provides an explanation as to what happens to any personal data that you share with us or that we collect from you either directly or indirectly.<br />\r\n<br />\r\n<strong>1. Information That We Collect</strong><br />\r\nIn operating our website we may collect and process the following data about you:<br />\r\n1.1&nbsp;&nbsp; &nbsp;Details of your visits to our website and the resources that you access, including but not limited to traffic data, location data, weblog statistics and other communication data.<br />\r\n1.2&nbsp;&nbsp; &nbsp;Information that you yourself provide to us by filling in forms on our website, such as when you register to receive information, a newsletter etc. or make a purchase on our website and complete the required order form.<br />\r\n1.3&nbsp;&nbsp; &nbsp;Only the necessary information, that is the delivery address and contact phone number will be made known to third parties delivering the product.<br />\r\n1.4&nbsp;&nbsp; &nbsp;Information provided to us when you communicate with us for any reason whether it be by email or on the website.<br />\r\n<br />\r\n<strong>2. Use of Cookies</strong><br />\r\nOn occasion, we may gather information about the computer that you are using for our services and to provide statistical information regarding the use of our website to our suppliers.<br />\r\nSuch information will not identify you personally as it is merely statistical data about our website visitors and their use of our site. This statistical data does not identify any personal details whatsoever. It is simply utilised by us to analyse how visitors to www.XXXXXXX.sslsec.co.za interact with the website so that we can continue to develop this website and make it an even better experience for our visitors.<br />\r\n<br />\r\nWe may gather information about your general internet use from time to time by using a cookie file that is downloaded to the computer that you are using. Where used, these cookies are downloaded to the computer that you are using automatically. This cookie file is stored on the hard drive of the computer that you are using as cookies contain information that is transferred to the computer&#39;s hard drive. They also help us to further improve our website and the service that we provide to you and do not provide any personal information.<br />\r\n<br />\r\nAll computers have the ability to decline cookies. This can be done by activating the setting on your browser which enables you to decline the cookies. Please note that should you choose to decline cookies, you may be unable to access particular parts of our website and we cannot be held responsible for any lack of functionality as a result of activating this option.<br />\r\n<br />\r\n<strong>3. Use of Your Information</strong><br />\r\nThe information that we collect and store relating to you is primarily used to enable us to provide our services to you. In addition, we may use the information for any or all of the following purposes:<br />\r\n3.1&nbsp;&nbsp; &nbsp;To provide you with information that you have requested from us, relating to our products and/or services and also to provide information on other similar or relevant products which we feel may be of interest to you, where you have consented to receive such information from us.<br />\r\n3.2&nbsp;&nbsp; &nbsp;To meet our contractual commitments and obligations to you.<br />\r\n3.3&nbsp;&nbsp; &nbsp;To notify you about any important and/or relevant changes to our website, such as improvements or service/product changes that may affect our service or your browsing experience.<br />\r\n3.4&nbsp;&nbsp; &nbsp;If you are an existing customer, we may contact you with information about goods and services similar to those which were the subject of a previous sale to you as such goods and services may be of a particular interest to you.<br />\r\n3.5&nbsp;&nbsp; &nbsp;Further, we may use your data to provide our suppliers with aggregate statistical information about our website visitors.<br />\r\n<br />\r\n<strong>4. Storing Your Personal Data</strong><br />\r\n4.1&nbsp;&nbsp; &nbsp;We may transfer data that we collect from you from time to time to locations outside of South Africa for processing and storage. Also, it may be processed by staff operating outside of South Africa who work for us. For example, such staff may be engaged or involved in the processing and finalising of your order, the processing of your payment details and the provision of support services. By submitting your personal data, you implicitly agree to the aforementioned potential transfer, storage and/or processing. We undertake to take all reasonable steps to ensure that your data is treated as private and is utilised securely and responsibly and in agreement with this Privacy Policy.<br />\r\n4.2&nbsp;&nbsp; &nbsp;Data that is provided to us is stored on our secure servers. Private details relating to any transactions entered into on our site will be encrypted to ensure its safety.<br />\r\n4.3&nbsp;&nbsp; &nbsp;The transmission of information via the internet is not completely secure and therefore we cannot unfortunately guarantee the security of data sent to us electronically and transmission of such data is therefore entirely at your own risk. Where we have given you (or where you have chosen) a password so that you can access certain parts of our site, you are responsible for keeping this password confidential. We cannot be held liable for any loss or damages suffered as a result of your providing us with personal and/or financial information where every effort has been made by us to protect such information to the best of our ability.<br />\r\n<br />\r\n<strong>5. Disclosing Your Information</strong><br />\r\n5.1&nbsp;&nbsp; &nbsp;We may disclose your personal information to third parties:<br />\r\n5.1.1&nbsp;&nbsp; &nbsp;Where we sell any or all of our business and/or our assets to a third party.<br />\r\n5.1.2&nbsp;&nbsp; &nbsp;Where we are legally required to disclose your information.<br />\r\n5.1.3&nbsp;&nbsp; &nbsp;To assist fraud protection and minimise credit risk.<br />\r\n5.1.4&nbsp;&nbsp; &nbsp;In any other circumstance where we are obligated by law to do so.<br />\r\n<br />\r\n<strong>6. Third Party Links</strong><br />\r\nYou may find links to third party websites on our website. These websites should have their own privacy policies which you should check. We do not accept any responsibility or liability for their policies or lack thereof whatsoever as we have no control over them.<br />\r\n<br />\r\n<strong>7. Contacting Us</strong><br />\r\nWe welcome any queries, comments or requests you may have regarding this Privacy Policy. Please do not hesitate to contact us at admin@XXXXXXX.co.za.</p>'),
(109, 'delivery', '<h1>DELIVERY POLICY</h1>\r\n\r\n<p><br />\r\nThank you for visiting and shopping at XXXXXXX. Following are the terms and conditions that constitute our Delivery Policy.<br />\r\n<br />\r\n<strong>Delivery processing time</strong><br />\r\nAll orders are processed within 2-3 business days. Orders are not delivered on weekends or holidays. If we are experiencing a high volume of orders, shipments may be delayed by a few days. Please allow additional days in transit for delivery. If there will be a significant delay in delivery of your order, we will contact you via email or telephone.<br />\r\n<br />\r\n<strong>Delivery rates</strong><br />\r\nDelivery charges for your order will be calculated and displayed at checkout. Unless it is stipulated that delivery is free or a flat fee, the delivery rate will be based on the weight and dimensions of the product. Delivery delays can occasionally occur.<br />\r\n<br />\r\n<strong>Your delivery address</strong><br />\r\nPlease ensure to provide a valid delivery address. In the case that the courier delivers to an incorrect address any surcharges will be billed to your account.<br />\r\n<br />\r\n<strong>Delivery confirmation &amp; Order tracking</strong><br />\r\nYou will receive a Delivery Confirmation email once your order has been dispatched containing your tracking number(s).<br />\r\n<br />\r\n<strong>Delivery outside of South Africa</strong><br />\r\nWe do not currently deliver outside South Africa.<br />\r\n<br />\r\n<strong>Damages</strong><br />\r\nXXXXXXX is not liable for any products damaged or lost during delivery. If you received your order damaged, please contact the courier to file a claim. Please save all packaging materials and damaged goods before filing a claim.<br />\r\n<br />\r\n<strong>Returns Policy</strong><br />\r\nOur Returns Policy [LINK HERE] provides detailed information about options and procedures for returning your order.<br />\r\n&nbsp;</p>\r\n'),
(110, 'eft_bank_details', '<p>Banking details here.<br>\r\nBanking details here.<br>\r\nBanking details here.<br>\r\nBanking details here.</p>\r\n'),
(111, 'whoweare', '<p>Who we are.</p>'),
(112, 'products_without_image', 'Yes'),
(113, 'micomp_posoption', 'micomp'),
(114, 'micomp_host_address', 'vcycleworks.ddns.net'),
(115, 'micomp_database', 'web'),
(116, 'micomp_username', 'posecom'),
(117, 'micomp_password', 'chelsea123'),
(118, 'micomp_menu_level1', 'dept'),
(119, 'micomp_menu_level2', 'type'),
(120, 'micomp_menu_level3', 'category'),
(121, 'posecom_posoption', 'micomp'),
(122, 'flat_rate_delivery', '150'),
(123, 'courier_service', 'self_courier'),
(124, 'free_delivery', 'flat'),
(125, 'service', '1'),
(126, 'delivery_collivery_full_name', 'Mijoe Mathew'),
(127, 'delivery_collivery_company_name', 'Nuro Works'),
(128, 'delivery_collivery_street', '12343'),
(129, 'delivery_collivery_town', '147'),
(130, 'delivery_collivery_suburb', '837'),
(131, 'delivery_collivery_type', '3'),
(132, 'delivery_collivery_zip_code', '1686'),
(133, 'delivery_collivery_email', 'mijoepm@gmail.com'),
(134, 'delivery_collivery_phone', '+918809178703'),
(135, 'delivery_collivery_cellphone', '+918809178703'),
(136, 'delivery_collivery_address_id', '1735645'),
(137, 'delivery_collivery_contact_id', '1803542'),
(138, 'delivery_collivery_id', 'api@collivery.co.za'),
(139, 'delivery_collivery_password', 'api123'),
(140, 'delivery_courierguy_id', 'svilen@valsa.co.za'),
(141, 'delivery_courierguy_password', 'VAL1JE'),
(142, 'delivery_courierguy_full_name', 'A Viles'),
(143, 'delivery_courierguy_company_name', 'NURO'),
(144, 'delivery_courierguy_address1', '581, 7th Road'),
(145, 'delivery_courierguy_address2', 'Johannesburg'),
(146, 'delivery_courierguy_address3', 'Halfway Gardens'),
(147, 'delivery_courierguy_zip_code', '1686'),
(148, 'delivery_courierguy_email', 'svilen@valsa.co.za'),
(149, 'delivery_courierguy_phone', '+918809178703'),
(150, 'delivery_courierguy_cellphone', '+918809178703'),
(151, 'delivery_courierguy_place', '1268'),
(152, 'delivery_courierguy_town', 'VORNA VALLEY, Halfway House'),
(153, 'live_transaction', 'on'),
(154, 'mygate_live_transaction', '0'),
(155, 'free_delivery_above', '0'),
(156, 'password', 'aki!j7AH_dsjjhA98_!nm6QErma51!jsaj'),
(157, 'grid_view_style', 'grid'),
(158, 'free_rate_above', ''),
(159, 'display_faq', '1'),
(160, 'abandoned_email', '<p>This is a test message!!</p>'),
(161, 'abandon_email_send_type', 'auto'),
(162, 'hide_registration', '0'),
(163, 'customer_registration', '0'),
(164, 'blogs_active', '0'),
(165, 'shopkeeper_json_creation_url', 'http://hd_kiosk.myjsk.net/jskdplay/startviewer3.php?CODESTRING=ZZZ-999~'),
(166, 'shopkeeper_json_url', 'https://online.shoso.com/jskdplay/inventory.json'),
(167, 'shopkeeper_username', 'jskuser'),
(168, 'shopkeeper_password', 'hdtokai'),
(169, 'schedule', '2'),
(170, 'schedule_day', '[\"\",\"\",\"2\",\"2\"]'),
(171, 'schedule_hour', '[\"0\",\"0\",\"0\",\"0\"]'),
(172, 'schedule_min', '[\"0\",\"0\",\"0\",\"0\"]'),
(173, 'last_sync_time', '2019-06-19 13:20:57'),
(174, 'schedule_hour2', '[\"0\",\"0\",\"0\",\"0\"]'),
(175, 'schedule_min2', '[\"0\",\"0\",\"0\",\"0\"]'),
(176, 'vat_percentage', '15'),
(177, 'mobile_logo', 'Blog-Design-for-Abad-Copper-Castle10.jpg'),
(178, 'posibolt_url', 'http://osbro.posibolt.com/AdempiereService'),
(179, 'posibolt_auth_username', '511234'),
(180, 'posibolt_auth_password', '313556'),
(181, 'posibolt_password', 'ONLINE'),
(182, 'posibolt_terminal', 'WEBSTORE'),
(183, 'posibolt_username', 'ONLINE'),
(187, 'name', 'popup_btn_color'),
(188, 'value', '#376f62'),
(190, 'popup_title', 'Subscribe!'),
(191, 'pk', '1'),
(192, 'popup_title_color', '#808080'),
(193, 'popup_footertext_color', '#808080'),
(194, 'popup_describe', 'Subscribe to our newsletter and get the best discounts sent directly to your inbox!'),
(195, 'popup_footertext', 'Win Prizes Weekly Exclusively for YOUR COMPANY Subscribers!'),
(196, 'popup_describe_color', '#808080'),
(197, 'email', ''),
(198, 'image_file', 'rawpixel-777267-unsplash8.jpg'),
(199, 'popup_btn_color', '#376f62'),
(200, 'show_popup_customers', '0'),
(201, 'deactivate_buybutton', '1'),
(202, 'add_cart_from_list', '1'),
(203, 'footer_additions', ''),
(204, '_template', 'designer'),
(205, 'show_product_code', '1'),
(206, 'show_product_comment', '1'),
(207, 'product_comment_area_title', 'Notes'),
(208, 'show_vat', '1'),
(209, 'whatsapp_no', '0734061803'),
(210, 'disable_inventory_tracking', '1'),
(211, 'card_payment_success_message', 'This is the delivery message.');

-- --------------------------------------------------------

--
-- Table structure for table `stock_price_attributes`
--

DROP TABLE IF EXISTS `stock_price_attributes`;
CREATE TABLE IF NOT EXISTS `stock_price_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `product_id` int(11) NOT NULL COMMENT 'product id, foreign key from products table',
  `group_id` int(11) NOT NULL,
  `sku` varchar(250) DEFAULT NULL,
  `attribute_id1` int(11) DEFAULT NULL COMMENT 'attribute id, foreign key from attributes table',
  `attribute_id2` int(11) DEFAULT NULL COMMENT 'attribute id, foreign key from attributes table',
  `attribute_id3` int(11) DEFAULT NULL COMMENT 'attribute id, foreign key from attributes table',
  `attribute_id4` int(11) DEFAULT NULL COMMENT 'attribute id, foreign key from attributes table',
  `attribute_id5` int(11) DEFAULT NULL COMMENT 'attribute id, foreign key from attributes table',
  `quantity` int(11) NOT NULL COMMENT 'stock quantity',
  `min_quantity` int(11) NOT NULL,
  `price_variation` float NOT NULL DEFAULT '0' COMMENT 'Price variation for this combination',
  PRIMARY KEY (`id`),
  KEY `FK_product_stock_price` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16516 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock_price_attributes`
--

INSERT INTO `stock_price_attributes` (`id`, `product_id`, `group_id`, `sku`, `attribute_id1`, `attribute_id2`, `attribute_id3`, `attribute_id4`, `attribute_id5`, `quantity`, `min_quantity`, `price_variation`) VALUES
(16512, 17752, 2593, 'MT66466', 16376, NULL, NULL, NULL, NULL, 10, 1, 0),
(16513, 17752, 2593, 'MT664533', 16377, NULL, NULL, NULL, NULL, 234, 1, 0),
(16515, 17752, 2594, 'eeesad£4', 16376, 16380, NULL, NULL, NULL, 40, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier',
  `number` varchar(50) NOT NULL COMMENT 'table number',
  `seats` int(11) NOT NULL COMMENT 'total seats available on',
  `qr_code` varchar(250) NOT NULL COMMENT 'qr code to access table',
  PRIMARY KEY (`id`),
  KEY `number` (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `uc_email` (`email`),
  UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  UNIQUE KEY `uc_remember_selector` (`remember_selector`),
  UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, 0x3a3a31, 'adam viles', '$2y$12$eduYtmunwjJ2HK6QTuLx3O9t.ZsQVngiBiXHt/2zp3usj6PmOJsc2', NULL, 'adam@nuro.co.za', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1565630336, 1565665738, 1, 'Adam', 'Viles', 'Nuro', '9809178703');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_group_groups` (`group_id`),
  KEY `fk_user_groups` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=322 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_group_offers`
--

DROP TABLE IF EXISTS `user_group_offers`;
CREATE TABLE IF NOT EXISTS `user_group_offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `offer` float NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_group_offers`
--

INSERT INTO `user_group_offers` (`id`, `group_id`, `offer`, `type`) VALUES
(2, 4, 5, 'percentage'),
(4, 6, 12, 'percentage');

-- --------------------------------------------------------

--
-- Table structure for table `whishlist`
--

DROP TABLE IF EXISTS `whishlist`;
CREATE TABLE IF NOT EXISTS `whishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_users_whish` (`user_id`),
  KEY `FK_products_whish` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_user_addresses` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attribute_options`
--
ALTER TABLE `attribute_options`
  ADD CONSTRAINT `fk_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attribute_option_groups`
--
ALTER TABLE `attribute_option_groups`
  ADD CONSTRAINT `fk_attributes` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_groups` FOREIGN KEY (`group_id`) REFERENCES `attribute_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_product_comments` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user_comments` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_product_images` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_collivery_log`
--
ALTER TABLE `order_collivery_log`
  ADD CONSTRAINT `fk_order_collivery` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_details` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `fk_products_attributes` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `FK_product_categories` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_manufacurer`
--
ALTER TABLE `product_manufacurer`
  ADD CONSTRAINT `fk_manu_manufactures` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_manufactures` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_products_rating` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_rating` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_price_attributes`
--
ALTER TABLE `stock_price_attributes`
  ADD CONSTRAINT `FK_product_stock_price` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `whishlist`
--
ALTER TABLE `whishlist`
  ADD CONSTRAINT `FK_products_whish` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_whish` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
