<?php

/**
 * Migrations between versions 079 and 080.
 */
class Migration080 extends sfMigration
{
    /**
    * Migrate up to version 080.
    */
    public function up()
    {
         $this->executeSQL("INSERT INTO `notification` (`send_from`, `send_to`, `reply_to`, `bcc`, `subject`, `body`, `footer`, `id`, `mail_config`, `cat_id`, `name`, `trigger_name`, `is_active`, `to_admins`, `days`, `whn`)
                                SELECT `send_from`, `send_to`, `reply_to`, `bcc`, `subject`, `body`, `footer`, `id`, `mail_config`, 17, `name`, `trigger_name`, `is_active`, `to_admins`, `days`, `whn`
                                            FROM `notification` WHERE `cat_id` = 1");
    }

    /**
    * Migrate down to version 079.
    */
    public function down()
    {
        $this->executeSQL("DELETE FROM notification WHERE cat_id = 17");
    }
}
