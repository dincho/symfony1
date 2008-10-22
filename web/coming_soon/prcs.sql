SET FOREIGN_KEY_CHECKS=0;

SET AUTOCOMMIT=0;
START TRANSACTION;

-- 
-- Database: `prcs`
-- 
DROP DATABASE `prcs`;
CREATE DATABASE `prcs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `prcs`;

-- --------------------------------------------------------

-- 
-- Table structure for table `prcs`
-- 

DROP TABLE IF EXISTS `prcs`;
CREATE TABLE `prcs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

SET FOREIGN_KEY_CHECKS=1;

COMMIT;
