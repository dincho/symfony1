<?php

/**
 * Migrations between versions 076 and 077.
 */
class Migration077 extends sfMigration
{
    /**
    * Migrate up to version 077.
    */
    public function up()
    {
        $this->executeSQL("
            INSERT INTO `subscription_details` (`id`, `subscription_id`, `cat_id`, `can_create_profile`, `create_profiles`, 
                            `can_post_photo`, `post_photos`, `can_post_private_photo`, `post_private_photos`, `can_wink`, 
                            `winks`, `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, `can_reply_messages`, 
                            `reply_messages`, `reply_messages_day`, `can_send_messages`, `send_messages`, `send_messages_day`, 
                            `can_see_viewed`, `see_viewed`, `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, 
                            `private_dating`, `pre_approve`, `amount`, `currency`, `period`, `period_type`, `imbra_amount`)
            SELECT NULL, `subscription_id`, 17, `can_create_profile`, `create_profiles`, 
                            `can_post_photo`, `post_photos`, `can_post_private_photo`, `post_private_photos`, `can_wink`, 
                            `winks`, `winks_day`, `can_read_messages`, `read_messages`, `read_messages_day`, `can_reply_messages`, 
                            `reply_messages`, `reply_messages_day`, `can_send_messages`, `send_messages`, `send_messages_day`, 
                            `can_see_viewed`, `see_viewed`, `can_contact_assistant`, `contact_assistant`, `contact_assistant_day`, 
                            `private_dating`, `pre_approve`, `amount`, `currency`, `period`, `period_type`, `imbra_amount`
                    FROM `subscription_details` WHERE `cat_id` = 1
        ");

    }

    /**
    * Migrate down to version 076.
    */
    public function down()
    {
        $this->executeSQL("DELETE FROM `subscription_details` WHERE `cat_id` = 17");
    }
}
