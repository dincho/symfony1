<?php

/**
 * Migrations between versions 094 and 095.
 */
class Migration095 extends sfMigration
{
    /**
    * Migrate up to version 095.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 094.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
