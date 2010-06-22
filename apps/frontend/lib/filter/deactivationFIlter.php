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

    static private $skip_actions = array('content/message', 'content/page', 
                                         'profile/signout', 'memberStories/index', 'memberStories/read', 'dashboard/deactivate',
                                         'dashboard/deleteYourAccount');

    public function execute($filterChain)
    {
        $context = $this->getContext();
        $user = $context->getUser();
        $module = $context->getModuleName();
        $action = $context->getActionName();
        $module_action = $module . '/' . $action;

        sfLogger::GetInstance()->info('deactivationFilter: module/action - ' . $module_action . ', member: ' . $user->getUsername());
         
        if ($this->isFirstCall() && $user->isAuthenticated() && $user->getAttribute('status_id') == MemberStatusPeer::ACTIVE &&
            $user->getAttribute('is_free') && !in_array($module_action, self::$skip_actions) && $module != 'ajax' && $module != 'subscription')
        {
            if( $user->getAttribute('deactivation_counter') > sfConfig::get('app_settings_deactivation_counter'))
            {
              sfLogger::getInstance()->info('deactivationFilter: jailing member - ' . $user->getUsername());
              $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
              $AI->message('close_or_upgrade_registration');
            }                
        }
        $filterChain->execute();
    }
}

