<?php

/**
 * registration actions.
 *
 * @package    pr
 * @subpackage registration
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class registrationActions extends sfActions
{
    /* Step 1 - the sign up .. */
    public function executeJoinNow()
    {
        $this->setLayout('simple');
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'Registration', 'uri' => 'registration/joinNow'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $member = new Member();
            $member->setUsername($this->getRequestParameter('username'));
            $member->setEmail($this->getRequestParameter('email'));
            $member->setTmpPassword($this->getRequestParameter('password')); //keep in tmp field until email confirmation
            $member->changeStatus(MemberStatusPeer::ABANDONED);
            $member->setSubscriptionId(SubscriptionPeer::FREE);
            
            $sex_looking = explode('_', $this->getRequestParameter('looking_for', 'M_F'));
            $member->setSex($sex_looking[0]);
            $member->setLookingFor($sex_looking[1]);
            
            //init member counter
            $counter = new MemberCounter();
            $counter->setHotlist(0); //just save to work, we need the ID.
            $counter->save();
            
            $member->setMemberCounter($counter);
            $member->save();
            
            Events::triggerJoin($member);
            $this->setFlash('s_title', 'Verify Your Email');
            $this->setFlash('s_msg', 'For your own security, please go to your email box and verify your email by clicking on the link we have just sent you.');
            $this->redirect('content/message');
        }
    }
    
    public function handleErrorJoinNow()
    {
        $this->setLayout('simple');
        
        return sfView::SUCCESS;
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
        $this->forward404Unless($this->getRequestParameter('hash') == $hash);
        
        $member->setPassword($member->getTmpPassword(), false);
        $member->setTmpPassword(NULL);
        $member->save();
        
        //log in the member so he/she can continue with registration
        $this->getUser()->SignIn($member);

        sfLoader::loadHelpers(array('Url'));
        $this->setFlash('s_title', 'Welcome');
        $this->setFlash('s_msg', 'Congratulations! You’ve just activated your account. <a href="{REGISTRATION_URL}" class="sec_link">Please finish the sign up now.</a>');
        $this->setFlash('s_vars', array('{REGISTRATION_URL}' => url_for('registration/index')));
        
        $this->redirect('content/message');
    }
    
    /* Step 3 - registration coutry, zip, names .. */
    public function executeIndex()
    {
        $this->setLayout('simple');
        $member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($member); //just in case
        $this->forward404Unless($member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $member->setLanguage($this->getRequestParameter('language'));
            $member->setCountry($this->getRequestParameter('country'));
            $member->setStateId($this->getRequestParameter('state'));
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
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getid());
        $this->forward404Unless($this->member); //just in case
        
        return sfView::SUCCESS;
    }
    
    public function executeSelfDescription()
    {
        $this->setLayout('simple');
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
                
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $birthday_arr = $this->getRequestParameter('birth_day');
            $birthday = $birthday_arr['year'] . '-' . $birthday_arr['month'] . '-' . $birthday_arr['day'];
            $this->member->setBirthDay($birthday);
            $this->member->setDontDisplayZodiac($this->getRequestParameter('dont_display_zodiac'));

            $this->member->clearDescAnswers();
            /*
            $c = new Criteria();
            $c->add(MemberDescAnswerPeer::MEMBER_ID, $this->getUser()->getId());
            MemberDescAnswerPeer::doDelete($c);
            */
            
            foreach ($this->getRequestParameter('answers') as $question_id => $value)
            {
                $q = DescQuestionPeer::retrieveByPK($question_id);
                
                $m_answer = new MemberDescAnswer();
                $m_answer->setDescQuestionId($question_id);
                $m_answer->setMemberId($this->getUser()->getId());
                                    
                if( $q->getType() == 'other_langs' )
                {
                    $m_answer->setOtherLangs($value);
                    $m_answer->setDescAnswerId(null);
                } else {
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
    
    public function executeEssay()
    {
        $this->setLayout('simple');
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
                
        if( $this->getRequest()->getMethod() == sfRequest::POST )
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
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case  
                
        return sfView::SUCCESS;
    }
    
    public function executePhotos()
    {
        $this->setLayout('simple');
        
        $this->member = MemberPeer::retrieveByPK($this->getUser()->getId());
        $this->forward404Unless($this->member); //just in case
        $this->forward404Unless($this->member->getMemberStatusId() == MemberStatusPeer::ABANDONED);
        
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
                if( $photo ) $photo->setAsMainPhoto();
            }
            
            //YouTube Video
            $youtube_url = $this->getRequestParameter('youtube_url');
            $matches = array();
            preg_match('#http://www\.youtube\.com/watch\?v=([a-z0-9]+)#i', $youtube_url, $matches);
            $this->member->setYoutubeVid( ($youtube_url && isset($matches[1])) ? $matches[1] : null);
            $this->member->save();
                        
            //if the form is submited by "Save and continue" button
            if( !$this->getRequestParameter('commit') )
            {
                if( $this->member->countMemberPhotos() > 0 )
                {
                    if( is_null($this->member->getUsCitizen()) && $this->member->getCountry() == 'US' )
                    {
                        $this->redirect('editProfile/imbra');
                    } else {
                        //activate the member
                        if( $this->member->getMemberStatusId()  == MemberStatusPeer::ABANDONED) $this->member->setMemberStatusId(MemberStatusPeer::ACTIVE);
                        $this->redirect('dashboard/index');                        
                    }
                } else {
                    $this->getRequest()->setError('photos', 'At least 1 photograph is required in order to continue.');
                }                
            } //else the upload button is pressed "commit", so show the photos ..

        }
        
        $this->photos = $this->member->getMemberPhotos();
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

        if( $photos < 2 )
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
