<?php
class messagesActions extends prActions
{
    public function preExecute()
    {
        $bc = $this->getUser()->getBC();
        $bc->addFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
    }
    
    public function executeIndex()
    {
        $this->getResponse()->addJavascript('show_hide_tick');
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->add(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENT_BOX, false);
        $this->received_messages = MessagePeer::doSelectJoinMemberRelatedByFromMemberId($c);
        
        $cc = clone $c;
        $cc->add(MessagePeer::IS_READ, false);
        $this->cnt_unread = MessagePeer::doCount($cc);
        
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->add(MessagePeer::FROM_MEMBER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENT_BOX, true);
        $this->sent_messages = MessagePeer::doSelectJoinMemberRelatedByToMemberId($c);
        
        //message deletion confirmation
        if( $this->getRequestParameter('confirm_delete') && count($this->getRequestParameter('selected', array())) > 0)
        {
            $del_msg = 'Are you sure you want to delete selected message(s)? <a href="javascript:window.history.go(-1);" class="sec_link">No</a>&nbsp;';
            $del_msg .= '<a href="javascript:document.getElementById(\''. $this->getRequestParameter('form_id').'\').submit()" class="sec_link">Yes</a>';
            //$del_msg = $this->getContext()->getI18N()->__($del_msg, array('%YES_LINK%' => $del_msg_yes));
            $this->setFlash('msg_error', $del_msg, false);
        }
        
    }
    
    public function executeView()
    {
        $message = MessagePeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($message);
        $this->forward404Unless( ($message->getSentBox() && $message->getFromMemberId() == $this->getUser()->getId()) || 
                                 (!$message->getSentBox() && $message->getToMemberId() == $this->getUser()->getId()));
        
        if( !$message->getSentBox() && !$message->getIsSystem() &&
            $message->getMemberRelatedByFromMemberId()->getSubscriptionId() == SubscriptionPeer::FREE &&
            $this->getUser()->getProfile()->getSubscriptionId() == SubscriptionPeer::FREE )
            {
                $this->message('upgrade_to_read_message');
            }
            
        $this->getUser()->getBC()->removeLast()->add(array('name' => $message->getSubject(), 'uri' => 'messages/view?id=' . $message->getId()));
        
        if ( !$message->getIsRead() ) //mark as read
        {
            $msg = clone $message;
            $msg->setIsRead(true);
            $msg->save();
            
            $this->getUser()->getProfile()->incCounter('ReadMessages');
        }
        
        $this->message = $message;
    }
    
    public function validateView()
    {
        $message = MessagePeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($message);
        if( !$message->getIsRead() && !$message->getSentBox() && !$message->getIsSystem())
        {
            $subscription = $this->getUser()->getProfile()->getSubscription();
            if( !$subscription->getCanReadMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->setFlash('msg_error', 'In order to read a message you need to upgrade your membership.');
                } else {
                    $this->setFlash('msg_error', 'Paid: In order to read a message you need to upgrade your membership.');
                }
                $this->redirect('messages/index');
            }
            
            if( $this->getUser()->getProfile()->getCounter('ReadMessages') >= $subscription->getReadMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->setFlash('msg_error', 'For the feature that you want want to use - read a message - you have reached the limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
                } else {
                    $this->setFlash('msg_error', 'Paid: For the feature that you want want to use - read a message - you have reached the limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
                }
                $this->redirect('messages/index');  
            }
        }
        
        return true;
    }
    
    public function executeReply()
    {
        $c = new Criteria();
        $c->add(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENT_BOX, false);
        $c->add(MessagePeer::ID, $this->getRequestParameter('id'));
        $c->add(MessagePeer::IS_REPLIED, false);
        $c->add(MessagePeer::IS_SYSTEM, false);
        $message = MessagePeer::doSelectOne($c);
        $this->forward404Unless($message);
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $send_msg = $message->reply($this->getRequestParameter('subject'), $this->getRequestParameter('content'));
            $this->sendConfirmation($send_msg->getId());
        }
        
        $this->message = $message;
    }
    
    public function validateReply()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $message = MessagePeer::retrieveByPK($this->getRequestParameter('id'));
            $this->forward404Unless($message);
            
            $profile = $message->getMemberRelatedByFromMemberId();
            //1. is the other member active ?
            if ( $profile->getmemberStatusId() != MemberStatusPeer::ACTIVE )
            {
                $this->getRequest()->setError('message', 'The member that you want to send a message to is not active.');
                return false;
            }
            
            //2. has blocked this member ?
            if ( $profile->hasBlockFor($this->getUser()->getId()) )
            {
                $this->getRequest()->setError('message', 'You can not send message to this member!');
                return false;
            }

            //3. subscription limits/restrictions ?
            $subscription = $this->getUser()->getProfile()->getSubscription();
            if( !$subscription->getCanReplyMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'In order to reply to message you need to upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: In order to reply to message you need to upgrade your membership.');
                }
                return false;
            }
            
            if( $this->getUser()->getProfile()->getCounter('ReplyMessages') >= $subscription->getReplyMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'For the feature that you want want to use - reply to message - you have reached the limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: For the feature that you want want to use - reply to message - you have reached the limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
                }
                return false;
            }
            
            if( $this->getRequestParameter('tos', 0) != 1 && !$this->getUser()->getProfile()->getLastImbra(true) && $profile->getLastImbra(true) )
            {
                $this->getRequest()->setError('message', 'The box has to be checked in order for non-IMBRA user to send a message to IMBRA approved user.');
                return false;                
            }            
        }
        return true;
    }
    
    public function handleErrorReply()
    {
        $c = new Criteria();
        $c->add(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENT_BOX, false);
        $c->add(MessagePeer::ID, $this->getRequestParameter('id'));
        $this->message = MessagePeer::doSelectOne($c);
        $this->forward404Unless($this->message);
                
        return sfView::SUCCESS;
    }
    
    public function executeSend()
    {
        $this->profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($this->profile);
        $this->member = $this->getUser()->getProfile();
            
        if( $this->getUser()->getId() == $this->profile->getId() )
        {
            $this->setFlash('msg_error', 'You can\'t use this function on your own profile');
            $this->redirect('profile/index?username=' . $this->profile->getUsername() );
        }
                
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $send_msg = MessagePeer::send($this->getUser()->getProfile(), $this->profile, 
                            $this->getRequestParameter('subject'), $this->getRequestParameter('content'));
        	
            $this->sendConfirmation($send_msg->getId());
        }
    }

    public function validateSend()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
            $this->forward404Unless($profile);
            $member = $this->getUser()->getProfile();
            
            //1. is the other member active ?
            if ( $profile->getmemberStatusId() != MemberStatusPeer::ACTIVE )
            {
                $this->getRequest()->setError('message', 'The member that you want to send a message to is not active.');
                return false;
            }
            
            //2. has blocked this member ?
            if ( $profile->hasBlockFor($member->getId()) )
            {
                $this->getRequest()->setError('message', 'You can not send message to this member!');
                return false;
            }
            
            //3. wants to receive messages only from paid members ?
            if ( $member->getSubscriptionId() == SubscriptionPeer::FREE && $profile->getContactOnlyFullMembers() )
            {
                $this->getRequest()->setError('message', 'This member accept messages only from paid members!');
                return false;
            }
            
            //4. subscription limits/restrictions ?
            $subscription = $member->getSubscription();
            if( !$subscription->getCanSendMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'In order to send message you need to upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: In order to send message you need to upgrade your membership.');
                }
                return false;
            }
            
            if( $member->getCounter('SentMessages') >= $subscription->getSendMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'For the feature that you want want to use - send message - you have reached the limit up to which you can use it with your membership. In order to send message, please upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: For the feature that you want want to use - send message - you have reached the limit up to which you can use it with your membership. In order to send message, please upgrade your membership.');
                }
                return false;
            }
            
            if( $this->getRequestParameter('tos', 0) != 1 && !$member->getLastImbra(true) && $profile->getLastImbra(true) )
            {
                $this->getRequest()->setError('message', 'The box has to be checked in order for non-IMBRA user to send a message to IMBRA approved user. ');
                return false;                
            }
                        
        }
        return true;        
    }
    
    public function handleErrorSend()
    {
        $this->profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($this->profile);
        $this->member = $this->getUser()->getProfile();
                
        return sfView::SUCCESS;
    }
    
    protected function sendConfirmation($send_msg_id)
    {
        sfLoader::loadHelpers(array('Tag', 'Url'));
        $view_msg_url = link_to(sfI18N::getInstance()->__('View sent message.'), 'messages/view?id=' . $send_msg_id, array('class' => 'sec_link'));
        $this->setFlash('msg_ok', sfI18N::getInstance()->__('Your message has been sent. ') . $view_msg_url);
        $this->redirect('messages/index');
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
        
        $this->setFlash('msg_ok', 'Selected message(s) has been deleted.');
        $this->redirect('messages/index');        
    }
}
