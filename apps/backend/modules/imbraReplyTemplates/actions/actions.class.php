<?php

/**
 * imbraReplyTemplates actions.
 *
 * @package    pr
 * @subpackage imbraReplyTemplates
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class imbraReplyTemplatesActions extends sfActions
{
  public function preExecute()
  {
    if ($this->getRequestParameter('cancel') == 1)
    {
      $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved');
      $this->redirect($this->getModuleName().'/'.$this->getActionName().'?id=' . $this->getRequestParameter('id'));
    }

    $this->left_menu_selected = 'Reply Templates';
    $bc = $this->getUser()->getBC();
    $bc->clear()->add(array('name' => 'IMBRA', 'uri' => 'imbra/list'))->add(array('name' => 'Reply Templates', 'uri' => 'imbraReplyTemplates/list'));
  }

  public function executeList()
  {
    $this->imbra_reply_templates = ImbraReplyTemplatePeer::doSelect(new Criteria());
  }

  public function executeCreate()
  {
  	$this->getUser()->getBC()->add(array('name' => 'New Template', 'uri' => 'imbraReplyTemplates/create'));
  	
    if( $this->getRequest()->getMethod() == sfRequest::POST )
    {
      $imbra_reply_template = new ImbraReplyTemplate();
      $imbra_reply_template->setTitle($this->getRequestParameter('title'));
      $imbra_reply_template->setSubject($this->getRequestParameter('subject'));
      $imbra_reply_template->setBody($this->getRequestParameter('body'));
      $imbra_reply_template->setMailFrom($this->getRequestParameter('mail_from'));
      $imbra_reply_template->setReplyTo($this->getRequestParameter('reply_to'));
      $imbra_reply_template->setBcc($this->getRequestParameter('bcc'));
  
      $imbra_reply_template->save();
      
      $this->setFlash('msg_ok', 'Template ' . $imbra_reply_template->getTitle() . ' has been added.');
      $this->redirect('imbraReplyTemplates/list');
    }
  }

  public function executeEdit()
  {
    $imbra_reply_template = ImbraReplyTemplatePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($imbra_reply_template);
    $this->imbra_reply_template = $imbra_reply_template;
    
    $this->getUser()->getBC()->add(array('name' => 'Edit', 'uri' => 'imbraReplyTemplates/edit?id=' . $imbra_reply_template->getId()));
    
    if( $this->getRequest()->getMethod() == sfRequest::POST )
    {
        $this->getUser()->checkPerm(array('imbra_edit'));
	    $imbra_reply_template->setTitle($this->getRequestParameter('title'));
	    $imbra_reply_template->setSubject($this->getRequestParameter('subject'));
	    $imbra_reply_template->setBody($this->getRequestParameter('body'));
	    $imbra_reply_template->setMailFrom($this->getRequestParameter('mail_from'));
	    $imbra_reply_template->setReplyTo($this->getRequestParameter('reply_to'));
	    $imbra_reply_template->setBcc($this->getRequestParameter('bcc'));
	
	    $imbra_reply_template->save();
	    
	    $this->setFlash('msg_ok', 'Your changes has been saved.');
	    $this->redirect('imbraReplyTemplates/list');
    }
  }

  public function executeDelete()
  {
    $marked = $this->getRequestParameter('marked', false);
    
    if( is_array($marked) && !empty($marked) )
    {
      $c = new Criteria();
      $c->add(ImbraReplyTemplatePeer::ID, $marked, Criteria::IN);
      ImbraReplyTemplatePeer::doDelete($c);
    }

    $this->setFlash('msg_ok', 'Selected templates has been deleted.');
    return $this->redirect('imbraReplyTemplates/list');
  }
}
