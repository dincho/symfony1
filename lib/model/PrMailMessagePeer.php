<?php

/**
 * Subclass for performing query and update operations on the 'PR_mail_message' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PrMailMessagePeer extends BasePrMailMessagePeer
{
    const STATUS_PENDING    = 'pending'; //mail message is just created in the DB table
    const STATUS_SCHEDULED  = 'scheduled'; //mail message is successiful scheduled in the queue ( currently gearman )
    const STATUS_SENDING    = 'sending'; //message is in the state of connecting to SMTP and trying to delivery to it
    const STATUS_SENT       = 'sent'; //message was successifuly delivered to the STMP
    const STATUS_FAILED     = 'failed'; //message was NOT delivered to the SMTP    
}
