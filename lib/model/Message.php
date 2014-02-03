<?php

/**
 * Subclass for representing a row from the 'message' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Message extends BaseMessage
{
    protected $is_reply = false;
    
    public function isReply($bool = true)
    {
        $this->is_reply = $bool;
    }
    
    public function getRecipient()
    {
        return MemberPeer::retrieveByPK($this->getToMemberId());
    }

    public function reply($content = '', $draft_id = null)
    {
        $send_message = MessagePeer::send($this->getMemberRelatedByToMemberId(), 
                                          $this->getMemberRelatedByFromMemberId(),
                                          $content, 
                                          $this->getId(),
                                          $draft_id);
        $this->setIsReplied(true);
        $this->save();
        
        return $send_message;
    }
    
    public function getBodyForReply($template)
    {
        $_body = explode('<br />', $this->getContent());
        $_body = array_map('trim', $_body);
        $from = $this->getMemberRelatedByFromMemberId()->getUsername();
        $message_body = '';

        foreach ($_body as $line)
        {
            $message_body .= '> ' . $line . "\r\n";
        }
                
        $ret = strtr($template, array('%DATETIME%' => $this->getCreatedAt('M d, Y H:i A'), 
                                      '%SENDER_USERNAME%' => $from,
                                      '%MESSAGE%' => $message_body,
                                      ));
                                      
        return $ret;
    }
    
}
