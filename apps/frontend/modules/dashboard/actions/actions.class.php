<?php
/**
 * dashboard actions.
 *
 * @package    pr
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class dashboardActions extends sfActions
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
        //messages
        $c = new Criteria();
        $c->add(MessagePeer::TO_MEMBER_ID, $member->getId());
        $c->add(MessagePeer::SENT_BOX, false);
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(MessagePeer::IS_READ);
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->messages = MessagePeer::doSelectJoinMemberRelatedByFromMemberId($c);
        $this->messages_cnt = MessagePeer::doCountJoinMemberRelatedByFromMemberId($cc);

        //winks
        $c = new Criteria();
        $c->add(WinkPeer::MEMBER_ID, $member->getId());
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(WinkPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->winks = WinkPeer::doSelectJoinMemberRelatedByProfileId($c);
        $this->winks_cnt = WinkPeer::doCountJoinMemberRelatedByProfileId($cc);
        
        //hotlist
        $c = new Criteria();
        $c->add(HotlistPeer::MEMBER_ID, $member->getId());
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->hotlist = HotlistPeer::doSelectJoinMemberRelatedByProfileId($c);
        $this->hotlist_cnt = HotlistPeer::doCountJoinMemberRelatedByProfileId($cc);
        
        //visitors
        $c = new Criteria();
        $c->add(ProfileViewPeer::PROFILE_ID, $member->getId());
        $c->addGroupByColumn(ProfileViewPeer::MEMBER_ID);
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(ProfileViewPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->visits = ProfileViewPeer::doSelectJoinMemberRelatedByMemberId($c);
        $cnt_rs = ProfileViewPeer::doSelectRS($cc);
        $this->visits_cnt = $cnt_rs->getRecordCount();
        
        //recent visits
        $c = new Criteria();
        $c->add(ProfileViewPeer::MEMBER_ID, $member->getId());
        $c->addGroupByColumn(ProfileViewPeer::PROFILE_ID);
        $c->addDescendingOrderByColumn(ProfileViewPeer::CREATED_AT);
        $c->setLimit(7);
        
        $this->recent_visits = ProfileViewPeer::doSelectJoinMemberRelatedByProfileId($c);
    }
    
    public function executeVisitors()
    {
        //$this->getUser()->getBC()->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        
        $c = new Criteria();
        $c->add(ProfileViewPeer::PROFILE_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(ProfileViewPeer::CREATED_AT);
        $c->addGroupByColumn(ProfileViewPeer::MEMBER_ID);
                
        $this->visits = ProfileViewPeer::doSelectJoinMemberRelatedByMemberId($c);
    }
    
    public function executeDeactivate()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            if( $this->getRequestParameter('deactivate_profile') == 1 && $member->getMemberStatusId() == MemberStatusPeer::ACTIVE )
            {
                $member->changeStatus(MemberStatusPeer::DEACTIVATED);
                $this->setFlash('msg_ok', 'Your profile status have been updated.');
            } elseif( $this->getRequestParameter('deactivate_profile') == 0 && $member->getMemberStatusId() == MemberStatusPeer::DEACTIVATED )
            {
                $member->changeStatus(MemberStatusPeer::ACTIVE);
                $this->setFlash('msg_ok', 'Your profile status have been updated.');
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
            
            $member->changeStatus(MemberStatusPeer::CANCELED_BY_MEMBER);
            $member->save();
            
            Events::triggerAccountDeleteByMember($member, nl2br(strip_tags($this->getRequestParameter('delete_reason'))));
            
            $this->getUser()->signOut();
            
            $this->setFlash('s_title', 'Delete Your Account');
            $this->setFlash('s_msg', 'Your account has been deleted.');        
            $this->redirect('content/message');            
        }

    }
        
    public function executeEmailNotifications()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($member);
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $member->setEmailNotifications($this->getRequestParameter('email_notifications'), 0);
            $member->save();
            
            $this->setFlash('msg_ok', 'Your email notifications have been updated.');
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
            $member->setDontUsePhotos($this->getRequestParameter('dont_use_photos'), 0);
            $member->setContactOnlyFullMembers($this->getRequestParameter('contact_only_full_members'), 0);
            $member->save();
            
            $this->setFlash('msg_ok', 'Your privacy have been updated.');
            $this->redirect('dashboard/index');
        }
        
        $this->member = $member;
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
        
        $search_criteria = $member->getSearchCriteria();
        if( !$search_criteria ) $search_criteria = new SearchCriteria();
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $member_answers = $this->getRequestParameter('answers', array());
            $member_match_weights = $this->getRequestParameter('weights');

            $search_criteria->clear();
            
            if( array_key_exists('ages', $member_answers))
            {
                $search_criteria->setAges( implode(',',array_values($member_answers['ages'])) );
                $search_criteria->setAgesWeight($member_match_weights['ages']);
            }

            $search_criteria->save();
            
            foreach ($questions as $question)
            {
                if( array_key_exists($question->getId(), $member_answers) )
                {
                    $search_crit_desc = new SearchCritDesc();
                    $search_crit_desc->setSearchCriteriaId($search_criteria->getId());
                    $search_crit_desc->setDescQuestionId($question->getId());
                    $member_answers_vals = ( is_array($member_answers[$question->getId()]) ) ? array_values($member_answers[$question->getId()]) : (array) $member_answers[$question->getId()];
                    $search_crit_desc->setDescAnswers(implode(',', $member_answers_vals));
                    $search_crit_desc->setMatchWeight( $member_match_weights[$question->getId()] );
                    $search_crit_desc->save();
                }
            }
            
            $member->setSearchCriteriaId($search_criteria->getId());
            $member->save();
            
            $this->setFlash('msg_ok', 'Your search criteria have been updated.');
            $this->redirect('dashboard/index');            
        }
        
        $this->search_criteria = $search_criteria;
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_crit_desc = $search_criteria->getSearchCritDescsArray();
    }
}
