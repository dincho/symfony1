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

    public function preExecute()
    {
        if ($this->getRequestParameter('cancel') == 1)
        {
            $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved');
            $this->redirect($this->getModuleName() . '/' . $this->getActionName() . '?id=' . $this->getRequestParameter('id'));
        }
        $this->left_menu_selected = 'Member Stories';
        $this->top_menu_selected = 'staticPages';
        
        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'Content', 'uri' => 'content/list'))->add(array('name' => 'Member Stories', 'uri' => 'memberStories/list'));
    }

    public function executeList()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
        
        $this->stories = MemberStoryPeer::doSelectWithI18n($c, 'en');
    }

    public function executeAdd()
    {
        $this->getUser()->getBC()->add(array('name' => 'New Story', 'uri' => 'memberStories/add'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $story = new MemberStory();
            $story->setCulture($this->getRequestParameter('culture'));
            $story->setLinkName($this->getRequestParameter('link_name'));
            $story->setSlug($this->getRequestParameter('url_name'));
            $story->setTitle($this->getRequestParameter('title'));
            $story->setKeywords($this->getRequestParameter('keywords'));
            $story->setDescription($this->getRequestParameter('description'));
            $story->setContent($this->getRequestParameter('html_content'));
            $story->save();
            $this->redirect('memberStories/list');
        }
    }

    public function executeEdit()
    {
        $story = MemberStoryPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($story);
        $story->setCulture($this->getRequestParameter('culture', 'en'));
        $this->getUser()->getBC()->add(array('name' => 'Edit', 'uri' => 'memberStories/edit'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $story->setCulture($this->getRequestParameter('culture'));
            $story->setLinkName($this->getRequestParameter('link_name'));
            $story->setSlug($this->getRequestParameter('slug'));
            $story->setTitle($this->getRequestParameter('title'));
            $story->setKeywords($this->getRequestParameter('keywords'));
            $story->setDescription($this->getRequestParameter('description'));
            $story->setContent($this->getRequestParameter('html_content'));
            $story->save();
            $this->redirect('memberStories/list');
        }
        $this->story = $story;
    }

    public function executeUpdate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            //update sort order
            if ($this->getRequestParameter('sort_submit'))
            {
                $sorts = $this->getRequestParameter('sort');
                $c = new Criteria();
                $c->add(MemberStoryPeer::ID, array_keys($sorts), Criteria::IN);
                $stories = MemberStoryPeer::doSelect($c);
                foreach ($stories as $story)
                {
                    if ($story->getSortOrder() != $sorts[$story->getId()])
                    {
                        $story->setSortOrder($sorts[$story->getId()]);
                        $story->save();
                    }
                }
                $this->setFlash('msg_ok', 'Sort order has been updated.');
            }
            //deletetion
            $marked = $this->getRequestParameter('marked', false);
            if (! is_null($this->getRequestParameter('delete')) && is_array($marked) && ! empty($marked))
            {
                $c = new Criteria();
                $c->add(MemberStoryPeer::ID, $marked, Criteria::IN);
                MemberStoryPeer::doDelete($c);
                $this->setFlash('msg_ok', 'Selected stories has been deleted.');
            }
        }
        $this->redirect('memberStories/list');
    }
}
