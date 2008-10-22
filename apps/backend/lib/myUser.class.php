<?php

class myUser extends sfNewSecurityUser
{
  private $profile = null;
    
  public function getId()
  {
    return $this->getAttribute('user_id');
  }
  
  public function getUsername()
  {
    return $this->getAttribute('username');
  }
  
  public function getBC()
  {
    return prBackendBreadCrumb::getInstance();
  }
  
  public function getLastLogin($format = 'm/d/Y H:iA T')
  {
      return date($format, $this->getAttribute('last_login'));
  }
  
  /**
   * Get User`s profile
   *
   * @return User
   */
  public function getProfile()
  {
      if( is_null( $this->profile ) )
      {
          $this->profile = UserPeer::retrieveByPK($this->getId());
      }
      
      return $this->profile;
  }
}
