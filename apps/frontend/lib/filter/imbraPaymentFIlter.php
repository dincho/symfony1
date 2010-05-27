<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Sep 27, 2008 9:16:46 PM
 * 
 */
class imbraPaymentFilter extends sfFilter
{

    static private $skip_actions = array('content/message', 'content/page', 'profile/signIn', 'profile/signout');
    
    public function execute($filterChain)
    {
        $context = $this->getContext();
        $user = $context->getUser();
        if ( !sfConfig::get('app_settings_imbra_disable') && $this->isFirstCall() && $user->isAuthenticated())
        {
            $module = $context->getModuleName();
            $action = $context->getActionName();
            $module_action = $module . '/' . $action;

            if ( $user->isAuthenticated() && 
                !in_array($module_action, self::$skip_actions) && 
                $module != 'ajax' && 
                $module != 'registration' && 
                $module != 'IMBRA' &&
                $user->getProfile()->mustPayIMBRA())
            {
	            $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
	            $AI->redirect('IMBRA/payment');
            }
        }
        $filterChain->execute();
    }
}

