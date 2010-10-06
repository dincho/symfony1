<?php

/**
 * Migrations between versions 035 and 036.
 */
class Migration036 extends sfMigration
{
    /**
    * Migrate up to version 036.
    */
    public function up()
    {
        $this->executeSQL('ALTER TABLE `trans_unit` CHANGE `source` `source` VARCHAR(220)  NOT NULL  DEFAULT ""');
        $this->executeSQL('ALTER IGNORE TABLE `trans_unit` ADD UNIQUE INDEX `cat_id_source` (`cat_id`, `source`)');
        
        $this->executeSQL('UPDATE `trans_unit` SET source = "Delete your account information" WHERE MD5(source) = "3b5436b7bf61c6b916008fb3d5df67f4"');
        $this->executeSQL('UPDATE `trans_unit` SET source = "I am familiar with this member IMBRA and I accept the TOS" WHERE MD5(source) = "0e2423b1948c0c21b41f42476b229498"');
        $this->executeSQL('UPDATE `trans_unit` SET source = "Thank you for your payment and for using our services." WHERE MD5(source) = "376d195430a812c7dd6214adf47235c7"');
        $this->executeSQL('UPDATE `trans_unit` SET source = "IMBRA: Oops. You have abandoned the payment process." WHERE MD5(source) = "c702f9d7eaf63ff7cecc03885f8e743e"');
    }

    /**
    * Migrate down to version 035.
    */
    public function down()
    {
        $this->executeSQL('ALTER TABLE `trans_unit` DROP INDEX `cat_id_source`');
        $this->executeSQL('ALTER TABLE `trans_unit` CHANGE `source` `source` VARCHAR(1000)  NOT NULL  DEFAULT ""');
    }
}
