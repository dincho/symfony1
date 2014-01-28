<?php

/**
 * Migrations between versions 085 and 086.
 */
class Migration086 extends sfMigration
{
    /**
     * Migrate up to version 086.
     */
    public function up()
    {
        $this->executeSQL("SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0");
        $this->executeSQL('UPDATE `flag` SET `flag_category_id`=1');
        $this->executeSQL('ALTER TABLE `flag` DROP COLUMN `flag_category_id`, DROP INDEX `flag_FI_3`, DROP FOREIGN KEY `flag_FK_3`');
        $this->executeSQL("DROP TABLE `flag_category`");
        $this->executeSQL("SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS");

        $this->loadTransUnits();
    }

    /**
     * Migrate down to version 085.
     */
    public function down()
    {
        $this->executeSQL("SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0");
        $this->executeSQL("CREATE TABLE `flag_category` (`id` INT(11) NOT NULL AUTO_INCREMENT, `title` VARCHAR(255) NULL DEFAULT NULL, PRIMARY KEY (`id`)) COLLATE='utf8_general_ci' ENGINE=InnoDB");
        $this->executeSQL("INSERT INTO `flag_category` (`id`, `title`) VALUES (1, 'Inappropriate Content');");
        $this->executeSQL("INSERT INTO `flag_category` (`id`, `title`) VALUES (2, 'Spam');");
        $this->executeSQL("INSERT INTO `flag_category` (`id`, `title`) VALUES (3, 'Scam');");
        $this->executeSQL("INSERT INTO `flag_category` (`id`, `title`) VALUES (4, 'Other');");
        $this->executeSQL("ALTER TABLE `flag` ADD COLUMN `flag_category_id` INT(11) NOT NULL AFTER `comment`, ADD INDEX `flag_FI_3` (`flag_category_id`), ADD CONSTRAINT `flag_FK_3` FOREIGN KEY (`flag_category_id`) REFERENCES `flag_category` (`id`)");
        $this->executeSQL("SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS");

        $this->deleteTransUnits();
    }
}
