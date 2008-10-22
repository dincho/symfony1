<?php
/**
 * winks actions.
 *
 * @package    pr
 * @subpackage winks
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class winksActions extends sfActions
{

    public function preExecute()
    {
        $bc = $this->getUser()->getBC();
        $bc->addFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
    }

    public function executeIndex()
    {
        $c = new Criteria();
        $c->add(WinkPeer::MEMBER_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(WinkPeer::CREATED_AT);
        $this->sent_winks = WinkPeer::doSelectJoinMemberRelatedByProfileId($c);
        
        $c = new Criteria();
        $c->add(WinkPeer::PROFILE_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(WinkPeer::CREATED_AT);
        $this->received_winks = WinkPeer::doSelectJoinMemberRelatedByMemberId($c);
    }

    public function executeSend()
    {
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        $wink = new Wink();
        $wink->setMemberId($this->getUser()->getId());
        $wink->setProfileId($profile->getId());
        $wink->save();
        
        //confirm msg
        $msg_ok = sfI18N::getInstance()->__('Congratulations! You have just sent the wink. Wait and see. Or see <a href="%WINKS_URL%" class="sec_link">all your winks</a>.', 
                array('%WINKS_URL%' => $this->getController()->genUrl('@winks')));
        $this->setFlash('msg_ok', $msg_ok);
        $this->redirect('@profile?username=' . $profile->getUsername());
    }

    public function validateSend()
    {
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        
        $c = new Criteria();
        $c->add(WinkPeer::MEMBER_ID, $this->getUser()->getId());
        $c->add(WinkPeer::PROFILE_ID, $profile->getId());
        $cnt = WinkPeer::doCount($c);
        if ($cnt > 0)
        {
            $this->getRequest()->setError('winks', 'Your already has sent wink to this member.');
            return false;
        }
        return true;
    }

    public function handleErrorSend()
    {
        $c = new Criteria();
        $c->add(WinkPeer::MEMBER_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(WinkPeer::CREATED_AT);
        $this->sent_winks = WinkPeer::doSelectJoinMemberRelatedByProfileId($c);
        
        $c = new Criteria();
        $c->add(WinkPeer::PROFILE_ID, $this->getUser()->getId());
        $c->addDescendingOrderByColumn(WinkPeer::CREATED_AT);
        $this->received_winks = WinkPeer::doSelectJoinMemberRelatedByMemberId($c);

        $this->getUser()->getBC()->removeLast();
        $this->setTemplate('index');
        return sfView::SUCCESS;
    }

    public function executeDelete()
    {
        $c = new Criteria();
        $c->add(WinkPeer::ID, $this->getRequestParameter('id'));
        $crit = $c->getNewCriterion(WinkPeer::MEMBER_ID, $this->getUser()->getId());
        $crit->addOr($c->getNewCriterion(WinkPeer::PROFILE_ID, $this->getUser()->getId()));
        $c->add($crit);
        $wink = WinkPeer::doSelectOne($c);
        $this->forward404Unless($wink);
        $wink->delete();
        
        //confirm msg
        $msg_ok = sfI18N::getInstance()->__('%USERNAME% has been removed from your winks. To undo, <a href="%ADD_URL%" class="sec_link">click here</a>.', 
                array('%USERNAME%' => $wink->getProfile()->getUsername(), '%ADD_URL%' => $this->getController()->genUrl('winks/undo?id=' . $wink->getId())));
        $this->setFlash('msg_ok', $msg_ok);
        $this->redirect('@winks');
    }
}
