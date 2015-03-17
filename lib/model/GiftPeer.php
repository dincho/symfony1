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
}
