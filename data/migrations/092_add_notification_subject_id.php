<?php

class Migration092 extends sfMigration
{
    /**
     * Migrate up to version 092.
     */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `member_notification` ADD `subject_id` INT NOT NULL AFTER `type`');
    }

    /**
     * Migrate down to version 091.
     */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `member_notification` DROP `subject_id`');
    }
}
