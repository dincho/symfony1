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
    $days = (int) $notification->getDays();
    
    $c = new Criteria();
    $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ABANDONED);
    $c->add(MemberPeer::CREATED_AT, 'DATE('. MemberPeer::CREATED_AT .') + INTERVAL '. $days .' DAY = CURRENT_DATE()', Criteria::CUSTOM);
    $members = MemberPeer::doSelect($c);
    
    foreach ($members as $member) Events::triggerRegistrationReminder($member);
}