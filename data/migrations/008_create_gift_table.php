<?php

class Migration008 extends sfMigration
{
    /**
     * Migrate the schema up, from the version 007 to the current one.
     */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/008/008_create_gift_table_up.sql');
    }

    /**
     * Migrate the schema down to version 008, i.e. undo the modifications made in up()
     */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/008/008_create_gift_table_down.sql');
    }
}
