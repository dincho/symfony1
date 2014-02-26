# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29-log)
# Database: polishdate_test
# Generation Time: 2014-02-26 14:13:13 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table as_seen_on_logo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `as_seen_on_logo`;

CREATE TABLE `as_seen_on_logo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `homepages` varchar(255) DEFAULT NULL,
  `is_online` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table block
# ------------------------------------------------------------

DROP TABLE IF EXISTS `block`;

CREATE TABLE `block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `block_FI_1` (`member_id`),
  KEY `block_FI_2` (`profile_id`),
  CONSTRAINT `block_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `block_FK_2` FOREIGN KEY (`profile_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table catalogue
# ------------------------------------------------------------

DROP TABLE IF EXISTS `catalogue`;

CREATE TABLE `catalogue` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `source_lang` varchar(100) NOT NULL DEFAULT '',
  `target_lang` varchar(100) NOT NULL DEFAULT '',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `date_modified` int(11) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `shared_catalogs` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `catalogue` WRITE;
/*!40000 ALTER TABLE `catalogue` DISABLE KEYS */;

INSERT INTO `catalogue` (`cat_id`, `name`, `source_lang`, `target_lang`, `date_created`, `date_modified`, `author`, `domain`, `shared_catalogs`)
VALUES
	(1,'www.polishdate.com.messages.en','en','en',1230029316,1384190282,'','www.polishdate.com','2,16'),
	(2,'www.szukammilionera.com.messages.pl','en','pl',1230029324,1387371822,'','www.szukammilionera.com','1,3,4,5,6,7,8,9,10,11,12,13'),
	(14,'www.dyskretnyuklad.com.messages.en','en','en',1230029316,1360822828,'','www.dyskretnyuklad.com',NULL),
	(15,'www.expatcalling.com.messages.en','en','en',1285768721,1360822749,'','www.expatcalling.com',NULL),
	(16,'www.meskamilosc.pl.messages.pl','en','pl',1285768721,1358956336,'','www.meskamilosc.pl','1'),
	(17,'www.cafesayang.com.messages.en','en','en',1371637565,1374142335,'','www.cafesayang.com',NULL),
	(18,'www.datingbistro.com.messages.en','en','en',1376916824,1376916824,'','www.datingbistro.com','1');

/*!40000 ALTER TABLE `catalogue` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table desc_answer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `desc_answer`;

CREATE TABLE `desc_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc_question_id` int(11) NOT NULL,
  `title` text,
  `search_title` varchar(255) DEFAULT NULL,
  `desc_title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `desc_answer_FI_1` (`desc_question_id`),
  CONSTRAINT `desc_answer_FK_1` FOREIGN KEY (`desc_question_id`) REFERENCES `desc_question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `desc_answer` WRITE;
/*!40000 ALTER TABLE `desc_answer` DISABLE KEYS */;

INSERT INTO `desc_answer` (`id`, `desc_question_id`, `title`, `search_title`, `desc_title`)
VALUES
	(1,2,'Never married',NULL,NULL),
	(2,2,'Widow(er)','Widow(er)',NULL),
	(3,2,'Divorced',NULL,NULL),
	(4,2,'Separated',NULL,NULL),
	(5,3,'No, I don\'t have children','never had a child',NULL),
	(6,3,'Yes, living with me','has children and lives with them',NULL),
	(7,3,'Yes, not living with me','has children but doesn\'t live with them',NULL),
	(8,3,'Yes, sometimes living with me','has children and lives with them sometimes',NULL),
	(9,4,'I own my place','owns his/ her place',NULL),
	(10,4,'I rent my place','rents his/ her place',NULL),
	(11,4,'I live with my parents','lives with parents',NULL),
	(12,4,'I live with roommate','lives with roommate',NULL),
	(13,5,'Yes','wants to have children',NULL),
	(14,5,'Maybe','is not sure about having children in the future',NULL),
	(15,5,'No','does not want to have children',NULL),
	(16,6,'Some High School',NULL,NULL),
	(17,6,'High School',NULL,NULL),
	(18,6,'Student',NULL,NULL),
	(19,6,'Some university',NULL,NULL),
	(20,6,'Associate degree',NULL,NULL),
	(21,6,'Undergraduate degree',NULL,NULL),
	(22,6,'Master degree',NULL,NULL),
	(23,6,'Graduate degree',NULL,NULL),
	(24,6,'PhD',NULL,NULL),
	(25,7,'$0 - $50,000',NULL,NULL),
	(26,7,'$50,00l - $100,000',NULL,NULL),
	(27,7,'$100,001 - $250,000',NULL,NULL),
	(28,7,'More than $250,000',NULL,NULL),
	(29,8,'Agnostic',NULL,NULL),
	(30,8,'Buddhist',NULL,NULL),
	(31,8,'Christian Anglican','Christian Anglican',NULL),
	(32,8,'Christian Catholic','Christian Catholic',NULL),
	(33,8,'Christian Orthodox','Christian Orthodox',NULL),
	(34,8,'Christian Protestant','Christian Protestant',NULL),
	(35,8,'Hindu','Hindu',NULL),
	(36,8,'Jehova\'s Witness','Jehova\'s Witness',NULL),
	(37,8,'Jewish','Jewish',NULL),
	(38,8,'Mormon','Mormon',NULL),
	(39,8,'Muslim','Muslim',NULL),
	(40,9,'Caucassian/ White','Caucassian/ White',NULL),
	(41,9,'Hispanic or Latino','Hispanic or Latino',NULL),
	(42,9,'Middle Eastern (Arab, Israeli, Turkic, etc.)','Middle Eastern (Arab, Israeli, Turkic, etc.)',NULL),
	(43,9,'South Asian (Indian, Pakistani, Bangladeshi)','South Asian (Indian, Pakistani, Bangladeshi)',NULL),
	(44,9,'Native American/ Native Indian',NULL,NULL),
	(45,9,'Asian',NULL,NULL),
	(46,9,'African or Caribbean (including African-American)',NULL,NULL),
	(47,9,'Pacific Islander',NULL,NULL),
	(48,10,'Never smoked',NULL,NULL),
	(49,10,'Had smoked in the past, but not anymore','Had smoked in the past, but anymore',NULL),
	(50,10,'I smoke but I\'m trying to quit','I smoke but I\'m trying to quit',NULL),
	(51,10,'I smoke and I like it',NULL,NULL),
	(52,11,'Never',NULL,NULL),
	(53,11,'Yes, occassionally',NULL,NULL),
	(54,11,'Yes, often',NULL,NULL),
	(55,11,'Yes, daily',NULL,NULL),
	(56,12,'37 kg (81 lbs) or less','37 kg (81 lbs) or less',NULL),
	(57,12,'38 kg (84 lbs)','38 kg (84 lbs)',NULL),
	(58,12,'39 kg (86 lbs) ','39 kg (86 lbs) ',NULL),
	(59,12,'40 kg (88 lbs)','40 kg (88 lbs)',NULL),
	(61,13,'137 cm (4\' 6\")','137 cm (4\' 6\")',NULL),
	(63,14,'Blue',NULL,NULL),
	(64,14,'Brown',NULL,NULL),
	(65,14,'Gray',NULL,NULL),
	(66,14,'Green',NULL,NULL),
	(67,14,'Hazel',NULL,NULL),
	(68,15,'Black',NULL,NULL),
	(69,15,'Blonde',NULL,NULL),
	(70,15,'Brown',NULL,NULL),
	(71,15,'Gray',NULL,NULL),
	(72,15,'Red',NULL,NULL),
	(73,15,'Salt pepper',NULL,NULL),
	(74,15,'White',NULL,NULL),
	(75,15,'Well... bald!',NULL,NULL),
	(76,18,'Near the Sea','Near the Sea',NULL),
	(77,18,'In the City','In the City',NULL),
	(78,18,'Out in the Country','Out in the Country',NULL),
	(79,18,'In the Mountains','In the Mountains',NULL),
	(82,13,'138 cm','138 cm',NULL),
	(83,13,'139 cm','139 cm',NULL),
	(84,13,'140 cm (4\' 7\")','140 cm (4\' 7\")',NULL),
	(85,13,'141 cm  ','141 cm',NULL),
	(86,13,'142 cm (4\' 8\")','142 cm (4\' 8\")',NULL),
	(87,13,'143 cm ','143 cm ',NULL),
	(88,13,'144 cm','144 cm',NULL),
	(89,13,'145 cm (4\' 9\")','145 cm (4\' 9\")',NULL),
	(90,13,'146 cm ','146 cm ',NULL),
	(91,13,'147 cm','147 cm',NULL),
	(92,13,'148 cm (4\' 10\")','148 cm (4\' 10\")',NULL),
	(93,13,'149 cm','149 cm',NULL),
	(94,13,'150 cm (4\' 11\")','150 cm (4\' 11\")',NULL),
	(95,13,'151 cm','151 cm',NULL),
	(96,13,'152 cm','152 cm',NULL),
	(97,13,'153 cm (5\' 0\")','153 cm (5\' 0\")',NULL),
	(98,13,'154 cm','154 cm',NULL),
	(99,13,'155 cm (5\' 1\")','155 cm (5\' 1\")',NULL),
	(100,13,'156 cm','156 cm',NULL),
	(101,13,'157 cm','157 cm',NULL),
	(102,13,'158 cm (5\' 2\")','158 cm (5\' 2\")',NULL),
	(103,13,'159 cm','159 cm',NULL),
	(104,13,'160 cm (5\' 3\")','160 cm (5\' 3\")',NULL),
	(105,13,'161 cm','161 cm',NULL),
	(106,13,'162 cm','162 cm',NULL),
	(107,13,'163 cm (5\' 4\")','163 cm (5\' 4\")',NULL),
	(108,13,'164 cm','164 cm',NULL),
	(109,13,'165 cm (5\' 5\")','165 cm (5\' 5\")',NULL),
	(110,13,'166 cm','166 cm',NULL),
	(111,13,'167 cm','167 cm',NULL),
	(112,13,'168 cm (5\' 6\")','168 cm (5\' 6\")',NULL),
	(113,13,'169 cm','169 cm',NULL),
	(114,13,'170 cm (5\' 7\")','170 cm (5\' 7\")',NULL),
	(115,13,'171 cm','171 cm',NULL),
	(116,13,'172 cm','172 cm',NULL),
	(117,13,'173 cm (5\' 8\")','173 cm (5\' 8\")',NULL),
	(118,13,'174 cm','174 cm',NULL),
	(119,13,'175 cm','175 cm',NULL),
	(120,13,'176 cm (5\' 9\")','176 cm (5\' 9\")',NULL),
	(121,13,'177 cm','177 cm',NULL),
	(122,13,'178 cm (5\' 10\")','178 cm (5\' 10\")',NULL),
	(123,13,'179 cm','179 cm',NULL),
	(124,13,'180 cm (5\' 11\")','180 cm (5\' 11\")',NULL),
	(125,13,'181 cm','181 cm',NULL),
	(126,13,'182 cm','182 cm',NULL),
	(127,13,'183 cm (6\' 0\")','183 cm (6\' 0\")',NULL),
	(128,13,'184 cm','184 cm',NULL),
	(129,13,'185 cm','185 cm',NULL),
	(130,13,'186 cm (6\' 1\")','186 cm (6\' 1\")',NULL),
	(131,13,'187 cm','187 cm',NULL),
	(132,13,'188 cm (6\' 2\")','188 cm (6\' 2\")',NULL),
	(133,13,'189 cm','189 cm',NULL),
	(134,13,'190 cm','190 cm',NULL),
	(135,13,'191 cm (6\' 3\")','191 cm (6\' 3\")',NULL),
	(136,13,'192 cm','192 cm',NULL),
	(137,13,'193 cm (6\' 4\")','193 cm (6\' 4\")',NULL),
	(138,13,'194 cm','194 cm',NULL),
	(139,13,'195 cm','195 cm',NULL),
	(140,13,'196 cm (6\' 5\")','196 cm (6\' 5\")',NULL),
	(141,13,'197 cm','197 cm',NULL),
	(142,13,'198 cm (6\' 6\")','198 cm (6\' 6\")',NULL),
	(143,13,'199 cm','199 cm',NULL),
	(144,13,'200 cm','200 cm',NULL),
	(145,13,'201 cm (6\' 7\")','201 cm (6\' 7\")',NULL),
	(146,13,'202 cm','202 cm',NULL),
	(147,13,'203 cm (6\' 8\")','203 cm (6\' 8\")',NULL),
	(148,13,'204 cm','204 cm',NULL),
	(149,13,'205 cm','205 cm',NULL),
	(150,13,'206 cm (6\' 9\")','206 cm (6\' 9\")',NULL),
	(151,13,'207 cm','207 cm',NULL),
	(152,13,'208 cm (6\' 10\")','208 cm (6\' 10\")',NULL),
	(153,13,'209 cm','209 cm',NULL),
	(154,13,'210 cm','210 cm',NULL),
	(155,13,'211 cm (6\' 11\")','211 cm (6\' 11\")',NULL),
	(156,13,'212 cm','212 cm',NULL),
	(157,13,'213 cm (7\' 0\")','213 cm (7\' 0\")',NULL),
	(158,13,'214 cm','214 cm',NULL),
	(159,13,'215 cm','215 cm',NULL),
	(160,13,'216 cm (7\' 1\")','216 cm (7\' 1\")',NULL),
	(161,13,'217 cm','217 cm',NULL),
	(162,13,'218 cm (7\' 2\")','218 cm (7\' 2\")',NULL),
	(163,13,'219 cm','219 cm',NULL),
	(164,13,'220 cm (7\' 3\")','220 cm (7\' 3\")',NULL),
	(165,13,'221 cm','221 cm',NULL),
	(166,13,'222 cm','222 cm',NULL),
	(167,13,'223 cm (7\' 4\")','223 cm (7\' 4\")',NULL),
	(169,12,'41 kg (90 lbs) ','41 kg (90 lbs) ',NULL),
	(170,12,'42 kg (92 lbs)','42 kg (92 lbs)',NULL),
	(171,12,'43 kg (95 lbs)','43 kg (95 lbs)',NULL),
	(172,12,'44 kg (97 lbs)','44 kg (97 lbs)',NULL),
	(173,12,'45 kg (99 lbs) ','45 kg (99 lbs) ',NULL),
	(174,12,'46 kg (101 lbs)','46 kg (101 lbs)',NULL),
	(175,12,'47 kg (103 lbs)','47 kg (103 lbs)',NULL),
	(176,12,'48 kg (106 lbs) ','48 kg (106 lbs)',NULL),
	(177,12,'49 kg (108 lbs)','49 kg (108 lbs)',NULL),
	(178,12,'50 kg (110 lbs)  ','50 kg (110 lbs)',NULL),
	(179,12,'51 kg (112 lbs)','51 kg (112 lbs)',NULL),
	(180,12,'52 kg (114 lbs)','52 kg (114 lbs)',NULL),
	(181,12,'53 kg (117 lbs)','53 kg (117 lbs)',NULL),
	(182,12,'54 kg (119 lbs)','54 kg (119 lbs)',NULL),
	(183,12,'55 kg (121 lbs)','55 kg (121 lbs)',NULL),
	(184,12,'56 kg','56 kg',NULL),
	(185,12,'57 kg','57 kg',NULL),
	(186,12,'58 kg','58 kg',NULL),
	(187,12,'59 kg','59 kg',NULL),
	(188,12,'60 kg (132 lbs)','60 kg (132 lbs)',NULL),
	(189,12,'61 kg','61 kg',NULL),
	(190,12,'62 kg','62 kg',NULL),
	(191,12,'63 kg','63 kg',NULL),
	(192,12,'64 kg','64 kg',NULL),
	(193,12,'65 kg (143 lbs)','65 kg (143 lbs)',NULL),
	(194,12,'66 kg','66 kg',NULL),
	(195,12,'67 kg','67 kg',NULL),
	(196,12,'68 kg','68 kg',NULL),
	(197,12,'69 kg','69 kg',NULL),
	(198,12,'70 kg (154 lbs)','70 kg (154 lbs)',NULL),
	(199,12,'71 kg','71 kg',NULL),
	(200,12,'72 kg','72 kg',NULL),
	(201,12,'73 kg','73 kg',NULL),
	(202,12,'74 kg','74 kg',NULL),
	(203,12,'75 kg (165 lbs)','75 kg (165 lbs)',NULL),
	(204,12,'76 kg','76 kg',NULL),
	(205,12,'77 kg','77 kg',NULL),
	(206,12,'78 kg','78 kg',NULL),
	(207,12,'79 kg','79 kg',NULL),
	(208,12,'80 kg (176 lbs)','80 kg (176 lbs)',NULL),
	(209,12,'81 kg','81 kg',NULL),
	(210,12,'82 kg','82 kg',NULL),
	(211,12,'83 kg','83 kg',NULL),
	(212,12,'84 kg','84 kg',NULL),
	(213,12,'85 kg (187 lbs) ','85 kg (187 lbs)',NULL),
	(214,12,'86 kg','86 kg',NULL),
	(215,12,'87 kg','87 kg',NULL),
	(216,12,'88 kg','88 kg',NULL),
	(217,12,'89 kg','89 kg',NULL),
	(218,12,'90 kg (198 lbs)','90 kg (198 lbs)',NULL),
	(219,12,'91 kg','91 kg',NULL),
	(220,12,'92 kg','92 kg',NULL),
	(221,12,'93 kg','93 kg',NULL),
	(222,12,'94 kg','94 kg',NULL),
	(223,12,'95 kg (209 lbs)','95 kg (209 lbs)',NULL),
	(224,12,'96 kg','96 kg',NULL),
	(225,12,'97 kg','97 kg',NULL),
	(226,12,'98 kg','98 kg',NULL),
	(227,12,'99 kg','99 kg',NULL),
	(228,12,'100 kg (220 lbs)','100 kg (220 lbs)',NULL),
	(229,12,'101 kg','101 kg',NULL),
	(230,12,'102 kg','102 kg',NULL),
	(231,12,'103 kg','103  kg',NULL),
	(232,12,'104 kg','104 kg',NULL),
	(233,12,'105 kg (231 lbs)','105 kg (231 lbs)',NULL),
	(234,12,'106 kg','106 kg',NULL),
	(235,12,'107 kg','107 kg',NULL),
	(236,12,'108 kg','108 kg',NULL),
	(237,12,'109 kg','109 kg',NULL),
	(238,12,'110 kg (242 lbs)','110 kg (242 lbs)',NULL),
	(239,12,'111 kg','111 kg',NULL),
	(240,12,'112 kg','112 kg',NULL),
	(241,12,'113 kg','113 kg',NULL),
	(242,12,'114 kg','114 kg',NULL),
	(243,12,'115 kg','115 kg',NULL),
	(244,12,'116 kg','116 kg',NULL),
	(245,12,'117 kg','117 kg',NULL),
	(246,12,'118 kg','118 kg',NULL),
	(247,12,'119 kg','119 kg',NULL),
	(248,12,'120 kg','120 kg',NULL),
	(249,12,'121 kg','121 kg',NULL),
	(250,12,'122 kg','122 kg',NULL),
	(251,12,'123 kg','123 kg',NULL),
	(252,12,'124 kg','124 kg',NULL),
	(253,12,'125 kg','125 kg',NULL),
	(254,12,'126 kg','126 kg',NULL),
	(255,12,'127 kg','127 kg',NULL),
	(256,12,'128 kg','128 kg',NULL),
	(257,12,'129 kg','129 kg',NULL),
	(258,12,'130 kg','130 kg',NULL),
	(259,12,'131 kg','131 kg',NULL),
	(260,12,'132 kg','132 kg',NULL),
	(261,12,'133 kg','133 kg',NULL),
	(262,12,'134 kg','134 kg',NULL),
	(263,12,'135 kg','135 kg',NULL),
	(264,12,'136 kg','136 kg',NULL),
	(265,12,'137 kg','137 kg',NULL),
	(266,12,'138 kg','138 kg',NULL),
	(267,12,'139 kg','139 kg',NULL),
	(268,12,'140 kg','140 kg',NULL),
	(269,12,'141 kg','141 kg',NULL),
	(270,12,'142 kg','142 kg',NULL),
	(271,12,'143 kg','143 kg',NULL),
	(272,12,'144 kg','144 kg',NULL),
	(273,12,'145 kg','145 kg',NULL),
	(274,12,'146 kg','146 kg',NULL),
	(275,12,'147 kg','147 kg',NULL),
	(276,12,'148 kg','148 kg',NULL),
	(277,12,'149 kg','149 kg',NULL),
	(278,12,'150 kg','150 kg',NULL),
	(279,12,'151 kg','151 kg',NULL),
	(280,12,'152 kg','152 kg',NULL),
	(281,12,'153 kg','153 kg',NULL),
	(282,12,'154 kg','154 kg',NULL),
	(283,12,'155 kg','155 kg',NULL),
	(284,12,'156 kg','156 kg',NULL),
	(285,12,'157 kg','157 kg',NULL),
	(286,12,'158 kg','158 kg',NULL),
	(287,12,'159 kg','159 kg',NULL),
	(288,12,'160 kg','160 kg',NULL),
	(289,12,'161 kg','161 kg',NULL),
	(290,12,'162 kg','162 kg',NULL),
	(291,12,'163 kg','163 kg',NULL),
	(294,8,'Scientologist','Scientologist',NULL),
	(295,2,'Married','Married',NULL);

/*!40000 ALTER TABLE `desc_answer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table desc_question
# ------------------------------------------------------------

DROP TABLE IF EXISTS `desc_question`;

CREATE TABLE `desc_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `search_title` varchar(255) DEFAULT NULL,
  `desc_title` varchar(255) DEFAULT NULL,
  `factor_title` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `is_required` int(11) NOT NULL DEFAULT '1',
  `select_greather` int(11) NOT NULL DEFAULT '0',
  `other` varchar(255) DEFAULT NULL,
  `include_custom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `desc_question` WRITE;
/*!40000 ALTER TABLE `desc_question` DISABLE KEYS */;

INSERT INTO `desc_question` (`id`, `title`, `search_title`, `desc_title`, `factor_title`, `type`, `is_required`, `select_greather`, `other`, `include_custom`)
VALUES
	(1,'What is your birthday?','You\'re looking for someone aged:',NULL,'the \"age factor\" is:','age',1,0,NULL,NULL),
	(2,'What is your marital status?','You\'re looking for someone whose marital status is:','Marital Status','the \"marital status factor\" is:','radio',0,0,NULL,NULL),
	(3,'Do you have children?','You\'re looking for someone who has:','Children','the \"children factor\" is:','radio',0,0,NULL,NULL),
	(4,'What is your living situation?','You\'re looking for someone who:','Living Situation','the \"own vs. rent factor\" is:','radio',0,0,NULL,NULL),
	(5,'Do you want to have children in the future?','You\'re looking for someone who, in the future:','Future children','the \"want children factor\" is:','radio',0,0,NULL,NULL),
	(6,'What is your education?','You\'re looking for someone whose highest degree in education is:','Education','the \"education factor\" is:','radio',0,1,NULL,NULL),
	(7,'What is your annual income?','You\'re looking for someone with annual income of:','Yearly income','the \"income factor\" is:','radio',1,0,NULL,NULL),
	(8,'What is your religion?','Religion you want someone whose:','Religion','the \"partner\'s religion factor\" is:','radio',0,0,'Other, specify',NULL),
	(9,'What is your ethnicity?','Ethnicity you\'re looking for someone who\'s: ','Ethnicity','the \"ethnicity factor\" is:','radio',0,0,'Other, specify',NULL),
	(10,'Have you ever smoked?','You\'re looking for someone who:','Smoking','the \"smoking factor\" is:','radio',0,0,NULL,NULL),
	(11,'Do you drink?','Drinking you\'re looking for someone who:','Drinks','the \"drinking factor\" is:','radio',0,0,NULL,NULL),
	(12,'What is your weight?','Weight you\'re looking for someone whose weight is between:','Weight','the \"weight factor\" is:','select',0,0,NULL,'select weight'),
	(13,'What is your height?','Height you\'re looking for someone who\'s height is between:','Height','the \"height factor\" is:','select',1,0,NULL,'select height'),
	(14,'What is the color of your eyes?','Eye color you\'re looking for someone whose eye color is:','Eye\'s color','the \"eye color factor\" is:','radio',0,0,'Other, specify',NULL),
	(15,'What is the color of your hair?','Hair color you\'re looking for someone whose hair color is:','Hair color','the \"hair color factor\" is:','radio',0,0,'Other, specify',NULL),
	(16,'What is your native language?','How important it is that she / he speaks your native language? ',NULL,'the \"language factor\" is:','native_lang',1,0,'Can\'t find your native language on the list? Write it in.',NULL),
	(17,'What other languages do you speak?','How important it is that she / he speaks other languages? ',NULL,'the \"foreign language factor\" is:','other_langs',0,0,'Can\'t find it on the list? write it in the box, use comma (\",\") when necessary:',NULL),
	(18,'What is your personality','You\'re looking for someone who\'s personality is?','Personality','the \"energy factor\" is:','radio',0,0,NULL,NULL);

/*!40000 ALTER TABLE `desc_question` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dotpay_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dotpay_history`;

CREATE TABLE `dotpay_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `control` varchar(128) NOT NULL,
  `amount` decimal(7,2) NOT NULL,
  `original_amount` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `t_status` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `checksum` varchar(32) NOT NULL,
  `p_info` varchar(255) DEFAULT NULL,
  `p_email` varchar(255) DEFAULT NULL,
  `t_date` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `request_ip` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table feedback
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailbox` tinyint(4) NOT NULL DEFAULT '1',
  `member_id` int(11) DEFAULT NULL,
  `mail_from` varchar(255) DEFAULT NULL,
  `name_from` varchar(255) DEFAULT NULL,
  `mail_to` varchar(255) DEFAULT NULL,
  `name_to` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  `is_read` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_FI_1` (`member_id`),
  CONSTRAINT `feedback_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table feedback_template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feedback_template`;

CREATE TABLE `feedback_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `mail_from` varchar(255) DEFAULT NULL,
  `reply_to` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  `footer` text,
  `tags` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table flag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flag`;

CREATE TABLE `flag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `flagger_id` int(11) NOT NULL,
  `flag_category_id` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `is_history` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flag_FI_1` (`member_id`),
  KEY `flag_FI_2` (`flagger_id`),
  KEY `flag_FI_3` (`flag_category_id`),
  CONSTRAINT `flag_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `flag_FK_2` FOREIGN KEY (`flagger_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `flag_FK_3` FOREIGN KEY (`flag_category_id`) REFERENCES `flag_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table flag_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flag_category`;

CREATE TABLE `flag_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table geo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `geo`;

CREATE TABLE `geo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `dsg` varchar(4) NOT NULL,
  `country` varchar(4) NOT NULL,
  `adm1_id` int(11) DEFAULT NULL,
  `adm2_id` int(11) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `population` int(10) NOT NULL DEFAULT '0',
  `timezone` varchar(255) DEFAULT 'UTC',
  PRIMARY KEY (`id`),
  KEY `geo_FK_1` (`adm1_id`),
  KEY `geo_FK_2` (`adm2_id`),
  KEY `complex` (`country`,`dsg`,`adm1_id`,`adm2_id`,`name`),
  CONSTRAINT `geo_FK_1` FOREIGN KEY (`adm1_id`) REFERENCES `geo` (`id`) ON DELETE SET NULL,
  CONSTRAINT `geo_FK_2` FOREIGN KEY (`adm2_id`) REFERENCES `geo` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table geo_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `geo_details`;

CREATE TABLE `geo_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `member_info` text,
  `seo_info` text,
  PRIMARY KEY (`id`,`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table geo_photo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `geo_photo`;

CREATE TABLE `geo_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `geo_id` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `geo_photo_FK_1` (`geo_id`),
  CONSTRAINT `geo_photo_FK_1` FOREIGN KEY (`geo_id`) REFERENCES `geo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table homepage_member_photo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `homepage_member_photo`;

CREATE TABLE `homepage_member_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `gender` char(1) NOT NULL DEFAULT 'M',
  `homepages` varchar(255) DEFAULT NULL,
  `homepages_set` tinyint(4) DEFAULT NULL,
  `homepages_pos` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `homepage_member_photo_FI_1` (`member_id`),
  CONSTRAINT `homepage_member_photo_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table homepage_member_story
# ------------------------------------------------------------

DROP TABLE IF EXISTS `homepage_member_story`;

CREATE TABLE `homepage_member_story` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_stories` varchar(255) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `homepage_member_story_FK_1` (`cat_id`),
  CONSTRAINT `homepage_member_story_FK_1` FOREIGN KEY (`cat_id`) REFERENCES `catalogue` (`cat_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table hotlist
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hotlist`;

CREATE TABLE `hotlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_new` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `hotlist_FI_1` (`member_id`),
  KEY `hotlist_FI_2` (`profile_id`),
  CONSTRAINT `hotlist_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hotlist_FK_2` FOREIGN KEY (`profile_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ip_blocks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ip_blocks`;

CREATE TABLE `ip_blocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_poly` polygon NOT NULL,
  `ip_from` int(10) unsigned NOT NULL,
  `ip_to` int(10) unsigned NOT NULL,
  `locid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  SPATIAL KEY `ip_poly` (`ip_poly`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table ip_country
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ip_country`;

CREATE TABLE `ip_country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` char(2) NOT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country_code` (`country_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table ip_location
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ip_location`;

CREATE TABLE `ip_location` (
  `id` int(10) unsigned NOT NULL,
  `country_code` char(2) DEFAULT NULL,
  `city_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table ipblock
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ipblock`;

CREATE TABLE `ipblock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(255) DEFAULT NULL,
  `item_type` int(1) DEFAULT '0',
  `netmask` int(2) DEFAULT '24',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_item_type` (`item`,`item_type`),
  KEY `item_type` (`item_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ipn_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ipn_history`;

CREATE TABLE `ipn_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parameters` text,
  `request_ip` bigint(20) DEFAULT NULL,
  `txn_type` varchar(255) DEFAULT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `subscr_id` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `paypal_response` varchar(8) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `txn_created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ipwatch
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ipwatch`;

CREATE TABLE `ipwatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` bigint(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table link
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link`;

CREATE TABLE `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` char(40) NOT NULL,
  `login_as` int(11) DEFAULT NULL,
  `uri` varchar(255) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `login_expires_at` datetime DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `hit_count` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_status_id` int(11) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `new_password` char(40) DEFAULT NULL,
  `must_change_pwd` int(11) NOT NULL DEFAULT '0',
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tmp_email` varchar(255) NOT NULL,
  `sex` char(1) NOT NULL,
  `looking_for` char(1) NOT NULL,
  `reviewed_by_id` int(11) DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `is_starred` int(11) NOT NULL DEFAULT '0',
  `country` varchar(4) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `language` varchar(3) NOT NULL,
  `birthday` date DEFAULT NULL,
  `dont_display_zodiac` int(11) NOT NULL DEFAULT '0',
  `us_citizen` int(11) DEFAULT NULL,
  `email_notifications` tinyint(4) DEFAULT NULL,
  `dont_use_photos` int(11) NOT NULL DEFAULT '0',
  `contact_only_full_members` int(11) NOT NULL DEFAULT '0',
  `youtube_vid` varchar(20) DEFAULT NULL,
  `essay_headline` varchar(255) DEFAULT NULL,
  `essay_introduction` text,
  `subscription_id` int(11) NOT NULL,
  `member_counter_id` int(11) NOT NULL,
  `last_status_change` datetime DEFAULT NULL,
  `last_flagged` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `main_photo_id` int(11) DEFAULT NULL,
  `has_email_confirmation` int(11) NOT NULL DEFAULT '0',
  `last_activity_notification` datetime DEFAULT NULL,
  `public_search` int(11) NOT NULL DEFAULT '0',
  `last_ip` bigint(20) DEFAULT NULL,
  `dashboard_msg` int(1) DEFAULT '0',
  `original_first_name` varchar(80) DEFAULT NULL,
  `original_last_name` varchar(80) NOT NULL,
  `last_subscription_change` datetime DEFAULT NULL,
  `adm1_id` int(11) DEFAULT NULL,
  `adm2_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `last_photo_upload_at` datetime DEFAULT NULL,
  `private_dating` int(11) NOT NULL DEFAULT '0',
  `registration_ip` bigint(20) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `millionaire` int(11) DEFAULT '0',
  `last_payment_state` varchar(50) DEFAULT NULL,
  `catalog_id` int(11) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `hide_visits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `member_FK_1` (`member_status_id`),
  KEY `member_FK_2` (`reviewed_by_id`),
  KEY `member_FK_3` (`adm1_id`),
  KEY `member_FK_4` (`adm2_id`),
  KEY `member_FK_5` (`city_id`),
  KEY `member_FK_6` (`main_photo_id`),
  KEY `member_FK_7` (`subscription_id`),
  KEY `member_FK_8` (`member_counter_id`),
  KEY `last_login` (`last_login`),
  KEY `created_at` (`created_at`),
  KEY `Last_IP` (`last_ip`),
  KEY `Reg_IP` (`registration_ip`),
  CONSTRAINT `member_FK_1` FOREIGN KEY (`member_status_id`) REFERENCES `member_status` (`id`),
  CONSTRAINT `member_FK_2` FOREIGN KEY (`reviewed_by_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `member_FK_3` FOREIGN KEY (`adm1_id`) REFERENCES `geo` (`id`) ON DELETE SET NULL,
  CONSTRAINT `member_FK_4` FOREIGN KEY (`adm2_id`) REFERENCES `geo` (`id`) ON DELETE SET NULL,
  CONSTRAINT `member_FK_5` FOREIGN KEY (`city_id`) REFERENCES `geo` (`id`) ON DELETE SET NULL,
  CONSTRAINT `member_FK_6` FOREIGN KEY (`main_photo_id`) REFERENCES `member_photo` (`id`) ON DELETE SET NULL,
  CONSTRAINT `member_FK_7` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`),
  CONSTRAINT `member_FK_8` FOREIGN KEY (`member_counter_id`) REFERENCES `member_counter` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_counter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_counter`;

CREATE TABLE `member_counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `current_flags` int(11) NOT NULL DEFAULT '0',
  `total_flags` int(11) NOT NULL DEFAULT '0',
  `sent_flags` int(11) NOT NULL DEFAULT '0',
  `sent_winks` int(11) NOT NULL DEFAULT '0',
  `received_winks` int(11) NOT NULL DEFAULT '0',
  `sent_messages` int(11) NOT NULL DEFAULT '0',
  `received_messages` int(11) NOT NULL DEFAULT '0',
  `reply_messages` int(11) NOT NULL DEFAULT '0',
  `unsuspensions` int(11) NOT NULL DEFAULT '0',
  `assistant_contacts` int(11) NOT NULL DEFAULT '0',
  `profile_views` int(11) NOT NULL DEFAULT '0',
  `made_profile_views` int(11) NOT NULL DEFAULT '0',
  `hotlist` int(11) NOT NULL DEFAULT '0',
  `on_others_hotlist` int(11) NOT NULL DEFAULT '0',
  `read_messages` int(11) NOT NULL DEFAULT '0',
  `sent_winks_day` int(11) NOT NULL DEFAULT '0',
  `received_winks_day` int(11) NOT NULL DEFAULT '0',
  `read_messages_day` int(11) NOT NULL DEFAULT '0',
  `sent_messages_day` int(11) NOT NULL DEFAULT '0',
  `reply_messages_day` int(11) NOT NULL DEFAULT '0',
  `assistant_contacts_day` int(11) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  `deactivation_counter` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_desc_answer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_desc_answer`;

CREATE TABLE `member_desc_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `desc_question_id` int(11) NOT NULL,
  `desc_answer_id` int(11) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `custom` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_answer` (`member_id`,`desc_question_id`),
  KEY `member_desc_answer_FI_1` (`member_id`),
  KEY `member_desc_answer_FI_2` (`desc_question_id`),
  CONSTRAINT `member_desc_answer_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `member_desc_answer_FK_2` FOREIGN KEY (`desc_question_id`) REFERENCES `desc_question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_login_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_login_history`;

CREATE TABLE `member_login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `ip` bigint(20) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_login_history_FI_1` (`member_id`),
  KEY `IP` (`ip`),
  CONSTRAINT `member_login_history_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_match
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_match`;

CREATE TABLE `member_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member1_id` int(11) NOT NULL,
  `member2_id` int(11) NOT NULL,
  `pct` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_match` (`member1_id`,`member2_id`),
  KEY `member_match_FI_2` (`member2_id`),
  CONSTRAINT `member_match_FK_1` FOREIGN KEY (`member1_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `member_match_FK_2` FOREIGN KEY (`member2_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_note
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_note`;

CREATE TABLE `member_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_note_FI_1` (`member_id`),
  KEY `member_note_FI_2` (`user_id`),
  CONSTRAINT `member_note_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `member_note_FK_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_notification
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_notification`;

CREATE TABLE `member_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_notification_FI_1` (`member_id`),
  CONSTRAINT `member_notification_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_payment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_payment`;

CREATE TABLE `member_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `payment_type` varchar(20) NOT NULL,
  `member_subscription_id` int(11) DEFAULT NULL,
  `payment_processor` varchar(10) DEFAULT NULL,
  `amount` decimal(7,2) NOT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'pending',
  `extra_status` varchar(100) DEFAULT NULL,
  `pp_ref` varchar(255) DEFAULT NULL,
  `details` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_payment_FI_1` (`member_id`),
  KEY `member_payment_FI_2` (`member_subscription_id`),
  CONSTRAINT `member_payment_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `member_payment_FK_2` FOREIGN KEY (`member_subscription_id`) REFERENCES `member_subscription` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_photo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_photo`;

CREATE TABLE `member_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `cropped` varchar(255) DEFAULT NULL,
  `is_main` int(11) NOT NULL DEFAULT '0',
  `auth` char(1) DEFAULT NULL,
  `is_private` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `member_photo_FI_1` (`member_id`),
  CONSTRAINT `member_photo_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_rate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_rate`;

CREATE TABLE `member_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `rater_id` int(11) NOT NULL,
  `rate` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_rate_FI_2` (`rater_id`),
  KEY `rate` (`rate`),
  KEY `member_rate_FI_1` (`member_id`),
  CONSTRAINT `member_rate_FK_2` FOREIGN KEY (`rater_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_status`;

CREATE TABLE `member_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `member_status` WRITE;
/*!40000 ALTER TABLE `member_status` DISABLE KEYS */;

INSERT INTO `member_status` (`id`, `title`)
VALUES
	(1,'Active'),
	(2,'Suspended'),
	(3,'Canceled'),
	(4,'Abandoned'),
	(5,'Deactivated'),
	(6,'Suspended - Flags'),
	(7,'Canceled by Member'),
	(8,'Pending'),
	(9,'Denied'),
	(10,'Suspended - Flags ( Confirmed )'),
	(11,'Deactivated - Auto'),
	(12,'Suspended - FV required');

/*!40000 ALTER TABLE `member_status` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table member_status_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_status_history`;

CREATE TABLE `member_status_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `member_status_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `from_status_id` int(11) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_status_history_FI_1` (`member_id`),
  KEY `member_status_history_FI_2` (`member_status_id`),
  CONSTRAINT `member_status_history_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `member_status_history_FK_2` FOREIGN KEY (`member_status_id`) REFERENCES `member_status` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_story
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_story`;

CREATE TABLE `member_story` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `link_name` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `stock_photo_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `summary` varchar(255) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `member_story_FI_1` (`stock_photo_id`),
  CONSTRAINT `member_story_FK_1` FOREIGN KEY (`stock_photo_id`) REFERENCES `stock_photo` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table member_subscription
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_subscription`;

CREATE TABLE `member_subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `subscription_id` int(11) DEFAULT NULL,
  `gift_by` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'pending',
  `last_status_change_at` datetime DEFAULT NULL,
  `period` tinyint(4) NOT NULL,
  `period_type` char(1) NOT NULL,
  `eot_at` datetime DEFAULT NULL,
  `pp_ref` varchar(255) DEFAULT NULL,
  `details` text,
  `next_amount` decimal(7,2) DEFAULT NULL,
  `next_currency` varchar(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `effective_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_subscription_FI_1` (`member_id`),
  KEY `member_subscription_FI_2` (`subscription_id`),
  CONSTRAINT `member_subscription_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `member_subscription_FK_2` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_reviewed` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `body` text,
  `type` int(11) NOT NULL DEFAULT '1',
  `unread` int(11) NOT NULL DEFAULT '1',
  `sender_deleted_at` datetime DEFAULT NULL,
  `recipient_deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `predefined_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `message_FK_1` (`sender_id`),
  KEY `message_FK_2` (`recipient_id`),
  KEY `message_FK_3` (`thread_id`),
  CONSTRAINT `message_FK_1` FOREIGN KEY (`sender_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `message_FK_2` FOREIGN KEY (`recipient_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `message_FK_3` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table msg_collection
# ------------------------------------------------------------

DROP TABLE IF EXISTS `msg_collection`;

CREATE TABLE `msg_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_collection_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `msg_collection_FI_1` (`trans_collection_id`),
  CONSTRAINT `msg_collection_FK_1` FOREIGN KEY (`trans_collection_id`) REFERENCES `trans_collection` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table notification
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `send_from` varchar(255) DEFAULT NULL,
  `send_to` varchar(255) DEFAULT NULL,
  `reply_to` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  `footer` text,
  `id` int(11) NOT NULL,
  `mail_config` varchar(255) DEFAULT NULL,
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `trigger_name` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '0',
  `to_admins` int(11) NOT NULL DEFAULT '0',
  `days` int(11) DEFAULT NULL,
  `whn` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`,`cat_id`),
  KEY `notification_FK_1` (`cat_id`),
  CONSTRAINT `notification_FK_1` FOREIGN KEY (`cat_id`) REFERENCES `catalogue` (`cat_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table notification_event
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notification_event`;

CREATE TABLE `notification_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_id` int(11) DEFAULT NULL,
  `event` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_notify` (`notification_id`,`event`),
  KEY `notification_event_FI_1` (`notification_id`),
  KEY `event` (`event`),
  CONSTRAINT `notification_event_FK_1` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table open_privacy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `open_privacy`;

CREATE TABLE `open_privacy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `member2profile` (`member_id`,`profile_id`),
  KEY `open_privacy_FI_2` (`profile_id`),
  CONSTRAINT `open_privacy_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `open_privacy_FK_2` FOREIGN KEY (`profile_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table photo_exif_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `photo_exif_info`;

CREATE TABLE `photo_exif_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_id` int(11) NOT NULL,
  `exif_info` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `photo_id` (`photo_id`),
  CONSTRAINT `photo_exif_info_fk` FOREIGN KEY (`photo_id`) REFERENCES `member_photo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pr_mail_message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pr_mail_message`;

CREATE TABLE `pr_mail_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_config` varchar(255) DEFAULT NULL,
  `sender` text,
  `mail_from` text,
  `recipients` text,
  `cc` text,
  `bcc` text,
  `subject` text,
  `body` text,
  `status` varchar(10) NOT NULL DEFAULT 'pending',
  `status_message` text,
  `notification_id` int(11) NOT NULL,
  `notification_cat` int(11) NOT NULL,
  `hash` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pr_mail_sum
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pr_mail_sum`;

CREATE TABLE `pr_mail_sum` (
  `mail_config` varchar(255) NOT NULL,
  `cnt` int(11) NOT NULL,
  `at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table predefined_message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `predefined_message`;

CREATE TABLE `predefined_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` text,
  `body` text,
  `sex` char(1) NOT NULL,
  `looking_for` char(1) NOT NULL,
  `catalog_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `predefined_message_FK_1` (`catalog_id`),
  CONSTRAINT `predefined_message_FK_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalogue` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table private_photo_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `private_photo_permission`;

CREATE TABLE `private_photo_permission` (
  `member_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `status` enum('A','R') NOT NULL,
  `type` enum('P','R') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `is_new` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`member_id`,`profile_id`,`type`),
  KEY `private_photo_permission_FI_2` (`profile_id`),
  CONSTRAINT `private_photo_permission_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `private_photo_permission_FK_2` FOREIGN KEY (`profile_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table profile_view
# ------------------------------------------------------------

DROP TABLE IF EXISTS `profile_view`;

CREATE TABLE `profile_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_new` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `profile_view_FI_1` (`member_id`),
  KEY `profile_view_FI_2` (`profile_id`),
  CONSTRAINT `profile_view_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `profile_view_FK_2` FOREIGN KEY (`profile_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table schema_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `schema_info`;

CREATE TABLE `schema_info` (
  `version` int(11) NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `schema_info` WRITE;
/*!40000 ALTER TABLE `schema_info` DISABLE KEYS */;

INSERT INTO `schema_info` (`version`)
VALUES
	(94);

/*!40000 ALTER TABLE `schema_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table search_crit_desc
# ------------------------------------------------------------

DROP TABLE IF EXISTS `search_crit_desc`;

CREATE TABLE `search_crit_desc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc_question_id` int(11) NOT NULL,
  `desc_answers` text,
  `match_weight` tinyint(4) NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_answer` (`member_id`,`desc_question_id`),
  KEY `search_crit_desc_FI_2` (`desc_question_id`),
  KEY `search_crit_desc_FI_1` (`member_id`),
  CONSTRAINT `search_crit_desc_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `search_crit_desc_FK_2` FOREIGN KEY (`desc_question_id`) REFERENCES `desc_question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table session_storage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `session_storage`;

CREATE TABLE `session_storage` (
  `sess_id` varchar(255) NOT NULL,
  `sess_data` text NOT NULL,
  `sess_time` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sess_id` (`sess_id`),
  UNIQUE KEY `user_sess` (`user_id`,`sess_id`),
  KEY `sess_time` (`sess_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sf_setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sf_setting`;

CREATE TABLE `sf_setting` (
  `cat_id` int(11) NOT NULL DEFAULT '1',
  `env` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `value` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `updated_user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `var_type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cat_id`,`env`,`name`),
  CONSTRAINT `sf_setting_FK_1` FOREIGN KEY (`cat_id`) REFERENCES `catalogue` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `sf_setting` WRITE;
/*!40000 ALTER TABLE `sf_setting` DISABLE KEYS */;

INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
VALUES
	(1,'all','deactivation_counter','0','Number of signin before close registration',NULL,NULL,NULL,NULL,NULL),
	(1,'all','deactivation_days','124','Member deactivation - Days after login reminder notification is sent',NULL,NULL,NULL,'2011-03-07 01:12:26',NULL),
	(1,'all','enable_gifts','0','Gifts',NULL,NULL,NULL,'2009-11-24 23:02:19','bool'),
	(1,'all','enable_upgrade_or_close','','Comma separated orientations, to whom upgrade or close is enabled',NULL,NULL,NULL,NULL,NULL),
	(1,'all','essay_headline_max','60','Essay headline max chars',NULL,NULL,NULL,NULL,NULL),
	(1,'all','essay_headline_min','3','Essay headline min chars',NULL,NULL,NULL,NULL,NULL),
	(1,'all','essay_introduction_max','2500','Essay introduction max chars',NULL,NULL,NULL,'2009-10-12 01:56:49',NULL),
	(1,'all','essay_introduction_min','12','Essay introduction min chars',NULL,NULL,NULL,NULL,NULL),
	(1,'all','extend_eot','10','Days after the actual EOT, when user subscription is downgraded',NULL,NULL,NULL,'2012-02-06 18:04:52',NULL),
	(1,'all','flags_comment_field','1','Flags - Optional comment field',NULL,NULL,NULL,'2009-01-12 05:45:34','bool'),
	(1,'all','flags_num_auto_suspension','3','Flags - Flags for auto-suspension',NULL,NULL,NULL,'2010-03-08 01:39:34',NULL),
	(1,'all','imbra_disable','1','Disable IMBRA',NULL,NULL,NULL,NULL,'bool'),
	(1,'all','immediately_subscription_upgrade','1','Immeditaly upgrade member\'s subscription ( non-prepaid )',NULL,NULL,NULL,NULL,'bool'),
	(1,'all','man_should_pay','1','Force man to pay to send and recive messges',NULL,NULL,NULL,'2010-02-28 20:45:09','bool'),
	(1,'all','member_notification_lifetime','14000','Member notification balloon lifetime ( in miliseconds )',NULL,NULL,NULL,'2012-02-13 02:35:09',NULL),
	(1,'all','notification_scam_flags','3','Notifications - Scam Flags',NULL,NULL,NULL,NULL,NULL),
	(1,'all','notification_spam_msgs','12','Notifications - Spam messages',NULL,NULL,NULL,'2012-07-09 13:59:10',NULL),
	(1,'all','post_your_story_max','2500','Post your story max chars',NULL,NULL,NULL,'2009-10-12 01:56:59',NULL),
	(1,'all','post_your_story_min','50','Post your story min chars',NULL,NULL,NULL,NULL,NULL),
	(1,'all','private_photo_requests','48','Private photo requests per day',NULL,NULL,NULL,'2012-12-31 12:11:32',NULL),
	(1,'all','profile_display_video','0','Profile - Display videos',NULL,NULL,NULL,'2010-05-02 18:22:35','bool'),
	(1,'all','profile_max_photos','8','Profile - Num photos on profile',NULL,NULL,NULL,'2010-08-12 04:01:05',NULL),
	(1,'all','profile_max_private_photos','8','Profile - Num private photos on profile',NULL,NULL,NULL,'2009-01-22 17:43:55',NULL),
	(1,'all','profile_num_recent_activities','9','Profile - Num recent activities',NULL,NULL,NULL,'2010-01-22 02:23:13',NULL),
	(1,'all','search_default_kilometers_miles','km','Search - Default value of radius metric ( valid values - \"km\" or \"mil\")',NULL,NULL,NULL,NULL,NULL),
	(1,'all','search_default_radius_distance','100','Search - Default value of radius input box',NULL,NULL,NULL,'2010-05-01 16:36:25',NULL),
	(1,'all','search_rows_custom','4','Search - Custom rows per page',NULL,NULL,NULL,'2011-12-28 01:22:22',NULL),
	(1,'all','search_rows_keyword','4','Search - by Keyword rows per page',NULL,NULL,NULL,'2011-12-28 01:22:31',NULL),
	(1,'all','search_rows_last_login','4','Search - Last Login rows per page',NULL,NULL,NULL,'2011-12-28 01:21:28',NULL),
	(1,'all','search_rows_matches','4','Search - Matches rows per page',NULL,NULL,NULL,'2011-12-28 01:21:38',NULL),
	(1,'all','search_rows_most_recent','4','Search - Most Recent rows per page',NULL,NULL,NULL,'2011-12-28 01:21:45',NULL),
	(1,'all','search_rows_public','3','Search - Public rows per page',NULL,NULL,NULL,'2010-08-06 12:49:00',NULL),
	(1,'all','search_rows_reverse','4','Search - Reverse rows per page',NULL,NULL,NULL,'2011-12-28 01:21:54',NULL),
	(1,'all','timeout_warning','3','Timeout warning before session expire in minutes (values 1 .. 29)',NULL,NULL,NULL,NULL,NULL),
	(2,'all','deactivation_counter','0','Number of signin before close registration',NULL,NULL,NULL,NULL,NULL),
	(2,'all','deactivation_days','124','Member deactivation - Days after login reminder notification is sent',NULL,NULL,NULL,'2011-03-07 01:12:26',NULL),
	(2,'all','enable_gifts','0','Gifts',NULL,NULL,NULL,'2009-11-24 23:02:19','bool'),
	(2,'all','enable_upgrade_or_close','','Comma separated orientations, to whom upgrade or close is enabled',NULL,NULL,NULL,NULL,NULL),
	(2,'all','essay_headline_max','60','Essay headline max chars',NULL,NULL,NULL,NULL,NULL),
	(2,'all','essay_headline_min','3','Essay headline min chars',NULL,NULL,NULL,NULL,NULL),
	(2,'all','essay_introduction_max','2500','Essay introduction max chars',NULL,NULL,NULL,'2009-10-12 01:56:49',NULL),
	(2,'all','essay_introduction_min','12','Essay introduction min chars',NULL,NULL,NULL,NULL,NULL),
	(2,'all','extend_eot','1','Days after the actual EOT, when user subscription is downgraded',NULL,NULL,NULL,'2010-06-22 06:23:23',NULL),
	(2,'all','flags_comment_field','1','Flags - Optional comment field',NULL,NULL,NULL,'2009-01-12 05:45:34','bool'),
	(2,'all','flags_num_auto_suspension','3','Flags - Flags for auto-suspension',NULL,NULL,NULL,'2010-03-08 01:39:34',NULL),
	(2,'all','imbra_disable','1','Disable IMBRA',NULL,NULL,NULL,NULL,'bool'),
	(2,'all','immediately_subscription_upgrade','1','Immeditaly upgrade member\'s subscription ( non-prepaid )',NULL,NULL,NULL,NULL,'bool'),
	(2,'all','man_should_pay','1','Force man to pay to send and recive messges',NULL,NULL,NULL,'2010-02-28 20:45:09','bool'),
	(2,'all','member_notification_lifetime','12000','Member notification balloon lifetime ( in miliseconds )',NULL,NULL,NULL,'2010-08-06 09:56:22',NULL),
	(2,'all','notification_scam_flags','3','Notifications - Scam Flags',NULL,NULL,NULL,NULL,NULL),
	(2,'all','notification_spam_msgs','12','Notifications - Spam messages',NULL,NULL,NULL,'2012-07-09 13:59:30',NULL),
	(2,'all','post_your_story_max','2500','Post your story max chars',NULL,NULL,NULL,'2009-10-12 01:56:59',NULL),
	(2,'all','post_your_story_min','50','Post your story min chars',NULL,NULL,NULL,NULL,NULL),
	(2,'all','private_photo_requests','48','Private photo requests per day',NULL,NULL,NULL,'2012-12-31 12:11:48',NULL),
	(2,'all','profile_display_video','0','Profile - Display videos',NULL,NULL,NULL,'2010-05-02 18:22:35','bool'),
	(2,'all','profile_max_photos','8','Profile - Num photos on profile',NULL,NULL,NULL,'2010-08-12 04:01:05',NULL),
	(2,'all','profile_max_private_photos','8','Profile - Num private photos on profile',NULL,NULL,NULL,'2009-01-22 17:43:55',NULL),
	(2,'all','profile_num_recent_activities','9','Profile - Num recent activities',NULL,NULL,NULL,'2010-01-22 02:23:13',NULL),
	(2,'all','search_default_kilometers_miles','km','Search - Default value of radius metric ( valid values - \"km\" or \"mil\")',NULL,NULL,NULL,NULL,NULL),
	(2,'all','search_default_radius_distance','100','Search - Default value of radius input box',NULL,NULL,NULL,'2010-05-01 16:36:25',NULL),
	(2,'all','search_rows_custom','4','Search - Custom rows per page',NULL,NULL,NULL,'2011-12-28 01:40:08',NULL),
	(2,'all','search_rows_keyword','4','Search - by Keyword rows per page',NULL,NULL,NULL,'2011-12-28 01:40:00',NULL),
	(2,'all','search_rows_last_login','4','Search - Last Login rows per page',NULL,NULL,NULL,'2011-12-28 01:40:15',NULL),
	(2,'all','search_rows_matches','4','Search - Matches rows per page',NULL,NULL,NULL,'2011-12-28 01:40:22',NULL),
	(2,'all','search_rows_most_recent','4','Search - Most Recent rows per page',NULL,NULL,NULL,'2011-12-28 01:40:33',NULL),
	(2,'all','search_rows_public','3','Search - Public rows per page',NULL,NULL,NULL,'2010-08-06 12:49:00',NULL),
	(2,'all','search_rows_reverse','4','Search - Reverse rows per page',NULL,NULL,NULL,'2011-12-28 01:40:42',NULL),
	(2,'all','timeout_warning','3','Timeout warning before session expire in minutes (values 1 .. 29)',NULL,NULL,NULL,NULL,NULL),
	(14,'all','deactivation_counter','0','Number of signin before close registration',NULL,NULL,NULL,NULL,NULL),
	(14,'all','deactivation_days','124','Member deactivation - Days after login reminder notification is sent',NULL,NULL,NULL,'2011-03-07 01:12:26',NULL),
	(14,'all','enable_gifts','0','Gifts',NULL,NULL,NULL,'2009-11-24 23:02:19','bool'),
	(14,'all','enable_upgrade_or_close','','Comma separated orientations, to whom upgrade or close is enabled',NULL,NULL,NULL,NULL,NULL),
	(14,'all','essay_headline_max','60','Essay headline max chars',NULL,NULL,NULL,NULL,NULL),
	(14,'all','essay_headline_min','3','Essay headline min chars',NULL,NULL,NULL,NULL,NULL),
	(14,'all','essay_introduction_max','2500','Essay introduction max chars',NULL,NULL,NULL,'2009-10-12 01:56:49',NULL),
	(14,'all','essay_introduction_min','12','Essay introduction min chars',NULL,NULL,NULL,NULL,NULL),
	(14,'all','extend_eot','1','Days after the actual EOT, when user subscription is downgraded',NULL,NULL,NULL,'2010-06-22 06:23:23',NULL),
	(14,'all','flags_comment_field','1','Flags - Optional comment field',NULL,NULL,NULL,'2009-01-12 05:45:34','bool'),
	(14,'all','flags_num_auto_suspension','3','Flags - Flags for auto-suspension',NULL,NULL,NULL,'2010-03-08 01:39:34',NULL),
	(14,'all','imbra_disable','1','Disable IMBRA',NULL,NULL,NULL,NULL,'bool'),
	(14,'all','immediately_subscription_upgrade','1','Immeditaly upgrade member\'s subscription ( non-prepaid )',NULL,NULL,NULL,NULL,'bool'),
	(14,'all','man_should_pay','1','Force man to pay to send and recive messges',NULL,NULL,NULL,'2010-02-28 20:45:09','bool'),
	(14,'all','member_notification_lifetime','12000','Member notification balloon lifetime ( in miliseconds )',NULL,NULL,NULL,'2010-08-06 09:56:22',NULL),
	(14,'all','notification_scam_flags','3','Notifications - Scam Flags',NULL,NULL,NULL,NULL,NULL),
	(14,'all','notification_spam_msgs','12','Notifications - Spam messages',NULL,NULL,NULL,'2012-07-09 13:59:49',NULL),
	(14,'all','post_your_story_max','2500','Post your story max chars',NULL,NULL,NULL,'2009-10-12 01:56:59',NULL),
	(14,'all','post_your_story_min','50','Post your story min chars',NULL,NULL,NULL,NULL,NULL),
	(14,'all','private_photo_requests','72','Private photo requests per day',NULL,NULL,NULL,NULL,NULL),
	(14,'all','profile_display_video','0','Profile - Display videos',NULL,NULL,NULL,'2010-05-02 18:22:35','bool'),
	(14,'all','profile_max_photos','8','Profile - Num photos on profile',NULL,NULL,NULL,'2010-08-12 04:01:05',NULL),
	(14,'all','profile_max_private_photos','8','Profile - Num private photos on profile',NULL,NULL,NULL,'2009-01-22 17:43:55',NULL),
	(14,'all','profile_num_recent_activities','9','Profile - Num recent activities',NULL,NULL,NULL,'2010-01-22 02:23:13',NULL),
	(14,'all','search_default_kilometers_miles','km','Search - Default value of radius metric ( valid values - \"km\" or \"mil\")',NULL,NULL,NULL,NULL,NULL),
	(14,'all','search_default_radius_distance','100','Search - Default value of radius input box',NULL,NULL,NULL,'2010-05-01 16:36:25',NULL),
	(14,'all','search_rows_custom','6','Search - Custom rows per page',NULL,NULL,NULL,'2010-02-27 18:31:13',NULL),
	(14,'all','search_rows_keyword','6','Search - by Keyword rows per page',NULL,NULL,NULL,'2010-02-27 18:33:44',NULL),
	(14,'all','search_rows_last_login','6','Search - Last Login rows per page',NULL,NULL,NULL,NULL,NULL),
	(14,'all','search_rows_matches','6','Search - Matches rows per page',NULL,NULL,NULL,'2009-12-11 18:25:38',NULL),
	(14,'all','search_rows_most_recent','6','Search - Most Recent rows per page',NULL,NULL,NULL,'2010-08-06 12:48:47',NULL),
	(14,'all','search_rows_public','3','Search - Public rows per page',NULL,NULL,NULL,'2010-08-06 12:49:00',NULL),
	(14,'all','search_rows_reverse','6','Search - Reverse rows per page',NULL,NULL,NULL,'2009-12-11 18:25:55',NULL),
	(14,'all','timeout_warning','3','Timeout warning before session expire in minutes (values 1 .. 29)',NULL,NULL,NULL,NULL,NULL),
	(15,'all','deactivation_counter','0','Number of signin before close registration',NULL,NULL,NULL,NULL,NULL),
	(15,'all','deactivation_days','124','Member deactivation - Days after login reminder notification is sent',NULL,NULL,NULL,'2011-03-07 01:12:26',NULL),
	(15,'all','enable_gifts','0','Gifts',NULL,NULL,NULL,'2009-11-24 23:02:19','bool'),
	(15,'all','enable_upgrade_or_close','','Comma separated orientations, to whom upgrade or close is enabled',NULL,NULL,NULL,NULL,NULL),
	(15,'all','essay_headline_max','60','Essay headline max chars',NULL,NULL,NULL,NULL,NULL),
	(15,'all','essay_headline_min','3','Essay headline min chars',NULL,NULL,NULL,NULL,NULL),
	(15,'all','essay_introduction_max','2500','Essay introduction max chars',NULL,NULL,NULL,'2009-10-12 01:56:49',NULL),
	(15,'all','essay_introduction_min','12','Essay introduction min chars',NULL,NULL,NULL,NULL,NULL),
	(15,'all','extend_eot','1','Days after the actual EOT, when user subscription is downgraded',NULL,NULL,NULL,'2010-06-22 06:23:23',NULL),
	(15,'all','flags_comment_field','1','Flags - Optional comment field',NULL,NULL,NULL,'2009-01-12 05:45:34','bool'),
	(15,'all','flags_num_auto_suspension','3','Flags - Flags for auto-suspension',NULL,NULL,NULL,'2010-03-08 01:39:34',NULL),
	(15,'all','imbra_disable','1','Disable IMBRA',NULL,NULL,NULL,NULL,'bool'),
	(15,'all','immediately_subscription_upgrade','1','Immeditaly upgrade member\'s subscription ( non-prepaid )',NULL,NULL,NULL,NULL,'bool'),
	(15,'all','man_should_pay','1','Force man to pay to send and recive messges',NULL,NULL,NULL,'2010-02-28 20:45:09','bool'),
	(15,'all','member_notification_lifetime','12000','Member notification balloon lifetime ( in miliseconds )',NULL,NULL,NULL,'2010-08-06 09:56:22',NULL),
	(15,'all','notification_scam_flags','3','Notifications - Scam Flags',NULL,NULL,NULL,NULL,NULL),
	(15,'all','notification_spam_msgs','12','Notifications - Spam messages',NULL,NULL,NULL,'2012-07-09 14:00:00',NULL),
	(15,'all','post_your_story_max','2500','Post your story max chars',NULL,NULL,NULL,'2009-10-12 01:56:59',NULL),
	(15,'all','post_your_story_min','50','Post your story min chars',NULL,NULL,NULL,NULL,NULL),
	(15,'all','private_photo_requests','72','Private photo requests per day',NULL,NULL,NULL,NULL,NULL),
	(15,'all','profile_display_video','0','Profile - Display videos',NULL,NULL,NULL,'2010-05-02 18:22:35','bool'),
	(15,'all','profile_max_photos','8','Profile - Num photos on profile',NULL,NULL,NULL,'2010-08-12 04:01:05',NULL),
	(15,'all','profile_max_private_photos','8','Profile - Num private photos on profile',NULL,NULL,NULL,'2009-01-22 17:43:55',NULL),
	(15,'all','profile_num_recent_activities','9','Profile - Num recent activities',NULL,NULL,NULL,'2010-01-22 02:23:13',NULL),
	(15,'all','search_default_kilometers_miles','km','Search - Default value of radius metric ( valid values - \"km\" or \"mil\")',NULL,NULL,NULL,NULL,NULL),
	(15,'all','search_default_radius_distance','100','Search - Default value of radius input box',NULL,NULL,NULL,'2010-05-01 16:36:25',NULL),
	(15,'all','search_rows_custom','6','Search - Custom rows per page',NULL,NULL,NULL,'2010-02-27 18:31:13',NULL),
	(15,'all','search_rows_keyword','6','Search - by Keyword rows per page',NULL,NULL,NULL,'2010-02-27 18:33:44',NULL),
	(15,'all','search_rows_last_login','6','Search - Last Login rows per page',NULL,NULL,NULL,NULL,NULL),
	(15,'all','search_rows_matches','6','Search - Matches rows per page',NULL,NULL,NULL,'2009-12-11 18:25:38',NULL),
	(15,'all','search_rows_most_recent','6','Search - Most Recent rows per page',NULL,NULL,NULL,'2010-08-06 12:48:47',NULL),
	(15,'all','search_rows_public','3','Search - Public rows per page',NULL,NULL,NULL,'2010-08-06 12:49:00',NULL),
	(15,'all','search_rows_reverse','6','Search - Reverse rows per page',NULL,NULL,NULL,'2009-12-11 18:25:55',NULL),
	(15,'all','timeout_warning','3','Timeout warning before session expire in minutes (values 1 .. 29)',NULL,NULL,NULL,NULL,NULL),
	(16,'all','deactivation_counter','0','Number of signin before close registration',NULL,NULL,NULL,NULL,NULL),
	(16,'all','deactivation_days','124','Member deactivation - Days after login reminder notification is sent',NULL,NULL,NULL,'2011-03-07 01:12:26',NULL),
	(16,'all','enable_gifts','0','Gifts',NULL,NULL,NULL,'2009-11-24 23:02:19','bool'),
	(16,'all','enable_upgrade_or_close','','Comma separated orientations, to whom upgrade or close is enabled',NULL,NULL,NULL,NULL,NULL),
	(16,'all','essay_headline_max','60','Essay headline max chars',NULL,NULL,NULL,NULL,NULL),
	(16,'all','essay_headline_min','3','Essay headline min chars',NULL,NULL,NULL,NULL,NULL),
	(16,'all','essay_introduction_max','2500','Essay introduction max chars',NULL,NULL,NULL,'2009-10-12 01:56:49',NULL),
	(16,'all','essay_introduction_min','12','Essay introduction min chars',NULL,NULL,NULL,NULL,NULL),
	(16,'all','extend_eot','1','Days after the actual EOT, when user subscription is downgraded',NULL,NULL,NULL,'2010-06-22 06:23:23',NULL),
	(16,'all','flags_comment_field','1','Flags - Optional comment field',NULL,NULL,NULL,'2009-01-12 05:45:34','bool'),
	(16,'all','flags_num_auto_suspension','3','Flags - Flags for auto-suspension',NULL,NULL,NULL,'2010-03-08 01:39:34',NULL),
	(16,'all','imbra_disable','1','Disable IMBRA',NULL,NULL,NULL,NULL,'bool'),
	(16,'all','immediately_subscription_upgrade','1','Immeditaly upgrade member\'s subscription ( non-prepaid )',NULL,NULL,NULL,NULL,'bool'),
	(16,'all','man_should_pay','1','Force man to pay to send and recive messges',NULL,NULL,NULL,'2010-02-28 20:45:09','bool'),
	(16,'all','member_notification_lifetime','12000','Member notification balloon lifetime ( in miliseconds )',NULL,NULL,NULL,'2010-08-06 09:56:22',NULL),
	(16,'all','notification_scam_flags','3','Notifications - Scam Flags',NULL,NULL,NULL,NULL,NULL),
	(16,'all','notification_spam_msgs','12','Notifications - Spam messages',NULL,NULL,NULL,'2012-07-09 14:00:11',NULL),
	(16,'all','post_your_story_max','2500','Post your story max chars',NULL,NULL,NULL,'2009-10-12 01:56:59',NULL),
	(16,'all','post_your_story_min','50','Post your story min chars',NULL,NULL,NULL,NULL,NULL),
	(16,'all','private_photo_requests','72','Private photo requests per day',NULL,NULL,NULL,NULL,NULL),
	(16,'all','profile_display_video','0','Profile - Display videos',NULL,NULL,NULL,'2010-05-02 18:22:35','bool'),
	(16,'all','profile_max_photos','8','Profile - Num photos on profile',NULL,NULL,NULL,'2010-08-12 04:01:05',NULL),
	(16,'all','profile_max_private_photos','8','Profile - Num private photos on profile',NULL,NULL,NULL,'2009-01-22 17:43:55',NULL),
	(16,'all','profile_num_recent_activities','9','Profile - Num recent activities',NULL,NULL,NULL,'2010-01-22 02:23:13',NULL),
	(16,'all','search_default_kilometers_miles','km','Search - Default value of radius metric ( valid values - \"km\" or \"mil\")',NULL,NULL,NULL,NULL,NULL),
	(16,'all','search_default_radius_distance','100','Search - Default value of radius input box',NULL,NULL,NULL,'2010-05-01 16:36:25',NULL),
	(16,'all','search_rows_custom','6','Search - Custom rows per page',NULL,NULL,NULL,'2010-02-27 18:31:13',NULL),
	(16,'all','search_rows_keyword','6','Search - by Keyword rows per page',NULL,NULL,NULL,'2010-02-27 18:33:44',NULL),
	(16,'all','search_rows_last_login','6','Search - Last Login rows per page',NULL,NULL,NULL,NULL,NULL),
	(16,'all','search_rows_matches','6','Search - Matches rows per page',NULL,NULL,NULL,'2009-12-11 18:25:38',NULL),
	(16,'all','search_rows_most_recent','6','Search - Most Recent rows per page',NULL,NULL,NULL,'2010-08-06 12:48:47',NULL),
	(16,'all','search_rows_public','3','Search - Public rows per page',NULL,NULL,NULL,'2010-08-06 12:49:00',NULL),
	(16,'all','search_rows_reverse','6','Search - Reverse rows per page',NULL,NULL,NULL,'2009-12-11 18:25:55',NULL),
	(16,'all','timeout_warning','3','Timeout warning before session expire in minutes (values 1 .. 29)',NULL,NULL,NULL,NULL,NULL),
	(17,'all','deactivation_counter','0','Number of signin before close registration',NULL,NULL,NULL,NULL,NULL),
	(17,'all','deactivation_days','124','Member deactivation - Days after login reminder notification is sent',NULL,NULL,NULL,'2011-03-07 01:12:26',NULL),
	(17,'all','enable_gifts','0','Gifts',NULL,NULL,NULL,'2009-11-24 23:02:19','bool'),
	(17,'all','enable_upgrade_or_close','','Comma separated orientations, to whom upgrade or close is enabled',NULL,NULL,NULL,NULL,NULL),
	(17,'all','essay_headline_max','60','Essay headline max chars',NULL,NULL,NULL,NULL,NULL),
	(17,'all','essay_headline_min','3','Essay headline min chars',NULL,NULL,NULL,NULL,NULL),
	(17,'all','essay_introduction_max','2500','Essay introduction max chars',NULL,NULL,NULL,'2009-10-12 01:56:49',NULL),
	(17,'all','essay_introduction_min','12','Essay introduction min chars',NULL,NULL,NULL,NULL,NULL),
	(17,'all','extend_eot','10','Days after the actual EOT, when user subscription is downgraded',NULL,NULL,NULL,'2012-02-06 18:04:52',NULL),
	(17,'all','flags_comment_field','1','Flags - Optional comment field',NULL,NULL,NULL,'2009-01-12 05:45:34','bool'),
	(17,'all','flags_num_auto_suspension','3','Flags - Flags for auto-suspension',NULL,NULL,NULL,'2010-03-08 01:39:34',NULL),
	(17,'all','imbra_disable','1','Disable IMBRA',NULL,NULL,NULL,NULL,'bool'),
	(17,'all','immediately_subscription_upgrade','1','Immeditaly upgrade member\'s subscription ( non-prepaid )',NULL,NULL,NULL,NULL,'bool'),
	(17,'all','man_should_pay','1','Force man to pay to send and recive messges',NULL,NULL,NULL,'2010-02-28 20:45:09','bool'),
	(17,'all','member_notification_lifetime','14000','Member notification balloon lifetime ( in miliseconds )',NULL,NULL,NULL,'2012-02-13 02:35:09',NULL),
	(17,'all','notification_scam_flags','3','Notifications - Scam Flags',NULL,NULL,NULL,NULL,NULL),
	(17,'all','notification_spam_msgs','12','Notifications - Spam messages',NULL,NULL,NULL,'2012-07-09 13:59:10',NULL),
	(17,'all','post_your_story_max','2500','Post your story max chars',NULL,NULL,NULL,'2009-10-12 01:56:59',NULL),
	(17,'all','post_your_story_min','50','Post your story min chars',NULL,NULL,NULL,NULL,NULL),
	(17,'all','private_photo_requests','48','Private photo requests per day',NULL,NULL,NULL,'2012-12-31 12:11:32',NULL),
	(17,'all','profile_display_video','0','Profile - Display videos',NULL,NULL,NULL,'2010-05-02 18:22:35','bool'),
	(17,'all','profile_max_photos','8','Profile - Num photos on profile',NULL,NULL,NULL,'2010-08-12 04:01:05',NULL),
	(17,'all','profile_max_private_photos','8','Profile - Num private photos on profile',NULL,NULL,NULL,'2009-01-22 17:43:55',NULL),
	(17,'all','profile_num_recent_activities','9','Profile - Num recent activities',NULL,NULL,NULL,'2010-01-22 02:23:13',NULL),
	(17,'all','search_default_kilometers_miles','km','Search - Default value of radius metric ( valid values - \"km\" or \"mil\")',NULL,NULL,NULL,NULL,NULL),
	(17,'all','search_default_radius_distance','100','Search - Default value of radius input box',NULL,NULL,NULL,'2010-05-01 16:36:25',NULL),
	(17,'all','search_rows_custom','4','Search - Custom rows per page',NULL,NULL,NULL,'2011-12-28 01:22:22',NULL),
	(17,'all','search_rows_keyword','4','Search - by Keyword rows per page',NULL,NULL,NULL,'2011-12-28 01:22:31',NULL),
	(17,'all','search_rows_last_login','4','Search - Last Login rows per page',NULL,NULL,NULL,'2011-12-28 01:21:28',NULL),
	(17,'all','search_rows_matches','4','Search - Matches rows per page',NULL,NULL,NULL,'2011-12-28 01:21:38',NULL),
	(17,'all','search_rows_most_recent','4','Search - Most Recent rows per page',NULL,NULL,NULL,'2011-12-28 01:21:45',NULL),
	(17,'all','search_rows_public','3','Search - Public rows per page',NULL,NULL,NULL,'2010-08-06 12:49:00',NULL),
	(17,'all','search_rows_reverse','4','Search - Reverse rows per page',NULL,NULL,NULL,'2011-12-28 01:21:54',NULL),
	(17,'all','timeout_warning','3','Timeout warning before session expire in minutes (values 1 .. 29)',NULL,NULL,NULL,NULL,NULL),
	(18,'all','deactivation_counter','0','Number of signin before close registration',NULL,NULL,NULL,NULL,NULL),
	(18,'all','deactivation_days','124','Member deactivation - Days after login reminder notification is sent',NULL,NULL,NULL,'2011-03-07 01:12:26',NULL),
	(18,'all','enable_gifts','0','Gifts',NULL,NULL,NULL,'2009-11-24 23:02:19','bool'),
	(18,'all','enable_upgrade_or_close','','Comma separated orientations, to whom upgrade or close is enabled',NULL,NULL,NULL,NULL,NULL),
	(18,'all','essay_headline_max','60','Essay headline max chars',NULL,NULL,NULL,NULL,NULL),
	(18,'all','essay_headline_min','3','Essay headline min chars',NULL,NULL,NULL,NULL,NULL),
	(18,'all','essay_introduction_max','2500','Essay introduction max chars',NULL,NULL,NULL,'2009-10-12 01:56:49',NULL),
	(18,'all','essay_introduction_min','12','Essay introduction min chars',NULL,NULL,NULL,NULL,NULL),
	(18,'all','extend_eot','10','Days after the actual EOT, when user subscription is downgraded',NULL,NULL,NULL,'2012-02-06 18:04:52',NULL),
	(18,'all','flags_comment_field','1','Flags - Optional comment field',NULL,NULL,NULL,'2009-01-12 05:45:34','bool'),
	(18,'all','flags_num_auto_suspension','3','Flags - Flags for auto-suspension',NULL,NULL,NULL,'2010-03-08 01:39:34',NULL),
	(18,'all','imbra_disable','1','Disable IMBRA',NULL,NULL,NULL,NULL,'bool'),
	(18,'all','immediately_subscription_upgrade','1','Immeditaly upgrade member\'s subscription ( non-prepaid )',NULL,NULL,NULL,NULL,'bool'),
	(18,'all','man_should_pay','1','Force man to pay to send and recive messges',NULL,NULL,NULL,'2010-02-28 20:45:09','bool'),
	(18,'all','member_notification_lifetime','14000','Member notification balloon lifetime ( in miliseconds )',NULL,NULL,NULL,'2012-02-13 02:35:09',NULL),
	(18,'all','notification_scam_flags','3','Notifications - Scam Flags',NULL,NULL,NULL,NULL,NULL),
	(18,'all','notification_spam_msgs','12','Notifications - Spam messages',NULL,NULL,NULL,'2012-07-09 13:59:10',NULL),
	(18,'all','post_your_story_max','2500','Post your story max chars',NULL,NULL,NULL,'2009-10-12 01:56:59',NULL),
	(18,'all','post_your_story_min','50','Post your story min chars',NULL,NULL,NULL,NULL,NULL),
	(18,'all','private_photo_requests','48','Private photo requests per day',NULL,NULL,NULL,'2012-12-31 12:11:32',NULL),
	(18,'all','profile_display_video','0','Profile - Display videos',NULL,NULL,NULL,'2010-05-02 18:22:35','bool'),
	(18,'all','profile_max_photos','8','Profile - Num photos on profile',NULL,NULL,NULL,'2010-08-12 04:01:05',NULL),
	(18,'all','profile_max_private_photos','8','Profile - Num private photos on profile',NULL,NULL,NULL,'2009-01-22 17:43:55',NULL),
	(18,'all','profile_num_recent_activities','9','Profile - Num recent activities',NULL,NULL,NULL,'2010-01-22 02:23:13',NULL),
	(18,'all','search_default_kilometers_miles','km','Search - Default value of radius metric ( valid values - \"km\" or \"mil\")',NULL,NULL,NULL,NULL,NULL),
	(18,'all','search_default_radius_distance','100','Search - Default value of radius input box',NULL,NULL,NULL,'2010-05-01 16:36:25',NULL),
	(18,'all','search_rows_custom','4','Search - Custom rows per page',NULL,NULL,NULL,'2011-12-28 01:22:22',NULL),
	(18,'all','search_rows_keyword','4','Search - by Keyword rows per page',NULL,NULL,NULL,'2011-12-28 01:22:31',NULL),
	(18,'all','search_rows_last_login','4','Search - Last Login rows per page',NULL,NULL,NULL,'2011-12-28 01:21:28',NULL),
	(18,'all','search_rows_matches','4','Search - Matches rows per page',NULL,NULL,NULL,'2011-12-28 01:21:38',NULL),
	(18,'all','search_rows_most_recent','4','Search - Most Recent rows per page',NULL,NULL,NULL,'2011-12-28 01:21:45',NULL),
	(18,'all','search_rows_public','3','Search - Public rows per page',NULL,NULL,NULL,'2010-08-06 12:49:00',NULL),
	(18,'all','search_rows_reverse','4','Search - Reverse rows per page',NULL,NULL,NULL,'2011-12-28 01:21:54',NULL),
	(18,'all','timeout_warning','3','Timeout warning before session expire in minutes (values 1 .. 29)',NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `sf_setting` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table static_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `static_page`;

CREATE TABLE `static_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `has_mini_menu` int(11) NOT NULL DEFAULT '0',
  `has_content` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `static_page` WRITE;
/*!40000 ALTER TABLE `static_page` DISABLE KEYS */;

INSERT INTO `static_page` (`id`, `slug`, `has_mini_menu`, `has_content`)
VALUES
	(1,'about_us',0,1),
	(2,'contact_us',1,1),
	(3,'frequently_asked_questions',0,1),
	(4,'for_law_enforcement',0,1),
	(6,'help',0,1),
	(7,'how_it_works',0,1),
	(8,'IMBRA',0,1),
	(9,'user_agreement',0,1),
	(10,'privacy_policy',0,1),
	(11,'copyright',0,1),
	(12,'site_map',0,1),
	(13,'affiliates',1,1),
	(14,'safety_tips',0,1),
	(15,'legal_resources',0,1),
	(16,'immigrant_rights',0,1),
	(17,'writing_tips',0,1),
	(18,'best_videos',0,1),
	(19,'best_videos_rules',0,1),
	(20,'blocked_user',0,1),
	(21,'tell_friend',0,0),
	(22,'search_engines',0,0),
	(23,'seo_countries',0,0);

/*!40000 ALTER TABLE `static_page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table static_page_domain
# ------------------------------------------------------------

DROP TABLE IF EXISTS `static_page_domain`;

CREATE TABLE `static_page_domain` (
  `link_name` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` text,
  `content` text NOT NULL,
  `id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`cat_id`),
  KEY `static_page_domain_FK_2` (`cat_id`),
  CONSTRAINT `static_page_domain_FK_2` FOREIGN KEY (`cat_id`) REFERENCES `catalogue` (`cat_id`) ON DELETE CASCADE,
  CONSTRAINT `static_page_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `static_page` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `static_page_domain` WRITE;
/*!40000 ALTER TABLE `static_page_domain` DISABLE KEYS */;

INSERT INTO `static_page_domain` (`link_name`, `title`, `keywords`, `description`, `content`, `id`, `updated_at`, `cat_id`)
VALUES
	('About Us','About Us','','','',1,'2010-02-08 09:57:06',1),
	('O nas','O nas','','','',1,'2012-03-09 17:19:11',2),
	('About Us','About Us','','','',1,'2013-06-19 14:25:46',17),
	('About Us','About Us','','','',1,'2013-08-19 15:53:44',18),
	('Contact Us','Contact Us','','','',2,'2012-03-05 15:04:37',1),
	('Kontakt','Skontaktuj się z nami','','','',2,'2012-03-05 15:21:18',2),
	('Contact Us','Contact Us','','','',2,'2013-06-19 14:25:46',17),
	('Contact Us','Contact Us','','','',2,'2013-08-19 15:53:44',18),
	('FAQs','Frequently Asked Questions','','','',3,'2010-07-30 12:17:36',1),
	('Pytania','Najczęściej zadawane pytania','','','',3,'2012-03-09 16:39:09',2),
	('FAQs','Frequently Asked Questions','','','',3,'2013-06-19 14:25:46',17),
	('FAQs','Frequently Asked Questions','','','',3,'2013-08-19 15:53:44',18),
	('Legal','Legal Statement','','','',4,'2010-11-03 07:57:54',1),
	('Prawne','Prawne uwagi, zastrzeżenia i wyłączenia','','','',4,'2010-07-30 12:37:43',2),
	('Legal','Legal Statement','','','',4,'2013-06-19 14:25:46',17),
	('Legal','Legal Statement','','','',4,'2013-08-19 15:53:44',18),
	('Help','Help','','','',6,'2010-02-08 09:57:06',1),
	('Pomoc','Pomoc','','','',6,'2012-03-09 17:51:28',2),
	('Help','Help','','','',6,'2013-06-19 14:25:46',17),
	('Help','Help','','','',6,'2013-08-19 15:53:44',18),
	('How It Works','How it works','','','',7,'2010-02-08 09:57:06',1),
	('Jak to działa','Jak działa Szukam Milionera?','','','',7,'2012-03-09 17:04:50',2),
	('How It Works','How it works','','','',7,'2013-06-19 14:25:46',17),
	('How It Works','How it works','','','',7,'2013-08-19 15:53:44',18),
	('Background Checks','Background Check Policy','','','',8,'2010-07-30 12:11:53',1),
	('Sprawdzanie przeszłości','Sprawdzanie przeszłości','','','',8,'2010-06-15 21:39:27',2),
	('Background Checks','Background Check Policy','','','',8,'2013-06-19 14:25:46',17),
	('Background Checks','Background Check Policy','','','',8,'2013-08-19 15:53:44',18),
	('Terms of Use','Terms of Use','','','',9,'2010-07-30 12:30:18',1),
	('Warunki użytkowania','Umowa i warunki użytkowania i korzystania z serwisu SzukamMilionera (dot) com','','','',9,'2012-01-26 21:12:59',2),
	('Warunki użytkowania','Umowa i warunki użytkowania i korzystania z serwisu Meska Milosc (dot) pl','','','',9,'2012-01-26 21:12:01',16),
	('Terms of Use','Terms of Use','','','',9,'2013-06-19 14:25:46',17),
	('Terms of Use','Terms of Use','','','',9,'2013-08-19 15:53:44',18),
	('Privacy Policy','Privacy Policy','','','',10,'2010-07-30 12:23:21',1),
	('Polityka prywatności','Polityka prywatności','','','',10,'2012-03-28 22:16:34',2),
	('Privacy Policy','Privacy Policy','','','',10,'2013-06-19 14:25:46',17),
	('Privacy Policy','Privacy Policy','','','',10,'2013-08-19 15:53:44',18),
	('Copyright_Note','Copyright','','','',11,'2010-07-30 12:16:35',1),
	('Prawa autorskie','Prawa autorskie zastrzeżone','','','',11,'2012-03-09 16:49:08',2),
	('Copyright_Note','Copyright','','','',11,'2013-06-19 14:25:46',17),
	('Copyright_Note','Copyright','','','',11,'2013-08-19 15:53:44',18),
	('Site Map','Site Map','','','',12,'2010-07-30 12:27:30',1),
	('Mapa serwisu','Mapa serwisu','','','',12,'2010-02-08 09:57:06',2),
	('Site Map','Site Map','','','',12,'2013-06-19 14:25:46',17),
	('Site Map','Site Map','','','',12,'2013-08-19 15:53:44',18),
	('Affiliates','Affiliates','','','',13,'2010-07-30 12:11:04',1),
	('Współpraca','Współpraca','','','',13,'2010-06-15 15:17:47',2),
	('Affiliates','Affiliates','','','',13,'2013-06-19 14:25:46',17),
	('Affiliates','Affiliates','','','',13,'2013-08-19 15:53:44',18),
	('Safe Dating','Safe Dating Tips','','','',14,'2011-05-20 00:14:33',1),
	('Bezpieczna randka','Bezpieczne randka','','','',14,'2010-02-12 00:26:07',2),
	('Safe Dating','Safe Dating Tips','','','',14,'2013-06-19 14:25:46',17),
	('Safe Dating','Safe Dating Tips','','','',14,'2013-08-19 15:53:44',18),
	('Moving to Poland?','Helpful Resources on Moving to Poland','','','',15,'2010-02-08 09:57:06',1),
	('Mądra przeprowadzka','Jak przeprowadzić się za granicę lub do innego miasta','','','',15,'2010-02-08 09:57:06',2),
	('Moving to Poland?','Helpful Resources on Moving to Poland','','','',15,'2013-06-19 14:25:46',17),
	('Moving to Poland?','Helpful Resources on Moving to Poland','','','',15,'2013-08-19 15:53:44',18),
	('Emigrating to Poland','Rights and Responsibilities of New Immigrants','','','',16,'2010-07-30 12:25:11',1),
	('Emigrujesz? Znaj swoje prawa!','Prawo i obowiązki świeżych imigrantów','','','',16,'2010-02-08 09:57:06',2),
	('Emigrating to Poland','Rights and Responsibilities of New Immigrants','','','',16,'2013-06-19 14:25:46',17),
	('Emigrating to Poland','Rights and Responsibilities of New Immigrants','','','',16,'2013-08-19 15:53:44',18),
	('Writing Tips','How to write a profile that attracts','','','',17,'2010-02-08 09:57:06',1),
	('Jak pisać aby wzbudzić zainteresowanie','Jak pisać, aby sobą zaciekawić','','','',17,'2010-07-30 12:38:29',2),
	('Jak pisać aby wzbudzić zainteresowanie','Jak pisać, aby sobą zaciekawić','','','',17,'2012-12-26 07:54:25',16),
	('Writing Tips','How to write a profile that attracts','','','',17,'2013-06-19 14:25:46',17),
	('Writing Tips','How to write a profile that attracts','','','',17,'2013-08-19 15:53:44',18),
	('Best Videos','Best Videos','','','',18,'2010-07-30 12:13:08',1),
	('Najlepsze klipy wideo','Najpopularniejsze wideo klipy użytkowników!','','','',18,'2010-07-30 12:46:28',2),
	('Best Videos','Best Videos','','','',18,'2013-06-19 14:25:46',17),
	('Best Videos','Best Videos','','','',18,'2013-08-19 15:53:44',18),
	('Best Videos Rules','Best Videos Rules','','','',19,'2010-07-30 12:15:06',1),
	('Regulamin konkursu wideo','Regulamin konkursu na najlelpszy klip wideo','','','',19,'2010-07-30 12:44:58',2),
	('Best Videos Rules','Best Videos Rules','','','',19,'2013-06-19 14:25:46',17),
	('Best Videos Rules','Best Videos Rules','','','',19,'2013-08-19 15:53:44',18),
	('Blocked User','Restricted Area','','','',20,'2010-07-30 12:23:59',1),
	('Dostęp zablokowany','Strefa niedostępna','','','',20,'2010-07-30 12:24:39',2),
	('Blocked User','Restricted Area','','','',20,'2013-06-19 14:25:46',17),
	('Blocked User','Restricted Area','','','',20,'2013-08-19 15:53:44',18),
	('Tell A Friend','Tell A Friend','','','',21,'2010-02-08 09:57:06',1),
	('Poleć nas','Poleć nas','','','',21,'2010-10-27 22:22:57',2),
	('Tell A Friend','Tell A Friend','','','',21,'2013-06-19 14:25:46',17),
	('Tell A Friend','Tell A Friend','','','',21,'2013-08-19 15:53:44',18),
	('View Polish Singles','View Polish Singles','','','',22,'2010-07-30 12:31:07',1),
	('Profile','Przeglądaj profile kobiet i mężczyzn','','','',22,'2012-03-09 16:42:23',2),
	('View Polish Singles','View Polish Singles','','','',22,'2013-06-19 14:25:46',17),
	('View Polish Singles','View Polish Singles','','','',22,'2013-08-19 15:53:44',18),
	('Locations','Locations','','','',23,'2010-06-15 23:59:20',1),
	('Lokalizacje','Lokalizacje','','','',23,'2010-06-15 21:49:45',2),
	('Locations','Locations','','','',23,'2013-06-19 14:25:46',17),
	('Locations','Locations','','','',23,'2013-08-19 15:53:44',18);

/*!40000 ALTER TABLE `static_page_domain` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stock_photo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stock_photo`;

CREATE TABLE `stock_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `cropped` varchar(255) DEFAULT NULL,
  `gender` char(1) NOT NULL DEFAULT 'M',
  `homepages` varchar(255) DEFAULT NULL,
  `homepages_set` tinyint(4) DEFAULT NULL,
  `homepages_pos` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `assistants` varchar(255) DEFAULT NULL,
  `join_now` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table subscription
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscription`;

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `subscription` WRITE;
/*!40000 ALTER TABLE `subscription` DISABLE KEYS */;

INSERT INTO `subscription` (`id`, `title`)
VALUES
	(1,'Standard'),
	(2,'VIP'),
	(3,'Premium');

/*!40000 ALTER TABLE `subscription` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subscription_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscription_details`;

CREATE TABLE `subscription_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `can_create_profile` int(11) NOT NULL DEFAULT '0',
  `create_profiles` int(11) NOT NULL DEFAULT '0',
  `can_post_photo` int(11) NOT NULL DEFAULT '0',
  `post_photos` int(11) NOT NULL DEFAULT '0',
  `can_post_private_photo` int(11) NOT NULL DEFAULT '0',
  `post_private_photos` int(11) NOT NULL DEFAULT '0',
  `can_wink` int(11) NOT NULL DEFAULT '0',
  `winks` int(11) NOT NULL DEFAULT '0',
  `winks_day` int(11) NOT NULL DEFAULT '0',
  `can_read_messages` int(11) NOT NULL DEFAULT '0',
  `read_messages` int(11) NOT NULL DEFAULT '0',
  `read_messages_day` int(11) NOT NULL DEFAULT '0',
  `can_reply_messages` int(11) NOT NULL DEFAULT '0',
  `reply_messages` int(11) NOT NULL DEFAULT '0',
  `reply_messages_day` int(11) NOT NULL DEFAULT '0',
  `can_send_messages` int(11) NOT NULL DEFAULT '0',
  `send_messages` int(11) NOT NULL DEFAULT '0',
  `send_messages_day` int(11) NOT NULL DEFAULT '0',
  `can_see_viewed` int(11) NOT NULL DEFAULT '0',
  `see_viewed` int(11) NOT NULL DEFAULT '0',
  `can_contact_assistant` int(11) NOT NULL DEFAULT '0',
  `contact_assistant` int(11) NOT NULL DEFAULT '0',
  `contact_assistant_day` int(11) NOT NULL DEFAULT '0',
  `private_dating` int(11) NOT NULL DEFAULT '0',
  `pre_approve` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(7,2) NOT NULL,
  `currency` char(3) NOT NULL DEFAULT '',
  `period` int(11) NOT NULL,
  `period_type` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subscription_details_FI_1` (`subscription_id`),
  KEY `subscription_details_FI_2` (`cat_id`),
  CONSTRAINT `subscription_details_FK_1` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscription_details_FK_2` FOREIGN KEY (`cat_id`) REFERENCES `catalogue` (`cat_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `subscription_details` WRITE;
/*!40000 ALTER TABLE `subscription_details` DISABLE KEYS */;

INSERT INTO `subscription_details` (`id`, `subscription_id`, `cat_id`, `can_create_profile`, `create_profiles`, `can_post_photo`, `post_photos`, `can_post_private_photo`, `post_private_photos`, `can_wink`, `winks`, `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, `can_reply_messages`, `reply_messages`, `reply_messages_day`, `can_send_messages`, `send_messages`, `send_messages_day`, `can_see_viewed`, `see_viewed`, `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, `private_dating`, `pre_approve`, `amount`, `currency`, `period`, `period_type`)
VALUES
	(1,1,1,1,1,1,5,1,5,1,3660,760,1,3600,360,1,3660,300,1,3660,350,1,3660,0,36,3,0,1,0.00,'PLN',1,'M'),
	(2,2,1,1,1,1,5,1,5,1,12000,390,1,12000,390,1,12000,390,1,12000,390,1,12000,1,12000,100,1,0,29.00,'USD',1,'M'),
	(3,3,1,1,1,1,5,1,5,1,10000,360,1,10000,360,1,10000,360,1,10000,360,1,10000,1,10000,100,0,0,24.00,'USD',1,'M'),
	(4,1,2,1,1,1,5,1,5,1,36000,3600,1,36000,3600,1,36000,3600,1,36000,3600,1,73200,0,36,3,0,1,0.00,'PLN',1,'M'),
	(5,2,2,1,1,1,5,1,5,1,132000,3600,1,132000,3600,1,132000,3600,1,132000,3600,1,132000,1,12000,100,1,0,99.00,'PLN',1,'M'),
	(6,3,2,1,1,1,5,1,5,1,36000,3600,1,36000,3600,1,36000,3600,1,36000,3600,1,100000,1,10000,100,0,0,85.00,'PLN',1,'M'),
	(10,1,14,1,1,1,5,1,5,1,3660,360,1,3600,360,1,3660,300,1,3660,350,1,3660,0,36,3,0,1,0.00,'PLN',1,'M'),
	(11,2,14,1,1,1,5,1,5,1,12000,390,1,12000,390,1,12000,390,1,12000,390,1,12000,1,12000,100,1,0,99.00,'PLN',1,'M'),
	(12,3,14,1,1,1,5,1,5,1,10000,360,1,10000,360,1,10000,360,1,10000,360,1,10000,1,10000,100,0,0,85.00,'PLN',1,'M'),
	(13,1,15,1,1,1,5,1,5,1,3660,360,1,3600,360,1,3660,300,1,3660,350,1,3660,0,36,3,0,1,0.00,'PLN',1,'M'),
	(14,2,15,1,1,1,5,1,5,1,12000,390,1,12000,390,1,12000,390,1,12000,390,1,12000,1,12000,100,1,0,10.00,'USD',1,'M'),
	(15,3,15,1,1,1,5,1,5,1,10000,360,1,10000,360,1,10000,360,1,10000,360,1,10000,1,10000,100,0,0,5.00,'USD',1,'M'),
	(16,1,16,1,1,1,5,1,5,1,3660,360,1,3600,360,1,3660,300,1,3660,350,1,3660,0,36,3,0,1,0.00,'PLN',1,'M'),
	(17,2,16,1,1,1,5,1,5,1,12000,390,1,12000,390,1,12000,390,1,12000,390,1,12000,1,12000,100,1,0,10.00,'PLN',1,'M'),
	(18,3,16,1,1,1,5,1,5,1,10000,360,1,10000,360,1,10000,360,1,10000,360,1,10000,1,10000,100,0,0,5.00,'PLN',1,'M'),
	(19,1,17,1,1,1,5,1,5,1,3660,760,1,3600,360,1,3660,300,1,3660,350,1,3660,0,36,3,0,1,0.00,'PLN',1,'M'),
	(20,2,17,1,1,1,5,1,5,1,12000,390,1,12000,390,1,12000,390,1,12000,390,1,12000,1,12000,100,1,0,2.00,'USD',1,'M'),
	(21,3,17,1,1,1,5,1,5,1,10000,360,1,10000,360,1,10000,360,1,10000,360,1,10000,1,10000,100,0,0,1.00,'USD',1,'M'),
	(22,1,18,1,1,1,5,1,5,1,3660,760,1,3600,360,1,3660,300,1,3660,350,1,3660,0,36,3,0,1,0.00,'PLN',1,'M'),
	(23,2,18,1,1,1,5,1,5,1,12000,390,1,12000,390,1,12000,390,1,12000,390,1,12000,1,12000,100,1,0,29.00,'USD',1,'M'),
	(24,3,18,1,1,1,5,1,5,1,10000,360,1,10000,360,1,10000,360,1,10000,360,1,10000,1,10000,100,0,0,24.00,'USD',1,'M');

/*!40000 ALTER TABLE `subscription_details` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subscription_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscription_history`;

CREATE TABLE `subscription_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `member_status_id` int(11) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `changed_by` varchar(255) DEFAULT 'unknown',
  PRIMARY KEY (`id`),
  KEY `subscription_history_FI_1` (`member_id`),
  KEY `subscription_history_FI_2` (`subscription_id`),
  KEY `subscription_history_FI_3` (`member_status_id`),
  CONSTRAINT `subscription_history_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscription_history_FK_2` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscription_history_FK_3` FOREIGN KEY (`member_status_id`) REFERENCES `member_status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table suspended_by_flag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `suspended_by_flag`;

CREATE TABLE `suspended_by_flag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `confirmed_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suspended_by_flag_FI_1` (`member_id`),
  KEY `suspended_by_flag_FI_2` (`confirmed_by`),
  CONSTRAINT `suspended_by_flag_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `suspended_by_flag_FK_2` FOREIGN KEY (`confirmed_by`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table thread
# ------------------------------------------------------------

DROP TABLE IF EXISTS `thread`;

CREATE TABLE `thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `snippet` text,
  `snippet_member_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thread_FI_1` (`snippet_member_id`),
  CONSTRAINT `thread_FK_1` FOREIGN KEY (`snippet_member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table trans_collection
# ------------------------------------------------------------

DROP TABLE IF EXISTS `trans_collection`;

CREATE TABLE `trans_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `trans_collection` WRITE;
/*!40000 ALTER TABLE `trans_collection` DISABLE KEYS */;

INSERT INTO `trans_collection` (`id`, `name`)
VALUES
	(1,'Homepage'),
	(2,'Profile'),
	(3,'Search - Most Recent'),
	(4,'Search - Custom (by Criteria)'),
	(5,'Search - Reverse'),
	(6,'Search - Matches'),
	(7,'Search - By Keyword'),
	(8,'Search - Profile ID'),
	(9,'Search - Public Search'),
	(10,'Registration - Registration'),
	(11,'Registration - Self-Description'),
	(12,'Registration - Essay'),
	(13,'Registration - Photos'),
	(14,'Registration - Search Criteria'),
	(15,'Registration - Join Now'),
	(16,'IMBRA - Application'),
	(17,'IMBRA - Report'),
	(18,'System Messages'),
	(19,'Assistant');

/*!40000 ALTER TABLE `trans_collection` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table trans_unit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `trans_unit`;

CREATE TABLE `trans_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL DEFAULT '1',
  `source` varbinary(220) NOT NULL DEFAULT '',
  `target` text NOT NULL,
  `comments` text,
  `author` varchar(255) NOT NULL DEFAULT '',
  `translated` int(11) NOT NULL DEFAULT '0',
  `date_modified` int(11) NOT NULL DEFAULT '0',
  `msg_collection_id` int(11) DEFAULT NULL,
  `date_added` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) DEFAULT NULL,
  `link` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cat_id_source` (`cat_id`,`source`),
  KEY `trans_unit_FI_1` (`cat_id`),
  KEY `trans_unit_FI_2` (`msg_collection_id`),
  KEY `tags` (`tags`),
  CONSTRAINT `trans_unit_FK_1` FOREIGN KEY (`cat_id`) REFERENCES `catalogue` (`cat_id`),
  CONSTRAINT `trans_unit_FK_2` FOREIGN KEY (`msg_collection_id`) REFERENCES `msg_collection` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `must_change_pwd` int(11) NOT NULL DEFAULT '0',
  `is_superuser` int(11) NOT NULL DEFAULT '0',
  `is_enabled` int(11) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `dashboard_mod` int(11) NOT NULL DEFAULT '0',
  `dashboard_mod_type` char(1) NOT NULL DEFAULT 'V',
  `members_mod` int(11) NOT NULL DEFAULT '0',
  `members_mod_type` char(1) NOT NULL DEFAULT 'V',
  `content_mod` int(11) NOT NULL DEFAULT '0',
  `content_mod_type` char(1) NOT NULL DEFAULT 'V',
  `subscriptions_mod` int(11) NOT NULL DEFAULT '0',
  `subscriptions_mod_type` char(1) NOT NULL DEFAULT 'V',
  `messages_mod` int(11) NOT NULL DEFAULT '0',
  `messages_mod_type` char(1) NOT NULL DEFAULT 'V',
  `flags_mod` int(11) NOT NULL DEFAULT '0',
  `flags_mod_type` char(1) NOT NULL DEFAULT 'V',
  `reports_mod` int(11) NOT NULL DEFAULT '0',
  `reports_mod_type` char(1) NOT NULL DEFAULT 'V',
  `users_mod` int(11) NOT NULL DEFAULT '0',
  `users_mod_type` char(1) NOT NULL DEFAULT 'V',
  `feedback_mod` int(11) NOT NULL DEFAULT '0',
  `feedback_mod_type` char(1) NOT NULL DEFAULT 'V',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wink
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wink`;

CREATE TABLE `wink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `sent_box` int(11) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `is_new` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `wink_FI_1` (`member_id`),
  KEY `wink_FI_2` (`profile_id`),
  CONSTRAINT `wink_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wink_FK_2` FOREIGN KEY (`profile_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table zong_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `zong_history`;

CREATE TABLE `zong_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transactionRef` varchar(255) NOT NULL,
  `itemRef` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `failure` varchar(20) DEFAULT NULL,
  `method` varchar(6) NOT NULL,
  `msisdn` varchar(20) NOT NULL,
  `outPayment` varchar(100) NOT NULL,
  `simulated` int(11) DEFAULT '0',
  `signature` text NOT NULL,
  `signatureVersion` varchar(2) NOT NULL,
  `request_ip` bigint(20) DEFAULT NULL,
  `verified` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
