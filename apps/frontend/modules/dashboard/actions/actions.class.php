<?php
/**
 * dashboard actions.
 *
 * @package    pr
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class dashboardActions extends BaseSearchActions
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
        $c = $member->getUnreadMessagesCriteria();
        $c->addJoin(MemberPeer::ID, MessagePeer::SENDER_ID);
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->messages = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->messages_cnt = $member->getUnreadMessagesCount();
        $this->messages_all_cnt = $member->getAllMessagesCount();
        
        //winks
        $c = new Criteria();
        $c->add(WinkPeer::PROFILE_ID, $member->getId());
        $c->addJoin(MemberPeer::ID, WinkPeer::MEMBER_ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->add(WinkPeer::SENT_BOX, false);
        $c->add(WinkPeer::DELETED_AT, null, Criteria::ISNULL);
        $cc_all = clone $c; //count all criteria
        $c->add(WinkPeer::IS_NEW, true);
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(WinkPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->winks = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->winks_cnt = MemberPeer::doCount($cc);
        $this->winks_all_cnt = MemberPeer::doCount($cc_all);
        
        //hotlist
        $c = HotlistPeer::getNewHotlistCriteria($member->getId());
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->hotlist = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->hotlist_cnt = MemberPeer::doCount($cc);
        $this->hotlist_all_cnt = MemberPeer::doCount(HotlistPeer::getAllHotlistCriteria($member->getId()));
        
        //visitors
        $c = ProfileViewPeer::getNewVisitorsCriteria($member->getId());
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(ProfileViewPeer::CREATED_AT);
        $c->setLimit(min(5, $member->getSubscriptionDetails()->getSeeViewed()));
        
        $this->visits = MemberPeer::doSelectJoinMemberPhoto($c);
        $cnt_rs = MemberPeer::doSelectRS($cc);
        $this->visits_cnt = $cnt_rs->getRecordCount();
        $cnt_all_rs = MemberPeer::doSelectRS(ProfileViewPeer::getAllVisitorsCriteria($member->getId()));
        $this->visits_all_cnt = $cnt_all_rs->getRecordCount();

        //private photos
        $c = PrivatePhotoPermissionPeer::getNewPhotoCriteria($member->getId());
        $cc = clone $c; //count criteria
        
        $c->addDescendingOrderByColumn(PrivatePhotoPermissionPeer::CREATED_AT);
        $c->setLimit(5);
        
        $this->private_photos_profiles = MemberPeer::doSelectJoinMemberPhoto($c);
        $this->private_photos_profiles_cnt = MemberPeer::doCount($cc);
        $this->private_photos_profiles_all_cnt = MemberPeer::doCount(PrivatePhotoPermissionPeer::getAllPhotoCriteria($member->getId()));
        
        if($this->getUser()->getProfile()->getPrivateDating()){
            $this->open_privacy_perms = $member->getTop5PrivacyPermsProfiles(); 
            $this->open_privacy_perms_cnt = $member->openPrivacyPermsCount(); 
        }

                
        //blocked member count
        $c = new Criteria();
        $c->add(BlockPeer::MEMBER_ID, $member->getId());
        $this->blocked_cnt = BlockPeer::doCount($c);
        
        //recent visits
        $c = new Criteria();
        $c->add(ProfileViewPeer::MEMBER_ID, $member->getId());
        $c->addJoin(MemberPeer::ID, ProfileViewPeer::PROFILE_ID);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->addGroupByColumn(ProfileViewPeer::PROFILE_ID);
        $c->addDescendingOrderByColumn(ProfileViewPeer::UPDATED_AT);
        $c->setLimit(7);
        
        $this->recent_visits = MemberPeer::doSelectJoinMemberPhoto($c);

        
        //Newly registered
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addSelectedCountriesCriteria($c);        
        $sort_by_subscription = sprintf("FIELD(%s,%s)", MemberPeer::SUBSCRIPTION_ID, implode(',', array(SubscriptionPeer::VIP, SubscriptionPeer::PREMIUM, SubscriptionPeer::FREE)) );
        $c->addAscendingOrderByColumn( $sort_by_subscription );
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        $cc = clone $c; //count criteria        
        $c->setLimit(5);

        $this->newly_registered = MemberMatchPeer::doSelectJoinMemberRelatedByMember2Id($c);
        $this->newly_registered_cnt = MemberMatchPeer::doCountJoinMemberRelatedByMember2Id($cc);
        
        //Most recent visitors
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addSelectedCountriesCriteria($c);        
        $cc = clone $c; //count criteria        
        $c->addDescendingOrderByColumn(MemberPeer::LAST_LOGIN);
        $c->setLimit(5);

        $this->most_recent_visitors = MemberMatchPeer::doSelectJoinMemberRelatedByMember2Id($c);
        $this->most_recent_visitors_cnt = MemberMatchPeer::doCountJoinMemberRelatedByMember2Id($cc);
        
        //Best matching you
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addSelectedCountriesCriteria($c);        
        $cc = clone $c; //count criteria        
        $c->addDescendingOrderByColumn(MemberMatchPeer::PCT);
        $c->setLimit(5);

        $this->best_matching_you = MemberMatchPeer::doSelectJoinMemberRelatedByMember2Id($c);
        $this->best_matching_you_cnt = MemberMatchPeer::doCountJoinMemberRelatedByMember2Id($cc);
        
        //You match them best
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addSelectedCountriesCriteria($c);        
        $c->addHaving($c->getNewCriterion(MemberMatchPeer::ID, 'reverse_pct > 0' ,Criteria::CUSTOM));
        $cc = clone $c; //count criteria        
        $c->addDescendingOrderByColumn('reverse_pct');
        $c->setLimit(5);

        $this->you_match_them_best = MemberMatchPeer::doSelectJoinMemberRelatedByMember2Id($c);
        $this->you_match_them_best_cnt = MemberMatchPeer::doCountJoinMemberRelatedByMember2IdReverse($cc);
        
        //Best mutual matches
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addSelectedCountriesCriteria($c);        
        $cc = clone $c; //count criteria        
        $c->addDescendingOrderByColumn('(pct+reverse_pct)');
        $c->setLimit(5);

        $this->best_mutual_matches = MemberMatchPeer::doSelectJoinMemberRelatedByMember2Id($c);
        $this->best_mutual_matches_cnt = MemberMatchPeer::doCountJoinMemberRelatedByMember2Id($cc);
        
        //Per your own rating
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addSelectedCountriesCriteria($c);        
        $c->addJoin(MemberMatchPeer::MEMBER1_ID, MemberRatePeer::RATER_ID.' AND '.MemberMatchPeer::MEMBER2_ID.' = '.MemberRatePeer::MEMBER_ID, Criteria::LEFT_JOIN);
        $cc = clone $c; //count criteria        
        $c->addDescendingOrderByColumn(MemberRatePeer::RATE);
        $c->setLimit(5);

        $this->per_your_own_rating = MemberMatchPeer::doSelectJoinMemberRelatedByMember2Id($c);
        $this->per_your_own_rating_cnt = MemberMatchPeer::doCountJoinMemberRelatedByMember2Id($cc);
        
        
        if( $member->getDashboardMsg() == 0 && !$this->hasFlash('msg_ok') ) //not hidden and has no other message
        {
          if ($this->member->getSex() == 'M' && $this->member->getLookingFor() == 'M')
          {
            $this->setFlash('msg_ok', 
                          sfI18N::getInstance()->__('M_M This is your control panel. Here you can find everything you need to use the website', 
                          array('%URL_FOR_HIDE%' => $this->getController()->genUrl('dashboard/hide')))
                          , false);
          }
          else if ($this->member->getSex() == 'M' && $this->member->getLookingFor() == 'F')
          {
            $this->setFlash('msg_ok', 
                          sfI18N::getInstance()->__('M_F This is your control panel. Here you can find everything you need to use the website', 
                          array('%URL_FOR_HIDE%' => $this->getController()->genUrl('dashboard/hide')))
                          , false);
          }
          else if ($this->member->getSex() == 'F' && $this->member->getLookingFor() == 'M')
          {
            $this->setFlash('msg_ok', 
                          sfI18N::getInstance()->__('F_M This is your control panel. Here you can find everything you need to use the website', 
                          array('%URL_FOR_HIDE%' => $this->getController()->genUrl('dashboard/hide')))
                          , false);
          }
          else if ($this->member->getSex() == 'F' && $this->member->getLookingFor() == 'F')
          {
            $this->setFlash('msg_ok', 
                          sfI18N::getInstance()->__('F_F This is your control panel. Here you can find everything you need to use the website', 
                          array('%URL_FOR_HIDE%' => $this->getController()->genUrl('dashboard/hide')))
                          , false);
          }

        }
        
        if( !$member->getMainPhotoId() && !$this->hasFlash('msg_warning') )
        {
          if ($this->member->getSex() == 'M' && $this->member->getLookingFor() == 'M')
          {
            $this->setFlash('msg_warning', 'M_M No photo can get you flagged by other members. Please add photo as soon as you can.', false);
          }
          else if ($this->member->getSex() == 'M' && $this->member->getLookingFor() == 'F')
          {
            $this->setFlash('msg_warning', 'M_F No photo can get you flagged by other members. Please add photo as soon as you can.', false);
          }
          else if ($this->member->getSex() == 'F' && $this->member->getLookingFor() == 'M')
          {
            $this->setFlash('msg_warning', 'F_M No photo can get you flagged by other members. Please add photo as soon as you can.', false);
          }
          else if ($this->member->getSex() == 'F' && $this->member->getLookingFor() == 'F')
          {
            $this->setFlash('msg_warning', 'F_F No photo can get you flagged by other members. Please add photo as soon as you can.', false);
          }
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
        $c->setLimit($this->getUser()->getProfile()->getSubscriptionDetails()->getSeeViewed());
                
        $this->visits = ProfileViewPeer::doSelectJoinMemberRelatedByMemberId($c);
    }
    
    public function validateVisitors()
    {
        //subscription limits/restrictions ?
        $member = $this->getUser()->getProfile();
        if( !$member->getSubscriptionDetails()->getCanSeeViewed() )
        {
            $this->setFlash('msg_error', sprintf('%s: In order to see who viewed your profile you need to upgrade your membership.', $member->getSubscription()->getTitle()));
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
        
      } elseif( $this->getRequestParameter('re') && in_array($member->getMemberStatusId(), array(MemberStatusPeer::DEACTIVATED, MemberStatusPeer::DEACTIVATED_AUTO)))
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

        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
            
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {   
            $member->changeStatus(MemberStatusPeer::CANCELED_BY_MEMBER, false);
            $member->save();
            
            Events::triggerAccountDeleteByMember($member, nl2br(strip_tags($this->getRequestParameter('delete_reason'))));
            
            $this->getUser()->signOut();
            $this->getUser()->setAttribute('member_id', $member->getId()); //we need this to receive member's profile in the confirmation message page
            
            $this->message('delete_account_confirm');
        }
        
        $this->member = $member;
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
            $modified = ( $member->getPrivateDating() != $this->getRequestParameter('private_dating') );
            
            $member->setPrivateDating($this->getRequestParameter('private_dating', 0));
            if( $this->getRequestParameter('private_dating', 0) == 1) 
            {
                $member->setPublicSearch(false);
                $member->deleteHomepagePhotos();
            }
            
            $member->setContactOnlyFullMembers($this->getRequestParameter('contact_only_full_members', 0));
            
            if( $modified && $this->getUser()->getProfile()->getSubscriptionId() != SubscriptionPeer::VIP )
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
        
        $this->photo = StockPhotoPeer::getAssistantPhotoByCatalog($this->getUser()->getCatalog());
    }
    
    public function validateContactYourAssistant()
    {
        $subscription = $this->getUser()->getProfile()->getSubscriptionDetails();
        if( !$subscription->getCanContactAssistant() )
        {
          $this->getRequest()->setError('subscription', sprintf('%s: In order to contact assistant you need to upgrade your membership.', $subscription->getTitle()));
          return false;
        }
        
        if( $this->getUser()->getProfile()->getCounter('AssistantContactsDay') >= $subscription->getContactAssistantDay() )
        {
          $this->getRequest()->setError('subscription', sprintf('%s: For the feature that you want to use - contact assistant - you have reached the daily limit up to which you can use it with your membership. In order to contact online assistant, please upgrade your membership.', $subscription->getTitle()));
            return false;            
        }
                
        if( $this->getUser()->getProfile()->getCounter('AssistantContacts') >= $subscription->getContactAssistant() )
        {
          $this->getRequest()->setError('subscription', sprintf('%s: For the feature that you want to use - contact assistant - you have reached the limit up to which you can use it with your membership. In order to contact online assistant, please upgrade your membership.', $subscription->getTitle()));
            return false;            
        }
                
        return true;
    }
    
    public function handleErrorContactYourAssistant()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Assistant request title'));
        $this->photo = StockPhotoPeer::getAssistantPhotoByCatalog($this->getUser()->getCatalog());
        return sfView::SUCCESS;
    }
    
    public function executeContactAssistantConfirmation()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Assistant request title', 'uri' => 'dashboard/contactYourAssistant'))->add(array('name' => 'Assistant response title'));
        $this->photo = StockPhotoPeer::getAssistantPhotoByCatalog($this->getUser()->getCatalog());
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
            
            $member->updateStraightMatches();
            $msg = ($hasSearchCriteria) ? 'Your Match Criteria have been updated' : 'You have just set up your search criteria';
            $this->setFlash('msg_ok', $msg);
            $this->redirect('dashboard/index');
        }
        else
        {
          $this->warningTimeout();
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
        
        $this->warningTimeout();

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
    
    public function executePhotoAccess()
    {
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::MEMBER_ID, $this->getUser()->getId());
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $c->addDescendingOrderByColumn(PrivatePhotoPermissionPeer::CREATED_AT);
        $c->add(PrivatePhotoPermissionPeer::STATUS, 'A');
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'P');
        $this->my_grants = PrivatePhotoPermissionPeer::doSelectJoinMemberRelatedByProfileId($c);
        
        $c = new Criteria();
        $c->add(PrivatePhotoPermissionPeer::PROFILE_ID, $this->getUser()->getId());
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        
        //privacy check
        $c->addJoin(PrivatePhotoPermissionPeer::PROFILE_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. PrivatePhotoPermissionPeer::MEMBER_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);
        
        $c->addDescendingOrderByColumn(PrivatePhotoPermissionPeer::CREATED_AT);
        $c->add(PrivatePhotoPermissionPeer::STATUS, 'A');
        $c->add(PrivatePhotoPermissionPeer::TYPE, 'R');
        $this->other_grants = PrivatePhotoPermissionPeer::doSelectJoinMemberRelatedByMemberId($c);
    }
}
