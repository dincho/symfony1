<?php
/**
 * dashboard actions.
 *
 * @package    pr
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class dashboardActions extends prActions
{

    public function preExecute()
    {
        //$this->getUser()->getBC()->removeLast()->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
    }

    public function executeIndex()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($member);
        $this->member = $member;
        
        //matches
        $c = new Criteria();
        $c->add(MemberMatchPeer::MEMBER1_ID, $member->getId());        
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        $c->addJoin(MemberMatchPeer::MEMBER2_ID, MemberPeer::ID);
        $c->setLimit(5);
        $this->matches = MemberPeer::doSelectJoinMemberPhoto($c);
        
        //messages
        $c = new Criteria();
        $c->add(MessagePeer::TO_MEMBER_ID, $member->getId());
        $c->add(MessagePeer::SENT_BOX, false);
        $c->addJoin(MemberPeer::ID, MessagePeer::FROM_MEMBER_ID);
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(MessagePeer::IS_READ);
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->messages = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->messages_cnt = MemberPeer::doCount($cc);

        //winks
        $c = new Criteria();
        $this->received_winks = WinkPeer::doSelectJoinMemberRelatedByMemberId($c);
                
        $c = new Criteria();
        $c->add(WinkPeer::PROFILE_ID, $member->getId());
        $c->addJoin(MemberPeer::ID, WinkPeer::MEMBER_ID);
        $c->add(WinkPeer::SENT_BOX, false);
        $c->add(WinkPeer::DELETED_AT, null, Criteria::ISNULL);
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(WinkPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->winks = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->winks_cnt = MemberPeer::doCount($cc);
        
        //hotlist
        $c = new Criteria();
        $c->add(HotlistPeer::PROFILE_ID, $member->getId());
        $c->addJoin(MemberPeer::ID, HotlistPeer::MEMBER_ID);
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->hotlist = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->hotlist_cnt = MemberPeer::doCount($cc);
        
        //visitors
        $c = new Criteria();
        $c->add(ProfileViewPeer::PROFILE_ID, $member->getId());
        $c->addJoin(MemberPeer::ID, ProfileViewPeer::MEMBER_ID);
        $c->addGroupByColumn(ProfileViewPeer::MEMBER_ID);
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(ProfileViewPeer::CREATED_AT);
        $c->setLimit(min(5, $member->getSubscription()->getSeeViewed()));
        
        //@TODO to be test for performance
        //if( $member->getSubscription()->getCanSeeViewed() ) $this->visits = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->visits = MemberPeer::doSelectJoinMemberPhoto($c);
        $cnt_rs = MemberPeer::doSelectRS($cc);
        $this->visits_cnt = $cnt_rs->getRecordCount();
        
        //recent visits
        $c = new Criteria();
        $c->add(ProfileViewPeer::MEMBER_ID, $member->getId());
        $c->addJoin(MemberPeer::ID, ProfileViewPeer::PROFILE_ID);
        $c->addGroupByColumn(ProfileViewPeer::PROFILE_ID);
        $c->addDescendingOrderByColumn(ProfileViewPeer::CREATED_AT);
        $c->setLimit(7);
        
        $this->recent_visits = MemberPeer::doSelectJoinMemberPhoto($c);
    }
    
    public function executeVisitors()
    {
        //$this->getUser()->getBC()->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        
        $c = new Criteria();
        $c->add(ProfileViewPeer::PROFILE_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(ProfileViewPeer::CREATED_AT);
        $c->addGroupByColumn(ProfileViewPeer::MEMBER_ID);
        $c->setLimit($this->getUser()->getProfile()->getSubscription()->getSeeViewed());
                
        $this->visits = ProfileViewPeer::doSelectJoinMemberRelatedByMemberId($c);
        
        $member = $this->getUser()->getProfile();
        $member->setLastProfileView(time());
        $member->save();
    }
    
    public function validateVisitors()
    {
        //subscription limits/restrictions ?
        $subscription = $this->getUser()->getProfile()->getSubscription();
        if( !$subscription->getCanSeeViewed() )
        {
            if( $subscription->getId() == SubscriptionPeer::FREE )
            {
                $this->setFlash('msg_error', 'In order to see who viewed your profile you need to upgrade your membership.');
            } else {
                $this->setFlash('msg_error', 'Paid: In order to see who viewed your profile you need to upgrade your membership.');
            }
            $this->redirect('@dashboard');
        }
        
        return true;
    }
    
    public function executeDeactivate()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
        
        $this->getUser()->getBC()->replaceLast(array('name' => ($member->getMemberStatusId() == MemberStatusPeer::DEACTIVATED) ? 'Activate Profile' : 'Deactivate Profile' ));
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            if( $this->getRequestParameter('deactivate_profile') == 1 && $member->getMemberStatusId() == MemberStatusPeer::ACTIVE )
            {
                $member->changeStatus(MemberStatusPeer::DEACTIVATED);
                $this->setFlash('msg_ok', 'Your account has been deactivated');
                Events::triggerAccountDeactivation($member);
                
            } elseif( $this->getRequestParameter('deactivate_profile') == 0 && $member->getMemberStatusId() == MemberStatusPeer::DEACTIVATED )
            {
                $member->changeStatus(MemberStatusPeer::ACTIVE);
                $this->setFlash('msg_ok', 'Your account has been reactivated');
            } else {
                $this->setFlash('msg_error', 'You have not made any changes.');
            }
            
            $member->save();
            
            $this->redirect('dashboard/index');
        }
        $this->member = $member;
    } 
    
    public function executeDeleteYourAccount()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
    }
    
    public function executeDeleteConfirmation()
    {
        $this->getUser()->getBC()->removeFirst()
        ->addFirst(array('name' => 'Delete Your Account', 'uri' => 'profile/deleteYourAccount'))
        ->addFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $member = MemberPeer::retrieveByPK($this->getUser()->getid());
            $this->forward404Unless($member); //just in case
            
            $member->changeStatus(MemberStatusPeer::CANCELED_BY_MEMBER, false);
            $member->save();
            
            Events::triggerAccountDeleteByMember($member, nl2br(strip_tags($this->getRequestParameter('delete_reason'))));
            
            $this->getUser()->signOut();
            $this->message('delete_account_confirm');            
        }

    }
        
    public function executeEmailNotifications()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($member);
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            if( $this->getRequestParameter('email_notifications') == 'no')
            {
                $member->setEmailNotifications(NULL);
            } else {
                $member->setEmailNotifications($this->getRequestParameter('email_notifications', 0));
            }
            
            $member->save();
            
            $this->setFlash('msg_ok', 'Your Email Notifications Settings have been updated');
            $this->redirect('dashboard/index');
        }
        
        $this->member = $member;
    }
    
    public function executePrivacy()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($member);
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $member->setDontUsePhotos($this->getRequestParameter('dont_use_photos', 0));
            if( $this->getRequestParameter('dont_use_photos', 0) == 1) $member->setPublicSearch(false);
            $member->setContactOnlyFullMembers($this->getRequestParameter('contact_only_full_members'), 0);
            $member->save();
            
            $this->setFlash('msg_ok', 'Your Privacy Settings have been updated');
            $this->redirect('dashboard/index');
        }
        
        $this->member = $member;
    }
    
    public function validatePrivacy()
    {
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            if( $this->getUser()->getProfile()->getSubscriptionId() == SubscriptionPeer::FREE )
            {
                $this->getRequest()->setError('privacy', 'This feature is available by to Full Members. Please upgrade your membership.');
                return false;            
            }            
        }
        
        return true;
    }
    
    public function handleErrorPrivacy()
    {
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member);
                
        return sfView::SUCCESS;
    }
    
    public function executeContactYourAssistant()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member = $this->getUser()->getProfile();
            
            $feedback = new Feedback();
            $feedback->setSubject($this->getRequestParameter('subject'));
            $feedback->setBody($this->getRequestParameter('description'));
            $feedback->setMailTo(FeedbackPeer::SUPPORT_ADDRESS);
            $feedback->setMailFrom($member->getEmail());
            $feedback->setNameFrom($member->getFullName());
            $feedback->setMemberId($member->getId());
            $feedback->setMailbox(FeedbackPeer::INBOX);
            $feedback->setIsRead(FALSE);
            $feedback->save();
            
            $member->incCounter('AssistantContacts');
            
            $this->setFlash('msg_ok', 'Thank you. We really appreciate your feedback.');
            $this->redirect('dashboard/index');
        }
    }
    
    public function validateContactYourAssistant()
    {
        $subscription = $this->getUser()->getProfile()->getSubscription();
        if( !$subscription->getCanContactAssistant() )
        {
            if( $subscription->getId() == SubscriptionPeer::FREE )
            {
                $this->getRequest()->setError('subscription', 'In order to contact assistant you need to upgrade your membership.');
            } else {
                $this->getRequest()->setError('subscription', 'Paid: In order to contact assistant you need to upgrade your membership.');
            }
            return false;
        }
                
        if( $this->getUser()->getProfile()->getCounter('AssistantContacts') >= $subscription->getContactAssistant() )
        {
            if( $subscription->getId() == SubscriptionPeer::FREE )
            {
                $this->getRequest()->setError('subscription', 'For the feature that you want want to use - contact assistant - you have reached the limit up to which you can use it with your membership. In order to contact online assistant, please upgrade your membership.');
            } else {
                $this->getRequest()->setError('subscription', 'Paid: For the feature that you want want to use - contact assistant - you have reached the limit up to which you can use it with your membership. In order to contact online assistant, please upgrade your membership.');
            }
            return false;            
        }
                
        return true;
    }
    
    public function handleErrorContactYourAssistant()
    {
        return sfView::SUCCESS;
    }
    
    public function executeSearchCriteria()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($member);
        
        $questions = DescQuestionPeer::doSelect(new Criteria());
        $this->questions = $questions;
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $member_answers = $this->getRequestParameter('answers', array());
            $member_match_weights = $this->getRequestParameter('weights');
            $member->clearSearchCriteria();
            
            foreach ($questions as $question)
            {
                if( array_key_exists($question->getId(), $member_answers) )
                {
                    $search_crit_desc = new SearchCritDesc();
                    $search_crit_desc->setMemberId($member->getId());
                    $search_crit_desc->setDescQuestionId($question->getId());
                    $member_answers_vals = ( is_array($member_answers[$question->getId()]) ) ? array_values($member_answers[$question->getId()]) : (array) $member_answers[$question->getId()];
                    $search_crit_desc->setDescAnswers(implode(',', $member_answers_vals));
                    $search_crit_desc->setMatchWeight( $member_match_weights[$question->getId()] );
                    $search_crit_desc->save();
                }
            }
            
            $member->updateMatches();
            $this->setFlash('msg_ok', 'Your Match Criteria have been updated');
            $this->redirect('dashboard/index');            
        }
        
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_crit_desc = $member->getSearchCritDescsArray();
    }
    
    public function validateSearchCriteria()
    {
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $questions = DescQuestionPeer::doSelect(new Criteria());
            $answers = $this->getRequestParameter('answers', array());
            
            $has_error = false;
            foreach ($questions as $question)
            {
                if( $question->getIsRequired() && !isset($answers[$question->getId()]) )
                {
                    $this->getRequest()->setError('answers[' . $question->getId() . ']', 'Search Criteria: You must fill out the missing information below indicated in red.');
                    $has_error = true;
                }
            }
            
            if ($has_error)
            {
                $this->setFlash('only_last_error', true);
                return false;
            }
        }
        
        return true;
      
    }
    
    public function handleErrorSearchCriteria()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($member);
        
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_crit_desc = $member->getSearchCritDescsArray();
        
        return sfView::SUCCESS;
    }
}
