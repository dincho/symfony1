<?php
/**
 * Migrations between versions 090 and 091.
 */
class Migration091 extends sfMigration
{
    /**
     * Migrate up to version 091.
     */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `message` DROP `subject`");
        $this->executeSQL("ALTER TABLE `thread` DROP `subject`");
    }

    /**
     * Migrate down to version 090.
     */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `message` ADD `subject` TEXT");
        $this->executeSQL("ALTER TABLE `thread` ADD `subject` VARCHAR(255)");
    }
}