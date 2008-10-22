<?php

/**
 * Subclass for representing a row from the 'wink' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Wink extends BaseWink
{
    public function getProfile()
    {
        return MemberPeer::retrieveByPK($this->getProfileId());
    }
    
    public function save($con = null, $inc_counter = true)
    {
        if($inc_counter && $this->isNew() && parent::save($con))
        {
            $this->getMemberRelatedByMemberId()->incCounter('SentWinks');
            $this->getMemberRelatedByProfileId()->incCounter('ReceivedWinks');
            
            return true;
        }
        
        return parent::save($con);
    }     
}
