<?php

/**
 * generateWinks batch script
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    pr
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
$cnt = count($members);

for($i=0; $i<$cnt; $i++)
{
    $member = $members[$i];
    
    for($j=0; $j<5; $j++) //generate 5 winks per member
    {
        srand((float) microtime() * 10000000);
        
        $rand_member = $members[rand(0, $cnt-1)];
        WinkPeer::send($member, $rand_member);
    }
}