ALTER TABLE `private_photo_permission`
  DROP `status`,
  DROP `type`,
  DROP `updated_at`;

ALTER IGNORE TABLE `private_photo_permission` DROP PRIMARY KEY , ADD PRIMARY KEY ( `member_id` , `profile_id` );

DELETE FROM `notification` WHERE `id` = 32;
  
DELETE FROM `notification_event` WHERE `notification_id` = 32;

DELETE FROM `sf_setting` WHERE `name` = 'private_photo_requests';