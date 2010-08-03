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

require_once(realpath(dirname(__FILE__).'/../config.php'));
require_once(sfConfigCache::getInstance()->checkConfig('config/db_settings.yml'));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$ddays = sfConfig::get('app_settings_deactivation_days', 0);

if ( $ddays > 0 )
{
    $c = new Criteria();
    $c->add(NotificationPeer::ID, NotificationPeer::LOGIN_REMINDER);
    $notifications = NotificationPeer::doSelect($c);

    foreach($notifications as $notification)
    {
        $days = (int) $notification->getDays() + $ddays;

        $select = new Criteria();
        $select->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
        $select->add(MemberPeer::CATALOG_ID, $notification->getCatId());
        $select->add(MemberPeer::LAST_LOGIN, 'DATE('. MemberPeer::LAST_LOGIN .') + INTERVAL '. $days .' DAY <= CURRENT_DATE()', Criteria::CUSTOM);

        $update = new Criteria();
        $update->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::DEACTIVATED_AUTO);

        BasePeer::doUpdate($select, $update, Propel::getConnection());
    }
}
