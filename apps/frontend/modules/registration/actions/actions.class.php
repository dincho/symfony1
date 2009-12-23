<?php

/**
 * registration actions.
 *
 * @package    pr
 * @subpackage registration
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class registrationActions extends prActions
{
    public function preExecute()
    {
      $this->header_steps = 4;
    }
  
    /* Step 1 - the sign up .. */
    public function executeJoinNow()
    {
        $this->setLayout('simple');
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'Join headline', 'uri' => 'registration/joinNow'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member = new Member();
            $member->setUsername($this->getRequestParameter('username'));
            $member->setEmail($this->getRequestParameter('email'));
            $member->setPassword($this->getRequestParameter('password'));
            $member->changeSubscription(SubscriptionPeer::FREE);
            $member->changeStatus(MemberStatusPeer::ABANDONED);
            $member->parseLookingFor($this->getRequestParameter('looking_for', 'M_F'));
            $member->initNewMember();
            $member->setLastIp(ip2long($_SERVER['REMOTE_ADDR']));
            $member->setLanguage($this->getUser()->getCulture()); //used by notifications
            $member->save();
            
            $this->getUser()->getAttributeHolder()->clear();
            $this->getUser()->clearCredentials();
                    
            Events::triggerJoin($member);
            
            $this->message('verify_your_email');
        }
        
        $this->getResponse()->addMeta('description', 'JoinNow description');
        $this->getResponse()->addMeta('keywords', 'JoinNow keywords');
    }

    public function handleErrorJoinNow()
    {
        $this->setLayout('simple');
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'Join headline', 'uri' => 'registration/joinNow'));
        $this->getResponse()->addMeta('description', 'JoinNow description');
        $this->getResponse()->addMeta('keywords', 'JoinNow keywords');
                
        return sfView::SUCCESS;
    }

    public function executeRequestNewActivationEmail()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
        $this->forward404Unless(!$member->getHasEmailConfirmation());
        
        $bc = $this->getUser()->getBC();
        $bc->replaceFirst(array('name' => 'Home', 'uri' => '@homepage'))->addBeforeLast(array('name' => 'Sign In', 'uri' => '@signin'));
        
        if( $this->getRequestParameter('confirm') == 1)
        {
            Events::triggerJoin($member);
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
        
        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
        $this->forward404Unless($member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member->setCountry($this->getRequestParameter('country'));
            $member->setAdm1Id($this->getRequestParameter('adm1_id'));
            $member->setAdm2Id($this->getRequestParameter('adm2_id'));
            $member->setCityId($this->getRequestParameter('city_id'));
            $member->setZip($this->getRequestParameter('zip'));
            $member->setNationality($this->getRequestParameter('nationality'));
            
            
            if( $member->getOriginalFirstName() ) //already confirmed
            {
                $member->save();
                $this->redirect('registration/selfDescription');
            } else { //not confirmed yet
                if( $this->hasRequestParameter('confirmed') ) //form confirmation ?
              {
                  $member->setOriginalFirstName($this->getRequestParameter('first_name'));
                  $member->save();
                  $this->redirect('registration/selfDescription');
              } else { //ask for confirmation
                    $member->setFirstName($this->getRequestParameter('first_name'));  
                    $member->parseLookingFor($this->getRequestParameter('orientation'));                  
                  $member->save();
                  $this->redirect('registration/index?confirm=1' );
              }
            }
        } else {
          $this->has_adm1 = ( !is_null($member->getAdm1Id()) ) ? true : false;
          $this->has_adm2 = ( !is_null($member->getAdm2Id()) ) ? true : false;
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
        
        $this->member = $member;
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
            
            if( !$first_name )
            {
                $this->getRequest()->setError('first_name', 'Please provide your First Name.');
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
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getid());
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

    public function executeSelfDescription()
    {
        $this->setLayout('simple');
        $this->header_current_step = 2;
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home'))
        ->add(array('name' => 'Registration headline', 'uri' => 'registration/index'))
        ->add(array('name' => 'Description headline', 'uri' => 'registration/selfDescription'));
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        //$this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
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
            }
            
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
            }
        }
        
        return true;
    }
    
    protected function hasValidAnswerForOtherLang($question_id)
    {
        $answers = $this->getRequestParameter('answers');
        $question_answers = $answers[$question_id];
        
        $has_one_answer = false;
        for($i=1; $i<5; $i++)
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
              
      $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
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
                
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->member->setEssayHeadline($this->getRequestParameter('essay_headline'));
            $this->member->setEssayIntroduction($this->getRequestParameter('essay_introduction'));
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
                
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case  
        

        return sfView::SUCCESS;
    }

    public function executePhotos()
    {
        $this->setLayout('simple');
        $this->header_current_step = 4;
        $BC = $this->getUser()->getBC();
        $BC->clear()->add(array('name' => 'Home'))
        ->add(array('name' => 'Registration headline', 'uri' => 'registration/index'))
        ->add(array('name' => 'Description headline', 'uri' => 'registration/selfDescription'))
        ->add(array('name' => 'Essay headline', 'uri' => 'registration/essay'))
        ->add(array('name' => 'Photos headline', 'uri' => 'registration/photos'));
                
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ( $this->getRequestParameter('commit') )
            {
                if( $this->getRequest()->getFileSize('new_photo') )
                {
                    $new_photo = new MemberPhoto();
                    $new_photo->setMember($this->member);
                    $new_photo->updateImageFromRequest('file', 'new_photo', true, true);
                    $new_photo->save();
                    
                    $this->member->save(); //because of main photo
                }
            } else { //the form is submited by "Save and continue" button
                //set main photo
                if ($this->getRequestParameter('main_photo'))
                {
                    $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('main_photo'));
                    if ($photo) $photo->setAsMainPhoto();
                }

                //YouTube Video
                $youtube_url = $this->getRequestParameter('youtube_url');
                $matches = array();
                preg_match('#http://www\.youtube\.com/watch\?v=([a-z0-9_]+)#i', $youtube_url, $matches);
                $this->member->setYoutubeVid(($youtube_url && isset($matches[1])) ? $matches[1] : '');
                
                $this->member->save();
                $this->getUser()->completeRegistration();
            }
            
            $this->redirect('registration/photos');
        }
        
        $this->photos = $this->member->getMemberPhotos();
        
        //message deletion confirmation
        if( $this->getRequestParameter('confirm_delete') )
        {
            $contoller = $this->getController();
            $i18n = $this->getContext()->getI18N();
            
            $i18n_options = array('%URL_FOR_CANCEL%' => $contoller->genUrl('registration/photos'), 
                                  '%URL_FOR_CONFIRM%' => $contoller->genUrl('registration/deletePhoto?id=' . $this->getRequestParameter('confirm_delete')));
            $del_msg = $i18n->__('Are you sure you want to delete selected photo? <a href="%URL_FOR_CANCEL%" class="sec_link">No</a> <a href="%URL_FOR_CONFIRM%" class="sec_link">Yes</a>', $i18n_options);
            $this->setFlash('msg_error', $del_msg, false);
        }         
    }
    
    public function validatePhotos()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
          if( $this->getRequestParameter('commit') ) //uploading photo
          {
            $member = MemberPeer::retrieveByPK($this->getUser()->getId());
            $subscription = $member->getSubscription();
            $cnt_photos = $member->countMemberPhotos();
          
            if (! $subscription->getCanPostPhoto())
            {
                $this->getRequest()->setError('subscription', 'In order to post photo you need to upgrade your membership.');
                return false;
            }
          
            if ($cnt_photos >= $subscription->getPostPhotos())
            {
                $this->getRequest()->setError('subscription', 
                        'For the feature that you want to use - post photo - you have reached the limit up to which you can use it with your membership. In order to post photo, please upgrade your membership.');
                return false;
            }
          } elseif ($this->getRequestParameter('youtube_url') ) //save and continue clicked
          {
            $youValidator = new sfRegexValidator();
            $youValidator->initialize($this->getContext(), array(
              'match_error' => 'Youtube error',
              'pattern'       => '/http:\/\/www\.youtube\.com\/watch\?v=[a-z0-9_]+/i',
            ));
            
            $value = $this->getRequestParameter('youtube_url');
            $error = '';
            if (!$youValidator->execute($value, $error))
            {
              $this->getRequest()->setError('youtube_url', $error);
              return false;
            }
          }
        }
        
        return true;
    }

    public function handleErrorPhotos()
    {
        $this->setLayout('simple');
        $this->header_steps = 4;
        $this->header_current_step = 4;
        $BC = $this->getUser()->getBC();
        $BC->clear()->add(array('name' => 'Home'))
        ->add(array('name' => 'Registration headline', 'uri' => 'registration/index'))
        ->add(array('name' => 'Description headline', 'uri' => 'registration/selfDescription'))
        ->add(array('name' => 'Essay headline', 'uri' => 'registration/essay'))
        ->add(array('name' => 'Photos headline', 'uri' => 'registration/photos'));
                
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->photos = $this->member->getMemberPhotos();
        return sfView::SUCCESS;
    }

    public function executeDeletePhoto()
    {
        $c = new Criteria();
        $c->add(MemberPhotoPeer::MEMBER_ID, $this->getUser()->getId());
        $c->add(MemberPhotoPeer::ID, $this->getRequestParameter('id'));
        
        $photo = MemberPhotoPeer::doSelectOne($c);
        $this->forward404Unless($photo);
        
        $photo->delete();
        $this->setFlash('msg_ok', 'Your photo has been deleted.');
        $this->redirect('registration/photos');
    }

    public function validateDeletePhoto()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $photos = $member->countMemberPhotos();
        
        if ($photos < 2)
        {
            $this->getRequest()->setError('photo', 'You only have 1 photo, please upload a second photo and then delete it.');
            return false;
        }
        return true;
    }

    public function handleErrorDeletePhoto()
    {
        $this->setLayout('simple');
        $this->setTemplate('photos');
        $BC = $this->getUser()->getBC();
        $BC->clear()->add(array('name' => 'Home'))
        ->add(array('name' => 'Registration headline', 'uri' => 'registration/index'))
        ->add(array('name' => 'Description headline', 'uri' => 'registration/selfDescription'))
        ->add(array('name' => 'Essay headline', 'uri' => 'registration/essay'))
        ->add(array('name' => 'Photos headline', 'uri' => 'registration/photos'));
                
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->photos = $this->member->getMemberPhotos();
        
        return sfView::SUCCESS;
    }
}
