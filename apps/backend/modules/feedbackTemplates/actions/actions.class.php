<?php

/**
 * feedbackTemplates actions.
 *
 * @package    PolishRomance
 * @subpackage feedbackTemplates
 * @author     Dincho Todorov <dincho
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class feedbackTemplatesActions extends sfActions
{

    public function preExecute()
    {
        if ($this->getRequestParameter('cancel') == 1)
        {
            $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved');
            $this->redirect($this->getModuleName() . '/' . $this->getActionName() . '?id=' . $this->getRequestParameter('id'));
        }
        
        $this->left_menu_selected = 'Templates';
        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'Templates', 'uri' => 'feedbackTemplates/list'));
        
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/feedbackTemplates/filters');
    }

    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');

            $this->getUser()->getAttributeHolder()->removeNamespace('backend/feedbackTemplates/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/feedbackTemplates/filters');
        }
    }


    public function executeList()
    {
        $c = new Criteria();
        $this->addFiltersCriteria($c);
        $this->templates = FeedbackTemplatePeer::doSelect($c);
    }

    public function executeCreate()
    {
        $this->getUser()->getBC()->add(array('name' => 'New Message Template to Users', 'uri' => 'feedbackTemplates/create'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('feedback_edit'));
            $template = new FeedbackTemplate();
            $template->setName($this->getRequestParameter('name'));
            $template->setMailFrom($this->getRequestParameter('mail_from'));
            $template->setReplyTo($this->getRequestParameter('reply_to'));
            $template->setBcc($this->getRequestParameter('bcc'));
            $template->setSubject($this->getRequestParameter('subject'));
            $template->setBody($this->getRequestParameter('message_body'));
            $template->setFooter($this->getRequestParameter('message_footer'));
            $tags = array_filter(array_map('trim', explode(",", $this->getRequestParameter('tags')))); //clear junk
            $template->setTags(implode(',', $tags));
            $template->save();
            
            $this->setFlash('msg_ok', 'Template ' . $template->getName() . ' has been added.');
            $this->redirect('feedbackTemplates/list');
        }
    }

    public function executeEdit()
    {
        $template = FeedbackTemplatePeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($template);
        $this->template = $template;
        
        $this->getUser()->getBC()->add(array('name' => 'Edit', 'uri' => 'feedbackTemplates/edit?id=' . $template->getId()));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('feedback_edit'));
            $template->setName($this->getRequestParameter('name'));
            $template->setMailFrom($this->getRequestParameter('mail_from'));
            $template->setReplyTo($this->getRequestParameter('reply_to'));
            $template->setBcc($this->getRequestParameter('bcc'));
            $template->setSubject($this->getRequestParameter('subject'));
            $template->setBody($this->getRequestParameter('body'));
            $template->setFooter($this->getRequestParameter('footer'));
            $tags = array_filter(array_map('trim', explode(",", $this->getRequestParameter('tags')))); //clear junk
            $template->setTags(implode(',', $tags));
            $template->save();
            
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('feedbackTemplates/list');
        }
    }

    public function executeDelete()
    {
        $this->getUser()->checkPerm(array('feedback_edit'));
        $marked = $this->getRequestParameter('marked', false);
        
        if (is_array($marked) && ! empty($marked))
        {
            $c = new Criteria();
            $c->add(FeedbackTemplatePeer::ID, $marked, Criteria::IN);
            FeedbackTemplatePeer::doDelete($c);
        }
        
        $this->setFlash('msg_ok', 'Selected templates has been deleted.');
        return $this->redirect('feedbackTemplates/list');
    }

    protected function addFiltersCriteria(Criteria $c)
    {
        if (isset($this->filters['tags']) && strlen($this->filters['tags']) > 0) {
            $c->add(FeedbackTemplatePeer::TAGS, '%' . $this->filters['tags'] . '%', Criteria::LIKE);
        }
    }
}
