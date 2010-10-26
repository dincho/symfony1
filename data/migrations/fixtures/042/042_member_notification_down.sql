ALTER TABLE `member_notification`
  ADD `title` varchar(255) NOT NULL AFTER `member_id`,
  ADD `body` varchar(255) NOT NULL AFTER `title` ;
ALTER TABLE `member_notification`
  DROP `profile_id`,
  DROP `type`;
