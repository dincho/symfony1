<?php

/**
 * clearLinks batch script
 *
 * This script clean-up the links garbage
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
$c->add(LinkPeer::CREATED_AT, LinkPeer::CREATED_AT . ' + INTERVAL ' . LinkPeer::LIFETIME . ' SECOND <= NOW()', Criteria::CUSTOM);
LinkPeer::doDelete($c);
