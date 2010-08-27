<?php

/**
 * Migrations between versions 021 and 022.
 */
class Migration022 extends sfMigration
{
    /**
    * Migrate up to version 022.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 021.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
