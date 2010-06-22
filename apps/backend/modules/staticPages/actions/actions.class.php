<?php
/**
 * staticPages actions.
 *
 * @package    pr
 * @subpackage staticPages
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class staticPagesActions extends sfActions
{
    public function preExecute()
    {
        if ($this->getRequestParameter('cancel') == 1)
        {
          $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved', false);
        }
    
        $this->left_menu_selected = 'Static Pages';
        $this->top_menu_selected = 'content';
        
        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'Content', 'uri' => 'content/list'))->add(array('name' => 'Static Pages', 'uri' => 'staticPages/list'));        
    }
    
    public function executeList()
    {
        $this->processSort();
        
        $c = new Criteria();
        $this->addSortCriteria($c);
        $c->add(StaticPageDomainPeer::CAT_ID, 1); //watherver id ...
        $this->pages = StaticPageDomainPeer::doSelectJoinAll($c);
    }
    
    public function executeEdit()
    {
        $c = new Criteria();
        $c->add(StaticPageDomainPeer::CAT_ID, $this->getRequestParameter('cat_id'));
        $c->add(StaticPageDomainPeer::ID, $this->getRequestParameter('id'));
        $c->setLimit(1);
        $pages = StaticPageDomainPeer::doSelectJoinAll($c);
        
        if( $pages )
        {
            $page = $pages[0];
        } else {
            $page = new StaticPageDomain();
            $page->setCatId($this->getRequestParameter('cat_id'));
            $page->setId($this->getRequestParameter('id'));
        }
        
        $bc = $this->getUser()->getBC();
        $bc->add(array('name' => 'Edit ' . $page->getStaticPage()->getSlug() .'.html', 'uri' => 'staticPages/edit?id=' . $page->getId() . '&cat_id=' .$page->getCatId()));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
           $this->getUser()->checkPerm(array('content_edit'));
           
           $page->setLinkName($this->getRequestParameter('link_name'));
           $page->setTitle($this->getRequestParameter('title'));
           $page->setKeywords($this->getRequestParameter('keywords'));
           $page->setDescription($this->getRequestParameter('description'));
           $page->setContent($this->getRequestParameter('html_content'));
           $page->save();
           
           $this->setFlash('msg_ok', 'Your changes have been saved.');
           $this->redirect('staticPages/list');
        }
        $this->page = $page;
    }
    
    protected function processSort()
    {
        $this->sort_namespace = 'backend/staticPages/sort';
        
        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }
        
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'StaticPageDomain::title', $this->sort_namespace); //default sort column
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
