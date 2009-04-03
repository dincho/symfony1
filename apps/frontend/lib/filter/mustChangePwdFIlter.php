<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Sep 27, 2008 9:16:46 PM
 * 
 */
class mustChangePwdFilter extends sfFilter
{
    public function execute($filterChain)
    {
        if ($this->isFirstCall())
        {
            $context = $this->getContext();
            $module = $context->getModuleName();
            $action = $context->getActionName();
            $user = $context->getUser();
            $password_action = $this->getParameter('password_action');
            
            if ( $user->getAttribute('status_id') != MemberStatusPeer::ABANDONED && $user->isAuthenticated() && $user->getAttribute('must_change_pwd') && ($module . '/' . $action != $password_action) )
            {
                $AI = $context->getActionStack()->getLastEntry()->getActionInstance();
                
                $AI->setFlash('msg_error', 'You must change your password!');
                $AI->redirect($password_action);

            }
        }
        $filterChain->execute();
    }
}

