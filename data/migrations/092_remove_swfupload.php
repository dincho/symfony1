<?php

/**
 * Migrations between versions 091 and 092.
 */
class Migration092 extends sfMigration
{
    /**
    * Migrate up to version 092.
    */
    public function up()
    {
        // remove obsolete TUs
        $this->deleteTransUnits();
    }

    /**
    * Migrate down to version 091.
    */
    public function down()
    {
        $this->loadTransUnits();
    }
}
