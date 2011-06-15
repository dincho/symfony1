<?php

/**
 * clearMemberNotification batch script
 *
 * This script permanently deletes MemberNotifications before 30 min
 * Runs once a day
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
$c = new Criteria();
$c->add(MemberNotificationPeer::CREATED_AT, 'DATE_SUB(CURDATE(),INTERVAL 30 MINUTE)', Criteria::LESS_EQUAL);
MemberNotificationPeer::doDelete($c);
