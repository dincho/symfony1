<?php

/**
 * Migrations between versions 024 and 025.
 */
class Migration025 extends sfMigration
{
    /**
    * Migrate up to version 025.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 024.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
