<?php

/**
 * memberStories actions.
 *
 * @package    pr
 * @subpackage memberStories
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class memberStoriesActions extends prActions
{

    public function executeIndex()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
        $c->add(MemberStoryPeer::CAT_ID, $this->getUser()->getCatalogId());
        $this->stories = MemberStoryPeer::doSelect($c);

        $this->getUser()->getBC()->addFirst(array('name' => 'Home', 'uri' => '@homepage'));
    }

    public function executeRead()
    {
        $c = new Criteria();
        $c->add(MemberStoryPeer::SLUG, $this->getRequestParameter('slug'));
        $c->add(MemberStoryPeer::CAT_ID, $this->getUser()->getCatalogId());
        //$c->add(MemberStoryPeer::CULTURE, $this->getUser()->getCulture());
        $c->setLimit(1);

        $stories = MemberStoryPeer::doSelectJoinStockPhoto2($c);
        $this->forward404Unless($stories);
        $this->story = $stories[0];

        $this->getResponse()->setTitle($this->story->getTitle());
        $this->getResponse()->addMeta('keywords', $this->story->getKeywords());
        $this->getResponse()->addMeta('description', $this->story->getDescription());

        $bc = $this->getUser()->getBC()->clear();
        $bc->add(array('name' => 'Home', 'uri' => '@homepage'));

        //next story
        $c = new Criteria();
        $c->add(MemberStoryPeer::SORT_ORDER, $this->story->getSortOrder(), Criteria::GREATER_THAN);
        $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
        $c->add(MemberStoryPeer::CAT_ID, $this->story->getCatId());
        $this->next_story = MemberStoryPeer::doSelectOne($c);
    }
}
