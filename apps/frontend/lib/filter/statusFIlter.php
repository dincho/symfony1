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

    static private $skip_actions = array('content/message', 'content/page', 'profile/signIn', 
                                         'profile/signout', 'memberStories/index', 'memberStories/read', 'dashboard/deactivate',
                                         'registration/movePhotoError', 'registration/confirmDeletePhoto', 'registration/deletePhoto', 'registration/ajaxPhotoHandler',
                                         'registration/uploadPhoto');
    
    public function execute($filterChain)
    {
      
        $context = $this->getContext();
        $user = $context->getUser();
        if ($this->isFirstCall() && $user->isAuthenticated())
        {
            
            $module = $context->getModuleName();
            $action = $context->getActionName();
            $module_action = $module . '/' . $action;
            $member = $user->getProfile();
           
            //second condition is to bypass case constructor if status is active
            if ($user->isAuthenticated() && $user->getAttribute('status_id') != MemberStatusPeer::ACTIVE && 
                !in_array($module_action, self::$skip_actions) && $module != 'ajax')
            {
                $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
                switch ($user->getAttribute('status_id')) {
                    case MemberStatusPeer::ABANDONED:
                      
                      if( $user->getAttribute('must_confirm_email') && 
                          $module_action != 'registration/requestNewActivationEmail' &&
                          $module_action != 'registration/activate')
                      {
                          $AI->redirect('registration/requestNewActivationEmail');
                      }
                      
                      
                      if ( $module != 'registration' && $module != 'IMBRA' )
                      {
                        
                          /*if( $member->getFirstName() && $member->getBirthDay() && $member->getEssayHeadline() 
                              && $member->countMemberPhotos() > 0 ) $user->completeRegistration();*/
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
                        $AI->message('status_flagged');
                        break;
                    case MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED:
                        $AI->message('status_canceled');
                        break;
                    case MemberStatusPeer::PENDING:
                        $AI->message('status_pending');
                        break;
                    case MemberStatusPeer::DENIED:
                        $AI->message('status_denied');
                        break;
                    case MemberStatusPeer::DEACTIVATED:
                    case MemberStatusPeer::DEACTIVATED_AUTO:
                        $AI->message('status_deactivated');
                        break;                        
                    default:
                        break;
                }
            }
        }
        $filterChain->execute();
    }
}

