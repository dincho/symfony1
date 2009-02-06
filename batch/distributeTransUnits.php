<?php

/**
 * distributeTransUnits batch script
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$c = new Criteria();
$c->add(TransUnitPeer::MSG_COLLECTION_ID, null, Criteria::ISNULL);
$c->add(TransUnitPeer::CAT_ID, 1); //english catalog
$units = TransUnitPeer::doSelect($c);

$c = new Criteria();
$c->add(CataloguePeer::CAT_ID, 1, Criteria::NOT_EQUAL);
$catalogs = CataloguePeer::doSelect($c);

foreach ($catalogs as $catalog)
{
	foreach ($units as $unit)
	{
	   $new_unit = new TransUnit();
	   $unit->copyInto($new_unit);
	   $new_unit->setCatId($catalog->getCatId());
	   $new_unit->save();
	}
}