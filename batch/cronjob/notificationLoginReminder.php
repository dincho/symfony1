<?php

/**
 * Login Reminder batch script - cron
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    pr
 * @subpackage batch
 * @version    $Id$
 * 
 * Running once a day
 */

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
include_once (sfConfigCache::getInstance()->checkConfig('config/db_settings.yml')); 

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$notification = NotificationPeer::retrieveByPK(NotificationPeer::LOGIN_REMINDER);
$days = (int) $notification->getDays();

if ( $notification->getIsActive() && $days > 0 && $notification->getWhn() == 'A')
{
    $c = new Criteria();
    $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
    $c->add(MemberPeer::LAST_LOGIN, 'DATE('. MemberPeer::LAST_LOGIN .') + INTERVAL '. $days .' DAY = CURRENT_DATE()', Criteria::CUSTOM);
    $members = MemberPeer::doSelect($c);
    
    foreach ($members as $member) Events::triggerLoginReminder($member);
}

