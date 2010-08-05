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
        $this->executeSQL('ALTER TABLE `pr_mail_message` CHANGE `mail_config_id` `mail_config` varchar(255) NULL DEFAULT NULL');
    }

    /**
    * Migrate down to version 013.
    */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `pr_mail_message` CHANGE `mail_config` `mail_config_id` tinyint(4) NULL DEFAULT NULL');
    }
}
