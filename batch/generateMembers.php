<?php
/**
 * generateMembers.php batch script
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

$user_ids = array(1);
$countries = array('PL', 'BG', 'US');
$languages = array('pl', 'bg', 'en');
$us_states = array('AL', 'FL');
$photos['M'] = array('1216898077_BW_DAVE_GRADUATE_5X7_UPRIGHT.jpg', '1216898164_kevinrosseel_K_dark_MN.jpg', '1216898206_stockvault_6130_20070301.jpg', '1216898268_stockvault_8978_20071127.jpg', '1216898326_stockvault_11145_20080428.jpg');
$photos['F'] = array('1216897623_DSC02303_a.jpg', '1216897680_DSC03304.jpg', '1216897735_Elisha_Cuthbert_Toro_Photoshoot_07.jpg', '1216897932_IMG_7002a.jpg', '1216897969_IMGP2027.jpg', '1216898004_stockvault_8187_20070722.jpg', '1216898043_stockvault_11016_20080407.jpg');

for( $i=0; $i<50; $i++):

//$rand = Tools::generateString(4);

srand((float) microtime() * 10000000);
$sex_arr = array("F", "M");
$sex = $sex_arr[rand(0,1)];

$first_name = RandomGenerator::getFirstname($sex);
$surname = RandomGenerator::getSurname();
//$first_name_l = strtolower($first_name);
//$surname_l = strtolower($surname);
$username = $first_name . '_' . $surname;

$member = new Member();
$member->setUsername( $username  );
$member->setPassword($username);
$member->setFirstName($first_name);
$member->setLastName($surname);
$member->setEmail($username .  '@polishromance.com');
$member->setBirthday(date('Y-m-d',Tools::randomTimestamp('1 January 1950', '1 January 1990')));
$member->setLastLogin(Tools::randomTimestamp('1 January 2006', '1 August 2008'));
$member->setSex($sex);
$member->setMemberStatusId(rand(1,6));
$member->setLastStatusChange(Tools::randomTimestamp());
$member->setEssayHeadline(RandomGenerator::getSentence());
$member->setEssayIntroduction(RandomGenerator::getSentence(50, 20));
// fifthy/fifthy
if( rand(0,1) )
{
    $user_id_rand = array_rand($user_ids);
    $member->setReviewedById($user_ids[$user_id_rand]);
    $member->setReviewedAt(Tools::randomTimestamp());
}

$country_rand = array_rand($countries);
if( $countries[$country_rand] == 'US' )
{
    $state_id = rand(1,2); //Alabama or Flodira
    $member->setStateId($state_id);
    $city = RandomGenerator::getCity('US', $us_states[$state_id-1]);
} else {
    $city = RandomGenerator::getCity($countries[$country_rand]);
}

$member->setCity($city);
$member->setCountry($countries[$country_rand]);
$member->setLanguage($languages[$country_rand]);
$member->setIsStarred(rand(0,1));

$member->setSubscriptionId(rand(1,3));
$member->setCreatedAt(Tools::randomTimestamp());
$member->setLastActivity(Tools::randomTimestamp());

/*
$search = new SearchCriteria();
$search->setAgeMin(18);
$search->setAgeMax(30);
$search->save();
$member->setSearchCriteria($search);
*/

$status_history = new MemberStatusHistory();
$status_history->setMemberStatusId(MemberStatusPeer::ABANDONED);
$status_history->setCreatedAt(Tools::randomTimestamp());
$member->addMemberStatusHistory($status_history);


$counter = new MemberCounter();
$counter->setCurrentFlags(0); //set 1 field, so save to work
$counter->save();
$member->setMemberCounter($counter);

//add a photo
$rand_photo = array_rand($photos[$sex]);
$photo = new MemberPhoto();
$photo->setFile($photos[$sex][$rand_photo]);
$photo->setIsMain(true);
$member->addMemberPhoto($photo);

//Q&A
$descQuestions = DescQuestionPeer::doSelect(new Criteria());

foreach ($descQuestions as $descQuestion)
{
    $descAnswers = $descQuestion->getDescAnswers();
    if ( count($descAnswers) > 1 && $descQuestion->getType() != 'other_langs')
    {
        $rand_answer_n = array_rand($descAnswers);
        $member_answer = new MemberDescAnswer();
        $member_answer->setDescQuestionId($descQuestion->getId());
        $member_answer->setDescAnswerId($descAnswers[$rand_answer_n]->getId());
        $member->addMemberDescAnswer($member_answer);           
    }

}

//saving
$member->save();

endfor;