<?php

/**
 * Registration Reminder batch script - cron
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    pr
 * @subpackage batch
 * @version    $Id$
 * 
 * Running once a day
 */

require_once('config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$c = new Criteria();
$c->add(NotificationPeer::ID, NotificationPeer::ACCOUNT_ACTIVITY);
$c->add(NotificationPeer::IS_ACTIVE, true);
$notifications = NotificationPeer::doSelect($c);

foreach ($notifications as $notification)
{
    $c = new Criteria();
    $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
    $c->add(MemberPeer::CATALOG_ID, $notification->getCatId());
    $c->add(MemberPeer::EMAIL_NOTIFICATIONS, NULL, Criteria::ISNOTNULL);
    $crit = $c->getNewCriterion(MemberPeer::EMAIL_NOTIFICATIONS, 0, Criteria::NOT_EQUAL);
    $c->addAnd($crit);
    $c->add(MemberPeer::LAST_ACTIVITY_NOTIFICATION, MemberPeer::LAST_ACTIVITY_NOTIFICATION . '< NOW() - INTERVAL ' . MemberPeer::EMAIL_NOTIFICATIONS . ' DAY', Criteria::CUSTOM);
    
    $members = MemberPeer::doSelect($c);
    
    foreach ($members as $member) Events::triggerAccountActivity($member);
}


