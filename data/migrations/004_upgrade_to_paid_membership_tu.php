<?php

class Migration004
{
    /**
     * Migrate the schema up, from the version 003 to the current one.
     */
    public function up()
    {
        $this->loadTransUnits();
    }

    /**
     * Migrate the schema down to version 003, i.e. undo the modifications made in up()
     */
    public function down()
    {
        $this->deleteTransUnits();
    }
}
