<?php
/**
 * mailbox_import batch script
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    pr
 * @subpackage batch
 * @version    $Id$
 */
require_once('config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$imap = new IMAP();
$messages = $imap->getMessages();

foreach ($messages as $message)
{
    $mail = new Feedback();
    $mail->setCreatedAt($message->getTS());
    $mail->setNameFrom($message->getFromName());
    $mail->setMailFrom($message->getFromMail());
    $mail->setNameTo($message->getToName());
    $mail->setMailTo($message->getToMail());
    $mail->setSubject($message->getSubject());
    $mail->setBody($message->getBody());

    $member = MemberPeer::retrieveByEmail($message->getFromMail());
    if( $member ) $mail->setMember($member);
    
    $mail->save();
    
    //$message->delete();
}

