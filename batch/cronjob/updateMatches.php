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
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);
set_time_limit(0);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfConfig::set('pr_timer_start', microtime(true));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here


//echo 'Initial memory: ' . number_format(memory_get_usage(), 0, '.', ',') . " bytes\n";

$c = new Criteria();
$members = MemberPeer::doSelect($c);
unset($c);

foreach( $members as $member )
{
  $member->updateMatches();
}

// echo 'Peak: ' . number_format(memory_get_peak_usage(), 0, '.', ',') . " bytes\n";
// echo 'End: ' . number_format(memory_get_usage(), 0, '.', ',') . " bytes\n";
// 
// $total_time = sprintf('%.7f', (microtime(true) - sfConfig::get('pr_timer_start')));
// echo 'Execution time: ' . $total_time . "\n";