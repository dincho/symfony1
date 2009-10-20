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

define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../..'));
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
$countries = array('PL', 'BG', 'US', 'GB');
$languages = array('pl', 'bg', 'en', 'en');
$photos['M'] = glob($image_fixtures_dir .'/M/*.jpg');
$photos['F'] = glob($image_fixtures_dir .'/F/*.jpg');
$sex_arr = array("F", "M");
$descQuestions = DescQuestionPeer::doSelect(new Criteria());
$descAnswers = DescAnswerPeer::getAnswersAssoc();
$weights = array(21 => 'Very Important', 8 => 'Important', 3 => 'Somehow Important', 1 => 'Not Important');
$generate_number = isset($argv[1]) ? min((int) $argv[1], 500) : 10; //default 10, max 500 cause of memory overload
$num_photos = isset($argv[2]) ? (int) $argv[2] : 0;
$max_memory_usage = 248 * 1024 * 1024; //248MB

echo 'Initial Memory: ' . number_format(memory_get_usage(), 0, '.', ',') . " bytes\n";
echo "--------------------------------------------\n";

for( $i=1; $i<=$generate_number; $i++):

srand((float) microtime() * 10000000);
$sex = $sex_arr[rand(0,1)];
$looking_for = $sex_arr[rand(0,1)];

$first_name = RandomGenerator::getFirstname($sex);
$surname = RandomGenerator::getSurname();
$username = $first_name . '_' . $surname . rand(1, 99999);

echo "Generating member - $i: " . $username . "\n";

$member = new Member();
$member->setUsername( $username  );
$member->setPassword('123qwe');
$member->setFirstName($first_name);
$member->setLastName($surname);
$member->setEmail($username .  '@polishromance.com');
$member->setBirthday(date('Y-m-d',Tools::randomTimestamp('1 January 1950', '1 January 1990')));
$member->setLastLogin(Tools::randomTimestamp('1 January 2006', '1 August 2008'));
$member->setSex($sex);
$member->setLookingFor($looking_for);
$member->setLastStatusChange(Tools::randomTimestamp());
$member->setEssayHeadline(RandomGenerator::getSentence());
$member->setEssayIntroduction(RandomGenerator::getSentence(50, 20));
$member->setPublicSearch(rand(0,1));

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

/** Attaching some random GEO info **/
$country_rand = array_rand($countries);
$country_iso = $countries[$country_rand];

echo "\tCountry: " . $country_iso . "\n";
$member->setCountry($country_iso);

$c = new Criteria();
$c->add(GeoPeer::DSG, "ADM1");
$c->add(GeoPeer::COUNTRY, $country_iso);
$c->addDescendingOrderByColumn("RAND()");
$adm1 = GeoPeer::doSelectOne($c);

if( $adm1 )
{
    echo "\tADM1: " . $adm1->getName() . "\n";
    $member->setAdm1Id($adm1->getId());
    $c->add(GeoPeer::DSG, "ADM2");
    $c->add(GeoPeer::ADM1, $adm1->getName());
    $adm2 = GeoPeer::doSelectOne($c);
    
    if( $adm2 )
    {
        echo "\tADM2: " . $adm2->getName() . "\n";
        $member->setAdm2Id($adm2->getId());
        $c->add(GeoPeer::ADM2, $adm2->getName());
        unset($adm2);
    }
    
    unset($adm1);
}

$c->add(GeoPeer::DSG, "PPL");
$city = GeoPeer::doSelectOne($c);
$c->clear();
unset($c);

if( $city )
{
    $member->setCityId($city->getId());
    echo "\tCity: " .$city->getName() . "\n";
}
unset($city);

/** END GEO **/
$member->setLanguage($languages[$country_rand]);
$member->setIsStarred(rand(0,1));

//subscription
$sub_id = rand(1,3);
$member->setSubscriptionId($sub_id);
$sub_history = new SubscriptionHistory();
$sub_history->setSubscriptionId($sub_id);
$sub_history->setFromDate(null);
$sub_history->setMemberStatusId($member->getMemberStatusId());
$member->addSubscriptionHistory($sub_history);
unset($sub_history);

$member->setCreatedAt(Tools::randomTimestamp());
$member->setLastActivity(Tools::randomTimestamp());

$member->setMemberStatusId(rand(1,10));
$status_history = new MemberStatusHistory();
$status_history->setMemberStatusId($member->getMemberStatusId());
$status_history->setFromStatusId(null);
//$status_history->setCreatedAt(Tools::randomTimestamp());
$status_history->setFromDate(null);
$member->addMemberStatusHistory($status_history);
unset($status_history);


$counter = new MemberCounter();
$counter->setCurrentFlags(0); //set 1 field, so save to work
$counter->save();
$member->setMemberCounter($counter);
unset($counter);

if( $num_photos > 0)
{
    //add 3 photos
    for($p=1; $p<=$num_photos; $p++)
    {
        $rand_photo = array_rand($photos[$sex]);
        $photo = new MemberPhoto();
        $photo->updateImageFromFile('file', $photos[$sex][$rand_photo]);
        if( $p==1 ) $member->setMemberPhoto($photo);
        $member->addMemberPhoto($photo);
        unset($photo);
    }
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
        unset($member_answer);
    }
}

//Search Criteria
foreach ($descQuestions as $descQuestion)
{
    if ( array_key_exists($descQuestion->getId(), $descAnswers) && count($descAnswers[$descQuestion->getId()]) > 1 && $descQuestion->getType() != 'other_langs' && $descQuestion->getType() != 'age')
    {
        $rand_answer_n1 = array_rand($descAnswers[$descQuestion->getId()]);
        $rand_answer_n2 = array_rand($descAnswers[$descQuestion->getId()]);
        
        $search_crit_desc = new SearchCritDesc();
        $search_crit_desc->setMemberId($member->getId());
        $search_crit_desc->setDescQuestionId($descQuestion->getId());     
        $search_crit_desc->setDescAnswers($descAnswers[$descQuestion->getId()][$rand_answer_n1]->getId() . ',' . $descAnswers[$descQuestion->getId()][$rand_answer_n2]->getId());
        $search_crit_desc->setMatchWeight(array_rand($weights));
        $member->addSearchCritDesc($search_crit_desc);
        unset($search_crit_desc);
    }    
}

//saving
$member->save();
unset($member);

if( memory_get_usage() > $max_memory_usage ) 
{
  echo "Breaking the loop because of hight memory usage: " . number_format(memory_get_usage(), 0, '.', ',') . " bytes\n";
  break;
}

endfor;

