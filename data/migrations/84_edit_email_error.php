<?php

/**
 * Migrations between version 084.
 */
class Migration084 extends sfMigration
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