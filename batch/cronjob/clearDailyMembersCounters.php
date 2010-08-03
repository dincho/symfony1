<?php

/**
 * clearDailyMembersCounters batch script
 *
 * Script that runs each day at 00:01 and clear daily counters of all members
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
$c->add(MemberCounterPeer::ID, null, Criteria::ISNOTNULL); //this goes to selected criteria when passed to doUpdate
$c->add(MemberCounterPeer::SENT_WINKS_DAY, 0);
$c->add(MemberCounterPeer::READ_MESSAGES_DAY, 0);
$c->add(MemberCounterPeer::REPLY_MESSAGES_DAY, 0);
$c->add(MemberCounterPeer::SENT_MESSAGES_DAY, 0);
$c->add(MemberCounterPeer::ASSISTANT_CONTACTS_DAY, 0);

MemberCounterPeer::doUpdate($c);
