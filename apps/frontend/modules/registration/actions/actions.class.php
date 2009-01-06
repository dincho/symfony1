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

    /* Step 1 - the sign up .. */
    public function executeJoinNow()
    {
        $this->setLayout('simple');
        $this->header_span = '';
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'JoinNow headline', 'uri' => 'registration/joinNow'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member = new Member();
            $member->setUsername($this->getRequestParameter('username'));
            $member->setEmail($this->getRequestParameter('email'));
            $member->setPassword($this->getRequestParameter('password'));
            $member->changeStatus(MemberStatusPeer::ABANDONED);
            $member->setSubscriptionId(SubscriptionPeer::FREE);
            
            //some default values
            $member->setLastProfileView(time());
            $member->setLastHotlistView(time());
            $member->setLastWinksView(time());
            $member->setLastActivityNotification(time());
            $member->setEmailNotifications(0);
            
            $sex_looking = explode('_', $this->getRequestParameter('looking_for', 'M_F'));
            $member->setSex($sex_looking[0]);
            $member->setLookingFor($sex_looking[1]);
            
            //init member counter
            $counter = new MemberCounter();
            $counter->setHotlist(0); //just save to work, we need the ID.
            $counter->save();
            
            $member->setMemberCounter($counter);
            $member->save();
            
            $this->getUser()->getAttributeHolder()->clear();
            $this->getUser()->clearCredentials();
                    
            Events::triggerJoin($member);
            $this->message('verify_your_email');
        }
    }

    public function handleErrorJoinNow()
    {
        $this->setLayout('simple');
        
        return sfView::SUCCESS;
    }

    public function executeRequestNewActivationEmail()
    {
        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
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
        $this->forward404Unless($member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        $hash = sha1(SALT . $member->getUsername() . SALT);
        $this->forward404Unless($this->getRequestParameter('hash') == $hash && !$member->getHasEmailConfirmation());
        
        //$member->setPassword($member->getNewPassword(), false);
        //$member->setNewPassword(NULL);
        $member->setHasEmailConfirmation(true);
        $member->save();
        
        //log in the member so he/she can continue with registration
        $this->getUser()->SignIn($member);
        
        sfLoader::loadHelpers(array('Url'));
        $this->message('welcome');
    }

    /* Step 3 - registration coutry, zip, names .. */
    public function executeIndex()
    {
        $this->setLayout('simple');
        $this->header_span = 'Step 1 of 4';
        
        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
        $this->forward404Unless($member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member->setCountry($this->getRequestParameter('country'));
            $member->setStateId($this->getRequestParameter('state_id'));
            $member->setDistrict($this->getRequestParameter('district'));
            $member->setCity($this->getRequestParameter('city'));
            $member->setZip($this->getRequestParameter('zip'));
            $member->setNationality($this->getRequestParameter('nationality'));
            $member->setFirstName($this->getRequestParameter('first_name'));
            $member->setLastName($this->getRequestParameter('last_name'));
            $member->save();
            
            $this->redirect('registration/selfDescription');
        }
        
        $this->member = $member;
    }

    public function handleErrorIndex()
    {
        $this->setLayout('simple');
        $this->header_span = 'Step 1 of 4';
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($this->member); //just in case
        

        return sfView::SUCCESS;
    }

    public function executeSelfDescription()
    {
        $this->setLayout('simple');
        $this->header_span = 'Step 2 of 4';
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
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
                    $m_answer->setDescAnswerId($value);
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
            $has_error = false;
            
            foreach ($questions as $question)
            {
                if ($question->getIsRequired() && (! isset($answers[$question->getId()]) || empty($answers[$question->getId()]) || (! is_null(
                        $question->getOther()) && $answers[$question->getId()] == 'other' && ! $others[$question->getId()])))
                {
                    $this->getRequest()->setError('answers[' . $question->getId() . ']', 'You must fill out the missing information below indicated in red.');
                    $has_error = true;
                }
            }
            
            if ($has_error)
            {
                $this->setFlash('only_last_error', true);
                return false;
            }
        }
        
        return true;
    }

    public function handleErrorSelfDescription()
    {
        $this->header_span = 'Step 2 of 4';
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssoc();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($this->member->getId());
        
        return sfView::SUCCESS;
    }

    public function executeEssay()
    {
        $this->setLayout('simple');
        $this->header_span = 'Step 3 of 4';
        $BC = $this->getUser()->getBC();
        $BC->addBeforeLast(array('name' => 'Self-Description', 'uri' => 'registration/selfDescription'));
        
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
        $this->header_span = 'Step 3 of 4';
        $BC = $this->getUser()->getBC();
        $BC->addBeforeLast(array('name' => 'Self-Description', 'uri' => 'registration/selfDescription'));
                
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case  
        

        return sfView::SUCCESS;
    }

    public function executePhotos()
    {
        $this->setLayout('simple');
        $this->header_span = 'Step 4 of 4';
        $BC = $this->getUser()->getBC();
        $BC->addBeforeLast(array('name' => 'Self-Description', 'uri' => 'registration/selfDescription'));
        $BC->addBeforeLast(array('name' => 'Essay', 'uri' => 'registration/essay'));
                
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('commit') && $this->getRequest()->getFileSize('new_photo'))
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
                $this->getUser()->completeRegistration();
            } //else the upload button is pressed "commit", so show the photos ..
        }
        $this->photos = $this->member->getMemberPhotos();
    }

    public function validatePhotos()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST && $this->getRequestParameter('commit'))
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
                        'For the feature that you want want to use - post photo - you have reached the limit up to which you can use it with your membership. In order to post photo, please upgrade your membership.');
                return false;
            }
        }
        
        return true;
    }

    public function handleErrorPhotos()
    {
        $this->setLayout('simple');
        $this->header_span = 'Step 4 of 4';
        $BC = $this->getUser()->getBC();
        $BC->addBeforeLast(array('name' => 'Self-Description', 'uri' => 'registration/selfDescription'));
        $BC->addBeforeLast(array('name' => 'Essay', 'uri' => 'registration/essay'));
                
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
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->photos = $this->member->getMemberPhotos();
        
        return sfView::SUCCESS;
    }
}
