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

require_once(realpath(dirname(__FILE__).'/../config.php'));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$c = new Criteria();
$c->add(NotificationPeer::ID, NotificationPeer::REGISTRATION_REMINDER);
$c->add(NotificationPeer::IS_ACTIVE, true);
$c->add(NotificationPeer::DAYS, 0, Criteria::GREATER_THAN);
$c->add(NotificationPeer::WHN, 'A');
$notifications = NotificationPeer::doSelect($c);

foreach ($notifications as $notification)
{
    $before7Days = date('Y-m-d', strtotime('-7 day'));
    $before21Days = date('Y-m-d', strtotime('-21 day'));
    $before90Days = date('Y-m-d', strtotime('-90 day'));

    $c = new Criteria();
    $c->add(MemberPeer::CATALOG_ID, $notification->getCatId());
    $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ABANDONED);
    $period1 = $c->getNewCriterion(MemberPeer::CREATED_AT, 'DATE('. MemberPeer::CREATED_AT .') = "'. $before7Days .'"', Criteria::CUSTOM);
    $period2 = $c->getNewCriterion(MemberPeer::CREATED_AT, 'DATE('. MemberPeer::CREATED_AT .') = "'. $before21Days .'"', Criteria::CUSTOM);
    $period3 = $c->getNewCriterion(MemberPeer::CREATED_AT, 'DATE('. MemberPeer::CREATED_AT .') = "'. $before90Days .'"', Criteria::CUSTOM);
    $c->addOr($period1);
    $c->addOr($period2);
    $c->addOr($period3);
    $members = MemberPeer::doSelect($c);
    
    foreach ($members as $member) Events::triggerRegistrationReminder($member);
}
