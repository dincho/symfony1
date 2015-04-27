<?php

/**
 * Migrations between versions 011 and 012.
 */
class Migration012 extends sfMigration
{
    /**
    * Migrate up to version 012.
    */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/012/012_add_new_domain_up.sql');
    }

    /**
    * Migrate down to version 011.
    */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/012/012_add_new_domain_down.sql');
    }
}
