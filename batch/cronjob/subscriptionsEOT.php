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

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
define('SF_APP',         'frontend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       0);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
include_once (sfConfigCache::getInstance()->checkConfig('config/db_settings.yml')); 

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

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
    echo "EOT event for member: " . $member->getUsername() . ' - EOT: ' .$subscription->getEotAt()  . "\n";

    $subscription->setStatus('eot');
        
    //we does not switch member to free, if it's already upgraded to other subscription
    if( $member->getSubscriptionId() == $subscription->getSubscriptionId() )
    {
      $member->changeSubscription(SubscriptionPeer::FREE);
    }
        
    //$subscription->save();
}
