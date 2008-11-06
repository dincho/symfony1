<?php
/**
 * members actions.
 *
 * @package    pr
 * @subpackage members
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class membersActions extends sfActions
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
        
        if( $this->getActionName() != 'list') $this->addFiltersCriteria(new Criteria()); //left menu selection
        
        if( !count($this->filters) )
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
        $c = new Criteria();
        $this->addFiltersCriteria($c);
                
        $per_page = ( $this->getRequestParameter('per_page', 0) <= 0 ) ? sfConfig::get('app_pager_default_per_page') : $this->getRequestParameter('per_page');
        
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAll');
        $pager->setPeerCountMethod('doCount');
        $pager->init();
        $this->pager = $pager;
        
    }

    public function executeCreate()
    {
        $this->member = new Member();
        $this->setTemplate('edit');
    }

    public function executeEdit()
    {
        $this->getUser()->getBC()->add(array('name' => 'Overview', 'uri' => 'members/edit?id=' . $this->member->getId()));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if( $this->getRequestParameter('submit_save') )
            {
                $this->member->setFirstName($this->getRequestParameter('first_name'));
                $this->member->setLastName($this->getRequestParameter('last_name'));
                $this->member->setEmail($this->getRequestParameter('email'));
                $this->member->changeStatus($this->getRequestParameter('member_status_id'));
                $this->member->save();
                $this->setFlash('msg_ok', 'Your changes have been saved');
                $this->redirect('members/edit?id=' . $this->member->getId());               
            } elseif($this->getRequestParameter('add_note')) {
                
                $this->forward('members', 'addNote');
            }

        } else {
            $c = new Criteria();
            $c->add(FlagPeer::MEMBER_ID, $this->member->getId());
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

    public function executeEditRegistration()
    {
        $this->getUser()->getBC()->add(array('name' => 'Registration', 'uri' => 'members/editRegistration?id=' . $this->member->getId()));
        $this->states = StatePeer::getAllByCountry($this->member->getCountry());
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->member->setCountry($this->getRequestParameter('country'));
            if($this->getRequestParameter('state_id')) $this->member->setStateId($this->getRequestParameter('state_id'));
            $this->member->setDistrict($this->getRequestParameter('district'));
            $this->member->setCity($this->getRequestParameter('city'));
            $this->member->setZip($this->getRequestParameter('zip'));
            $this->member->setNationality($this->getRequestParameter('nationality'));
            $this->member->save();
            $this->setFlash('msg_ok', 'Your changes have been saved');
            $this->redirect('members/editRegistration?id=' . $this->member->getId());
        }
    }

    public function executeEditSelfDescription()
    {
        $this->getUser()->getBC()->add(array('name' => 'Self-Description', 'uri' => 'members/editSelfDescription?id=' . $this->member->getId()));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $birthday_arr = $this->getRequestParameter('birth_day');
            $birthday = $birthday_arr['year'] . '-' . $birthday_arr['month'] . '-' . $birthday_arr['day'];
            $this->member->setBirthDay($birthday);
            $this->member->setDontDisplayZodiac($this->getRequestParameter('dont_display_zodiac'));
            $this->member->save();
            
            //update member self description Q/A
            $this->member->clearDescAnswers();
            
            foreach ($this->getRequestParameter('answers') as $question_id => $value)
            {
                $q = DescQuestionPeer::retrieveByPK($question_id);
                
                $m_answer = new MemberDescAnswer();
                $m_answer->setDescQuestionId($question_id);
                $m_answer->setMemberId($this->member->getId());
                                    
                if( $q->getType() == 'other_langs' )
                {
                    $m_answer->setOtherLangs($value);
                    $m_answer->setDescAnswerId(null);
                } else {
                    $m_answer->setDescAnswerId($value);
                }
                
                $m_answer->save();
            }
            
            $this->setFlash('msg_ok', 'Your changes have been saved');
            //$this->redirect('members/editSelfDescription?id=' . $this->member->getId());
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
            $this->member->setEssayHeadline($this->getRequestParameter('essay_headline'));
            $this->member->setEssayIntroduction($this->getRequestParameter('essay_introduction'));
            $this->member->save();
            $this->setFlash('msg_ok', 'Your changes have been saved');
            $this->redirect('members/editEssay?id=' . $this->member->getId());
        }
    }

    public function executeEditPhotos()
    {
        $this->getUser()->getBC()->add(array('name' => 'Photos', 'uri' => 'members/editPhotos?id=' . $this->member->getId()));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            //crop the photo if selected
            if ($this->getRequestParameter('photo_id'))
            {
                $crop_area['x1'] = $this->getRequestParameter('crop_x1');
                $crop_area['y1'] = $this->getRequestParameter('crop_y1');
                $crop_area['x2'] = $this->getRequestParameter('crop_x2');
                $crop_area['y2'] = $this->getRequestParameter('crop_y2');
                $crop_area['width'] = $this->getRequestParameter('crop_width');
                $crop_area['height'] = $this->getRequestParameter('crop_height');
                $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
                $this->forward404Unless($photo);
                $photo->updateCroppedImage($crop_area);
            }
            //add new photo if choosen
            if ($this->getRequest()->getFileSize('new_photo'))
            {
                $new_photo = new MemberPhoto();
                $new_photo->setMember($this->member);
                $new_photo->updateImageFromRequest('file', 'new_photo');
                $new_photo->save();
            }
            //set main photo
            if ($this->getRequestParameter('main_photo'))
            {
                $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('main_photo'));
                $photo->setAsMainPhoto();
            }
            //set confirm msg and redirect
            $this->setFlash('msg_ok', 'Your changes have been saved');
            $this->redirect('members/editPhotos?id=' . $this->member->getId());
        }
        $this->photos = $this->member->getMemberPhotos();
        $this->selected_photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
        //$this->getResponse()->addJavascript('fileUploads.js');
        $this->getResponse()->addJavascript('/cropper/lib/prototype.js');
        $this->getResponse()->addJavascript('/cropper/lib/scriptaculous.js?load=builder,dragdrop');
        $this->getResponse()->addJavascript('/cropper/cropper.js');
        $this->getResponse()->addStyleSheet('/cropper/cropper.css', 'last');
    }

    public function executeEditIMBRA()
    {
        $this->getUser()->getBC()->add(array('name' => 'IMBRA', 'uri' => 'members/editIMBRA?id=' . $this->member->getId()));
        $this->imbra = $this->member->getLastImbra();
    }

    public function executeEditSearchCriteria()
    {
        $this->getUser()->getBC()->add(array('name' => 'Search Criteria', 'uri' => 'members/editSearchCriteria?id=' . $this->member->getId()));
        $c = new Criteria();
        $c->addJoin(DescQuestionPeer::ID, SearchCritDescPeer::DESC_QUESTION_ID, Criteria::LEFT_JOIN);
        //$c->addJoin(SearchCritDescPeer::SEARCH_CRITERIA_ID, SearchCriteriaPeer::ID, Criteria::LEFT_JOIN);
        //$c->add(SearchCriteriaPeer::ID, $this->member->getSearchCriteriaId());
        $this->questions = DescQuestionPeer::doSelect($c);
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            //echo "<pre>";print_r($_POST);exit();
            $this->member->clearSearchCriteria();
            $answers_array = $this->getRequestParameter('answers');
            $weights_array = $this->getRequestParameter('weights');
            $search_criteria = new SearchCriteria();
            $search_criteria->setAgeMin(19);
            //$search_criteria->save();
            //die($search_criteria->getId());
            foreach ($answers_array as $question_id => $answers)
            {
                if (array_key_exists('from', $answers) && array_key_exists('to', $answers)) //select box with range
                {
                    $answers = range($answers['from'], $answers['to']);
                }
                $answers_value = (is_array($answers)) ? implode(',', $answers) : $answers;
                //echo "<pre>";print_r($answers_value);exit();
                $member_answer = new SearchCritDesc();
                //$member_answer->setSearchCriteriaId($search_criteria->getId());
                $member_answer->setDescQuestionId(
                        $question_id);
                $member_answer->setDescAnswers($answers_value);
                if (array_key_exists($question_id, $weights_array))
                    $member_answer->setMatchWeightId($weights_array[$question_id]);
                    //$member_answer->save();
                $search_criteria->addSearchCritDesc(
                        $member_answer);
            }
            $search_criteria->save();
            $this->member->setSearchCriteria($search_criteria);
            $this->member->save();
            $this->setFlash('msg_ok', 'Your changes have been saved');
            //$this->redirect('members/editSearchCriteria?id='.$this->member->getId());      
        }
    }

    public function executeEditStatusHistory()
    {
        $this->getUser()->getBC()->add(array('name' => 'Status History', 'uri' => 'members/editStatusHistory?id=' . $this->member->getId()));
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MemberStatusHistoryPeer::CREATED_AT);
        $this->history = $this->member->getMemberStatusHistorysJoinMemberStatus($c);
    }

    public function executeDeletePhoto()
    {
        $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
        $this->forward404Unless($photo);
        $photo->delete();
        $this->setFlash('msg_ok', 'Photo have been deleted.');
        return $this->redirect('members/editPhotos?id=' . $this->member->getId());
    }
    
    public function executeStar()
    {
        $this->forward404Unless($this->member);

        $this->member->setIsStarred(!$this->member->IsStarred());
        $this->member->save();
        
        $this->redirect('members/list');
    }
    
    public function executeAddNote()
    {
        $this->forward404Unless($this->member);
        $note = new MemberNote();
        $note->setMember($this->member);
        $note->setUserId($this->getUser()->getId());
        $note->setText($this->getRequestParameter('note_content'));
        $note->save();
        $this->redirect('members/edit?id=' . $this->member->getId());
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
            $c->add(MemberPeer::SEX, $this->filters['sex']);
            if( $this->filters['sex'] == 'f')
            {
                $bc->add(array('name' => 'Female Members', 'uri' => 'members/list?filter=filter&filters[sex]=f'));
                $this->left_menu_selected = 'Female Members';
            } else {
                $bc->add(array('name' => 'Male Members', 'uri' => 'members/list?filter=filter&filters[sex]=m'));
                $this->left_menu_selected = 'Male Members';
            }
        }
        
        if (isset($this->filters['subscription_id']))
        {
            $c->add(MemberPeer::SUBSCRIPTION_ID, $this->filters['subscription_id']);
            switch ($this->filters['subscription_id']) {
            	case SubscriptionPeer::COMP:
                    $bc->add(array('name' => 'Comp Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::COMP));
                    $this->left_menu_selected = 'Comp Members';            	    
            	;
            	break;
            	case SubscriptionPeer::PAID:
                    $bc->add(array('name' => 'Paid Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::PAID));
                    $this->left_menu_selected = 'Paid Members';            	    
            	;
            	break;
            	case SubscriptionPeer::VIP:
                    $bc->add(array('name' => 'VIP Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::VIP));
                    $this->left_menu_selected = 'VIP Members';            	    
            	;
            	break;
            	
            	default:
                    $bc->add(array('name' => 'Free Members', 'uri' => 'members/list?filter=filter&filters[subscription_id]=' . SubscriptionPeer::FREE));
                    $this->left_menu_selected = 'Free Members';            	    
        		;
            	break;
            }
            
        }
        if (isset($this->filters['country']))
        {
            switch ($this->filters['country']) {
            	case 'NON-US':
                    $crit = $c->getNewCriterion(MemberPeer::COUNTRY, 'US', Criteria::NOT_EQUAL);
                    $crit->addAnd($c->getNewCriterion(MemberPeer::COUNTRY, 'PL', Criteria::NOT_EQUAL));
                    $c->add($crit);
                    $bc->add(array('name' => 'Foreign (Non-US) Members', 'uri' => 'members/list?filter=filter&filters[country]=NON-US'));
                    $this->left_menu_selected = 'Foreign (Non-US) Members';          	    
            	;
            	break;
            	case 'US':
                    $c->add(MemberPeer::COUNTRY, 'US');
                    $bc->add(array('name' => 'Foreign (US) Members', 'uri' => 'members/list?filter=filter&filters[country]=US'));
                    $this->left_menu_selected = 'Foreign (US) Members';            	    
            	;
            	break;
            	
            	default:
                    $c->add(MemberPeer::COUNTRY, $this->filters['country']);
                    $bc->add(array('name' => 'Polish Members', 'uri' => 'members/list?filter=filter&filters[country]=PL'));
                    $this->left_menu_selected = 'Polish Members';              	    
        		;
            	break;
            }
            
        }
        if (isset($this->filters['status_id']))
        {
            $c->add(MemberPeer::MEMBER_STATUS_ID, $this->filters['status_id']);
            switch ($this->filters['status_id']) {
            	case MemberStatusPeer::SUSPENDED:
                    $bc->add(array('name' => 'Suspended Members', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::SUSPENDED));
                    $this->left_menu_selected = 'Suspended Members';          	    
            	;
            	break;
            	case MemberStatusPeer::ABANDONED:
                    $bc->add(array('name' => 'Abandoned Registration', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::ABANDONED));
                    $this->left_menu_selected = 'Abandoned Registration';          	    
            	;
            	break;
            	case MemberStatusPeer::PENDING:
                    $bc->add(array('name' => 'Pending Registration', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::PENDING));
                    $this->left_menu_selected = 'Pending Registration';          	    
            	;
            	break;
            	case MemberStatusPeer::DENIED:
                    $bc->add(array('name' => 'Denied Registration', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::DENIED));
                    $this->left_menu_selected = 'Denied Registration';          	    
            	;
            	break;
            	
            	default:
                    $bc->add(array('name' => 'Not Activated Members', 'uri' => 'members/list?filter=filter&filters[status_id]=' . MemberStatusPeer::DEACTIVATED));
                    $this->left_menu_selected = 'Not Activated Members';              	    
        		;
            	break;
            }
        }
        
        if( isset($this->filters['is_starred']) )
        {
            $c->add(MemberPeer::IS_STARRED, true);
            $bc->add(array('name' => 'Starred Members', 'uri' => 'members/list?filter=filter&filters[is_starred]=1'));
            $this->left_menu_selected = 'Starred Members'; 
        }
        
        if( isset($this->filters['flagged']) )
        {
            $c->add(MemberCounterPeer::CURRENT_FLAGS, 0, Criteria::GREATER_THAN);
            $bc->add(array('name' => 'Flagged Members', 'uri' => 'members/list?filter=filter&filters[flagged]=1'));
            $this->left_menu_selected = 'Flagged Members'; 
        }
        
        if( isset($this->filters['canceled']) )
        {
            $crit = $c->getNewCriterion(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::CANCELED);
            $crit->addOr($c->getNewCriterion(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::CANCELED_BY_MEMBER));
            $c->add($crit);
            
            $bc->add(array('name' => 'Deleted Members', 'uri' => 'members/list?filter=filter&filters[deleted]=1'));
            $this->left_menu_selected = 'Deleted Members'; 
        }
        
        if (isset($this->filters['search_type']) && isset($this->filters['search_query']) )
        {
            switch ($this->filters['search_type']) {
                case 'first_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'members/list?'));
                    $c->add(MemberPeer::FIRST_NAME, $this->filters['search_query']);
                ;
                break;
                case 'last_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'members/list?'));
                    $c->add(MemberPeer::LAST_NAME, $this->filters['search_query']);
                ;
                break;
                
                default:
                    $bc->add(array('name' => 'Search', 'uri' => 'members/list?'));
                    $c->add(MemberPeer::USERNAME, $this->filters['search_query']);
                ;
                break;
            }
        }        
    }
}
