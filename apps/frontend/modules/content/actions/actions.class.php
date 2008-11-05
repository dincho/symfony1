<?php
/**
 * content actions.
 *
 * @package    pr
 * @subpackage content
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class contentActions extends sfActions
{

    public function executeIndex()
    {
        if ($this->getUser()->isAuthenticated() && $this->getUser()->hasCredential(array('member'), false))
        {
            $this->redirect('dashboard/index');
        }
        $this->setLayout('layout_index');
    }

    public function executeFlag()
    {
        $this->profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($this->profile);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $flag = new Flag();
            $flag->setFlagCategoryId($this->getRequestParameter('flag_category'));
            $flag->setComment($this->getRequestParameter('comment'));
            $flag->setMemberId($this->profile->getId());
            $flag->setFlaggerId($this->getUser()->getId());
            $flag->save();
            
            $counter = $this->profile->getMemberCounter();
            $counter->setCurrentFlags($counter->getCurrentFlags()+1);
            $counter->setTotalFlags($counter->getTotalFlags()+1);
            $counter->save();
            
            $this->getUser()->getProfile()->incCounter('SentFlags');
            
            $this->setFlash('msg_ok', 'Thanks for taking time to report the profile! We appreciate it.');
            $this->redirect($this->getUser()->getRefererUrl());
        }
        
        $this->flag_categories = FlagCategoryPeer::doSelect(new Criteria());
    }

    public function validateFlag()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
                
        if( $this->getUser()->getId() == $profile->getId() )
        {
            $this->setFlash('msg_error', 'You can\'t use this function on your own profile');
            $this->redirect('profile/index?username=' . $profile->getUsername() );
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
        $this->getUser()->getBC()->clear()->add(array('name' => $this->page->getTitle(), 'uri' => '#'));
    }

    public function executeMessage()
    {
        $title = $this->getFlash('s_title');
        $this->forward404Unless($title);
        $this->setLayout('simple');
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => $title, 'uri' => '@homepage'));
        $this->header_title = $title;
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
            $this->redirect('dashboard/index');
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
            
            Events::triggerTellFriend($this->getRequestParameter('full_name'), $this->getRequestParameter('email'),
                                    $this->getRequestParameter('friend_full_name'), $this->getRequestParameter('friend_email'), $this->getRequestParameter('comments'));
            
            $this->setFlash('s_title', 'Tell a Friend Confirmation');
            $this->setFlash('s_msg', 'Your message has been sent.');
            $this->redirect('content/message');
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
}
