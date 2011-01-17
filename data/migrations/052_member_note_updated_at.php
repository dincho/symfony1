<?php

/**
 * Migrations between versions 051 and 052.
 */
class Migration052 extends sfMigration
{
    /**
    * Migrate up to version 052.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `member_note` ADD `updated_at` DATETIME NULL");
    }

    /**
    * Migrate down to version 051.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `member_note` DROP `updated_at`");
    }
}
