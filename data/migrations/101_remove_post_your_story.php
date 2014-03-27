<?php

class Migration101 extends sfMigration
{
    /**
     * Migrate the schema up, from version 100 to 101.
     */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/101/sf_settings_up.sql');
        $this->deleteTransUnits();
    }

    /**
     * Migrate the schema down to version 100, i.e. undo the modifications made in up()
     */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/101/sf_settings_down.sql');
        $this->loadTransUnits();
    }
}
