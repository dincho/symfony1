<?php

/**
 * Migrations between version 083 and 084.
 */
class Migration084 extends sfMigration
{
    /**
     * Migrate up to version 084.
     */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
     * Migrate down to version 083.
     */
    public function down()
    {
        $this->deleteTransUnits();
    }
}