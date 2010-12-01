<?php

/**
 * Migrations between versions 046 and 047.
 */
class Migration047 extends sfMigration
{
    /**
    * Migrate up to version 047.
    */
    public function up()
    {
        $this->deleteTransUnits();        
    }

    /**
    * Migrate down to version 046.
    */
    public function down()
    {
        $this->loadTransUnits();                        
    }
}
