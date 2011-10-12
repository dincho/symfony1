<?php

/**
 * callbacks actions.
 *
 * @package    PolishRomance
 * @subpackage callbacks
 * @author     Dincho Todorov <dincho at xbuv.com>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class callbacksActions extends sfActions
{

  public function executeZong()
  {   
      sfConfig::set('sf_web_debug', false);
      
      $zong = new sfZongPaymentCallback();
      $zong->initialize($this->getRequest(), $this->getRequestParams());
      $zong->handle();
      
      $this->getResponse()->setContentType('text/plain');
      $this->renderText(sprintf("%d:OK", $zong->getTransactionId()));
      
      return sfView::NONE;
  }
  
  public function executePaypal()
  {
        sfConfig::set('sf_web_debug', false);
      
        $ipn = new sfPaypalPaymentCallback();
        $ipn->initialize($this->getRequest(), $this->getRequestParams());
        $ipn->handle();

        return sfView::NONE;
  }
  
  public function getRequestParams()
  {
        $params_by_ref = $this->request->getParameterHolder()->getAll();
        
        //we don't need it by ref, beucase it's modified later.
        $params = array();
        foreach($params_by_ref as $key => $value ) $params[$key] = $value;
        
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        
        return $params;
  }
}
