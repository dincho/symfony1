<?php

/**
 * Migrations between versions 022 and 023.
 */
class Migration023 extends sfMigration
{
    /**
    * Migrate up to version 023.
    */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `predefined_message` ADD `catalog_id` INTEGER  NOT NULL');
        $this->executeSQL('UPDATE `predefined_message` SET `catalog_id` = 1');
        $this->executeSQL('ALTER TABLE `predefined_message` ADD CONSTRAINT `predefined_message_FK_1`
                            FOREIGN KEY (`catalog_id`)
                            REFERENCES `catalogue` (`cat_id`);');
    }

    /**
    * Migrate down to version 022.
    */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `predefined_message` DROP FOREIGN KEY `predefined_message_FK_1`');
        $this->executeSQL('ALTER TABLE `predefined_message` DROP `catalog_id`');
    }
}
