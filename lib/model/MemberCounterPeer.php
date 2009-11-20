<?php

/**
 * Subclass for performing query and update operations on the 'member_counter' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberCounterPeer extends BaseMemberCounterPeer
{
    public static function getNbNewWinks($member_id)
    {
        $c = new Criteria();
        $c->add(WinkPeer::IS_NEW, true);
        $c->add(WinkPeer::PROFILE_ID, $member_id);
        $c->add(WinkPeer::SENT_BOX, false); //we need only received winks
        $c->add(WinkPeer::DELETED_AT, null, Criteria::ISNULL);
        
        return WinkPeer::doCount($c);
    }
    
    public static function getNbNewOnOtherHotlist($member_id)
    {
        $c = new Criteria();
        $c->add(HotlistPeer::IS_NEW, true);
        $c->add(HotlistPeer::PROFILE_ID, $member_id);
        
        return HotlistPeer::doCount($c);
    }
    
    public static function getNbNewProfileViews($member_id)
    {
        $c = new Criteria();
        $c->add(ProfileViewPeer::IS_NEW, true);
        $c->add(ProfileViewPeer::PROFILE_ID, $member_id);
        
        return ProfileViewPeer::doCount($c);
    }    
}
