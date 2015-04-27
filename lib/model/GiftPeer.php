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
        if (!$member->getSubscriptionDetails()->getCanSendGift()) {
            return 0;
        }

        if (!$member->getLastCompletedPayment()) {
            return 0;
        }

        $giftsCnt = self::countMemberSentGifts($member, new Criteria());
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

    public static function canSendGiftToEmail(BaseMember $member, $email)
    {
        $c = new Criteria();
        $c->add(GiftPeer::TO_EMAIL, $email);
        $giftsCnt = self::countMemberSentGifts($member, $c);

        return $giftsCnt > 0;
    }

    public static function countMemberSentGifts(BaseMember $member, Criteria $c)
    {
        $last_payment = $member->getLastCompletedPayment();

        if (!$last_payment) {
            return 0;
        }

        $paymentDate = $last_payment->getCreatedAt(null); //timestamp
        $gracePeriod = sfConfig::get('app_gifts_send_period_days', 7)*24*60*60;  // 604800 secs
        $endDate = $paymentDate + $gracePeriod;

        $c->add(GiftPeer::FROM_MEMBER_ID, $member->getId());
        $c->add(GiftPeer::CREATED_AT, $paymentDate, Criteria::GREATER_THAN);
        $c->add(GiftPeer::CREATED_AT, $endDate, Criteria::LESS_THAN);

        return GiftPeer::doCount($c);
    }
}
