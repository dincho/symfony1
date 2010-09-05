<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Nov 24, 2008 9:38:12 PM
 * 
 */
 
class prActions extends sfActions
{
    public function message($msg_tpl)
    {
        $this->setFlash('msg_tpl', $msg_tpl);
        $this->redirect('content/message');
    }
    
    public function redirectToReferer()
    {
        $this->redirect($this->getUser()->getRefererUrl());
    }
    
    public function redirectToLastReferer()
    {
        $stack = $this->getUser()->getAttributeHolder()->getAll('frontend/member/referer_stack');
        return isset($stack[0]) ? $stack[0] : null;        
    }
    
    public function warningTimeout()
    {
      $timeout_mins = sfConfig::get('sf_timeout')/60;
      
      $this->setFlash('warning_timeout', __('Please save this page within %TIMEOUT% minutes or your changes will be lost.', array('%TIMEOUT%' => $timeout_mins)));
    }

}
