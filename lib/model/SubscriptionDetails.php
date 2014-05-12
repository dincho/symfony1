<?php

/**
 * Subclass for representing a row from the 'subscription_details' table.
 *
 *
 *
 * @package lib.model
 */
class SubscriptionDetails extends BaseSubscriptionDetails
{
    public function getTitle()
    {
        return $this->getSubscription()->getTitle();
    }

    public function getShortTitle()
    {
        return $this->getSubscription()->getShortTitle();
    }
}
