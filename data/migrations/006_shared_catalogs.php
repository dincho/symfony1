<?php

/**
 * Migrations between versions 005 and 006.
 */
class Migration006 extends sfMigration
{
  /**
   * Migrate up to version 006.
   */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `catalogue` ADD `shared_catalogs` VARCHAR(255)');
        $this->loadSqlFixtures();
    }

    /**
    * Migrate down to version 005.
    */
    public function down()
    {
          $this->executeSQL('ALTER TABLE `catalogue` DROP COLUMN `shared_catalogs`');
    }
}
