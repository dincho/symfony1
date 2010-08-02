<?php

/**
 * EOT reminder
 *
 * This notification is sent based on PAID member's EOT
 *
 * @package    pr
 * @subpackage batch
 * @version    $Id$
 * 
 * Run each day
 */

require_once('config.php');
include_once (sfConfigCache::getInstance()->checkConfig('config/db_settings.yml')); 

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$c = new Criteria();
$c->add(NotificationPeer::ID, NotificationPeer::EOT);
$c->add(NotificationPeer::IS_ACTIVE, true);
$notifications = NotificationPeer::doSelect($c);

foreach ($notifications as $notification)
{
    $sign = ($notification->getWhn() == 'B') ? '-' : '+';
    $days = $notification->getDays() + sfConfig::get('app_settings_extend_eot', 0);
    $date_expresion = sprintf('DATE(%s) %s INTERVAL %d DAY = CURRENT_DATE()', MemberSubscriptionPeer::EOT_AT, $sign, $days);
        
    $c = new Criteria();
    $c->add(MemberSubscriptionPeer::GIFT_BY, null, Criteria::ISNULL);
    $c->add(MemberSubscriptionPeer::EOT_AT, $date_expresion, Criteria::CUSTOM);
    $c->add(MemberPeer::CATALOG_ID, $notification->getCatid());
    $subscriptions = MemberSubscriptionPeer::doSelectJoinMember($c);
    
    foreach ($subscriptions as $subscription) Events::triggerEOT($subscription);
}
