<?php

/**
 * Subclass for representing a row from the 'member_payment' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberPayment extends BaseMemberPayment
{
    public function applyToSubscription()
    {
        $member_subscription = $this->getMemberSubscription();
        
        //confirm the subscription on the first payment
        //this is used for payment processors that does not send subscription confirmation/notification
        if( $member_subscription->getStatus() == 'pending' ) $member_subscription->setStatus('active');
    
        //calculate EOT
        $period_types_map = array('D' => 3, 'W' => 4, 'M' => 5, 'Y' => 7);
        $period_type = $period_types_map[$member_subscription->getPeriodType()];
        $eot_start_time = ( is_null($member_subscription->getEotAt()) ) ? $this->getCreatedAt(null) : $member_subscription->getEotAt(null);
        
        $dt = new sfDate($eot_start_time);
        $dt->add($member_subscription->getPeriod(), $period_type);
        $member_subscription->setEotAt($dt->get());
        $member_subscription->setIsCurrent(true);
        
        $member = $member_subscription->getMember();
        //in other words, this means first payment to this subscription
        if( $member->getSubscriptionId() != $member_subscription->getSubscriptionId() )
        {
           $member->changeSubscription($member_subscription->getSubscriptionId());
        }
        
        $member_subscription->save();
    }
    
    public function voidWithStatus($status)
    {
        $member_subscription = $this->getMemberSubscription();
        
        $period_types_map = array('D' => 3, 'W' => 4, 'M' => 5, 'Y' => 7);
        $period_type = $period_types_map[$member_subscription->getPeriodType()];
        $dt = new sfDate($member_subscription->getEotAt(null));
        $dt->subtract($member_subscription->getPeriod(), $period_type);
        $member_subscription->setEotAt($dt->get());
        
        $this->setExtraStatus($status);
    }
    
    public function setDetails($details)
    {
        parent::setDetails(serialize($details));
    }
    
    public function getDetails()
    {
        return (parent::getDetails()) ? unserialize(parent::getDetails()) : null;
    }
}
