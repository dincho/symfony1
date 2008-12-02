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
    
    public function reply($subject = '', $content = '')
    {
        $send_message = MessagePeer::send($this->getMemberRelatedByToMemberId(), $this->getMemberRelatedByFromMemberId(), $subject, $content, $this->getId());
        $this->setIsReplied(true);
        $this->save();
        
        return $send_message;
    }
}
