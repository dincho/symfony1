ALTER TABLE `member` ADD `last_paypal_subscr_id` VARCHAR(255);
ALTER TABLE `member` ADD `last_paypal_item` VARCHAR(255);
ALTER TABLE `member` ADD `paypal_unsubscribed_at` DATETIME;
ALTER TABLE `member` ADD `last_paypal_payment_at` DATETIME;
ALTER TABLE `subscription` ADD `amount` DECIMAL(7,2)  NOT NULL;
ALTER TABLE `subscription` ADD `trial1_amount` DECIMAL(7,2)  NOT NULL;
ALTER TABLE `subscription` ADD `trial1_period` INTEGER  NOT NULL;
ALTER TABLE `subscription` ADD `trial1_period_type` CHAR(1)  NOT NULL;
ALTER TABLE `subscription` ADD `trial2_amount` DECIMAL(7,2)  NOT NULL;
ALTER TABLE `subscription` ADD `trial2_period` INTEGER  NOT NULL;
ALTER TABLE `subscription` ADD `trial2_period_type` CHAR(1)  NOT NULL;
ALTER TABLE `wink` ADD `sent_box` INTEGER default 0 NOT NULL;
ALTER TABLE `wink` ADD `deleted_at` DATETIME;

CREATE TABLE `ipn_history`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`parameters` TEXT,
	`request_ip` INTEGER,
	`txn_type` VARCHAR(255),
	`txn_id` VARCHAR(255),
	`subscr_id` VARCHAR(255),
	`payment_status` VARCHAR(255),
	`paypal_response` VARCHAR(8),
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;
/* old definition: int(11) NOT NULL auto_increment
   new definition: INTEGER(11)  NOT NULL AUTO_INCREMENT */
ALTER TABLE `catalogue` CHANGE `cat_id` `cat_id` INTEGER(11)  NOT NULL AUTO_INCREMENT;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `catalogue` CHANGE `date_created` `date_created` INTEGER(11) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `catalogue` CHANGE `date_modified` `date_modified` INTEGER(11) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `member_story` CHANGE `sort_order` `sort_order` INTEGER(11) default 0 NOT NULL;
ALTER TABLE `subscription` DROP `period1_from`;
ALTER TABLE `subscription` DROP `period1_to`;
ALTER TABLE `subscription` DROP `period1_price`;
ALTER TABLE `subscription` DROP `period2_from`;
ALTER TABLE `subscription` DROP `period2_to`;
ALTER TABLE `subscription` DROP `period2_price`;
ALTER TABLE `subscription` DROP `period3_from`;
ALTER TABLE `subscription` DROP `period3_to`;
ALTER TABLE `subscription` DROP `period3_price`;
/* old definition: int(11) NOT NULL default '1'
   new definition: INTEGER(11) default 1 NOT NULL */
ALTER TABLE `trans_unit` CHANGE `cat_id` `cat_id` INTEGER(11) default 1 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `trans_unit` CHANGE `date_modified` `date_modified` INTEGER(11) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `trans_unit` CHANGE `date_added` `date_added` INTEGER(11) default 0 NOT NULL;
