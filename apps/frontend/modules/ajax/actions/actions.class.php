<?php

/**
 * ajax actions.
 *
 * @package    pr
 * @subpackage ajax
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class ajaxActions extends geoActions
{
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
        $c = new Criteria();
        $c->add(MessageDraftPeer::ID, $this->getRequestParameter('draft_id'));
        $c->add(MessageDraftPeer::FROM_MEMBER_ID, $this->getUser()->getId());
        $draft = MessageDraftPeer::doSelectOne($c);
        
        if ( $draft )
        {
	        $draft->setSubject($this->getRequestParameter('subject'));
	        $draft->setContent($this->getRequestParameter('content'));
	        $draft->save();
        }
        
        return sfView::NONE;
    }
}
