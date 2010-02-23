<?php

/**
 * Members deactivation batch script - cron
 *
 * Inactive Members are set to status DEACTIVATED, after {X} days from notification ( LoginReminder ) sent date
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
$ddays = sfConfig::get('app_settings_deactivation_days', 0);
$days = (int) $notification->getDays() + $ddays;

if ( $ddays > 0 )
{
    $select = new Criteria();
    $select->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
    $select->add(MemberPeer::LAST_LOGIN, 'DATE('. MemberPeer::LAST_LOGIN .') + INTERVAL '. $days .' DAY = CURRENT_DATE()', Criteria::CUSTOM);

    $update = new Criteria();
    $update->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::DEACTIVATED_AUTO);

    BasePeer::doUpdate($select, $update, Propel::getConnection());
}

