<?php

/**
 * Migrations between versions 096 and 097.
 */
class Migration097 extends sfMigration
{
    /**
    * Migrate up to version 097.
    */
    public function up()
    {
        // remove obsolete TUs
        $this->deleteTransUnits();
    }

    /**
    * Migrate down to version 096.
    */
    public function down()
    {
        $this->loadTransUnits();
    }
}
