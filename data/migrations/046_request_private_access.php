<?php

/**
 * Migrations between versions 045 and 046.
 */
class Migration046 extends sfMigration
{
    /**
    * Migrate up to version 046.
    */
    public function up()
    {
        $this->loadTransUnits();                
    }

    /**
    * Migrate down to version 045.
    */
    public function down()
    {
        $this->deleteTransUnits();        
    }
}
