<?php

/**
 * Migrations between versions 013 and 014.
 */
class Migration014 extends sfMigration
{
    /**
    * Migrate up to version 014.
    */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/014/014_add_new_domain_up.sql');
    }

    /**
    * Migrate down to version 013.
    */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/014/014_add_new_domain_down.sql');
    }
}
