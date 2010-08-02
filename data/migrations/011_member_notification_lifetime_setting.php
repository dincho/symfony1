<?php

/**
 * Migrations between versions 010 and 011.
 */
class Migration011 extends sfMigration
{
    /**
    * Migrate up to version 011.
    */
    public function up()
    {
        $this->loadSqlFixtures();
    }

    /**
    * Migrate down to version 010.
    */
    public function down()
    {
        $this->executeSQL('DELETE FROM `sf_setting` WHERE `name` = "member_notification_lifetime"');
    }
}
