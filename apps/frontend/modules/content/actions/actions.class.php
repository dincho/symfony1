<?php
/**
 * content actions.
 *
 * @package    pr
 * @subpackage content
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class contentActions extends prActions
{
    public function executeSearchEngine()
    {
        $c = new Criteria;
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
        $c->add(MemberPeer::PRIVATE_DATING, false);
        $c->addAscendingOrderByColumn(MemberPeer::ID);
    
        $this->pager = new sfPropelPager('Member', 15);
    
        $this->pager->setCriteria($c);
        $this->pager->setPage($this->getRequestParameter('page', 1));
        $this->pager->init();
        
        if( $page = StaticPagePeer::getBySlug('search_engines') )
        {
            $this->getResponse()->setTitle($page->getTitle());
            $this->getResponse()->addMeta('description', $page->getDescription());
            $this->getResponse()->addMeta('keywords', $page->getKeywords());
        }
    }

    public function executeIndex()
    {
        if ($this->getUser()->isAuthenticated() && $this->getUser()->hasCredential(array('member'), false))
        {
            $this->redirect('dashboard/index');
        }
        
        $last_homepage_set = $this->getUser()->getAttribute('last_homepage_set', 3);
        $homepage_set = ( $last_homepage_set >= 3 ) ? 1 : $last_homepage_set + 1;
        $this->getUser()->setAttribute('last_homepage_set', $homepage_set);
        $this->homepage_set = $homepage_set;
                
        $this->getResponse()->setTitle('Homepage title');
        $this->getResponse()->addMeta('description', 'Homepage description');
        $this->getResponse()->addMeta('keywords', 'Homepage keywords');
        $this->setLayout('layout_index');
    }

    public function executeFlag()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $flag = new Flag();
            $flag->setFlagCategoryId($this->getRequestParameter('flag_category'));
            $flag->setComment($this->getRequestParameter('comment'));
            $flag->setMemberId($profile->getId());
            $flag->setFlaggerId($this->getUser()->getId());
            $flag->save();
            
            $counter = $profile->getMemberCounter();
            $counter->setCurrentFlags($counter->getCurrentFlags() + 1);
            $counter->setTotalFlags($counter->getTotalFlags() + 1);
            $counter->save();
            
            $profile->setLastFlagged(time());
            
            if ($counter->getCurrentFlags() == sfConfig::get('app_settings_flags_num_auto_suspension'))
            {
                $profile->changeStatus(MemberStatusPeer::SUSPENDED_FLAGS);
                $profile->save();
            } else
            {
                $profile->save();
            }
            
            if ($counter->getCurrentFlags() == sfConfig::get('app_settings_notification_scam_flags'))
                Events::triggerScamActivity($profile, $counter->getCurrentFlags());
            
            $this->getUser()->getProfile()->incCounter('SentFlags');
            
            $this->setFlash('msg_ok', 'Thanks for taking time to report the profile! We appreciate it.', false);
            return $this->renderText(get_partial('content/messages'));
        }
        
        $this->profile = $profile;
        $this->flag_categories = FlagCategoryPeer::doSelect(new Criteria());
        
        if( $this->getRequestParameter('layout') == 'window' )
        {
            sfConfig::set('sf_web_debug', false);
            $this->setLayout('window');
        }
    }

    public function validateFlag()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
        
        if ($this->getUser()->getId() == $profile->getId())
        {
            $this->setFlash('msg_error', 'You can\'t use this function on your own profile');
            return false;
        }
        if( $profile->IsFlaggedBy($this->getUser()->getId()) )
        {
            $this->setFlash('msg_error', 'You have already flagged this user');
            return false;        
        }

        
        return true;
    }

    public function handleErrorFlag()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
        $this->profile = $profile;

        if( $this->getRequestParameter('layout') == 'window' )
        {
            sfConfig::set('sf_web_debug', false);
            $this->setLayout('window');
        }
    }

    public function executePage()
    {
        $c = new Criteria();
        $c->add(StaticPageDomainPeer::CAT_ID, $this->getUser()->getCatalogId());
        $c->add(StaticPagePeer::SLUG, $this->getRequestParameter('slug'));
        $c->setLimit(1);
        $pages = StaticPageDomainPeer::doSelectJoinAll($c);
        $page = (isset($pages[0])) ? $pages[0] : null;
        $this->forward404Unless($page);

        $page->setContent(strtr($page->getContent(), $this->getContext()->getI18N()->getPredefinedHashes()));
        $this->page = $page;
        $this->getResponse()->setTitle($this->page->getTitle());
        $this->getResponse()->addMeta('description', $this->page->getDescription());
        $this->getResponse()->addMeta('keywords', $this->page->getKeywords());
        
        if( $page->getSlug() == 'best_videos_rules' )
        {
            $links_map = StaticPagePeer::getLinskMap($this->getUser()->getCatalogId());
            $bc_middle = array('name' => $links_map['best_videos'], 'uri' => '@page?slug=best_videos');
        } else {
            $bc_middle = ($this->getUser()->isAuthenticated()) ? array('name' => 'Dashboard', 'uri' => '@dashboard') : array('name' => 'Home', 'uri' => '@homepage');
        }

        $this->getUser()->getBC()->clear()->add($bc_middle);
    }

    public function executeMessage()
    {
        $this->redirectUnless($this->hasFlash('msg_tpl'), '@homepage');
        $this->getRequest()->setParameter('msg_tpl', $this->getFlash('msg_tpl')); //add because of the cache
        
        $this->setLayout('simple');
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'));
    }

    public function executeReportBug()
    {
        $bc_item = ($this->getUser()->isAuthenticated()) ? array('name' => 'Dashboard', 'uri' => '@dashboard') : array('name' => 'Home', 'uri' => '@homepage');
        $this->getUser()->getBC()->replaceFirst($bc_item);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member = $this->getUser()->getProfile();
            $desc = $this->getRequestParameter('description');
            $desc .= "\n\nTechnical Info\n--------------------------------\n" . $this->getRequestParameter('tech_info');
            $feedback = new Feedback();
            $feedback->setSubject($this->getRequestParameter('subject'));
            $feedback->setBody($desc);
            $feedback->setMailTo(FeedbackPeer::BUGS_SUGGESIONS_ADDRESS);
            $feedback->setMailFrom($member->getEmail());
            $feedback->setNameFrom($member->getFullName());
            $feedback->setMemberId($member->getId());
            $feedback->setMailbox(FeedbackPeer::INBOX);
            $feedback->setIsRead(FALSE);
            $feedback->save();
            $this->setFlash('msg_ok', 'Thank you. We really appreciate your feedback.');
            //$this->redirect('dashboard/index');
            $this->redirectToReferer();
        }
    }

    public function handleErrorReportBug()
    {
        return sfView::SUCCESS;
    }

    public function executeTellFriend()
    {
        $this->getUser()->getBC()->removeFirst()->replaceFirst(array('name' => 'Tell a Friend', 'uri' => 'content/tellFriend'));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            
            Events::triggerTellFriend($this->getRequestParameter('full_name'), $this->getRequestParameter('email'), $this->getRequestParameter('friend_full_name'), 
                    $this->getRequestParameter('friend_email'), nl2br($this->getRequestParameter('comments')));
            
            $this->redirect('content/tellFriendConfirm');
        }
        
        if( $page = StaticPagePeer::getBySlug('tell_friend') )
        {
            $this->getResponse()->setTitle($page->getTitle());
            $this->getResponse()->addMeta('description', $page->getDescription());
            $this->getResponse()->addMeta('keywords', $page->getKeywords());
        }
    }

    public function handleErrorTellFriend()
    {
        $this->getUser()->getBC()->removeFirst()->replaceFirst(array('name' => 'Tell a Friend', 'uri' => 'content/tellFriend'));
        
        if( $page = StaticPagePeer::getBySlug('tell_friend') )
        {
            $this->getResponse()->setTitle($page->getTitle());
            $this->getResponse()->addMeta('description', $page->getDescription());
            $this->getResponse()->addMeta('keywords', $page->getKeywords());
        }
                
        return sfView::SUCCESS;
    }

    public function executeTellFriendConfirm()
    {
        $this->getUser()->getBC()->clear()->add(array('name' => 'Tell a Friend', 'uri' => 'content/tellFriend'))->add(array('name' => 'Confirmation'));
    }

    public function executeEmails()
    {
        $email = WebEmailPeer::retrieveByHash($this->getRequestParameter('hash'));
        $this->forward404Unless($email);
        
        $this->setLayout('simple_small');
        $this->email = $email;
    }
    
    public function executeBlockedUser()
    {
        $this->setLayout('simple_small');
        $this->setTemplate('page');
        
        $c = new Criteria();
        $c->add(StaticPagePeer::SLUG, 'blocked_user');
        $pages = StaticPagePeer::doSelectWithI18n($c);
        $this->forward404Unless($pages);
        $this->page = $pages[0];
    }
    
    public function executeAreaInfo()
    {
        $geo = GeoPeer::retrieveByPK($this->getRequestParameter('area_id'));
        $this->forward404Unless($geo);
        
        $member = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($member);
        
        $this->details = $member->getMostAccurateAreaInfo($this->getUser()->getCatalogId());
        
        $geo_tree = array();
        $geo_tree[] = format_country($geo->getCountry());
        
        if( $geo->getDsg() == 'PPL' && $geo->getAdm1Id() )
        {
            $geo_tree[] = $geo->getAdm1();
            if( $geo->getAdm2Id() ) $geo_tree[] = $geo->getAdm2();
        } 
        elseif( $geo->getDsg() == 'ADM2' )
        {
            $geo_tree[] = $geo->getAdm1();
        }
        
        if( $geo->getDSG() != 'PCL' ) $geo_tree[] = $geo->getName();
        
        $bc = $this->getUser()->getBC();
        $username = $this->getRequestParameter('username');
        
        $bc->clear();
        if( $this->getUser()->isAuthenticated() ) $bc->add(array('name' => 'dashboard', 'uri' => '@dashboard'));
        if( $username ) $bc->add(array('name' => __("%USERNAME%'s profile", array('%USERNAME%' => $username)), 'uri' => '@profile?username=' . $username));
        $bc->add(array('name' => implode(', ', $geo_tree)));
        
        $bc->setCustomLastItem('Area Information');
        
        $title_prefix =  sfConfig::get('app_title_prefix_' . str_replace('.', '_', $this->getRequest()->getHost()));
        $this->getResponse()->setTitle($title_prefix.implode(', ', $geo_tree));

        $this->geo_tree_string = implode(', ', array_reverse($geo_tree));
    }
    
    public function executeLink()
    {
      $hash = $this->getRequestParameter('hash');
      $this->forward404Unless($hash);
      
      $link = LinkPeer::getByHash($hash);
      $this->forward404Unless($link);
      
      if( $link->isExpired() ) $this->message('expired_link');
      
      //login the member if needs to
      if( $link->getLoginAs() )
      {
        if( $this->getUser()->isAuthenticated() && $this->getUser()->getId() != $link->getLoginAs() )
        {
            $this->getUser()->signOut();
            $this->setFlash('msg_ok', 'For your own security instant login of this link has expired, please login to continue.');
            
        } elseif(!$this->getUser()->isAuthenticated() && !$link->isExpiredLogin() )
        {
          $member = MemberPeer::retrieveByPK($link->getLoginAs());
          if( !$member ) $this->message('expired_link');
  
          $this->getUser()->SignIn($member);
        } elseif( !$this->getUser()->isAuthenticated() )
        {
          $this->setFlash('msg_ok', 'For your own security instant login of this link has expired, please login to continue.');
        }
      }
      
      $this->redirect($link->getUri());
    }
}
