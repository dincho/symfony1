<?php
define('SF_ROOT_DIR',    realpath(dirname(__file__).'/..'));
define('SF_APP',         'frontend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$c = new Criteria();

$c->add(GeoPeer::GEO_DETAILS_ID, null, Criteria::ISNULL);
$c->add(GeoPeer::INFO, '', Criteria::NOT_EQUAL);

    
$geos = GeoPeer::doSelect($c);

foreach($geos as $geo)
{
        $details = new GeoDetails();
        $details->setCulture('en');
        
        $details->setGeo($geo);
        $details->setMemberInfo($geo->getInfo());
        $details->save();
        
        $geo->setGeoDetails($details);
        $geo->save();
}