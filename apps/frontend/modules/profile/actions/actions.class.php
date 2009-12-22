<?php
/**
 * profile actions.
 *
 * @package    pr
 * @subpackage profile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class profileActions extends prActions
{

    public function executeIndexse()
    {
        $this->redirect('@public_profile?username=' . $this->getRequestParameter('username'));
    }

    
    protected function profilePreExecute()
    {
        $key =  sfConfig::get('app_gmaps_key_' . str_replace('.', '_', $this->getRequest()->getHost()));
        $this->getResponse()->addJavascript('http://maps.google.com/maps?file=api&v=2&key=' . $key);
        
        $this->member = MemberPeer::retrieveByUsernameJoinAll($this->getRequestParameter('username'));
        $this->forward404Unless($this->member);
        
        $this->getUser()->getBC()->clear();
    }
    
    
    public function executeMyProfile()
    {
        $this->getRequest()->setParameter('username', $this->getUser()->getUsername());
        
        $this->profilePreExecute();
        
        $this->getUser()->getBC()->add(array('name' => 'Dashboard', 'uri' => '@dashboard'));
        
        $this->profilePostExecute();
        
        if( !$this->hasFlash('msg_ok') ) $this->setFlash('msg_ok', 'To edit your profile, go to self-description, posting/essay or photos on your dashboard.', false);
        $this->getUser()->getBC()->setCustomLastItem(__('My Profile'));
        
        $this->setTemplate('simpleProfile');
    }
    
    public function executeIndex()
    {
        $this->profilePreExecute();
        
        $admin_hash = sha1(sfConfig::get('app_admin_user_hash') . $this->member->getUsername() . sfConfig::get('app_admin_user_hash'));
        $this->is_admin = ($this->getRequestParameter('admin_hash') == $admin_hash);
        $bc = $this->getUser()->getBC();
        
        if( !$this->is_admin )
        {
            if( $this->getUser()->isAuthenticated() && $this->getUser()->getId() == $this->member->getId() ) $this->redirect('profile/myProfile');
            
            //set correct error message if member is not active
            if( !$this->member->isActive() )
            {
                $member_status_id = $this->member->getMemberStatusId();
                
                $this->forward404If($member_status_id == MemberStatusPeer::ABANDONED ||
                      $member_status_id == MemberStatusPeer::PENDING ||
                      $member_status_id == MemberStatusPeer::DENIED
                      );

                switch ($member_status_id) {
                    case MemberStatusPeer::SUSPENDED:
                        $this->setFlash('msg_error', 'Sorry, this profile has been suspended');
                    break;
                    case MemberStatusPeer::SUSPENDED_FLAGS:
                        $this->setFlash('msg_error', 'Sorry, this profile has been suspended');
                    break;
                    case MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED:
                        $this->setFlash('msg_error', 'Sorry, this profile has been canceled');
                    break;
                    case MemberStatusPeer::CANCELED:
                        $this->setFlash('msg_error', 'Sorry, this profile has been canceled');
                    break;
                    case MemberStatusPeer::CANCELED_BY_MEMBER:
                        $this->setFlash('msg_error', 'Sorry, this profile has been canceled by its owner');
                    break;
                    case MemberStatusPeer::DEACTIVATED:
                        $this->setFlash('msg_error', 'Sorry, this profile has been deactivated by its owner');
                    break;

                    default:
                    break;
                }
            }
            
            if( $this->getUser()->isAuthenticated() )
            {
                if( !$this->member->isActive() ) $this->redirect('@dashboard');
                
                //privacy
                $prPrivavyValidator = new prPrivacyValidator();
                $prPrivavyValidator->setProfiles($this->getUser()->getProfile(), $this->member);
                $prPrivavyValidator->initialize($this->getContext(), array(
                'sex_error' => 'Due to privacy restrictions you cannot see this profile',
                'check_onlyfull' => false,
                ));

                $error = '';
                if( !$prPrivavyValidator->execute(&$value, &$error) )
                {
                    $this->setFlash('msg_error', $error);
                    $this->redirectToReferer();
                }
                
                $this->getUser()->viewProfile($this->member);
                $this->recent_conversations = $this->member->getRecentConversationWith($this->getUser()->getProfile());
                $this->match = $this->member->getMatchWith($this->getUser()->getProfile());
                $this->profile_pager = new ProfilePager($this->member->getUsername());
        
                //BC Setup below
                $bc->add(array('name' => 'Dashboard', 'uri' => '@dashboard'));
        
                switch ($this->getRequestParameter('bc')) {
                  case 'search':
                    $bc->add(array('name' => 'Search', 'uri' => '@matches'));
                    break;
                  case 'messages':
                    $bc->add(array('name' => 'Messages', 'uri' => 'messages/index'));
                    break;
                  case 'winks':
                    $bc->add(array('name' => 'Winks', 'uri' => '@winks'));
                    $this->getUser()->getProfile()->markOldWinksFrom($this->member);
                    break;
                  case 'hotlist':
                    $bc->add(array('name' => 'Hotlist', 'uri' => '@hotlist'));
                    $this->getUser()->getProfile()->markOldHotlistFrom($this->member);
                    break;
                  case 'visitors':
                    $bc->add(array('name' => 'Visitors', 'uri' => '@visitors'));
                    $this->getUser()->getProfile()->markOldViewsFrom($this->member);
                    break;          
                  case 'blocked':
                    $bc->add(array('name' => 'Blocked Members', 'uri' => '@blocked_members'));
                    break;
                  default:
                    break;
                }
                
            } else { //public visit
                if( !$this->member->isActive() ) $this->forward404();
                if( $this->member->getPrivateDating() )
                {
                    //$this->setFlash('msg_error', 'This profile is private.');
                    //$this->redirect('@homepage');
                    $this->forward404();
                }
                
                $this->setFlash('msg_ok', 'Sign in to see photo and more profile informmation', false);
                $this->setTemplate('publicProfile');
            }
        } else {
            $this->setTemplate('simpleProfile');
        }
        
        
        $bc->setCustomLastItem(__("%USERNAME%'s profile", array('%USERNAME%' => $this->member->getUsername())));
        $this->profilePostExecute();
    }
    
    public function profilePostExecute()
    {
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssocById();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
        
        //IMBRA
        if( !sfConfig::get('app_settings_imbra_disable') )
        {
          $this->imbra = $this->member->getLastImbra($approved = true);
          if ($this->imbra)
          {
              $imbra_culture =  ($this->getUser()->getCulture() == 'pl') ? 'pl' : 'en'; //we have only pl/en imbras
              $this->imbra->setCulture($imbra_culture);
              $this->imbra_questions = ImbraQuestionPeer::doSelectWithI18n(new Criteria());
              $this->imbra_answers = $this->imbra->getImbraAnswersArray();
          }
        }
        
        $this->getUser()->getBC()->add(array('name' =>  $this->member->getUsername() . ',  ' . $this->member->getAge() . ': ' . $this->member->getEssayHeadline()));
    }

    public function executeSignIn()
    {
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && $this->hasRequestParameter('email') && $this->hasRequestParameter('password'))
        {
            $member = MemberPeer::retrieveByEmail($this->getRequestParameter('email'));
            $this->forward404Unless($member);
            $this->getUser()->SignIn($member);

            $this->afterSignInRedirect();

        } elseif ($this->getUser()->isAuthenticated())
        {
           if (! $this->getUser()->hasCredential(array('member'), false)) $this->executeSignout();
           $this->redirect('@homepage');
        } else {
          $referer_rel = $_SERVER["REQUEST_URI"];
          $referer_abs = "http://" . $_SERVER["HTTP_HOST"] . $referer_rel;
          $this->getRequest()->setAttribute('referer', $referer_abs);
        }
    }
    
  
  protected function afterSignInRedirect()
  {
    $referer = $this->getRequestParameter('referer');
    $host    = $this->getRequest()->getHost();
    
    if( false !== strpos($referer, $host) )
    {
      $this->redirect( $referer );
    }
    else
    {
      $this->redirect( '@homepage' );
    }    
  }
  
    public function validateSignIn()
    {
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'Sign In', 'uri' => 'profile/signIn'));
        
        if ( $this->getRequest()->getMethod() == sfRequest::POST 
             && $this->hasRequestParameter('email') && $this->hasRequestParameter('password'))
        {
            $email = $this->getRequestParameter('email');
            $password = sha1(SALT . $this->getRequestParameter('password') . SALT);
            $c = new Criteria();
            $c->add(MemberPeer::EMAIL, $email);
            $c->add(MemberPeer::PASSWORD, $password);
            $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::CANCELED_BY_MEMBER, Criteria::NOT_EQUAL);
            $c->setLimit(1);
            $member = MemberPeer::doSelectOne($c);
            if (! $member)
            {
                $this->getRequest()->setError('login', 'Email and password do not match. Please try again.');
                $firstloginattempt = 1;
                if($this->getFlash("loginattempt"))
                {
                    if($this->getFlash("loginattempt")<4)
                    {
                        $this->setFlash("loginattempt", $this->getFlash("loginattempt")+1);
                    }
                    else
                    {
                        $c = new Criteria();
                        $c->add(MemberPeer::EMAIL, $email);
                        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::CANCELED_BY_MEMBER, Criteria::NOT_EQUAL);
                        $c->setLimit(1);
                        $member = MemberPeer::doSelectOne($c);
                        if($member)
                        {
                            $member->setMustChangePwd(1);
                            $member->save();
                        }
                        
                        $this->setFlash('msg_error', 'You unsuccessfully tried to log in too many times. Your account is blocked. Please reset your password to unblock it.');
                        $this->redirect('profile/forgotYourPassword');
                    }   
                }
                else
                {
                    $this->setFlash("loginattempt", $firstloginattempt);
                }
                
                return false;
            }
        }
        return true;
    }

    public function handleErrorSignIn()
    {
        return sfView::SUCCESS;
    }

    public function executeSignout()
    {
        $this->getUser()->signOut();

        $this->setFlash('msg_ok', 'Thanks for visiting, we hope you had a good time and we\'ll see you soon.');
        $this->redirect('profile/signIn');
    }

    public function executeForgotYourPassword()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Home', 'uri' => '@homepage'))->addBeforeLast(array('name' => 'Sign In', 'uri' => 'profile/signIn'));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            //$member = MemberPeer::retrieveByEmail($this->getRequestParameter('email'));
            $c = new Criteria();
            $c->add(MemberPeer::EMAIL, $this->getRequestParameter('email'));
            $c->add(MemberPeer::MEMBER_STATUS_ID, array(MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED, MemberStatusPeer::SUSPENDED_FLAGS, MemberStatusPeer::SUSPENDED,MemberStatusPeer::CANCELED, MemberStatusPeer::CANCELED_BY_MEMBER), Criteria::NOT_IN);
            $c->setLimit(1);
            $member = MemberPeer::doSelectOne($c);
            
            if ( $member )
            {
                //set temp pass
                $new_pass = Tools::generateString(8);
                $member->setNewPassword($new_pass);
                Events::triggerForgotPassword($member);
                $member->save();
            }
            
            $this->redirect('profile/forgotPasswordInfo');
        }
    }

    public function handleErrorForgotYourPassword()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Home', 'uri' => '@homepage'))->addBeforeLast(array('name' => 'Sign In', 'uri' => 'profile/signIn'));
        return sfView::SUCCESS;
    }

    public function executeForgotPasswordInfo()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Home', 'uri' => '@homepage'))->
        replaceLast(array('name' => 'Sign In', 'uri' => 'profile/signIn'))->
        add(array('name' => 'Forgot password info headline', 'profile/forgotPasswordConfirm'));
    }

    public function executeForgotPasswordConfirm()
    {
        $hash = $this->getRequestParameter('hash');
        $username = $this->getRequestParameter('username');
        $this->forward404Unless($hash && $username);
        
        $member = MemberPeer::retrieveByUsername($username);
        $this->forward404Unless($member);
        
        $pass_hash = sha1(SALT . $member->getNewPassword() . SALT);
        $this->forward404Unless($hash == $pass_hash);

        $member->setPassword($member->getNewPassword(), false);
        $member->setNewPassword(NULL, false);
        $member->setMustChangePwd(true);
        $member->save();
        
        $this->getUser()->SignIn($member);
        
        if( $member->isActive() ) //one redirect less if it's active ( do not apply the filter )
        {
          $this->redirect('editProfile/registration');
        } else {
          $this->redirect('dashboard/index'); //apply the status filter
        }
    }
    
    public function executeConfirmNewPassword()
    {
        $username = $this->getRequestParameter('username');
        $hash = $this->getRequestParameter('hash');
        $this->forward404Unless($username && $hash);
        
        $member = MemberPeer::retrieveByUsername($username);
        $this->forward404Unless($member);
        
        $this->forward404Unless($member->getNewPassword() == $hash);
        $member->setPassword($member->getNewPassword(), false);
        $member->setNewPassword(NULL, false);
        $member->save();
        $this->message('new_password_confirmed');
    }

    public function executeConfirmNewEmail()
    {
        $username = $this->getRequestParameter('username');
        $hash = $this->getRequestParameter('hash');
        $this->forward404Unless($username && $hash);
        
        $member = MemberPeer::retrieveByUsername($username);
        $this->forward404Unless($member);
        
        $tmp_email_hash = sha1(SALT . $member->getTmpEmail() . SALT);
        //$email_hash = sha1(SALT . $member->getEmail() . SALT);
        $this->forward404Unless($tmp_email_hash == $hash );
        

        $old_mail = $member->getEmail();
        $member->setEmail($member->getTmpEmail());
        $member->setTmpEmail($old_mail); //keep this for undo email change
        //$member->setConfirmedEmail(NULL); //clear the confirmation flag for future use 
        $member->save();
        
        Events::triggerNewEmailConfirmed($member);
        
        $this->message('email_verified');
    }
    
    public function executeUndoNewEmail()
    {
        $username = $this->getRequestParameter('username');
        $hash = $this->getRequestParameter('hash');
        $this->forward404Unless($username && $hash);
        
        $member = MemberPeer::retrieveByUsername($username);
        $this->forward404Unless($member);

        $emails_hash = sha1(SALT . $member->getEmail() . SALT . $member->getTmpEmail() . SALT);
        $this->forward404Unless($hash == $emails_hash);
        
        $tmp_email = $member->getEmail();
        $member->setEmail($member->getTmpEmail());
        $member->setTmpEmail($tmp_email);
        $member->save();
        
        $this->getUser()->SignIn($member);
        $this->message('undo_new_email');
    }

}
