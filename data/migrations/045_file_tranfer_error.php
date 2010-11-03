<?php

/**
 * Migrations between versions 044 and 045.
 */
class Migration045 extends sfMigration
{
    /**
    * Migrate up to version 045.
    */
    public function up()
    {
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 044.
    */
    public function down()
    {
        $this->deleteTransUnits();        
    }
}
