<?php

/**
 * Migrations between versions 088 and 089.
 */
class Migration089 extends sfMigration
{
    /**
    * Migrate up to version 089.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `member` ADD `hide_visits` INTEGER default 0 NOT NULL");
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 088.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `member` DROP `hide_visits`");
        $this->deleteTransUnits();
    }
}
