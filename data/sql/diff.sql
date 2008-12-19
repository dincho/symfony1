ALTER TABLE `member_story` ADD `culture` VARCHAR(7);
ALTER TABLE `member_story` ADD `link_name` VARCHAR(100)  NOT NULL;
ALTER TABLE `member_story` ADD `title` VARCHAR(255)  NOT NULL;
ALTER TABLE `member_story` ADD `keywords` VARCHAR(255)  NOT NULL;
ALTER TABLE `member_story` ADD `description` TEXT  NOT NULL;
ALTER TABLE `member_story` ADD `content` TEXT  NOT NULL;
/* old definition: int(11) NOT NULL auto_increment
   new definition: INTEGER(11)  NOT NULL AUTO_INCREMENT */
ALTER TABLE `catalogue` CHANGE `cat_id` `cat_id` INTEGER(11)  NOT NULL AUTO_INCREMENT;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `catalogue` CHANGE `date_created` `date_created` INTEGER(11) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `catalogue` CHANGE `date_modified` `date_modified` INTEGER(11) default 0 NOT NULL;
ALTER TABLE `member` DROP FOREIGN KEY `member_FK_4`;
/* old definition: (`search_criteria_id`)
   new definition: (`main_photo_id`) */
ALTER TABLE `member` DROP INDEX member_FI_4,        ADD  INDEX `member_FI_4` (`main_photo_id`);
ALTER TABLE `member` DROP INDEX member_FK_7;
/* old definition: int(10) NOT NULL
   new definition: INTEGER(10)  NOT NULL */
ALTER TABLE `member` CHANGE `zip` `zip` INTEGER(10)  NOT NULL;
ALTER TABLE `member` DROP `search_criteria_id`;
ALTER TABLE `member_desc_answer` DROP INDEX member_id;
ALTER TABLE `member_match` DROP INDEX member1_id;
ALTER TABLE `member_match` DROP INDEX pct;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `member_story` CHANGE `sort_order` `sort_order` INTEGER(11) default 0 NOT NULL;
DROP TABLE `member_story_i18n`;
/* old definition: decimal(7,2) NOT NULL default '0.00'
   new definition: DECIMAL(7,2) default 0 NOT NULL */
ALTER TABLE `subscription` CHANGE `period1_price` `period1_price` DECIMAL(7,2) default 0 NOT NULL;
/* old definition: decimal(7,2) NOT NULL default '0.00'
   new definition: DECIMAL(7,2) default 0 NOT NULL */
ALTER TABLE `subscription` CHANGE `period2_price` `period2_price` DECIMAL(7,2) default 0 NOT NULL;
/* old definition: decimal(7,2) NOT NULL default '0.00'
   new definition: DECIMAL(7,2) default 0 NOT NULL */
ALTER TABLE `subscription` CHANGE `period3_price` `period3_price` DECIMAL(7,2) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '1'
   new definition: INTEGER(11) default 1 NOT NULL */
ALTER TABLE `trans_unit` CHANGE `cat_id` `cat_id` INTEGER(11) default 1 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `trans_unit` CHANGE `date_created` `date_created` INTEGER(11) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `trans_unit` CHANGE `date_modified` `date_modified` INTEGER(11) default 0 NOT NULL;
