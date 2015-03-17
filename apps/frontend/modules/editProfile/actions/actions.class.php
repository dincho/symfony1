<?php
/**
 * editProfile actions.
 *
 * @package    pr
 * @subpackage editProfile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class editProfileActions extends BaseEditProfileActions
{

    public function preExecute()
    {
        $this->setMember();
    }

    public function setMember()
    {
        $this->member = $this->getUser()->getProfile();
        $this->forward404Unless($this->member);
    }

    public function executeRegistration()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->member->setCountry($this->getRequestParameter('country'));
            $this->member->setAdm1Id($this->getRequestParameter('adm1_id'));
            $this->member->setAdm2Id($this->getRequestParameter('adm2_id'));
            $this->member->setCityId($this->getRequestParameter('city_id'));
            $this->member->setZip($this->getRequestParameter('zip'));
//            $this->member->setNationality($this->getRequestParameter('nationality'));
            $this->member->setPurpose($this->getRequestParameter('purpose'));

            $flash_error = '';
            if ($this->member->getEmail() != $this->getRequestParameter('email')) { //email changed
                $flash_error .= 'IMPORTANT! Your email address change is not complete!';
                $this->member->setTmpEmail($this->getRequestParameter('email'));
                Events::triggerNewEmailConfirm($this->member);
            }

            if ($this->getRequestParameter('password')) { //password changed
                if ($this->getUser()->getAttribute('must_change_pwd', false)) { //comming from forgot password
                    $this->member->setPassword($this->getRequestParameter('password'));
                    $this->member->setMustChangePwd(false);
                    $this->getUser()->setAttribute('must_change_pwd', false);
                } else {
                    $flash_error .= 'IMPORTANT! Your password change is complete!';
                    $this->member->setNewPassword($this->getRequestParameter('password'));
                    Events::triggerNewPasswordConfirm($this->member);
                }
            }

            $this->member->setReviewedById(null);
            $this->member->setReviewedAt(null);

            $this->member->save();
            $this->member->clearCache();
            if ($flash_error) $this->setFlash('msg_error', $flash_error); //password and email changes
            $this->setFlash('msg_ok', 'Your Registration Information has been updated');
            $this->redirect('dashboard/index'); //the dashboard
        } else {
          $this->has_adm1 = ( !is_null($this->member->getAdm1Id()) ) ? true : false;
          $this->has_adm2 = ( !is_null($this->member->getAdm2Id()) ) ? true : false;
        }

    }

    public function validateRegistration()
    {
        $this->setMember();

        $return = true;

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $mail = $this->getRequestParameter('email');

            if ($this->member->getEmail() != $mail) { //new mail
                $myValidator = new sfPropelUniqueValidator();
                $myValidator->initialize($this->getContext(),
                        array('class' => 'Member', 'column' => 'email', 'unique_error' => 'This email address already exists in our database, please use another one.'));
                if (! $myValidator->execute($mail, $error)) {
                    $this->getRequest()->setError('email', $error);
                    $return = false;
                }
            }

            if ($this->getUser()->getAttribute('must_change_pwd') && ! $this->getRequestParameter('password')) {
                $this->getRequest()->setError('password', 'You must change your password!');
                $return = false;
            }

            $geoValidator = new prGeoValidator();
            $geoValidator->initialize($this->getContext());

            $value = $error = null;
            if ( !$geoValidator->execute($value, $error) ) {
                $this->getRequest()->setError($error['field_name'], $error['msg']);
                $return = false;
            }

/*            $nationality = $this->getRequestParameter('nationality');
            if (!$nationality) {
                $this->getRequest()->setError('nationality', 'Please provide your nationality.');
                $return = false;
            }
*/
            $purpose = $this->getRequestParameter('purpose');

            if ( $purpose && count(array_diff($purpose, array_keys(MemberPeer::$purposes))) ) {
              $this->getRequest()->setError('purpose', 'Invalid Purpose.');
              $return = false;
            }
        }

        return $return;
    }

    public function handleErrorRegistration()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
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

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->member->setDontDisplayZodiac($this->getRequestParameter('dont_display_zodiac'));
            $this->member->clearDescAnswers();
            $others = $this->getRequestParameter('others');

            foreach ($this->getRequestParameter('answers') as $question_id => $value) {
                $q = DescQuestionPeer::retrieveByPK($question_id);
                $m_answer = new MemberDescAnswer();
                $m_answer->setDescQuestionId($q->getId());
                $m_answer->setMemberId($this->getUser()->getId());

                if (! is_null($q->getOther()) && $value == 'other') {
                    $m_answer->setDescAnswerId(null);
                    $m_answer->setOther('other');
                } elseif ($q->getType() == 'other_langs') {
                    $m_answer->setOtherLangs($value);
                    $m_answer->setDescAnswerId(null);
                } elseif ($q->getType() == 'native_lang') {
                    $m_answer->setCustom($value);
                    $m_answer->setDescAnswerId(null);
                    $this->member->setLanguage($value);
                } elseif ($q->getType() == 'age') {
                    $birthday = date('Y-m-d', mktime(0, 0, 0, $value['month'], $value['day'], $value['year']));
                    $m_answer->setCustom($birthday);
                    $m_answer->setDescAnswerId(null);
                    $this->member->setBirthDay($birthday);
                } else {
                    $m_answer->setDescAnswerId( ($value) ? $value : null);
                }

                if (! is_null($q->getOther()) && isset($others[$question_id])) {
                    $m_answer->setDescAnswerId(null);
                    $m_answer->setOther('other');
                }
                $m_answer->save();

                //millionaire check
                if( $question_id == 7 ) $this->member->setMillionaire( ($value > 26) );
            }

            $this->member->setReviewedById(null);
            $this->member->setReviewedAt(null);
            $this->member->save();
            $this->member->clearCache();

            MemberMatchPeer::updateMemberIndex($this->member);

            $this->setFlash('msg_ok', 'Your Self-Description has been updated');
            $this->redirect('dashboard/index');
        }

        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
    }

    public function validateSelfDescription()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $questions = DescQuestionPeer::getQuestionsAssoc();
            $answers = $this->getRequestParameter('answers');
            $others = $this->getRequestParameter('others');
            $has_error = false; $you_must_fill = false;

            foreach ($questions as $question) {
                if ($question->getIsRequired() 
                    && (empty($answers[$question->getId()])
                        && (is_null($others) || empty($others[$question->getId()]))
                       )
                    )
                {
                    $this->getRequest()->setError('answers[' . $question->getId() . ']', null);
                    $has_error = true;
                    $you_must_fill = true;
                } elseif ( $question->getType() == 'age' ) {
                    $value = $answers[$question->getId()];
                    if (!$value['month'] || !$value['day'] || !$value['year']) {
                        $this->getRequest()->setError('answers[' . $question->getId() . ']', 'Please select you date of birthday.');
                        $has_error = true;
                    } elseif ( !checkdate($value['month'], $value['day'], $value['year']) ) {
                      $this->getRequest()->setError('answers[' . $question->getId() . ']', 'Please select a valid date of birthday.');
                      $has_error = true;
                    } else {
                        $birthday = date('Y-m-d', mktime(0, 0, 0, $value['month'], $value['day'], $value['year']));
                        $age = Tools::getAgeFromDateString($birthday);

                        if ($age < 18) {
                            $this->getRequest()->setError('answers[' . $question->getId() . ']', 'You must be 18 or older.');
                            $has_error = true;
                        }
                    }
                }
            }

            if ($has_error) {
                if( $you_must_fill ) $this->getRequest()->setError(null, 'You must fill out the missing information below indicated in red.');

                return false;
            } else {
                foreach ($others as $question_id => $value) {
                    if ( isset($answers[$question_id]) && $answers[$question_id] == 'other' && mb_strlen($value) > 35 ) {
                        $this->getRequest()->setError('answers[' . $question_id . ']', null);
                        $has_error = true;
                    }
                }

                if ($has_error) {
                    $this->getRequest()->setError(null, 'Other field values of the questions indicated in red below, can cantain maximum of 35 characters');

                    return false;
                }
            }
        }

        return true;
    }

    public function handleErrorSelfDescription()
    {
        $this->setMember();

        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());

        return sfView::SUCCESS;
    }

    public function executeEssay()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->member->setEssayHeadline($this->getRequestParameter('essay_headline'));
            $this->member->setEssayIntroduction($this->getRequestParameter('essay_introduction'));

            if ($this->member->isModified()) {
                $this->member->setReviewedById(null);
                $this->member->setReviewedAt(null);
                $this->member->save();
                $this->member->clearCache();
            }

            $this->setFlash('msg_ok', 'Your Posting have been updated');
            $this->redirect('dashboard/index');
        }
    }

    public function handleErrorEssay()
    {
        $this->setMember();
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));

        return sfView::SUCCESS;
    }

    public function executePhotos()
    {
        $this->getUser()->getBC()->clear()
        ->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'))
        ->add(array('name' => 'Photos'));

        return parent::executePhotos();
    }

    public function executeTestUploadPhoto()
    {
        $this->forward404Unless(SF_ENVIRONMENT == 'dev');  //this is test action

        $this->forward404Unless($this->member);

        $domain = $this->getUser()->getCatalog()->getDomain();
        $catalog_domains = sfConfig::get('app_catalog_domains');
        if( isset($catalog_domains[$domain]) ) $domain = $catalog_domains[$domain];

        if ( $this->getRequest()->getMethod() == sfRequest::POST ) {
            $member_photo = new MemberPhoto();
            $member_photo->setMember($this->member);
            $member_photo->updateImageFromRequest('file', 'Filedata', true, $brandName = $domain);
            $member_photo->setIsPrivate(true);
            $member_photo->setSortOrder(PHP_INT_MAX);
            $member_photo->save();

            $this->member->setLastPhotoUploadAt(time());
            $this->member->setReviewedById(null);
            $this->member->setReviewedAt(null);
            $this->member->save();
        }
    }

    public function validateUploadPhoto()
    {
        $this->setMember();

        return parent::validateUploadPhoto();
    }

    public function executeDeletePhoto()
    {
        parent::executeDeletePhoto();

        $this->setFlash('msg_ok', 'Your photo has been deleted.', false);

        return $this->renderText(get_partial('editProfile/delete_photo'));
    }

    public function executePhotoAuthenticity()
    {
        $this->getUser()->getBC()->clear()
        ->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'))
        ->add(array('name' => 'Photos', 'uri' => 'editProfile/photos'))
        ->add(array('name' => 'Photo Authenticity'));

        $this->setMember();

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
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

        $this->public_photos = $this->member->getPublicMemberPhotos();
        $this->private_photos = $this->member->getPrivateMemberPhotos();
    }

    public function validatePhotoAuthenticity()
    {
       if ($this->getRequest()->getMethod() == sfRequest::POST) {
           if ( !$this->getRequestParameter('auth_photo_id') ) {
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

        $this->setMember();

        $this->public_photos = $this->member->getPublicMemberPhotos();
        $this->private_photos = $this->member->getPrivateMemberPhotos();

        return sfView::SUCCESS;
    }

    public function executeCropPhoto()
    {
        sfLoader::loadHelpers(array('Partial'));

        if ($this->getRequestParameter('photo_id') && $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'))) {
            $photo->updateCroppedImage($this->getRequestParameter('crop'));

            return $this->renderText( get_partial('editProfile/photo_slot', array('photo' => $photo)) );
        }

        return sfView::NONE;
    }

    public function executeRotatePhoto()
    {
        sfLoader::loadHelpers(array('Partial'));

        if ($this->getRequestParameter('photo_id') && $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'))) {
            $photo->updateRotatedImage($this->getRequestParameter('deg'));

            return $this->renderText( get_partial('editProfile/photo_slot', array('photo' => $photo)) );
        }

        return sfView::NONE;
    }

    public function getPhotoError()
    {
        $errors = $this->getRequest()->getErrors();

        return __(array_shift($errors));
    }
}
