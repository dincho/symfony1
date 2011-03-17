<?php

/**
 * Migrations between versions 059 and 060.
 */
class Migration060 extends sfMigration
{
    /**
    * Migrate up to version 060.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 059.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
