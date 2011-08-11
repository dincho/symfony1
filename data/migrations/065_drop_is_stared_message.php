<?php

/**
 * Migrations between versions 064 and 065.
 */
class Migration065 extends sfMigration
{
    /**
    * Migrate up to version 065.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `message` DROP `is_starred`");        
    }

    /**
    * Migrate down to version 064.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `message` ADD `is_starred` INT NOT NULL DEFAULT '0'");        
    }
}
