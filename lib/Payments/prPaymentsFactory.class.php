<?php

class prPaymentsFactory
{
    private $member;
    private $subscription;

    public function __construct(Member $member, SubscriptionDetails $subscription)
    {
        $this->member = $member;
        $this->subscription = $subscription;
    }

    public function isZongAvailable()
    {
          $zong = new prZong($this->member->getCountry(), $this->subscription->getCurrency());
          $zongItem = $zong->getFirstItemWithApproxPrice($this->subscription->getAmount());

          return ((bool) $zongItem && $this->subscription->getId() != SubscriptionPeer::PREMIUM_EXPRESS);
    }

    public function isPaypalAvailable()
    {
        return $this->subscription->getSubscriptionId() != SubscriptionPeer::PREMIUM_EXPRESS;
    }

    public function isDotpayAvailable()
    {
        return $this->subscription->getSubscriptionId() != SubscriptionPeer::PREMIUM_EXPRESS;
    }

    public function isDotpaySmsAvailable()
    {
        return $this->subscription->getSubscriptionId() == SubscriptionPeer::PREMIUM_EXPRESS;
    }

    public function getDotpayURL($culture, sfWebController $controller, $memberSubscriptionId)
    {
        $dotpay = new DotPay(
            sfConfig::get('app_dotpay_account_id'),
            $culture
        );

        $dotpay->setAmount($this->subscription->getAmount());
        $dotpay->setCurrency($this->subscription->getCurrency());
        $dotpay->setDescription(
            $this->subscription->getTitle() . ' Membership ' . $this->member->getUsername()
        );
        $dotpay->setReturnURL($controller->genUrl('subscription/thankyou', true));
        $dotpay->setCallbackURL($controller->genUrl(
            sfConfig::get('app_dotpay_callback_url'),
            true
        ));
        $dotpay->setData($memberSubscriptionId);
        $dotpay->setFirstname($this->member->getFirstName());
        $dotpay->setLastname($this->member->getLastName());
        $dotpay->setEmail($this->member->getEmail());

        return $dotpay->generateURL(sfConfig::get('app_dotpay_url'));
    }

    //@see https://www.paypal.com/en_US/ebook/subscriptions/html.html
    public function getPaypalEncryptedData(
        sfWebController $controller,
        $memberSubscriptionId,
        $allowModify
    ) {
        $cancelUrl = $controller->genUrl(
            'subscription/cancel?subscription_id=' . $memberSubscriptionId,
            true
        );

        $parameters = array(
            "cmd" => "_xclick-subscriptions",
            "business" => sfConfig::get('app_paypal_business'),
            "item_name" => $this->getDescription(),
            'item_number' => $this->subscription->getSubscriptionId(),
            'lc' => $this->member->getCountry(),
            'no_note' => 1,
            'no_shipping' => 1,
            'currency_code' => $this->subscription->getCurrency(),
            'rm' => 1, //return method 1 = GET, 2 = POST
            'src' => 1, //Recurring or not
            'sra' => 1, //Reattemt recurring payments on failture
            'modify' => $allowModify ? 2 : 0,
            'notify_url' => $controller->genUrl(sfConfig::get('app_paypal_notify_url'), true),
            'return' => $controller->genUrl('subscription/thankyou', true),
            'cancel_return' => $cancelUrl,
            'a3' => $this->subscription->getAmount(),
            'p3' => $this->subscription->getPeriod(),
            't3' => $this->subscription->getPeriodType(),
            'custom' => $memberSubscriptionId,
        );

        $EWP = new sfEWP();

        return $EWP->encryptFields($parameters);
    }

    public function getDotpaySmsText($memberSubscriptionId)
    {
        return sfConfig::get('app_dotpay_sms_prefix') . '.' . $memberSubscriptionId;
    }

    protected function getDescription()
    {
        return $this->subscription->getTitle() . ' Membership ' . $this->member->getUsername();
    }
}
