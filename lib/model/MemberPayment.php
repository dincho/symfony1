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
        $member_subscription->setNextAmount($this->getAmount());
        $member_subscription->setNextCurrency($this->getCurrency());
        $member = $member_subscription->getMember();
        $subscription = SubscriptionDetailsPeer::retrieveBySubscriptionIdAndCatalogId($member_subscription->getSubscriptionId(), $member->getCatalogId());
        $curr_subscription = $member->getCurrentMemberSubscription();
        
        //confirm the subscription on the first payment
        //this is used for payment processors that does not send subscription confirmation/notification ( like zong )
        if( $member_subscription->getStatus() == 'pending' ) $member_subscription->setStatus('confirmed');
        
        //set effective date on first payment
        if( is_null($member_subscription->getEffectiveDate()) )
        {
            //if effective subscription look for last subscription EOT
            $effective_date = ( sfConfig::get('app_settings_immediately_subscription_upgrade') || !$curr_subscription ) ? time() : $member->getLastEotAt();
            $member_subscription->setEffectiveDate( $effective_date );
        }
          
        //calculate EOT
        $type = $subscription->getPeriodType();
        $period_types_map = array('D' => 3, 'W' => 4, 'M' => 5, 'Y' => 7);
        $period_type = $period_types_map[$type];
        $eot_start_time = ( is_null($member_subscription->getEotAt()) ) ? $member_subscription->getEffectiveDate(null) : $member_subscription->getEotAt(null);
        
        $dt = new sfDate($eot_start_time);
        $dt->add($subscription->getPeriod(), $period_type);
        $member_subscription->setEotAt($dt->get());
        
        if( $member_subscription->getEffectiveDate(null) <= time() && //effective date is today or in the past ( e.g. pending payment )
            $member->getSubscriptionId() != $member_subscription->getSubscriptionId() ) //in other words, this means first payment to this subscription
        {
           if( $curr_subscription && 
               //failed subscription detection, because failed subscription is also returned as "current", to prevent double subscribes
               $curr_subscription->getId() != $member_subscription->getId() ) 
           {
             $curr_subscription->setStatus('eot');
             $curr_subscription->save();
           }
           
           $member->changeSubscription($member_subscription->getSubscriptionId(), 'system (payment)');
           $member_subscription->setStatus('active');
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
