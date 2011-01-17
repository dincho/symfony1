<?php

/**
 * Migrations between versions 052 and 053.
 */
class Migration053 extends sfMigration
{
    /**
    * Migrate up to version 053.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `message` ADD `is_starred` INT NOT NULL DEFAULT '0'");
    }

    /**
    * Migrate down to version 052.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `message` DROP `is_starred`");
    }
}
