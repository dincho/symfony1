<?php
/**
 * members actions.
 *
 * @package    pr
 * @subpackage members
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class membersActions extends prActions
{
    
    public function preExecute()
    {
        if ($this->getRequestParameter('cancel') == 1)
        {
            $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved');
            $this->redirect($this->getModuleName() . '/' . $this->getActionName() . '?id=' . $this->getRequestParameter('id'));
        }
        
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/members/filters');
        $bc = $this->getUser()->getBC();
        $bc->removeLast();
        
        if ($this->getActionName() != 'list')
            $this->addFiltersCriteria(new Criteria()); //left menu selection
        

        if (! count($this->filters))
        {
            $this->left_menu_selected = 'All Members';
            $bc->add(array('name' => 'All Members', 'uri' => 'members/list'));
        }
        
        if ($this->getRequestParameter('id'))
        {
            $member = MemberPeer::retrieveByPkJoinAll($this->getRequestParameter('id'));
            $this->forward404Unless($member);
            $bc->add(array('name' => $member->getUsername(), 'uri' => 'members/edit?id=' . $member->getId()));
            
            $this->member = $member;
        }
    }

    public function executeIndex()
    {
        return $this->forward('members', 'list');
    }

    public function executeList()
    {
        $this->processSort();
        
        $c = new Criteria();
        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAll');
        $pager->setPeerCountMethod('doCountJoinAll');
        $pager->init();
        $this->pager = $pager;
    
        if( $this->getRequestParameter('page', 1)  == 1 )
        {   
            $pc = clone $c;
            $pc->setLimit(null);
            $pc->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);
            $pc->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);
            $pc->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID);
            $rs = MemberPeer::doSelectRS($pc);
            $profile_pager_members = array();

            while($rs->next()) {
                $profile_pager_members[] = $rs->getInt(1);
            }
        
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/members/profile_pager');
            $this->getUser()->getAttributeHolder()->add($profile_pager_members, 'backend/members/profile_pager');
        }
    }

    public function executeCreate()
    {
        $member = new Member();
        $this->member = $member;
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            
            $member->setUsername($this->getRequestParameter('username'));
            $member->setEmail($this->getRequestParameter('email'));
            $member->setPassword($this->getRequestParameter('password'));
            $member->changeStatus(MemberStatusPeer::PENDING);
            $member->changeSubscription(SubscriptionPeer::FREE, $this->getUser()->getUsername() . ' (create)');
            $member->parseLookingFor($this->getRequestParameter('looking_for', 'M_F'));
            $member->setCountry($this->getRequestParameter('country'));
            $member->setAdm1Id($this->getRequestParameter('adm1_id'));
            $member->setAdm2Id($this->getRequestParameter('adm2_id'));
            $member->setCityId($this->getRequestParameter('city_id'));
            $member->setZip($this->getRequestParameter('zip'));
            $member->setNationality($this->getRequestParameter('nationality'));
            $member->setFirstName($this->getRequestParameter('first_name'));
            $member->setLastName($this->getRequestParameter('last_name'));
                        
            $member->initNewMember();
            $member->setHasEmailConfirmation(true);
            $member->save();
            
            $this->setFlash('msg_ok', 'You have added a member, please finish registration');
            $this->redirect('members/editSelfDescription?id=' . $member->getId());
        }
        
        $this->has_adm1 = false;
        $this->has_adm2 = false;
    }
    
    public function validateCreate()
    {
        $return = true;
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $geoValidator = new prGeoValidator();
            $geoValidator->initialize($this->getContext());
            
            $nationality = $this->getRequestParameter('nationality');
            $username = $this->getRequestParameter('username');

            $value = $error = null;
            if( !$geoValidator->execute(&$value, &$error) )
            {
                $this->getRequest()->setError($error['field_name'], $error['msg']);
                $return = false;
            }
            
            if( !$nationality )
            {
                $this->getRequest()->setError('nationality', 'Please provide your nationality.');
                $return = false;
            }
            
            if( !$username )
            {
                $this->getRequest()->setError('username', 'Pease create your username.');
                $return = false;
            }
          
            $myRegexValidator = new sfRegexValidator();
            $myRegexValidator->initialize($this->getContext(), array(
                'match'       => true,
                'pattern'     => '/^[a-zA-Z0-9_]{4,20}$/',
            ));
            if (!$myRegexValidator->execute($username, $error))
            {
                $this->getRequest()->setError('username', 'Allowed characters for username are [a-zA-Z][0-9] and underscore, min 4 chars max 20.');
                $return = false;
            }
            
            $myRegexValidator2 = new sfRegexValidator();
            $myRegexValidator2->initialize($this->getContext(), array(
                'match'       => false,
                'pattern'     => '/^_.*$/',
            ));
            if (!$myRegexValidator2->execute($username, $error))
            {
                $this->getRequest()->setError('username', 'Username cannot start with underscore');
                $return = false;
            }
            
            $myUniqueValidator = new sfPropelUniqueValidator();
            $myUniqueValidator->initialize($this->getContext(), array(
                'class'        => 'Member',
                'column'       => 'username',
            ));
            if (!$myUniqueValidator->execute($username, $error))
            {
                $this->getRequest()->setError('username', 'This username is already taken.');
                $return = false;
            }

        }
        
        return $return;
    }
    
    public function handleErrorCreate()
    {
        $this->has_adm1 = GeoPeer::hasAdm1AreasIn($this->getRequestParameter('country'));
        
        if( $this->getRequestParameter('adm1_id') && 
            $adm1 = GeoPeer::getAdm1ByCountryAndPK($this->getRequestParameter('country'), $this->getRequestParameter('adm1_id'))
          )
        {
          $this->has_adm2 = $adm1->hasAdm2Areas();
        } else {
          $this->has_adm2 = false;
        }
                
        return sfView::SUCCESS;
    }

    public function executeEdit()
    {
        $this->getUser()->getBC()->add(array('name' => 'Overview', 'uri' => 'members/edit?id=' . $this->member->getId()));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('members_edit'));
            
            if ($this->getRequestParameter('submit_save'))
            {
                $this->member->setFirstName($this->getRequestParameter('first_name'));
                $this->member->setLastName($this->getRequestParameter('last_name'));
                $this->member->setEmail($this->getRequestParameter('email'));
                $this->member->changeStatus($this->getRequestParameter('member_status_id'));
                $this->member->parseLookingFor($this->getRequestParameter('orientation', 'M_F'));
                $this->member->setPurpose($this->getRequestParameter('purpose'));
                $this->member->setCatalogId($this->getRequestParameter('catalog_id'));
                
                //change the subscription and clear the last subscription item
                $subscription_id = $this->getRequestParameter('subscription_id');
                if ( $this->member->getSubscriptionId() != $subscription_id )
                {
                  $this->member->changeSubscription($subscription_id, $this->getUser()->getUsername() . ' (edit)');
                }
                
                $this->member->save();
                $this->setFlash('msg_ok', 'Your changes have been saved');
                $this->redirect('members/edit?id=' . $this->member->getId());
            } elseif ($this->getRequestParameter('add_note'))
            {
                
                $this->forward('members', 'addNote');
            }
        
        } else
        {
            $c = new Criteria();
            $c->add(FlagPeer::MEMBER_ID, $this->member->getId());
            $c->add(FlagPeer::IS_HISTORY, false);
            $c->addDescendingOrderByColumn(FlagPeer::CREATED_AT);
            $this->flags = FlagPeer::doSelectJoinAll($c);
            
            $c = new Criteria();
            $c->add(MemberNotePeer::MEMBER_ID, $this->member->getId());
            $this->notes = MemberNotePeer::doSelectJoinAll($c);
            
            $member = clone $this->member;
            $member->setReviewedById($this->getUser()->getId());
            $member->setReviewedAt(time());
            $member->save();
        }
    }

    public function handleErrorEdit()
    {
        $this->preExecute();
                
        $this->getUser()->getBC()->add(array('name' => 'Overview', 'uri' => 'members/edit?id=' . $this->member->getId()));
        
        $c = new Criteria();
        $c->add(FlagPeer::MEMBER_ID, $this->member->getId());
        $c->add(FlagPeer::IS_HISTORY, false);
        $c->addDescendingOrderByColumn(FlagPeer::CREATED_AT);
        $this->flags = FlagPeer::doSelectJoinAll($c);
        
        $c = new Criteria();
        $c->add(MemberNotePeer::MEMBER_ID, $this->member->getId());
        $this->notes = MemberNotePeer::doSelectJoinAll($c);
        
        $member = clone $this->member;
        $member->setReviewedById($this->getUser()->getId());
        $member->setReviewedAt(time());
        $member->save();
                    
        return sfView::SUCCESS;
    }
    
    public function executeEditRegistration()
    {
        $this->forward404Unless($this->member);
        $this->getUser()->getBC()->add(array('name' => 'Registration', 'uri' => 'members/editRegistration?id=' . $this->member->getId()));
        $this->adm1s = GeoPeer::getAllByCountry($this->member->getCountry());
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('members_edit'));
            $this->member->setCountry($this->getRequestParameter('country'));
            $this->member->setAdm1Id($this->getRequestParameter('adm1_id'));
            $this->member->setAdm2Id($this->getRequestParameter('adm2_id'));
            $this->member->setCityId($this->getRequestParameter('city_id'));
            $this->member->setZip($this->getRequestParameter('zip'));
            $this->member->setNationality($this->getRequestParameter('nationality'));
            if ($this->getRequestParameter('password')) //password changed
            {
                $this->member->setPassword($this->getRequestParameter('password'));
            }
            $this->member->save();
            $this->setFlash('msg_ok', 'Your changes have been saved');
            $this->redirect('members/editRegistration?id=' . $this->member->getId());
        } else {
          $this->has_adm1 = ( !is_null($this->member->getAdm1Id()) ) ? true : false;
          $this->has_adm2 = ( !is_null($this->member->getAdm2Id()) ) ? true : false;          
        }
    }
    
    public function validateEditRegistration()
    {
        $return = true;
        
        if ($this->getRequest()->getMethod() == sfRequest::POST )
        {
            $geoValidator = new prGeoValidator();
            $geoValidator->initialize($this->getContext());
            
            $nationality = $this->getRequestParameter('nationality');

            $value = $error = null;
            if( !$geoValidator->execute(&$value, &$error) )
            {
                $this->getRequest()->setError($error['field_name'], $error['msg']);
                $return = false;
            } 
            
            if( !$nationality )
            {
                $this->getRequest()->setError('nationality', 'Please provide your nationality.');
                $return = false;
            }           
        }
        
        return $return;
    }
    
    public function handleErroreditRegistration()
    {
        $this->member = MemberPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($this->member); //just in case
        
        $this->has_adm1 = GeoPeer::hasAdm1AreasIn($this->getRequestParameter('country'));
        
        if( $this->getRequestParameter('adm1_id') && 
            $adm1 = GeoPeer::getAdm1ByCountryAndPK($this->getRequestParameter('country'), $this->getRequestParameter('adm1_id'))
          )
        {
          $this->has_adm2 = $adm1->hasAdm2Areas();
        } else {
          $this->has_adm2 = false;
        } 
                
        return sfView::SUCCESS;
    }

    public function executeEditSelfDescription()
    {
        $this->getUser()->getBC()->add(array('name' => 'Self-Description', 'uri' => 'members/editSelfDescription?id=' . $this->member->getId()));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('members_edit'));
            $this->member->setDontDisplayZodiac($this->getRequestParameter('dont_display_zodiac'));
            $this->member->clearDescAnswers();
            $others = $this->getRequestParameter('others');
            
            foreach ($this->getRequestParameter('answers') as $question_id => $value)
            {
                $q = DescQuestionPeer::retrieveByPK($question_id);
                $m_answer = new MemberDescAnswer();
                $m_answer->setDescQuestionId($q->getId());
                $m_answer->setMemberId($this->member->getId());
                
                if (! is_null($q->getOther()) && $value == 'other' && isset($others[$question_id]))
                {
                    $m_answer->setDescAnswerId(null);
                    $m_answer->setOther($others[$question_id]);
                } elseif ($q->getType() == 'other_langs')
                {
                    $m_answer->setOtherLangs($value);
                    $m_answer->setDescAnswerId(null);
                } elseif ($q->getType() == 'native_lang')
                {
                    $m_answer->setCustom($value);
                    $m_answer->setDescAnswerId(null);
                    $this->member->setLanguage($value);
                } elseif ($q->getType() == 'age')
                {
                    $birthday = date('Y-m-d', mktime(0, 0, 0, $value['month'], $value['day'], $value['year']));
                    $m_answer->setCustom($birthday);
                    $m_answer->setDescAnswerId(null);
                    $this->member->setBirthDay($birthday);
                } else
                {
                    $m_answer->setDescAnswerId( ($value) ? $value : null);
                }
                $m_answer->save();
                
                //millionaire check
                if( $question_id == 7 ) $this->member->setMillionaire( ($value > 26) );                 
            }
            $this->member->save();
            $this->setFlash('msg_ok', 'Your changes have been saved');
            $this->redirect('members/editSelfDescription?id=' . $this->member->getId());
        }
        
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
    }

    public function executeEditEssay()
    {
        $this->getUser()->getBC()->add(array('name' => 'Essay', 'uri' => 'members/editEssay?id=' . $this->member->getId()));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('members_edit'));
            $this->member->setEssayHeadline($this->getRequestParameter('essay_headline'));
            $this->member->setEssayIntroduction($this->getRequestParameter('essay_introduction'));
            $this->member->save();
            $this->member->clearCache();
            $this->setFlash('msg_ok', 'Your changes have been saved');
            $this->redirect('members/editEssay?id=' . $this->member->getId());
        }
    }

    public function handleErrorEditEssay()
    {
      $member = MemberPeer::retrieveByPkJoinAll($this->getRequestParameter('id'));
      $this->forward404Unless($member);
      $this->member = $member;
      
      return sfView::SUCCESS;
    }
    
    public function executeEditPhotos()
    {
        $this->getResponse()->addJavascript('photos', 'last');
        $this->getResponse()->addJavascript('swfupload/swfupload.js', 'last');
        $this->getResponse()->addJavascript('swfupload/handlers.js', 'last');
        $this->getUser()->getBC()->add(array('name' => 'Photos', 'uri' => 'members/editPhotos?id=' . $this->member->getId()));
        
        $this->public_photos = $this->member->getPublicMemberPhotos();
        $this->private_photos = $this->member->getPrivateMemberPhotos();
    }
    
    public function handleErrorEditPhotos()
    {
        $member = MemberPeer::retrieveByPkJoinAll($this->getRequestParameter('id'));
        $this->forward404Unless($member);
        $this->member = $member;
        
        $this->photos = $this->member->getPublicMemberPhotos();
        $this->selected_photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
              
        $this->getUser()->getBC()->add(array('name' => 'Photos', 'uri' => 'members/editPhotos?id=' . $this->member->getId()));

        return sfView::SUCCESS; 
    }

    public function executeEditIMBRA()
    {
        $this->getUser()->getBC()->add(array('name' => 'IMBRA', 'uri' => 'members/editIMBRA?id=' . $this->member->getId()));
        $this->imbra = $this->member->getLastImbra();
    }

    public function executeEditSearchCriteria()
    {
        $this->getUser()->getBC()->add(array('name' => 'Search Criteria', 'uri' => 'members/editSearchCriteria?id=' . $this->member->getId()));
        $this->getResponse()->addJavascript('SC_select_all');
        
        $questions = DescQuestionPeer::doSelect(new Criteria());
        $this->questions = $questions;
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('members_edit'));
            $member_answers = $this->getRequestParameter('answers', array());
            $member_match_weights = $this->getRequestParameter('weights');
            $this->member->clearSearchCriteria();
            
            foreach ($questions as $question)
            {
                if (array_key_exists($question->getId(), $member_answers))
                {
                    $search_crit_desc = new SearchCritDesc();
                    $search_crit_desc->setMemberId($this->member->getId());
                    $search_crit_desc->setDescQuestionId($question->getId());
                    $member_answers_vals = (is_array($member_answers[$question->getId()])) ? array_values(
                            $member_answers[$question->getId()]) : (array) $member_answers[$question->getId()];
                    $search_crit_desc->setDescAnswers(implode(',', $member_answers_vals));
                    $search_crit_desc->setMatchWeight($member_match_weights[$question->getId()]);
                    $search_crit_desc->save();
                }
            }
            
            $this->member->updateMatches();
            $this->setFlash('msg_ok', 'Your changes have been saved');
        }
        
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_crit_desc = $this->member->getSearchCritDescsArray();
    }
    
    public function validateEditSearchCriteria()
    {
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $questions = DescQuestionPeer::doSelect(new Criteria());
            $answers = $this->getRequestParameter('answers', array());
            //print_r($answers);exit();
            $has_error = false;
            $add_error = false;
            foreach ($questions as $question)
            {
                if( $question->getType() == 'age' )
                {
                    $ages = $answers[$question->getId()];
                    if( !is_array($ages) || $ages[0] < 18 || $ages[1] > 100 || $ages[1] < $ages[0] )
                    {
                        $this->getRequest()->setError('answers[' . $question->getId() . ']', 'Please enter correct ages range');
                        $has_error = true;      
                    }
                } elseif( $question->getType() == 'select' && (!is_array($answers[$question->getId()]) || $answers[$question->getId()]['from'] > $answers[$question->getId()]['to']) )
                {
                        $this->getRequest()->setError('answers[' . $question->getId() . ']', 'Please select correct range');
                        $has_error = true;
                } elseif( $question->getIsRequired() && !isset($answers[$question->getId()]) )
                {
                        $this->getRequest()->setError('answers[' . $question->getId() . ']', 'You must fill out the missing information');
                        $has_error = true;
                        
                }
            }
            
            if ($has_error)
            {
                return false;
            }
        }
        
        return true;
    }

    public function handleErrorEditSearchCriteria()
    {
        if ($this->getRequestParameter('id'))
        {
            $member = MemberPeer::retrieveByPkJoinAll($this->getRequestParameter('id'));
            $this->forward404Unless($member);
            $this->getUser()->getBC()->add(array('name' => $member->getUsername(), 'uri' => 'members/edit?id=' . $member->getId()));
            
            $this->member = $member;
        }
            	
        $this->getUser()->getBC()->add(array('name' => 'Search Criteria', 'uri' => 'members/editSearchCriteria?id=' . $this->member->getId()));
        $this->getResponse()->addJavascript('SC_select_all');
        
        $questions = DescQuestionPeer::doSelect(new Criteria());
        $this->questions = $questions;
        
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_crit_desc = $this->member->getSearchCritDescsArray();       

        return sfView::SUCCESS;
    }

    public function executeEditStatusHistory()
    {
        $this->getUser()->getBC()->add(array('name' => 'Status History', 'uri' => 'members/editStatusHistory?id=' . $this->member->getId()));
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MemberStatusHistoryPeer::CREATED_AT);
        $this->history = $this->member->getMemberStatusHistorysJoinMemberStatus($c);
    }
    
    public function executeEditSubscriptionHistory()
    {
        $this->getUser()->getBC()->add(array('name' => 'Subscription History', 'uri' => 'members/editSubscriptionHistory?id=' . $this->member->getId()));
        $c = new Criteria();
        $c->addDescendingOrderByColumn(SubscriptionHistoryPeer::CREATED_AT);
        $this->history = $this->member->getSubscriptionHistorys($c);
    }    

    public function executeSubscriptions()
    {
        $c = new Criteria();
        $c->add(MemberSubscriptionPeer::MEMBER_ID, $this->member->getId());
        $c->addDescendingOrderByColumn(MemberSubscriptionPeer::UPDATED_AT);
        $this->subscriptions = MemberSubscriptionPeer::doSelect($c);
        
        $this->currentSubscriptionId = ($this->member->getCurrentMemberSubscription()) ? $this->member->getCurrentMemberSubscription()->getId() : null;
    }
    
    public function executePayments()
    {
        $c = new Criteria();
        $c->add(MemberPaymentPeer::MEMBER_ID, $this->member->getId());
        $c->addDescendingOrderByColumn(MemberPaymentPeer::UPDATED_AT);
        $this->payments = MemberPaymentPeer::doSelect($c);
    }

    public function executeEditOpenPrivacy()
    {
        $this->getUser()->getBC()->add(array('name' => 'Privacy Relations', 'uri' => 'members/editPrivacyRelations?id=' . $this->member->getId()));
        
        $c = new Criteria();
        
        if ($this->getRequestParameter('received_only'))
        {
            $c->add(OpenPrivacyPeer::PROFILE_ID, $this->member->getId());
            $c->addJoin(OpenPrivacyPeer::MEMBER_ID, MemberPeer::ID, Criteria::LEFT_JOIN);
        } 
        else
        {
            $c->add(OpenPrivacyPeer::MEMBER_ID, $this->member->getId());
            $c->addJoin(OpenPrivacyPeer::PROFILE_ID, MemberPeer::ID, Criteria::LEFT_JOIN);
        }
        $c->addDescendingOrderByColumn(OpenPrivacyPeer::CREATED_AT);
        $this->open_privacy = OpenPrivacyPeer::doSelect($c);
    }    


    public function executeStar()
    {
        $this->getUser()->checkPerm(array('members_edit'));
        $this->forward404Unless($this->member);
        
        $this->member->setIsStarred(! $this->member->IsStarred());
        $this->member->save();
        
        $this->redirect($this->getUser()->getRefererUrl());
    }

    public function executeAddNote()
    {
        $this->getUser()->checkPerm(array('members_edit'));
        $this->forward404Unless($this->member);
        
        $note = new MemberNote();
        $note->setMember($this->member);
        $note->setUserId($this->getUser()->getId());
        $note->setText($this->getRequestParameter('note_content'));
        $note->save();
        
        if( $this->getRequestParameter('flagger'))
        {
            $this->redirect('flags/profileFlagger?id=' . $this->member->getId());
        } elseif($this->getRequestParameter('flagged'))
        {
            $this->redirect('flags/profileFlagged?id=' . $this->member->getId());
        } else {
            $this->redirect('members/edit?id=' . $this->member->getId());
        }
    }

    public function executeConfirmEmail()
    {
        $this->getUser()->checkPerm(array('members_edit'));
        $this->forward404Unless($this->member);
        
        $this->member->setHasEmailConfirmation(true);
        $this->member->save();
        
        $this->setFlash('msg_ok', sprintf("%s's email address has been confirmed", $this->member->getUsername()));
        $this->redirect('members/edit?id=' . $this->member->getId());
    }
    
    public function executeResendActivationEmail()
    {
        $this->getUser()->checkPerm(array('members_edit'));
        $this->forward404Unless($this->member);
        
        if( Events::triggerJoin($this->member) )
        {
            $this->setFlash('msg_ok', sprintf("%s's activation email has been re-sent to address: %s", $this->member->getUsername(), $this->member->getEmail()));
            
            $note = new MemberNote();
            $note->setMember($this->member);
            $note->setUserId($this->getUser()->getId());
            $note->setText('activation email sent');
            $note->save();
                    
        } else {
            $this->setFlash('msg_error', sprintf("%s's activation email can not be re-sent to address: %s", $this->member->getUsername(), $this->member->getEmail()));            
        }
        
        $this->redirect('members/edit?id=' . $this->member->getId());
    }    

    public function executeVerifyPhoto()
    {
        $this->getUser()->checkPerm(array('members_edit'));
        $this->forward404Unless($this->member);
        
        $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
        $this->forward404Unless($photo);
        
        $photo->setAuth($this->getRequestParameter('auth'));
        $photo->save();
        
        $this->setFlash('msg_ok', "Member's photo authenticity successfully changed");
        $this->redirect($this->getUser()->getRefererUrl());
    }
        
    protected function processSort()
    {
        $this->sort_namespace = 'backend/members/sort';
        
        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }
        
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'Member::created_at', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $this->sort_namespace); //default order
        }
    }

    protected function addSortCriteria($c)
    {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $sort_arr = explode('::', $sort_column);
            $peer = $sort_arr[0] . 'Peer';
            
            $sort_column = call_user_func(array($peer,'translateFieldName'), $sort_arr[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
            if ($this->getUser()->getAttribute('type', null, $this->sort_namespace) == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
            } else
            {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }

    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/members/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/members/filters');
        }
    }

    protected function addFiltersCriteria($c)
    {
        $bc = $this->getUser()->getBC();
        
        if (isset($this->filters['sex']))
        {
            foreach($this->filters['sex'] as $orientation)
            {
                $sex_looking = explode('_', $orientation);
                $crit = $c->getNewCriterion(MemberPeer::SEX, $sex_looking[0]);
                $crit->addAnd($c->getNewCriterion(MemberPeer::LOOKING_FOR, $sex_looking[1]));
                $c->addOr($crit);
            }
        }
        
        if (isset($this->filters['subscription_id']))
        {
            $c->add(MemberPeer::SUBSCRIPTION_ID, $this->filters['subscription_id'], Criteria::IN);
        }
        
        if ( isset($this->filters['countries']) )
        {
            if( in_array('THE_REST', $this->filters['countries']) )
            {
                $c->add(MemberPeer::COUNTRY, array('PL', 'US', 'CA', 'GB', 'IE'), Criteria::NOT_IN);
            } else {
                $c->add(MemberPeer::COUNTRY, $this->filters['countries'], Criteria::IN);
            }
        }
        
        if (isset($this->filters['status_id']))
        {
            $c->add(MemberPeer::MEMBER_STATUS_ID, $this->filters['status_id'], Criteria::IN);
        }
        
        if (isset($this->filters['languages']))
        {
            $c->add(MemberPeer::LANGUAGE, $this->filters['languages'], Criteria::IN);
        }        
        
        if (isset($this->filters['is_starred']))
        {
            $c->add(MemberPeer::IS_STARRED, true);
            $bc->add(array('name' => 'Starred Members', 'uri' => 'members/list?filter=filter&filters[is_starred]=1'));
            $this->left_menu_selected = 'Starred Members';
        }
        
        if (isset($this->filters['flagged']))
        {
            $c->add(MemberCounterPeer::CURRENT_FLAGS, 0, Criteria::GREATER_THAN);
            $bc->add(array('name' => 'Flagged Members', 'uri' => 'members/list?filter=filter&filters[flagged]=1'));
            $this->left_menu_selected = 'Flagged Members';
        }
        
        if (isset($this->filters['canceled']))
        {
            $crit = $c->getNewCriterion(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::CANCELED);
            $crit->addOr($c->getNewCriterion(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::CANCELED_BY_MEMBER));
            $c->add($crit);
            
            $bc->add(array('name' => 'Deleted Members', 'uri' => 'members/list?filter=filter&filters[deleted]=1'));
            $this->left_menu_selected = 'Deleted Members';
        }
        
        if (isset($this->filters['no_email_confirmation']))
        {
            $c->add(MemberPeer::HAS_EMAIL_CONFIRMATION, false);
            $bc->add(array('name' => 'Not activated yet', 'uri' => 'members/list?filter=filter&filters[no_email_confirmation]=1'));
            $this->left_menu_selected = 'Not activated yet';
        }
                
        if (isset($this->filters['search_type']) && isset($this->filters['search_query']) && strlen($this->filters['search_query']) > 0)
        {
            switch ($this->filters['search_type']) {
                case 'first_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'members/list?'));
                    $c->add(MemberPeer::FIRST_NAME, $this->filters['search_query']);

                    break;
                case 'last_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'members/list?'));
                    $c->add(MemberPeer::LAST_NAME, $this->filters['search_query']);

                    break;
                case 'email':
                    $bc->add(array('name' => 'Search', 'uri' => 'members/list?'));
                    $c->add(MemberPeer::EMAIL, $this->filters['search_query']);

                    break;                
                default:
                    $bc->add(array('name' => 'Search', 'uri' => 'members/list?'));
                    $c->add(MemberPeer::USERNAME, $this->filters['search_query']);

                    break;
            }
        }
    }
}
