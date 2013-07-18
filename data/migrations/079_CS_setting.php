<?php

/**
 * Migrations between versions 078 and 079.
 */
class Migration079 extends sfMigration
{
    /**
    * Migrate up to version 079.
    */
    public function up()
    {
        $this->executeSQL("INSERT INTO `sf_setting` (`cat_id`, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`)
                                SELECT 17, `env`, `name`, `value`, `description`, `created_user_id`, `updated_user_id`, `created_at`, `updated_at`, `var_type`
                                            FROM `sf_setting` WHERE `cat_id` = 1");
    }

    /**
    * Migrate down to version 078.
    */
    public function down()
    {
        $this->executeSQL("DELETE FROM sf_setting WHERE cat_id = 17");
    }
}
