<?php
/**
 * editProfile actions.
 *
 * @package    pr
 * @subpackage editProfile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class editProfileActions extends sfActions
{

    public function executeRegistration()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $flash_error = '';
            if ($member->getEmail() != $this->getRequestParameter('email')) //email changed
            {
                $flash_error .= 'IMPORTANT! Your email address change is not complete! You must confirm your new email 
                                address before you can use it to log in to our website. We have sent you 2 emails – 1 on your current 
                                email address and 1 on your new email address. Please go to these messages and confirm the change. 
                                Until you do so, you will have to use your current email address.<br /><br />';
                $member->setTmpEmail($this->getRequestParameter('email'));
                Events::triggerNewEmailConfirm($member);
            }
            
            if ($this->getRequestParameter('password')) //password changed
            {
                if( $this->getUser()->getAttribute('must_change_pwd', false)) //comming from forgot password
                {
                    $member->setPassword($this->getRequestParameter('password'));
                    $member->setMustChangePwd(false);
                    $this->getUser()->setAttribute('must_change_pwd', false);                    
                } else {
                    $flash_error .= 'IMPORTANT! Your password change is complete! You must confirm it before you can use it to log 
                                    in to our website. We have sent you an email. Please go to the message and confirm the change. Until 
                                    you do so, you will have to use your current password to log in.  
                                    Thank you for understanding.<br /><br />';
                    $member->setNewPassword($this->getRequestParameter('password'));
                    Events::triggerNewPasswordConfirm($member);
                }
            }
            
            $sex_looking = explode('_', $this->getRequestParameter('looking_for', 'M_F'));
            $member->setSex($sex_looking[0]);
            $member->setLookingFor($sex_looking[1]);
            $member->setLanguage($this->getRequestParameter('language'));
            $member->setCountry($this->getRequestParameter('country'));
            $member->setStateId($this->getRequestParameter('state'));
            $member->setDistrict($this->getRequestParameter('district'));
            $member->setCity($this->getRequestParameter('city'));
            $member->setZip($this->getRequestParameter('zip'));
            $member->setNationality($this->getRequestParameter('nationality'));
            //$member->setFirstName($this->getRequestParameter('first_name'));
            //$member->setLastName($this->getRequestParameter('last_name'));
            $member->save();
            $this->setFlash('msg_ok', 'Your Registration Information has been updated');
            if ($flash_error) $this->setFlash('msg_error', $flash_error);
            $this->redirect('dashboard/index'); //the dashboard
        }
        $this->member = $member;
    }

    public function validateRegistration()
    {
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
                    return false;
                }
            }
            if ($this->getUser()->getAttribute('must_change_pwd') && ! $this->getRequestParameter('password'))
            {
                $this->getRequest()->setError('password', 'You must change your password!');
                return false;
            }
        }
        return true;
    }

    public function handleErrorRegistration()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($this->member); //just in case
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

            foreach ($this->getRequestParameter('answers') as $question_id => $value)
            {
                $q = DescQuestionPeer::retrieveByPK($question_id);
                $m_answer = new MemberDescAnswer();
                $m_answer->setDescQuestionId($question_id);
                $m_answer->setMemberId($this->getUser()->getId());
                if ($q->getType() == 'other_langs')
                {
                    $m_answer->setOtherLangs($value);
                    $m_answer->setDescAnswerId(null);
                } elseif($q->getType() == 'age')
                {
                    $birthday = date('Y-m-d', mktime(0,0,0,$value['month'],$value['day'],$value['year']));
                    $m_answer->setCustom($birthday);
                    $m_answer->setDescAnswerId(null);
                    $this->member->setBirthDay($birthday);
                } else
                {
                    $m_answer->setDescAnswerId($value);
                }
                $m_answer->save();
            }
            $this->member->save();
            $this->setFlash('msg_ok', 'Your Self-description Information has been updated');
            $this->redirect('dashboard/index');
        }
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
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
            $this->member->save();
            $this->setFlash('msg_ok', 'Your essay has been updated');
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
                if ($photo)
                    $photo->setAsMainPhoto();
            }
            //YouTube Video
            $youtube_url = $this->getRequestParameter('youtube_url');
            $matches = array();
            preg_match('#http://www\.youtube\.com/watch\?v=([a-z0-9]+)#i', $youtube_url, $matches);
            $this->member->setYoutubeVid(($youtube_url && isset($matches[1])) ? $matches[1] : null);
            $this->member->save();
            //if the form is submited by "Save and continue" button
            if (! $this->getRequestParameter('commit'))
            {
                $this->redirect('dashboard/index');
            } //else the upload button is pressed "commit", so show the photos ..
        }
        $this->photos = $this->member->getMemberPhotos();
    }

    public function validatePhotos()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member = MemberPeer::retrieveByPK($this->getUser()->getId());
            $subscription = $member->getSubscription();
            $cnt_photos = $member->countMemberPhotos();
            
            if( !$subscription->getCanPostPhoto() )
            {
                $this->getRequest()->setError('subscription', 'In order to post photo you need to upgrade your membership.');
                return false;                
            }
            
            if( $cnt_photos >= $subscription->getPostPhotos() )
            {
                $this->getRequest()->setError('subscription', 'For the feature that you want want to use - post photo - you have reached the limit up to which you can use it with your membership. In order to post photo, please upgrade your membership.');
                return false;                
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
}
