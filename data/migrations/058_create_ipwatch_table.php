<?php

/**
 * Migrations between versions 057 and 058.
 */
class Migration058 extends sfMigration
{
    /**
    * Migrate up to version 058.
    */
    public function up()
    {
        $this->executeSQL("CREATE TABLE IF NOT EXISTS `ipwatch` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `ip` int(11) NOT NULL,
                            `created_at` datetime NOT NULL,
                            PRIMARY KEY (`id`),
                            UNIQUE KEY `ip` (`ip`)
                          ) ENGINE=InnoDB;");        
        
    }

    /**
    * Migrate down to version 057.
    */
    public function down()
    {
        $this->executeSQL("DROP TABLE IF EXISTS `ipwatch`;");                
    }
}
