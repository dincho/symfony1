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
    public static function send($from_id, $to_id, $subject = '', $content = '')
    {
        //add to recepient
        $message = new Message();
        $message->setFromMemberId($from_id);
        $message->setToMemberId($to_id);
        $message->setSubject($subject);
        $message->setContent($content);
        
        
        //save to sent box
        $sent_message = clone $message;
        $sent_message->setSentBox(true);
        
        //save objects
        $message->save();
        $sent_message->save(null, false);
        
        return $sent_message->getId();
    }    
}
