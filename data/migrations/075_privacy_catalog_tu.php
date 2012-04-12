<?php

/**
 * Migrations between versions 074 and 075.
 */
class Migration075 extends sfMigration
{
    /**
    * Migrate up to version 075.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 074.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
