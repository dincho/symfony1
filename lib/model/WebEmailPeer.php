<?php

/**
 * Subclass for performing query and update operations on the 'web_email' table.
 *
 * 
 *
 * @package lib.model
 */ 
class WebEmailPeer extends BaseWebEmailPeer
{
    public static function retrieveByHash($hash)
    {
        $c = new Criteria();
        $c->add(WebEmailPeer::HASH, $hash);
        $c->setLimit(1);
        
        return self::doSelectOne($c);
    }
}
