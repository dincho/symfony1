<?php

/**
 * Migrations between versions 041 and 042.
 */
class Migration042 extends sfMigration
{
    /**
    * Migrate up to version 042.
    */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/042/042_member_notification_up.sql');        
    }

    /**
    * Migrate down to version 041.
    */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/042/042_member_notification_down.sql');        
    }
}
