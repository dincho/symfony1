<?php

/**
 * Migrations between versions 065 and 066.
 */
class Migration066 extends sfMigration
{
    /**
    * Migrate up to version 066.
    */
    public function up()
    {
        $this->deleteTransUnits();        
    }

    /**
    * Migrate down to version 065.
    */
    public function down()
    {
        $this->loadTransUnits();
    }
}
