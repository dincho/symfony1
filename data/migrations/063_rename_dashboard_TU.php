<?php

/**
 * Migrations between versions 062 and 063.
 */
class Migration063 extends sfMigration
{
    /**
    * Migrate up to version 063.
    */
    public function up()
    {
        //remove '\r' no undo
        $this->executeSQL("UPDATE `trans_unit` SET `source` =  SUBSTR( `source`, 1, LENGTH(source) - 1 ) WHERE `source` LIKE '%\r';");
        $this->executeSQL("UPDATE `trans_unit` SET `source` =  CONCAT_WS(' ', `source`, '( %count% )' ) WHERE `source` IN ('Newly registered', 'Most recent visitors', 'Best matching you', 'You match them best', 'Best mutual matches', 'Per your own rating');");
    }

    /**
    * Migrate down to version 062.
    */
    public function down()
    {
        $this->executeSQL("UPDATE `trans_unit` SET `source` = SUBSTR( `source` , 1, LENGTH( source ) - LENGTH( ' ( %count% )' ) ) WHERE `source` IN ('Newly registered ( %count% )','Most recent visitors ( %count% )','Best matching you ( %count% )','You match them best ( %count% )','Best mutual matches ( %count% )','Per your own rating ( %count% )');");
    }
}
