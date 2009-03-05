<?php

/**
 * ajax actions.
 *
 * @package    pr
 * @subpackage ajax
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class ajaxActions extends prActions
{

    public function executeGetStatesByCountry()
    {
        if ($country = $this->getRequestParameter('country'))
        {
            $states = StatePeer::getAllByCountry($country);
            
            $states_tmp = array();
            foreach ($states as $state)
            {
                $tmp['id'] = $state->getId();
                $tmp['title'] = $state->getTitle();
                $states_tmp[] = $tmp;
            }
            
            $output = json_encode($states_tmp);
            $this->getResponse()->setHttpHeader("X-JSON", '(' . $output . ')');
        }
        return sfView::HEADER_ONLY;
    }

    public function executeUsernameExists()
    {
        $username = $this->getRequestParameter('username');
        if( $username )
        {
            if( !preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username) )
            {
                $this->error_msg = 'Allowed characters for username are [a-zA-Z][0-9] and underscore, min 4 chars max 20.';
            } else {
                $member = MemberPeer::retrieveByUsername($username);
                if( $member ) $this->error_msg = 'Sorry, username "%USERNAME%" is already taken.';                
            }
            
            $this->username = $username;
        } else {
            return sfView::NONE;
        }
    }
    
    public function executeSaveToDraft()
    {
        $subject = $this->getRequestParameter('subject');
        $content = $this->getRequestParameter('content');
        $draft_id = $this->getRequestParameter('draft_id');
        $message = MessageDraftPeer::retrieveByPK($draft_id);
        $message->setSubject($subject);
        $message->setContent($content);
        $message->save();
        
        return sfView::NONE;
    }
}
