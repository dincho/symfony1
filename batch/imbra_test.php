<?php

/**
 * imbra_test batch script
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
//$member = MemberPeer::retrieveByPK(1);
//$member = new Member();

$imbra = new MemberImbra();
//$imbra = MemberImbraPeer::retrieveByPK(5);
$imbra->setImbraStatusId(2);
//$imbra->addVersion();
$imbra->setText('version 5');

$answer = new MemberImbraAnswer();
$answer->setAnswer(true);
$answer->setImbraQuestionId(1);
$imbra->addMemberImbraAnswer($answer);



$member = MemberPeer::retrieveByPK(1);
$member->addMemberImbra($imbra);
$member->save();
