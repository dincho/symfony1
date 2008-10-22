<?php

/**
 * Subclass for performing query and update operations on the 'subscription' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SubscriptionPeer extends BaseSubscriptionPeer
{
    const FREE = 1;
    const PAID = 2;
    const COMP = 3;
    const VIP  = 4;
}
