<?php


class Migration010 extends sfMigration
{
    /**
     * Migrate the schema up, from version 009 to the current one.
     */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
     * Migrate the schema down to version 009, i.e. undo the modifications made in up()
     */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
