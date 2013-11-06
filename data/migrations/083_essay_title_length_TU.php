<?php

/**
 * Migrations between versions 082 and 083.
 */
class Migration083 extends sfMigration
{
    /**
    * Migrate up to version 083.
    */
    public function up()
    {
        $this->executeSQL("UPDATE trans_unit SET `source`='Headline may contain maximum 40 characters.' WHERE `source`='Headline may contain maximum 60 characters.'");
    }

    /**
    * Migrate down to version 082.
    */
    public function down()
    {
        $this->executeSQL("UPDATE trans_unit SET `source`='Headline may contain maximum 60 characters.' WHERE `source`='Headline may contain maximum 40 characters.'");
    }
}
