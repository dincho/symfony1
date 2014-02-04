<?php
/**
 * Migrations between versions 088 and 089.
 */
class Migration089 extends sfMigration
{
    /**
     * Migrate up to version 089.
     */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
     * Migrate down to version 088.
     */
    public function down()
    {
        $this->deleteTransUnits();
    }
}