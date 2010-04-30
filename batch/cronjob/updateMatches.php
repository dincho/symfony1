<?php

/**
 * Script for updating member matches - cron
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    pr
 * @subpackage batch
 * @version    $Id$
 * 
 * Run once a day
 */

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       0);
set_time_limit(0);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfConfig::set('pr_timer_start', microtime(true));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here


//echo 'Initial memory: ' . number_format(memory_get_usage()/1024/1024, 0, '.', ',') . " MB\n";

$c = new Criteria();

$page = 0;
$per_page = 100;
$total_cnt = 0;

$pager = new sfPropelPager('Member', $per_page);
$pager->setCriteria($c);

do
{
    $page++;
    $pager->setPage($page);
    $pager->init();
    
    //printf("Page: %d, set %d \n", $page, $page*$per_page);
    
    foreach( $pager->getResults() as $member )
    {
      $member->updateMatches();
      $total_cnt++;
    }
 
}
while( $page != $pager->getLastPage() );


// echo "Total processed: " . $total_cnt . "\n";
// echo 'Peak: ' . number_format(memory_get_peak_usage()/1024/1024, 0, '.', ',') . " MB\n";
// echo 'End: ' . number_format(memory_get_usage()/1024/1024, 0, '.', ',') . " MB\n";
// 
// $total_time = sprintf('%.7f', (microtime(true) - sfConfig::get('pr_timer_start')));
// echo 'Execution time: ' . $total_time . "\n";