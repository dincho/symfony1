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

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       0);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$notification = NotificationPeer::retrieveByPK(NotificationPeer::ABANDONED_REGISTRATION);

if ( $notification->getIsActive() )
{
    $c = new Criteria();
    $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ABANDONED);
    $c->add(MemberPeer::CREATED_AT, 'TIMESTAMPDIFF(HOUR, '. MemberPeer::CREATED_AT .', '. Criteria::CURRENT_TIMESTAMP.') BETWEEN 24 AND 25', Criteria::CUSTOM);
    $members = MemberPeer::doSelect($c);
    
    foreach ($members as $member) Events::triggerAbandonedRegistration($member);
}

