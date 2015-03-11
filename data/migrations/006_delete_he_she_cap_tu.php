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
        $this->deleteTransUnits();
    }

    /**
    * Migrate down to version 005.
    */
    public function down()
    {
        $this->loadTransUnits();
    }
}
