ALTER TABLE `member_notification`
  DROP `title`,
  DROP `body`;
ALTER TABLE `member_notification` 
  ADD `profile_id` INT NOT NULL AFTER `member_id`,
  ADD `type` INT NOT NULL AFTER `profile_id`;   
