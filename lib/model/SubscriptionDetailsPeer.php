<?php

/**
 * Subclass for performing query and update operations on the 'subscription_details' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SubscriptionDetailsPeer extends BaseSubscriptionDetailsPeer
{
    public static function retrieveBySubscriptionIdAndCatalogId($sub_id, $cat_id)
    {
        $c = new Criteria();
        $c->add(SubscriptionDetailsPeer::SUBSCRIPTION_ID, $sub_id);
        $c->add(SubscriptionDetailsPeer::CAT_ID, $cat_id);
    
        $subs = SubscriptionDetailsPeer::doSelectJoinSubscription($c);
        
        return (isset($subs[0])) ? $subs[0] : null;
    }
}
