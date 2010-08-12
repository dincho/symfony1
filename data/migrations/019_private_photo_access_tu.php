<?php

/**
 * Migrations between versions 018 and 019.
 */
class Migration019 extends sfMigration
{
    /**
    * Migrate up to version 019.
    */
    public function up()
    {
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 018.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
