<?php

/**
 * Migrations between versions 043 and 044.
 */
class Migration044 extends sfMigration
{
    /**
    * Migrate up to version 044.
    */
    public function up()
    {
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 043.
    */
    public function down()
    {
        $this->deleteTransUnits();        
    }
}
