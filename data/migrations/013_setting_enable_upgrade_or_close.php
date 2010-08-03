<?php

/**
 * Migrations between versions 012 and 013.
 */
class Migration013 extends sfMigration
{
    /**
    * Migrate up to version 013.
    */
    public function up()
    {
        $this->loadSqlFixtures();
    }

    /**
    * Migrate down to version 012.
    */
    public function down()
    {
        $this->executeSQL('DELETE FROM `sf_setting` WHERE `name` = "enable_upgrade_or_close"');
    }
}
