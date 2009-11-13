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

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
define('SF_APP',         'frontend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$c = new Criteria();
$c->add(LinkPeer::CREATED_AT, LinkPeer::CREATED_AT . ' + INTERVAL ' . LinkPeer::LIFETIME . ' SECOND <= NOW()', Criteria::CUSTOM);
LinkPeer::doDelete($c);
