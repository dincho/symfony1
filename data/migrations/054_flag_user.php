<?php

/**
 * Migrations between versions 053 and 054.
 */
class Migration054 extends sfMigration
{
    /**
    * Migrate up to version 054.
    */
    public function up()
    {
        $this->loadTransUnits();                
    }

    /**
    * Migrate down to version 053.
    */
    public function down()
    {
        $this->deleteTransUnits();        
    }
}
