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
        $this->member = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($this->member);
        
        $this->getResponse()->addJavascript('http://maps.googleapis.com/maps/api/js?sensor=false');
        
        $this->getUser()->getBC()->clear();
        
        $title_prefix = sfConfig::get('app_title_prefix_' . str_replace('.', '_', $this->getRequest()->getHost()));
        
        if( $this->getUser()->getCulture() == 'en' )
        {
            $title = sprintf('%s %s %s - %s, %d: %s',
                            $title_prefix,
                            format_language($this->member->getLanguage()), __($this->member->getOrientationString()), 
                            $this->member->getUsername(), $this->member->getAge(), $this->member->getEssayHeadline());
        } else {
            $title = sprintf('%s %s - %s, %d: %s',
                $title_prefix,
                __($this->member->getOrientationString()), 
                $this->member->getUsername(), $this->member->getAge(), $this->member->getEssayHeadline());
        }
                       
        $this->getResponse()->setTitle($title);
        $this->getResponse()->addMeta('description', Tools::truncate($this->member->getEssayIntroduction(), 150, ''));

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
        $user = $this->getUser();
        $bc = $user->getBC();
        
        $error = null;
        
        if( !$this->is_admin )
        {
            if( $user->isAuthenticated() && $user->getId() == $this->member->getId() ) $this->redirect('profile/myProfile');
            
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
                        $error = 'Sorry, this profile has been suspended';
                    break;
                    case MemberStatusPeer::SUSPENDED_FLAGS:
                        $error = 'Sorry, this profile has been suspended';
                    break;
                    case MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED:
                        $error = 'Sorry, this profile has been canceled';
                    break;
                    case MemberStatusPeer::CANCELED:
                        $error = 'Sorry, this profile has been canceled';
                    break;
                    case MemberStatusPeer::CANCELED_BY_MEMBER:
                        $error = 'Sorry, this profile has been canceled by its owner';
                    break;
                    case MemberStatusPeer::DEACTIVATED:
                        $error = 'Sorry, this profile has been deactivated by its owner';
                    break;
                    case MemberStatusPeer::DEACTIVATED_AUTO:
                        $error = 'Sorry, this profile has been deactivated';
                    break;                    
                    case MemberStatusPeer::FV_REQUIRED:
                        $error = 'Sorry, this profile is being verified';
                    break;                    

                    default:
                    break;
                }
            }
            
            if( $user->isAuthenticated() )
            {
                 //if viewer is logged in and member is active ( no status error already )
                 //we need to check the privacy too
                if( $this->member->isActive() )
                {
                    //privacy
                    $prPrivavyValidator = new prPrivacyValidator();
                    $prPrivavyValidator->setProfiles($this->getUser()->getProfile(), $this->member);
                    $prPrivavyValidator->initialize($this->getContext(), array(
                    'sex_error' => 'Due to privacy restrictions you cannot see this profile',
                    'open_privacy_error' => 'Due to privacy restrictions you cannot see this profile',
                    'check_onlyfull' => false,
                    ));

                    $prPrivavyValidator->execute($value, $error);
                }
                
                if( !$error )
                {
                    $this->getUser()->viewProfile($this->member);
                    $this->match = MemberMatchPeer::getMatch(
                        $this->getUser()->getProfile(),
                        $this->member
                    );
                    
                    //unread messages flash message
                    $unread_c = new Criteria();
                    $unread_c->add(MessagePeer::SENDER_ID, $this->member->getId());
                    $c = $this->getUser()->getProfile()->getUnreadMessagesCriteria($unread_c);
                    $unread_msg_cnt = MessagePeer::doCount($c);
                    $msgThread = ThreadPeer::getOldThread($this->getUser()->getProfile(), $this->member);
                    
                    if( $unread_msg_cnt > 0 )
                    {
                      $msg = __('You have %CNT_UNREAD% unread message(s) from %USERNAME%', 
                                          array(
                                              '%USERNAME%' => $this->member->getUsername(),
                                              '%CNT_UNREAD%' => $unread_msg_cnt,
                                              '%THREAD_URL%' => $this->getController()->genUrl('messages/thread?id=' . $msgThread->getId(), true)
                                             
                                          ));
                      $this->setFlash('msg_ok', $msg, false);
                    }
                    
                    $this->messageThread = $msgThread;
                    
                } else {
                    $this->setTemplate('unavailableProfile');
                    $this->setFlash('msg_error', $error, false);
                }
                
                //we need profile pager and correct BC regardless of the error, 
                //since we just show an unavailable profile template
                if ($this->getRequest()->hasParameter('page')) {
                    $profile = $this->getUser()->getProfile();
                    $this->profile_pager = new FrontendProfilePager($profile->getId());
                    $this->profile_pager->setPage($this->getRequestParameter('page'));
                    
                    if (sfConfig::get('app_settings_man_should_pay') 
                        && $profile->isFree()
                        && $profile->getSex() == 'M' 
                        && $profile->getLookingFor() == 'F'
                    ) {
                        $this->profile_pager->setMaxRecordLimit(600);
                    }

                    $this->profile_pager->init();
                } else {
                    $this->profile_pager = null;
                }

                $this->grant_private_photos_perm = $this->getUser()->getProfile()->hasGrantPrivatePhotosPermsFor($this->member);
                $this->private_photos_perm = $this->getUser()->getProfile()->hasPrivatePhotosPermsFor($this->member);
                $this->private_photos_request = $this->getUser()->getProfile()->hasPrivatePhotoRequestTo($this->member);
                
                if($this->getUser()->getProfile()->getPrivateDating()){
                  $this->has_privacy_perm = $this->getUser()->getProfile()->hasGrantedOpenPrivacyPermsFor($this->member); 
                }
                $this->show_request_warning = 
                  ($this->getUser()->getProfile()->getNumberOfTodaysPrivatePhotoRequest() >=  
                    sfConfig::get('app_settings_private_photo_requests', 5))?true:false;

                $this->request_warning =__('You already have %REQUESTS_NUMBER% private photo requests today.', 
                    array('%REQUESTS_NUMBER%' => sfConfig::get('app_settings_private_photo_requests', 5)));
                
                sfContext::getInstance()->getLogger()->info('$this->show_request_warning =' . $this->show_request_warning);

                $this->rate = $this->member->getMemberRateWith($this->getUser()->getProfile());
                $this->has_old_threads = (bool) ThreadPeer::countOldthreads($this->getUser()->getProfile(), $this->member);

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
                  case 'photoAccess':
                    $bc->add(array('name' => 'Photo Access', 'uri' => '@photo_access'));
                    $this->getUser()->getProfile()->markOldProtoFrom($this->member);
                    break;
                  case 'whoCanSeeYou':
                    $bc->add(array('name' => 'Who Can See You', 'uri' => '@who_can_see_you'));
                    break;
                  default:
                    break;
                }
                                    
            } else { //public visit
                if( !$this->member->isActive() || $this->member->getPrivateDating()) $this->forward404();

                if( !$this->hasFlash('msg_ok') ){                
                  $this->setFlash('msg_ok', 'Sign in to see photo and more profile informmation', false);
                }
                $this->setTemplate('publicProfile');
            }
        } else { //viewer is admin
            $this->setTemplate('simpleProfile');
        }
        
        $bc->setCustomLastItem(__("%USERNAME%'s profile", array('%USERNAME%' => $this->member->getUsername())));
        $this->profilePostExecute();
    }
    
    public function profilePostExecute()
    {
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
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'Sign In', 'uri' => '@signin'));
        
        if ( $this->getRequest()->getMethod() == sfRequest::POST 
             && $this->hasRequestParameter('email') && $this->hasRequestParameter('password'))
        {
            $email = $this->getRequestParameter('email');
            $password = sha1(SALT . $this->getRequestParameter('password') . SALT);
            $c = new Criteria();
            $c->add(MemberPeer::EMAIL, $email);
            $c->add(MemberPeer::PASSWORD, $password);
            $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::CANCELED_BY_MEMBER, Criteria::NOT_EQUAL);
            $c->addJoin(MemberPeer::CATALOG_ID, CataloguePeer::CAT_ID, Criteria::LEFT_JOIN);
            
            $crit = $c->getNewCriterion(CataloguePeer::CAT_ID, $this->getUser()->getCatalogId());
            $crit->addOr($c->getNewCriterion(CataloguePeer::SHARED_CATALOGS, $this->getUser()->getCatalogId() . ' IN ('.CataloguePeer::SHARED_CATALOGS.')', Criteria::CUSTOM));
            $c->add($crit);
            
            $c->setLimit(1);
            $member = MemberPeer::doSelectOne($c);
            
            if (!$member)
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
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Home', 'uri' => '@homepage'))->addBeforeLast(array('name' => 'Sign In', 'uri' => '@signin'));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $c = new Criteria();
            $c->add(MemberPeer::EMAIL, $this->getRequestParameter('email'));
            $c->add(MemberPeer::MEMBER_STATUS_ID, array(MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED, MemberStatusPeer::SUSPENDED_FLAGS, MemberStatusPeer::SUSPENDED,MemberStatusPeer::CANCELED, MemberStatusPeer::CANCELED_BY_MEMBER), Criteria::NOT_IN);
            $c->setLimit(1);
            $member = MemberPeer::doSelectOne($c);
            
            if ( $member )
            {
                Events::triggerForgotPassword($member);
            }
            
            $this->redirect('@forgotten_password_info');
        }
    }

    public function handleErrorForgotYourPassword()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Home', 'uri' => '@homepage'))->addBeforeLast(array('name' => 'Sign In', 'uri' => '@signin'));
        return sfView::SUCCESS;
    }

    public function executeForgotPasswordInfo()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Home', 'uri' => '@homepage'))->
        replaceLast(array('name' => 'Sign In', 'uri' => '@signin'))->
        add(array('name' => 'Forgot password info headline', '@forgotten_password_confirm'));
    }

    public function executeForgotPasswordConfirm()
    {
        $member = $this->getUser()->getProfile();
        
        //force password change
        $this->getUser()->setAttribute('must_change_pwd', true);
        $member->setMustChangePwd(true);
        $member->save();
        
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
    
    public function executeFeed()
    {
        $request = $this->getRequest();
        $title_prefix =  sfConfig::get('app_title_prefix_' . str_replace('.', '_', $request->getHost()));
        
        $feed = sfFeed::newInstance('atom1');
        
        $feed->setTitle($title_prefix.'Profiles');
        $feed->setLink('http://'.$request->getHost().'/');
        $feed->setFeedUrl('@profiles_feed');

        $c = new Criteria;
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
        $c->add(MemberPeer::PRIVATE_DATING, false);
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        $c->setLimit(10);
        
        $members = MemberPeer::doSelect($c);

        foreach ($members as $member)
        {
            $item = new sfFeedItem();
            $item->setTitle($member->getEssayHeadline());
            $item->setLink('@public_profile?username=' . $member->getUsername());
            $item->setAuthorName($member->getUsername());
            $item->setPubdate($member->getCreatedAt('U'));
            $item->setUniqueId($this->getController()->genUrl('@public_profile?username=' . $member->getUsername(), true));
            $item->setDescription($member->getEssayIntroduction());

            $feed->addItem($item);
        }

        $this->feed = $feed;
    }

    public function executeRate()
    {
      $request = $this->getRequest();
      $member = MemberPeer::retrieveByPk($request->getParameter('id'));
      $rater = $this->getUser()->getProfile();
      $rate = min(round($request->getParameter('rate')), 5);
      
      if( !$member )
      {
        return $this->renderText(__("Wrong member ID!"));
      }

      $memberRate = $member->getMemberRateWith($rater, true);

      if( !$memberRate )
      {
          $memberRate = new MemberRate();
          $memberRate->setMemberRelatedByMemberId($member);
          $memberRate->setRaterId($rater->getId());
      }

      $memberRate->setRate($rate);
      
      $reverseRate = $rater->getMemberRateWith($member, true);
      
      if( $memberRate->isModified() )
      {
          //mutual rate
        if( $rate >= 4 && $reverseRate && $reverseRate->getRate() >= 4 )
        {
            if( $member->getEmailNotifications() === 0 ) Events::triggerAccountActivityMutualRate($member, $rater);
            if( $rater->getEmailNotifications() === 0 ) Events::triggerAccountActivityMutualRate($rater, $member);

        } elseif( $rate == 5 )
        {
          if( $member->getEmailNotifications() === 0 ) Events::triggerAccountActivityRate($member, $rater);
        }
          //we need to check some modified filed before saving this
          $memberRate->save();
      }
      
      $this->getResponse()->setHttpHeader("X-JSON", '('.json_encode(array('currentRate' => $rate)).')');
      return $this->renderText(__("You gave this member %NB% star", array('%NB%' => $rate)));
    }
    
    public function executeTogglePrivatePhotosPerm()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
        
        $perm = PrivatePhotoPermissionPeer::retrieveByPK($this->getUser()->getId(), $profile->getId(), 'P');
        if( ! $perm )
        {
            $perm = new PrivatePhotoPermission();
            $perm->setMemberRelatedByMemberId($this->getUser()->getProfile());
            $perm->setMemberRelatedByProfileId($profile);
            $perm->setType('P');
        }
        
        if($perm->getStatus() == 'A')
        { //revoke
            $perm->setStatus('R');
            $this->setFlash('msg_ok', 'Private photos permission revoked.', false);
        }
        else
        {// grant
            $perm->setStatus('A');
            $this->setFlash('msg_ok', 'Private photos permission granted.', false);
        }
        $perm->save();
        
        if( !$this->getRequest()->isXmlHttpRequest() ) $this->redirectToReferer();
        
        $this->perm = $perm;
        $this->profile = $profile;
    }
    
    public function validateTogglePrivatePhotosPerm()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
        
        $perm = PrivatePhotoPermissionPeer::retrieveByPK($this->getUser()->getId(), $profile->getId(), 'P');
        
        if( !$perm || $perm->getStatus() == 'R' ) //validate only granting
        {
            $member = $this->getUser()->getProfile();
            
            if( $member->countMemberPhotos() == 0 )
            {
                $this->getRequest()->setError('photo', 'You currently have no photos at all. Please upload some photos first.');
                return false;
            }
            
            
            if( $member->countPrivateMemberPhotos() == 0 )
            {
                $this->getRequest()->setError('photo', 'You currently have no private photos. You need to make some of your photos private.');
                return false;
            }
        }
        
        return true;
    }
    
    public function handleErrorTogglePrivatePhotosPerm()
    {
        sfLoader::loadHelpers(array('Partial'));
        
        return $this->renderText(get_partial('content/formErrors'));
    }    

    public function executeSendPrivatePhotosRequest()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
        
        sfContext::getInstance()->getLogger()->info('sendPrivatePhotosRequest()');

        $perm = PrivatePhotoPermissionPeer::retrieveByPK($this->getUser()->getId(), $profile->getId(), 'R');
        if( ! $perm )
        {
            $perm = new PrivatePhotoPermission();
            $perm->setMemberRelatedByMemberId($this->getUser()->getProfile());
            $perm->setMemberRelatedByProfileId($profile);
            $perm->setType('R');
            $perm->setStatus('R');
        }
        
        $this->setFlash('msg_ok', 'Private photos request sent.', false);
        $perm->save();
        
        if( !$this->getRequest()->isXmlHttpRequest() ) $this->redirectToReferer();
        
        $this->profile = $profile;
    }

    public function validateSendPrivatePhotosRequest()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
                              
        if( $this->getUser()->getProfile()->getNumberOfTodaysPrivatePhotoRequest() >=  
            sfConfig::get('app_settings_private_photo_requests', 5) ) //allow only 5 requests per day
        {
          $this->getRequest()->setError('photo', __('You already have %REQUESTS_NUMBER% private photo requests today.', 
              array('%REQUESTS_NUMBER%' => sfConfig::get('app_settings_private_photo_requests', 5))));
          return false;
        }
        
        return true;
    }

    public function handleErrorSendPrivatePhotosRequest()
    {
        sfLoader::loadHelpers(array('Partial'));
        
        return $this->renderText(get_partial('content/formErrors'));
    }    


}
