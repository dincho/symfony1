<?php

/**
 * Migrations between versions 030 and 031.
 */
class Migration031 extends sfMigration
{
    /**
    * Migrate up to version 031.
    */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/031_catalog_subscription_up.sql');
    }

    /**
    * Migrate down to version 030.
    */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/031_catalog_subscription_down.sql');
    }
}
