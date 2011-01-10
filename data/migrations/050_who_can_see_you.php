<?php

/**
 * Migrations between versions 049 and 050.
 */
class Migration050 extends sfMigration
{
    /**
    * Migrate up to version 050.
    */
    public function up()
    {
        $this->loadTransUnits();                
    }

    /**
    * Migrate down to version 049.
    */
    public function down()
    {
        $this->deleteTransUnits();        
    }
}
