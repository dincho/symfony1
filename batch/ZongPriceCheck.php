<?php

/**
 * Zong countries checker
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
// $databaseManager = new sfDatabaseManager();
// $databaseManager->initialize();

$countries = array('AR', 'AU', 'AT', 'BE', 'CA', 'CZ', 'CL', 'CO', 'DK', 'FI', 'FR', 'DE', 'HU', 'IE', 'MX', 'NZ', 'NL', 'NO', 'PL', 'PT', 'RU', 'ZA', 'ES', 'SE', 'CH', 'TR', 'GB', 'US', 'VE');

// $countries = array('PL', 'GB', 'US', 'DE');

$zong = new sfZong();
$zong->setCustomerKey('polishdev');
$zong->setItemsCurrency('PLN');

foreach ($countries as $country_code)
{
    $zong->setCountryCode($country_code);
    $item = $zong->getFirstItemWithPriceGreaterThan($argv[1]);
}