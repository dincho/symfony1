<?php
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();
$con = Propel::getConnection();

$sqlFiles = sfFinder::type('file')->name('*.sql')->in(dirname(__FILE__).'/../data/fixtures');
$con->createStatement()->executeQuery('SET FOREIGN_KEY_CHECKS=0');

foreach ($sqlFiles as $sqlFile)
{
    $sql = file_get_contents($sqlFile);
    foreach (explode(';', $sql) as $query_string)
    {
      if (trim($query_string))
      {
        $con->createStatement()->executeQuery($query_string);
      }
    }
}

$con->createStatement()->executeQuery('SET FOREIGN_KEY_CHECKS=1');