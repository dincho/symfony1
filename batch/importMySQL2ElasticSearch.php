<?php

/**
 * Script for importing members from MySQL to ElasticSearch
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    pr
 * @subpackage batch
 * @version    $Id$
 * 
 */
require_once(realpath(dirname(__FILE__).'/config.php'));

set_time_limit(0);
sfConfig::set('pr_timer_start', microtime(true));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
echo 'Initial memory: ' . number_format(memory_get_usage()/1024/1024, 0, '.', ',') . " MB\n";

$page = intval(@$argv[1]);
$ids = array_filter(array_map("intval", explode(",", @$argv[2])));
$perPage = 500;
$totalCnt = 0;
$maxCnt = 10000; //~180MB, ~160s

$client = new Elasticsearch\Client();

$c = new Criteria();
$c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);

if (!empty($ids)) {
    $c->add(MemberPeer::ID, $ids, Criteria::IN);
}

$pager = new sfPropelPager('Member', $perPage);
$pager->setCriteria($c);
// $pager->setMaxRecordLimit(10);

do {
    $page++;
    $pager->setPage($page);
    $pager->init();
    
    printf("Page: %d, set %d \n", $page, $page*$perPage);
    ob_flush();

    foreach ($pager->getResults() as $memberObj) {
        $member = MemberMatchPeer::updateMemberIndex($memberObj, $client);
        $totalCnt++;
    }

    if ($page*$perPage > $pager->getNbResults()) {
        break;
    }
 
} while ($totalCnt != $maxCnt);

echo "Total processed: " . $totalCnt . "\n";
echo 'Peak: ' . number_format(memory_get_peak_usage()/1024/1024, 0, '.', ',') . " MB\n";
echo 'End: ' . number_format(memory_get_usage()/1024/1024, 0, '.', ',') . " MB\n";

$total_time = sprintf('%.7f', (microtime(true) - sfConfig::get('pr_timer_start')));
echo 'Execution time: ' . $total_time . "\n";