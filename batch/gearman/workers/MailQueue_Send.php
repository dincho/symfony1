<?php

/**
 * MailQueue_Send Gearman worker script
 *
 * This script handles queued job by gearman
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../../../'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       0);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

function send_mail($job)
{
    $message_id = $job->workload();
    
    //get the queued message and try to send it, setting correct statuses
    $message = PrMailMessagePeer::retrieveByPK($message_id);
    if( !$message ) 
    {
        // printf("Queued Mail Message with ID %d was not found! Quitting ..\n", $message_id);
        return false;
    }
    
    // print("Trying to send the email message ...");
    $status = $message->sendMail();

    // echo ($status) ? "Success" : "Failed!";
    // echo "\n";
    
    // print("JOB DONE!\n");
    return $status;
}

$worker= new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);
$worker->addFunction("MailQueue_Send", "send_mail");
while ($worker->work());
 
