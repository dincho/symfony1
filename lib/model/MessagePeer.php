<?php

/**
 * Subclass for performing query and update operations on the 'message' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MessagePeer extends BaseMessagePeer
{
    const TYPE_NORMAL = 1;
    const TYPE_DRAFT  = 2;
    const TYPE_SYSTEM = 3;
    
    public static function send(BaseMember $sender, BaseMember $recipient, $subject = '', $body = '', $draft_id = null, BaseThread $thread = null)
    {
        $message = new Message();
        $message->setRecipientId($recipient->getId());
        $message->setSenderId($sender->getId());
        $message->setSubject($subject);
        $message->setBody(nl2br($body));
        
        $reply = true;
        
        if( !$thread)
        {
            $reply = false;
            $thread = new Thread();
            $thread->setSubject($subject);
        }
        
        $thread->setSnippet($message->getBody());
        $thread->setSnippetMemberId($message->getSenderId());
        $message->setThread($thread);
            
        //save objects
        $message->save();

        //open the privacy
        $sender->addOpenPrivacyForIfNeeded($recipient->getId());
        
        //add auto reply message if nessecary
        if( $sender->isSubscriptionFree() && 
            !$sender->getSubscription()->getCanSendMessages() && 
            ( $recipient->isSubscriptionFree() || !$recipient->getSubscription()->getCanReadMessages() )
          )
        {
            $subject = 'Re: ' . $subject . ' - (auto-response)';
            $msg = 'Messages - please upgrade auto-response';
            if( sfConfig::get('sf_i18n') ) $msg = sfContext::getInstance()->getI18N()->__($msg, array('%USERNAME%' => $recipient->getUsername()));
            
            $thread->setSnippet($msg);
            $thread->setSnippetMemberId($recipient->getId());
                        
            $auto_msg = new Message();
            $auto_msg->setThread($thread);
            $auto_msg->setType(MessagePeer::TYPE_SYSTEM);
            $auto_msg->setSenderId($recipient->getId());
            $auto_msg->setRecipientId($sender->getId());
            $auto_msg->setSubject($subject);
            $auto_msg->setBody($msg);
            $auto_msg->setIsReviewed(true);
            $auto_msg->save();
            
            if( $sender->getEmailNotifications() === 0 ) Events::triggerAccountActivityMessage($sender, $recipient, $auto_msg);
        }
                
        Events::triggerFirstContact($message);
        if( $recipient->getEmailNotifications() === 0 ) Events::triggerAccountActivityMessage($recipient, $sender, $message);

        //update last activity
        $sender->setLastActivity(time());
        $sender->save();

        if( !is_null($draft_id) ) MessagePeer::clearDraft($draft_id, $sender->getId());
        
        //increment counters
        if( $reply ) //replying ...
        {
            $sender->incCounter('ReplyMessages');
            $sender->incCounter('ReplyMessagesDay');
        } else {
            if( $sender->getNbSendMessagesToday()+1 == sfConfig::get('app_settings_notification_spam_msgs') ) 
                Events::triggerSpamActivity($sender, $sender->getNbSendMessagesToday()+1);
            
            $sender->incCounter('SentMessages');
            $sender->incCounter('SentMessagesDay');
        }

        $recipient->incCounter('ReceivedMessages');
        
                
        return $message;
    }
    
    public static function getThreadLastMessage($thread_id, $member_id)
    {
        $c = new Criteria();
        $c->add(self::THREAD_ID, $thread_id);

        $crit = $c->getNewCriterion(self::SENDER_ID, $member_id);
        $crit->addOr($c->getNewCriterion(self::RECIPIENT_ID, $member_id));
        $c->add($crit);
        
        $c->addDescendingOrderByColumn(self::CREATED_AT);
        
        return self::doSelectOne($c);
    }

    public static function countAllUnreadInThread($thread_id, BaseMember $member)
    {
        $c = new Criteria();
        $c->add(self::UNREAD, true);
        $c->add(self::THREAD_ID, $thread_id);
        $c->add(self::RECIPIENT_ID, $member->getId());
        $c->add(self::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
        return self::doCount($c);
    }
    

    public static function countUnreadInThread($thread_id, BaseMember $member)
    {
        $c = new Criteria();
        $c->add(self::UNREAD, true);
        $c->add(self::THREAD_ID, $thread_id);
        $c->add(self::RECIPIENT_ID, $member->getId());
        $c->add(self::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
        $c->add(self::TYPE, self::TYPE_NORMAL);
        return self::doCount($c);
    }
    
    public static function countUnreadSystemInThread($thread_id, BaseMember $member)
    {
        $c = new Criteria();
        $c->add(self::UNREAD, true);
        $c->add(self::THREAD_ID, $thread_id);
        $c->add(self::RECIPIENT_ID, $member->getId());
        $c->add(self::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
        $c->add(self::TYPE, self::TYPE_SYSTEM);
        return self::doCount($c);
    }    
    
    public static function markAsReadInThread($thread_id, BaseMember $member)
    {
        $c = new Criteria();
        $c->add(self::UNREAD, true);
        $c->add(self::THREAD_ID, $thread_id);
        $c->add(self::RECIPIENT_ID, $member->getId());
        $c->add(self::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
                
        $cnt = self::countAllUnreadInThread($thread_id, $member);
        
        if( $cnt > 0 )
        {
            $c2 = new Criteria();
            $c2->add(self::UNREAD, false);
            BasePeer::doUpdate($c, $c2, Propel::getConnection());
            
            $cnt = $cnt - self::countUnreadSystemInThread($thread_id, $member); //remove system messages from member's counter
            $member->incCounter('ReadMessages', $cnt);
            $member->incCounter('ReadMessagesDay', $cnt);
        }

    }
    
    /**
    * Looks for existing draft or create new one
    *
    * @param int $id
    * @param int $from_member_id
    * @param int $to_member_id
    * @return MessageDraft
    */
    public static function retrieveOrCreateDraft($id, $sender_id, $recipient_id, $thread_id = null)
    {
        $c = new Criteria();
        $c->add(self::ID, $id);
        $c->add(self::SENDER_ID, $sender_id);
        $c->add(self::RECIPIENT_ID, $recipient_id);
        $c->add(self::TYPE, self::TYPE_DRAFT);
        if( !is_null($thread_id) ) $c->add(self::THREAD_ID, $thread_id);
        
        $draft = self::doSelectOne($c);
    
        if( !$draft )
        {
          $draft = new Message();
          $draft->setThreadId($thread_id);
          $draft->setType(self::TYPE_DRAFT);
          $draft->setUnread(false);
          $draft->setSenderId($sender_id);
          $draft->setRecipientId($recipient_id);
          $draft->save();
        }
    
        return $draft;
    }
    
    public static function clearDraft($id, $member_id)
    {
        $c = new Criteria();
        $c->add(self::TYPE, self::TYPE_DRAFT);
        $c->add(self::ID, $id);
        $c->add(self::SENDER_ID, $member_id);

        self::doDelete($c);
    }    
}
