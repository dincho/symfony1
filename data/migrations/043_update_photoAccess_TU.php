<?php

/**
 * Migrations between versions 042 and 043.
 */
class Migration043 extends sfMigration
{
    /**
    * Migrate up to version 043.
    */
    public function up()
    {
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 042.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
