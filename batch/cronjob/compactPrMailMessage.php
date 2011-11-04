<?php

/**
 * compactPrMailMassage batch script
 *
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */
require_once(realpath(dirname(__FILE__).'/../config.php'));


// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$connection = Propel::getConnection();
$connection->setAutoCommit(false);

$sql = "LOCK TABLE pr_mail_message WRITE"; 
$statement = $connection->prepareStatement($sql); 
$resultset = $statement->executeQuery(); 

//compact procedure
$statement = $connection->createStatement();
$statement->executeUpdate('CALL `compact_pr_mail`()', ResultSet::FETCHMODE_NUM);

$statement = $connection->createStatement();
$statement->executeUpdate("COMMIT");

//Unlock table
$statement = $connection->createStatement();
$statement->executeUpdate("UNLOCK TABLES");
