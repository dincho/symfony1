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
    
    public function save($con = null)
    {
        if( $this->isNew() && !$this->getSentBox() && !$this->getIsSystem() && parent::save($con))
        {
            $from_member = $this->getMemberRelatedByFromMemberId();
            $to_member = $this->getMemberRelatedByToMemberId();
            
            if( $this->is_reply )
            {
                $from_member->incCounter('ReceivedMessages');
                $to_member->incCounter('ReplyMessages');
            } else {
                if( $from_member->getNbSendMessagesToday()+1 == sfConfig::get('app_settings_notification_spam_msgs') ) 
                    Events::triggerSpamActivity($from_member,$from_member->getNbSendMessagesToday()+1);
                
                $from_member->incCounter('SentMessages');
                $to_member->incCounter('ReceivedMessages');                
            }
            return true;
        }
        
        return parent::save($con);
    }
    
    public function reply($subject = '', $content = '', $draft_id = null)
    {
        $send_message = MessagePeer::send($this->getMemberRelatedByToMemberId(), 
                                          $this->getMemberRelatedByFromMemberId(), 
                                          $subject, 
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
                                      
        //$ret .= 'On ' . $this->getCreatedAt('M d, Y H:i A, ') .  $from . ' wrote: ' . "\r\n";
        return $ret;
    }     
}
