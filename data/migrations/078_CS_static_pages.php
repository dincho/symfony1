<?php

/**
 * Migrations between versions 077 and 078.
 */
class Migration078 extends sfMigration
{
    /**
    * Migrate up to version 078.
    */
    public function up()
    {
        $this->executeSQL("INSERT INTO `static_page_domain` (`link_name`, `title`, `keywords`, `description`, `content`, `id`, `updated_at`, `cat_id`)
                                        SELECT `link_name`, `title`, `keywords`, `description`, `content`, `id`, NOW(), 17
                                                    FROM `static_page_domain` WHERE `cat_id` = 1");
    }

    /**
    * Migrate down to version 077.
    */
    public function down()
    {
        $this->executeSQL('DELETE FROM `static_page_domain` WHERE `cat_id` = 17');
    }
}
