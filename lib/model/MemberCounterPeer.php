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
        $c->addJoin(WinkPeer::PROFILE_ID, MemberPeer::ID);
        $c->add(WinkPeer::CREATED_AT, WinkPeer::CREATED_AT . ' > ' . MemberPeer::LAST_WINKS_VIEW, Criteria::CUSTOM);
        $c->add(WinkPeer::PROFILE_ID, $member_id);
        $c->add(WinkPeer::SENT_BOX, false); //we need only received winks
        $c->add(WinkPeer::DELETED_AT, null, Criteria::ISNOTNULL);
        
        return WinkPeer::doCount($c);
    }
    
    public static function getNbNewOnOtherHotlist($member_id)
    {
        $c = new Criteria();
        $c->addJoin(HotlistPeer::PROFILE_ID, MemberPeer::ID);
        $c->add(HotlistPeer::CREATED_AT, HotlistPeer::CREATED_AT . ' > ' . MemberPeer::LAST_HOTLIST_VIEW, Criteria::CUSTOM);
        $c->add(HotlistPeer::PROFILE_ID, $member_id);
        
        return HotlistPeer::doCount($c);
    }
    
    public static function getNbNewProfileViews($member_id)
    {
        $c = new Criteria();
        $c->addJoin(ProfileViewPeer::PROFILE_ID, MemberPeer::ID);
        $c->add(ProfileViewPeer::CREATED_AT, ProfileViewPeer::CREATED_AT . ' > ' . MemberPeer::LAST_PROFILE_VIEW, Criteria::CUSTOM);
        $c->add(ProfileViewPeer::PROFILE_ID, $member_id);
        
        return ProfileViewPeer::doCount($c);
    }    
}
