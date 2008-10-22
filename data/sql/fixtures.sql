#Add default superuser
#------------------------------------------------------------

INSERT INTO `user` (`id`, `username`, `password`, `is_superuser`, `is_enabled`) VALUES (1, 'admin', '07bfd45d2383ae5f1af8632d0982e4e2478e21db', 1, 1);


# Dump of table flag_category
# ------------------------------------------------------------

INSERT INTO `flag_category` (`id`,`title`) VALUES ('1','Inappropriate Content');
INSERT INTO `flag_category` (`id`,`title`) VALUES ('2','Spam');
INSERT INTO `flag_category` (`id`,`title`) VALUES ('3','Scam');
INSERT INTO `flag_category` (`id`,`title`) VALUES ('4','Other');


# Dump of table imbra_status
# ------------------------------------------------------------

INSERT INTO `imbra_status` (`id`,`title`) VALUES ('1','Approved');
INSERT INTO `imbra_status` (`id`,`title`) VALUES ('2','Pending');
INSERT INTO `imbra_status` (`id`,`title`) VALUES ('3','Denied');


# Dump of table match_weight
# ------------------------------------------------------------

INSERT INTO `match_weight` (`id`,`title`,`number`) VALUES ('1','Very important','21');
INSERT INTO `match_weight` (`id`,`title`,`number`) VALUES ('2','Important','8');
INSERT INTO `match_weight` (`id`,`title`,`number`) VALUES ('3','Somehow important','3');
INSERT INTO `match_weight` (`id`,`title`,`number`) VALUES ('4','Not important','1');


# Dump of table member_status
# ------------------------------------------------------------

INSERT INTO `member_status` (`id`,`title`) VALUES ('1','Active');
INSERT INTO `member_status` (`id`,`title`) VALUES ('2','Suspended');
INSERT INTO `member_status` (`id`,`title`) VALUES ('3','Canceled');
INSERT INTO `member_status` (`id`,`title`) VALUES ('4','Abandoned');
INSERT INTO `member_status` (`id`,`title`) VALUES ('5','Pending');
INSERT INTO `member_status` (`id`,`title`) VALUES ('6','Deleted');


# Dump of table state
# ------------------------------------------------------------

INSERT INTO `state` (`id`,`country`,`title`) VALUES ('1','us','Alabama');
INSERT INTO `state` (`id`,`country`,`title`) VALUES ('2','us','Florida');


# Dump of table subscription
# ------------------------------------------------------------

INSERT INTO `subscription` (`id`,`title`,`can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`period1_from`,`period1_to`,`period1_price`,`period2_from`,`period2_to`,`period2_price`,`period3_from`,`period3_to`,`period3_price`,`pre_approve`) VALUES ('1','Free Membership','0','1','0','1','0','1','0','1','0','1','0','1','0','1','1','6','302E3030','7','12','302E3030','13','999','302E3030','1');
INSERT INTO `subscription` (`id`,`title`,`can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`period1_from`,`period1_to`,`period1_price`,`period2_from`,`period2_to`,`period2_price`,`period3_from`,`period3_to`,`period3_price`,`pre_approve`) VALUES ('2','Paid Membership','1','100','1','100','1','100','1','100','1','100','1','100','1','100','1','6','31392E3935','7','12','31322E3935','13','999','372E3935','0');
INSERT INTO `subscription` (`id`,`title`,`can_post_photo`,`post_photos`,`can_wink`,`winks`,`can_read_messages`,`read_messages`,`can_reply_messages`,`reply_messages`,`can_send_messages`,`send_messages`,`can_see_viewed`,`see_viewed`,`can_contact_assistant`,`contact_assistant`,`period1_from`,`period1_to`,`period1_price`,`period2_from`,`period2_to`,`period2_price`,`period3_from`,`period3_to`,`period3_price`,`pre_approve`) VALUES ('3','Complimentary Membership','1','100','1','100','1','100','1','100','1','100','1','100','1','100','1','6','302E3030','7','12','302E3030','13','999','302E3030','0');
