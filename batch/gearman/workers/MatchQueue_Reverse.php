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

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

function update_reverse_matches($job)
{
    $member_id = $job->workload();
    
    $connection = Propel::getConnection();
    $query = 'CALL update_reverse_matches(%d, %d)';
    $query = sprintf($query, $member_id, sfConfig::get('app_matches_max_weight'));
    $statement = $connection->prepareStatement($query);
    $statement->executeQuery();
        
    return true;
}

$worker= new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);
$worker->addFunction("MatchQueue_Reverse", "update_reverse_matches");
while ($worker->work());
 
