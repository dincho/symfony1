<?php

/**
 * Abandoned members report script - cron
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    pr
 * @subpackage batch
 * @version    $Id$
 * 
 * Run each hour
 */

require_once('config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$c = new Criteria();
$c->add(NotificationPeer::ID, NotificationPeer::ABANDONED_REGISTRATION);
$c->add(NotificationPeer::IS_ACTIVE, true);
$notifications = NotificationPeer::doSelect($c);

foreach($notifications as $notification)
{
    $c = new Criteria();
    $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ABANDONED);
    $c->add(MemberPeer::CATALOG_ID, $notification->getCatId());
    $c->add(MemberPeer::CREATED_AT, 'TIMESTAMPDIFF(HOUR, '. MemberPeer::CREATED_AT .', '. Criteria::CURRENT_TIMESTAMP.') BETWEEN 24 AND 25', Criteria::CUSTOM);
    $members = MemberPeer::doSelect($c);

    foreach ($members as $member) Events::triggerAbandonedRegistration($member);
}

