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
	`period` INTEGER  NOT NULL,
	`period_type` CHAR(1)  NOT NULL,
	`imbra_amount` DECIMAL(7,2)  NOT NULL,
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


INSERT INTO `subscription_details` (`id`,`subscription_id`, `cat_id`, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,
                                    `can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,
                                    `contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,`period`,`period_type`,`winks_day`,
                                    `read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
                                    `can_post_private_photo`,`post_private_photos`)
SELECT NULL,`id`, 1, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,
            `send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,
            `period`,`period_type`,`winks_day`,`read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
            `can_post_private_photo`,`post_private_photos` FROM `subscription`;
            
INSERT INTO `subscription_details` (`id`,`subscription_id`, `cat_id`, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,
                                    `can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,
                                    `contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,`period`,`period_type`,`winks_day`,
                                    `read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
                                    `can_post_private_photo`,`post_private_photos`)
SELECT NULL,`id`, 2, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,
            `send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,
            `period`,`period_type`,`winks_day`,`read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
            `can_post_private_photo`,`post_private_photos` FROM `subscription`;

INSERT INTO `subscription_details` (`id`,`subscription_id`, `cat_id`, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,
                                    `can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,
                                    `contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,`period`,`period_type`,`winks_day`,
                                    `read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
                                    `can_post_private_photo`,`post_private_photos`)
SELECT NULL,`id`, 3, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,
            `send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,
            `period`,`period_type`,`winks_day`,`read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
            `can_post_private_photo`,`post_private_photos` FROM `subscription`;
            
INSERT INTO `subscription_details` (`id`,`subscription_id`, `cat_id`, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,
                                    `can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,
                                    `contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,`period`,`period_type`,`winks_day`,
                                    `read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
                                    `can_post_private_photo`,`post_private_photos`)
SELECT NULL,`id`, 14, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,
            `send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,
            `period`,`period_type`,`winks_day`,`read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
            `can_post_private_photo`,`post_private_photos` FROM `subscription`;
            
INSERT INTO `subscription_details` (`id`,`subscription_id`, `cat_id`, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,
                                    `can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,
                                    `contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,`period`,`period_type`,`winks_day`,
                                    `read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
                                    `can_post_private_photo`,`post_private_photos`)
SELECT NULL,`id`, 15, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,
            `send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,
            `period`,`period_type`,`winks_day`,`read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
            `can_post_private_photo`,`post_private_photos` FROM `subscription`;
            
INSERT INTO `subscription_details` (`id`,`subscription_id`, `cat_id`, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,
                                    `can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,
                                    `contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,`period`,`period_type`,`winks_day`,
                                    `read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
                                    `can_post_private_photo`,`post_private_photos`)
SELECT NULL,`id`, 16, `can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,
            `send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,
            `period`,`period_type`,`winks_day`,`read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`,
            `can_post_private_photo`,`post_private_photos` FROM `subscription`;

ALTER TABLE `subscription` DROP `can_post_photo`;
ALTER TABLE `subscription` DROP `post_photos`;
ALTER TABLE `subscription` DROP `can_wink`;
ALTER TABLE `subscription` DROP `winks`;
ALTER TABLE `subscription` DROP `can_read_messages`;
ALTER TABLE `subscription` DROP `read_messages`;
ALTER TABLE `subscription` DROP `can_reply_messages`;
ALTER TABLE `subscription` DROP `reply_messages`;
ALTER TABLE `subscription` DROP `can_send_messages`;
ALTER TABLE `subscription` DROP `send_messages`;
ALTER TABLE `subscription` DROP `can_see_viewed`;
ALTER TABLE `subscription` DROP `see_viewed`;
ALTER TABLE `subscription` DROP `can_contact_assistant`;
ALTER TABLE `subscription` DROP `contact_assistant`;
ALTER TABLE `subscription` DROP `pre_approve`;
ALTER TABLE `subscription` DROP `amount`;
ALTER TABLE `subscription` DROP `can_create_profile`;
ALTER TABLE `subscription` DROP `create_profiles`;
ALTER TABLE `subscription` DROP `period`;
ALTER TABLE `subscription` DROP `period_type`;
ALTER TABLE `subscription` DROP `winks_day`;
ALTER TABLE `subscription` DROP `read_messages_day`;
ALTER TABLE `subscription` DROP `reply_messages_day`;
ALTER TABLE `subscription` DROP `send_messages_day`;
ALTER TABLE `subscription` DROP `contact_assistant_day`;
ALTER TABLE `subscription` DROP `imbra_amount`;
ALTER TABLE `subscription` DROP `private_dating`;
ALTER TABLE `subscription` DROP `can_post_private_photo`;
ALTER TABLE `subscription` DROP `post_private_photos`;
            

