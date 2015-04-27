<?php

class sfDotPaySmsPaymentCallback extends sfPaymentCallback
{
    protected $accountId;

    public function __construct()
    {
        parent::__construct();

        $this->accountId = sfConfig::get('app_dotpay_sms_account_id');
        $this->secret = sfConfig::get('app_dotpay_sms_secret');
    }

    protected function validate()
    {
        $hash = md5(
            $this->accountId .
            $this->secret .
            $this->getParam('ident') .
            $this->getParam('service') .
            $this->getParam('number') .
            $this->getParam('sender') .
            $this->getParam('code') .
            $this->getParam('date') .
            $this->getParam('fulltext')
        );

        if ($this->getParam('md5') == $hash) {
            return true;
        }

        return false;
    }

    protected function log($message, $priority = SF_LOG_INFO)
    {
        sfLogger::getInstance()->log('DOTPAY_SMS: ' . $message, $priority);
    }

    protected function logNotification()
    {
        $history = new DotpaySmsHistory();
        $history->setService($this->getParam('service'));
        $history->setIdent($this->getParam('ident'));
        $history->setNumber($this->getParam('number'));
        $history->setSender($this->getParam('sender'));
        $history->setCode($this->getParam('code'));
        $history->setText($this->getParam('text'));
        $history->setDate(strtotime($this->getParam('date')));
        $history->setChecksum($this->getParam('md5'));
        $history->setRequestIp(ip2long($_SERVER['REMOTE_ADDR']));
        $history->save();
    }

    protected function processNotification()
    {
        $memberSubscriptionId = (int) $this->getParam('text');
        if ($memberSubscriptionId <= 0) {
            $this->log(sprintf('Wrong member subscription id: %d', $memberSubscriptionId));

            return false;
        }

        $memberSubscription = MemberSubscriptionPeer::retrieveByPK($memberSubscriptionId);
        if (!$memberSubscription) {
            $this->log(sprintf('Member subscription with id "%d" not found', $memberSubscriptionId));

            return false;
        }

        $subscriptionDetails = SubscriptionDetailsPeer::retrieveBySubscriptionIdAndCatalogId(
            $memberSubscription->getSubscriptionId(),
            $memberSubscription->getMember()->getCatalogId()
        );

        $member_payment = new MemberPayment();
        $member_payment->setMemberSubscriptionId($memberSubscription->getId());
        $member_payment->setMemberId($memberSubscription->getMemberId());
        $member_payment->setPaymentType('subscription');
        $member_payment->setPaymentProcessor('dotpay-sms');
        $member_payment->setAmount($subscriptionDetails->getAmount());
        $member_payment->setCurrency($subscriptionDetails->getCurrency());
        $member_payment->setStatus('done');
        $member_payment->setPPRef($this->getParam('code'));
        $member_payment->setDetails($this->getParams());
        $member_payment->save();

        $member_payment->applyToSubscription();

        $member = $memberSubscription->getMember();
        $member->setLastPaymentState(null);
        $member->save();

        return true;
    }
}
