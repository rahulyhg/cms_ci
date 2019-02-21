-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 21, 2019 at 10:03 AM
-- Server version: 10.3.9-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_setting`
--

DROP TABLE IF EXISTS `cms_setting`;
CREATE TABLE IF NOT EXISTS `cms_setting` (
  `setting_name` varchar(255) NOT NULL,
  `setting_parameter` varchar(255) NOT NULL,
  `setting_last_time` datetime NOT NULL,
  `setting_by` int(11) NOT NULL,
  `valueadded_field` varchar(255) NOT NULL,
  `valueadded_fieldtext` text NOT NULL,
  `valueadded_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`setting_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cms_setting`
--

INSERT INTO `cms_setting` (`setting_name`, `setting_parameter`, `setting_last_time`, `setting_by`, `valueadded_field`, `valueadded_fieldtext`, `valueadded_image`) VALUES
('log', 'text_file', '2012-03-19 15:27:34', 3, '', '', ''),
('meta home', 'Telkomsel', '0000-00-00 00:00:00', 2, 'telkomsel,telekomunikasi,seluler,kartu as ,simpati,kartu halo', 'Telkomsel is the leading operator of cellular telecommunications services in Indonesia by market share and revenue share', ''),
('information', 'information', '2012-03-19 15:18:58', 3, 'Content Management System', '', 'Setting-icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_access`
--

DROP TABLE IF EXISTS `tbl_access`;
CREATE TABLE IF NOT EXISTS `tbl_access` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_level_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `access_active_status` tinyint(1) NOT NULL,
  `access_create_date` datetime NOT NULL,
  `access_create_by` int(11) NOT NULL,
  PRIMARY KEY (`access_id`),
  KEY `user_level_id` (`user_level_id`,`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_access`
--

INSERT INTO `tbl_access` (`access_id`, `user_level_id`, `module_id`, `access_active_status`, `access_create_date`, `access_create_by`) VALUES
(1, 1, 7, 1, '2019-02-20 15:37:55', 1),
(2, 1, 8, 1, '2019-02-20 16:30:13', 1),
(3, 1, 9, 1, '2019-02-20 17:14:25', 1),
(4, 1, 10, 1, '2019-02-21 13:15:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_access_privilege`
--

DROP TABLE IF EXISTS `tbl_access_privilege`;
CREATE TABLE IF NOT EXISTS `tbl_access_privilege` (
  `access_privilege_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL,
  `access_privilege_status` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`access_privilege_id`),
  KEY `access_id` (`access_id`,`privilege_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_access_privilege`
--

INSERT INTO `tbl_access_privilege` (`access_privilege_id`, `access_id`, `privilege_id`, `access_privilege_status`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 0),
(3, 1, 3, 0),
(4, 1, 4, 1),
(5, 1, 5, 0),
(6, 1, 6, 0),
(7, 1, 7, 0),
(8, 1, 8, 0),
(9, 2, 1, 1),
(10, 2, 2, 0),
(11, 2, 3, 1),
(12, 2, 4, 1),
(13, 2, 5, 1),
(14, 2, 6, 0),
(15, 2, 7, 1),
(16, 2, 8, 0),
(17, 3, 1, 1),
(18, 3, 2, 0),
(19, 3, 3, 1),
(20, 3, 4, 1),
(21, 3, 5, 1),
(22, 3, 6, 0),
(23, 3, 7, 1),
(24, 3, 8, 0),
(25, 4, 1, 1),
(26, 4, 2, 0),
(27, 4, 3, 1),
(28, 4, 4, 1),
(29, 4, 5, 1),
(30, 4, 6, 0),
(31, 4, 7, 1),
(32, 4, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alias`
--

DROP TABLE IF EXISTS `tbl_alias`;
CREATE TABLE IF NOT EXISTS `tbl_alias` (
  `alias_id` int(11) NOT NULL AUTO_INCREMENT,
  `alias_category` varchar(25) NOT NULL,
  `key_id` int(11) NOT NULL,
  `web_alias` varchar(255) NOT NULL,
  `web_ori` varchar(255) NOT NULL,
  `alias_active_status` tinyint(1) NOT NULL,
  `alias_create_date` datetime NOT NULL,
  `alias_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`alias_id`),
  KEY `alias_category` (`alias_category`),
  KEY `alias_active_status` (`alias_active_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

DROP TABLE IF EXISTS `tbl_banner`;
CREATE TABLE IF NOT EXISTS `tbl_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_name` varchar(100) DEFAULT NULL,
  `banner_images` varchar(100) NOT NULL,
  `banner_type` tinyint(2) NOT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `banner_active_status` tinyint(1) NOT NULL DEFAULT 0,
  `banner_create_date` datetime NOT NULL,
  `banner_create_by` int(11) NOT NULL,
  `banner_update_date` datetime DEFAULT NULL,
  `banner_update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`banner_id`, `banner_name`, `banner_images`, `banner_type`, `banner_url`, `banner_active_status`, `banner_create_date`, `banner_create_by`, `banner_update_date`, `banner_update_by`) VALUES
(1, 'Banner 1', '/assets/file_upload/admin/images/banner/slide-1.jpg', 1, '', 1, '2015-09-18 11:36:23', 1, NULL, NULL),
(2, 'Test', '/assets/file_upload/admin/images/banner/nba-superstar-last-supper-illustration-full.jpg', 1, 'http://picmix.it', 1, '2019-02-20 17:01:15', 1, '2019-02-20 17:02:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

DROP TABLE IF EXISTS `tbl_city`;
CREATE TABLE IF NOT EXISTS `tbl_city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `province_id` int(11) NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `kota_id` (`city_id`,`province_id`)
) ENGINE=MyISAM AUTO_INCREMENT=502 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`city_id`, `city_name`, `postal_code`, `province_id`) VALUES
(1, 'Aceh Barat', '23600', 21),
(2, 'Aceh Barat Daya', '23700', 21),
(3, 'Aceh Besar', '23000', 21),
(4, 'Aceh Jaya', '23600', 21),
(5, 'Aceh Selatan', '23700', 21),
(6, 'Aceh Singkil', '24700', 21),
(7, 'Aceh Tamiang', '24400', 21),
(8, 'Aceh Tengah', '24500', 21),
(9, 'Aceh Tenggara', '24600', 21),
(10, 'Aceh Timur', '24400', 21),
(11, 'Aceh Utara', '24300', 21),
(12, 'Agam', '26000', 32),
(13, 'Alor', '85800', 23),
(14, 'Ambon', '97000', 19),
(15, 'Asahan', '21000', 34),
(16, 'Asmat', '99700', 24),
(17, 'Badung', '80361', 1),
(18, 'Balangan', '71400', 13),
(19, 'Balikpapan', '76100', 15),
(20, 'Banda Aceh', '23000', 21),
(21, 'Bandar Lampung', '35000', 18),
(22, 'Bandung', '40000', 9),
(23, 'Bandung', '40000', 9),
(24, 'Bandung Barat', '40000', 9),
(25, 'Banggai', '94791', 29),
(26, 'Banggai Kepulauan', '94791', 29),
(27, 'Bangka', '33200', 2),
(28, 'Bangka Barat', '33300', 2),
(29, 'Bangka Selatan', '33700', 2),
(30, 'Bangka Tengah', '33600', 2),
(31, 'Bangkalan', '69100', 11),
(32, 'Bangli', '80600', 1),
(33, 'Banjar', '70600', 13),
(34, 'Banjar', '46300', 9),
(35, 'Banjarbaru', '70700', 13),
(36, 'Banjarmasin', '70000', 13),
(37, 'Banjarnegara', '53400', 10),
(38, 'Bantaeng', '92400', 28),
(39, 'Bantul', '55700', 5),
(40, 'Banyuasin', '30758', 33),
(41, 'Banyumas', '53100', 10),
(42, 'Banyuwangi', '68400', 11),
(43, 'Barito Kuala', '70500', 13),
(44, 'Barito Selatan', '73700', 14),
(45, 'Barito Timur', '73600', 14),
(46, 'Barito Utara', '73800', 14),
(47, 'Barru', '90700', 28),
(48, 'Batam', '29400', 17),
(49, 'Batang', '51200', 10),
(50, 'Batang Hari', '36600', 8),
(51, 'Batu', '65311', 11),
(52, 'Batu Bara', '21200', 34),
(53, 'Bau-Bau', '93700', 30),
(54, 'Bekasi', '17000', 9),
(55, 'Bekasi', '17000', 9),
(56, 'Belitung', '33400', 2),
(57, 'Belitung Timur', '33400', 2),
(58, 'Belu', '85700', 23),
(59, 'Bener Meriah', '24500', 21),
(60, 'Bengkalis', '28700', 26),
(61, 'Bengkayang', '79200', 12),
(62, 'Bengkulu', '38000', 4),
(63, 'Bengkulu Selatan', '38500', 4),
(64, 'Bengkulu Tengah', '38000', 4),
(65, 'Bengkulu Utara', '38600', 4),
(66, 'Berau', '77300', 15),
(67, 'Biak Numfor', '98100', 24),
(68, 'Bima', '84100', 22),
(69, 'Bima', '84100', 22),
(70, 'Binjai', '20700', 34),
(71, 'Bintan', '29100', 17),
(72, 'Bireuen', '24200', 21),
(73, 'Bitung', '95500', 31),
(74, 'Blitar', '66100', 11),
(75, 'Blitar', '66100', 11),
(76, 'Blora', '58200', 10),
(77, 'Boalemo', '96200', 7),
(78, 'Bogor', '16000', 9),
(79, 'Bogor', '16000', 9),
(80, 'Bojonegoro', '62100', 11),
(81, 'Bolaang Mongondow (Bolmong)', '95700', 31),
(82, 'Bolaang Mongondow Selatan', '95700', 31),
(83, 'Bolaang Mongondow Timur', '95700', 31),
(84, 'Bolaang Mongondow Utara', '95700', 31),
(85, 'Bombana', '93700', 30),
(86, 'Bondowoso', '68200', 11),
(87, 'Bone', '92552', 28),
(88, 'Bone Bolango', '96184', 7),
(89, 'Bontang', '75300', 15),
(90, 'Boven Digoel', '99600', 24),
(91, 'Boyolali', '57300', 10),
(92, 'Brebes', '52200', 10),
(93, 'Bukittinggi', '26100', 32),
(94, 'Buleleng', '81100', 1),
(95, 'Bulukumba', '92500', 28),
(96, 'Bulungan (Bulongan)', '77200', 16),
(97, 'Bungo', '37200', 8),
(98, 'Buol', '94500', 29),
(99, 'Buru', '97500', 19),
(100, 'Buru Selatan', '97500', 19),
(101, 'Buton', '93700', 30),
(102, 'Buton Utara', '93600', 30),
(103, 'Ciamis', '46200', 9),
(104, 'Cianjur', '43200', 9),
(105, 'Cilacap', '53200', 10),
(106, 'Cilegon', '42400', 3),
(107, 'Cimahi', '40500', 9),
(108, 'Cirebon', '45100', 9),
(109, 'Cirebon', '45100', 9),
(110, 'Dairi', '22200', 34),
(111, 'Deiyai (Deliyai)', '98700', 24),
(112, 'Deli Serdang', '20500', 34),
(113, 'Demak', '59500', 10),
(114, 'Denpasar', '80000', 1),
(115, 'Depok', '16400', 9),
(116, 'Dharmasraya', '27600', 32),
(117, 'Dogiyai', '98800', 24),
(118, 'Dompu', '84200', 22),
(119, 'Donggala', '94351', 29),
(120, 'Dumai', '28800', 26),
(121, 'Empat Lawang', '31500', 33),
(122, 'Ende', '86300', 23),
(123, 'Enrekang', '91700', 28),
(124, 'Fakfak', '98600', 25),
(125, 'Flores Timur', '86200', 23),
(126, 'Garut', '44100', 9),
(127, 'Gayo Lues', '24600', 21),
(128, 'Gianyar', '80500', 1),
(129, 'Gorontalo', '96100', 7),
(130, 'Gorontalo', '96100', 7),
(131, 'Gorontalo Utara', '96100', 7),
(132, 'Gowa', '92100', 28),
(133, 'Gresik', '61100', 11),
(134, 'Grobogan', '58152', 10),
(135, 'Gunung Kidul', '55800', 5),
(136, 'Gunung Mas', '74500', 14),
(137, 'Gunungsitoli', '22800', 34),
(138, 'Halmahera Barat', '97700', 20),
(139, 'Halmahera Selatan', '97700', 20),
(140, 'Halmahera Tengah', '97800', 20),
(141, 'Halmahera Timur', '97800', 20),
(142, 'Halmahera Utara', '97700', 20),
(143, 'Hulu Sungai Selatan', '71200', 13),
(144, 'Hulu Sungai Tengah', '71300', 13),
(145, 'Hulu Sungai Utara', '71400', 13),
(146, 'Humbang Hasundutan', '22400', 34),
(147, 'Indragiri Hilir', '29200', 26),
(148, 'Indragiri Hulu', '29300', 26),
(149, 'Indramayu', '45200', 9),
(150, 'Intan Jaya', '98700', 24),
(151, 'Jakarta Barat', '11000', 6),
(152, 'Jakarta Pusat', '10000', 6),
(153, 'Jakarta Selatan', '12000', 6),
(154, 'Jakarta Timur', '13000', 6),
(155, 'Jakarta Utara', '14000', 6),
(156, 'Jambi', '36000', 8),
(157, 'Jayapura', '99000', 24),
(158, 'Jayapura', '99000', 24),
(159, 'Jayawijaya', '99500', 24),
(160, 'Jember', '68100', 11),
(161, 'Jembrana', '82200', 1),
(162, 'Jeneponto', '92300', 28),
(163, 'Jepara', '59400', 10),
(164, 'Jombang', '61400', 11),
(165, 'Kaimana', '98654', 25),
(166, 'Kampar', '28400', 26),
(167, 'Kapuas', '73500', 14),
(168, 'Kapuas Hulu', '78700', 12),
(169, 'Karanganyar', '57700', 10),
(170, 'Karangasem', '80800', 1),
(171, 'Karawang', '41300', 9),
(172, 'Karimun', '29600', 17),
(173, 'Karo', '22100', 34),
(174, 'Katingan', '74400', 14),
(175, 'Kaur', '38000', 4),
(176, 'Kayong Utara', '78800', 12),
(177, 'Kebumen', '54300', 10),
(178, 'Kediri', '64100', 11),
(179, 'Kediri', '64100', 11),
(180, 'Keerom', '99000', 24),
(181, 'Kendal', '51300', 10),
(182, 'Kendari', '93000', 30),
(183, 'Kepahiang', '39172', 4),
(184, 'Kepulauan Anambas', '29700', 17),
(185, 'Kepulauan Aru', '97600', 19),
(186, 'Kepulauan Mentawai', '25391', 32),
(187, 'Kepulauan Meranti', '28700', 26),
(188, 'Kepulauan Sangihe', '95800', 31),
(189, 'Kepulauan Seribu', '14530', 6),
(190, 'Kepulauan Siau Tagulandang Biaro (Sitaro)', '95800', 31),
(191, 'Kepulauan Sula', '97700', 20),
(192, 'Kepulauan Talaud', '95800', 31),
(193, 'Kepulauan Yapen (Yapen Waropen)', '98200', 24),
(194, 'Kerinci', '37100', 8),
(195, 'Ketapang', '78800', 12),
(196, 'Klaten', '57400', 10),
(197, 'Klungkung', '80700', 1),
(198, 'Kolaka', '93500', 30),
(199, 'Kolaka Utara', '93500', 30),
(200, 'Konawe', '93400', 30),
(201, 'Konawe Selatan', '93000', 30),
(202, 'Konawe Utara', '93000', 30),
(203, 'Kotabaru', '72100', 13),
(204, 'Kotamobagu', '95700', 31),
(205, 'Kotawaringin Barat', '74100', 14),
(206, 'Kotawaringin Timur', '74300', 14),
(207, 'Kuantan Singingi', '29500', 26),
(208, 'Kubu Raya', '78000', 12),
(209, 'Kudus', '59300', 10),
(210, 'Kulon Progo', '55600', 5),
(211, 'Kuningan', '45500', 9),
(212, 'Kupang', '85000', 23),
(213, 'Kupang', '85000', 23),
(214, 'Kutai Barat', '75000', 15),
(215, 'Kutai Kartanegara', '75500', 15),
(216, 'Kutai Timur', '75556', 15),
(217, 'Labuhan Batu', '21400', 34),
(218, 'Labuhan Batu Selatan', '21400', 34),
(219, 'Labuhan Batu Utara', '21400', 34),
(220, 'Lahat', '31400', 33),
(221, 'Lamandau', '74100', 14),
(222, 'Lamongan', '62200', 11),
(223, 'Lampung Barat', '35000', 18),
(224, 'Lampung Selatan', '35000', 18),
(225, 'Lampung Tengah', '34100', 18),
(226, 'Lampung Timur', '34100', 18),
(227, 'Lampung Utara', '34500', 18),
(228, 'Landak', '79357', 12),
(229, 'Langkat', '20800', 34),
(230, 'Langsa', '24400', 21),
(231, 'Lanny Jaya', '99500', 24),
(232, 'Lebak', '42300', 3),
(233, 'Lebong', '39200', 4),
(234, 'Lembata', '86600', 23),
(235, 'Lhokseumawe', '24300', 21),
(236, 'Lima Puluh Koto/Kota', '26200', 32),
(237, 'Lingga', '29800', 17),
(238, 'Lombok Barat', '83363', 22),
(239, 'Lombok Tengah', '83500', 22),
(240, 'Lombok Timur', '83600', 22),
(241, 'Lombok Utara', '83300', 22),
(242, 'Lubuk Linggau', '31600', 33),
(243, 'Lumajang', '67300', 11),
(244, 'Luwu', '91900', 28),
(245, 'Luwu Timur', '91900', 28),
(246, 'Luwu Utara', '91900', 28),
(247, 'Madiun', '63100', 11),
(248, 'Madiun', '63100', 11),
(249, 'Magelang', '56100', 10),
(250, 'Magelang', '56100', 10),
(251, 'Magetan', '63300', 11),
(252, 'Majalengka', '45400', 9),
(253, 'Majene', '91400', 27),
(254, 'Makassar', '90000', 28),
(255, 'Malang', '65100', 11),
(256, 'Malang', '65100', 11),
(257, 'Malinau', '77154', 16),
(258, 'Maluku Barat Daya', '97000', 19),
(259, 'Maluku Tengah', '97500', 19),
(260, 'Maluku Tenggara', '97600', 19),
(261, 'Maluku Tenggara Barat', '97600', 19),
(262, 'Mamasa', '91363', 27),
(263, 'Mamberamo Raya', '99500', 24),
(264, 'Mamberamo Tengah', '99500', 24),
(265, 'Mamuju', '91500', 27),
(266, 'Mamuju Utara', '91500', 27),
(267, 'Manado', '95000', 31),
(268, 'Mandailing Natal', '22919', 34),
(269, 'Manggarai', '86500', 23),
(270, 'Manggarai Barat', '86753', 23),
(271, 'Manggarai Timur', '86500', 23),
(272, 'Manokwari', '98300', 25),
(273, 'Manokwari Selatan', '98300', 25),
(274, 'Mappi', '99000', 24),
(275, 'Maros', '90500', 28),
(276, 'Mataram', '83000', 22),
(277, 'Maybrat', '99000', 25),
(278, 'Medan', '20000', 34),
(279, 'Melawi', '78672', 12),
(280, 'Merangin', '37300', 8),
(281, 'Merauke', '99600', 24),
(282, 'Mesuji', '34500', 18),
(283, 'Metro', '34100', 18),
(284, 'Mimika', '99900', 24),
(285, 'Minahasa', '95600', 31),
(286, 'Minahasa Selatan', '95000', 31),
(287, 'Minahasa Tenggara', '95000', 31),
(288, 'Minahasa Utara', '95000', 31),
(289, 'Mojokerto', '61300', 11),
(290, 'Mojokerto', '61300', 11),
(291, 'Morowali', '94000', 29),
(292, 'Muara Enim', '31300', 33),
(293, 'Muaro Jambi', '36365', 8),
(294, 'Muko Muko', '38365', 4),
(295, 'Muna', '93600', 30),
(296, 'Murung Raya', '73900', 14),
(297, 'Musi Banyuasin', '30700', 33),
(298, 'Musi Rawas', '31600', 33),
(299, 'Nabire', '98800', 24),
(300, 'Nagan Raya', '23600', 21),
(301, 'Nagekeo', '86400', 23),
(302, 'Natuna', '29700', 17),
(303, 'Nduga', '99500', 24),
(304, 'Ngada', '86400', 23),
(305, 'Nganjuk', '64400', 11),
(306, 'Ngawi', '63200', 11),
(307, 'Nias', '22800', 34),
(308, 'Nias Barat', '22800', 34),
(309, 'Nias Selatan', '22800', 34),
(310, 'Nias Utara', '22800', 34),
(311, 'Nunukan', '77182', 16),
(312, 'Ogan Ilir', '30600', 33),
(313, 'Ogan Komering Ilir', '30600', 33),
(314, 'Ogan Komering Ulu', '32100', 33),
(315, 'Ogan Komering Ulu Selatan', '32100', 33),
(316, 'Ogan Komering Ulu Timur', '32100', 33),
(317, 'Pacitan', '63500', 11),
(318, 'Padang', '25000', 32),
(319, 'Padang Lawas', '22700', 34),
(320, 'Padang Lawas Utara', '22700', 34),
(321, 'Padang Panjang', '27100', 32),
(322, 'Padang Pariaman', '25500', 32),
(323, 'Padang Sidempuan', '22700', 34),
(324, 'Pagar Alam', '31500', 33),
(325, 'Pakpak Bharat', '22200', 34),
(326, 'Palangka Raya', '73000', 14),
(327, 'Palembang', '30000', 33),
(328, 'Palopo', '91900', 28),
(329, 'Palu', '94000', 29),
(330, 'Pamekasan', '69300', 11),
(331, 'Pandeglang', '42200', 3),
(332, 'Pangandaran', '46396', 9),
(333, 'Pangkajene Kepulauan', '90600', 28),
(334, 'Pangkal Pinang', '33100', 2),
(335, 'Paniai', '98700', 24),
(336, 'Parepare', '91100', 28),
(337, 'Pariaman', '25500', 32),
(338, 'Parigi Moutong', '94371', 29),
(339, 'Pasaman', '26300', 32),
(340, 'Pasaman Barat', '26300', 32),
(341, 'Paser', '76200', 15),
(342, 'Pasuruan', '67100', 11),
(343, 'Pasuruan', '67100', 11),
(344, 'Pati', '59100', 10),
(345, 'Payakumbuh', '26200', 32),
(346, 'Pegunungan Arfak', '98300', 25),
(347, 'Pegunungan Bintang', '99500', 24),
(348, 'Pekalongan', '51100', 10),
(349, 'Pekalongan', '51100', 10),
(350, 'Pekanbaru', '28000', 26),
(351, 'Pelalawan', '28300', 26),
(352, 'Pemalang', '52300', 10),
(353, 'Pematang Siantar', '21100', 34),
(354, 'Penajam Paser Utara', '76141', 15),
(355, 'Pesawaran', '35000', 18),
(356, 'Pesisir Barat', '34574', 18),
(357, 'Pesisir Selatan', '25600', 32),
(358, 'Pidie', '24100', 21),
(359, 'Pidie Jaya', '24100', 21),
(360, 'Pinrang', '91200', 28),
(361, 'Pohuwato', '96200', 7),
(362, 'Polewali Mandar', '91300', 27),
(363, 'Ponorogo', '63400', 11),
(364, 'Pontianak', '78000', 12),
(365, 'Pontianak', '78000', 12),
(366, 'Poso', '94600', 29),
(367, 'Prabumulih', '31100', 33),
(368, 'Pringsewu', '35373', 18),
(369, 'Probolinggo', '67200', 11),
(370, 'Probolinggo', '67200', 11),
(371, 'Pulang Pisau', '73561', 14),
(372, 'Pulau Morotai', '97771', 20),
(373, 'Puncak', '98900', 24),
(374, 'Puncak Jaya', '98900', 24),
(375, 'Purbalingga', '53300', 10),
(376, 'Purwakarta', '41100', 9),
(377, 'Purworejo', '54100', 10),
(378, 'Raja Ampat', '98400', 25),
(379, 'Rejang Lebong', '39100', 4),
(380, 'Rembang', '59200', 10),
(381, 'Rokan Hilir', '28991', 26),
(382, 'Rokan Hulu', '28455', 26),
(383, 'Rote Ndao', '85974', 23),
(384, 'Sabang', '23500', 21),
(385, 'Sabu Raijua', '85391', 23),
(386, 'Salatiga', '50700', 10),
(387, 'Samarinda', '75000', 15),
(388, 'Sambas', '79400', 12),
(389, 'Samosir', '22300', 34),
(390, 'Sampang', '69200', 11),
(391, 'Sanggau', '78500', 12),
(392, 'Sarmi', '99373', 24),
(393, 'Sarolangun', '37300', 8),
(394, 'Sawah Lunto', '27400', 32),
(395, 'Sekadau', '78582', 12),
(396, 'Selayar (Kepulauan Selayar)', '92800', 28),
(397, 'Seluma', '38000', 4),
(398, 'Semarang', '50000', 10),
(399, 'Semarang', '50000', 10),
(400, 'Seram Bagian Barat', '97500', 19),
(401, 'Seram Bagian Timur', '97500', 19),
(402, 'Serang', '42100', 3),
(403, 'Serang', '42100', 3),
(404, 'Serdang Bedagai', '20000', 34),
(405, 'Seruyan', '74200', 14),
(406, 'Siak', '28686', 26),
(407, 'Sibolga', '22500', 34),
(408, 'Sidenreng Rappang/Rapang', '91600', 28),
(409, 'Sidoarjo', '61200', 11),
(410, 'Sigi', '94000', 29),
(411, 'Sijunjung (Sawah Lunto Sijunjung)', '27500', 32),
(412, 'Sikka', '86100', 23),
(413, 'Simalungun', '21100', 34),
(414, 'Simeulue', '23000', 21),
(415, 'Singkawang', '79100', 12),
(416, 'Sinjai', '92600', 28),
(417, 'Sintang', '78600', 12),
(418, 'Situbondo', '68300', 11),
(419, 'Sleman', '55500', 5),
(420, 'Solok', '27300', 32),
(421, 'Solok', '27300', 32),
(422, 'Solok Selatan', '27300', 32),
(423, 'Soppeng', '90800', 28),
(424, 'Sorong', '98400', 25),
(425, 'Sorong', '98400', 25),
(426, 'Sorong Selatan', '98400', 25),
(427, 'Sragen', '57200', 10),
(428, 'Subang', '41200', 9),
(429, 'Subulussalam', '23782', 21),
(430, 'Sukabumi', '43100', 9),
(431, 'Sukabumi', '43100', 9),
(432, 'Sukamara', '74172', 14),
(433, 'Sukoharjo', '57500', 10),
(434, 'Sumba Barat', '87200', 23),
(435, 'Sumba Barat Daya', '87200', 23),
(436, 'Sumba Tengah', '87200', 23),
(437, 'Sumba Timur', '87100', 23),
(438, 'Sumbawa', '84300', 22),
(439, 'Sumbawa Barat', '84300', 22),
(440, 'Sumedang', '45300', 9),
(441, 'Sumenep', '69400', 11),
(442, 'Sungaipenuh', '37100', 8),
(443, 'Supiori', '98100', 24),
(444, 'Surabaya', '60000', 11),
(445, 'Surakarta (Solo)', '57100', 10),
(446, 'Tabalong', '71500', 13),
(447, 'Tabanan', '82100', 1),
(448, 'Takalar', '92200', 28),
(449, 'Tambrauw', '98400', 25),
(450, 'Tana Tidung', '77152', 16),
(451, 'Tana Toraja', '91800', 28),
(452, 'Tanah Bumbu', '70000', 13),
(453, 'Tanah Datar', '27200', 32),
(454, 'Tanah Laut', '70800', 13),
(455, 'Tangerang', '15000', 3),
(456, 'Tangerang', '15000', 3),
(457, 'Tangerang Selatan', '15000', 3),
(458, 'Tanggamus', '35000', 18),
(459, 'Tanjung Balai', '21300', 34),
(460, 'Tanjung Jabung Barat', '36500', 8),
(461, 'Tanjung Jabung Timur', '36500', 8),
(462, 'Tanjung Pinang', '29100', 17),
(463, 'Tapanuli Selatan', '22700', 34),
(464, 'Tapanuli Tengah', '22500', 34),
(465, 'Tapanuli Utara', '22400', 34),
(466, 'Tapin', '71100', 13),
(467, 'Tarakan', '77100', 16),
(468, 'Tasikmalaya', '46100', 9),
(469, 'Tasikmalaya', '46100', 9),
(470, 'Tebing Tinggi', '20600', 34),
(471, 'Tebo', '37200', 8),
(472, 'Tegal', '52100', 10),
(473, 'Tegal', '52100', 10),
(474, 'Teluk Bintuni', '98300', 25),
(475, 'Teluk Wondama', '98300', 25),
(476, 'Temanggung', '56200', 10),
(477, 'Ternate', '97700', 20),
(478, 'Tidore Kepulauan', '97800', 20),
(479, 'Timor Tengah Selatan', '85500', 23),
(480, 'Timor Tengah Utara', '85600', 23),
(481, 'Toba Samosir', '22300', 34),
(482, 'Tojo Una-Una', '94600', 29),
(483, 'Toli-Toli', '94500', 29),
(484, 'Tolikara', '99562', 24),
(485, 'Tomohon', '95362', 31),
(486, 'Toraja Utara', '91890', 28),
(487, 'Trenggalek', '66300', 11),
(488, 'Tual', '97600', 19),
(489, 'Tuban', '62300', 11),
(490, 'Tulang Bawang', '34500', 18),
(491, 'Tulang Bawang Barat', '34500', 18),
(492, 'Tulungagung', '66200', 11),
(493, 'Wajo', '90900', 28),
(494, 'Wakatobi', '93700', 30),
(495, 'Waropen', '98200', 24),
(496, 'Way Kanan', '35000', 18),
(497, 'Wonogiri', '57600', 10),
(498, 'Wonosobo', '56300', 10),
(499, 'Yahukimo', '99500', 24),
(500, 'Yalimo', '99500', 24),
(501, 'Yogyakarta', '55000', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

DROP TABLE IF EXISTS `tbl_country`;
CREATE TABLE IF NOT EXISTS `tbl_country` (
  `country_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_name` varchar(100) NOT NULL,
  `country_active_status` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=245 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_country`
--

INSERT INTO `tbl_country` (`country_id`, `country_name`, `country_active_status`) VALUES
(1, 'Germany', 1),
(2, 'Austria', 1),
(3, 'Belgium', 1),
(4, 'Canada', 1),
(5, 'China', 1),
(6, 'Spain', 1),
(7, 'Finland', 1),
(8, 'France', 1),
(9, 'Greece', 1),
(10, 'Italy', 1),
(11, 'Japan', 1),
(12, 'Luxemburg', 1),
(13, 'Netherlands', 1),
(14, 'Poland', 1),
(15, 'Portugal', 1),
(16, 'Czech Republic', 1),
(17, 'United Kingdom', 1),
(18, 'Sweden', 1),
(19, 'Switzerland', 1),
(20, 'Denmark', 1),
(21, 'United States', 1),
(22, 'HongKong', 1),
(23, 'Norway', 1),
(24, 'Australia', 1),
(25, 'Singapore', 1),
(26, 'Ireland', 1),
(27, 'New Zealand', 1),
(28, 'South Korea', 1),
(29, 'Israel', 1),
(30, 'South Africa', 1),
(31, 'Nigeria', 1),
(32, 'Ivory Coast', 1),
(33, 'Togo', 1),
(34, 'Bolivia', 1),
(35, 'Mauritius', 1),
(36, 'Romania', 1),
(37, 'Slovakia', 1),
(38, 'Algeria', 1),
(39, 'American Samoa', 1),
(40, 'Andorra', 1),
(41, 'Angola', 1),
(42, 'Anguilla', 1),
(43, 'Antigua and Barbuda', 1),
(44, 'Argentina', 1),
(45, 'Armenia', 1),
(46, 'Aruba', 1),
(47, 'Azerbaijan', 1),
(48, 'Bahamas', 1),
(49, 'Bahrain', 1),
(50, 'Bangladesh', 1),
(51, 'Barbados', 1),
(52, 'Belarus', 1),
(53, 'Belize', 1),
(54, 'Benin', 1),
(55, 'Bermuda', 1),
(56, 'Bhutan', 1),
(57, 'Botswana', 1),
(58, 'Brazil', 1),
(59, 'Brunei', 1),
(60, 'Burkina Faso', 1),
(61, 'Burma (Myanmar)', 1),
(62, 'Burundi', 1),
(63, 'Cambodia', 1),
(64, 'Cameroon', 1),
(65, 'Cape Verde', 1),
(66, 'Central African Republic', 1),
(67, 'Chad', 1),
(68, 'Chile', 1),
(69, 'Colombia', 1),
(70, 'Comoros', 1),
(71, 'Congo, Dem. Republic', 1),
(72, 'Congo, Republic', 1),
(73, 'Costa Rica', 1),
(74, 'Croatia', 1),
(75, 'Cuba', 1),
(76, 'Cyprus', 1),
(77, 'Djibouti', 1),
(78, 'Dominica', 1),
(79, 'Dominican Republic', 1),
(80, 'East Timor', 1),
(81, 'Ecuador', 1),
(82, 'Egypt', 1),
(83, 'El Salvador', 1),
(84, 'Equatorial Guinea', 1),
(85, 'Eritrea', 1),
(86, 'Estonia', 1),
(87, 'Ethiopia', 1),
(88, 'Falkland Islands', 1),
(89, 'Faroe Islands', 1),
(90, 'Fiji', 1),
(91, 'Gabon', 1),
(92, 'Gambia', 1),
(93, 'Georgia', 1),
(94, 'Ghana', 1),
(95, 'Grenada', 1),
(96, 'Greenland', 1),
(97, 'Gibraltar', 1),
(98, 'Guadeloupe', 1),
(99, 'Guam', 1),
(100, 'Guatemala', 1),
(101, 'Guernsey', 1),
(102, 'Guinea', 1),
(103, 'Guinea-Bissau', 1),
(104, 'Guyana', 1),
(105, 'Haiti', 1),
(106, 'Heard Island and McDonald Islands', 1),
(107, 'Vatican City State', 1),
(108, 'Honduras', 1),
(109, 'Iceland', 1),
(110, 'India', 1),
(111, 'Indonesia', 1),
(112, 'Iran', 1),
(113, 'Iraq', 1),
(114, 'Man Island', 1),
(115, 'Jamaica', 1),
(116, 'Jersey', 1),
(117, 'Jordan', 1),
(118, 'Kazakhstan', 1),
(119, 'Kenya', 1),
(120, 'Kiribati', 1),
(121, 'Korea, Dem. Republic of', 1),
(122, 'Kuwait', 1),
(123, 'Kyrgyzstan', 1),
(124, 'Laos', 1),
(125, 'Latvia', 1),
(126, 'Lebanon', 1),
(127, 'Lesotho', 1),
(128, 'Liberia', 1),
(129, 'Libya', 1),
(130, 'Liechtenstein', 1),
(131, 'Lithuania', 1),
(132, 'Macau', 1),
(133, 'Macedonia', 1),
(134, 'Madagascar', 1),
(135, 'Malawi', 1),
(136, 'Malaysia', 1),
(137, 'Maldives', 1),
(138, 'Mali', 1),
(139, 'Malta', 1),
(140, 'Marshall Islands', 1),
(141, 'Martinique', 1),
(142, 'Mauritania', 1),
(143, 'Hungary', 1),
(144, 'Mayotte', 1),
(145, 'Mexico', 1),
(146, 'Micronesia', 1),
(147, 'Moldova', 1),
(148, 'Monaco', 1),
(149, 'Mongolia', 1),
(150, 'Montenegro', 1),
(151, 'Montserrat', 1),
(152, 'Morocco', 1),
(153, 'Mozambique', 1),
(154, 'Namibia', 1),
(155, 'Nauru', 1),
(156, 'Nepal', 1),
(157, 'Netherlands Antilles', 1),
(158, 'New Caledonia', 1),
(159, 'Nicaragua', 1),
(160, 'Niger', 1),
(161, 'Niue', 1),
(162, 'Norfolk Island', 1),
(163, 'Northern Mariana Islands', 1),
(164, 'Oman', 1),
(165, 'Pakistan', 1),
(166, 'Palau', 1),
(167, 'Palestinian Territories', 1),
(168, 'Panama', 1),
(169, 'Papua New Guinea', 1),
(170, 'Paraguay', 1),
(171, 'Peru', 1),
(172, 'Philippines', 1),
(173, 'Pitcairn', 1),
(174, 'Puerto Rico', 1),
(175, 'Qatar', 1),
(176, 'Reunion Island', 1),
(177, 'Russian Federation', 1),
(178, 'Rwanda', 1),
(179, 'Saint Barthelemy', 1),
(180, 'Saint Kitts and Nevis', 1),
(181, 'Saint Lucia', 1),
(182, 'Saint Martin', 1),
(183, 'Saint Pierre and Miquelon', 1),
(184, 'Saint Vincent and the Grenadines', 1),
(185, 'Samoa', 1),
(186, 'San Marino', 1),
(187, 'São Tomé and Príncipe', 1),
(188, 'Saudi Arabia', 1),
(189, 'Senegal', 1),
(190, 'Serbia', 1),
(191, 'Seychelles', 1),
(192, 'Sierra Leone', 1),
(193, 'Slovenia', 1),
(194, 'Solomon Islands', 1),
(195, 'Somalia', 1),
(196, 'South Georgia and the South Sandwich Islands', 1),
(197, 'Sri Lanka', 1),
(198, 'Sudan', 1),
(199, 'Suriname', 1),
(200, 'Svalbard and Jan Mayen', 1),
(201, 'Swaziland', 1),
(202, 'Syria', 1),
(203, 'Taiwan', 1),
(204, 'Tajikistan', 1),
(205, 'Tanzania', 1),
(206, 'Thailand', 1),
(207, 'Tokelau', 1),
(208, 'Tonga', 1),
(209, 'Trinidad and Tobago', 1),
(210, 'Tunisia', 1),
(211, 'Turkey', 1),
(212, 'Turkmenistan', 1),
(213, 'Turks and Caicos Islands', 1),
(214, 'Tuvalu', 1),
(215, 'Uganda', 1),
(216, 'Ukraine', 1),
(217, 'United Arab Emirates', 1),
(218, 'Uruguay', 1),
(219, 'Uzbekistan', 1),
(220, 'Vanuatu', 1),
(221, 'Venezuela', 1),
(222, 'Vietnam', 1),
(223, 'Virgin Islands (British)', 1),
(224, 'Virgin Islands (U.S.)', 1),
(225, 'Wallis and Futuna', 1),
(226, 'Western Sahara', 1),
(227, 'Yemen', 1),
(228, 'Zambia', 1),
(229, 'Zimbabwe', 1),
(230, 'Albania', 1),
(231, 'Afghanistan', 1),
(232, 'Antarctica', 1),
(233, 'Bosnia and Herzegovina', 1),
(234, 'Bouvet Island', 1),
(235, 'British Indian Ocean Territory', 1),
(236, 'Bulgaria', 1),
(237, 'Cayman Islands', 1),
(238, 'Christmas Island', 1),
(239, 'Cocos (Keeling) Islands', 1),
(240, 'Cook Islands', 1),
(241, 'French Guiana', 1),
(242, 'French Polynesia', 1),
(243, 'French Southern Territories', 1),
(244, 'Åland Islands', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general`
--

DROP TABLE IF EXISTS `tbl_general`;
CREATE TABLE IF NOT EXISTS `tbl_general` (
  `general_id` int(11) NOT NULL AUTO_INCREMENT,
  `general_title` varchar(100) NOT NULL,
  `general_description` varchar(255) NOT NULL,
  `general_keyword` varchar(255) NOT NULL,
  `general_facebook` varchar(50) DEFAULT NULL,
  `general_twitter` varchar(50) DEFAULT NULL,
  `general_cs_phonenumber` varchar(50) DEFAULT NULL,
  `general_cs_email` varchar(150) DEFAULT NULL,
  `general_update_date` datetime DEFAULT NULL,
  `general_update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`general_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_general`
--

INSERT INTO `tbl_general` (`general_id`, `general_title`, `general_description`, `general_keyword`, `general_facebook`, `general_twitter`, `general_cs_phonenumber`, `general_cs_email`, `general_update_date`, `general_update_by`) VALUES
(1, 'Title', 'Desciption', 'keyword1, keyword2', 'tukarpoin', 'tukarpoin', '021-5888888', 'cs[@]tukarpoin.com', '2015-09-10 10:13:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

DROP TABLE IF EXISTS `tbl_language`;
CREATE TABLE IF NOT EXISTS `tbl_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_title` varchar(50) NOT NULL,
  `language_image` varchar(255) NOT NULL,
  `language_default` tinyint(1) NOT NULL,
  `language_active_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`language_id`, `language_title`, `language_image`, `language_default`, `language_active_status`) VALUES
(1, 'Indonesia', '/assets/file_upload/admin/images/language/lang-ind.jpg', 0, 1),
(2, 'English', '/assets/file_upload/admin/images/language/lang-eng.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log_cms`
--

DROP TABLE IF EXISTS `tbl_log_cms`;
CREATE TABLE IF NOT EXISTS `tbl_log_cms` (
  `log_id_cms` int(11) NOT NULL AUTO_INCREMENT,
  `log_module` varchar(50) NOT NULL,
  `log_value` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_create_date` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`log_id_cms`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_log_cms`
--

INSERT INTO `tbl_log_cms` (`log_id_cms`, `log_module`, `log_value`, `user_id`, `log_create_date`, `ip`) VALUES
(1, 'Login', 'Superadmin | 1', 1, '2019-02-20 13:11:32', '::1'),
(2, 'Login', 'Superadmin | 1', 1, '2019-02-20 13:38:52', '::1'),
(3, 'Login', 'Superadmin | 1', 1, '2019-02-20 13:44:14', '::1'),
(4, 'Inactive User Level', '3 | Administrator | 0', 1, '2019-02-20 13:49:07', '::1'),
(5, 'Active User Level', '3 | Administrator | 1', 1, '2019-02-20 13:49:08', '::1'),
(6, 'Login', 'Superadmin | 1', 1, '2019-02-20 14:13:04', '::1'),
(7, 'Add User', '3 | admin | admin@domain.com', 1, '2019-02-20 14:39:02', '::1'),
(8, 'Active User', '2 | admin | 1', 1, '2019-02-20 14:41:14', '::1'),
(9, 'Login', 'Superadmin | 1', 1, '2019-02-20 14:52:35', '::1'),
(10, 'Login', 'Admin | 3', 2, '2019-02-20 15:07:19', '::1'),
(11, 'Login', 'Superadmin | 1', 1, '2019-02-20 15:07:47', '::1'),
(12, 'Login', 'Superadmin | 1', 1, '2019-02-20 15:16:38', '::1'),
(13, 'Change Password', 'Superadmin | ', 1, '2019-02-20 15:24:50', '::1'),
(14, 'Login', 'Superadmin | 1', 1, '2019-02-20 15:26:27', '::1'),
(15, 'Change Password', 'Superadmin', 1, '2019-02-20 15:27:00', '::1'),
(16, 'Login', 'Superadmin | 1', 1, '2019-02-20 15:27:13', '::1'),
(17, 'Login', 'Admin | 3', 2, '2019-02-20 15:27:30', '::1'),
(18, 'Login', 'Superadmin | 1', 1, '2019-02-20 15:27:39', '::1'),
(19, 'Login', 'Superadmin | 1', 1, '2019-02-20 15:35:10', '::1'),
(20, 'Change Password', 'Superadmin', 1, '2019-02-20 15:35:39', '::1'),
(21, 'Login', 'Superadmin | 1', 1, '2019-02-20 15:35:48', '::1'),
(22, 'Active Module', '7 | General | 1', 1, '2019-02-20 15:37:33', '::1'),
(23, 'Login', 'Superadmin | 1', 1, '2019-02-20 15:42:50', '::1'),
(24, 'Active Module Group', '3 | Content | 1', 1, '2019-02-20 15:44:08', '::1'),
(25, 'Active Module', '8 | Banner | 1', 1, '2019-02-20 15:44:28', '::1'),
(26, 'Inactive Banner', '1 | Banner 1 | 0', 1, '2019-02-20 16:50:39', '::1'),
(27, 'Active Banner', '1 | Banner 1 | 1', 1, '2019-02-20 16:50:39', '::1'),
(28, 'Add Banner', '2 | Test | /assets/file_upload/admin/images/banner/nba-superstar-last-supper-illustration-full.jpg | 1 | ', 1, '2019-02-20 17:01:15', '::1'),
(29, 'Edit Banner', '2 | Test | /assets/file_upload/admin/images/banner/nba-superstar-last-supper-illustration-full.jpg | 1 | http://picmix.it', 1, '2019-02-20 17:02:43', '::1'),
(30, 'Active Banner', '2 | Test | 1', 1, '2019-02-20 17:02:47', '::1'),
(31, 'Login', 'Superadmin | 1', 1, '2019-02-20 17:13:47', '::1'),
(32, 'Active Module', '9 | Pages | 1', 1, '2019-02-20 17:14:08', '::1'),
(33, 'Inactive Pages', '1 | ABOUT US | 0', 1, '2019-02-20 17:28:19', '::1'),
(34, 'Active Pages', '1 | ABOUT US | 1', 1, '2019-02-20 17:28:20', '::1'),
(35, 'Edit Pages', '1 | ABOUT US | <p>Pages Short Description</p> | <p class=\"border-blue\">Pages Description</p> |  | about-us |  | ', 1, '2019-02-20 17:39:30', '::1'),
(36, 'Edit Pages', '1 | ABOUT US | <p>Pages Short Description</p> | <p class=\"border-blue\">Pages Description</p> | /assets/file_upload/admin/images/750xauto-begini-kabar-ian-kasela-radja-jadi-hot-papa-dan-awet-muda-160517f.jpg | about-us |  | ', 1, '2019-02-20 17:39:47', '::1'),
(37, 'Active Module', '10 | Video | 1', 1, '2019-02-21 13:13:32', '::1'),
(38, 'Login', 'Superadmin | 1', 1, '2019-02-21 13:55:17', '::1'),
(39, 'List Video', '', 1, '2019-02-21 13:56:29', '::1'),
(40, 'List Video', '', 1, '2019-02-21 13:56:30', '::1'),
(41, 'List Video', '', 1, '2019-02-21 13:56:30', '::1'),
(42, 'List Video', '', 1, '2019-02-21 13:56:31', '::1'),
(43, 'List Video', '', 1, '2019-02-21 13:56:31', '::1'),
(44, 'List Video', '', 1, '2019-02-21 13:56:31', '::1'),
(45, 'List Video', '', 1, '2019-02-21 13:57:32', '::1'),
(46, 'List Video', '', 1, '2019-02-21 14:00:31', '::1'),
(47, 'List Video', '', 1, '2019-02-21 14:00:34', '::1'),
(48, 'Insert Video', '0 - mhfgngfnf - 862122473466322944.mp4', 1, '2019-02-21 15:19:21', '::1'),
(49, 'Insert Video', '1 - trbrtrt - 862122473466322944.mp4', 1, '2019-02-21 15:21:44', '::1'),
(50, 'Insert Video', '2 - vvrverveb - 18399705_1353221644753895_286126460651962368_n.mp4', 1, '2019-02-21 15:26:02', '::1'),
(51, 'Edit Video', '2 - vvrverveb1 - 18399705_1353221644753895_286126460651962368_n.mp4', 1, '2019-02-21 15:42:07', '::1'),
(52, 'Edit Video', '2 - vvrverveb1 - 23762890_141335269959304_1641235655251984384_n.mp4', 1, '2019-02-21 15:45:22', '::1'),
(53, 'Delete Video', '2 | vvrverveb1', 1, '2019-02-21 15:49:47', '::1'),
(54, 'Delete Video', '1 | trbrtrt', 1, '2019-02-21 15:49:57', '::1'),
(55, 'Insert Video', '3 - feerver - 862122473466322944.mp4 - 750xauto-begini-kabar-ian-kasela-radja-jadi-hot-papa-dan-awet-muda-160517f.jpg', 1, '2019-02-21 16:33:13', '::1'),
(56, 'Edit Video', '3 - forever - 862122473466322944.mp4 - 750xauto-begini-kabar-ian-kasela-radja-jadi-hot-papa-dan-awet-muda-160517f.jpg', 1, '2019-02-21 16:43:39', '::1'),
(57, 'Edit Video', '3 - forever - 862122473466322944.mp4 - 750xauto-begini-kabar-ian-kasela-radja-jadi-hot-papa-dan-awet-muda-160517f.jpg', 1, '2019-02-21 16:56:11', '::1'),
(58, 'Edit Video', '3 - forever - 862122473466322944.mp4 - 750xauto-begini-kabar-ian-kasela-radja-jadi-hot-papa-dan-awet-muda-160517f.jpg', 1, '2019-02-21 16:56:29', '::1'),
(59, 'Edit Video', '3 - forever - 862122473466322944.mp4 - hi_471322a0-4aca-11e6-932f-2f1193c0e5b4.jpeg', 1, '2019-02-21 16:58:36', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(50) NOT NULL,
  `menu_active_status` tinyint(1) NOT NULL DEFAULT 0,
  `menu_url` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `menu_parent` tinyint(2) NOT NULL DEFAULT 0,
  `menu_order` tinyint(2) NOT NULL DEFAULT 1,
  `menu_create_date` datetime NOT NULL,
  `menu_create_by` int(11) NOT NULL,
  `menu_update_date` datetime DEFAULT NULL,
  `menu_update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `menu_parent` (`menu_parent`,`menu_order`),
  KEY `menu_active_status` (`menu_active_status`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`menu_id`, `menu_title`, `menu_active_status`, `menu_url`, `menu_parent`, `menu_order`, `menu_create_date`, `menu_create_by`, `menu_update_date`, `menu_update_by`) VALUES
(4, 'HOME', 1, 'http://127.0.0.1/cms_default/', 0, 1, '2015-10-07 12:53:23', 1, '2015-11-10 14:38:10', 1),
(3, 'ABOUT US', 1, 'http://127.0.0.1/cms_default/about-us', 0, 2, '2015-08-13 15:35:42', 1, '2015-11-10 14:38:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_module`
--

DROP TABLE IF EXISTS `tbl_module`;
CREATE TABLE IF NOT EXISTS `tbl_module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  `module_path` varchar(255) NOT NULL,
  `module_active_status` int(1) NOT NULL,
  `module_order_value` int(5) NOT NULL DEFAULT 1,
  `module_create_date` datetime NOT NULL,
  `module_create_by` int(11) NOT NULL,
  `module_update_date` datetime DEFAULT NULL,
  `module_update_by` int(11) DEFAULT NULL,
  `module_group_id` int(11) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_module`
--

INSERT INTO `tbl_module` (`module_id`, `module_name`, `module_path`, `module_active_status`, `module_order_value`, `module_create_date`, `module_create_by`, `module_update_date`, `module_update_by`, `module_group_id`) VALUES
(7, 'General', 'general', 1, 1, '2019-02-20 15:37:31', 1, '2019-02-21 13:13:30', 1, 2),
(8, 'Banner', 'banner', 1, 1, '2019-02-20 15:44:25', 1, '2019-02-21 13:13:30', 1, 3),
(9, 'Pages', 'pages', 1, 2, '2019-02-20 17:14:03', 1, '2019-02-21 13:13:30', 1, 3),
(10, 'Video', 'video', 1, 3, '2019-02-21 13:13:24', 1, '2019-02-21 13:13:30', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_module_group`
--

DROP TABLE IF EXISTS `tbl_module_group`;
CREATE TABLE IF NOT EXISTS `tbl_module_group` (
  `module_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_group_name` varchar(255) NOT NULL,
  `module_group_active_status` int(1) NOT NULL,
  `module_group_order_value` int(5) NOT NULL DEFAULT 1,
  `module_group_images` varchar(255) DEFAULT NULL,
  `module_group_create_date` datetime NOT NULL,
  `module_group_create_by` int(11) NOT NULL,
  `module_group_update_date` datetime DEFAULT NULL,
  `module_group_update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`module_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_module_group`
--

INSERT INTO `tbl_module_group` (`module_group_id`, `module_group_name`, `module_group_active_status`, `module_group_order_value`, `module_group_images`, `module_group_create_date`, `module_group_create_by`, `module_group_update_date`, `module_group_update_by`) VALUES
(2, 'Configuration', 1, 1, NULL, '2015-10-07 13:07:34', 1, '2019-02-20 15:44:11', 1),
(3, 'Content', 1, 2, NULL, '2019-02-20 15:40:21', 1, '2019-02-20 15:44:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_module_privilege`
--

DROP TABLE IF EXISTS `tbl_module_privilege`;
CREATE TABLE IF NOT EXISTS `tbl_module_privilege` (
  `module_privilege_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL,
  `module_privilege_create_date` datetime NOT NULL,
  `module_privilege_create_by` int(11) NOT NULL,
  PRIMARY KEY (`module_privilege_id`),
  KEY `module_id` (`module_id`,`privilege_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_module_privilege`
--

INSERT INTO `tbl_module_privilege` (`module_privilege_id`, `module_id`, `privilege_id`, `module_privilege_create_date`, `module_privilege_create_by`) VALUES
(1, 7, 1, '2019-02-20 15:37:47', 1),
(2, 7, 4, '2019-02-20 15:37:47', 1),
(3, 8, 1, '2019-02-20 15:44:45', 1),
(4, 8, 3, '2019-02-20 15:44:45', 1),
(5, 8, 4, '2019-02-20 15:44:45', 1),
(6, 8, 5, '2019-02-20 15:44:45', 1),
(7, 8, 7, '2019-02-20 15:44:45', 1),
(8, 9, 1, '2019-02-20 17:14:17', 1),
(9, 9, 3, '2019-02-20 17:14:17', 1),
(10, 9, 4, '2019-02-20 17:14:17', 1),
(11, 9, 5, '2019-02-20 17:14:17', 1),
(12, 9, 7, '2019-02-20 17:14:17', 1),
(13, 10, 1, '2019-02-21 13:13:41', 1),
(14, 10, 3, '2019-02-21 13:13:41', 1),
(15, 10, 4, '2019-02-21 13:13:41', 1),
(16, 10, 5, '2019-02-21 13:13:41', 1),
(17, 10, 7, '2019-02-21 13:13:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

DROP TABLE IF EXISTS `tbl_pages`;
CREATE TABLE IF NOT EXISTS `tbl_pages` (
  `pages_id` int(11) NOT NULL AUTO_INCREMENT,
  `pages_title` varchar(255) NOT NULL,
  `pages_short_desc` varchar(1000) DEFAULT NULL,
  `pages_desc` text NOT NULL,
  `pages_image` varchar(255) DEFAULT NULL,
  `pages_active_status` tinyint(1) NOT NULL DEFAULT 0,
  `pages_alias` varchar(255) DEFAULT NULL,
  `pages_meta_description` varchar(250) DEFAULT NULL,
  `pages_meta_keywords` varchar(250) DEFAULT NULL,
  `pages_create_date` datetime NOT NULL,
  `pages_create_by` int(11) NOT NULL,
  `pages_update_date` datetime DEFAULT NULL,
  `pages_update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`pages_id`),
  KEY `pages_title` (`pages_title`,`pages_active_status`,`pages_create_date`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pages`
--

INSERT INTO `tbl_pages` (`pages_id`, `pages_title`, `pages_short_desc`, `pages_desc`, `pages_image`, `pages_active_status`, `pages_alias`, `pages_meta_description`, `pages_meta_keywords`, `pages_create_date`, `pages_create_by`, `pages_update_date`, `pages_update_by`) VALUES
(1, 'ABOUT US', '<p>Pages Short Description</p>', '<p class=\"border-blue\">Pages Description</p>', '/assets/file_upload/admin/images/750xauto-begini-kabar-ian-kasela-radja-jadi-hot-papa-dan-awet-muda-160517f.jpg', 1, 'about-us', '', '', '2019-02-20 15:23:22', 1, '2019-02-20 17:39:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_privilege`
--

DROP TABLE IF EXISTS `tbl_privilege`;
CREATE TABLE IF NOT EXISTS `tbl_privilege` (
  `privilege_id` int(11) NOT NULL AUTO_INCREMENT,
  `privilege_name` varchar(255) NOT NULL,
  `privilege_create_date` datetime NOT NULL,
  `privilege_create_by` int(11) NOT NULL,
  PRIMARY KEY (`privilege_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_privilege`
--

INSERT INTO `tbl_privilege` (`privilege_id`, `privilege_name`, `privilege_create_date`, `privilege_create_by`) VALUES
(1, 'List', '2012-01-04 21:13:59', 1),
(3, 'Add', '2012-01-04 21:14:27', 1),
(4, 'Edit', '2012-01-04 21:14:27', 1),
(2, 'View', '2012-01-04 21:15:18', 1),
(6, 'Approve', '2012-01-04 21:15:34', 1),
(7, 'Delete', '2012-01-04 21:15:34', 1),
(5, 'Publish', '2012-01-04 21:16:17', 1),
(8, 'Order', '2012-01-04 21:16:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_province`
--

DROP TABLE IF EXISTS `tbl_province`;
CREATE TABLE IF NOT EXISTS `tbl_province` (
  `province_id` int(11) NOT NULL AUTO_INCREMENT,
  `province_name` varchar(100) NOT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_province`
--

INSERT INTO `tbl_province` (`province_id`, `province_name`) VALUES
(1, 'Bali'),
(2, 'Bangka Belitung'),
(3, 'Banten'),
(4, 'Bengkulu'),
(5, 'DI Yogyakarta'),
(6, 'DKI Jakarta'),
(7, 'Gorontalo'),
(8, 'Jambi'),
(9, 'Jawa Barat'),
(10, 'Jawa Tengah'),
(11, 'Jawa Timur'),
(12, 'Kalimantan Barat'),
(13, 'Kalimantan Selatan'),
(14, 'Kalimantan Tengah'),
(15, 'Kalimantan Timur'),
(16, 'Kalimantan Utara'),
(17, 'Kepulauan Riau'),
(18, 'Lampung'),
(19, 'Maluku'),
(20, 'Maluku Utara'),
(21, 'Nanggroe Aceh Darussalam (NAD)'),
(22, 'Nusa Tenggara Barat (NTB)'),
(23, 'Nusa Tenggara Timur (NTT)'),
(24, 'Papua'),
(25, 'Papua Barat'),
(26, 'Riau'),
(27, 'Sulawesi Barat'),
(28, 'Sulawesi Selatan'),
(29, 'Sulawesi Tengah'),
(30, 'Sulawesi Tenggara'),
(31, 'Sulawesi Utara'),
(32, 'Sumatera Barat'),
(33, 'Sumatera Selatan'),
(34, 'Sumatera Utara');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tagging`
--

DROP TABLE IF EXISTS `tbl_tagging`;
CREATE TABLE IF NOT EXISTS `tbl_tagging` (
  `tagging_id` int(11) NOT NULL AUTO_INCREMENT,
  `tagging_title` varchar(100) NOT NULL,
  `tagging_create_date` datetime NOT NULL,
  PRIMARY KEY (`tagging_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(40) NOT NULL,
  `user_pass` varchar(72) NOT NULL,
  `user_active_status` int(1) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_contact` varchar(15) NOT NULL,
  `user_avatar` varchar(50) DEFAULT NULL,
  `user_expired` date NOT NULL,
  `user_create_date` datetime NOT NULL,
  `user_create_by` int(11) NOT NULL,
  `user_update_date` datetime NOT NULL,
  `user_update_by` int(11) NOT NULL,
  `user_change_password_date` datetime DEFAULT NULL,
  `user_level_id` int(11) NOT NULL,
  `token` varchar(128) DEFAULT NULL,
  `token_expired` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_pass`, `user_active_status`, `user_email`, `user_contact`, `user_avatar`, `user_expired`, `user_create_date`, `user_create_by`, `user_update_date`, `user_update_by`, `user_change_password_date`, `user_level_id`, `token`, `token_expired`, `ip`) VALUES
(1, 'superadmin', '$2y$15$tMMYPPDa/Z5LW/2Ep5WDn.24pl8Ux6cAuA8BnMSrN09Gt2F765zwu', 1, 'superadmin@domain.com', '', '36490201902.png', '0000-00-00', '2019-02-20 13:37:44', 0, '2019-02-20 15:35:39', 1, NULL, 1, NULL, '0000-00-00 00:00:00', NULL),
(2, 'admin', '$2y$15$UJEMfg5nnmMbPQTAcNXrt.1DivBbbEVG2rjmjy4TJF5ZTqNM57hte', 1, 'admin@domain.com', '', NULL, '0000-00-00', '2019-02-20 14:39:02', 1, '0000-00-00 00:00:00', 0, NULL, 3, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_level`
--

DROP TABLE IF EXISTS `tbl_user_level`;
CREATE TABLE IF NOT EXISTS `tbl_user_level` (
  `user_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_level_name` varchar(255) NOT NULL,
  `user_level_desc` varchar(200) NOT NULL,
  `user_level_active_status` int(1) NOT NULL,
  `user_level_create_date` datetime NOT NULL,
  `user_level_create_by` int(11) NOT NULL,
  `user_level_update_date` datetime DEFAULT NULL,
  `user_level_update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_level_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_level`
--

INSERT INTO `tbl_user_level` (`user_level_id`, `user_level_name`, `user_level_desc`, `user_level_active_status`, `user_level_create_date`, `user_level_create_by`, `user_level_update_date`, `user_level_update_by`) VALUES
(1, 'Super Administrator', 'Super Administrator', 1, '2011-08-19 10:49:45', 1, '2015-08-11 15:18:22', 1),
(3, 'Administrator', 'Administrator', 1, '2015-08-24 15:49:07', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video`
--

DROP TABLE IF EXISTS `tbl_video`;
CREATE TABLE IF NOT EXISTS `tbl_video` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `video_name` varchar(100) NOT NULL,
  `video_file` varchar(255) NOT NULL,
  `video_cover` varchar(255) NOT NULL,
  `video_create_date` datetime NOT NULL,
  `video_create_by` int(11) NOT NULL,
  `video_update_date` datetime DEFAULT NULL,
  `video_update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_video`
--

INSERT INTO `tbl_video` (`video_id`, `video_name`, `video_file`, `video_cover`, `video_create_date`, `video_create_by`, `video_update_date`, `video_update_by`) VALUES
(3, 'forever', '862122473466322944.mp4', 'hi_471322a0-4aca-11e6-932f-2f1193c0e5b4.jpeg', '2019-02-21 16:33:13', 1, '2019-02-21 16:58:36', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
