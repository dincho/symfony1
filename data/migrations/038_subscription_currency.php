<?php

/**
 * Migrations between versions 037 and 038.
 */
class Migration038 extends sfMigration
{
    /**
    * Migrate up to version 038.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `subscription_details` ADD `currency` CHAR(3)  NOT NULL  DEFAULT ''  AFTER `amount`");
        $this->executeSQL("UPDATE `subscription_details` SET `currency` = 'PLN'");
        
        $this->executeSQL('DELETE FROM `sf_setting` WHERE `name` = "currency_en"');
        $this->executeSQL('DELETE FROM `sf_setting` WHERE `name` = "currency_pl"');
    }

    /**
    * Migrate down to version 037.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `subscription_details` DROP COLUMN `currency`");
        
        $this->executeSQL("INSERT INTO `sf_setting` (`env`, `name`, `value`, `description`, `created_at`, `updated_at`) VALUES
                                                    ('all', 'currency_en', 'PLN', 'English currency', NOW(), NOW())");
                                                    
        $this->executeSQL("INSERT INTO `sf_setting` (`env`, `name`, `value`, `description`, `created_at`, `updated_at`) VALUES
                                                    ('all', 'currency_pl', 'PLN', 'Polish currency', NOW(), NOW())");                                                    
    }
}
