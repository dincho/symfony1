<?php

/**
 * Subclass for performing query and update operations on the 'hotlist' table.
 *
 * 
 *
 * @package lib.model
 */ 
class HotlistPeer extends BaseHotlistPeer
{
    public static function getNewHotlistCriteria($member_id)
    {
        $c = new Criteria();
        $c->add(HotlistPeer::PROFILE_ID, $member_id);
        $c->add(HotlistPeer::IS_NEW, true);
        $c->addJoin(MemberPeer::ID, HotlistPeer::MEMBER_ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles

        //privacy check
        $c->addJoin(HotlistPeer::MEMBER_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. HotlistPeer::PROFILE_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);

        return $c;
    }


    public static function getMembersForLoginNotification(BaseMember $profile)
    {
        $c = new Criteria();
        $c->add(self::PROFILE_ID, $profile->getId());
        $c->clearSelectColumns()->addSelectColumn(self::MEMBER_ID);

        $ids = array();
        $rs = self::doSelectRS($c);
        while($rs->next()) {
            $ids[] = $rs->getInt(1);
        }

        return $ids;
    }
}
