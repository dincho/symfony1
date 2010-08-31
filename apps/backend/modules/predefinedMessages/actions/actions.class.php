<?php

/**
 * predefinedMessages actions.
 *
 * @package    PolishRomance
 * @subpackage predefinedMessages
 * @author     Dincho Todorov <dincho at xbuv.com>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class predefinedMessagesActions extends sfActions
{
    
    public function preExecute()
    {
        if ($this->getRequestParameter('cancel') == 1)
        {
            $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved');
            $this->redirect($this->getModuleName() . '/' . $this->getActionName() . '?id=' . $this->getRequestParameter('id'));
        }
    
        $bc = $this->getUser()->getBC();
        $bc->addFirst(array('name' => 'Messages', 'uri' => 'messages/list'));
        $this->top_menu_selected = "messages";
        $this->left_menu_selected = "Predefined Messages";
    }
        
    public function executeList()
    {
      $this->messages = PredefinedMessagePeer::doSelect(new Criteria());
    }

    public function executeCreate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            $message = new PredefinedMessage();
            $message->setCatalogId($this->getRequestParameter('catalog_id'));
            $message->setSex($this->getRequestParameter('sex'));
            $message->setLookingFor($this->getRequestParameter('looking_for'));
            $message->setSubject($this->getRequestParameter('subject'));
            $message->setBody($this->getRequestParameter('message_body'));
            $message->save();
            
            $this->setFlash('msg_ok', 'New predefined message has been added.');
            $this->redirect('predefinedMessages/list');
        }
    }

    public function handleErrorCreate()
    {
        $this->preExecute();
                
        return sfView::SUCCESS;
    }
    
    public function executeEdit()
    {
        $message = PredefinedMessagePeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($message);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            
            $message->setCatalogId($this->getRequestParameter('catalog_id'));
            $message->setSex($this->getRequestParameter('sex'));
            $message->setLookingFor($this->getRequestParameter('looking_for'));
            $message->setSubject($this->getRequestParameter('subject'));
            $message->setBody($this->getRequestParameter('message_body'));
            $message->save();
            
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('predefinedMessages/list');
        }
        
        $this->message = $message;
    }
    
    public function handleErrorEdit()
    {
        $this->preExecute();
        
        $this->message = PredefinedMessagePeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($this->message);
                
        return sfView::SUCCESS;
    }
    
    public function executeDelete()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        $marked = $this->getRequestParameter('marked', false);
        
        if (is_array($marked) && ! empty($marked))
        {
            $c = new Criteria();
            $c->add(PredefinedMessagePeer::ID, $marked, Criteria::IN);
            PredefinedMessagePeer::doDelete($c);
        }
        
        $this->setFlash('msg_ok', 'Selected messages has been deleted.');
        return $this->redirect('predefinedMessages/list');
    }    
}
