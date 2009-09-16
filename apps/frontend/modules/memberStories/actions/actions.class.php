<?php

/**
 * memberStories actions.
 *
 * @package    pr
 * @subpackage memberStories
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class memberStoriesActions extends prActions
{

    public function executeIndex()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
        $c->add(MemberStoryPeer::CULTURE, $this->getUser()->getCulture());
        $this->stories = MemberStoryPeer::doSelect($c);
        
        $this->getUser()->getBC()->addFirst(array('name' => 'Home', 'uri' => '@homepage'));
    }

    public function executeRead()
    {
        $c = new Criteria();
        $c->add(MemberStoryPeer::SLUG, $this->getRequestParameter('slug'));
        //$c->add(MemberStoryPeer::CULTURE, $this->getUser()->getCulture());
        $c->setLimit(1);
        
        $stories = MemberStoryPeer::doSelectJoinStockPhoto2($c);
        $this->forward404Unless($stories);
        $this->story = $stories[0];
        
        $this->getResponse()->setTitle($this->story->getTitle());
        $this->getResponse()->addMeta('keywords', $this->story->getKeywords());
        $this->getResponse()->addMeta('description', $this->story->getDescription());
        
        $bc = $this->getUser()->getBC()->clear();
        $bc->add(array('name' => 'Home', 'uri' => '@homepage'));
    
    }

    public function executePostYourStory()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $feedback = new Feedback();
            $feedback->setSubject('New Member Story');
            $feedback->setMailTo(FeedbackPeer::SUPPORT_ADDRESS);
            $feedback->setMailbox(FeedbackPeer::INBOX);
            $feedback->setIsRead(FALSE);
            
            $body = '';
            if( $this->getUser()->isAuthenticated())
            {
                $member = $this->getUser()->getProfile();
                $feedback->setMailFrom($member->getEmail());
                $feedback->setNameFrom($member->getFullName());
                $feedback->setMemberId($member->getId());                
            } else {
                $feedback->setMailFrom($this->getRequestParameter('email'));
                $feedback->setNameFrom($this->getRequestParameter('your_name'));
            }

            $body .= '<strong>' . $this->getRequestParameter('story_title') . '</strong><br /><br />';
            $body .= $this->getRequestParameter('your_story');
            $feedback->setBody($body);
            $feedback->save();
            
            $this->redirect('memberStories/postYourStoryConfirmation');            
        }
    }

    public function validatePostYourStory()
    {
        $return = true;
        if($this->getRequest()->getMethod() == sfRequest::POST)
        {
          if(!$this->getUser()->isAuthenticated())
          {
              if (! $this->getRequestParameter('your_name'))
              {
                  $this->getRequest()->setError('your_name', 'You must provide your name. ');
                  $return = false;
              }
            
              $email = $this->getRequestParameter('email');
              if (!$email)
              {
                  $this->getRequest()->setError('email', 'You must provide your email address.');
                  $return = false;
              } else {
                $emailValidator = new prEmailValidator();
                $emailValidator->initialize($this->getContext(), array(
                  'strict'      => true,
                  'email_error' => 'Please provide email address in correct format.',
                ));
            
                if (!$emailValidator->execute($email, $mailerror)) 
                {
                  $this->getRequest()->setError('email', $mailerror);
                  $return = false;
                }                
              }
          }
          
          if( !$this->getRequestParameter('story_title') )
          {
            $this->getRequest()->setError('story_title', 'Please enter a title.');
            $return = false;
          }          
          
          $your_story = $this->getRequestParameter('your_story');
          if( !$your_story )
          {
            $this->getRequest()->setError('your_story', 'Please enter a content.');
            $return = false;
          } else {          
            $myValidator = new sfStringValidator();
            $myValidator->initialize($this->getContext(), array(
              'min'       => 50,
              'min_error' => 'We also like short stories, but please make it at least 50 characters, so that we can share your story with others',
              'max'       => 2500,
              'max_error' => 'Your story may contain maximum 2500 characters.',
            ));
            
            if (!$myValidator->execute($your_story, $error)) 
            {
              $this->getRequest()->setError('your_story', $error);
              $return = false;
            }
          }
          
          if( !$this->getRequestParameter('tos') )
          {
            $this->getRequest()->setError('tos', 'You must agree to Terms of Use and Privacy Policy to continue.');
            $return = false;
          }            
        }
        return $return;
    }

    public function handleErrorPostYourStory()
    {
        return sfView::SUCCESS;
    }
    
    public function executePostYourStoryConfirmation()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Thank you for sharing your story'));
    }
}
