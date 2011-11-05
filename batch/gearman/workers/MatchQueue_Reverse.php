<?php

/**
 * MatchQueue Reverse Gearman worker script
 *
 * This script handles queued job by gearman
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

require_once(realpath(dirname(__FILE__).'/../../config.php'));

$logger = new sfFileLogger();
$logger->initialize(array('file' => SF_ROOT_DIR . '/log/workers/MatchQueue_Reverse.log'));

$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();
    
function update_reverse_matches($job)
{
    global $logger;
    
    //due to bad implementation getConnection just check if conn isset in connMap
    //however the close() does not unset the connection, thus makes Propel shitty
    //and we need explicitly to initialize this shit.
    Propel::initialize();
    
    try {
        $member = MemberPeer::retrieveByPk($job->workload());
        $member->doUpdateReverseMatches();
        
        $job->sendComplete(null);
    } catch (SQLException $e) {
        $logger->log($e->getMessage(), 0, 'Err');
        $job->sendException($e->getMessage());
        $job->sendFail();
    }
    
    Propel::close();
}

$worker= new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);
$worker->addFunction("MatchQueue_Reverse", "update_reverse_matches");

while ($worker->work())
{
    if (GEARMAN_SUCCESS != $worker->returnCode())
        echo "Worker failed: " . $worker->error() . "\n";
}