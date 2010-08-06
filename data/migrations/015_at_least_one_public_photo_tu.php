<?php

/**
 * Migrations between versions 014 and 015.
 */
class Migration015 extends sfMigration
{
    /**
    * Migrate up to version 015.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 014.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
