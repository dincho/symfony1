<?php

class Migration003 extends sfMigration
{

    /**
     * Migrate the schema up, from the version 002 to the current one.
     */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
     * Migrate the schema down to version 002, i.e. undo the modifications made in up()
     */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
