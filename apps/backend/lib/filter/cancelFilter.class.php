<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Sep 22, 2008 10:44:43 AM
 * 
 */
 

class confirmMessageFilter extends sfFilter
{
    const OK = 1;
    const CANCEL = 2;
    const DELETE = 3;
    
  public function execute($filterChain)
  {
    // Execute this filter only once
    if ($this->isFirstCall())
    {
      $request = $this->getContext()->getRequest();
      $user    = $this->getContext()->getUser();
      $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
      
      $confirm_msg = $request->getParameter('confirm_msg');
      //$request->setParameter('confirm_msg', null);
      //how to clear this param ? try redirect ...
      
      switch ($confirm_msg)
      {
          case(self::OK):
              $AI->setFlash('msg_ok', 'Your changes has been saved.');
              break;
          
          case(self::CANCEL):
              $AI->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved.');
              break;
          
          case(self::DELETE):
              $AI->setFlash('msg_ok', 'Selected items has been deleted.');
              break;
              
          default:
              break;
      }
    }
 
    $filterChain->execute();
  }
}
