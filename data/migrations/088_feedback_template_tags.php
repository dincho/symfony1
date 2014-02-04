<?php

/**
 * Migrations between versions 087 and 088.
 */
class Migration088 extends sfMigration
{
    /**
    * Migrate up to version 088.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `feedback_template` ADD `tags` TEXT;");
    }

    /**
    * Migrate down to version 087.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `feedback_template` DROP `tags`");
    }
}
