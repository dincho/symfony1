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
        $c->add(SubscriptionDetailsPeer::SUBSCRIPTION_ID, SubscriptionPeer::FREE, Criteria::NOT_EQUAL);
        $c->add(SubscriptionDetailsPeer::CAT_ID, $this->member->getCatalogId());
        $c->addAscendingOrderByColumn(sprintf(
            'FIELD(%s, %d, %d, %d)',
            SubscriptionDetailsPeer::SUBSCRIPTION_ID,
            SubscriptionPeer::PREMIUM_EXPRESS,
            SubscriptionPeer::PREMIUM,
            SubscriptionPeer::VIP
        ));

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
        $this->redirectIf(
            $this->member->getSubscriptionId() == SubscriptionPeer::FREE,
            'subscription'
        );

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
            } elseif ($this->last_payment->getPaymentProcessor() == 'dotpay-sms') {
                $this->smsText = sfConfig::get('app_dotpay_sms_prefix') . '.' . $this->member_subscription->getId();
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
        $this->paypalAvailable = $paymentsFactory->isPaypalAvailable();
        $this->dotpayAvailable = $paymentsFactory->isDotpayAvailable();
        $this->dotpaySmsAvailable = $paymentsFactory->isDotpaySmsAvailable();
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
        $this->smsText = $paymentsFactory->getDotpaySmsText($memberSubscription->getId());

        //additional details
        $this->amount = $subscription->getAmount();
        $this->currency = $subscription->getCurrency();
        $this->memberSubscriptionId = $memberSubscription->getId();
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

    public function executeSendGift()
    {
        $this->member = $this->getUser()->getProfile();

        if ($this->getRequest()->getMethod() == sfRequest::POST) {

            $gift = new Gift();
            $gift->setMemberRelatedByFromMemberId($this->member);
            $gift->setToEmail($this->getRequestParameter('email'));

            $rand = Tools::generateString(8) . time();
            $gift->setHash(sha1(SALT . $rand . SALT));
            $gift->setSubscriptionId($this->member->getSubscriptionId());

            $gift->save();

            $this->setFlash('msg_ok', 'Your gift has been successfully sent');

            Events::triggerGiftReceived($gift);

            $this->redirect('subscription/send_gift');
        }

        $this->allowedGifts = GiftPeer::getAllowedGiftsNum($this->member);
    }

    public function validateSendGift() {

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            // check if the email belongs to the currently logged in member
            $this->member = $this->getUser()->getProfile();
            $email = $this->getRequestParameter('email');
            if ($email == $this->member->getEmail()) {
                $this->setFlash('msg_error', 'You can\'t send gifts to yourself');
                return false;
            }

            // check if the email belongs to a non-standard subscriber
            $recipient = MemberPeer::retrieveByEmail($email);
            if ($recipient && $recipient->isPaid()) {
                $this->setFlash('msg_error', 'You can\'t send gifts to Premium ot VIP profiles');
                return false;
            }

            if (GiftPeer::getAllowedGiftsNum($this->member) <= 0) {
                return false;
            }

            if (GiftPeer::canSendGiftToEmail($this->member, $email)) {
                $this->setFlash('msg_error', 'You have already sent a gift to this email address');
                return false;
            }
        }

        return true;
    }

    public function handleErrorSendGift()
    {
        $this->member = $this->getUser()->getProfile();
        $this->allowedGifts = GiftPeer::getAllowedGiftsNum($this->member);

        return sfView::SUCCESS;
    }

    public function executeAcceptGift()
    {
        /* @var Member $member */
        $member = $this->getUser()->getProfile();

        if ($member->isSubscriptionPaid()) {
            $this->setFlash(
                'msg_error',
                'Your already have a subscription. You cannot accept gifts.'
            );
            $this->redirect('subscription/manage');
        }

        $gift = GiftPeer::retrieveByHash($this->getRequestParameter('hash', ''));

        $this->forward404Unless($gift);

        // if sent to unregistered email there is no memberId, so we check the email
        if (!$gift->getToMemberId() && $gift->getToEmail() == $member->getEmail()) {
            // add the memberId so the validation by Id shall pass
            $gift->setToMemberId($member->getId());
        }

        // 404 if the gift is not for this user
        $this->forward404Unless($gift->getToMemberId() == $member->getId());

        if ($gift->isExpired()) {
            $this->setFlash('msg_error', 'Gift expired.');
            $this->redirect('subscription/manage');
        }

        $subscriptionExpires = new DateTime();
        $subscriptionExpires->add(new DateInterval('P' . sfConfig::get('app_gifts_free_period_days') . 'D'));

        $memberSubscription = new MemberSubscription();
        $memberSubscription->setMember($member);
        $memberSubscription->setSubscriptionId($gift->getSubscriptionId());
        $memberSubscription->setPeriod(sfConfig::get('app_gifts_free_period_days'));
        $memberSubscription->setPeriodType('D');
        $memberSubscription->setStatus('active');
        $memberSubscription->setEotAt($subscriptionExpires->getTimestamp());
        $memberSubscription->setEffectiveDate(time());
        $memberSubscription->setGiftBy($gift->getFromMemberId());
        $memberSubscription->save();

        $member->changeSubscription(
            $gift->getSubscriptionId(),
            $gift->getMemberRelatedByFromMemberId()->getUsername() . ' (gift)'
        );
        $member->save();

        $gift->setAccepted(time());
        $gift->save();

        $this->setFlash('msg_ok', 'Your account was upgraded.');
        $this->redirect('subscription/manage');
    }
}
