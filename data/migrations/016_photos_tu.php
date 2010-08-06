<?php

/**
 * Migrations between versions 015 and 016.
 */
class Migration016 extends sfMigration
{
    /**
    * Migrate up to version 016.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 015.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
