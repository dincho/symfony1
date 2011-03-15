<?php

/**
 * Migrations between versions 058 and 059.
 */
class Migration059 extends sfMigration
{
    /**
    * Migrate up to version 059.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 058.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
