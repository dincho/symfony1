<?php

/**
 * Subclass for performing query and update operations on the 'gift' table.
 *
 * 
 *
 * @package lib.model
 */ 
class GiftPeer extends BaseGiftPeer
{
    public static function getAllowedGiftsNum(BaseMember $member)
    {
        // calculate last member payment
        $member_subscription = $member->getCurrentMemberSubscription();
        $last_payment = ($member_subscription) ? $member_subscription->getLastCompletedPayment() : null;

        if (!$last_payment) {
            return 0;
        }

        $paymentDate = $last_payment->getCreatedAt(null); //timestamp
        $gracePeriod = sfConfig::get('app_gifts_send_period_days', 7)*24*60*60;  // 604800 secs
        $endDate = $paymentDate + $gracePeriod;

        $c = new Criteria();
        $c->add(GiftPeer::FROM_MEMBER_ID, $member->getId());
        $c->add(GiftPeer::CREATED_AT, $paymentDate, Criteria::GREATER_THAN);
        $c->add(GiftPeer::CREATED_AT, $endDate, Criteria::LESS_THAN);
        $giftsCnt = GiftPeer::doCount($c);

        $giftsLimit = sfConfig::get('app_gifts_friends_limit', 2);

        return $giftsLimit - $giftsCnt;
    }
    /**
     * @param $hash
     * @return Gift
     */
    public static function retrieveByHash($hash)
    {
        $c = new Criteria();
        $c->add(self::HASH, $hash);

        return self::doSelectOne($c);
    }

    public static function giftAlreadyPending(BaseMember $member, $email)
    {
        // calculate last member payment
        $member_subscription = $member->getCurrentMemberSubscription();
        $last_payment = ($member_subscription) ? $member_subscription->getLastCompletedPayment() : null;

        if (!$last_payment) {
            return false;
        }

        $paymentDate = $last_payment->getCreatedAt(null); //timestamp
        $gracePeriod = sfConfig::get('app_gifts_send_period_days', 7)*24*60*60;  // 604800 secs
        $endDate = $paymentDate + $gracePeriod;

        $c = new Criteria();
        $c->add(GiftPeer::FROM_MEMBER_ID, $member->getId());
        $c->add(GiftPeer::CREATED_AT, $paymentDate, Criteria::GREATER_THAN);
        $c->add(GiftPeer::CREATED_AT, $endDate, Criteria::LESS_THAN);
        $c->add(GiftPeer::TO_EMAIL, $email);
        $giftsCnt = GiftPeer::doCount($c);

        return $giftsCnt > 0;
    }
}
