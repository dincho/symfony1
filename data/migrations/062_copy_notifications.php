<?php

/**
 * Migrations between versions 061 and 062.
 */
class Migration062 extends sfMigration
{
    /**
    * Migrate up to version 062.
    */
    public function up()
    {
        $this->executeSQL(" DROP TABLE IF EXISTS `notification_temp`;");
        $this->executeSQL(" CREATE TABLE `notification_temp` SELECT * FROM `notification` WHERE to_admins=1;");
        $this->executeSQL(" UPDATE `notification_temp` SET cat_id=2, is_active=0 ;");
        $this->executeSQL(" INSERT INTO `notification` SELECT * FROM `notification_temp`;");
        $this->executeSQL(" DROP TABLE IF EXISTS `notification_temp`;");
        $this->executeSQL(" CREATE TABLE `notification_temp` SELECT * FROM `notification` WHERE cat_id=1;");
        $this->executeSQL(" UPDATE `notification_temp` SET cat_id=15, is_active=0;");
        $this->executeSQL(" INSERT INTO `notification` SELECT * FROM `notification_temp`;");
        $this->executeSQL(" DROP TABLE IF EXISTS `notification_temp`;");
        $this->executeSQL(" CREATE TABLE `notification_temp` SELECT * FROM `notification` WHERE cat_id=2;");
        $this->executeSQL(" UPDATE `notification_temp` SET cat_id=14, is_active=0;");
        $this->executeSQL(" INSERT INTO `notification` SELECT * FROM `notification_temp`;");
        $this->executeSQL(" UPDATE `notification_temp` SET cat_id=16, is_active=0;");
        $this->executeSQL(" INSERT INTO `notification` SELECT * FROM `notification_temp`;");
        $this->executeSQL(" DROP TABLE IF EXISTS `notification_temp`;");        
        
    }

    /**
    * Migrate down to version 061.
    */
    public function down()
    {
        $this->executeSQL(" DELETE FROM  `notification` where to_admins=1 and cat_id=2;");
        $this->executeSQL(" DELETE FROM  `notification` where cat_id in (14,15,16);");        
    }
}
