<?php

/**
 *  sfCountries2SQL batch script
 *
 * dump sfCountries to GEO ready SQL
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
//$databaseManager = new sfDatabaseManager();
//$databaseManager->initialize();

// batch process here

$culture = 'en';

$c = new sfCultureInfo($culture);
$countries = $c->getCountries();

//remove continents out of the array
$culture_continets_elements = ($culture == 'en') ? 30 : 29;
$countries = array_slice($countries, $culture_continets_elements);

//remove some non-countries
unset($countries['QU'], $countries['ZZ'], $countries['QO']);

asort($countries, SORT_LOCALE_STRING);

foreach($countries as $iso => $name)
{
    printf('INSERT INTO geo (name, dsg, country) VALUES ("%s", "PCL", "%s");' . "\n", $name, $iso);
}
