<?php

/**
 * Migrations between versions 068 and 069.
 */
class Migration069 extends sfMigration
{
    /**
    * Migrate up to version 069.
    */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `member_subscription` ADD `next_amount` DECIMAL(7,2)  NULL  AFTER `details`');
        $this->executeSQL('ALTER TABLE `member_subscription` ADD `next_currency` VARCHAR(5)  NULL  DEFAULT NULL  AFTER `next_amount`');
    }

    /**
    * Migrate down to version 068.
    */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `member_subscription` DROP `next_amount`');
        $this->executeSQL('ALTER TABLE `member_subscription` DROP `next_currency`');
    }
}
