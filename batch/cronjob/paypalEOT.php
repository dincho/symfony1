<?php

/**
 * handle paypal EOT batch script
 *
 * Script that runs each day at 00:00 and switch all paid member that needs to to free subscription
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
$c = new Criteria();
$c->add(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::PAID);
$members = MemberPeer::doSelect($c);

foreach( $members as $member)
{
    $eot = $member->getEotDate(true);

    if( $eot && $eot->format('Ymd') == date('Ymd') )
    {
       echo "Swtiching to FREE: " . $member->getUsername() . ' - ' .$eot->format('Ymd')  . "\n";
        
       $member->clearCounters();
       $member->changeSubscription(SubscriptionPeer::FREE);
       $member->setLastPaypalSubscrId(null);
       $member->setLastPaypalPaymentAt(null);
       $member->setLastPaypalItem(null);
       $member->save();
    }
}
