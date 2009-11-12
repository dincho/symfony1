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
    public static function send(BaseMember $from_member, BaseMember $to_member, $subject = '', $content = '', $reply_to = null, $draft_id = null)
    {
        //add to recepient
        $message = new Message();
        $message->setFromMemberId($from_member->getId());
        $message->setToMemberId($to_member->getId());
        $message->setSubject($subject);
        $message->setContent(nl2br($content));
        $message->isReply(!is_null($reply_to));
        
        //save to sent box
        $sent_message = clone $message;
        $sent_message->setSentBox(true);
        
        //save objects
        $message->save();
        $sent_message->save();
        
        //add auto reply message if nessecary
        if( $from_member->isSubscriptionFree() && 
            !$from_member->getSubscription()->getCanSendMessages() && 
            ( $to_member->isSubscriptionFree() || !$to_member->getSubscription()->getCanReadMessages() )
          )
        {
            $auto_reply = new Message();
            $auto_reply->setFromMemberId($to_member->getId());
            $auto_reply->setToMemberId($from_member->getId());
            $auto_reply->setSubject('Re: ' . $subject . ' - (auto-response)');
            $msg = 'Messages - please upgrade auto-response';
            if( sfConfig::get('sf_i18n') ) $msg = sfContext::getInstance()->getI18N()->__($msg, array('%USERNAME%' => $to_member->getUsername()));
            
            $auto_reply->setContent($msg);
            $auto_reply->isReply(true);
            $auto_reply->setIsSystem(true);
            $auto_reply->setIsReplied(true);
            $auto_reply->setIsReviewed(true);
            $auto_reply->save();
        }
                
        Events::triggerFirstContact($message);
        if( $to_member->getEmailNotifications() === 0 ) Events::triggerAccountActivityMessage($to_member, $from_member);

        //update last activity
        $from_member->setLastActivity(time());
        $from_member->save();

        if( !is_null($draft_id) ) MessageDraftPeer::clear($draft_id, $from_member->getId());
        return $sent_message;
    }
}
