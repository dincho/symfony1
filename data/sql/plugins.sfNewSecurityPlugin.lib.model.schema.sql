
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- groups
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;


CREATE TABLE `groups`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`group_name` VARCHAR(100)  NOT NULL,
	`group_description` VARCHAR(1000),
	PRIMARY KEY (`id`),
	UNIQUE KEY `groups_group_name_unique` (`group_name`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- permissions
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;


CREATE TABLE `permissions`
(
	`id` INTEGER  NOT NULL,
	`group_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`,`group_id`),
	INDEX `permissions_FI_1` (`group_id`),
	CONSTRAINT `permissions_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- group_and_action
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `group_and_action`;


CREATE TABLE `group_and_action`
(
	`action` VARCHAR(200)  NOT NULL,
	`group_id` INTEGER  NOT NULL,
	PRIMARY KEY (`action`,`group_id`),
	INDEX `group_and_action_FI_1` (`group_id`),
	CONSTRAINT `group_and_action_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
