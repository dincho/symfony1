<?php
class sfDotPayPaymentCallback extends sfPaymentCallback
{
    const STATUS_NEW        = 1;
    const STATUS_DONE       = 2;
    const STATUS_REJECTED   = 3;
    const STATUS_REFUND     = 4;
    const STATUS_COMPLAINT  = 5;

    protected static $statuses = array(1 => 'new',
                                       2 => 'done',
                                       3 => 'rejected',
                                       4 => 'refund',
                                       5 => 'complaint',
    );

    protected $testMode = false;

    public function __construct()
    {
        parent::__construct();
        $this->thisMode = sfConfig::get('app_dotpay_test_mode', false);
    }

    protected function validate()
    {
        $checksum = md5(sprintf('%s:%s:%s:%s:%s:%s:%s:%s:%s:%s:%s',
                            sfConfig::get('app_dotpay_secret'), $this->getParam('id'), $this->getParam('control'),
                            $this->getParam('t_id'), $this->getParam('amount'), $this->getParam('email'),
                            $this->getParam('service'), $this->getParam('code'), $this->getParam('username'), $this->getParam('password'),
                            $this->getParam('t_status')
        ));

        if( $this->getParam('md5') == $checksum &&
            @$_SERVER['REMOTE_ADDR'] == sfConfig::get('app_dotpay_ip_address') )
        {
            return true;
        }

        return false;
    }

    public function handle()
    {
        return parent::handle();
    }

    protected function log($message, $priority = SF_LOG_INFO)
    {
        sfLogger::getInstance()->log('DOTPAY: ' . $message, $priority);
    }

    protected function logNotification()
    {
        $history = new DotpayHistory();
        $history->setAccountId($this->getParam('id'));
        $history->setTransactionId($this->getParam('t_id'));
        $history->setStatus($this->getParam('status'));
        $history->setControl($this->getParam('control'));
        $history->setAmount($this->getParam('amount'));
        $history->setOriginalAmount($this->getParam('orginal_amount')); //this is not type, it's dotpay typo/pl version ?
        $history->setEmail($this->getParam('email'));
        $history->setTStatus($this->getParam('t_status'));
        $history->setDescription($this->getParam('description'));
        $history->setChecksum($this->getParam('md5'));
        $history->setPInfo($this->getParam('p_info'));
        $history->setPEmail($this->getParam('p_email'));

        if( $this->getParam('t_date') )
            $history->setTDate(strtotime($this->getParam('t_date')));

        $history->setRequestIp(ip2long($_SERVER['REMOTE_ADDR']));
        $history->save();
    }

    protected function processNotification()
    {
        $subscription = MemberSubscriptionPeer::retrieveByPK($this->getParam('control'));

       if ($subscription) {
           list($amount, $currency) = explode(' ', $this->getParam('orginal_amount'));
           $status = self::$statuses[$this->getParam('t_status')];

           if ($status == 'refund') {
                $c = new Criteria();
                $c->add(MemberPaymentPeer::PP_REF, $this->getParam('t_id'));

                $member_payment = MemberPaymentPeer::doSelectOne($c);
                $member_payment->voidWithStatus($status);
                $member_payment->save();
           }

           $member_payment = new MemberPayment();
           $member_payment->setMemberSubscriptionId($subscription->getId());
           $member_payment->setMemberId($subscription->getMemberId());
           $member_payment->setPaymentType('subscription');
           $member_payment->setPaymentProcessor('dotpay');
           $member_payment->setAmount($amount);
           $member_payment->setCurrency($currency);
           $member_payment->setStatus($status);
           $member_payment->setPPRef($this->getParam('t_id'));
           $member_payment->setDetails($this->getParams());
           $member_payment->save();

           if( $status == 'done' )
               $member_payment->applyToSubscription();

           $member = $subscription->getMember();
           $member->setLastPaymentState(null);
           $member->save();
       }
    }
}
