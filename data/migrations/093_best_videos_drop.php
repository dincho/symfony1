<?php

/**
 * Migrations between versions 092 and 093.
 */
class Migration093 extends sfMigration
{
    /**
    * Migrate up to version 093.
    */
    public function up()
    {
        $this->executeSQL("DROP TABLE `best_video_template`");
    }

    /**
    * Migrate down to version 092.
    */
    public function down()
    {
        $this->executeSQL("
            CREATE TABLE `best_video_template` (
              `header` text,
              `body_winner` text,
              `footer` text,
              `id` int(11) NOT NULL,
              `cat_id` int(11) NOT NULL DEFAULT '0',
              `updated_at` datetime DEFAULT NULL,
              PRIMARY KEY (`id`,`cat_id`),
              KEY `best_video_template_FK_1` (`cat_id`),
              CONSTRAINT `best_video_template_FK_1` FOREIGN KEY (`cat_id`) REFERENCES `catalogue` (`cat_id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }
}
