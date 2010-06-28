<?php

/**
 * Migrations between versions 003 and 004.
 */
class Migration004 extends sfMigration
{
  /**
   * Migrate up to version 004.
   */
  public function up()
  {
    $this->loadSqlFixtures();
  }

  /**
   * Migrate down to version 003.
   */
  public function down()
  {
      $this->executeSQL("DELETE FROM `notification_event` WHERE `notification_id` = 29 AND `event` = 26");
      $this->executeSQL("DELETE FROM `notification_event` WHERE `notification_id` = 30 AND `event` = 27");
      $this->executeSQL("DELETE FROM `notification` WHERE (`id`=29 AND `cat_id`=1) OR (`id`=29 AND `cat_id`= 2)");
      $this->executeSQL("DELETE FROM `notification` WHERE (`id`=30 AND `cat_id`=1) OR (`id`=30 AND `cat_id`= 2)");
  }
}
