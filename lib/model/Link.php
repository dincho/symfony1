<?php

/**
 * Subclass for representing a row from the 'link' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Link extends BaseLink
{
  public function __construct($uri = null, $login_as = null)
  {
    $this->setUri($uri);
    $this->setLoginAs($login_as);
    
    $rand = Tools::generateString(8) . time();
    $this->setHash(sha1(SALT . $rand . SALT));
    
    $this->setLoginExpiresAt(time() + sfConfig::get('app_links_default_login_expire_period'));
    $this->setExpiresAt(time() + sfConfig::get('app_links_default_expire_period'));
    $this->setLifetime(sfConfig::get('app_links_default_lifetime'));
  }
  
  public function getUrl($culture)
  { 
    $domain = sfConfig::get('app_domains_' . $culture, sfConfig::get('app_base_domain', @$_SERVER['HTTP_HOST']));
    $url = 'http://' . $domain . '/link/' . $this->getHash() . '.html';
    
    return $url;
  }
  
  public function isExpired()
  {
    return ( time() > $this->getExpiresAt(null));
  }
  
  public function isExpiredLogin()
  {
    return ( time() > $this->getLoginExpiresAt(null));
  }
}
