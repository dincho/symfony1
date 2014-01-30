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

    public static function getOrCreatePendingSubscription(
        Member $member,
        SubscriptionDetails $subscription
    ) {
        //check if pending subscription already exists
        $c = new Criteria();
        $c->add(MemberSubscriptionPeer::MEMBER_ID, $member->getId());
        $c->add(MemberSubscriptionPeer::SUBSCRIPTION_ID, $subscription->getSubscriptionId());
        $c->add(MemberSubscriptionPeer::STATUS, 'pending');
        $memberSubscription = MemberSubscriptionPeer::doSelectOne($c);

        //no subscription found, create new one.
        if (!$memberSubscription) {
          $memberSubscription = new MemberSubscription();
          $memberSubscription->setMemberId($member->getId());
          $memberSubscription->setSubscriptionId($subscription->getSubscriptionId());
          $memberSubscription->setPeriod($subscription->getPeriod());
          $memberSubscription->setPeriodType($subscription->getPeriodType());
          $memberSubscription->save();
        }

        return $memberSubscription;
    }
}
