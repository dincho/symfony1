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
        $this->member = $this->getUser()->getProfile();
        
        $c = new Criteria();
        $c->add(SubscriptionDetailsPeer::CAT_ID, $this->member->getCatalogId());
        $c->addAscendingOrderByColumn(SubscriptionDetailsPeer::AMOUNT);
        $this->subscriptions = SubscriptionDetailsPeer::doSelect($c);
    
        $this->recent_subscription = $this->member->getMostRecentSubscription();
        $this->forward404Unless($this->recent_subscription);
    }

    public function executeManage()
    {
        $this->getUser()->getBC()->clear()
             ->add(array('name' => 'Dashboard', 'uri' => 'dashboard/index'))
             ->add(array('name' => 'Subscription', 'uri' => 'subscription/manage'));
             
        $this->member = $this->getUser()->getProfile();
        $this->redirectIf($this->member->getSubscriptionId() == SubscriptionPeer::FREE, 'subscription/payment');
        
        $this->member_subscription = $this->member->getCurrentMemberSubscription();
        $this->next_member_subscription = $this->member->getNextMemberSubscription();
        //@todo when all subscription without "next_amount", gets EOTS, we'll not need this anymore
        $this->last_payment = ( $this->member_subscription ) ? $this->member_subscription->getLastCompletedPayment() : null;
        $this->date_format = ( $this->getUser()->getCulture() == 'pl' ) ? 'dd MMM yyyy' : 'MMM dd, yyyy';
        
        if( $this->last_payment )
        {
            $subscription = SubscriptionDetailsPeer::retrieveBySubscriptionIdAndCatalogId($this->member_subscription->getSubscriptionId(), $this->member->getCatalogId());
            
            if( $this->last_payment->getPaymentProcessor() == 'zong' )
            {
                $zong = new prZong($this->member->getCountry(), $subscription->getCurrency());
                $zongItem = $zong->getFirstItemWithApproxPrice($subscription->getAmount());
                $this->zongAvailable = (bool) $zongItem;
                
            } elseif ( $this->last_payment->getPaymentProcessor() == 'dotpay' )
            {
                  $dotpay = new DotPay(sfConfig::get('app_dotpay_account_id'), $this->getUser()->getCulture());
                  $dotpay->setAmount($subscription->getAmount());
                  $dotpay->setCurrency($subscription->getCurrency());
                  $dotpay->setDescription($subscription->getTitle() . ' Membership');
                  $dotpay->setReturnURL($this->getController()->genUrl('subscription/thankyou', true));
                  $dotpay->setCallbackURL($this->getController()->genUrl(sfConfig::get('app_dotpay_callback_url'), true));
                  $dotpay->setData($this->member_subscription->getId());
                  $dotpay->setFirstname($this->member->getFirstName());
                  $dotpay->setLastname($this->member->getLastName());
                  $dotpay->setEmail($this->member->getEmail());
                  $this->dotpayURL = $dotpay->generateURL(sfConfig::get('app_dotpay_url'));
            }
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
        
        $subscription = SubscriptionDetailsPeer::retrieveBySubscriptionIdAndCatalogId($this->getRequestParameter('sid'), $member->getCatalogId());
        $this->forward404Unless($subscription);
        
        //downgrades and double payments are not allowed
        $this->forward404Unless($subscription->getAmount() > $member->getMostRecentSubscription()->getAmount());
        
        $current_member_subscription = $member->getCurrentMemberSubscription();
        $is_last_processor_paypal = ($current_member_subscription && $current_member_subscription->getLastCompletedPayment()->getPaymentProcessor() == 'paypal');
        
        if( $current_member_subscription && !$is_last_processor_paypal && $current_member_subscription->getStatus() != 'canceled')
        {
          $this->redirect('subscription/cancelToUpgrade?sid=' . $subscription->getSubscriptionId());
        }

        $this->zongAvailable = false;
        
        if( !$is_last_processor_paypal )
        {
          $member->setLastPaymentState('init');
          $member->save();
        
          //check if we already have some pending subscription
          $c = new Criteria();
          $c->add(MemberSubscriptionPeer::MEMBER_ID, $member->getId());
          $c->add(MemberSubscriptionPeer::SUBSCRIPTION_ID, $subscription->getSubscriptionID());
          $c->add(MemberSubscriptionPeer::STATUS, 'pending');
          $member_subscription = MemberSubscriptionPeer::doSelectOne($c);
        
          if( !$member_subscription ) //no subscription found, create new one.
          {
              $member_subscription = new MemberSubscription();
              $member_subscription->setMemberId($member->getId());
              $member_subscription->setSubscriptionId($subscription->getSubscriptionId());
              $member_subscription->setPeriod($subscription->getPeriod());
              $member_subscription->setPeriodType($subscription->getPeriodType());
          }
          
          
          //if effective subscription look for last subscription EOT
          $effective_date = ( sfConfig::get('app_settings_immediately_subscription_upgrade') || !$current_member_subscription ) ? time() : $member->getLastEotAt();
          $member_subscription->setEffectiveDate( $effective_date );
          $member_subscription->save();
          
          $zong = new prZong($member->getCountry(), $subscription->getCurrency());
          $zongItem = $zong->getFirstItemWithApproxPrice($subscription->getAmount());
          $this->zongAvailable = (bool) $zongItem;
          
          $dotpay = new DotPay(sfConfig::get('app_dotpay_account_id'), $this->getUser()->getCulture());
          $dotpay->setAmount($subscription->getAmount());
          $dotpay->setCurrency($subscription->getCurrency());
          $dotpay->setDescription($subscription->getTitle() . ' Membership');
          $dotpay->setReturnURL($this->getController()->genUrl('subscription/thankyou', true));
          $dotpay->setCallbackURL($this->getController()->genUrl(sfConfig::get('app_dotpay_callback_url'), true));
          $dotpay->setData($member_subscription->getId());
          $dotpay->setFirstname($member->getFirstName());
          $dotpay->setLastname($member->getLastName());
          $dotpay->setEmail($member->getEmail());
          $this->dotpayURL = $dotpay->generateURL(sfConfig::get('app_dotpay_url'));
        
        } else {
          $member_subscription = $current_member_subscription;
        }

        //paypal setup
        //@see https://www.paypal.com/en_US/ebook/subscriptions/html.html
        $EWP = new sfEWP();
        $parameters = array("cmd" => "_xclick-subscriptions",
                            "business" => sfConfig::get('app_paypal_business'),
                            "item_name" => $subscription->getTitle() . ' Membership',
                            'item_number' => $subscription->getSubscriptionId(),
                            'lc' => $member->getCountry(),
                            'no_note' => 1,
                            'no_shipping' => 1,
                            'currency_code' => $subscription->getCurrency(),
                            'rm' => 1, //return method 1 = GET, 2 = POST
                            'src' => 1, //Recurring or not
                            'sra' => 1, //Reattemt recurring payments on failture
                            'modify' => ( $is_last_processor_paypal ) ? 2 : 0, 
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
        $this->currency = $subscription->getCurrency();
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
                            'currency_code' => 'GBP',
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
            $this->member_subscription_id = $member->getCurrentMemberSubscription()->getSubscriptionId();
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
