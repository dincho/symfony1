<?php

/**
 * Subclass for performing query and update operations on the 'member_subscription' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberSubscriptionPeer extends BaseMemberSubscriptionPeer
{
  public static function retrieveByPPRef($ref)
  {
    $c = new Criteria();
    $c->add(self::PP_REF, $ref);
    return self::doSelectOne($c);
  }  
}
