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
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

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
$c->add(MemberSubscriptionPeer::IS_CURRENT, true);

//$c->add(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::PAID);
$member_subscriptions = MemberSubscriptionPeer::doSelectJoinMember($c);


foreach( $member_subscriptions as $subscription)
{
    $member = $subscription->getMember();
    echo "Swtiching to FREE: " . $member->getUsername() . ' - EOT: ' .$subscription->getEotAt()  . "\n";

    $subscription->EOT();
    $subscription->save();
}
