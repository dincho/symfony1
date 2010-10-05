<?php
class myUser extends sfBasicSecurityUser
{
    private $profile = null;
    private $catalog = null;

    public function getId()
    {
        return $this->getAttribute('member_id');
    }

    public function getUsername()
    {
        return $this->getAttribute('username');
    }

    public function getBC()
    {
        return prFrontendBreadCrumb::getInstance();
    }

    /**
     * Get User`s profile
     *
     * @return Member
     */
    public function getProfile()
    {
        if(is_null($this->profile))
        {
            $this->profile = MemberPeer::retrieveByPk($this->getId());
        }
        return $this->profile;
    }

    public function SignIn($member)
    {
        $this->getAttributeHolder()->clear();
        $this->clearCredentials();
          
        $this->setAuthenticated(true);
        $this->addCredential('member');
        $this->setAttribute('username', $member->getUsername());
        $this->setAttribute('email', $member->getEmail());
        $this->setAttribute('member_id', $member->getId());
        $this->setAttribute('status_id', $member->getMemberStatusId());
        $this->setAttribute('must_change_pwd', $member->getMustChangePwd());
        
         //just for optimizations, we don't deactivate paid members at all..
        if( $member->isFree() )
        {
            $member->incCounter('DeactivationCounter');
            $this->setAttribute('deactivation_counter', $member->getCounter('DeactivationCounter'));
            $this->setAttribute('is_free', true);
        }
        
        if( $member->getMemberStatusId() == MemberStatusPeer::ABANDONED ) $this->setAttribute('must_confirm_email', !$member->getHasEmailConfirmation());
        
        //login history
        $history = new MemberLoginHistory();
        $history->setMemberId($member->getId());
        $history->setLastLogin($member->getLastLogin());
        $history->save();
                
        $member->setLastIp(ip2long($_SERVER ['REMOTE_ADDR']));
        $member->setLastLogin(time());
        $member->save();
        
        //clear old session zombies
        if(SF_ENVIRONMENT != 'dev')  $member->clearDroppedSessions(session_id());
    }

    public function SignOut()
    {
        $this->getAttributeHolder()->clear();
        $this->clearCredentials();
        $this->setAuthenticated(false);
    }

    public function getRefererUrl()
    {
        $request = sfContext::getInstance()->getRequest();
        if ($request->getParameter('return_url')) return base64_decode(strtr($request->getParameter('return_url'), '-_,', '+/='));
        
        $stack = $this->getAttributeHolder()->getAll('frontend/member/referer_stack');
        return isset($stack [1]) ? $stack [1] : '@homepage';
    }

    public function completeRegistration()
    {
        $member = $this->getProfile();
        $action = sfContext::getInstance()->getActionStack()->getLastEntry()->getActionInstance();
        
        if($member->getMemberStatusId() == MemberStatusPeer::ABANDONED)
        {
            if($member->mustFillIMBRA())
            {
                $action->redirect('IMBRA/index');
            } elseif($member->mustPayIMBRA())
            {
                $action->redirect('IMBRA/payment');
            } else
            {
                if($member->getSubscriptionDetails()->getPreApprove())
                {
                    $member->changeStatus(MemberStatusPeer::PENDING, false);
                } else
                {
                    $member->changeStatus(MemberStatusPeer::ACTIVE, false);
                    Events::triggerWelcome($member, $_SERVER['REMOTE_ADDR']);
                }
                
                $member->save();
                $this->setAttribute('status_id', $member->getMemberStatusId());

                //show congratulation message only if pre approve is OFF
                if( $member->getSubscriptionDetails()->getPreApprove() ) 
                {
                  $action->message('status_pending');
                } else {
                  $action->setFlash('msg_ok', 'Congratulations, your registration is complete.');
                  $action->redirect('@my_profile');
                }
                
            }
        }
    }

    public function viewProfile($profile)
    {
        if($this->getId() != $profile->getId()) //not looking himself and not already been here
        {
            if($this->isAuthenticated())
            {
                $c = new Criteria();
                $c->add(ProfileViewPeer::MEMBER_ID, $this->getId());
                $c->add(ProfileViewPeer::PROFILE_ID, $profile->getId());
                
                $already_visit = ProfileViewPeer::doSelectOne($c);
                if($already_visit)
                {
                    $already_visit->setUpdatedAt(time());
                    $already_visit->save();
                } else
                {
                    $visit = new ProfileView();
                    $visit->setMemberRelatedByMemberId($this->getProfile());
                    $visit->setMemberRelatedByProfileId($profile);
                    $visit->save();
                    
                    if ( !$this->getProfile()->getPrivateDating() || 
                         $this->getProfile()->hasOpenPrivacyFor($profile->getId()) )
                    {
                      MemberNotificationPeer::addVisit($profile, $this->getProfile());
                      
                      if( $profile->getEmailNotifications() === 0 ) Events::triggerAccountActivityVisitor($profile, $this->getProfile());
                    }

                }
                
            } else
            {
                $profile->incCounter('ProfileViews');
            }
        }
    }
    
    public function getLocale()
    {
       return ($this->getCulture() == 'en') ? 'en_US.utf8' : $this->getCulture().'_'.strtoupper($this->getCulture()).'.utf8';
    }
    
    public function getCatalog()
    {
        if( is_null($this->catalog) )
        {
            $domain = strtolower($_SERVER['HTTP_HOST']);
            $catalog_domain = sfConfig::get('app_catalog_domains_' . $domain, $domain);

            $c = new Criteria();
            $c->add(CataloguePeer::DOMAIN, $catalog_domain);
            $c->add(CataloguePeer::TARGET_LANG, $this->getCulture());
            $this->catalog = CataloguePeer::doSelectOne($c);
        }
        
        return $this->catalog;
    }
    
    public function getCatalogId()
    {
        return ($this->getCatalog()) ? $this->getCatalog()->getCatId() : null;
    }
}
