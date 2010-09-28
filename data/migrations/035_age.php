<?php

/**
 * Migrations between versions 034 and 035.
 */
class Migration035 extends sfMigration
{
    /**
    * Migrate up to version 035.
    */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `member` ADD `age` INTEGER');
        $this->executeSQL('UPDATE member SET age = IF( MONTH(CURRENT_DATE) < MONTH(birthday) OR ( (MONTH(CURRENT_DATE) = MONTH(birthday)) AND DAY(CURRENT_DATE) < DAY(birthday) ), 
                               YEAR(CURRENT_DATE) - YEAR(birthday) -1, 
                               YEAR(CURRENT_DATE) - YEAR(birthday))');
    }

    /**
    * Migrate down to version 034.
    */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `member` DROP `age`');
    }
}
