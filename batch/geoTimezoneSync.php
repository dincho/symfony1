<?php

/**
 * geoTimezoneSync batch script
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
$offset = 0;
$limit = 100;
$last_geo_id = -20000000000;
$ts = time();
$cnt_updated = 0;

$c = new Criteria();
$c->add(GeoPeer::LATITUDE, null, Criteria::ISNOTNULL);
$c->add(GeoPeer::LONGITUDE, null, Criteria::ISNOTNULL);
$c->add(GeoPeer::TIMEZONE, 'UTC');
$c->add(GeoPeer::ID, $last_geo_id, Criteria::GREATER_THAN);
$c->addAscendingOrderByColumn(GeoPeer::ID);
$cnt = GeoPeer::doCount($c);

$c->setLimit($limit);
$c->clearSelectColumns()->addSelectColumn(GeoPeer::ID);
$c->addSelectColumn(GeoPeer::LATITUDE);
$c->addSelectColumn(GeoPeer::LONGITUDE);

$connection = Propel::getConnection();


while( $offset < $cnt )
{
    $c->setOffset($offset);
    $rs = GeoPeer::doSelectRS($c);
    
    while($rs->next())
    {
        $id = $rs->getInt(1);
        $lat = $rs->getFloat(2);
        $lng = $rs->getFloat(3);
        
        $ws_url = sprintf('http://ws.geonames.org/timezoneJSON?formatted=true&lat=%f&lng=%f&style=full', $lat, $lng);
        $result = json_decode(file_get_contents($ws_url));
        
        print_r($result);
        
        if( isset($result->timezoneId) )
        {
           $query = 'UPDATE %s SET %s = "%s" WHERE %s = %d LIMIT 1';

           $query = sprintf($query,
             GeoPeer::TABLE_NAME,
             GeoPeer::TIMEZONE,
             $result->timezoneId,
             GeoPeer::ID,
             $id
           );
           $statement = $connection->prepareStatement($query);
           $statement->executeQuery();
           
           echo "Updated GEO ID: " . $id . "\n";
        } else {
            echo "No TZ result for GEO ID: " . $id . "\n";
        }
        
        $cnt_updated++;
    }
    
    $offset += $limit;
}

printf("Updated %d records for %f seconds", $cnt_updated, time()-$ts);

