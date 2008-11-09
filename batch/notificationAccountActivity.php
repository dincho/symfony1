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

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$notification = NotificationPeer::retrieveByPK(NotificationPeer::ACCOUNT_ACTIVITY);

if ( $notification->getIsActive() )
{
    $c = new Criteria();
    $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
    $members = MemberPeer::doSelect($c);
    
    foreach ($members as $member) Events::triggerAccountActivity($member);
}

