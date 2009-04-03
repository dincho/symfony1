<?php

/**
 * clearGiftMembershipCounters batch script
 *
 * Script that runs each day and clear counters of no "Paid Members", but with gift membership
 * since we cannot use notifications by paypal, cause period is set to 3 Months, with no recurring
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
// batch process here
$current_day = date('d');
$last_clear_day = 28; //28 is the last day for clearment, cause each month have 28 but not 29 30 .. 

if( $current_day <= $last_clear_day)
{
    $c = new Criteria();
    $c->add(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::PAID);
    $c->add(MemberPeer::LAST_PAYPAL_ITEM, 'gift_membership');
    $c->add(MemberPeer::LAST_PAYPAL_PAYMENT_AT, 'MONTH(' . MemberPeer::LAST_PAYPAL_PAYMENT_AT . ') '. Criteria::GREATER_THAN .' ' . date('m'), Criteria::CUSTOM);
    
    if( $current_day == $last_clear_day ) 
    {
        $c->add(MemberPeer::LAST_PAYPAL_PAYMENT_AT, 'DAY(' . MemberPeer::LAST_PAYPAL_PAYMENT_AT . ') '. Criteria::GREATER_EQUAL .' ' . $current_day, Criteria::CUSTOM);
    } else {
        $c->add(MemberPeer::LAST_PAYPAL_PAYMENT_AT, 'DAY(' . MemberPeer::LAST_PAYPAL_PAYMENT_AT . ') '. Criteria::EQUAL .' ' . $current_day, Criteria::CUSTOM);
    }
    
    $members = MemberPeer::doSelectJoinMemberCounter($c);
    foreach ($members as $member)
    {
        //echo $member->getUsername() . ' - ' . $member->getCreatedAt('d/m/Y H:i:s') . ' ' . $member->getSubscription() . "\n";
        $member->clearCounters();
    }
}