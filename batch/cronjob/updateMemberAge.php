<?php

/**
 * Update pre-calculated age field of member batch script - cron
 *
 *
 * @package    pr
 * @subpackage batch
 * @version    $Id$
 * 
 * Running once a day
 */

require_once(realpath(dirname(__FILE__).'/../config.php'));
require_once(sfConfigCache::getInstance()->checkConfig('config/db_settings.yml'));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$query = "UPDATE member 
SET age = (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(birthday, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(birthday, '00-%m-%d')))
WHERE birthday IS NOT NULL"
;

$connection = Propel::getConnection();
$statement = $connection->prepareStatement($query);
$statement->executeQuery();
