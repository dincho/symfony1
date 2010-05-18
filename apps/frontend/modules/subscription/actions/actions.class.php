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
        $c->addAscendingOrderByColumn(SubscriptionPeer::AMOUNT);
        $this->subscriptions = SubscriptionPeer::doSelect($c);
    
        $this->member = $this->getUser()->getProfile();
        // $this->redirectIf($this->member->getSubscriptionId() != SubscriptionPeer::FREE, 'subscription/manage');
    }

    public function executeManage()
    {
        $this->getUser()->getBC()->clear()
             ->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'))
             ->add(array('name' => 'Subscription', 'uri' => 'subscription/manage'));
             
        $this->member = $this->getUser()->getProfile();
        $this->redirectIf($this->member->getSubscriptionId() == SubscriptionPeer::FREE, 'subscription/payment');
        
        $this->member_subscription = $this->member->getCurrentMemberSubscription();
        $this->last_payment = ( $this->member_subscription ) ? $this->member_subscription->getLastCompletedPayment() : null;
        $this->date_format = ( $this->getUser()->getCulture() == 'pl' ) ? 'dd MMM yyyy' : 'MMM dd, yyyy';
        
        if( $this->last_payment && $this->last_payment->getPaymentProcessor() == 'zong' )
        {
            $zong = new prZong($this->member->getCountry(), sfConfig::get('app_settings_currency_' . $this->getUser()->getCulture(), 'GBP'));
            $zongItem = $zong->getFirstItemWithApproxPrice($this->member_subscription->getSubscription()->getAmount());
        
            $this->zongAvailable = (bool) $zongItem;
        }
    }
    
    
    public function executePayment()
    {
        $member = $this->getUser()->getProfile();
        // $this->redirectIf($member->getSubscriptionId() != SubscriptionPeer::FREE, 'subscription/manage');
        
        if( $member->getLastPaymentState() == 'pending' )
        {
            $this->setFlash('msg_error', 'You have pending payment, please allow us up to 24 hours to process it.');
            $this->redirect('@dashboard');
        }
        
        $subscription = SubscriptionPeer::retrieveByPK($this->getRequestParameter('sid'));
        $this->forward404Unless($subscription);
                
        if( $member->getCurrentMemberSubscription() && $member->getCurrentMemberSubscription()->getStatus() != 'canceled')
        {
          $this->redirect('subscription/cancelToUpgrade?sid=' . $subscription->getId());
        }

        $member->setLastPaymentState('init');
        $member->save();

        //check if we already have some subscription
        $c = new Criteria();
        $c->add(MemberSubscriptionPeer::MEMBER_ID, $member->getId());
        $c->add(MemberSubscriptionPeer::SUBSCRIPTION_ID, $subscription->getID());
        $c->add(MemberSubscriptionPeer::STATUS, 'pending');
        $member_subscription = MemberSubscriptionPeer::doSelectOne($c);
        
        if( !$member_subscription ) //no subscription found, create new one.
        {
            $member_subscription = new MemberSubscription();
            $member_subscription->setMemberId($member->getId());
            $member_subscription->setSubscriptionId($subscription->getId());
            $member_subscription->setPeriod($subscription->getPeriod());
            $member_subscription->setPeriodType($subscription->getPeriodType());
        }
        
        //if effective subscription look for last subscription EOT
        $member_subscription->setEffectiveDate( ($member->getCurrentMemberSubscription()) ? $member->getLastEotAt() : time() );
        $member_subscription->save();
                    
        //paypal setup
        $EWP = new sfEWP();
        $parameters = array("cmd" => "_xclick-subscriptions",
                            "business" => sfConfig::get('app_paypal_business'),
                            "item_name" => $_SERVER['HTTP_HOST'] . ' Membership',
                            'item_number' => $member->getId(),
                            'lc' => $member->getCountry(),
                            'no_note' => 1,
                            'no_shipping' => 1,
                            'currency_code' => sfConfig::get('app_settings_currency_' . $this->getUser()->getCulture(), 'GBP'),
                            'rm' => 1, //return method 1 = GET, 2 = POST
                            'src' => 1, //Recurring or not
                            'sra' => 1, //Reattemt recurring payments on failture
                            'notify_url' => $this->getController()->genUrl(sfConfig::get('app_paypal_notify_url'), true),
                            'return' => $this->getController()->genUrl('subscription/thankyou', true),
                            'cancel_return' => $this->getController()->genUrl('subscription/cancel?subscription_id=' . $member_subscription->getId(), true),
                            'a3' => $subscription->getAmount(),
                            'p3' => $subscription->getPeriod(),
                            't3' => $subscription->getPeriodType(),
                            'custom' => $member_subscription->getId(),
        );
        
        
        $this->encrypted = $EWP->encryptFields($parameters);
        $this->amount = $subscription->getAmount();
        
        //zong setup
        $zong = new prZong($member->getCountry(), sfConfig::get('app_settings_currency_' . $this->getUser()->getCulture(), 'GBP'));
        $zongItem = $zong->getFirstItemWithApproxPrice($subscription->getAmount());
                
        $this->zongAvailable = (bool) $zongItem;
        $this->member_subscription_id = $member_subscription->getId();
    }

    
    protected function executeGiftMembership()
    {
        $this->forward404Unless( sfConfig::get('app_settings_enable_gifts') );
        $member = MemberPeer::retrieveByUsername($this->getRequestParameter('profile'));
        $this->forward404Unless($member);
        $this->forward404Unless($member->getSubscriptionId() == SubscriptionPeer::FREE);
        
        $i18n = $this->getContext()->getI18N();
        $bc_parent = $i18n->__("%USERNAME%'s profile", array('%USERNAME%' => $member->getUsername()));
        $bc_buy_string = $i18n->__('Buy %USERNAME% a gift', array('%USERNAME%' => $member->getUsername()));
                
        $this->getUser()->getBC()->clear()
        ->add(array('name' => $bc_parent, 'uri' => '@profile?username=' . $member->getUsername()))
        ->add(array('name' => $bc_buy_string));
        
        if( $this->getUser()->getId() == $member->getId() )
        {
            $this->setFlash('msg_error', 'You can\'t use this function on your own profile');
            $this->redirect('profile/index?username=' . $member->getUsername() );
        }
                    
        $this->member = $member;
        $this->amount = 29.95;
        
        $EWP = new sfEWP();
        $parameters = array("cmd" => "_xclick-subscriptions",
                            "business" => sfConfig::get('app_paypal_business'),
                            "item_name" => 'Buy ' . $_SERVER['HTTP_HOST'] . ' Gift to ' . $member->getUsername(),
                            'item_number' => 'gift_membership',
                            'lc' => $this->getUser()->getProfile()->getCountry(),
                            'no_note' => 1,
                            'no_shipping' => 1,
                            'currency_code' => sfConfig::get('app_settings_currency_' . $this->getUser()->getCulture(), 'GBP'),
                            'rm' => 1, //return method 1 = GET, 2 = POST
                            'src' => 0, //Recurring or not
                            'sra' => 1, //Reattemt recurring payments on failture
                            'notify_url' => $this->getController()->genUrl(sfConfig::get('app_paypal_notify_url'), true), 
                            'return' => $this->getController()->genUrl('subscription/thankyouGift?profile=' . $member->getUsername(), true),
                            'cancel_return' => $this->getController()->genUrl('@profile?cancel_gift=1&username=' . $member->getUsername(), true),
                            'a3' => $this->amount,
                            'p3' => 3,
                            't3' => 'M',
                            'custom' => $member->getId().'|'.$this->getUser()->getId(),
                            
        );
        
        $this->encrypted = $EWP->encryptFields($parameters);
    }
        
    public function executeThankyou()
    {
        $this->getUser()->getBC()->clear()
             ->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'))
             ->add(array('name' => 'Subscription', 'uri' => 'subscription/manage'))
             ->add(array('name' => 'Thank you for your payment'));
             
        $member = $this->getUser()->getProfile();
        if( $member->getLastPaymentState() == 'init' )
        {
            $member->setLastPaymentState('pending');
            $member->save();
        }
        
        if( $this->getRequestParameter('bonus') == 'true' && $member->getCurrentMemberSubscription() ) //zong sends true/false strings
        {
            $this->zongBonusEntryPointUrl = urlencode($this->getRequestParameter('bonusEntryPointUrl'));
            $this->member_subscription_id = $member->getCurrentMemberSubscription()->getId();
        }
    }
        
    protected function executeThankyouGift()
    {
        $member = MemberPeer::retrieveByUsername($this->getRequestParameter('profile'));
        $this->forward404Unless($member);

        $this->getUser()->getBC()->clear()->add(array('name' => $member->getUsername() . "'s Profile", 'uri' => '@profile?username=' . $member->getUsername()))
        ->add(array('name' => 'Buy ' . $member->getUsername() . ' a gift'))
        ->add(array('name' => 'Thank you!')); 
                
        $this->member = $member;
    }
    
    public function executeCancel()
    {
        
    }
    
    public function executeIPN()
    {
        $this->forward('callbacks', 'paypal');
    }
    
    public function executeCancelToUpgrade()
    {
      $member_subscription = $this->getUser()->getProfile()->getCurrentMemberSubscription();
      
      if( $this->getRequestParameter('cancelCurrent') )
      {
        $member_subscription->setStatus('canceled');
        $member_subscription->save();
        
        $this->setFlash('msg_ok', 'Your subscription has been canceled, now you can upgrade it.');
        $this->redirect('subscription/payment?sid=' . $this->getRequestParameter('sid'));
      }
      
      $this->last_payment = $member_subscription->getLastCompletedPayment();
    }
}
