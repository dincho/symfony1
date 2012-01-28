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

$logger = new sfFileLogger();
$logger->initialize(array('file' => SF_ROOT_DIR . '/log/workers/MailQueue_Send.log'));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

function send_mail($job)
{
    global $logger;
    
    //due to bad implementation getConnection just check if conn isset in connMap
    //however the close() does not unset the connection, thus makes Propel shitty
    //and we need explicitly to initialize this shit.
    Propel::initialize();
    
    try {
        //get the queued message and try to send it, setting correct statuses
        if( $message = PrMailMessagePeer::retrieveByPK($job->workload()) )
        {
            $message->sendMail();
        }
        
        $job->sendComplete(null);
    } catch (Exception $e) {
        $logger->log($e->getMessage(), 0, 'Err');
        $job->sendException($e->getMessage());
        $job->sendFail();
    }
    
    Propel::close();
}

$worker= new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);
$worker->addFunction("MailQueue_Send", "send_mail");
while ($worker->work());
 
