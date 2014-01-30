<?php

/**
 * set member payment state to null after subscriptions expire,
 * so member can initialize payment again
 *
 * Script that runs each end of the day
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

require_once(realpath(dirname(__FILE__).'/../config.php'));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$date = new DateTime();
$date->sub(new DateInterval('P3D'));

$c = new Criteria();
$c->add(MemberSubscriptionPeer::UPDATED_AT, $date->format('Y-m-d'), Criteria::LESS_THAN);
$c->add(MemberSubscriptionPeer::STATUS, 'pending');
$memberSubscriptions = MemberSubscriptionPeer::doSelectJoinMember($c);

$clearedMembers = array();
foreach ($memberSubscriptions as $subscription) {
    $member = $subscription->getMember();

    if (!in_array($member->getId(), $clearedMembers)) {
        $clearedMembers[] = $member->getId();
        $member->setLastPaymentState(null);
        $member->save();
    }

    $subscription->delete();
}
