<?php

/**
 * system actions.
 *
 * @package    pr
 * @subpackage system
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class systemActions extends prActions
{ 
  public function executeSecure()
  {
      $this->setLayout('system');
  }
  
  public function executePageNotFound()
  {
      $this->setLayout('system');
  }
  
  public function executeDisabled()
  {
      $this->setLayout('system');
  }
  
  public function executeUnavailable()
  {
      $this->setLayout('system');
  }
}
