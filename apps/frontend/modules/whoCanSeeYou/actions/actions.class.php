<?php

/**
 * privacy actions.
 *
 * @package    PolishRomance
 * @subpackage privacy
 * @author     Venci Vidov
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class whoCanSeeYouActions extends prActions
{
    public function preExecute()
    {
        $bc = $this->getUser()->getBC();
        $bc->addFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
    }

    public function executeIndex()
    {
        $c = new Criteria();
        $c->add(OpenPrivacyPeer::MEMBER_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(OpenPrivacyPeer::CREATED_AT);
        $this->privacy_list = OpenPrivacyPeer::doSelectJoinMemberRelatedByMemberId($c);        
    }
    
    public function validateIndex()
    {
      return $this->getUser()->getProfile()->getPrivateDating();
    }
    
    public function handleErrorIndex()
    {
      $this->redirect('dashboard/index');
    }    

    public function executeTogglePrivacyPerm()
    {
        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
        $this->forward404Unless($profile);
        
        $perm = OpenPrivacyPeer::getPrivacy($this->getUser()->getId(), $profile->getId());
        if( $perm )
        {
          $perm->delete();        
          $this->setFlash('msg_ok', 'User can not see you anymore.', false);
        }
        else
        {
          $perm = new OpenPrivacy();
          $perm->setMemberRelatedByMemberId($this->getUser()->getProfile());
          $perm->setMemberRelatedByProfileId($profile);
          $perm->save();
          $this->setFlash('msg_ok', 'User can see you now.', false);
        }
                
        if( !$this->getRequest()->isXmlHttpRequest() ) $this->redirectToReferer();
        
        $this->perm = $perm;
    }
    
    public function validateTogglePrivacyPerm()
    {
//        $profile = MemberPeer::retrieveByUsername($this->getRequestParameter('username'));
//        $this->forward404Unless($profile);
        
        
        
        return true;
    }
    
    public function handleErrorTogglePrivacyPerm()
    {
        sfLoader::loadHelpers(array('Partial'));
        
        return $this->renderText(get_partial('content/formErrors'));
    }    

}
