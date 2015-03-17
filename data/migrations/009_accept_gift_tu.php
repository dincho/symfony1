<?php

/**
 * Migrations between versions 008 and 009
 */
class Migration009 extends sfMigration
{
    /**
    * Migrate up to version 009
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 008
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
