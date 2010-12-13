<?php

/**
 * Migrations between versions 047 and 048.
 */
class Migration048 extends sfMigration
{
    /**
    * Migrate up to version 048.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `member` CHANGE `registration_ip` `registration_ip` BIGINT");
        $this->executeSQL("ALTER TABLE `member` CHANGE `last_ip` `last_ip` BIGINT");
        $this->executeSQL("ALTER TABLE `zong_history` CHANGE `request_ip` `request_ip` BIGINT");
        $this->executeSQL("ALTER TABLE `ipn_history` CHANGE `request_ip` `request_ip` BIGINT");
    }

    /**
    * Migrate down to version 047.
    */
    public function down()
    {
        
    }
}
