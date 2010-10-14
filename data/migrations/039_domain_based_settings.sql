ALTER TABLE `sf_setting` ADD `cat_id` INTEGER(11) default 1 NOT NULL AFTER `id`;
ALTER TABLE `sf_setting` ADD CONSTRAINT `sf_setting_FK_1`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`);
ALTER TABLE `sf_setting` CHANGE `id` `id` INT(11)  NOT NULL;
ALTER TABLE `sf_setting` DROP PRIMARY KEY,        ADD PRIMARY KEY  (`cat_id`,`env`,`name`);
ALTER TABLE `sf_setting` DROP `id`;

INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
    SELECT 2, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type` FROM `sf_setting` WHERE `cat_id` = 1;
    
INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
    SELECT 14, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type` FROM `sf_setting` WHERE `cat_id` = 1;

INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
    SELECT 15, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type` FROM `sf_setting` WHERE `cat_id` = 1;
    
INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
    SELECT 16, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type` FROM `sf_setting` WHERE `cat_id` = 1;
    
INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
    SELECT 17, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type` FROM `sf_setting` WHERE `cat_id` = 1;

