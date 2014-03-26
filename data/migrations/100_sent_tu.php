<?php

class Migration100 extends sfMigration
{

    /**
     * Migrate the schema up, from version 99 to 100.
     */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
     * Migrate the schema down to version 99, i.e. undo the modifications made in up()
     */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
