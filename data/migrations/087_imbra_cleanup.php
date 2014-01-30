<?php

/**
 * Migrations between versions 086 and 087.
 */
class Migration087 extends sfMigration
{
    /**
    * Migrate up to version 087.
    */
    public function up()
    {
        $this->executeSQL("DROP TABLE `member_imbra_i18n`");
        $this->executeSQL("DROP TABLE `member_imbra_answer`");
        $this->executeSQL("DROP TABLE `member_imbra`");
        $this->executeSQL("DROP TABLE `imbra_status`");
        $this->executeSQL("DROP TABLE `imbra_question`");
        $this->executeSQL("DROP TABLE `imbra_reply_template`");
        $this->executeSQL("ALTER TABLE `member` DROP `imbra_payment`");
        $this->executeSQL("ALTER TABLE `subscription_details` DROP `imbra_amount`");
        $this->executeSQL("ALTER TABLE `user` DROP `imbra_mod`");
        $this->executeSQL("ALTER TABLE `user` DROP `imbra_mod_type`");
    }

    /**
    * Migrate down to version 086.
    */
    public function down()
    {
        $this->executeSQL("ALTER TABLE `user` ADD `imbra_mod` INTEGER default 0 NOT NULL");
        $this->executeSQL("ALTER TABLE `user` ADD `imbra_mod_type` CHAR(1) default '' NOT NULL");
        $this->executeSQL("ALTER TABLE `member` ADD `imbra_payment` VARCHAR(100)");
        $this->executeSQL("ALTER TABLE `subscription_details` ADD `imbra_amount` DECIMAL(7,2)  NOT NULL");
        $this->executeSQL("CREATE TABLE `imbra_question`
        (
            `id` INTEGER  NOT NULL,
            `cat_id` INTEGER  NOT NULL,
            `title` TEXT,
            `explain_title` TEXT,
            `positive_answer` TEXT,
            `negative_answer` TEXT,
            `only_explain` INTEGER default 0 NOT NULL,
            PRIMARY KEY (`id`,`cat_id`),
            INDEX `imbra_question_FI_1` (`cat_id`),
            CONSTRAINT `imbra_question_FK_1`
                FOREIGN KEY (`cat_id`)
                REFERENCES `catalogue` (`cat_id`)
                ON UPDATE RESTRICT
                ON DELETE CASCADE
        )ENGINE=InnoDB");

        $this->executeSQL("CREATE TABLE `imbra_status`
        (
            `id` INTEGER  NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(80),
            PRIMARY KEY (`id`)
        )ENGINE=InnoDB");

        $this->executeSQL("CREATE TABLE `imbra_reply_template`
        (
            `id` INTEGER  NOT NULL AUTO_INCREMENT,
            `user_id` INTEGER,
            `title` VARCHAR(255),
            `subject` VARCHAR(255),
            `body` TEXT,
            `footer` TEXT,
            `mail_from` VARCHAR(255),
            `reply_to` VARCHAR(255),
            `bcc` VARCHAR(255),
            `created_at` DATETIME,
            PRIMARY KEY (`id`),
            INDEX `imbra_reply_template_FI_1` (`user_id`),
            CONSTRAINT `imbra_reply_template_FK_1`
                FOREIGN KEY (`user_id`)
                REFERENCES `user` (`id`)
        )ENGINE=InnoDB");

        $this->executeSQL("CREATE TABLE `member_imbra`
        (
            `id` INTEGER  NOT NULL AUTO_INCREMENT,
            `member_id` INTEGER  NOT NULL,
            `imbra_status_id` INTEGER  NOT NULL,
            `name` VARCHAR(100),
            `dob` VARCHAR(100),
            `address` VARCHAR(255),
            `city` VARCHAR(100),
            `adm1_id` INTEGER,
            `zip` VARCHAR(20),
            `phone` VARCHAR(30),
            `created_at` DATETIME,
            PRIMARY KEY (`id`),
            INDEX `member_imbra_FI_1` (`member_id`),
            CONSTRAINT `member_imbra_FK_1`
                FOREIGN KEY (`member_id`)
                REFERENCES `member` (`id`)
                ON DELETE CASCADE,
            INDEX `member_imbra_FI_2` (`imbra_status_id`),
            CONSTRAINT `member_imbra_FK_2`
                FOREIGN KEY (`imbra_status_id`)
                REFERENCES `imbra_status` (`id`)
                ON DELETE RESTRICT,
            INDEX `member_imbra_FI_3` (`adm1_id`),
            CONSTRAINT `member_imbra_FK_3`
                FOREIGN KEY (`adm1_id`)
                REFERENCES `geo` (`id`)
                ON DELETE RESTRICT
        )ENGINE=InnoDB");

        $this->executeSQL("CREATE TABLE `member_imbra_i18n`
        (
            `text` TEXT,
            `id` INTEGER  NOT NULL,
            `culture` VARCHAR(7)  NOT NULL,
            PRIMARY KEY (`id`,`culture`),
            CONSTRAINT `member_imbra_i18n_FK_1`
                FOREIGN KEY (`id`)
                REFERENCES `member_imbra` (`id`)
                ON DELETE CASCADE
        )ENGINE=InnoDB");

        $this->executeSQL("CREATE TABLE `member_imbra_answer`
        (
            `id` INTEGER  NOT NULL AUTO_INCREMENT,
            `member_imbra_id` INTEGER  NOT NULL,
            `imbra_question_id` INTEGER  NOT NULL,
            `answer` INTEGER default 0 NOT NULL,
            `explanation` TEXT,
            PRIMARY KEY (`id`),
            INDEX `member_imbra_answer_FI_1` (`member_imbra_id`),
            CONSTRAINT `member_imbra_answer_FK_1`
                FOREIGN KEY (`member_imbra_id`)
                REFERENCES `member_imbra` (`id`)
                ON DELETE CASCADE,
            INDEX `member_imbra_answer_FI_2` (`imbra_question_id`),
            CONSTRAINT `member_imbra_answer_FK_2`
                FOREIGN KEY (`imbra_question_id`)
                REFERENCES `imbra_question` (`id`)
                ON DELETE CASCADE
        )ENGINE=InnoDB");
    }
}
