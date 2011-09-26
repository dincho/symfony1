<?php

/**
 * Migrations between versions 066 and 067.
 */
class Migration067 extends sfMigration
{
    /**
    * Migrate up to version 067.
    */
    public function up()
    {
        $this->executeSQL("ALTER TABLE `member_login_history` ADD INDEX IP (ip);");
        $this->executeSQL("ALTER TABLE `member`
        	ADD INDEX Last_IP (last_ip),
        	ADD INDEX Reg_IP (registration_ip);");        
        
    }

    /**
    * Migrate down to version 066.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE member_login_history DROP INDEX IP;");
        $this->executeSQL("ALTER TABLE member
        	DROP INDEX Last_IP,
        	DROP INDEX Reg_IP;");        
                            

    }
}
