<?php
/**
 * winks actions.
 *
 * @package    pr
 * @subpackage winks
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class winksActions extends prActions
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
        $c->add(WinkPeer::SENT_BOX, true);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $this->sent_winks = WinkPeer::doSelectJoinMemberRelatedByProfileId($c);
        
        $c = new Criteria();
        $c->add(WinkPeer::PROFILE_ID, $this->getUser()->getId());
        $c->add(WinkPeer::SENT_BOX, false);
        $c->addDescendingOrderByColumn(WinkPeer::CREATED_AT);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        $this->received_winks = WinkPeer::doSelectJoinMemberRelatedByMemberId($c);
    }

    public function executeSend()
    {
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        
        WinkPeer::send($this->getUser()->getProfile(), $profile);
        
        //confirm msg
        $msg_ok = sfI18N::getInstance()->__('Congratulations! You have just sent the wink. Wait and see. Or see <a href="%WINKS_URL%" class="sec_link">all your winks</a>.', 
                array('%WINKS_URL%' => $this->getController()->genUrl('@winks')));
        $this->setFlash('msg_ok', $msg_ok, false);
        
        return $this->renderText(get_partial('content/messages'));
    }

    public function validateSend()
    {
        $profile = MemberPeer::retrieveByPK($this->getRequestParameter('profile_id'));
        $this->forward404Unless($profile);
        $member = $this->getUser()->getProfile();
        
        if( $member->getId() == $profile->getId() )
        {
            $this->setFlash('msg_error', 'You can\'t use this function on your own profile');
            // $this->redirect('profile/index?username=' . $profile->getUsername() );
            return false;
        }
        
        //2. Privacy
        $prPrivavyValidator = new prPrivacyValidator();
        $prPrivavyValidator->setProfiles($member, $profile);
        $prPrivavyValidator->initialize($this->getContext(), array(
          'block_error' => 'You can not send wink to this profile!',
          'sex_error' => 'Due to privacy restrictions you cannot send wink to this profile',
          'check_onlyfull' => false,
        ));
        
        $error = '';
        if( !$prPrivavyValidator->execute(&$value, &$error) )
        {
            $this->getRequest()->setError('privacy', $error);
            return false;
        }
                    
        $subscription = $this->getUser()->getProfile()->getSubscriptionDetails();
        if( !$subscription->getCanWink() )
        {
          $this->getRequest()->setError('subscription', sprintf('%s: In order to send wink you need to upgrade to become a Full Member.', $subscription->getTitle()));
          return false;
        }
        
        if( $this->getUser()->getProfile()->getCounter('SentWinksDay') >= $subscription->getWinksDay() )
        {
          $this->getRequest()->setError('subscription', sprintf('%s: For the feature that you want to use - send wink - you have reached the daily limit up to which you can use it with your membership. In order to send wink, please upgrade your membership.', $subscription->getTitle()));
          return false;
        }
        
        if( $this->getUser()->getProfile()->getCounter('SentWinks') >= $subscription->getWinks() )
        {
          $this->getRequest()->setError('subscription', sprintf('%s: For the feature that you want to use - send wink - you have reached the limit up to which you can use it with your membership. In order to send wink, please upgrade your membership.', $subscription->getTitle()));
          return false;
        }
                
        if ($this->getUser()->getProfile()->hasWinkTo($profile->getId()))
        {
            $this->getRequest()->setError('winks', 'Your already has sent wink to this member.');
            return false;
        }
        
        return true;
    }

    public function handleErrorSend()
    {
        return $this->renderText(get_partial('content/formErrors'));
    }

    public function executeDelete()
    {
        $c = new Criteria();
        $c->add(WinkPeer::ID, $this->getRequestParameter('id'));
        $c->add(WinkPeer::DELETED_AT, null, Criteria::ISNULL);
        
        $crit = $c->getNewCriterion(WinkPeer::MEMBER_ID, $this->getUser()->getId());
        $crit->addAnd($c->getNewCriterion(WinkPeer::SENT_BOX, true));
        
        $crit2 = $c->getNewCriterion(WinkPeer::PROFILE_ID, $this->getUser()->getId());
        $crit2->addAnd($c->getNewCriterion(WinkPeer::SENT_BOX, false));
        $crit->addOr($crit2);
        $c->add($crit);
        
        $wink = WinkPeer::doSelectOne($c);
        $this->forward404Unless($wink);
        $wink->delete();
        
        $username = ($wink->getSentBox()) ? $wink->getMemberRelatedByProfileId()->getUsername() : $wink->getMemberRelatedByMemberId()->getUsername();
        //confirm msg
        $msg_ok = sfI18N::getInstance()->__('%USERNAME% has been removed from your winks. <a href="%URL_FOR_WINK_UNDO_DELETE%" class="sec_link">Click here to add her back.</a>', 
                array('%USERNAME%' => $username, '%URL_FOR_WINK_UNDO_DELETE%' => $this->getController()->genUrl('winks/undoDelete?id=' . $wink->getId())));
        
        $this->setFlash('msg_ok', $msg_ok);
        $this->redirect('@winks');
    }
    
    public function executeUndoDelete()
    {
        $c = new Criteria();
        $c->add(WinkPeer::ID, $this->getRequestParameter('id'));
        $c->add(WinkPeer::DELETED_AT, null, Criteria::ISNOTNULL);
        
        $crit = $c->getNewCriterion(WinkPeer::MEMBER_ID, $this->getUser()->getId());
        $crit->addAnd($c->getNewCriterion(WinkPeer::SENT_BOX, true));
        
        $crit2 = $c->getNewCriterion(WinkPeer::PROFILE_ID, $this->getUser()->getId());
        $crit2->addAnd($c->getNewCriterion(WinkPeer::SENT_BOX, false));
        $crit->addOr($crit2);
        $c->add($crit);
        
        $wink = WinkPeer::doSelectOne($c);
        $this->forward404Unless($wink);
        $wink->setDeletedAt(null);
        $wink->save();
        
        $this->redirect('@winks');        
    }
}
