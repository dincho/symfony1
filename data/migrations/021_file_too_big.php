<?php

/**
 * Migrations between versions 020 and 021.
 */
class Migration021 extends sfMigration
{
    /**
    * Migrate up to version 021.
    */
    public function up()
    {
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 020.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
