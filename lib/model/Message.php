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
    public function getRecipient()
    {
        return MemberPeer::retrieveByPK($this->getToMemberId());
    }
    
    public function save($con = null, $inc_counter = true)
    {
        if( $inc_counter && $this->isNew() && parent::save($con))
        {
            $this->getMemberRelatedByFromMemberId()->incCounter('SentMessages');
            $this->getMemberRelatedByToMemberId()->incCounter('ReceivedMessages');
            
            return true;
        }
        
        return parent::save($con);
    }
}
