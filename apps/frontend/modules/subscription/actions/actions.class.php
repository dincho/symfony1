<?php
/**
 * subscription actions.
 *
 * @package    pr
 * @subpackage subscription
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class subscriptionActions extends prActions
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
            
            if ($subscription->getId() == SubscriptionPeer::PAID)
            {
                $this->redirect('subscription/payment?subscription_id=' . $subscription->getId());
            } else
            {
                //$this->member->changeSubscription($subscription->getId());
                //$this->member->save();
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
        $this->redirectIf($this->member->getSubscriptionId() != SubscriptionPeer::PAID, 'subscription/payment');
        
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
        $member = $this->getUser()->getProfile();
        $this->redirectIf($member->getSubscriptionId() != SubscriptionPeer::FREE, 'subscription/manage');
        if( !is_null($member->getLastPaypalSubscrId()) )
        {
            $this->setFlash('msg_error', 'You already have a subscription');
            $this->redirect('@dashboard');
        }
        $subscription = SubscriptionPeer::retrieveByPK(SubscriptionPeer::PAID);
        
        $EWP = new sfEWP();
        $parameters = array("cmd" => "_xclick-subscriptions",
                            "business" => sfConfig::get('app_paypal_business'),
                            "item_name" => sfConfig::get('app_primary_domain'),
                            'lc' => 'US',
                            'no_note' => 1,
                            'no_shipping' => 1,
                            'currency_code' => 'GBP',
                            'rm' => 1, //return method 1 = GET, 2 = POST
                            'cbt' => 'Return to ' .sfConfig::get('app_primary_domain'),
                            'src' => 1, //Recurring or not
                            'sra' => 1, //Reattemt recurring payments on failture
                            'notify_url' => 'http://pr.dincho.bonex.us:8003/frontend_dev.php/IPN.html',
                            //'notify_url' => $this->getController()->genUrl('@ipn', true), 
                            'return' => $this->getController()->genUrl('subscription/thankyou', true),
                            'cancel_return' => $this->getController()->genUrl('subscription/cancel', true),
                            'a1' => $subscription->getTrial1Amount(),
                            'p1' => $subscription->getTrial1Period(),
                            't1' => $subscription->getTrial1PeriodType(),
                            'a2' => $subscription->getTrial2Amount(),
                            'p2' => $subscription->getTrial2Period(),
                            't2' => $subscription->getTrial2PeriodType(),
                            'a3' => $subscription->getAmount(),
                            'p3' => 1,
                            't3' => 'M',
                            'custom' => $member->getUsername(),
                            
        );
        
        $this->encrypted = $EWP->encryptFields($parameters);
    }

    public function executeThankyou()
    {
    }
    
    public function executeCancel()
    {
        
    }
    
    public function executeIPN()
    {
        $ipn = new sfIPN();
        //$ipn->validate();
        return sfView::NONE;
    }
}
