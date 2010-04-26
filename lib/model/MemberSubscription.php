<?php

/**
 * Subclass for representing a row from the 'member_subscription' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberSubscription extends BaseMemberSubscription
{
    public function getLastCompletedPayment()
    {
        $c = new Criteria();
        $c->add(MemberPaymentPeer::MEMBER_SUBSCRIPTION_ID, $this->getId());
        $c->add(MemberPaymentPeer::STATUS, 'completed');
        $c->addDescendingOrderByColumn(MemberPaymentPeer::CREATED_AT);
        
        return MemberPaymentPeer::doSelectOne($c);
    }
    
    public function getExtendedEOT()
    {
        $dt = new sfDate($this->getEotAt(null));
        $dt->addDay(sfConfig::get('app_settings_extend_eot', 0));
        
        return $dt->get();
    }
    
    public function EOT()
    {
        $this->setStatus('eot');
        $this->setIsCurrent(false);
        
        $this->getMember()->changeSubscription(SubscriptionPeer::FREE);
    }
    
    public function setDetails($details)
    {
        parent::setDetails(serialize($details));
    }
    
    public function getDetails()
    {
        return (parent::getDetails()) ? unserialize(parent::getDetails()) : null;
    }
    
    public function getGiftSender()
    {
        return ($this->getGiftBy()) ? MemberPeer::retrieveByPK($this->getGiftBy()) : null;
    }
}
