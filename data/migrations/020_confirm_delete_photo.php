<?php

/**
 * Migrations between versions 019 and 020.
 */
class Migration020 extends sfMigration
{
    /**
    * Migrate up to version 020.
    */
    public function up()
    {
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 019.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
