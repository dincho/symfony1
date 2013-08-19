<?php

/**
 * Migrations between versions 080 and 081.
 */
class Migration081 extends sfMigration
{
    /**
    * Migrate up to version 081.
    */
    public function up()
    {
        $this->executeSQL("INSERT INTO `catalogue` (`cat_id`,`name`,`source_lang`,`target_lang`,`date_created`,`date_modified`,`author`,`domain`,`shared_catalogs`) VALUES 
                                                    (18,'www.datingbistro.com.messages.en','en','en',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(), '', 'www.datingbistro.com',NULL)");

        $this->executeSQL("INSERT INTO `trans_unit` (`id`,`cat_id`,`source`,`target`,`comments`,`author`,`translated`,`date_modified`,`msg_collection_id`,`date_added`,`tags`,`link`)
                                        SELECT NULL, 18, `source`,`target`,`comments`,`author`,`translated`,UNIX_TIMESTAMP(),`msg_collection_id`,UNIX_TIMESTAMP(),`tags`,`link` 
                                                    FROM `trans_unit` WHERE `cat_id` = 1");

        $this->executeSQL("
            INSERT INTO `subscription_details` (`id`, `subscription_id`, `cat_id`, `can_create_profile`, `create_profiles`, 
                            `can_post_photo`, `post_photos`, `can_post_private_photo`, `post_private_photos`, `can_wink`, 
                            `winks`, `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, `can_reply_messages`, 
                            `reply_messages`, `reply_messages_day`, `can_send_messages`, `send_messages`, `send_messages_day`, 
                            `can_see_viewed`, `see_viewed`, `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, 
                            `private_dating`, `pre_approve`, `amount`, `currency`, `period`, `period_type`, `imbra_amount`)
            SELECT NULL, `subscription_id`, 18, `can_create_profile`, `create_profiles`, 
                            `can_post_photo`, `post_photos`, `can_post_private_photo`, `post_private_photos`, `can_wink`, 
                            `winks`, `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, `can_reply_messages`, 
                            `reply_messages`, `reply_messages_day`, `can_send_messages`, `send_messages`, `send_messages_day`, 
                            `can_see_viewed`, `see_viewed`, `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, 
                            `private_dating`, `pre_approve`, `amount`, `currency`, `period`, `period_type`, `imbra_amount`
                    FROM `subscription_details` WHERE `cat_id` = 1
        ");

        $this->executeSQL("INSERT INTO `static_page_domain` (`link_name`, `title`, `keywords`, `description`, `content`, `id`, `updated_at`, `cat_id`)
                                        SELECT `link_name`, `title`, `keywords`, `description`, `content`, `id`, NOW(), 18
                                                    FROM `static_page_domain` WHERE `cat_id` = 1");

        $this->executeSQL("INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
                                SELECT 18, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`
                                            FROM `sf_setting` WHERE `cat_id` = 1");

         $this->executeSQL("INSERT INTO `notification` (`send_from`, `send_to`, `reply_to`, `bcc`, `subject`, `body`, `footer`, `id`, `mail_config`, `cat_id`, `name`, `trigger_name`, `is_active`, `to_admins`, `days`, `whn`)
                                SELECT `send_from`, `send_to`, `reply_to`, `bcc`, `subject`, `body`, `footer`, `id`, `mail_config`, 18, `name`, `trigger_name`, `is_active`, `to_admins`, `days`, `whn`
                                            FROM `notification` WHERE `cat_id` = 1");
    }

    /**
    * Migrate down to version 080.
    */
    public function down()
    {
        $this->executeSQL('DELETE FROM `trans_unit` WHERE `cat_id` = 18');
        $this->executeSQL('DELETE FROM `catalogue` WHERE `cat_id` = 18');
        $this->executeSQL("DELETE FROM `subscription_details` WHERE `cat_id` = 18");
        $this->executeSQL('DELETE FROM `static_page_domain` WHERE `cat_id` = 18');
        $this->executeSQL("DELETE FROM sf_setting WHERE cat_id = 18");
        $this->executeSQL("DELETE FROM notification WHERE cat_id = 18");
    }
}
