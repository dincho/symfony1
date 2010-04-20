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

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
include_once (sfConfigCache::getInstance()->checkConfig('config/db_settings.yml')); 

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$notification = NotificationPeer::retrieveByPK(NotificationPeer::EOT);

if ( $notification->getIsActive() )
{
    $sign = ($notification->getWhn() == 'B') ? '-' : '+';
    $days = $notification->getDays() + sfConfig::get('app_settings_extend_eot', 0);
    $date_expresion = sprintf('DATE(%s) %s INTERVAL %d DAY = CURRENT_DATE()', MemberSubscriptionPeer::EOT_AT, $sign, $days);
        
    $c = new Criteria();
    $c->add(MemberSubscriptionPeer::GIFT_BY, null, Criteria::ISNULL);
    $c->add(MemberSubscriptionPeer::EOT_AT, $date_expresion, Criteria::CUSTOM);
    $subscriptions = MemberSubscriptionPeer::doSelectJoinMember($c);
    
    foreach ($subscriptions as $subscription) Events::triggerEOT($subscription);
}

