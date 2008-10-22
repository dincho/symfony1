<?php

/**
 * Subclass for performing query and update operations on the 'user' table.
 *
 * 
 *
 * @package lib.model
 */ 
class UserPeer extends BaseUserPeer
{
  public static function retrieveByUsername($username)
  {
    $c = new Criteria();
    $c->add(UserPeer::USERNAME, $username);
    
    return UserPeer::doSelectOne($c);
  }
}
