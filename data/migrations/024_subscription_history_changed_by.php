<?php

/**
 * Migrations between versions 023 and 024.
 */
class Migration024 extends sfMigration
{
    /**
    * Migrate up to version 024.
    */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `subscription_history` ADD `changed_by` VARCHAR(255) default "unknown"');
    }

    /**
    * Migrate down to version 023.
    */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `subscription_history` DROP column `changed_by`');
    }
}
