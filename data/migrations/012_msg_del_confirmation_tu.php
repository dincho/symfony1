<?php

/**
 * Migrations between versions 011 and 012
 */
class Migration012 extends sfMigration
{
    /**
     * Migrate up
     */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
     * Migrate down
     */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
