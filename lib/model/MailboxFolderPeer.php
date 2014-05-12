<?php

/**
 * Subclass for performing query and update operations on the 'mailbox_folder' table.
 *
 *
 *
 * @package lib.model
 */
class MailboxFolderPeer extends BaseMailboxFolderPeer
{
    const INBOX     = 1;
    const SENTBOX   = 2;
    const DRAFTS    = 3;
    const SYSTEM    = 4;
}
