<?php

/**
 * system actions.
 *
 * @package    pr
 * @subpackage system
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class systemActions extends sfActions
{
  public function executeIndex()
  {
  }
  
  public function executeLogin()
  {
    if( $this->getRequest()->getMethod() != sfRequest::POST )
    {
      if( $this->getUser()->isAuthenticated() )
      {
        if( $this->getUser()->hasCredential(array('member'), false) ) $this->executeLogout();
        $this->redirect('@homepage');
      }
      
      //helps to redirect to requested page
      $referer_rel = $_SERVER["REQUEST_URI"];
      $referer_abs = "http://" . $_SERVER["HTTP_HOST"] . $referer_rel;
      
      $this->getRequest()->setAttribute('referer', $referer_abs);
      
    } else {
      $logged = UserPeer::retrieveByUsername($this->getRequestParameter('username'));
      
      $this->getUser()->signIn($logged);
      $logged->setLastLogin(time());
      $logged->save();
      
      //$user->setCulture($logged->getCulture());
      $this->redirectToReferer();
    }
  }
  
  public function validateLogin()
  {
    if( $this->getRequest()->getMethod() == sfRequest::POST )
    {
      $username = $this->getRequestParameter('username');
      //$password = sha1($this->getRequestParameter('password'));
      $password = sha1( SALT . $this->getRequestParameter('password') . SALT );
  
      $c = new Criteria();
      $c->add(UserPeer::USERNAME, $username);
      $c->add(UserPeer::PASSWORD, $password);
      $c->add(UserPeer::IS_ENABLED, true);
      $c->setLimit(1);
  
      $logged = UserPeer::doSelectOne($c);
      
      if (!$logged)
      {
        $this->getRequest()->setError('login', 'Invalid username/password');
        return false;
      }
    }
    return true;
  }
  
  public function handleErrorLogin()
  {
    return sfView::SUCCESS;
  }
  
  public function executeLogout()
  {
    $user = $this->getUser();
    $user->getAttributeHolder()->clear();
    $user->clearCredentials();
    $user->setAuthenticated(false);
    $this->setFlash('msg', 'You have been logged out.');
    $this->redirect('system/login');
  }
  
  protected function redirectToReferer()
  {
    $referer = $this->getRequestParameter('referer');
    $host    = $this->getRequest()->getHost();
    
    if( false !== strpos($referer, $host) )
    {
      $this->redirect( $referer );
    }
    else
    {
      $this->redirect( '@homepage' );
    }
  }

  public function executeSecure()
  {
    
  }
  
  public function executeTest()
  {
    
  }
  
  public function executeClearCache()
  {
	$this->getUser()->checkPerm(array('content_edit'));
	
	//clear the cache
	$sf_root_cache_dir = sfConfig::get('sf_root_cache_dir');
	$cache_dir = $sf_root_cache_dir.'/frontend/*/i18n/';
	sfToolkit::clearGlob($cache_dir);
	
	$this->setFlash('msg_ok', 'Frontend i18n cache has been removed');
	$this->redirect($this->getUser()->getRefererUrl());
	
  }
}
