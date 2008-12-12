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
define('SF_ROOT_DIR', realpath(dirname(__file__) . '/..'));
define('SF_APP', 'backend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG', 1);
require_once (SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . SF_APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');
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
    
    $message->delete();
}

