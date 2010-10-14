<?php

/**
 * Migrations between versions 038 and 039.
 */
class Migration039 extends sfMigration
{
    /**
    * Migrate up to version 039.
    */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/039_domain_based_settings.sql');
    }

    /**
    * Migrate down to version 038.
    */
    public function down()
    {
        $this->executeSQL("DELETE FROM `sf_setting` WHERE cat_id != 1");
        $this->executeSQL("ALTER TABLE `sf_setting` DROP FOREIGN KEY `sf_setting_FK_1`");
        $this->executeSQL("ALTER TABLE `sf_setting` DROP PRIMARY KEY");
        $this->executeSQL("ALTER TABLE `sf_setting` DROP `cat_id`");
        $this->executeSQL("ALTER TABLE `sf_setting` ADD `id` INT  NULL  DEFAULT NULL AUTO_INCREMENT  PRIMARY KEY FIRST");
    }
}
