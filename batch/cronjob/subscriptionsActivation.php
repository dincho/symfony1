<?php

/**
 * handle subscriptions effective date (prepaid/upgrade subscriptions) batch script
 *
 * Script that runs each end of the day at 23:30 and upgrade all members that needs to
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

require_once('config.php');
include_once (sfConfigCache::getInstance()->checkConfig('config/db_settings.yml')); 

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$c = new Criteria();
$c->add(MemberSubscriptionPeer::EFFECTIVE_DATE, 'DATE('.MemberSubscriptionPeer::EFFECTIVE_DATE .') = CURDATE()', Criteria::CUSTOM);
$c->add(MemberSubscriptionPeer::STATUS, 'confirmed');
$member_subscriptions = MemberSubscriptionPeer::doSelectJoinMember($c);


$con = Propel::getConnection(MemberSubscriptionPeer::DATABASE_NAME);

foreach( $member_subscriptions as $subscription)
{
    try {
      $con->begin();

      $member = $subscription->getMember();
      $current_subscription = $member->getCurrentMemberSubscription();
  
      printf("Member %s needs to be upgraded to %s, old subscription %s ...", $member->getUsername(), $subscription->getSubscription()->getTitle(), $member->getSubscription()->getTitle());
      $current_subscription->setStatus('eot');
      $current_subscription->save();
  
      $subscription->setStatus('active');
      $member->changeSubscription($subscription->getSubscriptionId());
      $subscription->save();
    
      $con->commit();
      echo "done.\n";
      printf("-- current member subscription becomes: %s\n", $member->getCurrentMemberSubscription()->getSubscription()->getTitle());
    } catch (PropelException $e) {
      $con->rollback();
      echo "failed!\n";
      //throw $e;
    }


}
