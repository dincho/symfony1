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
        if( $this->isNew() && !$this->getSentBox() && parent::save($con))
        {
            $from_member = $this->getMemberRelatedByFromMemberId();
            $to_member = $this->getMemberRelatedByToMemberId();
            
            if( $this->is_reply )
            {
                $from_member->incCounter('ReceivedMessages');
                $to_member->incCounter('ReplyMessages');
            } else {
                //@TODO 5 must be moved to some backend setting, to be dinamicaly changed.
                if( $from_member->getNbSendMessagesToday()+1 == 5 ) Events::triggerSpamActivity($from_member);
                
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
