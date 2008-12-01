
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- sf_setting
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_setting`;


CREATE TABLE `sf_setting`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`env` VARCHAR(10),
	`name` VARCHAR(40),
	`value` VARCHAR(100),
	`var_type` VARCHAR(30),
	`description` VARCHAR(255),
	`created_user_id` INTEGER,
	`updated_user_id` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
