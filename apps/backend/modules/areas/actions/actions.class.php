<?php
/**
 * areas actions.
 *
 * @package    pr
 * @subpackage areas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class areasActions extends sfActions
{

    public function preExecute()
    {
        $this->getUser()->getBC()->addFirst(array('name' => 'content', 'uri' => 'content/list'));
        $this->top_menu_selected = 'content';
        $this->left_menu_selected = 'Areas';
    }

    public function executeList()
    {
        $this->forward('areas', 'edit');
    }

    public function executeEdit()
    {
        $country = $this->getRequestParameter('country', 'US');
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            $req_states = $this->getRequestParameter('states');
            $states = StatePeer::getAssocByCountry($country);
            if (is_array($req_states) && ! empty($req_states))
            {
                foreach ($req_states as $req_state_id => $req_state_title)
                {
                    if (array_key_exists($req_state_id, $states))
                    {
                        $states[$req_state_id]->setTitle($req_state_title);
                        $states[$req_state_id]->save();
                    } else
                    {
                        $new_state = new State();
                        $new_state->setTitle($req_state_title);
                        $new_state->setCountry($country);
                        $new_state->save();
                    }
                }
            }
            
            $this->redirect('areas/edit?country=' . $country . '&confirm_msg=' . confirmMessageFilter::OK);
        }
        
        $this->states = StatePeer::getAllByCountry($country);
        $this->country = $country;
    }

    public function handleErrorEdit()
    {
        $this->states = StatePeer::getAllByCountry($this->getRequestParameter('country', 'US'));
        $this->country = $this->getRequestParameter('country', 'US');
        return sfView::SUCCESS;
    }

    public function executeInfo()
    {
        $state = StatePeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($state);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $state->setInfo($this->getRequestParameter('info'));
            $state->save();
            
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('areas/edit?country=' . $state->getCountry());
        }
        
        $this->state = $state;
    }

    public function executeUploadPhoto()
    {
        $state = StatePeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($state);
        $this->forward404Unless($this->getRequest()->getMethod() == sfRequest::POST);
        
        if ($this->getRequest()->getFileSize('new_photo'))
        {
            $photo = new StatePhoto();
            $photo->setStateId($state->getId());
            $photo->updateImageFromRequest('file', 'new_photo');
            $photo->save();
            
            $this->setFlash('msg_ok', 'New photo has been uploaded');
        }
        
        $this->redirect('areas/info?id=' . $state->getId());
    }
    
    public function executeDeletePhoto()
    {
        $photo = StatePhotoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($photo);
        
        $photo->delete();
        
        $this->setFlash('msg_ok', 'Selected photo has been deleted');
        $this->redirect('areas/info?id=' . $photo->getStateId());
    }
}
