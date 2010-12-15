<?php

/**
 * Migrations between versions 048 and 049.
 */
class Migration049 extends sfMigration
{
    /**
    * Migrate up to version 049.
    */
    public function up()
    {
        $this->loadTransUnits();                
    }

    /**
    * Migrate down to version 048.
    */
    public function down()
    {
        $this->deleteTransUnits();        
    }
}
