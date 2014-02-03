<?php
/**
 * Migrations between versions 089 and 090.
 */
class Migration090 extends sfMigration
{
    /**
     * Migrate up to version 090.
     */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `message` DROP `subject`");
        $this->executeSQL("ALTER TABLE `thread` DROP `subject`");
    }

    /**
     * Migrate down to version 089.
     */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `message` ADD `subject` TEXT");
        $this->executeSQL("ALTER TABLE `thread` ADD `subject` VARCHAR(255)");
    }
}