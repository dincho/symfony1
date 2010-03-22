<?php
/**
 * editProfile actions.
 *
 * @package    pr
 * @subpackage editProfile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class editProfileActions extends prActions
{

    public function executeRegistration()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member->setCountry($this->getRequestParameter('country'));
            $member->setAdm1Id($this->getRequestParameter('adm1_id'));
            $member->setAdm2Id($this->getRequestParameter('adm2_id'));
            $member->setCityId($this->getRequestParameter('city_id'));
            $member->setZip($this->getRequestParameter('zip'));
            $member->setNationality($this->getRequestParameter('nationality'));
            $member->setPurpose($this->getRequestParameter('purpose'));
            
            $flash_error = '';
            if ($member->getEmail() != $this->getRequestParameter('email')) //email changed
            {
                $flash_error .= 'IMPORTANT! Your email address change is not complete!';
                $member->setTmpEmail($this->getRequestParameter('email'));
                Events::triggerNewEmailConfirm($member);
            }
            
            if ($this->getRequestParameter('password')) //password changed
            {
                if ($this->getUser()->getAttribute('must_change_pwd', false)) //comming from forgot password
                {
                    $member->setPassword($this->getRequestParameter('password'));
                    $member->setMustChangePwd(false);
                    $this->getUser()->setAttribute('must_change_pwd', false);
                } else
                {
                    $flash_error .= 'IMPORTANT! Your password change is complete!';
                    $member->setNewPassword($this->getRequestParameter('password'));
                    Events::triggerNewPasswordConfirm($member);
                }
            }
            
            $member->save();
            if ($flash_error) $this->setFlash('msg_error', $flash_error); //password and email changes
            $this->setFlash('msg_ok', 'Your Registration Information has been updated');
            $this->redirect('dashboard/index'); //the dashboard
        } else {
          $this->has_adm1 = ( !is_null($member->getAdm1Id()) ) ? true : false;
          $this->has_adm2 = ( !is_null($member->getAdm2Id()) ) ? true : false;
        }
        
        $this->member = $member;
    }

    public function validateRegistration()
    {
        $return = true;
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member = MemberPeer::retrieveByPK($this->getUser()->getid());
            $this->forward404Unless($member); //just in case
            $mail = $this->getRequestParameter('email');
            
            if ($member->getEmail() != $mail) //new mail
            {
                $myValidator = new sfPropelUniqueValidator();
                $myValidator->initialize($this->getContext(), 
                        array('class' => 'Member', 'column' => 'email', 'unique_error' => 'For some reason the system does not accept this email address. Please use another one.'));
                if (! $myValidator->execute($mail, $error))
                {
                    $this->getRequest()->setError('email', $error);
                    $return = false;
                }
            }
            
            if ($this->getUser()->getAttribute('must_change_pwd') && ! $this->getRequestParameter('password'))
            {
                $this->getRequest()->setError('password', 'You must change your password!');
                $return = false;
            }
            
            $geoValidator = new prGeoValidator();
            $geoValidator->initialize($this->getContext());

            $value = $error = null;
            if( !$geoValidator->execute(&$value, &$error) )
            {
                $this->getRequest()->setError($error['field_name'], $error['msg']);
                $return = false;
            }            
            
            $nationality = $this->getRequestParameter('nationality');      
            if( !$nationality )
            {
                $this->getRequest()->setError('nationality', 'Please provide your nationality.');
                $return = false;
            }
        }
        return $return;
    }

    public function handleErrorRegistration()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
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
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->member->setDontDisplayZodiac($this->getRequestParameter('dont_display_zodiac'));
            $this->member->clearDescAnswers();
            $others = $this->getRequestParameter('others');
            
            foreach ($this->getRequestParameter('answers') as $question_id => $value)
            {
                $q = DescQuestionPeer::retrieveByPK($question_id);
                $m_answer = new MemberDescAnswer();
                $m_answer->setDescQuestionId($q->getId());
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
            $this->member->save();
            $this->member->clearCache();
            $this->setFlash('msg_ok', 'Your Self-Description has been updated');
            $this->redirect('dashboard/index');
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
            
            //print_r($answers); print_r($others);exit();
            
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
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
        
        return sfView::SUCCESS;
    }

    public function executeEssay()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->member->setEssayHeadline($this->getRequestParameter('essay_headline'));
            $this->member->setEssayIntroduction($this->getRequestParameter('essay_introduction'));
            
            if($this->member->isModified())
            {
                $this->member->save();
                $this->member->clearCache();
            }
            
            $this->setFlash('msg_ok', 'Your Posting have been updated');
            $this->redirect('dashboard/index');
        }
    }

    public function handleErrorEssay()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case  
        return sfView::SUCCESS;
    }

    public function executePhotos()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('commit') && $this->getRequest()->getFileSize('new_photo'))
            {
                $new_photo = new MemberPhoto();
                $new_photo->setMember($this->member);
                $new_photo->updateImageFromRequest('file', 'new_photo', true, true);
                $new_photo->save();
                
                $this->member->setLastPhotoUploadAt(time());
            }
            
            //set main photo
            if ($this->getRequestParameter('main_photo'))
            {
                $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('main_photo'));
                if ($photo) $this->member->setMemberPhoto($photo);
            }
            
            //YouTube Video
            $youtube_url = $this->getRequestParameter('youtube_url');
            $matches = array();
            preg_match('#http://www\.youtube\.com/watch\?v=([a-z0-9_]+)#i', $youtube_url, $matches);
            $this->member->setYoutubeVid(($youtube_url && isset($matches[1])) ? $matches[1] : null);
            $this->member->save();
            
            //if the form is submited by "Save and continue" button
            if (! $this->getRequestParameter('commit'))
            {
                $this->setFlash('msg_ok', 'Your Photos have been updated');
                $this->redirect('dashboard/index');
            } 
            
            //else the upload button is pressed "commit", so show the photos .. 
            //BUT redirect to itself, to prevent form resubmit
            $this->redirect('editProfile/photos');
        }
        
        
        $this->photos = $this->member->getMemberPhotos();
        
        //message deletion confirmation
        if( $this->getRequestParameter('confirm_delete') )
        {
            $contoller = $this->getController();
            $i18n = $this->getContext()->getI18N();
            
            $i18n_options = array('%URL_FOR_CANCEL%' => $contoller->genUrl('editProfile/photos'), 
                                  '%URL_FOR_CONFIRM%' => $contoller->genUrl('editProfile/deletePhoto?id=' . $this->getRequestParameter('confirm_delete')));
            $del_msg = $i18n->__('Are you sure you want to delete selected photo? <a href="%URL_FOR_CANCEL%" class="sec_link">No</a> <a href="%URL_FOR_CONFIRM%" class="sec_link">Yes</a>', $i18n_options);
            $this->setFlash('msg_error', $del_msg, false);
        }        
    }

    public function validatePhotos()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST )
        {
          if( $this->getRequestParameter('commit') ) //uploading photo
          {
            $member = MemberPeer::retrieveByPK($this->getUser()->getId());
            $subscription = $member->getSubscription();
            $cnt_photos = $member->countMemberPhotos();
            
            $file_arr = $this->getRequest()->getFile('new_photo');
            if( !$file_arr['name'] )
            {
                $this->getRequest()->setError('new_photo', 'Please select photo');
                return false;
            }
            
            if( $file_arr['tmp_name'] )
            {
                $image_info = getimagesize($file_arr['tmp_name']);
                
                if( empty($image_info) )
                {
                    $this->getRequest()->setError('new_photo', 'Please select correct file type');
                    return false;
                }
                
                if( $image_info[0] < 200 )
                {
                    $this->getRequest()->setError('new_photo', 'The photo should be at least 200px wide');
                    return false;
                }
            }
                        
            if (! $subscription->getCanPostPhoto())
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'In order to post photo you need to upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: In order to post photo you need to upgrade your membership.');
                }
                return false;
            }
            
            if ($cnt_photos >= $subscription->getPostPhotos())
            {
                if( $subscription->getId() == SubscriptionPeer::FREE )
                {
                    $this->getRequest()->setError('subscription', 'For the feature that you want to use - post photo - you have reached the limit up to which you can use it with your membership. In order to post photo, please upgrade your membership.');
                } else {
                    $this->getRequest()->setError('subscription', 'Paid: For the feature that you want to use - post photo - you have reached the limit up to which you can use it with your membership. In order to post photo, please upgrade your membership.');
                }
                return false;
            }
            
          } elseif( $this->getRequestParameter('youtube_url') ) //save and continue clicked
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
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
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
        $this->redirect('editProfile/photos');
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
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        $this->setTemplate('photos');
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->photos = $this->member->getMemberPhotos();
        return sfView::SUCCESS;
    }
    
    public function executePhotoAuthenticity()
    {
        $this->getUser()->getBC()->clear()
        ->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'))
        ->add(array('name' => 'Photos', 'uri' => 'editProfile/photos'))
        ->add(array('name' => 'Photo Authenticity'));
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        
         if ($this->getRequest()->getMethod() == sfRequest::POST)
         {
             $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('auth_photo_id'));
             $this->forward404Unless($photo);
             
             $c1 = new Criteria();
             $c1->add(MemberPhotoPeer::AUTH, 'S');
             $c1->add(MemberPhotoPeer::MEMBER_ID, $this->member->getId());
             $c2 = new Criteria();
             $c2->add(MemberPhotoPeer::AUTH, null);
             BasePeer::doUpdate($c1, $c2, Propel::getConnection());
             
             $photo->setAuth('S');
             $photo->save();
             
             $this->setFlash('msg_ok', 'Your photo has been submitted for authenticity approval.');
             $this->redirect('editProfile/photoAuthenticity');
         }
         
        $this->photos = $this->member->getMemberPhotos();
    }
    
    public function validatePhotoAuthenticity()
    {
       if ($this->getRequest()->getMethod() == sfRequest::POST)
       {
           if( !$this->getRequestParameter('auth_photo_id') )
           {
               $this->getRequest()->setError('auth_photo_id', 'Please select photo');
               return false;
           }
       } 
       
       return true;
    }
    
    public function handleErrorPhotoAuthenticity()
    {
        $this->getUser()->getBC()->clear()
        ->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'))
        ->add(array('name' => 'Photos', 'uri' => 'editProfile/photos'))
        ->add(array('name' => 'Photo Authenticity'));
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
         
        $this->photos = $this->member->getMemberPhotos();
        
        return sfView::SUCCESS;
    }
}
