<?php

/**
 * Migrations between versions 028 and 029.
 */
class Migration029 extends sfMigration
{
    /**
    * Migrate up to version 029.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 029.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
