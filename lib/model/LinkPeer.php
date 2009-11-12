<?php

/**
 * Subclass for performing query and update operations on the 'link' table.
 *
 * 
 *
 * @package lib.model
 */ 
class LinkPeer extends BaseLinkPeer
{
  public static function getByHash($hash)
  {
    $c = new Criteria();
    $c->add(self::HASH, $hash);
    return self::doSelectOne($c);
  }
  
  public static function create($uri, $login_as = null)
  {
    $link = new Link($uri, $login_as);
    $link->save();
    
    return $link;
  }
}
