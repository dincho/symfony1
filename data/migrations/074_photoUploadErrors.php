<?php

/**
 * Migrations between versions 073 and 074.
 */
class Migration074 extends sfMigration
{
    /**
    * Migrate up to version 074.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 073.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
