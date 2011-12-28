<?php

/**
 * Migrations between versions 071 and 072.
 */
class Migration072 extends sfMigration
{
    /**
    * Migrate up to version 072.
    */
    public function up()
    {
        $this->executeSQL('CREATE TABLE IF NOT EXISTS `dotpay_history` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `account_id` int(11) NOT NULL,
                          `transaction_id` varchar(255) NOT NULL,
                          `status` varchar(10) NOT NULL,
                          `control` varchar(128) NOT NULL,
                          `amount` decimal(7,2) NOT NULL,
                          `original_amount` varchar(255) NOT NULL DEFAULT "",
                          `email` varchar(255) NOT NULL,
                          `t_status` varchar(255) NOT NULL,
                          `description` varchar(255) DEFAULT NULL,
                          `checksum` varchar(32) NOT NULL,
                          `p_info` varchar(255) DEFAULT NULL,
                          `p_email` varchar(255) DEFAULT NULL,
                          `t_date` datetime NOT NULL,
                          `created_at` datetime DEFAULT NULL,
                          `request_ip` bigint(20) DEFAULT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8');
    }

    /**
    * Migrate down to version 071.
    */
    public function down()
    {
        $this->executeSQL('DROP TABLE `dotpay_history`');
    }
}
