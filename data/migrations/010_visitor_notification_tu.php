<?php

/**
 * Migrations between versions 009 and 010.
 */
class Migration010 extends sfMigration
{
    /**
    * Migrate up to version 010.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 009.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
