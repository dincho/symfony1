<?php

/**
 * generateStatusHistory batch script
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    PolishRomance
 * @subpackage batch
 * @version    $Id$
 */

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       1);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here
$members = MemberPeer::doSelect(new Criteria());
$cnt_mem = count($members);
$ss = MemberStatusPeer::doSelect(new Criteria());
$cnt_ss = count($ss);

for($i=0; $i<$cnt_mem; $i++)
{
    $member = $members[$i];
    
    for($j=0; $j<5; $j++) //generate 5 history rows
    {
        srand((float) microtime() * 10000000);
        $rand_ss = $ss[rand(0, $cnt_ss-1)];
        
        $history = new MemberStatusHistory();
        $history->setMemberId($member->getId());
        $history->setMemberStatusId($rand_ss->getId());
        $history->setCreatedAt(Tools::randomTimestamp('1 January 2000', '29 January 2009'));
        $history->save();
    }
}
