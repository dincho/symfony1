INSERT INTO `catalogue` (`cat_id`, `name`, `source_lang`, `target_lang`, `date_created`, `date_modified`, `author`, `domain`, `shared_catalogs`)
VALUES
    (20, 'www.ashley.pl.messages.pl', 'en', 'pl', 1430142180, 1430142180, '', 'www.ashley.pl', NULL),
    (21, 'www.ishchumillionera.com.messages.com', 'en', 'ru', 1430142180, 1430142180, '', 'www.ishchumillionera.com', NULL);

INSERT INTO `trans_unit` (`id`,`cat_id`,`source`,`target`,`comments`,`author`,`translated`,`date_modified`,`msg_collection_id`,`date_added`,`tags`,`link`)
    SELECT NULL, 20, `source`,`target`,`comments`,`author`,`translated`,UNIX_TIMESTAMP(),`msg_collection_id`,UNIX_TIMESTAMP(),`tags`,`link` 
    FROM `trans_unit`
    WHERE `cat_id` = 1;

INSERT INTO `subscription_details` (`id`, `subscription_id`, `cat_id`, `can_create_profile`, `create_profiles`, 
                 `can_post_photo`, `post_photos`, `can_post_private_photo`, `post_private_photos`, `can_wink`, 
                 `winks`, `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, `can_reply_messages`, 
                 `reply_messages`, `reply_messages_day`, `can_send_messages`, `send_messages`, `send_messages_day`, 
                 `can_see_viewed`, `see_viewed`, `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, 
                 `private_dating`, `pre_approve`, `amount`, `currency`, `period`, `period_type`)
    SELECT NULL, `subscription_id`, 20, `can_create_profile`, `create_profiles`, `can_post_photo`, `post_photos`, `can_post_private_photo`,
                 `post_private_photos`, `can_wink`, `winks`, `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, `can_reply_messages`,
                 `reply_messages`, `reply_messages_day`, `can_send_messages`, `send_messages`, `send_messages_day`, `can_see_viewed`, `see_viewed`,
                 `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, `private_dating`, `pre_approve`, `amount`, `currency`, `period`,`period_type`
    FROM `subscription_details`
    WHERE `cat_id` = 1;

INSERT INTO `static_page_domain` (`link_name`, `title`, `keywords`, `description`, `content`, `id`, `updated_at`, `cat_id`)
    SELECT `link_name`, `title`, `keywords`, `description`, `content`, `id`, NOW(), 20
    FROM `static_page_domain`
    WHERE `cat_id` = 1;

INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
    SELECT 20, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`
    FROM `sf_setting`
    WHERE `cat_id` = 1;

INSERT INTO `notification` (`send_from`, `send_to`, `reply_to`, `bcc`, `subject`, `body`, `footer`, `id`, `mail_config`, `cat_id`, `name`, `trigger_name`, `is_active`, `to_admins`, `days`, `whn`)
    SELECT `send_from`, `send_to`, `reply_to`, `bcc`, `subject`, `body`, `footer`, `id`, `mail_config`, 20, `name`, `trigger_name`, `is_active`, `to_admins`, `days`, `whn`
    FROM `notification`
    WHERE `cat_id` = 1;

INSERT INTO `trans_unit` (`id`,`cat_id`,`source`,`target`,`comments`,`author`,`translated`,`date_modified`,`msg_collection_id`,`date_added`,`tags`,`link`)
    SELECT NULL, 21, `source`,`target`,`comments`,`author`,`translated`,UNIX_TIMESTAMP(),`msg_collection_id`,UNIX_TIMESTAMP(),`tags`,`link` 
    FROM `trans_unit`
    WHERE `cat_id` = 1;

INSERT INTO `subscription_details` (`id`, `subscription_id`, `cat_id`, `can_create_profile`, `create_profiles`, 
                 `can_post_photo`, `post_photos`, `can_post_private_photo`, `post_private_photos`, `can_wink`, 
                 `winks`, `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, `can_reply_messages`, 
                 `reply_messages`, `reply_messages_day`, `can_send_messages`, `send_messages`, `send_messages_day`, 
                 `can_see_viewed`, `see_viewed`, `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, 
                 `private_dating`, `pre_approve`, `amount`, `currency`, `period`, `period_type`)
    SELECT NULL, `subscription_id`, 21, `can_create_profile`, `create_profiles`, `can_post_photo`, `post_photos`, `can_post_private_photo`,
                 `post_private_photos`, `can_wink`, `winks`, `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, `can_reply_messages`,
                 `reply_messages`, `reply_messages_day`, `can_send_messages`, `send_messages`, `send_messages_day`, `can_see_viewed`, `see_viewed`,
                 `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, `private_dating`, `pre_approve`, `amount`, `currency`, `period`,`period_type`
    FROM `subscription_details`
    WHERE `cat_id` = 1;

INSERT INTO `static_page_domain` (`link_name`, `title`, `keywords`, `description`, `content`, `id`, `updated_at`, `cat_id`)
    SELECT `link_name`, `title`, `keywords`, `description`, `content`, `id`, NOW(), 21
    FROM `static_page_domain`
    WHERE `cat_id` = 1;

INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
    SELECT 21, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`
    FROM `sf_setting`
    WHERE `cat_id` = 1;

INSERT INTO `notification` (`send_from`, `send_to`, `reply_to`, `bcc`, `subject`, `body`, `footer`, `id`, `mail_config`, `cat_id`, `name`, `trigger_name`, `is_active`, `to_admins`, `days`, `whn`)
    SELECT `send_from`, `send_to`, `reply_to`, `bcc`, `subject`, `body`, `footer`, `id`, `mail_config`, 21, `name`, `trigger_name`, `is_active`, `to_admins`, `days`, `whn`
    FROM `notification`
    WHERE `cat_id` = 1;

UPDATE `member` SET catalog_id = '18' WHERE catalog_id = '15';

SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM `notification` WHERE cat_id = 15 OR cat_id = 19;
SET FOREIGN_KEY_CHECKS = 1;

DELETE FROM `static_page_domain` WHERE cat_id = 15 OR cat_id = 19;
DELETE FROM `subscription_details` WHERE cat_id = 15 OR cat_id = 19;
DELETE FROM `sf_setting` WHERE cat_id = 15 OR cat_id = 19;
DELETE FROM `trans_unit` WHERE cat_id = 15 OR cat_id = 19;
DELETE FROM `catalogue` WHERE cat_id = 15 OR cat_id = 19;
