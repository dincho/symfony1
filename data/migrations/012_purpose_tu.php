<?php

/**
 * Migrations between versions 011 and 012.
 */
class Migration012 extends sfMigration
{
    /**
    * Migrate up to version 012.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 011.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
