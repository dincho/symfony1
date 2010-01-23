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
        $member = $this->getUser()->getProfile();
        $this->forward404Unless($member);
        $this->member = $member;
        
        //matches
        $c = new Criteria();
        $c->add(MemberMatchPeer::MEMBER1_ID, $member->getId());        
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        $c->addJoin(MemberMatchPeer::MEMBER2_ID, MemberPeer::ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles

        $c->addJoin(MemberMatchPeer::MEMBER1_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. MemberMatchPeer::MEMBER2_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);
                
        $c->setLimit(5);
        $this->matches = MemberPeer::doSelectJoinMemberPhoto($c);
        
        //messages
        
        $c = new Criteria();
        $c->add(MessagePeer::RECIPIENT_ID, $this->getUser()->getId());
        $c->add(MessagePeer::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->add(MessagePeer::UNREAD, true);
        $c->addGroupByColumn(MessagePeer::THREAD_ID);
        $c->addJoin(MemberPeer::ID, MessagePeer::SENDER_ID);
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->messages = MemberPeer::doSelectJoinMemberPhoto($c);
        $rs = MessagePeer::doSelectRS($cc);
        $this->messages_cnt = $rs->getRecordCount();
        
        //winks
        $c = new Criteria();
        $c->add(WinkPeer::PROFILE_ID, $member->getId());
        $c->addJoin(MemberPeer::ID, WinkPeer::MEMBER_ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->add(WinkPeer::SENT_BOX, false);
        $c->add(WinkPeer::DELETED_AT, null, Criteria::ISNULL);
        $c->add(WinkPeer::IS_NEW, true);
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(WinkPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->winks = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->winks_cnt = MemberPeer::doCount($cc);
        
        //hotlist
        $c = new Criteria();
        $c->add(HotlistPeer::PROFILE_ID, $member->getId());
        $c->addJoin(MemberPeer::ID, HotlistPeer::MEMBER_ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->add(HotlistPeer::IS_NEW, true);
        
        //privacy check
        $c->addJoin(HotlistPeer::MEMBER_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. HotlistPeer::PROFILE_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);
        
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->hotlist = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->hotlist_cnt = MemberPeer::doCount($cc);
        
        //visitors
        $c = new Criteria();
        $c->add(ProfileViewPeer::PROFILE_ID, $member->getId());
        $c->addJoin(MemberPeer::ID, ProfileViewPeer::MEMBER_ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->addGroupByColumn(ProfileViewPeer::MEMBER_ID);
        $c->add(ProfileViewPeer::IS_NEW, true);
        
        //privacy check
        $c->addJoin(ProfileViewPeer::MEMBER_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. ProfileViewPeer::PROFILE_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);
                
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
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->addGroupByColumn(ProfileViewPeer::PROFILE_ID);
        $c->addDescendingOrderByColumn(ProfileViewPeer::UPDATED_AT);
        $c->setLimit(7);
        
        $this->recent_visits = MemberPeer::doSelectJoinMemberPhoto($c);
        
        if( $member->getDashboardMsg() == 0 && !$this->hasFlash('msg_ok') ) //not hidden and has no other message
        {
          $this->setFlash('msg_ok', 
                          sfI18N::getInstance()->__('This is your control panel. Here you can find everything you need to use the website', 
                          array('%URL_FOR_HIDE%' => $this->getController()->genUrl('dashboard/hide')))
                          , false);
        }
    }
    
    public function executeVisitors()
    {      
        $c = new Criteria();
        $c->add(ProfileViewPeer::PROFILE_ID, $this->getUser()->getId());
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        
        //privacy check
        $c->addJoin(ProfileViewPeer::MEMBER_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. ProfileViewPeer::PROFILE_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);
                
        $c->addGroupByColumn(ProfileViewPeer::MEMBER_ID);
        $c->addDescendingOrderByColumn(ProfileViewPeer::CREATED_AT);
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
        
      if( !$this->getRequestParameter('re') && $member->getMemberStatusId() == MemberStatusPeer::ACTIVE )
      {
          $member->changeStatus(MemberStatusPeer::DEACTIVATED);
          $this->setFlash('msg_ok', 'Your account has been deactivated');
          Events::triggerAccountDeactivation($member);
          $member->save();
        
          $this->getUser()->setAttribute('status_id', MemberStatusPeer::DEACTIVATED);
          $this->message('status_deactivated');
        
      } elseif( $this->getRequestParameter('re') && $member->getMemberStatusId() == MemberStatusPeer::DEACTIVATED )
      {
          $member->changeStatus(MemberStatusPeer::ACTIVE);
          $this->setFlash('msg_ok', 'Your account has been reactivated');
          $member->save();
        
          $this->getUser()->setAttribute('status_id', MemberStatusPeer::ACTIVE);
          $this->redirect('dashboard/index');
      }
    
      $this->redirect('dashboard/index'); //we do not have template
    } 
    
    public function executeDeleteYourAccount()
    {
        $this->getUser()->getBC()
        ->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'))
        ->replaceLast(array('name' => 'Delete your account headline'));
    }
    
    public function executeDeleteConfirmation()
    {
        $this->getUser()->getBC()->removeFirst()
        ->addFirst(array('name' => 'Delete Your Account', 'uri' => 'dashboard/deleteYourAccount'))
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
            $modified = false;
            if( $member->getPrivateDating() != $this->getRequestParameter('private_dating') ||
                $member->getContactOnlyFullMembers() != $this->getRequestParameter('contact_only_full_members'))
                {
                  $modified = true;
                }
            
            $member->setPrivateDating($this->getRequestParameter('private_dating', 0));
            if( $this->getRequestParameter('private_dating', 0) == 1) $member->setPublicSearch(false);
            $member->setContactOnlyFullMembers($this->getRequestParameter('contact_only_full_members', 0));
            
            if( $modified && $this->getUser()->getProfile()->getSubscriptionId() == SubscriptionPeer::FREE )
            {
              $this->setFlash('msg_error', 'This feature is available by to Full Members. Please upgrade your membership.', false);
            } else {
              $member->save();
              $this->setFlash('msg_ok', 'Your Privacy Settings have been updated');
              $this->redirect('dashboard/index');                
            }            
        }
        
        $this->member = $member;
    }
    
    public function executeContactYourAssistant()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Assistant request title'));
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
            $member->incCounter('AssistantContactsDay');
            
            //$this->setFlash('msg_ok', 'Thank you. We really appreciate your feedback.');
            $this->redirect('dashboard/contactAssistantConfirmation');
        }
        
        $this->photo = StockPhotoPeer::getAssistantPhotoByCulture($this->getUser()->getCulture());
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
        
        if( $this->getUser()->getProfile()->getCounter('AssistantContactsDay') >= $subscription->getContactAssistantDay() )
        {
            if( $subscription->getId() == SubscriptionPeer::FREE )
            {
                $this->getRequest()->setError('subscription', 'For the feature that you want to use - contact assistant - you have reached the daily limit up to which you can use it with your membership. In order to contact online assistant, please upgrade your membership.');
            } else {
                $this->getRequest()->setError('subscription', 'Paid: For the feature that you want to use - contact assistant - you have reached the daily limit up to which you can use it with your membership. In order to contact online assistant, please upgrade your membership.');
            }
            return false;            
        }
                
        if( $this->getUser()->getProfile()->getCounter('AssistantContacts') >= $subscription->getContactAssistant() )
        {
            if( $subscription->getId() == SubscriptionPeer::FREE )
            {
                $this->getRequest()->setError('subscription', 'For the feature that you want to use - contact assistant - you have reached the limit up to which you can use it with your membership. In order to contact online assistant, please upgrade your membership.');
            } else {
                $this->getRequest()->setError('subscription', 'Paid: For the feature that you want to use - contact assistant - you have reached the limit up to which you can use it with your membership. In order to contact online assistant, please upgrade your membership.');
            }
            return false;            
        }
                
        return true;
    }
    
    public function handleErrorContactYourAssistant()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Assistant request title'));
        $this->photo = StockPhotoPeer::getAssistantPhotoByCulture($this->getUser()->getCulture());
        return sfView::SUCCESS;
    }
    
    public function executeContactAssistantConfirmation()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Assistant request title', 'uri' => 'dashboard/contactYourAssistant'))->add(array('name' => 'Assistant response title'));
        $this->photo = StockPhotoPeer::getAssistantPhotoByCulture($this->getUser()->getCulture());
    }
    
    public function executeSearchCriteria()
    {
        $this->getUser()->getBC()->clear()->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($member);
        
        $questions = DescQuestionPeer::doSelect(new Criteria());
        $this->questions = $questions;
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $hasSearchCriteria = $member->hasSearchCriteria();
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
            $msg = ($hasSearchCriteria) ? 'Your Match Criteria have been updated' : 'You have just set up your search criteria';
            $this->setFlash('msg_ok', $msg);
            $this->redirect('dashboard/index');
        }
        
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_crit_desc = $member->getSearchCritDescsArray();
    }
    
    public function validateSearchCriteria()
    {
        $request = $this->getRequest();
        if( $request->getMethod() == sfRequest::POST )
        {
            $questions = DescQuestionPeer::doSelect(new Criteria());
            $answers = $this->getRequestParameter('answers', array());
            
            foreach ($questions as $question)
            {
                if( $question->getType() == 'age' )
                {
                  $ages = $answers[$question->getId()];
                  if( !is_array($ages) || !is_numeric($ages[0]) || !is_numeric($ages[1]) || $ages[0] < 18 || $ages[1] > 100 || $ages[1] < $ages[0] )
                  {
                        $request->setError('answers[' . $question->getId() . ']', 'Please enter correct ages range');
                  }
                } elseif( $question->getType() == 'select' && (!is_array($answers[$question->getId()]) || $answers[$question->getId()]['from'] > $answers[$question->getId()]['to']) )
                {
                        $request->setError('answers[' . $question->getId() . ']', 'Please select correct range for questions below indicated in red');
                } elseif( $question->getIsRequired() && !isset($answers[$question->getId()]) )
                {
                        $request->setError('answers[' . $question->getId() . ']', 'Search Criteria: You must fill out the missing information below indicated in red.');
                }
            }
            
            if ($request->hasErrors())
            {
                $this->setFlash('only_unique_errors', true);
                return false;
            }
        }
        
        return true;
    }
    
    public function handleErrorSearchCriteria()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($member);
        $this->getUser()->getBC()->clear()->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_crit_desc = $member->getSearchCritDescsArray();
        
        return sfView::SUCCESS;
    }
    
    public function executeHide()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($member);
        
        $member->setDashboardMsg(1);
        $member->save();
        $this->redirect('dashboard/index');
    }
}
