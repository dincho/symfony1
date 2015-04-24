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

