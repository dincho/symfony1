//Updating imbra reply templates to meet the FS
ALTER TABLE `imbra_reply_template` ADD `user_id` INTEGER;
ALTER TABLE `imbra_reply_template` ADD `created_at` DATETIME;
ALTER TABLE `imbra_reply_template` ADD  INDEX `imbra_reply_template_FI_1` (`user_id`);
ALTER TABLE `imbra_reply_template` ADD CONSTRAINT `imbra_reply_template_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`);
UPDATE `imbra_reply_template` SET `user_id` = 1;
ALTER TABLE `imbra_reply_template` ADD `footer` TEXT;
