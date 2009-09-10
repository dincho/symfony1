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
        $member = MemberPeer::retrieveByUsernameJoinAll($this->getRequestParameter('username'));
        $this->forward404Unless($member || $member->getStatusId() != MemberStatusPeer::ACTIVE);
        
        $title = $this->getContext()->getI18N()->__("%USERNAME%'s profile", array('%USERNAME%' => $member->getUsername()));
        $this->getResponse()->setTitle($title);
        
        $c = new Criteria;
        $c->add(MemberPeer::ID, $member->getId(), Criteria::GREATER_THAN);
        $c->adD(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
        $this->next_member = MemberPeer::doSelectOne($c);
        
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssocById();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($member->getId());
        $this->member = $member;
    }

    public function executeIndex()
    {
        $this->current_culture = ($this->getUser()->getCulture() == 'pl') ? 'pl' : 'en';
        $key =  sfConfig::get('app_gmaps_key_' . str_replace('.', '_', $this->getRequest()->getHost()));
        $this->getResponse()->addJavascript('http://maps.google.com/maps?file=api&v=2&key=' . $key);
        
        $member = MemberPeer::retrieveByUsernameJoinAll($this->getRequestParameter('username'));
        $this->forward404Unless($member);
        
        //secure action for non-admins
        $admin_hash = sha1(sfConfig::get('app_admin_user_hash') . $member->getUsername() . sfConfig::get('app_admin_user_hash'));                                  
        $this->forwardIf(!$this->getUser()->isAuthenticated() && $this->getRequestParameter('admin_hash') != $admin_hash, sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
                    
        
        if( $this->getRequestParameter('admin_hash') != $admin_hash && $this->getUser()->getId() != $member->getId() )
        {
          $member_status_id = $member->getMemberStatusId();
          if( $member_status_id != MemberStatusPeer::ACTIVE )
          {
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
              
              $this->redirect('@dashboard');
          }
          
          //privacy
          $prPrivavyValidator = new prPrivacyValidator();
          $prPrivavyValidator->setProfiles($this->getUser()->getProfile(), $member);
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
        }
        
        //add a visit
        $this->getUser()->viewProfile($member);

        if( $this->getUser()->getId() == $member->getId() && !$this->hasFlash('msg_ok') ) 
        {
          $this->setFlash('msg_ok', 'To edit your profile, go to self-description, posting/essay or photos on your dashboard.', false); 
        }
        
        //@TODO recent conversatoions - this need refactoring and move to the model
        $c = new Criteria();
        $crit = $c->getNewCriterion(MessagePeer::TO_MEMBER_ID, $member->getId());
        $crit->addAnd($c->getNewCriterion(MessagePeer::FROM_MEMBER_ID, $this->getUser()->getId()));
        $crit->addAnd($c->getNewCriterion(MessagePeer::SENT_BOX, true));
        
        $crit2 = $c->getNewCriterion(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId());
        $crit2->addAnd($c->getNewCriterion(MessagePeer::FROM_MEMBER_ID, $member->getId()));
        $crit2->addAnd($c->getNewCriterion(MessagePeer::SENT_BOX, false));
        
        $c->add($crit);
        $c->addOr($crit2);
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->setLimit(sfConfig::get('app_settings_profile_num_recent_messages'));
        $this->recent_conversations = MessagePeer::doSelect($c);

        $c = new Criteria();
        $c->add(MemberMatchPeer::MEMBER1_ID, $this->getUser()->getId());
        $c->add(MemberMatchPeer::MEMBER2_ID, $member->getId());
        $c->setLimit(1);
        $this->match = MemberMatchPeer::doSelectOne($c);
        
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssocById();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($member->getId());
        $this->member = $member;
        
        //IMBRA
        $this->imbra = $member->getLastImbra($approved = true);
        if ($this->imbra)
        {
            $imbra_culture =  ($this->getUser()->getCulture() == 'pl') ? 'pl' : 'en';
            $this->imbra->setCulture($imbra_culture);
            $this->imbra_questions = ImbraQuestionPeer::doSelectWithI18n(new Criteria());
            $this->imbra_answers = $this->imbra->getImbraAnswersArray();
        }
                    
        $this->profile_pager = new ProfilePager($member->getUsername());

        $bc = $this->getUser()->getBC();
        $bc->replaceFirst(array('name' => 'Dashboard', 'uri' => '@dashboard'));
        
        switch ($this->getRequestParameter('bc')) {
          case 'search':
            $bc->add(array('name' => 'Search', 'uri' => '@matches'));
            break;
          case 'messages':
            $bc->add(array('name' => 'Messages', 'uri' => 'messages/index'));
            break;
          case 'winks':
            $bc->add(array('name' => 'Winks', 'uri' => '@winks'));
            break;
          case 'hotlist':
            $bc->add(array('name' => 'Hotlist', 'uri' => '@hotlist'));
            break;
          case 'visitors':
            $bc->add(array('name' => 'Visitors', 'uri' => '@visitors'));
            break;          
          case 'blocked':
            $bc->add(array('name' => 'Blocked Members', 'uri' => '@blocked_members'));
            break;
          default:
            break;
        }
        
        if( $member->getUsername() == $this->getUser()->getUsername() ) //looking myself
        {
          $bc->setCustomLastItem(__('Profile'));
        } else {
          $bc->setCustomLastItem(__("%USERNAME%'s profile", array('%USERNAME%' => $member->getUsername())));
        }
        
        $bc->add(array('name' =>  $member->getUsername() . ',  ' . $member->getAge() . ': ' . $member->getEssayHeadline()));
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

        /* 
          don't force pending and abandoned members to change passwords 
          to prevent redirect loop since forcing so will jail them to the 
          editProfile/registration witch is not accesable for these statuses
        */
        if( !in_array($member->getMemberStatusId(), array(MemberStatusPeer::PENDING, MemberStatusPeer::ABANDONED)) )
        {
          $member->setPassword($member->getNewPassword(), false);
          $member->setNewPassword(NULL, false);
          $member->setMustChangePwd(true);
          $member->save();
        }
        
        $this->getUser()->SignIn($member);
        $this->redirect('dashboard/index');
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
        
        $this->message('undo_new_email');
    }
    
    public function executeMyProfile()
    {
        $this->getRequest()->setParameter('username', $this->getUser()->getUsername());
        $this->getUser()->getBC()->clear()->add(array('name' => 'Dashboard', 'uri' => '@dashboard'));
        $this->forward('profile', 'index');
    }
}
