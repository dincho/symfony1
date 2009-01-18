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

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/..'));
define('SF_APP',         'frontend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$c = new Criteria();
$c->add(WinkPeer::DELETED_AT, time()-24*60*60, Criteria::LESS_EQUAL);
WinkPeer::doDelete($c);
