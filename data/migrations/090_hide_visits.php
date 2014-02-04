<?php

/**
 * Migrations between versions 089 and 090.
 */
class Migration090 extends sfMigration
{
    /**
    * Migrate up to version 090.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `member` ADD `hide_visits` INTEGER default 0 NOT NULL");
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 089.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `member` DROP `hide_visits`");
        $this->deleteTransUnits();
    }
}
