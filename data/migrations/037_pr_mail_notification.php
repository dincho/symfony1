<?php

/**
 * Migrations between versions 036 and 037.
 */
class Migration037 extends sfMigration
{
    /**
    * Migrate up to version 037.
    */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `pr_mail_message` ADD `notification_id` INT NOT NULL AFTER `status_message` , ADD `notification_cat` INT NOT NULL AFTER `notification_id`');        
    }

    /**
    * Migrate down to version 036.
    */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `pr_mail_message` DROP `notification_id`, DROP `notification_cat`');        
    }
}
