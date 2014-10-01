<?php

/**
 * Subclass for performing query and update operations on the 'private_photo_permission' table.
 *
 *
 *
 * @package lib.model
 */
class PrivatePhotoPermissionPeer extends BasePrivatePhotoPermissionPeer
{
  public static function getNewPhotoCriteria($member_id)
  {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::PROFILE_ID, $member_id);
        $c->addJoin(MemberPeer::ID, PrivatePhotoPermissionPeer::MEMBER_ID);
        $c->add(PrivatePhotoPermissionPeer::STATUS, 'A');
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'P');
        $c->add(PrivatePhotoPermissionPeer::IS_NEW, true);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //do not show unavailable profiles

        //privacy check
        $c->addJoin(PrivatePhotoPermissionPeer::PROFILE_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. PrivatePhotoPermissionPeer::MEMBER_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);

        return $c;
  }

  public static function getAllPhotoCriteria($member_id)
  {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::PROFILE_ID, $member_id);
        $c->addJoin(MemberPeer::ID, PrivatePhotoPermissionPeer::MEMBER_ID);
        $c->add(PrivatePhotoPermissionPeer::STATUS, 'A');
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'P');
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //do not show unavailable profiles

        //privacy check
        $c->addJoin(PrivatePhotoPermissionPeer::PROFILE_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. PrivatePhotoPermissionPeer::MEMBER_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);

        return $c;
  }

}
