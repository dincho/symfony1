<?php

/**
 * Migrations between versions 062 and 063.
 */
class Migration063 extends sfMigration
{
    /**
    * Migrate up to version 063.
    */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
    * Migrate down to version 062.
    */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
