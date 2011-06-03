<?php

/**
 * Migrations between versions 063 and 064.
 */
class Migration064 extends sfMigration
{
    /**
    * Migrate up to version 064.
    */
    public function up()
    {
        $this->executeSQL("DROP TABLE IF EXISTS `web_email`;");
        $this->executeSQL("ALTER TABLE `pr_mail_message` ADD COLUMN `hash` CHAR(40) NULL AFTER `notification_cat`;");
        $this->executeSQL("CREATE TABLE `pr_mail_sum` (
            	`mail_config` VARCHAR(255) NOT NULL,
            	`cnt` INT(11) NOT NULL,
            	`at` DATE NOT NULL
            )
            ENGINE=InnoDB;");
    }

    /**
    * Migrate down to version 063.
    */
    public function down()
    {
        $this->executeSQL("CREATE TABLE IF NOT EXISTS `web_email` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `subject` varchar(255) DEFAULT NULL,
          `body` text,
          `created_at` datetime DEFAULT NULL,
          `hash` char(40) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
        $this->executeSQL("ALTER TABLE `pr_mail_message` DROP COLUMN `hash`;");
        $this->executeSQL("DROP TABLE `pr_mail_sum`;");
    }
}
