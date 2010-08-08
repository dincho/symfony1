<?php

/**
 * Migrations between versions 016 and 017.
 */
class Migration017 extends sfMigration
{
    /**
    * Migrate up to version 017.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 016.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
