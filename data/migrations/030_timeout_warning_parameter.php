<?php

/**
 * Migrations between versions 029 and 030.
 */
class Migration030 extends sfMigration
{
    /**
    * Migrate up to version 030.
    */
    public function up()
    {
        $this->executeSQL("INSERT INTO `sf_setting` (`id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`) 
                VALUES (NULL, 'all', 'timeout_warning', '3', 'Timeout warning before session expire in minutes (values 1 .. 29)', NULL, NULL, NULL, NULL, NULL)");
    }

    /**
    * Migrate down to version 029.
    */
    public function down()
    {
        $this->executeSQL("DELETE FROM  `sf_setting` WHERE `name` = 'timeout_warning'");        
    }

}
