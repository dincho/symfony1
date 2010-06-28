<?php

/**
 * Migrations between versions 002 and 003.
 */
class Migration003 extends sfMigration
{
  /**
   * Migrate up to version 003.
   */
  public function up()
  {
    $this->executeSQL("CREATE TABLE `PR_mail_message`
                                    (
                                        `id` INTEGER  NOT NULL AUTO_INCREMENT,
                                        `mail_config_id` TINYINT,
                                        `sender` TEXT,
                                        `mail_from` TEXT,
                                        `recipients` TEXT,
                                        `cc` TEXT,
                                        `bcc` TEXT,
                                        `subject` TEXT,
                                        `body` TEXT,
                                        `status` VARCHAR(10) default 'pending' NOT NULL,
                                        `status_message` TEXT,
                                        `created_at` DATETIME,
                                        `updated_at` DATETIME,
                                        PRIMARY KEY (`id`)
                                    )Type=InnoDB;
                                    ");

  }

  /**
   * Migrate down to version 002.
   */
  public function down()
  {
    $this->executeSQL("DROP TABLE `PR_mail_message`");
  }
}
