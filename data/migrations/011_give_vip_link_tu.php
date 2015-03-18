<?php

/**
 * Migrations between versions 010 and 011
 */
class Migration011 extends sfMigration
{
    /**
    * Migrate up
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
