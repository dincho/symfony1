<?php

/**
 * Migrations between versions 027 and 028.
 */
class Migration028 extends sfMigration
{
    /**
    * Migrate up to version 028.
    */
    public function up()
    {
        $this->executeSQL("INSERT INTO `catalogue` (`cat_id`,`name`,`source_lang`,`target_lang`,`date_created`,`date_modified`,`author`,`domain`,`shared_catalogs`) VALUES 
                                                    (16,'messages.pl','en','pl',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(), '', 'www.meskamilosc.pl',NULL)");

        $this->executeSQL("INSERT INTO `trans_unit` (`id`,`cat_id`,`source`,`target`,`comments`,`author`,`translated`,`date_modified`,`msg_collection_id`,`date_added`,`tags`,`link`)
                                        SELECT NULL, 16, `source`,`target`,`comments`,`author`,`translated`,UNIX_TIMESTAMP(),`msg_collection_id`,UNIX_TIMESTAMP(),`tags`,`link` 
                                                    FROM `trans_unit` WHERE `cat_id` = 2");
    }

    /**
    * Migrate down to version 027.
    */
    public function down()
    {
        $this->executeSQL('DELETE FROM `trans_unit` WHERE `cat_id` = 16');
        $this->executeSQL('DELETE FROM `catalogue` WHERE `cat_id` = 16');
    }
}
