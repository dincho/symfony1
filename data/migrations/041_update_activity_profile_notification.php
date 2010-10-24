<?php

/**
 * Migrations between versions 040 and 041.
 */
class Migration041 extends sfMigration
{
    /**
    * Migrate up to version 041.
    */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/041/041_update_activity_profile_notification_up.sql');        
    }

    /**
    * Migrate down to version 040.
    */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/041/041_update_activity_profile_notification_down.sql');        
    }
}
