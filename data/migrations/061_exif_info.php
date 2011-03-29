<?php

/**
 * Migrations between versions 060 and 061.
 */
class Migration061 extends sfMigration
{
    /**
    * Migrate up to version 061.
    */
    public function up()
    {
        $this->executeSQL("CREATE TABLE IF NOT EXISTS `photo_exif_info` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `photo_id` int(11) NOT NULL,
              `exif_info` varchar(8192) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `photo_id` (`photo_id`)
              ) ENGINE=InnoDB;");        
    }

    /**
    * Migrate down to version 060.
    */
    public function down()
    {
        $this->executeSQL("DROP TABLE IF EXISTS `photo_exif_info`;");        
    }
}
