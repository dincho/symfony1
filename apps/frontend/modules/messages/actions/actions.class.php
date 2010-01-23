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
        $c->add(MessagePeer::RECIPIENT_ID, $this->getUser()->getId());
        $c->add(MessagePeer::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        $cc = clone $c;
        
        $c->addGroupByColumn(ThreadPeer::ID);
        $c->addJoin(ThreadPeer::ID, MessagePeer::THREAD_ID);
        $c->addJoin(MessagePeer::SENDER_ID, MemberPeer::ID);
        $c->addDescendingOrderByColumn(ThreadPeer::UPDATED_AT);
        $this->threads_received = ThreadPeer::doSelectHydrateObject($c);
        
        $cc->add(MessagePeer::UNREAD, true);
        $cc->addGroupByColumn(MessagePeer::THREAD_ID);
        $rs = MessagePeer::doSelectRS($cc);
        $this->cnt_unread = $rs->getRecordCount();
        
        $c = new Criteria();
        $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENDER_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->addJoin(ThreadPeer::ID, MessagePeer::THREAD_ID);
        $c->addGroupByColumn(ThreadPeer::ID);
        $c->addDescendingOrderByColumn(ThreadPeer::UPDATED_AT);
        $c->addJoin(MessagePeer::RECIPIENT_ID, MemberPeer::ID);
        $this->sent_threads = ThreadPeer::doSelectHydrateObject($c);
        
        $c1 = new Criteria();
        $c1->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
        $c1->add(MessagePeer::SENDER_DELETED_AT, null, Criteria::ISNULL);
        $c1->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT);
        $c1->addDescendingOrderByColumn(MessagePeer::UPDATED_AT);
        
        $crit = $c1->getNewCriterion(MessagePeer::SUBJECT, '', Criteria::NOT_EQUAL);
        $crit->addOr($c1->getNewCriterion(MessagePeer::BODY, '', Criteria::NOT_EQUAL));
        $c1->add($crit);
        $this->draft_messages = MessagePeer::doSelectJoinMemberRelatedByRecipientId($c1);
        
        //message deletion confirmation
        if( ($this->getRequestParameter('confirm_delete') || $this->getRequestParameter('confirm_delete_draft')) && count($this->getRequestParameter('selected', array())) > 0 )
        {
            $i18n = $this->getContext()->getI18N();
            $i18n_options = array('%URL_FOR_CANCEL%' => 'javascript:window.history.go(-1);', 
                                  '%URL_FOR_CONFIRM%' => 'javascript:document.getElementById(\''. $this->getRequestParameter('form_id').'\').submit()');
            $del_msg = $i18n->__('Are you sure you want to delete selected message(s)? <a href="%URL_FOR_CANCEL%" class="sec_link">No</a> <a href="%URL_FOR_CONFIRM%" class="sec_link">Yes</a>', $i18n_options);
            $this->setFlash('msg_error', $del_msg, false);            
        }        
    }
    
    public function validateIndex()
    {
      if( $this->getRequest()->getMethod() == sfRequest::POST && 
          ($this->getRequestParameter('confirm_delete') || $this->getRequestParameter('confirm_delete_draft')) )
      {
        $selected = $this->getRequestParameter('selected', array());
        
        if( empty($selected) )
        {
          $this->setFlash('msg_error', 'You must select at least one message to delete', false);
          $this->redirect('messages/index');
        }
      }
      
      return true;
    }

    
    // public function executeView()
    // {
    //     $message = MessagePeer::retrieveByPK($this->getRequestParameter('id'));
    //     $this->forward404Unless($message);
    //     $this->forward404Unless( ($message->getSentBox() && $message->getFromMemberId() == $this->getUser()->getId()) || 
    //                              (!$message->getSentBox() && $message->getToMemberId() == $this->getUser()->getId()));
    //     
    //     if( !$message->getSentBox() && !$message->getIsSystem() &&
    //         $message->getMemberRelatedByFromMemberId()->isSubscriptionFree() &&
    //         !$message->getMemberRelatedByFromMemberId()->getSubscription()->getCanSendMessages() &&
    //         $this->getUser()->getProfile()->isSubscriptionFree() )
    //         {
    //             $this->message('upgrade_to_read_message');
    //         }
    //         
    //     $this->getUser()->getBC()->removeLast()->add(array('name' => $message->getSubject(), 'uri' => 'messages/view?id=' . $message->getId()));
    //     
    //     if ( !$message->getIsRead() ) //mark as read
    //     {
    //         $msg = clone $message;
    //         $msg->setIsRead(true);
    //         $msg->save();
    //         
    //         $this->getUser()->getProfile()->incCounter('ReadMessages');
    //         $this->getUser()->getProfile()->incCounter('ReadMessagesDay');
    //     }
    //     
    // 
    //   $member = ( $message->getSentBox() ) ? $message->getMemberRelatedByToMemberId() : $from_member = $message->getMemberRelatedByFromMemberId();
    //   if( !$member->isActive() ) 
    //     $this->setFlash('msg_error', sfI18N::getInstance()->__('%USERNAME%\'s Profile is not longer available', array('%USERNAME%' => $member->getUsername())), false);
    //     
    //   $this->message = $message;
    // }
    
    // public function validateView()
    // {
    //     $message = MessagePeer::retrieveByPK($this->getRequestParameter('id'));
    //     $this->forward404Unless($message);
    //     
    //     if( !$message->getIsRead() && !$message->getSentBox() && !$message->getIsSystem())
    //     {
    //         $subscription = $this->getUser()->getProfile()->getSubscription();
    //         
    //         if( !$subscription->getCanReadMessages() )
    //         {
    //             if( $subscription->getId() == SubscriptionPeer::FREE )
    //             {
    //                 $this->setFlash('msg_error', 'In order to read a message you need to upgrade your membership.');
    //             } else {
    //                 $this->setFlash('msg_error', 'Paid: In order to read a message you need to upgrade your membership.');
    //             }
    //             $this->redirect('messages/index');
    //         } elseif ( $subscription->getId() == SubscriptionPeer::FREE && 
    //                    $message->getMemberRelatedByFromMemberId()->isSubscriptionFree() &&
    //                    !$message->getMemberRelatedByFromMemberId()->getSubscription()->getCanSendMessages())
    //         {
    //             //received by FREE member with send messages OFF
    //             $this->setFlash('msg_error', 'Sender of the message is not a paid member. At least one of you must be a paid member for either send or receive messages.');
    //             $this->redirect('messages/index');
    //         }
    //         
    //         if( $this->getUser()->getProfile()->getCounter('ReadMessagesDay') >= $subscription->getReadMessagesDay() )
    //         {
    //             if( $subscription->getId() == SubscriptionPeer::FREE )
    //             {
    //                 $this->setFlash('msg_error', 'For the feature that you want to use - read a message - you have reached the daily limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
    //             } else {
    //                 $this->setFlash('msg_error', 'Paid: For the feature that you want to use - read a message - you have reached the daily limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
    //             }
    //             $this->redirect('messages/index');  
    //         }
    //         
    //         if( $this->getUser()->getProfile()->getCounter('ReadMessages') >= $subscription->getReadMessages() )
    //         {
    //             if( $subscription->getId() == SubscriptionPeer::FREE )
    //             {
    //                 $this->setFlash('msg_error', 'For the feature that you want to use - read a message - you have reached the limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
    //             } else {
    //                 $this->setFlash('msg_error', 'Paid: For the feature that you want to use - read a message - you have reached the limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
    //             }
    //             $this->redirect('messages/index');  
    //         }
    //         
    //     }
    //     
    //     return true;
    // }
    
    // public function executeReply()
    // {
    //     $c = new Criteria();
    //     $c->add(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId());
    //     $c->add(MessagePeer::SENT_BOX, false);
    //     $c->add(MessagePeer::ID, $this->getRequestParameter('id'));
    //     $c->add(MessagePeer::IS_SYSTEM, false);
    //     $message = MessagePeer::doSelectOne($c);
    //     $this->forward404Unless($message);
    //     
    //     $draft_id = $this->getRequestParameter('draft_id');
    //     if ( $message->getIsReplied() ) //message is already replied
    //     {
    //        //but this is draft
    //       if( $draft_id && $draft = MessageDraftPeer::retrieveByPK($draft_id) )
    //       {
    //         $this->redirect('messages/send?draft_id=' . $draft->getId() . '&profile_id=' . $draft->getToMemberId());
    //       }
    //       
    //       $this->forward404(); //if replied but not draft
    //     }
    //     
    //     if( $this->getRequest()->getMethod() == sfRequest::POST )
    //     {
    //         $send_msg = $message->reply($this->getRequestParameter('subject'), 
    //                                     $this->getRequestParameter('content'), 
    //                                     $this->getRequestParameter('draft_id'));
    //         $this->sendConfirmation($send_msg->getId(), $message->getMemberRelatedByFromMemberId()->getUsername());
    //     }
    //     
    //     $i18n = sfI18N::getInstance();
    //     $i18n->setCulture('en');
    //     $reply_body_template = $i18n->__('Reply Message Body Template');
    //     $subject = (preg_match('/^Re:.*$/', $message->getSubject())) ? $message->getSubject() : 'Re: ' . $message->getSubject();
    //     
    //     $this->draft = MessageDraftPeer::retrieveOrCreate($draft_id,
    //                                                       $message->getToMemberId(),
    //                                                       $message->getFromMemberId(),
    //                                                       $message->getId(),
    //                                                       $subject,
    //                                                       $message->getBodyForReply($reply_body_template)
    //                                                       );
    //     $this->message = $message;
    // }
    // 
    // public function validateReply()
    // {
    //         $message = MessagePeer::retrieveByPK($this->getRequestParameter('id'));
    //         $this->forward404Unless($message);
    //         
    //         $profile = $message->getMemberRelatedByFromMemberId();
    //         $member = $this->getUser()->getProfile();
    //         
    //         //1. is the other member active ?
    //         if ( $profile->getmemberStatusId() != MemberStatusPeer::ACTIVE )
    //         {
    //             $this->getRequest()->setError('message', 'The member that you want to send a message to is not active.');
    //             return false;
    //         }
    //         
    //         //2. Privacy
    //         $prPrivavyValidator = new prPrivacyValidator();
    //         $prPrivavyValidator->setProfiles($member, $profile);
    //         $prPrivavyValidator->initialize($this->getContext(), array(
    //           'block_error' => 'You can not send message to this member!',
    //           'sex_error' => 'Due to privacy restrictions you cannot send message to this profile',
    //           'check_onlyfull' => false,
    //         ));
    //         
    //         $error = '';
    //         if( !$prPrivavyValidator->execute(&$value, &$error) )
    //         {
    //             $this->getRequest()->setError('privacy', $error);
    //             return false;
    //         }
    // 
    //         //3. subscription limits/restrictions ?
    //         $subscription = $member->getSubscription();
    //         if( !$subscription->getCanReplyMessages() )
    //         {
    //             if( $subscription->getId() == SubscriptionPeer::FREE )
    //             {
    //                 $this->getRequest()->setError('subscription', 'In order to reply to message you need to upgrade your membership.');
    //             } else {
    //                 $this->getRequest()->setError('subscription', 'Paid: In order to reply to message you need to upgrade your membership.');
    //             }
    //             return false;
    //         }
    //         
    //         if( $member->getCounter('ReplyMessagesDay') >= $subscription->getReplyMessagesDay() )
    //         {
    //             if( $subscription->getId() == SubscriptionPeer::FREE )
    //             {
    //                 $this->getRequest()->setError('subscription', 'For the feature that you want to use - reply to message - you have reached the daily limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
    //             } else {
    //                 $this->getRequest()->setError('subscription', 'Paid: For the feature that you want to use - reply to message - you have reached the daily limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
    //             }
    //             return false;
    //         }
    //         
    //         if( $member->getCounter('ReplyMessages') >= $subscription->getReplyMessages() )
    //         {
    //             if( $subscription->getId() == SubscriptionPeer::FREE )
    //             {
    //                 $this->getRequest()->setError('subscription', 'For the feature that you want to use - reply to message - you have reached the limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
    //             } else {
    //                 $this->getRequest()->setError('subscription', 'Paid: For the feature that you want to use - reply to message - you have reached the limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
    //             }
    //             return false;
    //         }
    //         
    //         
    //         if( $this->getRequest()->getMethod() == sfRequest::POST && $this->getRequestParameter('tos', 0) != 1 && !$member->getLastImbra(true) && $profile->getLastImbra(true) )
    //         {
    //             $this->getRequest()->setError('message', 'The box has to be checked in order for non-IMBRA user to send a message to IMBRA approved user.');
    //             return false;                
    //         }            
    //     return true;
    // }
    // 
    // public function handleErrorReply()
    // {
    //     $c = new Criteria();
    //     $c->add(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId());
    //     $c->add(MessagePeer::SENT_BOX, false);
    //     $c->add(MessagePeer::ID, $this->getRequestParameter('id'));
    //     $this->message = MessagePeer::doSelectOne($c);
    //     $this->forward404Unless($this->message);
    // 
    //     $this->draft = MessageDraftPeer::retrieveOrCreate($this->getRequestParameter('draft_id'), 
    //                                                       $this->message->getToMemberId(), 
    //                                                       $this->message->getFromMemberId(), 
    //                                                       $this->message->getId());
    //     
    //     return sfView::SUCCESS;
    // }
    
    public function executeSend()
    {
        $this->recipient = MemberPeer::retrieveByPK($this->getRequestParameter('recipient_id'));
        $this->forward404Unless($this->recipient);
        
        $this->sender = $this->getUser()->getProfile();
            
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {   
            $send_msg = MessagePeer::send($this->sender, $this->recipient, 
                                          $this->getRequestParameter('subject'), 
                                          $this->getRequestParameter('content'),
                                          $this->getRequestParameter('draft_id'));

            $this->sendConfirmation($send_msg);
        }
        
        $this->draft = MessagePeer::retrieveOrCreateDraft($this->getRequestParameter('draft_id'), $this->sender->getId(), $this->recipient->getId() );
    }

    public function validateSend()
    {
            $recipient = MemberPeer::retrieveByPK($this->getRequestParameter('recipient_id'));
            $this->forward404Unless($recipient);
            $sender = $this->getUser()->getProfile();
            
            if( $sender->getId() == $recipient->getId() )
            {
                $this->setFlash('msg_error', 'You can\'t use this function on your own profile');
                $this->redirect('profile/index?username=' . $recipient->getUsername() );
            }
                    
            //1. is the other member active ?
            if ( $recipient->getmemberStatusId() != MemberStatusPeer::ACTIVE )
            {
                $this->getRequest()->setError('message', 'The member that you want to send a message to is not active.');
                return false;
            }
            
            //2. Privacy
            $prPrivavyValidator = new prPrivacyValidator();
            $prPrivavyValidator->setProfiles($sender, $recipient);
            $prPrivavyValidator->initialize($this->getContext(), array(
                'block_error' => 'You can not send message to this member!',
                'sex_error' => 'Due to privacy restrictions you cannot send message to this profile',
                'onlyfull_error' => 'This member accept messages only from paid members!',
            ));

            $error = '';
            if( !$prPrivavyValidator->execute(&$value, &$error) )
            {
                $this->getRequest()->setError('privacy', $error);
                return false;
            }
      
            //3. subscription limits/restrictions ?
            $subscription = $sender->getSubscription();
            if( !$subscription->getCanSendMessages() && $subscription->getId() != SubscriptionPeer::FREE )
            {
                $this->getRequest()->setError('subscription', 'Paid: In order to send message you need to upgrade your membership.');
                return false;
            }
            
            if( $sender->getCounter('SentMessagesDay') >= $subscription->getSendMessagesDay() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'For the feature that you want to use - send message - you have reached the daily limit up to which you can use it with your membership. In order to send message, please upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: For the feature that you want to use - send message - you have reached the daily limit up to which you can use it with your membership. In order to send message, please upgrade your membership.');
                }
                return false;
            }
            
            if( $sender->getCounter('SentMessages') >= $subscription->getSendMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'For the feature that you want to use - send message - you have reached the limit up to which you can use it with your membership. In order to send message, please upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: For the feature that you want to use - send message - you have reached the limit up to which you can use it with your membership. In order to send message, please upgrade your membership.');
                }
                return false;
            }
            
            if( !sfConfig::get('app_settings_imbra_disable') && $this->getRequestParameter('tos', 0) != 1 && !$sender->getLastImbra(true) && $recipient->getLastImbra(true) )
            {
                $this->getRequest()->setError('message', 'The box has to be checked in order for non-IMBRA user to send a message to IMBRA approved user. ');
                return false;                
            }
                        
        return true;        
    }
    
    public function handleErrorSend()
    {
        $this->recipient = MemberPeer::retrieveByPK($this->getRequestParameter('recipient_id'));
        $this->forward404Unless($this->recipient);
        $this->sender = $this->getUser()->getProfile();
        
        $this->draft = MessagePeer::retrieveOrCreateDraft($this->getRequestParameter('draft_id'), $this->sender->getId(), $this->recipient->getId());
        
        return sfView::SUCCESS;
    }
    
    protected function sendConfirmation(BaseMessage $sent_msg)
    {
        $to_username = $sent_msg->getMemberRelatedByRecipientId()->getUsername();
        
        $msg_ok = __('Your message has been sent.',
                    array('%URL_TO_SENT_MESSAGE%' => $this->getController()->genUrl('messages/thread?id=' . $sent_msg->getThreadId() .'#message_'.$sent_msg->getId()),
                          '%MEMBER_PROFILE_URL%' => $this->getController()->genUrl('@profile?username=' . $to_username),
                          '%MEMBER_USERNAME%' => $to_username
                          )
                    );
                    
        $this->setFlash('msg_ok', $msg_ok);
        $this->redirect('messages/thread?id=' . $sent_msg->getThreadId() .'#message_'.$sent_msg->getId());

    }
        
    public function executeDelete()
    {
        $marked = $this->getRequestParameter('selected', array());
        if ( !empty($marked) )
        {
            //inbox
            $c = new Criteria();
            $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
            $c->add(MessagePeer::THREAD_ID, $marked, Criteria::IN);
            $c->add(MessagePeer::RECIPIENT_ID, $this->getUser()->getId());
            
            $c2 = new Criteria();
            $c2->add(MessagePeer::RECIPIENT_DELETED_AT, time());
            
            BasePeer::doUpdate($c, $c2, Propel::getConnection());
            
            //sent box
            $c = new Criteria();
            $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
            $c->add(MessagePeer::THREAD_ID, $marked, Criteria::IN);
            $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
            
            $c2 = new Criteria();
            $c2->add(MessagePeer::SENDER_DELETED_AT, time());
            
            BasePeer::doUpdate($c, $c2, Propel::getConnection());
                        
        }
        
        $this->setFlash('msg_ok', 'Selected message(s) has been deleted.');
        $this->redirect('messages/index');        
    }
    
    public function executeDeleteDraft()
    {
        $marked = $this->getRequestParameter('selected', array());
        if ( !empty($marked) )
        {
            $c = new Criteria();
            $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT);
            $c->add(MessagePeer::ID, $marked, Criteria::IN);
            $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
            MessagePeer::doDelete($c);
        }
        
        $this->setFlash('msg_ok', 'Selected message(s) has been deleted.');
        $this->redirect('messages/index');        
    }
        
    public function executeDiscard()
    {
        $c = new Criteria();
        $c->add(MessagePeer::ID, $this->getRequestParameter('draft_id'));
        $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT);
        
        $draft = MessagePeer::doSelectOne($c);
        
        if($draft) $draft->delete();
        
        $this->setFlash('msg_ok', 'Your message has been discarded.');
        $this->redirect('messages/index');
    }
    
    public function executeThread()
    {
        $member = $this->getUser()->getProfile();
        $thread = $member->retrieveThreadById($this->getRequestParameter('id'));
        $this->forward404Unless($thread);
        
        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        $messages = $thread->getMessages($c);
        $this->forward404Unless($messages);
        $message_sample = $messages[0];
        
        $this->getUser()->getBC()->removeLast()->add(array('name' => $thread->getSubject()));
        
        $profile  = ( $message_sample->getSenderId() == $member->getId() ) ? $message_sample->getMemberRelatedByRecipientId() : $message_sample->getMemberRelatedBySenderId();
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {   
            $send_msg = MessagePeer::send($member, $profile, 
                                          $this->getRequestParameter('subject'), 
                                          $this->getRequestParameter('content'),
                                          $this->getRequestParameter('draft_id'),
                                          $thread);

            $this->sendConfirmation($send_msg);
        }
                
        MessagePeer::markAsReadInThread($thread->getId(), $member);
        $this->draft = MessagePeer::retrieveOrCreateDraft($this->getRequestParameter('draft_id'), $member->getId(), $profile->getId(), $thread->getId());
      
        //template varibales
        $this->thread = $thread;
        $this->member = $member;
        $this->profile = $profile;
        $this->messages = $messages;
        
    }
    
    public function validateThread()
    {
        $member = $this->getUser()->getProfile();
        $thread = $member->retrieveThreadById($this->getRequestParameter('id'));
        $this->forward404Unless($thread);
        
        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        $messages = $thread->getMessages($c);
        $this->forward404Unless($messages);
        $message_sample = $messages[0];
        
        $profile  = ( $message_sample->getSenderId() == $member->getId() ) ? $message_sample->getMemberRelatedByRecipientId() : $message_sample->getMemberRelatedBySenderId();
        $subscription = $member->getSubscription();
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            /* REPLYING TO THREAD */
            //1. is the other member active ?
            if ( $profile->getmemberStatusId() != MemberStatusPeer::ACTIVE )
            {
                $this->getRequest()->setError('message', 'The member that you want to send a message to is not active.');
                return false;
            }
            
            //2. Privacy
            $prPrivavyValidator = new prPrivacyValidator();
            $prPrivavyValidator->setProfiles($member, $profile);
            $prPrivavyValidator->initialize($this->getContext(), array(
              'block_error' => 'You can not send message to this member!',
              'sex_error' => 'Due to privacy restrictions you cannot send message to this profile',
              'check_onlyfull' => false,
            ));
            
            $error = '';
            if( !$prPrivavyValidator->execute(&$value, &$error) )
            {
                $this->getRequest()->setError('privacy', $error);
                return false;
            }
    
            //3. subscription limits/restrictions ?
            $subscription = $member->getSubscription();
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
            
            if( $member->getCounter('ReplyMessagesDay') >= $subscription->getReplyMessagesDay() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'For the feature that you want to use - reply to message - you have reached the daily limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: For the feature that you want to use - reply to message - you have reached the daily limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
                }
                return false;
            }
            
            if( $member->getCounter('ReplyMessages') >= $subscription->getReplyMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'For the feature that you want to use - reply to message - you have reached the limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: For the feature that you want to use - reply to message - you have reached the limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.');
                }
                return false;
            }
            
            
            if( $this->getRequest()->getMethod() == sfRequest::POST && $this->getRequestParameter('tos', 0) != 1 && !$member->getLastImbra(true) && $profile->getLastImbra(true) )
            {
                $this->getRequest()->setError('message', 'The box has to be checked in order for non-IMBRA user to send a message to IMBRA approved user.');
                return false;                
            }    
                        
        } else {
            /* THREAD VIEW */
            
            if( !$profile->isActive() ) $this->setFlash('msg_error', __('%USERNAME%\'s Profile is not longer available', array('%USERNAME%' => $profile->getUsername())), false);
            
            //break/leave if there is no UNread messages
            $cnt_unread = MessagePeer::countUnreadInThread($thread->getId(), $member);
            if( $cnt_unread < 1 ) return true;
                    
            if( !$subscription->getCanReadMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->setFlash('msg_error', 'In order to read a message you need to upgrade your membership.');
                } else {
                    $this->setFlash('msg_error', 'Paid: In order to read a message you need to upgrade your membership.');
                }
                $this->redirect('messages/index');
            } elseif ( $subscription->getId() == SubscriptionPeer::FREE && $profile->isSubscriptionFree() && !$profile->getSubscription()->getCanSendMessages() )
            {
                //received by FREE member with send messages OFF
                $this->setFlash('msg_error', 'Sender of the message is not a paid member. At least one of you must be a paid member for either send or receive messages.');
                $this->redirect('messages/index');
            }
        
            if( $member->getCounter('ReadMessagesDay') >= $subscription->getReadMessagesDay() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->setFlash('msg_error', 'For the feature that you want to use - read a message - you have reached the daily limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
                } else {
                    $this->setFlash('msg_error', 'Paid: For the feature that you want to use - read a message - you have reached the daily limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
                }
                $this->redirect('messages/index');  
            }
        
            if( $member->getCounter('ReadMessages') >= $subscription->getReadMessages() )
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->setFlash('msg_error', 'For the feature that you want to use - read a message - you have reached the limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
                } else {
                    $this->setFlash('msg_error', 'Paid: For the feature that you want to use - read a message - you have reached the limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.');
                }
                $this->redirect('messages/index');  
            }
        }
    
        
        return true;
    }
    
    public function handleErrorThread()
    {
        
        $member = $this->getUser()->getProfile();
        $thread = $member->retrieveThreadById($this->getRequestParameter('id'));
        $this->forward404Unless($thread);
        
        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        $messages = $thread->getMessages($c);
        $this->forward404Unless($messages);
        $message_sample = $messages[0];
        
        $this->getUser()->getBC()->removeLast()->add(array('name' => $thread->getSubject()));

        $profile  = ( $message_sample->getSenderId() == $member->getId() ) ? $message_sample->getMemberRelatedByRecipientId() : $message_sample->getMemberRelatedBySenderId();
        $this->draft = MessagePeer::retrieveOrCreateDraft($this->getRequestParameter('draft_id'), $member->getId(), $profile->getId(), $thread->getId());
      
        //template varibales
        $this->thread = $thread;
        $this->member = $member;
        $this->profile = $profile;
        $this->messages = $messages;
                
        return sfView::SUCCESS;
    }
}
