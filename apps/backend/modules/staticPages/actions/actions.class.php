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
          $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved');
          $this->redirect($this->getModuleName().'/'.$this->getActionName().'?id=' . $this->getRequestParameter('id'));
        }
    
        $this->left_menu_selected = 'Static Pages';
        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'Content', 'uri' => 'content/list'))->add(array('name' => 'Static Pages', 'uri' => 'staticPages/list'));        
    }
    
    public function executeList()
    {
        $c = new Criteria();
        $c->add(StaticPageI18nPeer::CULTURE, $this->getRequestParameter('lang', 'en'));
        $this->pages = StaticPagePeer::doSelectWithI18n($c);
    }
    
    public function executeEdit()
    {
        $c = new Criteria();
        //$c->add(StaticPageI18nPeer::CULTURE, $this->getRequestParameter('lang'));
        $c->add(StaticPagePeer::ID, $this->getRequestParameter('id'));
        //$c->setLimit(1);
        
        //$pages = StaticPagePeer::doSelectWithI18n($c, $this->getRequestParameter('lang', 'en'));
        $page = StaticPagePeer::doSelectOne($c);
        $page->setCulture($this->getRequestParameter('culture', 'en'));
        
        //$this->forward404Unless($pages);
        //$page = (isset($pages[0])) ? $pages[0] : null;
        $bc = $this->getUser()->getBC();
        $bc->add(array('name' => 'Edit ' . $page->getSlug() .'.html', 'uri' => 'staticPages/edit?id=' . $page->getId()));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
           //print_r($this->getRequest()->getParameterHolder()->getAll());exit();
           //$page->setTitle($this->getRequestParameter('title'));
           $page->setLinkName($this->getRequestParameter('link_name'));
           $page->setTitle($this->getRequestParameter('title'));
           $page->setKeywords($this->getRequestParameter('keywords'));
           $page->setDescription($this->getRequestParameter('description'));
           $page->setContent($this->getRequestParameter('html_content'));
           $page->save();
           //$this->redirect('staticPages/list');
        }
        
        $this->page = $page;
        
    }
}
