<?php

/**
 * Migrations between versions 004 and 005.
 */
class Migration005 extends sfMigration
{
  /**
   * Migrate up to version 005.
   */
  public function up()
  {
    $this->loadSqlFixtures();
      
    $this->executeSQL('ALTER TABLE `member_photo` ADD `is_private` INTEGER default 0 NOT NULL');
    $this->executeSQL('ALTER TABLE `member_photo` ADD `sort_order` INTEGER default 0 NOT NULL');
    $this->executeSQL('UPDATE `member_photo` SET `sort_order` = `id`');
    $this->executeSQL('ALTER TABLE `subscription` ADD `can_post_private_photo` INTEGER default 0 NOT NULL');
    $this->executeSQL('ALTER TABLE `subscription` ADD `post_private_photos` INTEGER default 0 NOT NULL');

    $this->executeSQL('CREATE TABLE `private_photo_permission`
                        (
                            `member_id` INTEGER  NOT NULL,
                            `profile_id` INTEGER  NOT NULL,
                            `created_at` DATETIME,
                            PRIMARY KEY (`member_id`,`profile_id`),
                            CONSTRAINT `private_photo_permission_FK_1`
                                FOREIGN KEY (`member_id`)
                                REFERENCES `member` (`id`)
                                ON DELETE CASCADE,
                            INDEX `private_photo_permission_FI_2` (`profile_id`),
                            CONSTRAINT `private_photo_permission_FK_2`
                                FOREIGN KEY (`profile_id`)
                                REFERENCES `member` (`id`)
                                ON DELETE CASCADE
                        )Type=InnoDB;
                    ');
  }

  /**
   * Migrate down to version 004.
   */
  public function down()
  {
    //fixtures
    $this->executeSQL('DELETE FROM `sf_setting` WHERE `name` = "profile_max_private_photos"');
    $this->executeSQL("DELETE FROM `notification_event` WHERE `notification_id` = 31 AND `event` = 28");
    $this->executeSQL("DELETE FROM `notification` WHERE (`id`=31 AND `cat_id`=1) OR (`id`=31 AND `cat_id`= 2)");
          
    $this->executeSQL('DROP TABLE `private_photo_permission`');
    $this->executeSQL('ALTER TABLE `member_photo` DROP COLUMN `is_private`');
    $this->executeSQL('ALTER TABLE `member_photo` DROP COLUMN `sort_order`');
    $this->executeSQL('ALTER TABLE `subscription` DROP COLUMN `can_post_private_photo`');
    $this->executeSQL('ALTER TABLE `subscription` DROP COLUMN `post_private_photos`');
  }
}
