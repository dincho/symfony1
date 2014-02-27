<?php

/**
 * Migrations between versions 094 and 095.
 */
class Migration095 extends sfMigration
{

    /**
     * Migrate the schema up, from 094 to 095.
     */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/094/094_verify_photo_notification_up.sql');
    }

    /**
     * Migrate the schema down to 093, i.e. undo the modifications made in up()
     */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/094/094_verify_photo_notification_down.sql');
    }
}
