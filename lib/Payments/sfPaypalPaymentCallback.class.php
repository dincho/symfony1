<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 12, 2009 5:16:59 PM
 * 
 */
 

class sfPaypalPaymentCallback extends sfPaymentCallback
{
    private $paypal_response = null;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    protected function validate()
    {
        if( $this->getParam('test_ipn') && !sfConfig::get('app_paypal_test') ) return false;
        if( $this->getParam('receiver_email') != sfConfig::get('app_paypal_business') ) return false;
        
        $params = array_merge(array('cmd' => '_notify-validate'), $this->getParams());
        $data = http_build_query($params, '', '&');
        
        $process = curl_init();
        curl_setopt($process, CURLOPT_URL, sfConfig::get('app_paypal_url'));
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        $this->paypal_response = curl_exec($process);
        curl_close($process);
        
        return ($this->paypal_response == 'VERIFIED') ? true : false;
    }
    
    protected function logNotification()
    {
        $history = new IpnHistory();
        $history->setParameters(serialize($this->getParams()));
        $history->setTxnType($this->getParam('txn_type'));
        $history->setSubscrId($this->getParam('subscr_id'));
        $history->setTxnId($this->getParam('txn_id'));
        $history->setPaymentStatus($this->getParam('payment_status'));
        $history->setRequestIp(ip2long($_SERVER['REMOTE_ADDR']));
        $history->setPaypalResponse($this->paypal_response);
        $history->setIsRenewal($this->getParam('is_renewal', false));
        $history->setMemberSubscrId($this->getParam('member_subscr_id'));
        $history->save();
    }
    
    protected function log($message, $priority = SF_LOG_INFO)
    {
        sfLogger::getInstance()->log('{sfPaypalPaymentCallback} ' . $message, $priority);
    }
    
    public function processNotification()
    {
        if( $this->getParam('subscr_date') )
        {
            $note_time = strtotime($this->getParam('subscr_date'));
        } elseif ( $this->getParam('payment_date') )
        {
            $note_time = strtotime($this->getParam('payment_date'));
        }
        
        //04.15.2010 00:00:00 - this should be set to the time of the this release
        if( $note_time < 1271289600 )
        {
            $this->processNotificationOld();
        } else {
            $this->processNotificationNew();
        }
    }
    
    protected function processNotificationNew()
    {   
        if( $this->getParam('txn_type') )
        {
            switch ($this->getParam('txn_type')) {
                case 'subscr_payment':
                       $member_subscription = MemberSubscriptionPeer::retrieveByPPRef($this->getParam('subscr_id'));
                       
                       if( $member_subscription )
                       {
                           $member_payment = new MemberPayment();
                           $member_payment->setMemberSubscriptionId($member_subscription->getId());
                           $member_payment->setMemberId($member_subscription->getMemberId());
                           $member_payment->setPaymentType('subscription');
                           $member_payment->setPaymentProcessor('paypal');
                           $member_payment->setAmount($this->getParam('mc_gross'));
                           $member_payment->setCurrency($this->getParam('mc_currency'));
                           $member_payment->setStatus(strtolower($this->getParam('payment_status')));
                           $member_payment->setPPRef($this->getParam('txn_id'));
                           $member_payment->setDetails($this->getParams());
                           $member_payment->save();
                           
                           if( $this->getParam('payment_status') == 'Completed') $member_payment->applyToSubscription();
                           $member = $member_subscription->getMember();
                           $member->setLastPaymentState(null);
                           $member->save();
                       }
                break;
                
                case 'subscr_signup':
                    //confirm member subscription
                    $c = new Criteria();
                    $c->add(MemberSubscriptionPeer::ID, $this->getParam('custom'));
                    $c->add(MemberSubscriptionPeer::STATUS, 'pending');
                    $member_subscription = MemberSubscriptionPeer::doSelectOne($c);
                    
                    if( $member_subscription )
                    {
                        list($period, $period_type) = explode(' ', $this->getParam('period3'));
                        
                        $member_subscription->setPeriod($period);
                        $member_subscription->setPeriodType($period_type);
                        $member_subscription->setStatus('active');
                        $member_subscription->setDetails($this->getParams());
                        $member_subscription->setPPRef($this->getParam('subscr_id'));
                        $member_subscription->setCreatedAt(strtotime($this->getParam('subscr_date')));
                        $member_subscription->setUpdatedAt(strtotime($this->getParam('subscr_date')));
                        $member_subscription->save();
                    }
                break;
                
                case 'subscr_cancel':
                    //cancel member subscription - note that this not lead to EOF
                    $member_subscription = MemberSubscriptionPeer::retrieveByPPRef($this->getParam('subscr_id'));
                    
                    if($member_subscription)
                    {
                        $member_subscription->setStatus('canceled');
                        $member_subscription->save();
                    }
                break;
                
                //IMBRA payments
                case 'web_accept':
                    //create payment_transaction and just record it
                    //also we need to put some flag on the member object that he/she is already paid for the imbra, or we should check this on the fly ?!
                break;
                                
                default:
                    sfLogger::getInstance()->notice('Unhandled txn_type: ' . $this->getParam('txn_type'));
                break;
            }
            
        } else {
            if( $this->getParam('payment_status') == 'Reversed' || $this->getParam('payment_status') == 'Refunded' )
            {
                $c = new Criteria();
                $c->add(MemberPaymentPeer::PP_REF, $this->getParam('parent_txn_id'));
                $member_payment = MemberPaymentPeer::doSelectOne($c);
                
                if( $member_payment )
                {
                    $member_payment->voidWithStatus(strtolower($this->getParam('payment_status')));
                    $member_payment->save();
                    
                    //record the new payment
                    $void_payment = new MemberPayment();
                    $void_payment->setMemberSubscriptionId($member_payment->getMemberSubscriptionId());
                    $void_payment->setMemberId($member_payment->getMemberId());
                    $void_payment->setPaymentType($member_payment->getPaymentType());
                    $void_payment->setPaymentProcessor($member_payment->getPaymentProcessor());
                    $void_payment->setAmount($this->getParam('mc_gross'));
                    $void_payment->setCurrency($this->getParam('mc_currency'));
                    $void_payment->setStatus(strtolower($this->getParam('payment_status')));
                    $void_payment->setPPRef($this->getParam('txn_id'));
                    $void_payment->setDetails($this->getParams());
                    $void_payment->save();
                }

            } else {
                sfLogger::getInstance()->notice('Unhandled payment_status: ' . $this->getParam('payment_status'));
            }            
        }
        
        return false;    
    }
    
    public function processNotificationOld()
    {        
        if( $this->getParam('txn_type') )
        {
            switch ($this->getParam('txn_type')) {
                case 'subscr_payment':
                       $c = new Criteria();
                       $c->add(MemberSubscriptionPeer::PP_REF, $this->getParam('subscr_id'));
                       $member_subscription = MemberSubscriptionPeer::doSelectOne($c);
                       
                       if( $member_subscription )
                       {   
                           $member_payment = new MemberPayment();
                           $member_payment->setMemberSubscriptionId($member_subscription->getId());
                           $member_payment->setMemberId($member_subscription->getMemberId());
                           $member_payment->setPaymentType('subscription');
                           $member_payment->setPaymentProcessor('paypal');
                           $member_payment->setAmount($this->getParam('mc_gross'));
                           $member_payment->setCurrency($this->getParam('mc_currency'));
                           $member_payment->setStatus(strtolower($this->getParam('payment_status')));
                           $member_payment->setPPRef($this->getParam('txn_id'));
                           $member_payment->setDetails($this->getParams());
                           $member_payment->setCreatedAt(strtotime($this->getParam('payment_date')));
                           $member_payment->setUpdatedAt(strtotime($this->getParam('payment_date')));
                           $member_payment->save();
                       
                           if( $this->getParam('payment_status') == 'Completed') $member_payment->applyToSubscription();
                       } else {
                           $this->log('Received payment but can not find a subscription: ' . $this->getParam('subscr_id'));
                       }
                break;
                
                case 'subscr_signup':
                       $member = MemberPeer::retrieveByPK($this->getParam('custom'));
                       if( !$member ) $member = MemberPeer::retrieveByUsername($this->getParam('custom'));
                       
                       if( $member )
                       {
                            list($period, $period_type) = explode(' ', $this->getParam('period3'));
                            
                            $member_subscription = new MemberSubscription();
                            $member_subscription->setMemberId($member->getId());
                            $member_subscription->setSubscriptionId(SubscriptionPeer::PAID);
                            $member_subscription->setPeriod($period);
                            $member_subscription->setPeriodType($period_type);
                            $member_subscription->setStatus('active');
                            $member_subscription->setDetails($this->getParams());
                            $member_subscription->setPPRef($this->getParam('subscr_id'));
                            $member_subscription->setCreatedAt(strtotime($this->getParam('subscr_date')));
                            $member_subscription->setUpdatedAt(strtotime($this->getParam('subscr_date')));
                            $member_subscription->save();
                       }
                break;
                
                case 'subscr_cancel':
                       $c = new Criteria();
                       $c->add(MemberSubscriptionPeer::PP_REF, $this->getParam('subscr_id'));
                       $member_subscription = MemberSubscriptionPeer::doSelectOne($c);
                   
                       if( $member_subscription )
                       {
                           $member_subscription->setStatus('canceled');
                           $member_subscription->save();
                       }
                break;
                                
                default:
                    $this->log('Unhandled txn_type: ' . $this->params['txn_type']);
                break;
            }
            
        } else {
            if( $this->getParam('payment_status') == 'Reversed' || $this->getParam('payment_status') == 'Refunded' )
            {

            } else {
                $this->log('Unhandled payment_status: ' . $this->getParam('payment_status'));
            }            
        }
        
        return false;
    }    
}