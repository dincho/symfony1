<?php

/**
 * Migrations between versions 075 and 076.
 */
class Migration076 extends sfMigration
{
    /**
    * Migrate up to version 076.
    */
    public function up()
    {
        $this->executeSQL("INSERT INTO `catalogue` (`cat_id`,`name`,`source_lang`,`target_lang`,`date_created`,`date_modified`,`author`,`domain`,`shared_catalogs`) VALUES 
                                                    (17,'www.cafesayang.com.messages.en','en','en',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(), '', 'www.cafesayang.com',NULL)");

        $this->executeSQL("INSERT INTO `trans_unit` (`id`,`cat_id`,`source`,`target`,`comments`,`author`,`translated`,`date_modified`,`msg_collection_id`,`date_added`,`tags`,`link`)
                                        SELECT NULL, 17, `source`,`target`,`comments`,`author`,`translated`,UNIX_TIMESTAMP(),`msg_collection_id`,UNIX_TIMESTAMP(),`tags`,`link` 
                                                    FROM `trans_unit` WHERE `cat_id` = 1");
    }

    /**
    * Migrate down to version 075.
    */
    public function down()
    {
        $this->executeSQL('DELETE FROM `trans_unit` WHERE `cat_id` = 17');
        $this->executeSQL('DELETE FROM `catalogue` WHERE `cat_id` = 17');
    }
}
