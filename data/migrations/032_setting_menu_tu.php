<?php

/**
 * Migrations between versions 031 and 032.
 */
class Migration032 extends sfMigration
{
    /**
    * Migrate up to version 032.
    */
    public function up()
    {
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 031.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
