<?php

/**
 * Migrations between versions 095 and 096.
 */
class Migration096 extends sfMigration
{
    /**
    * Migrate up to version 096.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 095.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
