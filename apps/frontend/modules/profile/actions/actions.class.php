<?php
/**
 * profile actions.
 *
 * @package    pr
 * @subpackage profile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class profileActions extends sfActions
{

    public function executeIndex()
    {
        $this->getResponse()->addJavascript('http://maps.google.com/maps?file=api&v=2&key=' . sfConfig::get('app_gmaps_key'));
        $this->getResponse()->addJavascript('profile_desc_map.js');
        $this->getResponse()->addJavascript('show_hide_tick');
        
        $member = MemberPeer::retrieveByUsernameJoinAll($this->getRequestParameter('username'));
        $this->forward404Unless($member);
        
        //add a visit
        $this->getUser()->viewProfile($member);

        //recent conversatoions - this need refactoring and move to the model
        $c = new Criteria();
        $crit = $c->getNewCriterion(MessagePeer::TO_MEMBER_ID, $member->getId());
        $crit->addAnd($c->getNewCriterion(MessagePeer::FROM_MEMBER_ID, $this->getUser()->getId()));
        $crit->addAnd($c->getNewCriterion(MessagePeer::SENT_BOX, true));
        
        $crit2 = $c->getNewCriterion(MessagePeer::TO_MEMBER_ID, $this->getUser()->getId());
        $crit2->addAnd($c->getNewCriterion(MessagePeer::FROM_MEMBER_ID, $member->getId()));
        $crit2->addAnd($c->getNewCriterion(MessagePeer::SENT_BOX, false));
        
        $c->add($crit);
        $c->addOr($crit2);
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->setLimit(5);
        $this->recent_conversations = MessagePeer::doSelect($c);

        $c = new Criteria();
        $c->add(MemberMatchPeer::MEMBER1_ID, $this->getUser()->getId());
        $c->add(MemberMatchPeer::MEMBER2_ID, $member->getId());
        $c->setLimit(1);
        $this->match = MemberMatchPeer::doSelectOne($c);
        
        $this->questions = DescQuestionPeer::doSelect(new Criteria());
        $this->answers = DescAnswerPeer::getAnswersAssocById();
        $this->member_answers = MemberDescAnswerPeer::getAnswersAssoc($member->getId());
        $this->header_title = Tools::truncate($member->getEssayHeadline(), 40) . ' / ' . $member->getUsername() . ' /  ' . $member->getAge();
        $this->member = $member;
        
        //IMBRA
        $this->imbra = $member->getLastImbra($approved = true);
        if ($this->imbra)
        {
            $this->imbra_questions = ImbraQuestionPeer::doSelect(new Criteria());
            $this->imbra_answers = $this->imbra->getImbraAnswersArray();
        }
    }

    public function executeSignIn()
    {
        $this->getUser()->getBC()->clear()->add(array('name' => 'Home', 'uri' => '@homepage'))->add(array('name' => 'Sign In', 'uri' => 'profile/signIn'));
        $this->header_title = 'Member Sign In';
        
        //@TODO THIS IS ONLY FOR TESTS, REMOVETE FOR PRODUCTION
        /*
        $c_test = new Criteria();
        $c_test->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
        $c_test->addAscendingOrderByColumn('RAND()');
        $this->test_member = MemberPeer::doSelectOne($c_test);
        */
        //END @TODO
        
        if ($this->getRequest()->getMethod() != sfRequest::POST)
        {
            if ($this->getUser()->isAuthenticated())
            {
                if (! $this->getUser()->hasCredential(array('member'), false))
                    $this->executeSignout();
                $this->redirect('@homepage');
            }
        } else
        {
            $member = MemberPeer::retrieveByEmail($this->getRequestParameter('email'));
            $this->getUser()->SignIn($member);

            $this->redirect(
                    'dashboard/index');
        }
    }

    public function validateSignIn()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $email = $this->getRequestParameter('email');
            $password = sha1(SALT . $this->getRequestParameter('password') . SALT);
            $c = new Criteria();
            $c->add(MemberPeer::EMAIL, $email);
            $c->add(MemberPeer::PASSWORD, $password);
            $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::CANCELED_BY_MEMBER, Criteria::NOT_EQUAL);
            $c->setLimit(1);
            $member = MemberPeer::doSelectOne($c);
            if (! $member)
            {
                $this->getRequest()->setError('login', 'Email and password do not match. Please try again.');
                return false;
            }
        }
        return true;
    }

    public function handleErrorSignIn()
    {
        return sfView::SUCCESS;
    }

    public function executeSignout()
    {
        $this->getUser()->signOut();

        $this->setFlash('msg_ok', 'Thanks for visiting, we hope you had a good time and we\'ll see you soon.');
        $this->redirect('profile/signIn');
    }

    public function executeForgotYourPassword()
    {
        $this->getUser()->getBC()->addBeforeLast(array('name' => 'Sign In', 'uri' => 'profile/signIn'));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            //$member = MemberPeer::retrieveByEmail($this->getRequestParameter('email'));
            $c = new Criteria();
            $c->add(MemberPeer::EMAIL, $this->getRequestParameter('email'));
            $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
            $c->setLimit(1);
            $member = MemberPeer::doSelectOne($c);
            
            if ( $member )
            {
                //set temp pass
                $new_pass = Tools::generateString(8);
                $member->setPassword($new_pass);
                Events::triggerForgotPassword($member);
                $member->save();
            }
            
            $this->redirect('profile/forgotPasswordInfo');
        }
    }

    public function handleErrorForgotYourPassword()
    {
        return sfView::SUCCESS;
    }

    public function executeForgotPasswordInfo()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Sign In', 'uri' => 'profile/signIn'))->add(
                array('name' => 'You have successfully changed your password', 'profile/forgotPasswordConfirm'));
    }

    public function executeForgotPasswordConfirm()
    {
        $hash = $this->getRequestParameter('hash');
        $username = $this->getRequestParameter('username');
        $this->forward404Unless($hash && $username);
        
        $member = MemberPeer::retrieveByUsername($username);
        $this->forward404Unless($member);
        
        $pass_hash = sha1(SALT . $member->getPassword() . SALT);
        $this->forward404Unless($hash == $pass_hash);

        $member->setMustChangePwd(true);
        $member->save();
        
        $this->getUser()->SignIn($member);
        $this->redirect('dashboard/index');
    }
    
    public function executeConfirmNewPassword()
    {
        $username = $this->getRequestParameter('username');
        $hash = $this->getRequestParameter('hash');
        $this->forward404Unless($username && $hash);
        
        $member = MemberPeer::retrieveByUsername($username);
        $this->forward404Unless($member);
        
        $this->forward404Unless($member->getNewPassword() == $hash);
        $member->setPassword($member->getNewPassword(), false);
        $member->setNewPassword(NULL);
        $member->save();
        $this->setFlash('s_title', 'Your new password has been confirmed.');
        $this->setFlash('s_msg', 'You successfully changed your password. Now you can use your new password to log in.');
        $this->redirect('content/message');
    }

    public function executeConfirmNewEmail()
    {
        $username = $this->getRequestParameter('username');
        $hash = $this->getRequestParameter('hash');
        $this->forward404Unless($username && $hash);
        
        $member = MemberPeer::retrieveByUsername($username);
        $this->forward404Unless($member);
        
        $tmp_email_hash = sha1(SALT . $member->getTmpEmail() . SALT);
        //$email_hash = sha1(SALT . $member->getEmail() . SALT);
        $this->forward404Unless($tmp_email_hash == $hash );
        

        $old_mail = $member->getEmail();
        $member->setEmail($member->getTmpEmail());
        $member->setTmpEmail($old_mail); //keep this for undo email change
        $member->setConfirmedEmail(NULL); //clear the confirmation flag for future use 
        $member->save();
        
        Events::triggerNewEmailConfirmed($member);
        
        $this->setFlash('s_title', 'Email verification.');
        $this->setFlash('s_msg', 'Your email address (' . $member->getEmail() . ') has been verified. You may now use it to log in');
        $this->redirect('content/message');
    }
    
    public function executeUndoNewEmail()
    {
        $username = $this->getRequestParameter('username');
        $hash = $this->getRequestParameter('hash');
        $this->forward404Unless($username && $hash);
        
        $member = MemberPeer::retrieveByUsername($username);
        $this->forward404Unless($member);

        $emails_hash = sha1(SALT . $member->getEmail() . SALT . $member->getTmpEmail() . SALT);
        $this->forward404Unless($hash == $emails_hash);
        
        $tmp_email = $member->getEmail();
        $member->setEmail($member->getTmpEmail());
        $member->setTmpEmail($tmp_email);
        $member->save();
        
        $this->setFlash('s_title', 'Email undo.');
        $this->setFlash('s_msg', 'Your have undo your email change. Your email address is back to: ' . $member->getEmail());        
        $this->redirect('content/message');
    }
    

}
