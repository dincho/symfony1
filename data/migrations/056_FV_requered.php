<?php

/**
 * Migrations between versions 055 and 056.
 */
class Migration056 extends sfMigration
{
    /**
    * Migrate up to version 056.
    */
    public function up()
    {
        $this->loadTransUnits();
        $this->executeSQL("INSERT INTO `member_status` (`id`, `title`) VALUES (12 , 'FV required');");        
    }

    /**
    * Migrate down to version 055.
    */
    public function down()
    {
        $this->deleteTransUnits();
        $this->executeSQL("delete FROM  `member_status` WHERE  `id`=12;");
    }
}
