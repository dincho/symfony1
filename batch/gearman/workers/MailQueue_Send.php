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

require_once(realpath(dirname(__FILE__).'/../../config.php'));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

function send_mail($job)
{
    //due to bad implementation getConnection just check if conn isset in connMap
    //however the close() does not unset the connection, thus makes Propel shitty
    //and we need explicitly to initialize this shit.
    Propel::initialize();
    
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
    
    Propel::close();
    
    // print("JOB DONE!\n");
    return $status;
}

$worker= new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);
$worker->addFunction("MailQueue_Send", "send_mail");
while ($worker->work());
 
