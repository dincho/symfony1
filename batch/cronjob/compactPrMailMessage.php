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

$customObject = new CustomQueryObject();

$sql = 'CALL `compact_pr_mail`()';
             
$conn = Propel::getConnection();
$stmt = $conn->createStatement();
$rs = $stmt->executeQuery($sql, ResultSet::FETCHMODE_NUM);
$stmt->close();