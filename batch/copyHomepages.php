<?php

/**
 * generateFlags batch script
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    pr
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
$base_trans_unit = TransUnitPeer::getByCultureAndCollection(1, 'en');

$c = new Criteria();
$c->add(CataloguePeer::TARGET_LANG, 'en', Criteria::NOT_EQUAL);
$catalogs = CataloguePeer::doSelect($c);

foreach ($catalogs as $catalog)
{
    $tran_unit = new TransUnit();
    $base_trans_unit->copyInto($tran_unit);
    $tran_unit->setCatId($catalog->getCatId());
    $tran_unit->save();
}