<?php

class Migration094 extends sfMigration
{
    /**
     * Migrate up to version 094.
     */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `member_notification` ADD `subject_id` INT NOT NULL AFTER `type`');
        $this->loadTransUnits();
    }

    /**
     * Migrate down to version 093.
     */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `member_notification` DROP `subject_id`');
        $this->deleteTransUnits();
    }
}
