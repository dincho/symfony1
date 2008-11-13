<?php
/**
 * subscription actions.
 *
 * @package    pr
 * @subpackage subscription
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class subscriptionActions extends sfActions
{

    public function executeIndex()
    {
        $c = new Criteria();
        $c->add(SubscriptionPeer::ID, array(SubscriptionPeer::FREE, SubscriptionPeer::PAID), Criteria::IN);
        $this->subscriptions = SubscriptionPeer::doSelect($c);
        
        $this->member = $this->getUser()->getProfile();
        $this->redirectIf($this->member->getSubscriptionId() != SubscriptionPeer::FREE, 'subscription/manage');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $subscription = SubscriptionPeer::retrieveByPK($this->getRequestParameter('subscription_id'));
            $this->forward404Unless($subscription);
            if( !in_array($subscription->getId(), array(SubscriptionPeer::FREE, SubscriptionPeer::PAID))) $this->forward404();
            
            if ($subscription->getPeriod1Price() > 0)
            {
                $this->redirect('subscription/payment?subscription_id=' . $subscription->getId());
            } else
            {
                $this->member->changeSubscription($subscription->getId());
                $this->member->save();
                $this->redirect('dashboard/index');
            }
        }
    }

    public function executeManage()
    {
        $this->getUser()->getBC()->clear()
             ->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'))
             ->add(array('name' => 'Subscription', 'uri' => 'subscription/manage'));
             
        $this->member = $this->getUser()->getProfile();

        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            if( $this->getRequestParameter('sub_auto_renew') == 0 && $this->member->getSubAutoRenew() == 1)
            {
                Events::triggerAutoRenew($this->member);
            }
            
            $this->member->setSubAutoRenew($this->getRequestParameter('sub_auto_renew'));
            $this->member->save();
            
            $this->setFlash('msg_ok', 'Auto-Renewal Status have been updated.');
            $this->redirect('dashboard/index');
        }
    }

    public function executePayment()
    {
        $subscription = SubscriptionPeer::retrieveByPK($this->getRequestParameter('subscription_id'));
        $this->forward404Unless($subscription);
        $member = $this->getUser()->getProfile();
        $this->redirectIf($member->getSubscriptionId() != SubscriptionPeer::FREE, 'subscription/manage');
        
        //this is only for test purpose we need to redirect to some payment gateway here
        // or make the payment from some API
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $member->changeSubscription($subscription->getId());
            $member->save();
            
            $this->redirect('subscription/thankyou');
        }
        
        $this->price = $subscription->getPeriod1Price();
        $this->subscription_id = $subscription->getId();
    }

    public function executeThankyou()
    {
    }
}
