<?php

/**
 * Migrations between versions 025 and 026.
 */
class Migration026 extends sfMigration
{
    /**
    * Migrate up to version 026.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 025.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
