CREATE TABLE `gift`
(
    `id` INTEGER  NOT NULL AUTO_INCREMENT,
    `from_member_id` INTEGER  NOT NULL,
    `to_member_id` INTEGER default null,
    `to_email` VARCHAR(255)  NOT NULL,
    `accepted` DATETIME default NULL,
    `hash` CHAR(40)  NOT NULL,
    `subscription_id` INTEGER  NOT NULL,
    `created_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `gift_FI_1` (`from_member_id`),
    CONSTRAINT `gift_FK_1`
        FOREIGN KEY (`from_member_id`)
        REFERENCES `member` (`id`)
        ON DELETE CASCADE,
    INDEX `gift_FI_2` (`to_member_id`),
    CONSTRAINT `gift_FK_2`
        FOREIGN KEY (`to_member_id`)
        REFERENCES `member` (`id`)
        ON DELETE CASCADE,
    INDEX `gift_FI_3` (`subscription_id`),
    CONSTRAINT `gift_FK_3`
        FOREIGN KEY (`subscription_id`)
        REFERENCES `subscription` (`id`)
        ON DELETE RESTRICT
);

ALTER TABLE `gift` ADD UNIQUE INDEX `hash` (`hash`);
