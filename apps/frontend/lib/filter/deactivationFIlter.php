<?php
/**
 * 
 * @author Vencislav Vidov
 * @version 1.0
 * @created June 20, 2010 
 * 
 */
class deactivationFilter extends sfFilter
{

    public function execute($filterChain)
    {
      
        $context = $this->getContext();
        $user = $context->getUser();
        if ($this->isFirstCall() && $user->isAuthenticated())
        {
            
            sfLogger::getInstance()->info('User DeactivationCounter: ' . $user->getAttribute('deactivation_counter'));
            sfLogger::getInstance()->info('DeactivationCounter settings: ' . sfConfig::get('app_settings_deactivation_counter'));
            if( $user->getAttribute('deactivation_counter') > sfConfig::get('app_settings_deactivation_counter'))
            {
              //jail user
              sfLogger::getInstance()->info('jail user');              
              $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
              $AI->setFlash('msg_error', 'You must Upgrade or close your account!');
//              $AI->redirect('@dashboard');
            }                
        }
        $filterChain->execute();
    }
}

