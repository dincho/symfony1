<?php

/**
 * Migrations between versions 067 and 068.
 */
class Migration068 extends sfMigration
{
    /**
    * Migrate up to version 068.
    */
    public function up()
    {
        $this->executeSQL("DELETE FROM `photo_exif_info` WHERE `photo_id` NOT IN (SELECT DISTINCT p.id FROM `member_photo` p)");
        $this->executeSQL("ALTER TABLE `photo_exif_info` ADD CONSTRAINT `photo_exif_info_fk` FOREIGN KEY (`photo_id`) REFERENCES `member_photo` (`id`)");
    }

    /**
    * Migrate down to version 067.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `photo_exif_info` DROP FOREIGN KEY `photo_exif_info_fk`;");
    }
}
