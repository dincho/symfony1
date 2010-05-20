<?php

/**
 * clearDailyMembersCounters batch script
 *
 * Script that runs at first day of each month at 00:01 and clear monthly counters of all members
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
define('SF_APP',         'frontend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       0);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$c = new Criteria();
$c->add(MemberCounterPeer::ID, null, Criteria::ISNOTNULL); //this goes to selected criteria when passed to doUpdate
$c->add(MemberCounterPeer::SENT_WINKS, 0);
$c->add(MemberCounterPeer::RECEIVED_WINKS, 0);
$c->add(MemberCounterPeer::READ_MESSAGES, 0);
$c->add(MemberCounterPeer::REPLY_MESSAGES, 0);
$c->add(MemberCounterPeer::SENT_MESSAGES, 0);
$c->add(MemberCounterPeer::RECEIVED_MESSAGES, 0);
$c->add(MemberCounterPeer::ASSISTANT_CONTACTS, 0);

MemberCounterPeer::doUpdate($c);
