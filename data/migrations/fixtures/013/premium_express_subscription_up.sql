INSERT INTO `subscription` (`id`, `title`) VALUES (4, 'Premium Express');
INSERT INTO `subscription_details`
    SELECT NULL, 4, `cat_id`, `can_create_profile`, `create_profiles`, `can_post_photo`,
            `post_photos`, `can_post_private_photo`, `post_private_photos`, `can_wink`, `winks`, 
            `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, 
            `can_reply_messages`, `reply_messages`, `reply_messages_day`, `can_send_messages`,
            `send_messages`, `send_messages_day`, `can_see_viewed`, `see_viewed`, 
            `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, `private_dating`,
             `pre_approve`, 25.00, "PLN", 1, "D"
        FROM `subscription_details` 
        WHERE `subscription_id` = 3;

CREATE TABLE `dotpay_sms_history`
(
    `id` INTEGER  NOT NULL AUTO_INCREMENT,
    `service` VARCHAR(2)  NOT NULL,
    `ident` VARCHAR(10)  NOT NULL,
    `number` VARCHAR(5)  NOT NULL,
    `sender` VARCHAR(100)  NOT NULL,
    `code` VARCHAR(8)  NOT NULL,
    `text` VARCHAR(160)  NOT NULL,
    `date` DATETIME  NOT NULL,
    `checksum` VARCHAR(32)  NOT NULL,
    `request_ip` BIGINT,
    `created_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;