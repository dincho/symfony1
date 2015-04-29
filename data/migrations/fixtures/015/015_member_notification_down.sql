CREATE TABLE `member_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_notification_FI_1` (`member_id`),
  CONSTRAINT `member_notification_FK_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;