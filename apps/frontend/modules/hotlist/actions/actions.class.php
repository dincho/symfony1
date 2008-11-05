<?php
/**
 * hotlist actions.
 *
 * @package    pr
 * @subpackage hotlist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class hotlistActions extends sfActions
{
    public function preExecute()
    {
        $bc = $this->getUser()->getBC();
        $bc->addFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
    }

    public function executeIndex()
    {
        $c = new Criteria();
        $c->add(HotlistPeer::MEMBER_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $this->hotlists = HotlistPeer::doSelectJoinMemberRelatedByProfileId($c);
        
        $c = new Criteria();
        $c->add(HotlistPeer::PROFILE_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $this->others_hotlists = HotlistPeer::doSelectJoinMemberRelatedByMemberId($c);
    }

    public function executeAdd()
    {
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        $hotlist = new Hotlist();
        $hotlist->setMemberId($this->getUser()->getId());
        $hotlist->setProfileId($profile->getId());
        $hotlist->save();
        
        //confirm msg
        $msg_ok = sfI18N::getInstance()->__('%USERNAME% has been added to your hotlist. <a href="%HOSTLIST_URL%" class="sec_link">See your hot-list</a>', 
        array('%USERNAME%' => $profile->getUsername(), '%HOSTLIST_URL%' => $this->getController()->genUrl('@hotlist')));
        $this->setFlash('msg_ok', $msg_ok);
        
        $this->redirect('@profile?username=' . $profile->getUsername());
    }

    public function validateAdd()
    {
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        
        if( $this->getUser()->getId() == $profile->getId() )
        {
            $this->setFlash('msg_error', 'You can\'t use this function on your own profile');
            $this->redirect('profile/index?username=' . $profile->getUsername() );
        }
                
        $c = new Criteria();
        $c->add(HotlistPeer::MEMBER_ID, $this->getUser()->getId());
        $c->add(HotlistPeer::PROFILE_ID, $profile->getId());
        $cnt = HotlistPeer::doCount($c);
        if ($cnt > 0)
        {
            $this->getRequest()->setError('hotlist', 'This member is already in your hotlist.');
            return false;
        }
        return true;
    }

    public function handleErrorAdd()
    {
        $c = new Criteria();
        $c->add(HotlistPeer::MEMBER_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $this->hotlists = HotlistPeer::doSelectJoinMemberRelatedByProfileId($c);
        
        $c = new Criteria();
        $c->add(HotlistPeer::PROFILE_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(HotlistPeer::CREATED_AT);
        $this->others_hotlists = HotlistPeer::doSelectJoinMemberRelatedByMemberId($c);

        $this->getUser()->getBC()->removeLast();
        $this->setTemplate('index');
        return sfView::SUCCESS;
    }

    public function executeDelete()
    {
        $c = new Criteria();
        $c->add(HotlistPeer::MEMBER_ID, $this->getUser()->getId());
        $c->add(HotlistPeer::ID, $this->getRequestParameter('id'));
        $hotlist = HotlistPeer::doSelectOne($c);
        $this->forward404Unless($hotlist);
        $hotlist->delete();
        
        //confirm msg
        $msg_ok = sfI18N::getInstance()->__('%USERNAME% has been removed from your hotlist. To undo, <a href="%ADD_URL%" class="sec_link">click here</a>.', 
        array('%USERNAME%' => $hotlist->getMemberRelatedByProfileId()->getUsername(), '%ADD_URL%' => $this->getController()->genUrl('hotlist/add?profile_id=' . $hotlist->getProfileId())));
        $this->setFlash('msg_ok', $msg_ok);
        
        $this->redirect('@hotlist');
    }
}
