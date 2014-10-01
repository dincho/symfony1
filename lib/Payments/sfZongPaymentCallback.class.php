<?php

class sfZongPaymentCallback extends sfPaymentCallback
{
    protected $transactionID;
    protected $acceptSimulated = false;

    public function __construct()
    {
        parent::__construct();
        $this->acceptSimulated = sfConfig::get('app_zong_accept_simulated', false);
    }

    public function getTransactionId()
    {
        return $this->transactionID;
    }

    protected function validate()
    {
        if( !$this->acceptSimulated && $this->getParam('simulated') == 'true' ) return false;

        $cert_file = sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . 'zong_pubkey_v1.pem';
        $cert = file_get_contents($cert_file);
        $pubkeyid = openssl_get_publickey($cert);
        $query_params = $this->getParams(); //we need a copy

        $signature = base64_decode($this->getParam('signature'));
        $query_params['signature'] = '';
        ksort($query_params);

        $query_string = '?' . http_build_query($query_params, '', '&');

        //1 - OK, 0 - wrong, -1 SSL error
        $verified = (bool) openssl_verify($query_string, $signature, $pubkeyid); //we don't need to return -1, just boolean is enought
        openssl_free_key($pubkeyid);

        return $verified;
    }

    public function handle()
    {
        $this->transactionID = $this->getParam('transactionRef');

        return parent::handle();
    }

    protected function log($message, $priority = SF_LOG_INFO)
    {
        sfLogger::getInstance()->log('ZONG: ' . $message, $priority);
    }

    protected function logNotification()
    {
        $history = new ZongHistory();
        $history->setTransactionRef($this->getParam('transactionRef'));
        $history->setItemRef($this->getParam('itemRef'));
        $history->setStatus($this->getParam('status'));
        $history->setFailure($this->getParam('failure'));
        $history->setMethod($this->getParam('method'));
        $history->setMsisdn($this->getParam('msisdn'));
        $history->setOutPayment($this->getParam('outPayment'));
        $history->setSimulated( ($this->getParam('simulated') == 'true') ? true : false );
        $history->setSignature($this->getParam('signature'));
        $history->setSignatureVersion($this->getParam('signatureVersion'));
        $history->setRequestIp(ip2long($_SERVER['REMOTE_ADDR']));
        $history->save();
    }

    protected function processNotification()
    {
        $member_payment = MemberPaymentPeer::retrieveByPK($this->getParam('transactionRef'));

        if ($member_payment) {
            $member_payment->setStatus(strtolower($this->getParam('status')));
            $member_payment->getMember()->setLastPaymentState(null);
            $member_payment->save();

            if ( $member_payment->getStatus() == 'completed' ) {
                switch ($member_payment->getPaymentType()) {
                    case 'subscription':
                           $member_payment->applyToSubscription();
                        break;

                    default:

                        break;
                }

            }
        }
    }
}
