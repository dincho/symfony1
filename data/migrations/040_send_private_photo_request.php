<?php

/**
 * Migrations between versions 039 and 040.
 */
class Migration040 extends sfMigration
{
    /**
    * Migrate up to version 040.
    */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/040/040_send_private_photo_request_up.sql');
        $this->loadTransUnits();                
    }

    /**
    * Migrate down to version 039.
    */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/040/040_send_private_photo_request_down.sql');        
        $this->deleteTransUnits();
    }
}
