<?php

/**
 * registration actions.
 *
 * @package    pr
 * @subpackage registration
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class registrationActions extends BaseEditProfileActions
{
    public function preExecute()
    {
      $this->header_steps = 4;
      if( !in_array($this->getRequestParameter('action'), array('joinNow', 'activate', 'requestNewActivationEmail')) )
      {
          $this->setMember();
      }
    }
    
    public function setMember($required = true)
    {
        $this->member = $this->getUser()->getProfile();
        if( $required ) $this->forward404Unless($this->member);
    }    
  
    /* Step 1 - the sign up .. */
    public function executeJoinNow()
    {
        if( $this->getUser()->isAuthenticated() )
        {
            $this->setFlash('msg_ok', 'You are already member');
            $this->redirect('@dashboard');
        }
        
        $this->setLayout('simple');
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'Join headline', 'uri' => 'registration/joinNow'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member = new Member();
            $member->initNewMember();
            $member->setUsername($this->getRequestParameter('username'));
            $member->setEmail($this->getRequestParameter('email'));
            $member->setPassword($this->getRequestParameter('password'));
            $member->changeSubscription(SubscriptionPeer::FREE, 'system (registration)');
            $member->changeStatus(MemberStatusPeer::ABANDONED);
            $member->parseLookingFor($this->getRequestParameter('looking_for', 'M_F'));
            $member->setLastIp(ip2long($_SERVER['REMOTE_ADDR']));
            $member->setRegistrationIp(ip2long($_SERVER['REMOTE_ADDR']));
            $member->setLanguage($this->getUser()->getCulture());
            $member->setCatalogId($this->getUser()->getCatalogId()); //used by notifications
            $member->setReviewedById(null);
            $member->setReviewedAt(null);

            $member->save();
            
            //just cleanup
            $this->getUser()->SignOut();
            $this->getUser()->setAttribute('member_id', $member->getId());
                    
            Events::triggerJoin($member);
            
            $this->message('verify_your_email');
        }
        
        $this->photo = StockPhotoPeer::getJoinNowPhotoByCatalog($this->getUser()->getCatalog());
        $this->getResponse()->addMeta('description', 'JoinNow description');
        $this->getResponse()->addMeta('keywords', 'JoinNow keywords');
    }

    public function handleErrorJoinNow()
    {
        $this->setLayout('simple');
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'Join headline', 'uri' => 'registration/joinNow'));
        $this->getResponse()->addMeta('description', 'JoinNow description');
        $this->getResponse()->addMeta('keywords', 'JoinNow keywords');
        
        $this->photo = StockPhotoPeer::getJoinNowPhotoByCatalog($this->getUser()->getCatalog());
                
        return sfView::SUCCESS;
    }

    public function executeRequestNewActivationEmail()
    {
        $this->setMember();
        $this->forward404Unless(!$this->member->getHasEmailConfirmation());
        
        $bc = $this->getUser()->getBC();
        $bc->replaceFirst(array('name' => 'Home', 'uri' => '@homepage'))->addBeforeLast(array('name' => 'Sign In', 'uri' => '@signin'));
        
        if( $this->getRequestParameter('confirm') == 1)
        {
            Events::triggerJoin($this->member);
            $this->message('verify_your_email');
        }
    }
    
    /* Step 2 - email confirmation */
    public function executeActivate()
    {
        $this->setLayout('simple');
        
        $username = $this->getRequestParameter('username');
        $member = MemberPeer::retrieveByUsername($username);
        $this->forward404Unless($member);
        $this->forward404If($member->getMemberStatusId() == MemberStatusPeer::CANCELED || 
                            $member->getMemberStatusId() == MemberStatusPeer::CANCELED_BY_MEMBER);
        
        $hash = sha1(SALT . $member->getUsername() . SALT);
        $this->forward404Unless($this->getRequestParameter('hash') == $hash);
        
        if( $member->getHasEmailConfirmation() )
        {
            $this->setFlash('msg_error', 'You already verified your email address. Please sign in.');
            $this->redirect('@signin');
        } else {
            $member->setHasEmailConfirmation(true);
            $member->setReviewedById(null);
            $member->setReviewedAt(null);
            $member->save();
            
            //log in the member so he/she can continue with registration
            $this->getUser()->SignIn($member);
            
            sfLoader::loadHelpers(array('Url'));
            $this->message('welcome');
        }
    }

    /* Step 3 - registration coutry, zip, names .. */
    public function executeIndex()
    {
        $this->setLayout('simple');
        $this->header_current_step = 1;
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home'))->add(array('name' => 'Registration headline', 'uri' => 'registration/index'));
        
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->member->setCountry($this->getRequestParameter('country'));
            $this->member->setAdm1Id($this->getRequestParameter('adm1_id'));
            $this->member->setAdm2Id($this->getRequestParameter('adm2_id'));
            $this->member->setCityId($this->getRequestParameter('city_id'));
            $this->member->setZip($this->getRequestParameter('zip'));
            $this->member->setNationality($this->getRequestParameter('nationality'));
            $this->member->setPurpose($this->getRequestParameter('purpose'));
            $this->member->setReviewedById(null);
            $this->member->setReviewedAt(null);
            
            if( !is_null($this->member->getOriginalFirstName()) ) //already confirmed
            {
                $this->member->save();
                $this->redirect('registration/selfDescription');
            } else { //not confirmed yet
                if( $this->hasRequestParameter('confirmed') ) //form confirmation ?
              {
                  $this->member->setOriginalFirstName('');
                  $this->member->save();
                  $this->redirect('registration/selfDescription');
              } else { //ask for confirmation
                  $this->member->parseLookingFor($this->getRequestParameter('orientation'));
                  $this->member->save();
                  $this->redirect('registration/index?confirm=1' );
              }
            }
        } else {
          $this->has_adm1 = ( !is_null($this->member->getAdm1Id()) ) ? true : false;
          $this->has_adm2 = ( !is_null($this->member->getAdm2Id()) ) ? true : false;
        }
        
        if( $this->hasRequestParameter('confirm') ) 
        {
            $i18n = $this->getContext()->getI18N();
            $i18n_options = array('%URL_FOR_CANCEL%' => $this->getController()->genUrl('registration/index'), 
                                  '%URL_FOR_CONFIRM%' => 'javascript:document.public_reg_form.submit();');
            $conf_msg = $i18n->__('Please confirm that Name and Orientation are filled correctly? <a href="%URL_FOR_CANCEL%" class="sec_link">No</a> <a href="%URL_FOR_CONFIRM%" class="sec_link">Yes</a>', $i18n_options);
          $this->setFlash('msg_error', $conf_msg, false);
          $this->setFlash('msg_no_i18n', true, false);
        }
        
    }

    public function validateIndex()
    {
        $return = true;
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $validator = new prGeoValidator();
            $validator->initialize($this->getContext());
            
            $zip = $this->getRequestParameter('zip');
            $nationality = $this->getRequestParameter('nationality');
            $first_name = $this->getRequestParameter('first_name');
            $purpose = $this->getRequestParameter('purpose');
            
            $value = $error = null;
            
            if( !$validator->execute(&$value, &$error) )
            {
                $this->getRequest()->setError($error['field_name'], $error['msg']);
                $return = false;
            }
            
            if( !$nationality )
            {
                $this->getRequest()->setError('nationality', 'Please provide your nationality.');
                $return = false;
            }
            
            if( !$purpose )
            {
                $this->getRequest()->setError('purpose', 'Please select purpose.');
                $return = false;                
            } elseif ( count(array_diff($purpose, array_keys(MemberPeer::$purposes))) )
            {
              $this->getRequest()->setError('purpose', 'Invalid Purpose.');
              $return = false;              
            }
        }
        
        return $return;
    }
    
    
    public function handleErrorIndex()
    {
        $this->setLayout('simple');
        $this->header_current_step = 1;
        $this->header_steps = 4;
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home'))->add(array('name' => 'Registration headline', 'uri' => 'registration/index'));
        
        $this->setMember();
        
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

    public function executeSelfDescription()
    {
        $this->setLayout('simple');
        $this->header_current_step = 2;
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home'))
        ->add(array('name' => 'Registration headline', 'uri' => 'registration/index'))
        ->add(array('name' => 'Description headline', 'uri' => 'registration/selfDescription'));
        
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->member->setDontDisplayZodiac($this->getRequestParameter('dont_display_zodiac'));
            $this->member->clearDescAnswers();
            $others = $this->getRequestParameter('others');
            
            foreach ($this->getRequestParameter('answers') as $question_id => $value)
            {
                $q = DescQuestionPeer::retrieveByPK($question_id);
                
                $m_answer = new MemberDescAnswer();
                $m_answer->setDescQuestionId($question_id);
                $m_answer->setMemberId($this->getUser()->getId());
                
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
            
            $this->member->setReviewedById(null);
            $this->member->setReviewedAt(null);
            $this->member->save();
            $this->redirect('registration/essay');
        }
        
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
    
    }

    public function validateSelfDescription()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $questions = DescQuestionPeer::getQuestionsAssoc();
            $answers = $this->getRequestParameter('answers');
            $others = $this->getRequestParameter('others');
            $has_error = false; $you_must_fill = false;
            
            foreach ($questions as $question)
            {
                if ($question->getIsRequired() && 
                    (!isset($answers[$question->getId()]) || empty($answers[$question->getId()]) || 
                        (!is_null($question->getOther()) && $answers[$question->getId()] == 'other' && !$others[$question->getId()])
                    || ( $question->getType() == 'other_langs' && $answers[$question->getId()]  != 'other' && !$this->hasValidAnswerForOtherLang($question->getId()) )
                    ))
                {
                    $this->getRequest()->setError('answers[' . $question->getId() . ']', null);
                    $has_error = true;
                    $you_must_fill = true;
                } elseif( $question->getType() == 'age' )
                {
                    $value = $answers[$question->getId()];
                    if( !$value['month'] || !$value['day'] || !$value['year'])
                    {
                        $this->getRequest()->setError('answers[' . $question->getId() . ']', 'Please select you date of birthday.');
                        $has_error = true;
                    }
                    elseif( !checkdate($value['month'], $value['day'], $value['year']) )
                    {
                      $this->getRequest()->setError('answers[' . $question->getId() . ']', 'Please select a valid date of birthday.');
                      $has_error = true;                    
                    } else {
                        $birthday = date('Y-m-d', mktime(0, 0, 0, $value['month'], $value['day'], $value['year']));
                        $age = Tools::getAgeFromDateString($birthday);
                    
                        if( $age < 18 )
                        {
                            $this->getRequest()->setError('answers[' . $question->getId() . ']', 'You must be 18 or older.');
                            $has_error = true;
                        }
                    }
                }
            }
            
            if ($has_error)
            {
                if( $you_must_fill ) $this->getRequest()->setError(null, 'You must fill out the missing information below indicated in red.');
                return false;
            } else {
                foreach($others as $question_id => $value)
                {
                    if( $answers[$question_id] == 'other' && mb_strlen($value) > 35 )
                    {
                        $this->getRequest()->setError('answers[' . $question_id . ']', null);
                        $has_error = true;
                    }
                }
                
                if( $has_error ) 
                {   
                    $this->getRequest()->setError(null, 'Other field values of the questions indicated in red below, can cantain maximum of 35 characters');
                    return false;
                }
            }
        }
        
        return true;
    }
    
    protected function hasValidAnswerForOtherLang($question_id)
    {
      $answers = $this->getRequestParameter('answers');
      $question_answers = $answers[$question_id];
      

      $has_one_answer = false;

        for($i=0; $i<5; $i++)
        {
          if( $question_answers[$i] )
          {
            $has_one_answer = true;
            if( !$question_answers['lang_levels'][$i] ) return false;
          }
        }
      
        return $has_one_answer;
    }

    public function handleErrorSelfDescription()
    {
      $this->setLayout('simple');
      $this->header_steps = 4;
      $this->header_current_step = 2;
      $this->getUser()->getBC()->clear()->add(array('name' => 'Home'))
      ->add(array('name' => 'Registration headline', 'uri' => 'registration/index'))
      ->add(array('name' => 'Description headline', 'uri' => 'registration/selfDescription'));
              
      $this->setMember();
      $this->questions = DescQuestionPeer::doSelect(new Criteria());
      $this->answers = DescAnswerPeer::getAnswersAssoc();
      $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
      
      return sfView::SUCCESS;
    }

    public function executeEssay()
    {
        $this->setLayout('simple');
        $this->header_current_step = 3;
        $BC = $this->getUser()->getBC();
        $BC->clear()->add(array('name' => 'Home'))
        ->add(array('name' => 'Registration headline', 'uri' => 'registration/index'))
        ->add(array('name' => 'Description headline', 'uri' => 'registration/selfDescription'))
        ->add(array('name' => 'Essay headline', 'uri' => 'registration/essay'));
                
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->member->setEssayHeadline($this->getRequestParameter('essay_headline'));
            $this->member->setEssayIntroduction($this->getRequestParameter('essay_introduction'));
            $this->member->setReviewedById(null);
            $this->member->setReviewedAt(null);
            $this->member->save();
            
            $this->redirect('registration/photos');
        }
    }

    public function handleErrorEssay()
    {
        $this->setLayout('simple');
        $this->header_steps = 4;
        $this->header_current_step = 3;
        $BC = $this->getUser()->getBC();
        $BC->clear()->add(array('name' => 'Home'))
        ->add(array('name' => 'Registration headline', 'uri' => 'registration/index'))
        ->add(array('name' => 'Description headline', 'uri' => 'registration/selfDescription'))
        ->add(array('name' => 'Essay headline', 'uri' => 'registration/essay'));
                
        $this->setMember();
        

        return sfView::SUCCESS;
    }

    public function executePhotos()
    {
        $this->setMember();
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if( $this->getRequestParameter('skip') )
        {
                $this->member->setYoutubeVid(''); //registration marker
                $this->member->setReviewedById(null);
                $this->member->setReviewedAt(null);
                $this->member->save();
                $this->getUser()->completeRegistration();
        }
        
        $this->setLayout('simple');
        $this->header_current_step = 4;
        $BC = $this->getUser()->getBC();
        $BC->clear()->add(array('name' => 'Home'))
        ->add(array('name' => 'Registration headline', 'uri' => 'registration/index'))
        ->add(array('name' => 'Description headline', 'uri' => 'registration/selfDescription'))
        ->add(array('name' => 'Essay headline', 'uri' => 'registration/essay'))
        ->add(array('name' => 'Photos headline', 'uri' => 'registration/photos'));
                
        return parent::executePhotos();
    }
    
    
    public function validateDeletePhoto()
    {
        $this->setMember();
        return parent::validateDeletePhoto();
    }

    public function validateUploadPhoto()
    {
        $this->setMember();
        return parent::validateUploadPhoto();
    }    

}
