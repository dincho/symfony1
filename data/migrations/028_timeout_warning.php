<?php

/**
 * Migrations between versions 027 and 028.
 */
class Migration028 extends sfMigration
{
    /**
    * Migrate up to version 028.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 027.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
