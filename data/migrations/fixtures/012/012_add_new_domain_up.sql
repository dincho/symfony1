INSERT INTO `catalogue` (`cat_id`, `name`, `source_lang`, `target_lang`, `date_created`, `date_modified`, `author`, `domain`, `shared_catalogs`)
VALUES
    (20, 'www.ashley.pl.messages.pl', 'en', 'pl', 1530029316, 1596527580, '', 'www.ashley.pl', NULL),
    (21, 'www.ishchumillionera.com.messages.com', 'en', 'com', 1530029316, 1596527580, '', 'www.ishchumillionera.com', NULL);

UPDATE `member` SET catalog_id = '18' WHERE catalog_id = '15';

SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM `catalogue` WHERE cat_id = 15;
DELETE FROM `catalogue` WHERE cat_id = 19;
SET FOREIGN_KEY_CHECKS = 1;
