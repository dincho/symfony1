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
        
        $i18n = sfContext::getInstance()->getI18n();
        if( !preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username) )
        {
            $this->error_msg = $i18n->__('Allowed characters for username are [a-zA-Z][0-9] and underscore, min 4 chars max 20.', array('%USERNAME%' => $username));
            return sfView::SUCCESS; //only one error at once
        }
        
        $member = MemberPeer::retrieveByUsername($username);
        if( $member )
        {
            $this->error_msg = $i18n->__('Sorry, username "%USERNAME%" is already taken.', array('%USERNAME%' => $username));
            return sfView::SUCCESS;  //only one error at once
        }
        
        //if not returned by previews checks, all looks OK
        $this->ok_msg = $i18n->__('Congratulations, your username "%USERNAME%" is available.', array('%USERNAME%' => $username));
    }
    
    public function executeSaveToDraft()
    {
        $c = new Criteria();
        $c->add(MessagePeer::ID, $this->getRequestParameter('draft_id'));
        $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT);
        $c->add(MessagePeer::SENDER_DELETED_AT, null, Criteria::ISNULL);
        $draft = MessagePeer::doSelectOne($c);
        
        if ( $draft )
        {
            $draft->setSubject($this->getRequestParameter('subject'));
            $draft->setBody($this->getRequestParameter('content'));
            $draft->save();
            
            return $this->renderText(__('Draft saved at %TIME%', array('%TIME%' => date('h:i a'))));
        }
        
        return sfView::NONE;
    }
}
