<?php

/**
 * Migrations between versions 014 and 015.
 */
class Migration015 extends sfMigration
{
    /**
    * Migrate up to version 015.
    */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/015/015_member_notification_up.sql');
    }

    /**
    * Migrate down to version 014.
    */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/015/015_member_notification_down.sql');
    }
}
