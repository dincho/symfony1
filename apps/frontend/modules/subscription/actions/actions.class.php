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

        if ($this->last_payment) {
            $subscription = SubscriptionDetailsPeer::retrieveBySubscriptionIdAndCatalogId($this->member_subscription->getSubscriptionId(), $this->member->getCatalogId());

            if ( $this->last_payment->getPaymentProcessor() == 'zong' ) {
                $zong = new prZong($this->member->getCountry(), $subscription->getCurrency());
                $zongItem = $zong->getFirstItemWithApproxPrice($subscription->getAmount());
                $this->zongAvailable = (bool) $zongItem;

            } elseif ( $this->last_payment->getPaymentProcessor() == 'dotpay' ) {
                  $dotpay = new DotPay(sfConfig::get('app_dotpay_account_id'), $this->getUser()->getCulture());
                  $dotpay->setAmount($subscription->getAmount());
                  $dotpay->setCurrency($subscription->getCurrency());
                  $dotpay->setDescription($subscription->getTitle() . ' Membership ' . $this->member->getUsername());
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

        if ($member->getLastPaymentState() == 'pending') {
            $this->setFlash('msg_error', 'You have pending payment, please allow us up to 24 hours to process it.');
            $this->redirect('@dashboard');
        }

        $subscription = SubscriptionDetailsPeer::retrieveBySubscriptionIdAndCatalogId(
            $this->getRequestParameter('sid'),
            $member->getCatalogId()
        );
        $this->forward404Unless($subscription);

        //downgrades and double payments are not allowed
        $this->forward404Unless($subscription->getAmount() > $member->getMostRecentSubscription()->getAmount());

        //determine current payment processor
        $memberSubscription = $member->getcurrentMemberSubscription();
        if ($memberSubscription) {
            $currentPaymentProcessor = $memberSubscription->getLastCompletedPayment()->getPaymentProcessor();
        } else {
            $currentPaymentProcessor = null;
        }

        //Members with not canceled non paypal subscriptions are not allowed to upgrade
        if ($memberSubscription
            && $currentPaymentProcessor != 'paypal'
            && $memberSubscription->getStatus() != 'canceled'
        ) {
            $this->redirect('subscription/cancelToUpgrade?sid=' . $subscription->getSubscriptionId());
        }

        /**
        * If member has no current subscription, or it's not paypal (because paypal allow modify)
        * Initialize new pending member subscription for further processing
        */
        if ($currentPaymentProcessor != 'paypal') {
            $member->setLastPaymentState('init');
            $member->save();

            $memberSubscription = MemberSubscriptionPeer::getOrCreatePendingSubscription(
                $member, $subscription
            );
        }

        //build payment processor buttons & forms
        $paymentsFactory = new prPaymentsFactory($member, $subscription);
        $this->zongAvailable = $paymentsFactory->isZongAvailable();
        $this->dotpayURL = $paymentsFactory->getDotpayURL(
            $this->getUser()->getCulture(),
            $this->getController(),
            $memberSubscription->getId()
        );
        $this->encrypted = $paymentsFactory->getPaypalEncryptedData(
            $this->getController(),
            $memberSubscription->getId(),
            //allow upgrade (modify) if last processor is paypal
            ($currentPaymentProcessor == 'paypal')
        );

        //additional details
        $this->amount = $subscription->getAmount();
        $this->currency = $subscription->getCurrency();
        $this->memberSubscription_id = $memberSubscription->getId();
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

        if ( $this->getUser()->getId() == $member->getId() ) {
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
        if ( $member->getLastPaymentState() == 'init' ) {
            $member->setLastPaymentState('pending');
            $member->save();
        }

        if ( $this->getRequestParameter('bonus') == 'true' && $member->getCurrentMemberSubscription() ) { //zong sends true/false strings
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
      $this->member_subscription = $this->getUser()->getProfile()->getCurrentMemberSubscription();

      if ( $this->getRequestParameter('cancelCurrent') ) {
        $this->member_subscription->setStatus('canceled');
        $this->member_subscription->save();

        $this->setFlash('msg_ok', 'Your subscription has been canceled, now you can upgrade it.');
        $this->redirect('subscription/payment?sid=' . $this->getRequestParameter('sid'));
      }

      $this->last_payment = $this->member_subscription->getLastCompletedPayment();
    }
}
