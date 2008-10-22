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
  
  public function executeSecure()
  {
      
  }
  
  public function executePageNotFound()
  {
      $this->setLayout('system');
      $this->header_title = 'Oops, Page Not Found';
  }
}
