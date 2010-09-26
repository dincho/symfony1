<?php

/**
 * Migrations between versions 033 and 034.
 */
class Migration034 extends sfMigration
{
    /**
    * Migrate up to version 034.
    */
    public function up()
    {
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 033.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
