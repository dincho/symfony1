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
    public static function send(BaseMember $from_member, BaseMember $to_member, $subject = '', $content = '', $reply_to = null)
    {
        //add to recepient
        $message = new Message();
        $message->setFromMemberId($from_member->getId());
        $message->setToMemberId($to_member->getId());
        $message->setSubject($subject);
        $message->setContent($content);
        $message->isReply(!is_null($reply_to));
        
        
        //save to sent box
        $sent_message = clone $message;
        $sent_message->setSentBox(true);
        
        //save objects
        $message->save();
        $sent_message->save();
        
        //add auto reply message if both members are with free subscriptions
        if( $from_member->getSubscriptionId() == SubscriptionPeer::FREE &&
            $to_member->getSubscriptionId() == SubscriptionPeer::FREE )
        {
            $controller = sfContext::getInstance()->getController();
            $auto_reply = new Message();
            $auto_reply->setFromMemberId($to_member->getId());
            $auto_reply->setToMemberId($from_member->getId());
            $auto_reply->setSubject('Re: ' . $subject . ' - (auto-response)');
            $msg = 'The person whom you contacted - %USERNAME% - cannot read your message, 
            because at least one person must be a Full Member for either send or receive a message. 
            To make sure %USERNAME% will be able to open your message, <a href="%URL_FOR_SUBSCRIPTION%">please upgrade now to become a Full Member.</a>';
            $msg = sfContext::getInstance()->getI18N()->__($msg, array('%USERNAME%' => $to_member->getUsername(), '%URL_FOR_SUBSCRIPTION%' => $controller->genUrl('subscription/index')));
            
            $auto_reply->setContent($msg);
            $auto_reply->isReply(true);
            $auto_reply->setIsSystem(true);
            $auto_reply->setIsReplied(true);
            $auto_reply->setIsReviewed(true);
            $auto_reply->save();
        }
                
        Events::triggerFirstContact($message);
        if( $to_member->getEmailNotifications() === 0 ) Events::triggerAccountActivity($to_member);
        
        return $sent_message;
    }
}
