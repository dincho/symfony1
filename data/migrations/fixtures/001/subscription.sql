INSERT INTO `subscription` (`id`,`title`,`can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`pre_approve`,`amount`,`can_create_profile`,`create_profiles`,`period`,`period_type`,`winks_day`,`read_messages_day`,`reply_messages_day`,`send_messages_day`,`contact_assistant_day`,`imbra_amount`,`private_dating`)
VALUES
	(1, 'Standard', 1, 6, 1, 3660, 1, 3600, 0, 3660, 0, 3660, 1, 3660, 0, 36, 1, 0.00, 1, 1, 1, 'D', 30, 30, 30, 250, 3, 0.00, 0),
	(2, 'VIP', 1, 6, 1, 1, 1, 10000, 0, 10000, 1, 10000, 1, 10000, 1, 10000, 0, 99.00, 1, 1, 1, 'M', 100, 100, 100, 300, 100, 0.00, 1),
	(3, 'Premium', 1, 6, 1, 10000, 1, 10000, 1, 10000, 1, 10000, 1, 10000, 1, 10000, 0, 82.50, 1, 1, 1, 'M', 100, 100, 100, 100, 100, 0.00, 0);
