<?php

class Migration005
{
    /**
     * Migrate the schema up, from the version 004 to the current one.
     */
    public function up()
    {
        $this->executeSQL(
            '
                UPDATE message m1,
                (
                    SELECT m2.recipient_id as `recipient`, max(m2.thread_id) as `max_thread`
                    FROM message m2
                    WHERE m2.sender_id IS NULL
                    GROUP BY m2.recipient_id
                )
                AS tbl_2
                SET m1.thread_id = tbl_2.max_thread
                WHERE m1.recipient_id = tbl_2.recipient
                AND m1.sender_id IS NULL
            '
        );
    }

    /**
     * Migrate the schema down to version 004, i.e. undo the modifications made in up()
     */
    public function down()
    {
        // nothing to do
    }
}
