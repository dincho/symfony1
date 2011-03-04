<?php

/**
 * Migrations between versions 056 and 057.
 */
class Migration057 extends sfMigration
{
    /**
    * Migrate up to version 057.
    */
    public function up()
    {
        $this->executeSQL("update `trans_unit` set `source`='%USERNAME% can see you. Do not let %USERNAME% see you.' where `source`='She (he) can see you. Do not let her' ;");        
        $this->executeSQL("update `trans_unit` set `source`='%USERNAME% cannot see you. Let %USERNAME% see you.' where `source`='She (he) can not see you. Let her' ;");        
    }

    /**
    * Migrate down to version 056.
    */
    public function down()
    {
        $this->executeSQL("update `trans_unit` set `source`='She (he) can see you. Do not let her' where `source`='%USERNAME% can see you. Do not let %USERNAME% see you.' ;");        
        $this->executeSQL("update `trans_unit` set `source`='She (he) can not see you. Let her' where `source`='%USERNAME% cannot see you. Let %USERNAME% see you.' ;");                
    }
}
