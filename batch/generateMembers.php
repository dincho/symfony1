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

$image_fixtures_dir = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'fixtures'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR;
// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

// batch process here

$user_ids = array(1);
$countries = array('PL', 'BG', 'US');
$languages = array('pl', 'bg', 'en');
$us_states = array('AL', 'FL');
$photos['M'] = glob($image_fixtures_dir .'/M/*.jpg');
$photos['F'] = glob($image_fixtures_dir .'/F/*.jpg');
$sex_arr = array("F", "M");
$descQuestions = DescQuestionPeer::doSelect(new Criteria());
$descAnswers = DescAnswerPeer::getAnswersAssoc();
$weights = array(21 => 'Very Important', 8 => 'Important', 3 => 'Somehow Important', 1 => 'Not Important');
$generate_number = isset($argv[1]) ? min((int) $argv[1], 600) : 10; //default 10, max 600 cause of memory overload


for( $i=1; $i<=$generate_number; $i++):

srand((float) microtime() * 10000000);
$sex = $sex_arr[rand(0,1)];

$first_name = RandomGenerator::getFirstname($sex);
$surname = RandomGenerator::getSurname();
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
if( rand(0, 1))
{
    $member->setYoutubeVid(($sex == 'F') ? 'y9Epdt8e1h8' : 'd8krIwgzJEA');
}

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

$status_history = new MemberStatusHistory();
$status_history->setMemberStatusId(MemberStatusPeer::ABANDONED);
$status_history->setCreatedAt(Tools::randomTimestamp());
$member->addMemberStatusHistory($status_history);


$counter = new MemberCounter();
$counter->setCurrentFlags(0); //set 1 field, so save to work
$counter->save();
$member->setMemberCounter($counter);

//add 3 photos
for($p=1; $p<=3; $p++)
{
    $rand_photo = array_rand($photos[$sex]);
    $photo = new MemberPhoto();
    $photo->updateImageFromFile('file', $photos[$sex][$rand_photo]);
    if( $i==1 ) $photo->setIsMain(true);
    $member->addMemberPhoto($photo);
}

//Q&A
foreach ($descQuestions as $descQuestion)
{
    if ( array_key_exists($descQuestion->getId(), $descAnswers) && count($descAnswers[$descQuestion->getId()]) > 1 && $descQuestion->getType() != 'other_langs')
    {
        $rand_answer_n = array_rand($descAnswers[$descQuestion->getId()]);
        $member_answer = new MemberDescAnswer();
        $member_answer->setDescQuestionId($descQuestion->getId());
        $member_answer->setDescAnswerId($descAnswers[$descQuestion->getId()][$rand_answer_n]->getId());
        $member->addMemberDescAnswer($member_answer);           
    }
}

//Search Criteria
$search = new SearchCriteria();

$age_min = rand(18, 90);
$search->setAges($age_min . ',' . rand($age_min, 90));
$search->setAgesWeight(array_rand($weights));
$search->save();
$member->setSearchCriteria($search);

foreach ($descQuestions as $descQuestion)
{
    if ( array_key_exists($descQuestion->getId(), $descAnswers) && count($descAnswers[$descQuestion->getId()]) > 1 && $descQuestion->getType() != 'other_langs')
    {
        $rand_answer_n1 = array_rand($descAnswers[$descQuestion->getId()]);
        $rand_answer_n2 = array_rand($descAnswers[$descQuestion->getId()]);
        $search_crit_desc = new SearchCritDesc();
        $search_crit_desc->setSearchCriteriaId($search->getId());
        $search_crit_desc->setDescQuestionId($descQuestion->getId());     
        $search_crit_desc->setDescAnswers($descAnswers[$descQuestion->getId()][$rand_answer_n1]->getId() . ',' . $descAnswers[$descQuestion->getId()][$rand_answer_n2]->getId());
        $search_crit_desc->setMatchWeight(array_rand($weights));
        $search_crit_desc->save();
    }    
}

//saving
$member->save();
echo "Generated member - $i: " . $member->getUsername() . "\n";

//free some memory
unset($member);
unset($counter);
unset($status_history);
unset($photo);
unset($member_answer);
unset($search);

endfor;