<?php

/**
 * generateVisits batch script
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
$members = MemberPeer::doSelect(new Criteria());
$cnt = count($members);

for($i=0; $i<$cnt; $i++)
{
    $member = $members[$i];
    
    for($j=0; $j<10; $j++) //generate 10 visits per member to a random members
    {
        srand((float) microtime() * 10000000);
        
        $rand_member = $members[rand(0, $cnt-1)];
        
        $visit = new ProfileView();
        $visit->setMemberRelatedByMemberId($member);
        $visit->setProfileId($rand_member->getId());
        $visit->save();

        $rand_member->getCounter()->setProfileViews($rand_member->getCounter()->getProfileViews()+1);
        $rand_member->save();
    }
    
    $member->getCounter()->setMadeProfileViews($member->getCounter()->getMadeProfileViews()+10);
    $member->save();
}