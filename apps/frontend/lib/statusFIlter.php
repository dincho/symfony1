<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Sep 27, 2008 9:16:46 PM
 * 
 */
class statusFilter extends sfFilter
{

    static private $skip_actions = array('content/message', 'content/page', 'profile/signIn', 'profile/signout');
    
    public function execute($filterChain)
    {
        if ($this->isFirstCall())
        {
            $context = $this->getContext();
            $module = $context->getModuleName();
            $action = $context->getActionName();
            $user = $context->getUser();
            $module_action = $module . '/' . $action;

            //second condition is to bypass case constructor if status is active
            if ($user->isAuthenticated() && $user->getAttribute('status_id') != MemberStatusPeer::ACTIVE && 
                !in_array($module_action, self::$skip_actions) && $module != 'ajax')
            {
                $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
                switch ($user->getAttribute('status_id')) {
                    case MemberStatusPeer::ABANDONED:
                        if ( $module != 'registration' && $module != 'IMBRA' )
                        {
                            if( $user->getAttribute('must_confirm_email') ) $AI->redirect('registration/requestNewActivationEmail');
                            $AI->message('complete_registration');
                        }
                        break;
                    case MemberStatusPeer::CANCELED:
                        $AI->message('status_canceled');
                        break;
                    case MemberStatusPeer::SUSPENDED:
                        $AI->message('status_suspended');
                        break;
                    case MemberStatusPeer::SUSPENDED_FLAGS:
                    case MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED:
                        $AI->message('status_flagged');
                        break;
                    case MemberStatusPeer::PENDING:
                        $AI->message('status_pending');
                        break;
                    case MemberStatusPeer::DENIED:
                        $AI->message('status_denied');
                        break;
                    default:
                        break;
                }
            }
        }
        $filterChain->execute();
    }
}

