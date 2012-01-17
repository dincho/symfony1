<?php

/**
 * Migrations between versions 072 and 073.
 */
class Migration073 extends sfMigration
{
    /**
    * Migrate up to version 073.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 072.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
