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
            $this->redirect($this->getModuleName() . '/' . $this->getActionName() . '?cat_id=' . $this->getRequestParameter('cat_id'));
        }
        $this->left_menu_selected = 'Member Stories';
        $this->top_menu_selected = 'content';
        
        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'Content', 'uri' => 'content/list'))->add(array('name' => 'Member Stories', 'uri' => 'memberStories/list'));
        
        $this->catalog = CataloguePeer::retrieveByPK($this->getRequestParameter('cat_id'));
        $this->forward404Unless($this->catalog);
    }

    public function executeList()
    {
        $this->processSort();
        
        $c = new Criteria();
        $this->addSortCriteria($c);
        
        $c->add(MemberStoryPeer::CAT_ID, $this->catalog->getCatId()); 
        $this->stories = MemberStoryPeer::doSelect($c);
    }

    public function executeAdd()
    {
        $this->getUser()->getBC()->add(array('name' => 'New Story', 'uri' => 'memberStories/add'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $story = new MemberStory();
            $story->setCatId($this->getRequestParameter('cat_id'));
            $story->setLinkName($this->getRequestParameter('link_name'));
            $story->setTitle($this->getRequestParameter('title'));
            $story->setSummary($this->getRequestParameter('summary'));
            $story->setKeywords($this->getRequestParameter('keywords'));
            $story->setDescription($this->getRequestParameter('description'));
            $story->setContent($this->getRequestParameter('html_content'));
            $story->save();
            $this->redirect('memberStories/list?cat_id=' . $story->getCatId());
        }
        
        $this->catalogs = CataloguePeer::doSelect(new Criteria());
    }

    public function executeEdit()
    {
        $story = MemberStoryPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($story);
        
        //$story->setCulture($this->getRequestParameter('culture', 'en'));
        $this->getUser()->getBC()->add(array('name' => 'Edit', 'uri' => 'memberStories/edit'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            
            $story->setCatId($this->getRequestParameter('cat_id'));
            $story->setLinkName($this->getRequestParameter('link_name'));
            $story->setTitle($this->getRequestParameter('title'));
            $story->setSummary($this->getRequestParameter('summary'));
            $story->setKeywords($this->getRequestParameter('keywords'));
            $story->setDescription($this->getRequestParameter('description'));
            $story->setContent($this->getRequestParameter('html_content'));
            $story->save();
            $this->redirect('memberStories/list?cat_id=' . $story->getCatId());
        }
        $this->story = $story;
    }

    public function executeUpdate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
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
        $this->redirect('memberStories/list?cat_id=' . $this->getRequestParameter('cat_id'));
    }
    
    protected function processSort()
    {
        $this->sort_namespace = 'backend/memberStories/sort';
        
        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }
        
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'MemberStory::sort_order', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'asc', $this->sort_namespace); //default order
        }
    }

    protected function addSortCriteria($c)
    {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $sort_arr = explode('::', $sort_column);
            $peer = $sort_arr[0] . 'Peer';
            
            $sort_column = call_user_func(array($peer, 'translateFieldName'), $sort_arr[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
            if ($this->getUser()->getAttribute('type', null, $this->sort_namespace) == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
            } else
            {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }
}
