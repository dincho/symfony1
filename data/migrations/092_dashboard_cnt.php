<?php

/**
 * Migrations between versions 091 and 092.
 */
class Migration092 extends sfMigration
{
    /**
    * Migrate up to version 092.
    */
    public function up()
    {
        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Messages ( %count% )' 
            WHERE `source` = 'Messages ( %count%/%count_all% )'"
        );

        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Winks ( %count% )' 
            WHERE `source` = 'Winks ( %count%/%count_all% )'"
        );

        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Hotlist ( %count% )' 
            WHERE `source` = 'Hotlist ( %count%/%count_all% )'"
        );

        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Visitors ( %count% )' 
            WHERE `source` = 'Visitors ( %count%/%count_all% )'"
        );

        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Private Photo Access ( %count% )' 
            WHERE `source` = 'Private Photo Access ( %count%/%count_all% )'"
        );
    }

    /**
    * Migrate down to version 091.
    */
    public function down()
    {
        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Messages ( %count%/%count_all% )' 
            WHERE `source` = 'Messages ( %count% )'"
        );

        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Winks ( %count%/%count_all% )' 
            WHERE `source` = 'Winks ( %count% )'"
        );

        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Hotlist ( %count%/%count_all% )' 
            WHERE `source` = 'Hotlist ( %count% )'"
        );

        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Visitors ( %count%/%count_all% )' 
            WHERE `source` = 'Visitors ( %count% )'"
        );

        $this->executeSQL("UPDATE trans_unit 
            SET `source` = 'Private Photo Access ( %count%/%count_all% )' 
            WHERE `source` = 'Private Photo Access ( %count% )'"
        ); 
    }
}
