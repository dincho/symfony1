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
        $this->top_menu_selected = 'staticPages';
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
            if( is_array($req_states) && !empty($req_states) )
            {
                foreach ($req_states as $req_state_id => $req_state_title )
                {
                    if( array_key_exists($req_state_id, $states) )
                    {
                        $states[$req_state_id]->setTitle($req_state_title);
                        $states[$req_state_id]->save();
                    } else {
                        $new_state = new State();
                        $new_state->setTitle($req_state_title);
                        $new_state->setCountry($country);
                        $new_state->save();
                    }
                }
            }
            
            $this->redirect('areas/edit?country='. $country .'&confirm_msg=' . confirmMessageFilter::OK);
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
}
