<?php
/**
 * 
 * @author Vencislav Vidov
 * @version 1.0
 * @created Feb 15, 2011 
 * 
 */
class FVrequiredFilter extends sfFilter
{
    static private $skip_actions = array('content/message', 'editProfile/photoAuthenticity', 'content/page', 'profile/signIn', 'profile/signout');

    public function execute($filterChain)
    {
        $context = $this->getContext();
        $user = $context->getUser();
        $module = $context->getModuleName();
        $action = $context->getActionName();
        $module_action = $module . '/' . $action;

//        sfLogger::GetInstance()->info('FVrequiredFilter: module/action - ' . $module_action . ', member: ' . $user->getUsername());
         
        if ($user->isAuthenticated() && $user->getAttribute('status_id') == MemberStatusPeer::FV_REQUIRED && 
            !in_array($module_action, self::$skip_actions) && $module != 'ajax' )
        {
//            sfLogger::getInstance()->info('FVrequiredFilter: jailing member - ' . $user->getUsername());
            $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
            $AI->message('photo_verification_required');
            $AI->redirect('@verify_photo');
        }
        $filterChain->execute();
    }
}

