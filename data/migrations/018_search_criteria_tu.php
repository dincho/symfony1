<?php

/**
 * Migrations between versions 017 and 018.
 */
class Migration018 extends sfMigration
{
    /**
    * Migrate up to version 018.
    */
    public function up()
    {
        $this->loadSqlFixtures();
        
        $this->loadTransUnits();        
    }

    /**
    * Migrate down to version 017.
    */
    public function down()
    {
        $this->deleteTransUnits();

        $this->executeSQL('UPDATE `polish_romance`.`desc_question` SET `factor_title` = "" WHERE `desc_question`.`id` =16;');        
        $this->executeSQL('UPDATE `polish_romance`.`desc_question` SET `factor_title` = "" WHERE `desc_question`.`id` =17;');        
        $this->executeSQL('UPDATE `polish_romance`.`desc_question` SET `factor_title` = "" WHERE `desc_question`.`id` =18;');        
    }
}
