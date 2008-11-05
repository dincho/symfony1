<?php
/**
 * states actions.
 *
 * @package    pr
 * @subpackage states
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class statesActions extends sfActions
{

    public function preExecute()
    {
        $this->top_menu_selected = 'content';
    }
    
    public function executeList()
    {
        $this->states = StatePeer::doSelect(new Criteria());
    }

    public function executeCreate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $state = new State();
            $state->setCountry($this->getRequestParameter('country'));
            $state->setTitle($this->getRequestParameter('title'));
            $state->save();
            
            $this->setFlash('msg_ok', 'State has been created.');
            $this->redirect('states/list');
        }
    }
    
    public function handleErrorCreate()
    {
        return sfView::SUCCESS;
    }
    
    public function executeEdit()
    {
        $state = StatePeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($state);
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $state->setCountry($this->getRequestParameter('country'));
            $state->setTitle($this->getRequestParameter('title'));
            $state->save();
            
            $this->redirect('states/list?confirm_msg=' . confirmMessageFilter::OK);
        }
        $this->state = $state;
    }

    public function handleErrorEdit()
    {
        $this->state = StatePeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($this->state);
        return sfView::SUCCESS;
    }

    public function executeDelete()
    {
        $marked = $this->getRequestParameter('marked', false);
        
        if( is_array($marked) && !empty($marked) )
        {
          $c = new Criteria();
          $c->add(StatePeer::ID, $marked, Criteria::IN);
          StatePeer::doDelete($c);
        }
    
        $this->redirect('states/list?confirm_msg=' . confirmMessageFilter::DELETE);
    }
}
