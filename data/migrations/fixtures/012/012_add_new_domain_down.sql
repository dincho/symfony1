INSERT INTO `catalogue` (`cat_id`, `name`, `source_lang`, `target_lang`, `date_created`, `date_modified`, `author`, `domain`, `shared_catalogs`)
VALUES
    (15, 'www.expatcalling.com.messages.en', 'en', 'en', 1285768721, 1360822749, '', 'www.expatcalling.com', NULL),
    (19, 'www.datingonhudson.com.messages.en', 'en', 'en', 1393953180, 1396527587, '', 'www.datingonhudson.com', NULL);

UPDATE `member` SET catalog_id = '15' WHERE catalog_id = '18';

SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM `catalogue` WHERE cat_id = 20;
DELETE FROM `catalogue` WHERE cat_id = 21;
SET FOREIGN_KEY_CHECKS = 1;
