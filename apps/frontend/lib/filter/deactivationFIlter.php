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

    static private $skip_actions = array('content/message', 'content/page', 'profile/signIn', 
                                         'profile/signout', 'memberStories/index', 'memberStories/read', 'dashboard/deactivate',
                                         'dashboard/deleteYourAccount', 'subscription/index');

    public function execute($filterChain)
    {
  
        $context = $this->getContext();
        $user = $context->getUser();
        $module = $context->getModuleName();
        $action = $context->getActionName();
        $module_action = $module . '/' . $action;

        sfLogger::GetInstance()->info('module/action - ' . $module_action);
         
        if ($this->isFirstCall() && $user->isAuthenticated() && $user->getAttribute('status_id') == MemberStatusPeer::ACTIVE &&
            $user->getAttribute('is_free') && !in_array($module_action, self::$skip_actions) && $module != 'ajax')
        {
            

            if( $user->getAttribute('deactivation_counter') > sfConfig::get('app_settings_deactivation_counter'))
            {
              sfLogger::getInstance()->info('jail user');              
              $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
              $AI->message('close_or_upgrade_registration');
            }                
        }
        $filterChain->execute();
    }
}

