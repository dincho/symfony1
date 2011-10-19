<?php

/**
 * Migrations between versions 069 and 070.
 */
class Migration070 extends sfMigration
{
    /**
    * Migrate up to version 070.
    */
    public function up()
    {
        $this->executeSQL("update `member` set `registration_ip` = `last_ip` where `registration_ip` = inet_aton('127.255.255.255')");                        
    }

    /**
    * Migrate down to version 069.
    */
    public function down()
    {
        
    }
}
