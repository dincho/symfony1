ALTER TABLE `ipwatch` ADD UNIQUE INDEX `uniq_ip` (`ip`);
ALTER TABLE `ip_location` ADD PRIMARY INDEX `` (`id`);
ALTER TABLE `ip_location` ADD  INDEX `ip_location_FI_1` (`country_code`);
ALTER TABLE `ip_location` ADD CONSTRAINT `ip_location_FK_1`
		FOREIGN KEY (`country_code`)
		REFERENCES `ip_country` (`country_code`)
		ON DELETE RESTRICT;
ALTER TABLE `ip_blocks` ADD  INDEX `ip_blocks_FI_1` (`locid`);
ALTER TABLE `ip_blocks` ADD CONSTRAINT `ip_blocks_FK_1`
		FOREIGN KEY (`locid`)
		REFERENCES `ip_location` (`id`)
		ON DELETE RESTRICT;
ALTER TABLE `member` ADD  INDEX `member_FI_1` (`member_status_id`);
ALTER TABLE `member` ADD  INDEX `member_FI_2` (`reviewed_by_id`);
ALTER TABLE `member` ADD  INDEX `member_FI_3` (`adm1_id`);
ALTER TABLE `member` ADD  INDEX `member_FI_4` (`adm2_id`);
ALTER TABLE `member` ADD  INDEX `member_FI_5` (`city_id`);
ALTER TABLE `member` ADD  INDEX `member_FI_6` (`catalog_id`);
ALTER TABLE `member` ADD  INDEX `member_FI_7` (`main_photo_id`);
ALTER TABLE `member` ADD  INDEX `member_FI_8` (`subscription_id`);
ALTER TABLE `member` ADD  INDEX `member_FI_9` (`member_counter_id`);
ALTER TABLE `member` ADD CONSTRAINT `member_FK_6`
		FOREIGN KEY (`catalog_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON UPDATE RESTRICT
		ON DELETE SET NULL;
ALTER TABLE `member_rate` ADD CONSTRAINT `member_rate_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE;
ALTER TABLE `photo_exif_info` ADD  INDEX `photo_exif_info_FI_1` (`photo_id`);
ALTER TABLE `message` ADD  INDEX `msg_type` (`type`);
ALTER TABLE `message` ADD  INDEX `message_FI_1` (`sender_id`);
ALTER TABLE `message` ADD  INDEX `message_FI_2` (`recipient_id`);
ALTER TABLE `message` ADD  INDEX `message_FI_3` (`thread_id`);
ALTER TABLE `predefined_message` ADD  INDEX `predefined_message_FI_1` (`catalog_id`);
ALTER TABLE `static_page_domain` ADD  INDEX `static_page_domain_FI_2` (`cat_id`);
ALTER TABLE `member_story` ADD  INDEX `cat_id` (`cat_id`);
ALTER TABLE `member_story` ADD  INDEX `member_story_FI_2` (`stock_photo_id`);
ALTER TABLE `member_story` ADD CONSTRAINT `member_story_FK_1`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON DELETE SET NULL;
ALTER TABLE `homepage_member_story` ADD  INDEX `cat_id` (`cat_id`);
ALTER TABLE `notification` ADD  INDEX `notification_FI_1` (`cat_id`);
ALTER TABLE `member_notification` ADD  INDEX `member_notification_FI_2` (`profile_id`);
ALTER TABLE `member_notification` ADD CONSTRAINT `member_notification_FK_2`
		FOREIGN KEY (`profile_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE;
ALTER TABLE `pr_mail_sum` ADD `id` INTEGER  NOT NULL AUTO_INCREMENT;
ALTER TABLE `pr_mail_sum` ADD PRIMARY INDEX `` (`id`);
ALTER TABLE `geo` ADD  INDEX `geo_FI_1` (`adm1_id`);
ALTER TABLE `geo` ADD  INDEX `geo_FI_2` (`adm2_id`);
ALTER TABLE `geo_photo` ADD  INDEX `geo_photo_FI_1` (`geo_id`);
ALTER TABLE `geo_details` ADD  INDEX `geo_details_FI_2` (`cat_id`);
ALTER TABLE `geo_details` ADD CONSTRAINT `geo_details_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `geo` (`id`)
		ON UPDATE RESTRICT
		ON DELETE CASCADE;
ALTER TABLE `geo_details` ADD CONSTRAINT `geo_details_FK_2`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON UPDATE RESTRICT
		ON DELETE CASCADE;
DROP TABLE `best_video_template`;
ALTER TABLE `feedback_template` DROP `tags`;
ALTER TABLE `flag` DROP `flag_category_id`;
ALTER TABLE `geo` DROP INDEX geo_FK_1;
ALTER TABLE `geo` DROP INDEX geo_FK_2;
/* old definition: int(10) NOT NULL AUTO_INCREMENT
   new definition: INTEGER  NOT NULL AUTO_INCREMENT */
ALTER TABLE `geo` CHANGE `id` `id` INTEGER  NOT NULL AUTO_INCREMENT;
/* old definition: varchar(255) DEFAULT 'UTC'
   new definition: VARCHAR(255) default '' */
ALTER TABLE `geo` CHANGE `timezone` `timezone` VARCHAR(255) default '';
ALTER TABLE `geo_photo` DROP INDEX geo_photo_FK_1;
/* old definition: char(1) NOT NULL DEFAULT 'M'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `homepage_member_photo` CHANGE `gender` `gender` CHAR(1) default '' NOT NULL;
ALTER TABLE `homepage_member_story` DROP INDEX homepage_member_story_FK_1;
/* old definition: int(10) unsigned NOT NULL AUTO_INCREMENT
   new definition: INTEGER  NOT NULL AUTO_INCREMENT */
ALTER TABLE `ip_blocks` CHANGE `id` `id` INTEGER  NOT NULL AUTO_INCREMENT;
/* old definition: polygon NOT NULL
   new definition: LONGBLOB  NOT NULL */
ALTER TABLE `ip_blocks` CHANGE `ip_poly` `ip_poly` LONGBLOB  NOT NULL;
/* old definition: int(10) unsigned NOT NULL
   new definition: BIGINT  NOT NULL */
ALTER TABLE `ip_blocks` CHANGE `ip_from` `ip_from` BIGINT  NOT NULL;
/* old definition: int(10) unsigned NOT NULL
   new definition: BIGINT  NOT NULL */
ALTER TABLE `ip_blocks` CHANGE `ip_to` `ip_to` BIGINT  NOT NULL;
/* old definition: int(10) unsigned NOT NULL
   new definition: INTEGER */
ALTER TABLE `ip_blocks` CHANGE `locid` `locid` INTEGER;
/* old definition: int(10) unsigned NOT NULL AUTO_INCREMENT
   new definition: INTEGER  NOT NULL AUTO_INCREMENT */
ALTER TABLE `ip_country` CHANGE `id` `id` INTEGER  NOT NULL AUTO_INCREMENT;
/* old definition: varchar(255) DEFAULT NULL
   new definition: VARCHAR(255)  NOT NULL */
ALTER TABLE `ip_country` CHANGE `country_name` `country_name` VARCHAR(255)  NOT NULL;
/* old definition: int(10) unsigned NOT NULL
   new definition: INTEGER  NOT NULL AUTO_INCREMENT */
ALTER TABLE `ip_location` CHANGE `id` `id` INTEGER  NOT NULL AUTO_INCREMENT;
/* old definition: char(2) DEFAULT NULL
   new definition: CHAR(2)  NOT NULL */
ALTER TABLE `ip_location` CHANGE `country_code` `country_code` CHAR(2)  NOT NULL;
ALTER TABLE `ipwatch` DROP INDEX ip;
/* old definition: bigint(11) NOT NULL
   new definition: INTEGER */
ALTER TABLE `ipwatch` CHANGE `ip` `ip` INTEGER;
/* old definition: datetime NOT NULL
   new definition: DATETIME */
ALTER TABLE `ipwatch` CHANGE `created_at` `created_at` DATETIME;
ALTER TABLE `member` DROP INDEX member_FK_1;
ALTER TABLE `member` DROP INDEX member_FK_2;
ALTER TABLE `member` DROP INDEX member_FK_3;
ALTER TABLE `member` DROP INDEX member_FK_4;
ALTER TABLE `member` DROP INDEX member_FK_5;
ALTER TABLE `member` DROP INDEX member_FK_6;
ALTER TABLE `member` DROP INDEX member_FK_7;
ALTER TABLE `member` DROP INDEX member_FK_8;
ALTER TABLE `member` DROP INDEX last_login;
ALTER TABLE `member` DROP INDEX created_at;
ALTER TABLE `member` DROP INDEX Last_IP;
ALTER TABLE `member` DROP INDEX Reg_IP;
ALTER TABLE `member_desc_answer` DROP INDEX member_desc_answer_FI_1;
ALTER TABLE `member_login_history` DROP INDEX IP;
/* old definition: bigint(20) NOT NULL
   new definition: BIGINT */
ALTER TABLE `member_login_history` CHANGE `ip` `ip` BIGINT;
DROP TABLE `member_match`;
/* old definition: varchar(100) DEFAULT 'pending'
   new definition: VARCHAR(100) default '' */
ALTER TABLE `member_payment` CHANGE `status` `status` VARCHAR(100) default '';
/* old definition: timestamp NULL DEFAULT CURRENT_TIMESTAMP
   new definition: DATETIME */
ALTER TABLE `member_photo` CHANGE `updated_at` `updated_at` DATETIME;
ALTER TABLE `member_rate` DROP INDEX rate;
ALTER TABLE `member_story` DROP INDEX member_story_FI_1;
/* old definition: varchar(100) DEFAULT 'pending'
   new definition: VARCHAR(100) default '' */
ALTER TABLE `member_subscription` CHANGE `status` `status` VARCHAR(100) default '';
/* old definition: decimal(7,2) DEFAULT NULL
   new definition: DECIMAL(7,2)  NOT NULL */
ALTER TABLE `member_subscription` CHANGE `next_amount` `next_amount` DECIMAL(7,2)  NOT NULL;
ALTER TABLE `message` DROP INDEX message_FK_1;
ALTER TABLE `message` DROP INDEX message_FK_2;
ALTER TABLE `message` DROP INDEX message_FK_3;
ALTER TABLE `notification` DROP INDEX notification_FK_1;
ALTER TABLE `notification_event` DROP INDEX notification_event_FI_1;
ALTER TABLE `photo_exif_info` DROP INDEX photo_id;
/* old definition: int(11) NOT NULL
   new definition: INTEGER */
ALTER TABLE `photo_exif_info` CHANGE `photo_id` `photo_id` INTEGER;
/* old definition: text NOT NULL
   new definition: TEXT */
ALTER TABLE `photo_exif_info` CHANGE `exif_info` `exif_info` TEXT;
ALTER TABLE `pr_mail_message` DROP INDEX status;
/* old definition: varchar(10) NOT NULL DEFAULT 'pending'
   new definition: VARCHAR(10) default '' NOT NULL */
ALTER TABLE `pr_mail_message` CHANGE `status` `status` VARCHAR(10) default '' NOT NULL;
/* old definition: int(11) NOT NULL
   new definition: INTEGER */
ALTER TABLE `pr_mail_message` CHANGE `notification_id` `notification_id` INTEGER;
/* old definition: int(11) NOT NULL
   new definition: INTEGER */
ALTER TABLE `pr_mail_message` CHANGE `notification_cat` `notification_cat` INTEGER;
/* old definition: varchar(255) NOT NULL
   new definition: VARCHAR(255) */
ALTER TABLE `pr_mail_sum` CHANGE `mail_config` `mail_config` VARCHAR(255);
/* old definition: int(11) NOT NULL
   new definition: INTEGER */
ALTER TABLE `pr_mail_sum` CHANGE `cnt` `cnt` INTEGER;
/* old definition: date NOT NULL
   new definition: DATE */
ALTER TABLE `pr_mail_sum` CHANGE `at` `at` DATE;
ALTER TABLE `predefined_message` DROP INDEX predefined_message_FK_1;
/* old definition: enum('A','R') NOT NULL
   new definition: CHAR(1) */
ALTER TABLE `private_photo_permission` CHANGE `status` `status` CHAR(1);
/* old definition: enum('P','R') NOT NULL
   new definition: CHAR(1)  NOT NULL */
ALTER TABLE `private_photo_permission` CHANGE `type` `type` CHAR(1)  NOT NULL;
/* old definition: datetime NOT NULL
   new definition: DATETIME */
ALTER TABLE `private_photo_permission` CHANGE `updated_at` `updated_at` DATETIME;
ALTER TABLE `search_crit_desc` DROP INDEX search_crit_desc_FI_1;
/* old definition: int(11) NOT NULL DEFAULT '1'
   new definition: INTEGER(11)  NOT NULL */
ALTER TABLE `sf_setting` CHANGE `cat_id` `cat_id` INTEGER(11)  NOT NULL;
ALTER TABLE `static_page_domain` DROP INDEX static_page_domain_FK_2;
/* old definition: char(1) NOT NULL DEFAULT 'M'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `stock_photo` CHANGE `gender` `gender` CHAR(1) default '' NOT NULL;
/* old definition: varchar(255) DEFAULT 'unknown'
   new definition: VARCHAR(255) default '' */
ALTER TABLE `subscription_history` CHANGE `changed_by` `changed_by` VARCHAR(255) default '';
ALTER TABLE `trans_unit` DROP INDEX trans_unit_FI_1;
ALTER TABLE `trans_unit` DROP INDEX tags;
/* old definition: varbinary(220) NOT NULL DEFAULT ''
   new definition: MEDIUMBLOB  NOT NULL */
ALTER TABLE `trans_unit` CHANGE `source` `source` MEDIUMBLOB  NOT NULL;
/* old definition: varchar(255) DEFAULT NULL
   new definition: TEXT */
ALTER TABLE `trans_unit` CHANGE `tags` `tags` TEXT;
/* old definition: char(1) NOT NULL DEFAULT 'V'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `user` CHANGE `dashboard_mod_type` `dashboard_mod_type` CHAR(1) default '' NOT NULL;
/* old definition: char(1) NOT NULL DEFAULT 'V'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `user` CHANGE `members_mod_type` `members_mod_type` CHAR(1) default '' NOT NULL;
/* old definition: char(1) NOT NULL DEFAULT 'V'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `user` CHANGE `content_mod_type` `content_mod_type` CHAR(1) default '' NOT NULL;
/* old definition: char(1) NOT NULL DEFAULT 'V'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `user` CHANGE `subscriptions_mod_type` `subscriptions_mod_type` CHAR(1) default '' NOT NULL;
/* old definition: char(1) NOT NULL DEFAULT 'V'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `user` CHANGE `messages_mod_type` `messages_mod_type` CHAR(1) default '' NOT NULL;
/* old definition: char(1) NOT NULL DEFAULT 'V'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `user` CHANGE `flags_mod_type` `flags_mod_type` CHAR(1) default '' NOT NULL;
/* old definition: char(1) NOT NULL DEFAULT 'V'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `user` CHANGE `reports_mod_type` `reports_mod_type` CHAR(1) default '' NOT NULL;
/* old definition: char(1) NOT NULL DEFAULT 'V'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `user` CHANGE `users_mod_type` `users_mod_type` CHAR(1) default '' NOT NULL;
/* old definition: char(1) NOT NULL DEFAULT 'V'
   new definition: CHAR(1) default '' NOT NULL */
ALTER TABLE `user` CHANGE `feedback_mod_type` `feedback_mod_type` CHAR(1) default '' NOT NULL;

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- schema_info
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `schema_info`;


CREATE TABLE `schema_info`
(
	`version` INTEGER  NOT NULL,
	PRIMARY KEY (`version`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- session_storage
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `session_storage`;


CREATE TABLE `session_storage`
(
	`sess_id` VARCHAR(255)  NOT NULL,
	`sess_data` TEXT  NOT NULL,
	`sess_time` DATETIME  NOT NULL,
	`user_id` INTEGER default null,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `sess_id` (`sess_id`),
	UNIQUE KEY `user_sess` (`user_id`, `sess_id`),
	KEY `sess_time`(`sess_time`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- user
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;


CREATE TABLE `user`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(20)  NOT NULL,
	`password` CHAR(40)  NOT NULL,
	`first_name` VARCHAR(80)  NOT NULL,
	`last_name` VARCHAR(80)  NOT NULL,
	`email` VARCHAR(255)  NOT NULL,
	`phone` VARCHAR(20)  NOT NULL,
	`dashboard_mod` INTEGER default 0 NOT NULL,
	`dashboard_mod_type` CHAR(1) default '' NOT NULL,
	`members_mod` INTEGER default 0 NOT NULL,
	`members_mod_type` CHAR(1) default '' NOT NULL,
	`content_mod` INTEGER default 0 NOT NULL,
	`content_mod_type` CHAR(1) default '' NOT NULL,
	`subscriptions_mod` INTEGER default 0 NOT NULL,
	`subscriptions_mod_type` CHAR(1) default '' NOT NULL,
	`messages_mod` INTEGER default 0 NOT NULL,
	`messages_mod_type` CHAR(1) default '' NOT NULL,
	`feedback_mod` INTEGER default 0 NOT NULL,
	`feedback_mod_type` CHAR(1) default '' NOT NULL,
	`flags_mod` INTEGER default 0 NOT NULL,
	`flags_mod_type` CHAR(1) default '' NOT NULL,
	`reports_mod` INTEGER default 0 NOT NULL,
	`reports_mod_type` CHAR(1) default '' NOT NULL,
	`users_mod` INTEGER default 0 NOT NULL,
	`users_mod_type` CHAR(1) default '' NOT NULL,
	`must_change_pwd` INTEGER default 0 NOT NULL,
	`is_superuser` INTEGER default 0 NOT NULL,
	`is_enabled` INTEGER default 0 NOT NULL,
	`last_login` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ipblock
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ipblock`;


CREATE TABLE `ipblock`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`item` VARCHAR(255),
	`item_type` INTEGER(1) default 0,
	`netmask` INTEGER(2) default 24,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `uniq_item_type` (`item`, `item_type`),
	KEY `item_type`(`item_type`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ipwatch
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ipwatch`;


CREATE TABLE `ipwatch`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ip` INTEGER,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `uniq_ip` (`ip`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ip_country
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ip_country`;


CREATE TABLE `ip_country`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`country_code` CHAR(2)  NOT NULL,
	`country_name` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `country_code` (`country_code`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ip_location
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ip_location`;


CREATE TABLE `ip_location`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`country_code` CHAR(2)  NOT NULL,
	`city_name` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `ip_location_FI_1` (`country_code`),
	CONSTRAINT `ip_location_FK_1`
		FOREIGN KEY (`country_code`)
		REFERENCES `ip_country` (`country_code`)
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ip_blocks
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ip_blocks`;


CREATE TABLE `ip_blocks`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ip_poly` LONGBLOB  NOT NULL,
	`ip_from` BIGINT  NOT NULL,
	`ip_to` BIGINT  NOT NULL,
	`locid` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `ip_blocks_FI_1` (`locid`),
	CONSTRAINT `ip_blocks_FK_1`
		FOREIGN KEY (`locid`)
		REFERENCES `ip_location` (`id`)
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member`;


CREATE TABLE `member`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_status_id` INTEGER,
	`username` VARCHAR(20)  NOT NULL,
	`password` CHAR(40)  NOT NULL,
	`new_password` CHAR(40),
	`must_change_pwd` INTEGER default 0 NOT NULL,
	`first_name` VARCHAR(80)  NOT NULL,
	`last_name` VARCHAR(80)  NOT NULL,
	`email` VARCHAR(255)  NOT NULL,
	`tmp_email` VARCHAR(255)  NOT NULL,
	`has_email_confirmation` INTEGER default 0 NOT NULL,
	`sex` CHAR(1)  NOT NULL,
	`looking_for` CHAR(1)  NOT NULL,
	`reviewed_by_id` INTEGER,
	`reviewed_at` DATETIME,
	`is_starred` INTEGER default 0 NOT NULL,
	`country` VARCHAR(4)  NOT NULL,
	`adm1_id` INTEGER,
	`adm2_id` INTEGER,
	`city_id` INTEGER,
	`zip` VARCHAR(20)  NOT NULL,
	`nationality` VARCHAR(255)  NOT NULL,
	`language` VARCHAR(3)  NOT NULL,
	`catalog_id` INTEGER  NOT NULL,
	`birthday` DATE,
	`age` INTEGER,
	`dont_display_zodiac` INTEGER default 0 NOT NULL,
	`us_citizen` INTEGER,
	`email_notifications` TINYINT,
	`dont_use_photos` INTEGER default 0 NOT NULL,
	`contact_only_full_members` INTEGER default 0 NOT NULL,
	`youtube_vid` VARCHAR(20),
	`essay_headline` VARCHAR(255),
	`essay_introduction` TEXT,
	`main_photo_id` INTEGER,
	`subscription_id` INTEGER  NOT NULL,
	`member_counter_id` INTEGER  NOT NULL,
	`public_search` INTEGER default 0 NOT NULL,
	`private_dating` INTEGER default 0 NOT NULL,
	`hide_visits` INTEGER default 0 NOT NULL,
	`registration_ip` BIGINT,
	`last_ip` BIGINT,
	`last_status_change` DATETIME,
	`last_flagged` DATETIME,
	`last_login` DATETIME,
	`last_activity_notification` DATETIME,
	`created_at` DATETIME,
	`dashboard_msg` INTEGER(1) default 0,
	`original_first_name` VARCHAR(80),
	`original_last_name` VARCHAR(80)  NOT NULL,
	`last_subscription_change` DATETIME,
	`last_photo_upload_at` DATETIME,
	`purpose` VARCHAR(255),
	`millionaire` INTEGER default 0,
	`last_payment_state` VARCHAR(50),
	PRIMARY KEY (`id`),
	UNIQUE KEY `username` (`username`),
	UNIQUE KEY `email` (`email`),
	INDEX `member_FI_1` (`member_status_id`),
	CONSTRAINT `member_FK_1`
		FOREIGN KEY (`member_status_id`)
		REFERENCES `member_status` (`id`)
		ON DELETE RESTRICT,
	INDEX `member_FI_2` (`reviewed_by_id`),
	CONSTRAINT `member_FK_2`
		FOREIGN KEY (`reviewed_by_id`)
		REFERENCES `user` (`id`)
		ON DELETE SET NULL,
	INDEX `member_FI_3` (`adm1_id`),
	CONSTRAINT `member_FK_3`
		FOREIGN KEY (`adm1_id`)
		REFERENCES `geo` (`id`)
		ON DELETE SET NULL,
	INDEX `member_FI_4` (`adm2_id`),
	CONSTRAINT `member_FK_4`
		FOREIGN KEY (`adm2_id`)
		REFERENCES `geo` (`id`)
		ON DELETE SET NULL,
	INDEX `member_FI_5` (`city_id`),
	CONSTRAINT `member_FK_5`
		FOREIGN KEY (`city_id`)
		REFERENCES `geo` (`id`)
		ON DELETE SET NULL,
	INDEX `member_FI_6` (`catalog_id`),
	CONSTRAINT `member_FK_6`
		FOREIGN KEY (`catalog_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON UPDATE RESTRICT
		ON DELETE SET NULL,
	INDEX `member_FI_7` (`main_photo_id`),
	CONSTRAINT `member_FK_7`
		FOREIGN KEY (`main_photo_id`)
		REFERENCES `member_photo` (`id`)
		ON DELETE SET NULL,
	INDEX `member_FI_8` (`subscription_id`),
	CONSTRAINT `member_FK_8`
		FOREIGN KEY (`subscription_id`)
		REFERENCES `subscription` (`id`)
		ON DELETE RESTRICT,
	INDEX `member_FI_9` (`member_counter_id`),
	CONSTRAINT `member_FK_9`
		FOREIGN KEY (`member_counter_id`)
		REFERENCES `member_counter` (`id`)
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_status
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_status`;


CREATE TABLE `member_status`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_counter
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_counter`;


CREATE TABLE `member_counter`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`current_flags` INTEGER default 0 NOT NULL,
	`total_flags` INTEGER default 0 NOT NULL,
	`sent_flags` INTEGER default 0 NOT NULL,
	`sent_winks` INTEGER default 0 NOT NULL,
	`sent_winks_day` INTEGER default 0 NOT NULL,
	`received_winks` INTEGER default 0 NOT NULL,
	`received_winks_day` INTEGER default 0 NOT NULL,
	`read_messages` INTEGER default 0 NOT NULL,
	`read_messages_day` INTEGER default 0 NOT NULL,
	`sent_messages` INTEGER default 0 NOT NULL,
	`sent_messages_day` INTEGER default 0 NOT NULL,
	`received_messages` INTEGER default 0 NOT NULL,
	`reply_messages` INTEGER default 0 NOT NULL,
	`reply_messages_day` INTEGER default 0 NOT NULL,
	`unsuspensions` INTEGER default 0 NOT NULL,
	`assistant_contacts` INTEGER default 0 NOT NULL,
	`assistant_contacts_day` INTEGER default 0 NOT NULL,
	`profile_views` INTEGER default 0 NOT NULL,
	`made_profile_views` INTEGER default 0 NOT NULL,
	`hotlist` INTEGER default 0 NOT NULL,
	`on_others_hotlist` INTEGER default 0 NOT NULL,
	`deactivation_counter` INTEGER default 0 NOT NULL,
	`active` INTEGER(1) default 0 NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_note
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_note`;


CREATE TABLE `member_note`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`user_id` INTEGER,
	`text` TEXT  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `member_note_FI_1` (`member_id`),
	CONSTRAINT `member_note_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `member_note_FI_2` (`user_id`),
	CONSTRAINT `member_note_FK_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_login_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_login_history`;


CREATE TABLE `member_login_history`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`ip` BIGINT,
	`last_login` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `member_login_history_FI_1` (`member_id`),
	CONSTRAINT `member_login_history_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_rate
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_rate`;


CREATE TABLE `member_rate`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`rater_id` INTEGER  NOT NULL,
	`rate` INTEGER(1)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `member_rate_FI_1` (`member_id`),
	CONSTRAINT `member_rate_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `member_rate_FI_2` (`rater_id`),
	CONSTRAINT `member_rate_FK_2`
		FOREIGN KEY (`rater_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- desc_question
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `desc_question`;


CREATE TABLE `desc_question`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
	`search_title` VARCHAR(255),
	`desc_title` VARCHAR(255),
	`factor_title` VARCHAR(255),
	`type` VARCHAR(50),
	`is_required` INTEGER default 1 NOT NULL,
	`select_greather` INTEGER default 0 NOT NULL,
	`other` VARCHAR(255),
	`include_custom` VARCHAR(255),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- desc_answer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `desc_answer`;


CREATE TABLE `desc_answer`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`desc_question_id` INTEGER  NOT NULL,
	`title` TEXT,
	`search_title` VARCHAR(255),
	`desc_title` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `desc_answer_FI_1` (`desc_question_id`),
	CONSTRAINT `desc_answer_FK_1`
		FOREIGN KEY (`desc_question_id`)
		REFERENCES `desc_question` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_desc_answer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_desc_answer`;


CREATE TABLE `member_desc_answer`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`desc_question_id` INTEGER  NOT NULL,
	`desc_answer_id` INTEGER default null,
	`other` VARCHAR(255),
	`custom` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `member_answer` (`member_id`, `desc_question_id`),
	CONSTRAINT `member_desc_answer_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `member_desc_answer_FI_2` (`desc_question_id`),
	CONSTRAINT `member_desc_answer_FK_2`
		FOREIGN KEY (`desc_question_id`)
		REFERENCES `desc_question` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- search_crit_desc
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `search_crit_desc`;


CREATE TABLE `search_crit_desc`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`desc_question_id` INTEGER  NOT NULL,
	`desc_answers` TEXT,
	`match_weight` TINYINT  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `member_answer` (`member_id`, `desc_question_id`),
	CONSTRAINT `search_crit_desc_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `search_crit_desc_FI_2` (`desc_question_id`),
	CONSTRAINT `search_crit_desc_FK_2`
		FOREIGN KEY (`desc_question_id`)
		REFERENCES `desc_question` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_photo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_photo`;


CREATE TABLE `member_photo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER,
	`file` VARCHAR(255),
	`cropped` VARCHAR(255),
	`updated_at` DATETIME,
	`is_main` INTEGER default 0 NOT NULL,
	`is_private` INTEGER  NOT NULL,
	`sort_order` INTEGER default 0 NOT NULL,
	`auth` CHAR(1),
	PRIMARY KEY (`id`),
	INDEX `member_photo_FI_1` (`member_id`),
	CONSTRAINT `member_photo_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- photo_exif_info
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `photo_exif_info`;


CREATE TABLE `photo_exif_info`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`photo_id` INTEGER,
	`exif_info` TEXT,
	PRIMARY KEY (`id`),
	INDEX `photo_exif_info_FI_1` (`photo_id`),
	CONSTRAINT `photo_exif_info_FK_1`
		FOREIGN KEY (`photo_id`)
		REFERENCES `member_photo` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- private_photo_permission
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `private_photo_permission`;


CREATE TABLE `private_photo_permission`
(
	`member_id` INTEGER  NOT NULL,
	`profile_id` INTEGER  NOT NULL,
	`type` CHAR(1)  NOT NULL,
	`status` CHAR(1),
	`is_new` INTEGER default 1 NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`member_id`,`profile_id`,`type`),
	CONSTRAINT `private_photo_permission_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `private_photo_permission_FI_2` (`profile_id`),
	CONSTRAINT `private_photo_permission_FK_2`
		FOREIGN KEY (`profile_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- stock_photo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `stock_photo`;


CREATE TABLE `stock_photo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`file` VARCHAR(255),
	`cropped` VARCHAR(255),
	`gender` CHAR(1) default '' NOT NULL,
	`homepages` VARCHAR(255),
	`homepages_set` TINYINT,
	`homepages_pos` TINYINT,
	`assistants` VARCHAR(255),
	`join_now` VARCHAR(255),
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- profile_view
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `profile_view`;


CREATE TABLE `profile_view`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`profile_id` INTEGER  NOT NULL,
	`is_new` INTEGER default 1 NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `profile_view_FI_1` (`member_id`),
	CONSTRAINT `profile_view_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `profile_view_FI_2` (`profile_id`),
	CONSTRAINT `profile_view_FK_2`
		FOREIGN KEY (`profile_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- block
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `block`;


CREATE TABLE `block`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`profile_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `block_FI_1` (`member_id`),
	CONSTRAINT `block_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `block_FI_2` (`profile_id`),
	CONSTRAINT `block_FK_2`
		FOREIGN KEY (`profile_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- subscription
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subscription`;


CREATE TABLE `subscription`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- subscription_details
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subscription_details`;


CREATE TABLE `subscription_details`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`subscription_id` INTEGER  NOT NULL,
	`cat_id` INTEGER  NOT NULL,
	`can_create_profile` INTEGER default 0 NOT NULL,
	`create_profiles` INTEGER default 0 NOT NULL,
	`can_post_photo` INTEGER default 0 NOT NULL,
	`post_photos` INTEGER default 0 NOT NULL,
	`can_post_private_photo` INTEGER default 0 NOT NULL,
	`post_private_photos` INTEGER default 0 NOT NULL,
	`can_wink` INTEGER default 0 NOT NULL,
	`winks` INTEGER default 0 NOT NULL,
	`winks_day` INTEGER default 0 NOT NULL,
	`can_read_messages` INTEGER default 0 NOT NULL,
	`read_messages` INTEGER default 0 NOT NULL,
	`read_messages_day` INTEGER default 0 NOT NULL,
	`can_reply_messages` INTEGER default 0 NOT NULL,
	`reply_messages` INTEGER default 0 NOT NULL,
	`reply_messages_day` INTEGER default 0 NOT NULL,
	`can_send_messages` INTEGER default 0 NOT NULL,
	`send_messages` INTEGER default 0 NOT NULL,
	`send_messages_day` INTEGER default 0 NOT NULL,
	`can_see_viewed` INTEGER default 0 NOT NULL,
	`see_viewed` INTEGER default 0 NOT NULL,
	`can_contact_assistant` INTEGER default 0 NOT NULL,
	`contact_assistant` INTEGER default 0 NOT NULL,
	`contact_assistant_day` INTEGER default 0 NOT NULL,
	`private_dating` INTEGER default 0 NOT NULL,
	`pre_approve` INTEGER default 0 NOT NULL,
	`amount` DECIMAL(7,2)  NOT NULL,
	`currency` CHAR(3)  NOT NULL,
	`period` INTEGER  NOT NULL,
	`period_type` CHAR(1)  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `subscription_details_FI_1` (`subscription_id`),
	CONSTRAINT `subscription_details_FK_1`
		FOREIGN KEY (`subscription_id`)
		REFERENCES `subscription` (`id`)
		ON DELETE CASCADE,
	INDEX `subscription_details_FI_2` (`cat_id`),
	CONSTRAINT `subscription_details_FK_2`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- subscription_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subscription_history`;


CREATE TABLE `subscription_history`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`subscription_id` INTEGER  NOT NULL,
	`member_status_id` INTEGER,
	`from_date` DATETIME,
	`changed_by` VARCHAR(255) default '',
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `subscription_history_FI_1` (`member_id`),
	CONSTRAINT `subscription_history_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `subscription_history_FI_2` (`subscription_id`),
	CONSTRAINT `subscription_history_FK_2`
		FOREIGN KEY (`subscription_id`)
		REFERENCES `subscription` (`id`)
		ON DELETE CASCADE,
	INDEX `subscription_history_FI_3` (`member_status_id`),
	CONSTRAINT `subscription_history_FK_3`
		FOREIGN KEY (`member_status_id`)
		REFERENCES `member_status` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_status_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_status_history`;


CREATE TABLE `member_status_history`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`member_status_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`from_status_id` INTEGER,
	`from_date` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `member_status_history_FI_1` (`member_id`),
	CONSTRAINT `member_status_history_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `member_status_history_FI_2` (`member_status_id`),
	CONSTRAINT `member_status_history_FK_2`
		FOREIGN KEY (`member_status_id`)
		REFERENCES `member_status` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- thread
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `thread`;


CREATE TABLE `thread`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`subject` VARCHAR(255),
	`snippet` TEXT,
	`snippet_member_id` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `thread_FI_1` (`snippet_member_id`),
	CONSTRAINT `thread_FK_1`
		FOREIGN KEY (`snippet_member_id`)
		REFERENCES `member` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- message
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `message`;


CREATE TABLE `message`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sender_id` INTEGER,
	`recipient_id` INTEGER  NOT NULL,
	`thread_id` INTEGER,
	`subject` TEXT,
	`body` TEXT,
	`type` INTEGER default 1 NOT NULL,
	`unread` INTEGER default 1 NOT NULL,
	`is_reviewed` INTEGER default 0 NOT NULL,
	`predefined_id` INTEGER,
	`sender_deleted_at` DATETIME,
	`recipient_deleted_at` DATETIME,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `msg_type`(`type`),
	INDEX `message_FI_1` (`sender_id`),
	CONSTRAINT `message_FK_1`
		FOREIGN KEY (`sender_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `message_FI_2` (`recipient_id`),
	CONSTRAINT `message_FK_2`
		FOREIGN KEY (`recipient_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `message_FI_3` (`thread_id`),
	CONSTRAINT `message_FK_3`
		FOREIGN KEY (`thread_id`)
		REFERENCES `thread` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- predefined_message
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `predefined_message`;


CREATE TABLE `predefined_message`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`catalog_id` INTEGER  NOT NULL,
	`subject` TEXT,
	`body` TEXT,
	`sex` CHAR(1)  NOT NULL,
	`looking_for` CHAR(1)  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `predefined_message_FI_1` (`catalog_id`),
	CONSTRAINT `predefined_message_FK_1`
		FOREIGN KEY (`catalog_id`)
		REFERENCES `catalogue` (`cat_id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- hotlist
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `hotlist`;


CREATE TABLE `hotlist`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`profile_id` INTEGER  NOT NULL,
	`is_new` INTEGER default 1 NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `hotlist_FI_1` (`member_id`),
	CONSTRAINT `hotlist_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `hotlist_FI_2` (`profile_id`),
	CONSTRAINT `hotlist_FK_2`
		FOREIGN KEY (`profile_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- wink
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `wink`;


CREATE TABLE `wink`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`profile_id` INTEGER  NOT NULL,
	`sent_box` INTEGER default 0 NOT NULL,
	`is_new` INTEGER default 1 NOT NULL,
	`created_at` DATETIME,
	`deleted_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `wink_FI_1` (`member_id`),
	CONSTRAINT `wink_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `wink_FI_2` (`profile_id`),
	CONSTRAINT `wink_FK_2`
		FOREIGN KEY (`profile_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- feedback
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `feedback`;


CREATE TABLE `feedback`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`mailbox` TINYINT default 1 NOT NULL,
	`member_id` INTEGER,
	`mail_from` VARCHAR(255),
	`name_from` VARCHAR(255),
	`mail_to` VARCHAR(255),
	`name_to` VARCHAR(255),
	`bcc` VARCHAR(255),
	`subject` VARCHAR(255),
	`body` TEXT,
	`is_read` INTEGER default 0 NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `feedback_FI_1` (`member_id`),
	CONSTRAINT `feedback_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- feedback_template
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `feedback_template`;


CREATE TABLE `feedback_template`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`mail_from` VARCHAR(255),
	`reply_to` VARCHAR(255),
	`bcc` VARCHAR(255),
	`subject` VARCHAR(255),
	`body` TEXT,
	`footer` TEXT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- flag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `flag`;


CREATE TABLE `flag`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`flagger_id` INTEGER  NOT NULL,
	`comment` VARCHAR(255),
	`is_history` INTEGER default 0 NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `flag_FI_1` (`member_id`),
	CONSTRAINT `flag_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `flag_FI_2` (`flagger_id`),
	CONSTRAINT `flag_FK_2`
		FOREIGN KEY (`flagger_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- suspended_by_flag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `suspended_by_flag`;


CREATE TABLE `suspended_by_flag`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`confirmed_at` DATETIME,
	`confirmed_by` INTEGER,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `suspended_by_flag_FI_1` (`member_id`),
	CONSTRAINT `suspended_by_flag_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `suspended_by_flag_FI_2` (`confirmed_by`),
	CONSTRAINT `suspended_by_flag_FK_2`
		FOREIGN KEY (`confirmed_by`)
		REFERENCES `user` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- catalogue
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `catalogue`;


CREATE TABLE `catalogue`
(
	`cat_id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) default '' NOT NULL,
	`source_lang` VARCHAR(100) default '' NOT NULL,
	`target_lang` VARCHAR(100) default '' NOT NULL,
	`domain` VARCHAR(255) default '' NOT NULL,
	`date_created` INTEGER(11) default 0 NOT NULL,
	`date_modified` INTEGER(11) default 0 NOT NULL,
	`author` VARCHAR(255) default '' NOT NULL,
	`shared_catalogs` VARCHAR(255),
	PRIMARY KEY (`cat_id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- trans_unit
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `trans_unit`;


CREATE TABLE `trans_unit`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`cat_id` INTEGER(11) default 1 NOT NULL,
	`msg_collection_id` INTEGER,
	`source` MEDIUMBLOB  NOT NULL,
	`target` TEXT  NOT NULL,
	`comments` TEXT,
	`author` VARCHAR(255) default '' NOT NULL,
	`translated` INTEGER default 0 NOT NULL,
	`tags` TEXT,
	`link` TEXT,
	`date_added` INTEGER(11) default 0 NOT NULL,
	`date_modified` INTEGER(11) default 0 NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `cat_id_source` (`cat_id`, `source`),
	CONSTRAINT `trans_unit_FK_1`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`),
	INDEX `trans_unit_FI_2` (`msg_collection_id`),
	CONSTRAINT `trans_unit_FK_2`
		FOREIGN KEY (`msg_collection_id`)
		REFERENCES `msg_collection` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- trans_collection
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `trans_collection`;


CREATE TABLE `trans_collection`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- msg_collection
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `msg_collection`;


CREATE TABLE `msg_collection`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`trans_collection_id` INTEGER,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `msg_collection_FI_1` (`trans_collection_id`),
	CONSTRAINT `msg_collection_FK_1`
		FOREIGN KEY (`trans_collection_id`)
		REFERENCES `trans_collection` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- static_page
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `static_page`;


CREATE TABLE `static_page`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`slug` VARCHAR(255)  NOT NULL,
	`has_mini_menu` INTEGER default 0 NOT NULL,
	`has_content` INTEGER default 1 NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- static_page_domain
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `static_page_domain`;


CREATE TABLE `static_page_domain`
(
	`id` INTEGER  NOT NULL,
	`cat_id` INTEGER  NOT NULL,
	`link_name` VARCHAR(100),
	`title` VARCHAR(255)  NOT NULL,
	`keywords` VARCHAR(255),
	`description` TEXT,
	`content` TEXT  NOT NULL,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`,`cat_id`),
	CONSTRAINT `static_page_domain_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `static_page` (`id`)
		ON UPDATE RESTRICT
		ON DELETE CASCADE,
	INDEX `static_page_domain_FI_2` (`cat_id`),
	CONSTRAINT `static_page_domain_FK_2`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_story
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_story`;


CREATE TABLE `member_story`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`cat_id` INTEGER,
	`slug` VARCHAR(255)  NOT NULL,
	`sort_order` INTEGER(11) default 0 NOT NULL,
	`link_name` VARCHAR(100)  NOT NULL,
	`title` VARCHAR(255)  NOT NULL,
	`summary` VARCHAR(255)  NOT NULL,
	`keywords` VARCHAR(255)  NOT NULL,
	`description` TEXT  NOT NULL,
	`content` TEXT  NOT NULL,
	`stock_photo_id` INTEGER,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `slug` (`slug`),
	KEY `cat_id`(`cat_id`),
	CONSTRAINT `member_story_FK_1`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON DELETE SET NULL,
	INDEX `member_story_FI_2` (`stock_photo_id`),
	CONSTRAINT `member_story_FK_2`
		FOREIGN KEY (`stock_photo_id`)
		REFERENCES `stock_photo` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- homepage_member_story
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `homepage_member_story`;


CREATE TABLE `homepage_member_story`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_stories` VARCHAR(255),
	`cat_id` INTEGER,
	PRIMARY KEY (`id`),
	KEY `cat_id`(`cat_id`),
	CONSTRAINT `homepage_member_story_FK_1`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- notification
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `notification`;


CREATE TABLE `notification`
(
	`id` INTEGER  NOT NULL,
	`cat_id` INTEGER  NOT NULL,
	`name` VARCHAR(255),
	`trigger_name` VARCHAR(255),
	`is_active` INTEGER default 0 NOT NULL,
	`to_admins` INTEGER default 0 NOT NULL,
	`days` INTEGER,
	`whn` CHAR(1),
	`send_from` VARCHAR(255),
	`send_to` VARCHAR(255),
	`reply_to` VARCHAR(255),
	`bcc` VARCHAR(255),
	`subject` VARCHAR(255),
	`body` TEXT,
	`footer` TEXT,
	`mail_config` VARCHAR(255),
	PRIMARY KEY (`id`,`cat_id`),
	INDEX `notification_FI_1` (`cat_id`),
	CONSTRAINT `notification_FK_1`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- notification_event
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `notification_event`;


CREATE TABLE `notification_event`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`notification_id` INTEGER,
	`event` TINYINT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `event_notify` (`notification_id`, `event`),
	KEY `event`(`event`),
	CONSTRAINT `notification_event_FK_1`
		FOREIGN KEY (`notification_id`)
		REFERENCES `notification` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_notification
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_notification`;


CREATE TABLE `member_notification`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`profile_id` INTEGER  NOT NULL,
	`type` INTEGER  NOT NULL,
	`sent_at` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `member_notification_FI_1` (`member_id`),
	CONSTRAINT `member_notification_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `member_notification_FI_2` (`profile_id`),
	CONSTRAINT `member_notification_FK_2`
		FOREIGN KEY (`profile_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pr_mail_message
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pr_mail_message`;


CREATE TABLE `pr_mail_message`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`mail_config` VARCHAR(255),
	`sender` TEXT,
	`mail_from` TEXT,
	`recipients` TEXT,
	`cc` TEXT,
	`bcc` TEXT,
	`subject` TEXT,
	`body` TEXT,
	`status` VARCHAR(10) default '' NOT NULL,
	`status_message` TEXT,
	`notification_id` INTEGER,
	`notification_cat` INTEGER,
	`hash` CHAR(40),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pr_mail_sum
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pr_mail_sum`;


CREATE TABLE `pr_mail_sum`
(
	`mail_config` VARCHAR(255),
	`cnt` INTEGER,
	`at` DATE,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- geo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `geo`;


CREATE TABLE `geo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100),
	`dsg` VARCHAR(4)  NOT NULL,
	`country` VARCHAR(4)  NOT NULL,
	`adm1_id` INTEGER,
	`adm2_id` INTEGER,
	`latitude` FLOAT,
	`longitude` FLOAT,
	`population` INTEGER(10) default 0 NOT NULL,
	`timezone` VARCHAR(255) default '',
	PRIMARY KEY (`id`),
	KEY `complex`(`country`, `dsg`, `adm1_id`, `adm2_id`, `name`),
	INDEX `geo_FI_1` (`adm1_id`),
	CONSTRAINT `geo_FK_1`
		FOREIGN KEY (`adm1_id`)
		REFERENCES `geo` (`id`)
		ON DELETE SET NULL,
	INDEX `geo_FI_2` (`adm2_id`),
	CONSTRAINT `geo_FK_2`
		FOREIGN KEY (`adm2_id`)
		REFERENCES `geo` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- geo_photo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `geo_photo`;


CREATE TABLE `geo_photo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`geo_id` INTEGER  NOT NULL,
	`file` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `geo_photo_FI_1` (`geo_id`),
	CONSTRAINT `geo_photo_FK_1`
		FOREIGN KEY (`geo_id`)
		REFERENCES `geo` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- geo_details
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `geo_details`;


CREATE TABLE `geo_details`
(
	`id` INTEGER  NOT NULL,
	`cat_id` INTEGER  NOT NULL,
	`member_info` TEXT,
	`seo_info` TEXT,
	PRIMARY KEY (`id`,`cat_id`),
	CONSTRAINT `geo_details_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `geo` (`id`)
		ON UPDATE RESTRICT
		ON DELETE CASCADE,
	INDEX `geo_details_FI_2` (`cat_id`),
	CONSTRAINT `geo_details_FK_2`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- link
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `link`;


CREATE TABLE `link`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`hash` CHAR(40)  NOT NULL,
	`login_as` INTEGER,
	`uri` VARCHAR(255)  NOT NULL,
	`expires_at` DATETIME,
	`login_expires_at` DATETIME,
	`lifetime` INTEGER,
	`hit_count` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `hash` (`hash`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- open_privacy
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `open_privacy`;


CREATE TABLE `open_privacy`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`profile_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `member2profile` (`member_id`, `profile_id`),
	CONSTRAINT `open_privacy_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `open_privacy_FI_2` (`profile_id`),
	CONSTRAINT `open_privacy_FK_2`
		FOREIGN KEY (`profile_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- homepage_member_photo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `homepage_member_photo`;


CREATE TABLE `homepage_member_photo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`filepath` VARCHAR(255),
	`gender` CHAR(1) default '' NOT NULL,
	`homepages` VARCHAR(255),
	`homepages_set` TINYINT,
	`homepages_pos` TINYINT,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `homepage_member_photo_FI_1` (`member_id`),
	CONSTRAINT `homepage_member_photo_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_subscription
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_subscription`;


CREATE TABLE `member_subscription`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`subscription_id` INTEGER,
	`gift_by` INTEGER,
	`status` VARCHAR(100) default '',
	`last_status_change_at` DATETIME,
	`period` TINYINT  NOT NULL,
	`period_type` CHAR(1)  NOT NULL,
	`effective_date` DATETIME,
	`eot_at` DATETIME,
	`pp_ref` VARCHAR(255),
	`details` TEXT,
	`next_amount` DECIMAL(7,2)  NOT NULL,
	`next_currency` VARCHAR(5),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `member_subscription_FI_1` (`member_id`),
	CONSTRAINT `member_subscription_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `member_subscription_FI_2` (`subscription_id`),
	CONSTRAINT `member_subscription_FK_2`
		FOREIGN KEY (`subscription_id`)
		REFERENCES `subscription` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_payment
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_payment`;


CREATE TABLE `member_payment`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER,
	`payment_type` VARCHAR(20)  NOT NULL,
	`member_subscription_id` INTEGER,
	`payment_processor` VARCHAR(10),
	`amount` DECIMAL(7,2)  NOT NULL,
	`currency` VARCHAR(5),
	`status` VARCHAR(100) default '',
	`extra_status` VARCHAR(100),
	`pp_ref` VARCHAR(255),
	`details` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `member_payment_FI_1` (`member_id`),
	CONSTRAINT `member_payment_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `member_payment_FI_2` (`member_subscription_id`),
	CONSTRAINT `member_payment_FK_2`
		FOREIGN KEY (`member_subscription_id`)
		REFERENCES `member_subscription` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ipn_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ipn_history`;


CREATE TABLE `ipn_history`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`parameters` TEXT,
	`request_ip` BIGINT,
	`txn_type` VARCHAR(255),
	`txn_id` VARCHAR(255),
	`subscr_id` VARCHAR(255),
	`payment_status` VARCHAR(255),
	`paypal_response` VARCHAR(8),
	`txn_created_at` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- zong_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `zong_history`;


CREATE TABLE `zong_history`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`transactionRef` VARCHAR(255)  NOT NULL,
	`itemRef` VARCHAR(255)  NOT NULL,
	`status` VARCHAR(10)  NOT NULL,
	`failure` VARCHAR(20),
	`method` VARCHAR(6)  NOT NULL,
	`msisdn` VARCHAR(20)  NOT NULL,
	`outPayment` VARCHAR(100)  NOT NULL,
	`simulated` INTEGER default 0,
	`signature` TEXT  NOT NULL,
	`signatureVersion` VARCHAR(2)  NOT NULL,
	`request_ip` BIGINT,
	`verified` INTEGER default 0,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- dotpay_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `dotpay_history`;


CREATE TABLE `dotpay_history`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`account_id` INTEGER  NOT NULL,
	`transaction_id` VARCHAR(255)  NOT NULL,
	`status` VARCHAR(10)  NOT NULL,
	`control` VARCHAR(128)  NOT NULL,
	`amount` DECIMAL(7,2)  NOT NULL,
	`original_amount` VARCHAR(255)  NOT NULL,
	`email` VARCHAR(255)  NOT NULL,
	`t_status` VARCHAR(255)  NOT NULL,
	`description` VARCHAR(255),
	`checksum` VARCHAR(32)  NOT NULL,
	`p_info` VARCHAR(255),
	`p_email` VARCHAR(255),
	`t_date` DATETIME  NOT NULL,
	`request_ip` BIGINT,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- as_seen_on_logo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `as_seen_on_logo`;


CREATE TABLE `as_seen_on_logo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`file` VARCHAR(255),
	`url` VARCHAR(255),
	`homepages` VARCHAR(255),
	`is_online` INTEGER default 1,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- sf_setting
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_setting`;


CREATE TABLE `sf_setting`
(
	`cat_id` INTEGER(11)  NOT NULL,
	`env` VARCHAR(10)  NOT NULL,
	`name` VARCHAR(40)  NOT NULL,
	`value` VARCHAR(100),
	`var_type` VARCHAR(30),
	`description` VARCHAR(255),
	`created_user_id` INTEGER,
	`updated_user_id` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`cat_id`,`env`,`name`),
	CONSTRAINT `sf_setting_FK_1`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
