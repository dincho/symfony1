<?php

/**
 * Subclass for representing a row from the 'profile_view' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ProfileView extends BaseProfileView
{
    public function getProfile()
    {
        return MemberPeer::retrieveByPK($this->getProfileId());
    }
    
    public function save($con = null, $inc_counter = true)
    {
        if($inc_counter && $this->isNew() && parent::save($con))
        {
            $this->getMemberRelatedByMemberId()->incCounter('MadeProfileViews');
            $this->getMemberRelatedByProfileId()->incCounter('ProfileViews');
            
            return true;
        }
        
        
        return parent::save($con);
    }     
}
