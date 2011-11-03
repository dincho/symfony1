<?php

/**
 * Migrations between versions 070 and 071.
 */
class Migration071 extends sfMigration
{
    /**
    * Migrate up to version 071.
    */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `member_photo` ADD `cropped_at` DATETIME');
    }

    /**
    * Migrate down to version 070.
    */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `member_photo` DROP `cropped_at`');
    }
}
