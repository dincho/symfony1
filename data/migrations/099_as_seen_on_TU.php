<?php

/**
 * Migrations between versions 097 and 098.
 */
class Migration099 extends sfMigration
{
    /**
     * Migrate up to version 099.
     */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
     * Migrate down to version 098.
     */
    public function down()
    {
        $this->deleteTransUnits();
    }
}