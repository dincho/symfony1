<?php

/**
 * clearDeletedWinks batch script
 *
 * This script permanently deletes marked as deleted winks before 24 hours
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
$c->add(WinkPeer::DELETED_AT, time()-24*60*60, Criteria::LESS_EQUAL);
WinkPeer::doDelete($c);
