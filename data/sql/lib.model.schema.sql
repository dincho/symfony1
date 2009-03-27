
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- session_storage
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `session_storage`;


CREATE TABLE `session_storage`
(
	`sess_id` VARCHAR(255)  NOT NULL,
	`sess_data` TEXT  NOT NULL,
	`sess_time` BIGINT(20)  NOT NULL,
	`user_id` INTEGER default null,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
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
	`dashboard_mod_type` CHAR(1) default 'V' NOT NULL,
	`members_mod` INTEGER default 0 NOT NULL,
	`members_mod_type` CHAR(1) default 'V' NOT NULL,
	`content_mod` INTEGER default 0 NOT NULL,
	`content_mod_type` CHAR(1) default 'V' NOT NULL,
	`subscriptions_mod` INTEGER default 0 NOT NULL,
	`subscriptions_mod_type` CHAR(1) default 'V' NOT NULL,
	`messages_mod` INTEGER default 0 NOT NULL,
	`messages_mod_type` CHAR(1) default 'V' NOT NULL,
	`feedback_mod` INTEGER default 0 NOT NULL,
	`feedback_mod_type` CHAR(1) default 'V' NOT NULL,
	`flags_mod` INTEGER default 0 NOT NULL,
	`flags_mod_type` CHAR(1) default 'V' NOT NULL,
	`imbra_mod` INTEGER default 0 NOT NULL,
	`imbra_mod_type` CHAR(1) default 'V' NOT NULL,
	`reports_mod` INTEGER default 0 NOT NULL,
	`reports_mod_type` CHAR(1) default 'V' NOT NULL,
	`users_mod` INTEGER default 0 NOT NULL,
	`users_mod_type` CHAR(1) default 'V' NOT NULL,
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
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- state
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `state`;


CREATE TABLE `state`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`country` CHAR(2)  NOT NULL,
	`title` VARCHAR(255)  NOT NULL,
	`info` TEXT,
	PRIMARY KEY (`id`),
	KEY `state_country_index`(`country`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- state_photo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `state_photo`;


CREATE TABLE `state_photo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`state_id` INTEGER  NOT NULL,
	`file` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `state_photo_FI_1` (`state_id`),
	CONSTRAINT `state_photo_FK_1`
		FOREIGN KEY (`state_id`)
		REFERENCES `state` (`id`)
		ON DELETE CASCADE
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
	`country` CHAR(2)  NOT NULL,
	`state_id` INTEGER,
	`district` VARCHAR(100)  NOT NULL,
	`city` VARCHAR(60)  NOT NULL,
	`zip` VARCHAR(20)  NOT NULL,
	`nationality` VARCHAR(255)  NOT NULL,
	`language` VARCHAR(3)  NOT NULL,
	`birthday` DATE,
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
	`sub_auto_renew` INTEGER default 1 NOT NULL,
	`member_counter_id` INTEGER  NOT NULL,
	`public_search` INTEGER default 0 NOT NULL,
	`last_ip` INTEGER,
	`last_paypal_subscr_id` VARCHAR(255),
	`last_paypal_item` VARCHAR(255),
	`paypal_unsubscribed_at` DATETIME,
	`last_paypal_payment_at` DATETIME,
	`last_activity` DATETIME,
	`last_status_change` DATETIME,
	`last_flagged` DATETIME,
	`last_login` DATETIME,
	`last_winks_view` DATETIME,
	`last_hotlist_view` DATETIME,
	`last_profile_view` DATETIME,
	`last_activity_notification` DATETIME,
	`created_at` DATETIME,
	`dashboard_msg` INTEGER(1) default 0,
	`imbra_payment` VARCHAR(100),
	`original_first_name` VARCHAR(80)  NOT NULL,
	`original_last_name` VARCHAR(80)  NOT NULL,
	PRIMARY KEY (`id`),
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
	INDEX `member_FI_3` (`state_id`),
	CONSTRAINT `member_FK_3`
		FOREIGN KEY (`state_id`)
		REFERENCES `state` (`id`)
		ON DELETE RESTRICT,
	INDEX `member_FI_4` (`main_photo_id`),
	CONSTRAINT `member_FK_4`
		FOREIGN KEY (`main_photo_id`)
		REFERENCES `member_photo` (`id`)
		ON DELETE SET NULL,
	INDEX `member_FI_5` (`subscription_id`),
	CONSTRAINT `member_FK_5`
		FOREIGN KEY (`subscription_id`)
		REFERENCES `subscription` (`id`)
		ON DELETE RESTRICT,
	INDEX `member_FI_6` (`member_counter_id`),
	CONSTRAINT `member_FK_6`
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
	`received_winks` INTEGER default 0 NOT NULL,
	`read_messages` INTEGER default 0 NOT NULL,
	`sent_messages` INTEGER default 0 NOT NULL,
	`received_messages` INTEGER default 0 NOT NULL,
	`reply_messages` INTEGER default 0 NOT NULL,
	`unsuspensions` INTEGER default 0 NOT NULL,
	`assistant_contacts` INTEGER default 0 NOT NULL,
	`profile_views` INTEGER default 0 NOT NULL,
	`made_profile_views` INTEGER default 0 NOT NULL,
	`hotlist` INTEGER default 0 NOT NULL,
	`on_others_hotlist` INTEGER default 0 NOT NULL,
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
	`custom` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `member_desc_answer_FI_1` (`member_id`),
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
	INDEX `search_crit_desc_FI_1` (`member_id`),
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
	`is_main` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `member_photo_FI_1` (`member_id`),
	CONSTRAINT `member_photo_FK_1`
		FOREIGN KEY (`member_id`)
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
	`gender` CHAR(1) default 'M' NOT NULL,
	`homepages` VARCHAR(255),
	`homepages_set` TINYINT,
	`homepages_pos` TINYINT,
	`assistants` VARCHAR(255),
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- imbra_question
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `imbra_question`;


CREATE TABLE `imbra_question`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`only_explain` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- imbra_question_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `imbra_question_i18n`;


CREATE TABLE `imbra_question_i18n`
(
	`title` TEXT,
	`explain_title` TEXT,
	`positive_answer` TEXT,
	`negative_answer` TEXT,
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `imbra_question_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `imbra_question` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- imbra_status
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `imbra_status`;


CREATE TABLE `imbra_status`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(80),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- imbra_reply_template
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `imbra_reply_template`;


CREATE TABLE `imbra_reply_template`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER,
	`title` VARCHAR(255),
	`subject` VARCHAR(255),
	`body` TEXT,
	`footer` TEXT,
	`mail_from` VARCHAR(255),
	`reply_to` VARCHAR(255),
	`bcc` VARCHAR(255),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `imbra_reply_template_FI_1` (`user_id`),
	CONSTRAINT `imbra_reply_template_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_imbra
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_imbra`;


CREATE TABLE `member_imbra`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_id` INTEGER  NOT NULL,
	`imbra_status_id` INTEGER  NOT NULL,
	`name` VARCHAR(100),
	`dob` VARCHAR(100),
	`address` VARCHAR(255),
	`city` VARCHAR(100),
	`state_id` INTEGER,
	`zip` VARCHAR(20),
	`phone` VARCHAR(30),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `member_imbra_FI_1` (`member_id`),
	CONSTRAINT `member_imbra_FK_1`
		FOREIGN KEY (`member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `member_imbra_FI_2` (`imbra_status_id`),
	CONSTRAINT `member_imbra_FK_2`
		FOREIGN KEY (`imbra_status_id`)
		REFERENCES `imbra_status` (`id`)
		ON DELETE RESTRICT,
	INDEX `member_imbra_FI_3` (`state_id`),
	CONSTRAINT `member_imbra_FK_3`
		FOREIGN KEY (`state_id`)
		REFERENCES `state` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_imbra_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_imbra_i18n`;


CREATE TABLE `member_imbra_i18n`
(
	`text` TEXT,
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `member_imbra_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `member_imbra` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_imbra_answer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_imbra_answer`;


CREATE TABLE `member_imbra_answer`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member_imbra_id` INTEGER  NOT NULL,
	`imbra_question_id` INTEGER  NOT NULL,
	`answer` INTEGER default 0 NOT NULL,
	`explanation` TEXT,
	PRIMARY KEY (`id`),
	INDEX `member_imbra_answer_FI_1` (`member_imbra_id`),
	CONSTRAINT `member_imbra_answer_FK_1`
		FOREIGN KEY (`member_imbra_id`)
		REFERENCES `member_imbra` (`id`)
		ON DELETE CASCADE,
	INDEX `member_imbra_answer_FI_2` (`imbra_question_id`),
	CONSTRAINT `member_imbra_answer_FK_2`
		FOREIGN KEY (`imbra_question_id`)
		REFERENCES `imbra_question` (`id`)
		ON DELETE CASCADE
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
	`created_at` DATETIME,
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
	`can_create_profile` INTEGER default 0 NOT NULL,
	`create_profiles` INTEGER default 0 NOT NULL,
	`can_post_photo` INTEGER default 0 NOT NULL,
	`post_photos` INTEGER default 0 NOT NULL,
	`can_wink` INTEGER default 0 NOT NULL,
	`winks` INTEGER default 0 NOT NULL,
	`can_read_messages` INTEGER default 0 NOT NULL,
	`read_messages` INTEGER default 0 NOT NULL,
	`can_reply_messages` INTEGER default 0 NOT NULL,
	`reply_messages` INTEGER default 0 NOT NULL,
	`can_send_messages` INTEGER default 0 NOT NULL,
	`send_messages` INTEGER default 0 NOT NULL,
	`can_see_viewed` INTEGER default 0 NOT NULL,
	`see_viewed` INTEGER default 0 NOT NULL,
	`can_contact_assistant` INTEGER default 0 NOT NULL,
	`contact_assistant` INTEGER default 0 NOT NULL,
	`pre_approve` INTEGER default 0 NOT NULL,
	`amount` DECIMAL(7,2)  NOT NULL,
	`trial1_amount` DECIMAL(7,2)  NOT NULL,
	`trial1_period` INTEGER  NOT NULL,
	`trial1_period_type` CHAR(1)  NOT NULL,
	`trial2_amount` DECIMAL(7,2)  NOT NULL,
	`trial2_period` INTEGER  NOT NULL,
	`trial2_period_type` CHAR(1)  NOT NULL,
	PRIMARY KEY (`id`)
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
#-- message
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `message`;


CREATE TABLE `message`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`from_member_id` INTEGER  NOT NULL,
	`to_member_id` INTEGER  NOT NULL,
	`subject` VARCHAR(255),
	`content` TEXT,
	`sent_box` INTEGER default 0 NOT NULL,
	`is_read` INTEGER default 0 NOT NULL,
	`is_reviewed` INTEGER default 0 NOT NULL,
	`is_replied` INTEGER default 0 NOT NULL,
	`is_system` INTEGER default 0 NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `message_FI_1` (`from_member_id`),
	CONSTRAINT `message_FK_1`
		FOREIGN KEY (`from_member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `message_FI_2` (`to_member_id`),
	CONSTRAINT `message_FK_2`
		FOREIGN KEY (`to_member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
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
#-- flag_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `flag_category`;


CREATE TABLE `flag_category`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
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
	`flag_category_id` INTEGER  NOT NULL,
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
		ON DELETE CASCADE,
	INDEX `flag_FI_3` (`flag_category_id`),
	CONSTRAINT `flag_FK_3`
		FOREIGN KEY (`flag_category_id`)
		REFERENCES `flag_category` (`id`)
		ON DELETE RESTRICT
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
	`date_created` INTEGER(11) default 0 NOT NULL,
	`date_modified` INTEGER(11) default 0 NOT NULL,
	`author` VARCHAR(255) default '' NOT NULL,
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
	`source` TEXT  NOT NULL,
	`target` TEXT  NOT NULL,
	`comments` TEXT,
	`author` VARCHAR(255) default '' NOT NULL,
	`translated` INTEGER default 0 NOT NULL,
	`tags` TEXT,
	`link` TEXT,
	`date_added` INTEGER(11) default 0 NOT NULL,
	`date_modified` INTEGER(11) default 0 NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `trans_unit_FI_1` (`cat_id`),
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
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- static_page_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `static_page_i18n`;


CREATE TABLE `static_page_i18n`
(
	`link_name` VARCHAR(100),
	`title` VARCHAR(255)  NOT NULL,
	`keywords` VARCHAR(255),
	`description` TEXT,
	`content` TEXT  NOT NULL,
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `static_page_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `static_page` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_story
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_story`;


CREATE TABLE `member_story`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`culture` VARCHAR(7),
	`slug` VARCHAR(255)  NOT NULL,
	`sort_order` INTEGER(11) default 0 NOT NULL,
	`link_name` VARCHAR(100)  NOT NULL,
	`title` VARCHAR(255)  NOT NULL,
	`keywords` VARCHAR(255)  NOT NULL,
	`description` TEXT  NOT NULL,
	`content` TEXT  NOT NULL,
	`stock_photo_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `member_story_FI_1` (`stock_photo_id`),
	CONSTRAINT `member_story_FK_1`
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
	`homepage_culture` VARCHAR(7),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- notification
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `notification`;


CREATE TABLE `notification`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`send_from` VARCHAR(255),
	`send_to` VARCHAR(255),
	`reply_to` VARCHAR(255),
	`bcc` VARCHAR(255),
	`trigger_name` VARCHAR(255),
	`subject` VARCHAR(255),
	`body` TEXT,
	`footer` TEXT,
	`is_active` INTEGER default 0 NOT NULL,
	`to_admins` INTEGER default 0 NOT NULL,
	`days` INTEGER,
	`whn` CHAR(1),
	PRIMARY KEY (`id`)
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
	INDEX `notification_event_FI_1` (`notification_id`),
	CONSTRAINT `notification_event_FK_1`
		FOREIGN KEY (`notification_id`)
		REFERENCES `notification` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- web_email
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `web_email`;


CREATE TABLE `web_email`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`subject` VARCHAR(255),
	`body` TEXT,
	`hash` CHAR(40)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- member_match
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `member_match`;


CREATE TABLE `member_match`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`member1_id` INTEGER  NOT NULL,
	`member2_id` INTEGER  NOT NULL,
	`pct` TINYINT default 0 NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `member_match_FI_1` (`member1_id`),
	CONSTRAINT `member_match_FK_1`
		FOREIGN KEY (`member1_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `member_match_FI_2` (`member2_id`),
	CONSTRAINT `member_match_FK_2`
		FOREIGN KEY (`member2_id`)
		REFERENCES `member` (`id`)
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
	`request_ip` INTEGER,
	`txn_type` VARCHAR(255),
	`txn_id` VARCHAR(255),
	`subscr_id` VARCHAR(255),
	`payment_status` VARCHAR(255),
	`paypal_response` VARCHAR(8),
	`is_renewal` INTEGER default 0 NOT NULL,
	`member_subscr_id` INTEGER,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- message_draft
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `message_draft`;


CREATE TABLE `message_draft`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`from_member_id` INTEGER  NOT NULL,
	`to_member_id` INTEGER  NOT NULL,
	`subject` VARCHAR(255),
	`content` TEXT,
	`reply_to` INTEGER,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `message_draft_FI_1` (`from_member_id`),
	CONSTRAINT `message_draft_FK_1`
		FOREIGN KEY (`from_member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE,
	INDEX `message_draft_FI_2` (`to_member_id`),
	CONSTRAINT `message_draft_FK_2`
		FOREIGN KEY (`to_member_id`)
		REFERENCES `member` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
