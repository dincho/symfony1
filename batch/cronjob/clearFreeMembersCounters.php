<?php

/**
 * clearFreeMembersCounters batch script
 *
 * Script that runs each day and clear counters of no "Paid Members" -> SubscriptionPeer::PAID
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
define('SF_APP',         'frontend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$current_day = date('d');
$last_clear_day = 28; //28 is the last day for clearment, cause each month have 28 but not 29 30 .. 

if( $current_day <= $last_clear_day)
{
    $c = new Criteria();
    $c->add(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::PAID, Criteria::NOT_EQUAL);
    $c->add(MemberPeer::CREATED_AT, 'MONTH(' . MemberPeer::CREATED_AT . ') '. Criteria::GREATER_THAN .' ' . date('m'), Criteria::CUSTOM);
    
    if( $current_day == $last_clear_day ) 
    {
        $c->add(MemberPeer::CREATED_AT, 'DAY(' . MemberPeer::CREATED_AT . ') '. Criteria::GREATER_EQUAL .' ' . $current_day, Criteria::CUSTOM);
    } else {
        $c->add(MemberPeer::CREATED_AT, 'DAY(' . MemberPeer::CREATED_AT . ') '. Criteria::EQUAL .' ' . $current_day, Criteria::CUSTOM);
    }
    
    $members = MemberPeer::doSelectJoinMemberCounter($c);
    foreach ($members as $member)
    {
        //echo $member->getUsername() . ' - ' . $member->getCreatedAt('d/m/Y H:i:s') . ' ' . $member->getSubscription() . "\n";
        $member->clearCounters();
    }
}