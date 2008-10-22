<?php
class messagesActions extends sfActions
{
    public function preExecute()
    {
        $bc = $this->getUser()->getBC();
        $bc->addFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
    }
    
    public function executeIndex()
    {
        $this->getResponse()->addJavascript('show_hide_messages');
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->add(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENT_BOX, false);
        $this->received_messages = MessagePeer::doSelectJoinMemberRelatedByFromMemberId($c);
        
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->add(MessagePeer::FROM_MEMBER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENT_BOX, true);
        $this->sent_messages = MessagePeer::doSelectJoinMemberRelatedByToMemberId($c);
        
    }
    
    public function executeView()
    {
        $message = MessagePeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($message);
        $this->forward404Unless( ($message->getSentBox() && $message->getFromMemberId() == $this->getUser()->getId()) || 
                                 (!$message->getSentBox() && $message->getToMemberId() == $this->getUser()->getId()));
        
        if( !$message->getSentBox() &&
            $message->getMemberRelatedByFromMemberId()->getSubscriptionId() == SubscriptionPeer::FREE &&
            $this->getUser()->getProfile()->getSubscriptionId() == SubscriptionPeer::FREE )
            {
                $this->setFlash('s_title', 'Please upgrade to read this message');
                $this->redirect('content/message');
            }
            
        $this->getUser()->getBC()->removeLast()->add(array('name' => $message->getSubject(), 'uri' => 'messages/view?id=' . $message->getId()));
        $this->header_title = 'Messages';
        
        if ( !$message->getIsRead() ) //mark as read
        {
            $msg = clone $message;
            $msg->setIsRead(true);
            $msg->save();
        }
        
        $this->message = $message;
    }
    
    public function executeReply()
    {
        $c = new Criteria();
        $c->add(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENT_BOX, false);
        $c->add(MessagePeer::ID, $this->getRequestParameter('id'));
        $message = MessagePeer::doSelectOne($c);
        $this->forward404Unless($message);
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $send_msg_id = MessagePeer::send($this->getUser()->getId(), $message->getFromMemberId(), 
                            $this->getRequestParameter('subject'), $this->getRequestParameter('content'));
            
            sfLoader::loadHelpers(array('Tag', 'Url'));
            $view_msg_url = link_to(sfI18N::getInstance()->__('View sent message.'), 'messages/view?id=' . $send_msg_id, array('class' => 'sec_link'));
            $this->setFlash('msg_ok', sfI18N::getInstance()->__('Your message has been sent. ') . $view_msg_url);
            $this->redirect('@messages');
        }
    }
    
    public function executeSend()
    {
        $this->profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($this->profile);
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $send_msg_id = MessagePeer::send($this->getUser()->getId(), $this->getRequestParameter('profile_id'), 
                            $this->getRequestParameter('subject'), $this->getRequestParameter('content'));
        	
                            
            if( $this->getRequestParameter('reply') )
            {
                  $this->getUser()->getProfile()->incCounter('ReplyMessages');              
            }
            
            sfLoader::loadHelpers(array('Tag', 'Url'));
            $view_msg_url = link_to(sfI18N::getInstance()->__('View sent message.'), 'messages/view?id=' . $send_msg_id, array('class' => 'sec_link'));
        	$this->setFlash('msg_ok', sfI18N::getInstance()->__('Your message has been sent. ') . $view_msg_url);
        	$this->redirect('@messages');
        }
    }
    
    public function validateSend()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
            $this->forward404Unless($profile);
        
            if ( !$this->getUser()->getProfile()->canSendMessageTo($profile) )
            {
                $this->getRequest()->setError('message', 'You can not send message to this member!');
                return false;
            }
        }
        return true;        
    }
    
    public function handleErrorSend()
    {
        $this->profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($this->profile);
                
        return sfView::SUCCESS;
    }
    
    public function executeDelete()
    {
        $marked = $this->getRequestParameter('selected', array());
        if ( !empty($marked) )
        {
            //perm delete trashed emails
            $c = new Criteria();
            $c->add(MessagePeer::ID, $marked, Criteria::IN);
            $crit = $c->getNewCriterion(MessagePeer::FROM_MEMBER_ID, $this->getUser()->getId());
            $crit->addOr($c->getNewCriterion(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId()));
            $c->add($crit);
            MessagePeer::doDelete($c);
        }
        
        $this->setFlash('msg_ok', 'Selected messages has been deleted.');
        $this->redirect('messages/index');        
    }
}
