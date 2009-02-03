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
    	$c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
    
    	$this->pager = new sfPropelPager('Member', 15);
    
    	$this->pager->setCriteria($c);
    	$this->pager->setPage($this->getRequestParameter('page', 1));
    	$this->pager->init();
    }

    public function executeIndex()
    {
        if ($this->getUser()->isAuthenticated() && $this->getUser()->hasCredential(array('member'), false))
        {
            $this->redirect('dashboard/index');
        }
        
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
            
            $this->setFlash('msg_ok', 'Thanks for taking time to report the profile! We appreciate it.');
            $this->redirect('@profile?username=' . $profile->getUsername());
        }
        
        $this->profile = $profile;
        $this->flag_categories = FlagCategoryPeer::doSelect(new Criteria());
    }

    public function validateFlag()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
        
        if ($this->getUser()->getId() == $profile->getId())
        {
            $this->setFlash('msg_error', 'You can\'t use this function on your own profile');
            $this->redirect('profile/index?username=' . $profile->getUsername());
        }
        
        return true;
    }

    public function handleErrorFlag()
    {
        $this->profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($this->profile);
        $this->flag_categories = FlagCategoryPeer::doSelect(new Criteria());
        return sfView::SUCCESS;
    }

    public function executePage()
    {
        $c = new Criteria();
        $c->add(StaticPagePeer::SLUG, $this->getRequestParameter('slug'));
        $pages = StaticPagePeer::doSelectWithI18n($c);
        $this->forward404Unless($pages);
        $this->page = $pages[0];
        $this->getResponse()->setTitle('PolishRomance - ' . $this->page->getTitle());
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => $this->page->getLinkName(), 'uri' => '#'));
    }

    public function executeMessage()
    {
        $this->redirectUnless($this->hasFlash('msg_tpl'), '@homepage');
        $this->setLayout('simple');
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'Message'));
    }

    public function executeReportBug()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member = $this->getUser()->getProfile();
            $feedback = new Feedback();
            $feedback->setSubject($this->getRequestParameter('subject'));
            $feedback->setBody($this->getRequestParameter('description'));
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
                    $this->getRequestParameter('friend_email'), $this->getRequestParameter('comments'));
            
            $this->message('tell_friend_confirm');
        }
    }

    public function handleErrorTellFriend()
    {
        $this->getUser()->getBC()->removeFirst()->replaceFirst(array('name' => 'Tell a Friend', 'uri' => 'content/tellFriend'));
        return sfView::SUCCESS;
    }

    public function executeTellFriendConfirmation()
    {
    
    }

    public function executeEmails()
    {
        $email = WebEmailPeer::retrieveByHash($this->getRequestParameter('hash'));
        $this->forward404Unless($email);
        
        $this->setLayout('simple_small');
        $this->email = $email;
    }
    
    public function executeAreaInfo()
    {
        $state = StatePeer::retrieveByPK($this->getRequestParameter('area_id'));
        $this->forward404Unless($state);
        
        $this->getUser()->getBC()->clear()
        ->add(array('name' => 'dashboard', 'uri' => '@dashboard'))
        ->add(array('name' => 'profile', 'uri' => '@profile?username=' . $this->getRequestParameter('username')))
        ->add(array('name' => 'area information'));
        
        $this->state = $state;
    }
    
    public function executeChangeLanguage()
    {
        $ref = $this->getUser()->getRefererUrl();
        
        if( $this->getRequestParameter('lang') )
        {
            $this->getUser()->setCulture($this->getRequestParameter('lang'));
            $ref = preg_replace('/sf_culture\=[a-z]+/', 'sf_culture=' . $this->getRequestParameter('lang'), $ref);
        }
        
        $this->redirect($ref);
    }
}
