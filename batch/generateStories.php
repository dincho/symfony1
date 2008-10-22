<?php

/**
 * generateStories batch script
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

for($i=0; $i<10; $i++)
{
    $story = new MemberStory();
    $story->setCulture('en');
    $story->setLinkName(RandomGenerator::getSentence());
    $story->setSlug('story' . rand(1, 65000));
    $story->setTitle(RandomGenerator::getSentence());
    $story->setKeywords(RandomGenerator::getSentence());
    $story->setDescription(RandomGenerator::getSentence());
    $story->setContent(RandomGenerator::generate());
    $story->save();
}