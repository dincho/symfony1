<?php

/**
 * Migrations between versions 032 and 033.
 */
class Migration033 extends sfMigration
{
    /**
    * Migrate up to version 033.
    */
    public function up()
    {
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 032.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
