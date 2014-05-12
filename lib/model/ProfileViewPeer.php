<?php

/**
 * Subclass for performing query and update operations on the 'profile_view' table.
 *
 *
 *
 * @package lib.model
 */
class ProfileViewPeer extends BaseProfileViewPeer
{
  public static function getNewVisitorsCriteria($member_id)
  {
        $c = new Criteria();
        $c->add(self::PROFILE_ID, $member_id);
        $c->add(self::IS_NEW, true);
        $c->addJoin(MemberPeer::ID, self::MEMBER_ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->addGroupByColumn(self::MEMBER_ID);

        //privacy check
        $c->addJoin(self::MEMBER_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. self::PROFILE_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);

        return $c;
  }

  public static function getAllVisitorsCriteria($member_id)
  {
        $c = new Criteria();
        $c->add(self::PROFILE_ID, $member_id);
        $c->addJoin(MemberPeer::ID, self::MEMBER_ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->addGroupByColumn(self::MEMBER_ID);

        //privacy check
        $c->addJoin(self::MEMBER_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. self::PROFILE_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);

        return $c;
  }
}
