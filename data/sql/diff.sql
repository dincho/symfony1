ALTER TABLE `member` ADD `last_activity_notification` DATETIME;
ALTER TABLE `permissions` ADD PRIMARY INDEX `` (`id`,`group_id`);
ALTER TABLE `permissions` ADD CONSTRAINT `permissions_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`);
ALTER TABLE `group_and_action` ADD CONSTRAINT `group_and_action_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`);
/* old definition: int(11) NOT NULL auto_increment
   new definition: INTEGER(11)  NOT NULL AUTO_INCREMENT */
ALTER TABLE `catalogue` CHANGE `cat_id` `cat_id` INTEGER(11)  NOT NULL AUTO_INCREMENT;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `catalogue` CHANGE `date_created` `date_created` INTEGER(11) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `catalogue` CHANGE `date_modified` `date_modified` INTEGER(11) default 0 NOT NULL;
/* old definition: CONSTRAINT `group_and_action_FK_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE
   new definition: CONSTRAINT `group_and_action_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`) */
ALTER TABLE `group_and_action` DROP FOREIGN KEY `group_and_action_FK_1`;
ALTER TABLE `group_and_action` ADD CONSTRAINT `group_and_action_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`);
/* old definition: text
   new definition: VARCHAR(1000) */
ALTER TABLE `groups` CHANGE `group_description` `group_description` VARCHAR(1000);
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
ALTER TABLE `permissions` DROP FOREIGN KEY `permissions_FK_1`;
/* old definition: CONSTRAINT `permissions_FK_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE
   new definition: CONSTRAINT `permissions_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`) */
ALTER TABLE `permissions` DROP FOREIGN KEY `permissions_FK_2`;
ALTER TABLE `permissions` ADD CONSTRAINT `permissions_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`);
/* old definition: (`id`)
   new definition: (`group_id`) */
ALTER TABLE `permissions` DROP INDEX permissions_FI_1,        ADD  INDEX `permissions_FI_1` (`group_id`);
ALTER TABLE `permissions` DROP INDEX permissions_FI_2;
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
