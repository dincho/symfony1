<?php

/**
 * Migrations between versions 054 and 055.
 */
class Migration055 extends sfMigration
{
    /**
    * Migrate up to version 055.
    */
    public function up()
    {
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Messages ( %count%/%count_all% )' WHERE `source` = 'Messages ( %count% )';");
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Winks ( %count%/%count_all% )' WHERE `source` = 'Winks ( %count% )';");
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Hotlist ( %count%/%count_all% )' WHERE `source` = 'Hotlist ( %count% )';");
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Visitors ( %count%/%count_all% )' WHERE `source` = 'Visitors ( %count% )';");
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Private Photo Access ( %count%/%count_all% )' WHERE `source` = 'Private Photo Access ( %count% )';");
        $this->executeSQL("ALTER TABLE `private_photo_permission` ADD `is_new` INT NOT NULL DEFAULT '1';");
    }

    /**
    * Migrate down to version 054.
    */
    public function down()
    {
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Messages ( %count% )' WHERE `source` = 'Messages ( %count%/%count_all% )';");
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Winks ( %count% )' WHERE `source` = 'Winks ( %count%/%count_all% )';");
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Hotlist ( %count% )' WHERE `source` = 'Hotlist ( %count%/%count_all% )';");
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Visitors ( %count% )' WHERE `source` = 'Visitors ( %count%/%count_all% )';");
        $this->executeSQL("UPDATE `trans_unit` SET `source` = 'Private Photo Access ( %count% )' WHERE `source` = 'Private Photo Access ( %count%/%count_all% )';");
        $this->executeSQL("ALTER TABLE `private_photo_permission` DROP `is_new`; ");
    }
}
