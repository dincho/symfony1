<?php

/**
 * Subclass for representing a row from the 'user' table.
 *
 * 
 *
 * @package lib.model
 */ 
class User extends BaseUser
{
  public function __toString()
  {
    return $this->getUsername();
  }
  
  public function getStatus()
  {
    return ($this->isEnabled()) ? 'enabled' : 'disabled';
  }
  
  public function isEnabled()
  {
    return $this->getIsEnabled();
  }
  
  public function setPassword($v)
  {
      parent::setPassword(sha1(SALT . $v . SALT));
  }
}
