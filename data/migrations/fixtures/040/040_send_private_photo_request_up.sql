ALTER TABLE `private_photo_permission` 
  ADD `status` ENUM( 'A', 'R' ) NOT NULL AFTER `profile_id` ,
  ADD `type` ENUM( 'P', 'R' ) NOT NULL AFTER `status` ;

ALTER TABLE `private_photo_permission` ADD `updated_at` DATETIME NOT NULL; 

ALTER TABLE `private_photo_permission` DROP PRIMARY KEY ,
  ADD PRIMARY KEY ( `member_id` , `profile_id` , `type` ) ; 

INSERT INTO `notification` (`send_from`, `send_to`, `reply_to`, `bcc`, `subject`, `body`, `footer`, `id`, `mail_config`, `cat_id`, `name`, `trigger_name`, `is_active`, `to_admins`, `days`, `whn`) VALUES
  ('PolishDate <hello@szukammilionera.pl>', NULL, NULL, '', 'Private photo access requested!', 'This message is not a spam. You registered with <a href="http://polishdate.com">PolishDate.com</a> from computer {REGISTRATION_IP} on {CREATED_AT}, using {EMAIL}. \r\n-----------------------------------------------------------------------------\r\nHello {Username}!\r\n\r\nUser {REQUEST_FROM_USERNAME} has just requested an access to your private photos.\r\n<a href="{REQUEST_FROM_PROFILE_URL}">See {REQUEST_FROM_USERNAME} profile now.</a> \r\n\r\nGood luck!\r\n\r\nMonika // hello@polishdate.com //  <a href="http://www.polishdate.com">PolishDate.com</a>\r\n<br />', '-----------------------------------------------------------------------------\r\n<a href="http://polishdate.com/en/dashboard/emailNotifications.html">Unsubscribe</a> | <a href="http://polishdate.com/en/dashboard/deactivate.html">Deactivate Profile</a> | <a href="http://polishdate.com/en/dashboard/deleteYourAccount.html">Close Account</a> | Forgot password? <a href="http://polishdate.com/en/profile/forgotYourPassword.html">Reset it</a>', 32, 'hello@szukammilionera.pl', 1, 'Account activity - private photo access requested', NULL, 1, 0, 0, NULL),
  ('SzukamMilionera <hello@szukammilionera.pl>', NULL, NULL, '', 'Private photo access requested!', 'This message is not a spam. You registered with <a href="http://polishdate.com">PolishDate.com</a> from computer {REGISTRATION_IP} on {CREATED_AT}, using {EMAIL}. \r\n-----------------------------------------------------------------------------\r\nHello {Username}!\r\n\r\nUser {REQUEST_FROM_USERNAME} has just requested an access to your private photos.\r\n<a href="{REQUEST_FROM_PROFILE_URL}">See {REQUEST_FROM_USERNAME} profile now.</a> \r\n\r\nGood luck!\r\n\r\nMonika // hello@polishdate.com //  <a href="http://www.polishdate.com">PolishDate.com</a>\r\n<br />', '-----------------------------------------------------------------------------\r\n<a href="http://polishdate.com/en/dashboard/emailNotifications.html">Unsubscribe</a> | <a href="http://polishdate.com/en/dashboard/deactivate.html">Deactivate Profile</a> | <a href="http://polishdate.com/en/dashboard/deleteYourAccount.html">Close Account</a> | Forgot password? <a href="http://polishdate.com/en/profile/forgotYourPassword.html">Reset it</a>', 32, 'hello@szukammilionera.pl', 2, 'Account activity - private photo access request', NULL, 1, 0, 0, NULL);


INSERT INTO `notification_event` (`id` , `notification_id` , `event`) VALUES (NULL , '32', '29' );

INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`) VALUES
(1, 'all', 'private_photo_requests', '5', 'Private photo requests per day', NULL, NULL, NULL, NULL, NULL);