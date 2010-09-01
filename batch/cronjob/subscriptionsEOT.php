<?php

/**
 * handle subscriptions EOT batch script
 *
 * Script that runs each end of the day at 23:50 and switch all paid member that needs to to free subscription
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

require_once(realpath(dirname(__FILE__).'/../config.php'));
include_once (sfConfigCache::getInstance()->checkConfig('config/db_settings.yml')); 

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$logger = new sfFileLogger();
$logger->initialize(array('file' => SF_ROOT_DIR . '/log/cron/subscriptionEOT.log'));
 

// batch process here
$days = sfConfig::get('app_settings_extend_eot', 0);

$c = new Criteria();
$c->add(MemberSubscriptionPeer::EOT_AT, '('.MemberSubscriptionPeer::EOT_AT . ' + INTERVAL ' . $days . ' DAY) <= NOW()', Criteria::CUSTOM);
$c->add(MemberSubscriptionPeer::STATUS, array('active', 'canceled'), Criteria::IN);
// $c->add(MemberSubscriptionPeer::SUBSCRIPTION_ID, MemberPeer::SUBSCRIPTION_ID);
$member_subscriptions = MemberSubscriptionPeer::doSelectJoinMember($c);


foreach( $member_subscriptions as $subscription)
{
    $member = $subscription->getMember();
    $log_msg = "EOT event for member: " . $member->getUsername() . ' - EOT: ' .$subscription->getEotAt();
    $logger->log($log_msg, 0, "Info");
    
    $subscription->setStatus('eot');
        
    //we does not switch member to free, if it's already upgraded to other subscription
    if( $member->getSubscriptionId() == $subscription->getSubscriptionId() )
    {
      $member->changeSubscription(SubscriptionPeer::FREE);
    }
        
    $subscription->save();
}
