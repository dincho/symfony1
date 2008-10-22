<?php

/**
 * memberStories actions.
 *
 * @package    pr
 * @subpackage memberStories
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class memberStoriesActions extends sfActions
{
  public function executeIndex()
  {
      $c = new Criteria();
      $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
      
      $this->stories = MemberStoryPeer::doSelectWithI18n($c);
  }
  
  public function executeRead()
  {
      $c = new Criteria();
      $c->add(MemberStoryPeer::SLUG, $this->getRequestParameter('slug'));
      $c->setLimit(1);
      
      $stories = MemberStoryPeer::doSelectWithI18n($c);
      $this->forward404Unless($stories);
      $this->story = $stories[0];
      
      $this->getResponse()->setTitle($this->story->getTitle());
      $this->getResponse()->addMeta('keywords', $this->story->getKeywords());
      $this->getResponse()->addMeta('description', $this->story->getDescription());
      
      $this->getUser()->getBC()->replaceLast(array('name' => $this->story->getLinkName(), 'uri' => '@member_story_by_slug?slug=' . $this->story->getSlug()));
      
  }
  
  public function executePostYourStory()
  {
      
  }
}
