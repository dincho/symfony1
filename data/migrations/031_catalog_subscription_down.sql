DROP TABLE subscription_details;
SET foreign_key_checks = 0;
TRUNCATE subscription;

ALTER TABLE `subscription` ADD `can_create_profile` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `create_profiles` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `can_post_photo` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `post_photos` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `can_post_private_photo` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `post_private_photos` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `can_wink` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `winks` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `winks_day` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `can_read_messages` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `read_messages` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `read_messages_day` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `can_reply_messages` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `reply_messages` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `reply_messages_day` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `can_send_messages` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `send_messages` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `send_messages_day` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `can_see_viewed` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `see_viewed` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `can_contact_assistant` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `contact_assistant` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `contact_assistant_day` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `private_dating` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `pre_approve` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `amount` DECIMAL(7,2)  NOT NULL;
ALTER TABLE `subscription` ADD `period` INTEGER  NOT NULL;
ALTER TABLE `subscription` ADD `period_type` CHAR(1)  NOT NULL;
ALTER TABLE `subscription` ADD `imbra_amount` DECIMAL(7,2)  NOT NULL;


INSERT INTO `subscription`  (`id`,`title`,`can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,`period`,`period_type`,`winks_day`,`read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,`can_post_private_photo`,`post_private_photos`)
                    VALUES
                    	(1, 'Standard', 1, 6, 1, 3660, 1, 3600, 1, 3660, 1, 3660, 1, 3660, 0, 36, 1, 0.00, 1, 1, 1, 'D', 30, 30, 30, 250, 3, 0.00, 0, 1, 5),
                    	(2, 'VIP', 1, 6, 1, 1, 1, 10000, 1, 10000, 1, 10000, 1, 10000, 1, 10000, 0, 99.00, 1, 1, 1, 'M', 100, 100, 100, 300, 100, 0.00, 1, 1, 5),
                    	(3, 'Premium', 1, 20, 1, 10000, 1, 10000, 1, 10000, 1, 10000, 1, 10000, 1, 10000, 0, 82.50, 1, 1, 1, 'M', 100, 100, 100, 100, 100, 0.00, 0, 1, 20);
SET foreign_key_checks = 1;