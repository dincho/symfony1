<?php

class Migration013 extends sfMigration
{
    /**
     * Migrate the schema up, from the version 012 to the current one.
     */
    public function up()
    {
        $this->loadTransUnits();
        $this->loadSql(dirname(__FILE__).'/fixtures/013/premium_express_subscription_up.sql');
    }

    /**
     * Migrate the schema down to version 013, i.e. undo the modifications made in up()
     */
    public function down()
    {
        $this->deleteTransUnits();
        $this->loadSql(dirname(__FILE__).'/fixtures/013/premium_express_subscription_down.sql');
    }
}
