<?php

/**
 * Migrations between versions 050 and 051.
 */
class Migration051 extends sfMigration
{
    /**
    * Migrate up to version 051.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `trans_unit` CHANGE `source` `source` VARBINARY( 220 ) NOT NULL DEFAULT ''");
        $this->loadTransUnits();                
    }

    /**
    * Migrate down to version 050.
    */
    public function down()
    {
        $this->deleteTransUnits();        
        $this->executeSQL("ALTER TABLE `trans_unit` CHANGE `source` `source` VARCHAR( 220 ) NOT NULL DEFAULT ''");
    }
}
