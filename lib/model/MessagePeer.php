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
        
        Events::triggerFirstContact($message);
        
        return $sent_message;
    }
}
