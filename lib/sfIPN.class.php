<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 12, 2009 5:16:59 PM
 * 
 */
 

class sfIPN
{
    private $request = null;
    private $params = array();
    private $paypal_response = null;
    
    public function __construct()
    {
        $this->request = sfContext::getInstance()->getRequest();
        $this->params = $this->request->getParameterHolder()->getAll();
        unset($this->params['module']);
        unset($this->params['action']);
        unset($this->params['sf_culture']);
        
        //test mode protection
        if( isset($this->params['test_ipn']) && !sfConfig::get('app_paypal_test') ) return;
    }
    
    public function handle()
    {
        $this->validate();
        
        if( $this->paypal_response == 'VERIFIED')
        {
            $this->processNotification();
        }
        
        $this->logNotification();
    }
    
    protected function validate()
    {
        $params = array_merge(array('cmd' => '_notify-validate'), $this->params);
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
        $history->setParameters(serialize($this->params));
        $history->setTxnType(isset($this->params['txn_type']) ? $this->params['txn_type'] : null);
        $history->setSubscrId(isset($this->params['subscr_id']) ? $this->params['subscr_id'] : null);
        $history->setTxnId(isset($this->params['txn_id']) ? $this->params['txn_id'] : null);
        $history->setPaymentStatus(isset($this->params['payment_status']) ? $this->params['payment_status'] : null);
        $history->setRequestIp(ip2long($_SERVER['REMOTE_ADDR']));
        $history->setPaypalResponse($this->paypal_response);
        $history->setIsRenewal(isset($this->params['is_renewal']) ? $this->params['is_renewal'] : false);
        $history->setMemberSubscrId(isset($this->params['member_subscr_id']) ? $this->params['member_subscr_id'] : null);
        $history->save();
    }
    
    protected function log($message, $priority = SF_LOG_INFO)
    {
        sfLogger::getInstance()->log('sfIPN: ' . $message, $priority);
    }
    
    public function processNotification()
    {
        if( isset($this->params['txn_type']) 
            && $this->params['receiver_email'] == sfConfig::get('app_paypal_business')
            && $this->params['mc_currency'] == 'GBP')
        {
            switch ($this->params['txn_type']) {
            	case 'subscr_payment':
            	   if( $this->params['payment_status'] == 'Completed')
            	   {
            	       $member = MemberPeer::retrieveByUsername($this->params['custom']);
            	       if( $member )
            	       {
            	           $member->clearCounters();
            	           $member->changeSubscription(SubscriptionPeer::PAID);
            	           $member->setLastPaypalPaymentAt($this->params['payment_date']);
            	           $member->setLastPaypalItem($this->params['item_number']);
            	           $member->save();
            	           
            	           //renewal or not
            	           $c = new Criteria();
            	           $c->add(IpnHistoryPeer::SUBSCR_ID, $this->params['subscr_id']);
            	           $c->add(IpnHistoryPeer::TXN_TYPE, 'subscr_payment');
            	           $c->add(IpnHistoryPeer::PAYMENT_STATUS, 'Completed');
            	           $this->params['renewal'] = (IpnHistoryPeer::doCount($c) > 0) ? true : false;
            	           
            	           
            	           $this->params['member_subscr_id'] = $member->getSubscriptionId();
            	           
            	           return true;
            	       }
            	   }
            	break;
            	
            	case 'subscr_signup':
            	       $member = MemberPeer::retrieveByUsername($this->params['custom']);
            	       if( $member )
            	       {
            	           $member->setLastPaypalSubscrId($this->params['subscr_id']);
            	           $member->setLastPaypalItem($this->params['item_number']);
            	           $member->setPaypalUnsubscribedAt(null);
            	           $member->save();
            	           return true;
            	       }
            	break;
            	
            	case 'subscr_cancel':
                       $member = MemberPeer::retrieveByUsername($this->params['custom']);
                       if( $member && ($member->getLastPaypalSubscrId() == $this->params['subscr_id']) )
                       {
                            if( $member->getLastPaypalSubscrId() == $this->params['subscr_id'] )
                            {
                                $member->setPaypalUnsubscribedAt(time());
                                $member->save();
                                return true;
                            }
                       }            	    
            	break;
            	
            	case 'subscr_eot':
                       $member = MemberPeer::retrieveByUsername($this->params['custom']);
                       if( $member && ($member->getLastPaypalSubscrId() == $this->params['subscr_id']) )
                       {
                           $member->clearCounters();
                           $member->changeSubscription(SubscriptionPeer::FREE);
                           $member->setLastPaypalSubscrId(null);
                           $member->setLastPaypalPaymentAt(null);
                           $member->setLastPaypalItem(null);
                           $member->save();
                           return true;
                       }             	    
            	break;
            	
            	//IMBRA payments
                case 'web_accept':
	                $member = MemberPeer::retrieveByUsername($this->params['custom']);
	                if( $member )
	                {
	                     if( $this->params['payment_status'] == 'Pending')
	                     {
	                     	$member->setImbraPayment('pending');
	                     } elseif( $this->params['payment_status'] == 'Completed' )
	                     {
	                     	$member->setImbraPayment('completed');
	                     } elseif( $this->params['payment_status'] == 'Failed' )
	                     {
	                     	$member->setImbraPayment(null);
	                     }
	                    
	                     $member->save();
	                    return true;
	                }
                break;
                            	
            	default:
            	    sfLogger::getInstance()->notice('Unhandled txn_type: ' . $this->params['txn_type']);
            	break;
            }
            
        }
        
        return false;
    }    
}