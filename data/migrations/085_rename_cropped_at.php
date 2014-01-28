<?php

/**
 * Migrations between versions 084 and 085.
 */
class Migration085 extends sfMigration
{
    /**
    * Migrate up to version 085.
    */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `member_photo` CHANGE COLUMN `cropped_at` `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `sort_order`');
        $this->executeSQL('UPDATE `member_photo` SET `updated_at` = NOW()');
    }

    /**
    * Migrate down to version 084.
    */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `member_photo` CHANGE COLUMN `updated_at` `cropped_at` DATETIME NULL DEFAULT NULL AFTER `sort_order`');
    }
}
