<?php

/**
 * Migrations between versions 001 and 002.
 */
class Migration002 extends sfMigration
{
  /**
   * Migrate up to version 002.
   */
  public function up()
  {
      $this->executeSQL("ALTER TABLE `message` CHANGE `sender_id` `sender_id` INTEGER;");
      $this->loadSqlFixtures();
  }

  /**
   * Migrate down to version 001.
   */
  public function down()
  {
      $this->executeSQL("DELETE FROM `notification_event` WHERE `notification_id` = 28 AND `event` = 25");
      $this->executeSQL("DELETE FROM `notification` WHERE (`id`=28 AND `cat_id`=1) OR (`id`=28 AND `cat_id`= 2)");
      $this->executeSQL("ALTER TABLE `message` CHANGE `sender_id` `sender_id` INTEGER  NOT NULL");
  }
}
