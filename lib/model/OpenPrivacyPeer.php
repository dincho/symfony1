<?php

/**
 * Subclass for performing query and update operations on the 'open_privacy' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OpenPrivacyPeer extends BaseOpenPrivacyPeer
{
	
  public static function getPrivacy( $member_id, $profile_id) {

		$c = new Criteria();
		$c->add(OpenPrivacyPeer::MEMBER_ID, $member_id);
		$c->add(OpenPrivacyPeer::PROFILE_ID, $profile_id);
 		$v = OpenPrivacyPeer::doSelect($c);

		return !empty($v) ? $v[0] : null;
	}
}
