<?php

class Migration005 extends sfMigration
{
    /**
     * Migrate the schema up, from the version 004 to the current one.
     */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/005/005_member_photo_deleted_notification_up.sql');
    }

    /**
     * Migrate the schema down to version 005, i.e. undo the modifications made in up()
     */
    public function down()
    {
        $this->loadSql(dirname(__FILE__).'/fixtures/005/005_member_photo_deleted_notification_down.sql');
    }
}
