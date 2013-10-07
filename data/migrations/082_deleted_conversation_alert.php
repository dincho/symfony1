<?php

/**
 * Migrations between versions 081 and 082.
 */
class Migration082 extends sfMigration
{
    /**
    * Migrate up to version 082.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 081.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
