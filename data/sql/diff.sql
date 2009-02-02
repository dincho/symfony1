ALTER TABLE `imbra_reply_template` ADD CONSTRAINT `imbra_reply_template_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`);
ALTER TABLE `subscription` ADD `can_create_profile` INTEGER default 0 NOT NULL;
ALTER TABLE `subscription` ADD `create_profiles` INTEGER default 0 NOT NULL;
/* old definition: int(11) NOT NULL auto_increment
   new definition: INTEGER(11)  NOT NULL AUTO_INCREMENT */
ALTER TABLE `catalogue` CHANGE `cat_id` `cat_id` INTEGER(11)  NOT NULL AUTO_INCREMENT;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `catalogue` CHANGE `date_created` `date_created` INTEGER(11) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `catalogue` CHANGE `date_modified` `date_modified` INTEGER(11) default 0 NOT NULL;
/* old definition: CONSTRAINT `imbra_reply_template_FK_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
   new definition: CONSTRAINT `imbra_reply_template_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`) */
ALTER TABLE `imbra_reply_template` DROP FOREIGN KEY `imbra_reply_template_FK_1`;
ALTER TABLE `imbra_reply_template` ADD CONSTRAINT `imbra_reply_template_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`);
/* old definition: int(1) default '0'
   new definition: INTEGER(1) default 0 */
ALTER TABLE `ipblock` CHANGE `item_type` `item_type` INTEGER(1) default 0;
/* old definition: int(2) default '24'
   new definition: INTEGER(2) default 24 */
ALTER TABLE `ipblock` CHANGE `netmask` `netmask` INTEGER(2) default 24;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `member_story` CHANGE `sort_order` `sort_order` INTEGER(11) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '1'
   new definition: INTEGER(11) default 1 NOT NULL */
ALTER TABLE `trans_unit` CHANGE `cat_id` `cat_id` INTEGER(11) default 1 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `trans_unit` CHANGE `date_modified` `date_modified` INTEGER(11) default 0 NOT NULL;
/* old definition: int(11) NOT NULL default '0'
   new definition: INTEGER(11) default 0 NOT NULL */
ALTER TABLE `trans_unit` CHANGE `date_added` `date_added` INTEGER(11) default 0 NOT NULL;
ALTER TABLE `wink` DROP INDEX deleted_at;
