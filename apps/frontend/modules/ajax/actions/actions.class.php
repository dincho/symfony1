<?php

/**
 * ajax actions.
 *
 * @package    pr
 * @subpackage ajax
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class ajaxActions extends geoActions
{
    public function executeUsernameExists()
    {
        $username = $this->getRequestParameter('username');
        
        $i18n = sfContext::getInstance()->getI18n();
        if( !preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username) )
        {
            $this->error_msg = $i18n->__('Allowed characters for username are [a-zA-Z][0-9] and underscore, min 4 chars max 20.', array('%USERNAME%' => $username));
            return sfView::SUCCESS; //only one error at once
        }
        
        $member = MemberPeer::retrieveByUsername($username);
        if( $member )
        {
            $this->error_msg = $i18n->__('Sorry, username "%USERNAME%" is already taken.', array('%USERNAME%' => $username));
            return sfView::SUCCESS;  //only one error at once
        }
        
        //if not returned by previews checks, all looks OK
        $this->ok_msg = $i18n->__('Congratulations, your username "%USERNAME%" is available.', array('%USERNAME%' => $username));
    }
    
    public function executeSaveToDraft()
    {
        $c = new Criteria();
        $c->add(MessagePeer::ID, $this->getRequestParameter('draft_id'));
        $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT);
        $c->add(MessagePeer::SENDER_DELETED_AT, null, Criteria::ISNULL);
        $draft = MessagePeer::doSelectOne($c);
        
        if ( $draft )
        {
            $draft->setSubject($this->getRequestParameter('subject'));
            $draft->setBody($this->getRequestParameter('content'));
            $draft->save();
            
            return $this->renderText(__('Draft saved at %TIME%', array('%TIME%' => date('h:i a'))));
        }
        
        return sfView::NONE;
    }
    
    public function executeZongPayment()
    {
        $member = $this->getUser()->getProfile();
        
        if( $member->getLastPaymentState() == 'pending' )
        {
            $this->renderText('<p>' . __('You have pending payment, please allow us up to 24 hours to process it.') . '</p>');
            return sfView::NONE;
        }
        
        $subscription = SubscriptionPeer::retrieveByPK(SubscriptionPeer::PAID);
        
        if( $this->getRequestParameter('entrypointURL') )
        {
            $entrypointURL = $this->getRequestParameter('entrypointURL');
            $amount = 0;
        } else {
            $zong = new prZong($member->getCountry());
            $zongItem = $zong->getFirstItemWithPriceGreaterThan(sfConfig::get('app_zong_amount'));
                
            if( !$zongItem ) 
            {
                $this->renderText('<p>' . __('Zong+ is currently unavailable in your country') . '</p>');
                return sfView::NONE;
            }
        
            $entrypointURL = $zongItem['entrypointURL'];
            $amount = $zongItem['amount'];
        }

        
        $member_subscription = MemberSubscriptionPeer::retrieveByPK($this->getRequestParameter('msid'));
        if( !$member_subscription ) return sfView::NONE;
        
        //create new transaction - each zong request needs a new one
        
        $member_payment = new MemberPayment();
        $member_payment->setMemberId($member->getId());
        $member_payment->setPaymentType('subscription');
        $member_payment->setPaymentProcessor('zong');
        $member_payment->setMemberSubscriptionId($member_subscription->getId());
        $member_payment->setAmount($amount);
        $member_payment->setCurrency($zong->getLocalCurrency());
        $member_payment->setStatus('pending');
        $member_payment->save();
        
        
        $controller = $this->getController();
        $zongParams = array('transactionRef' => $member_payment->getId(),
                            'itemDesc'       => 'Membership',
                            'redirect'       => $controller->genUrl('subscription/thankyou', true),
                            'redirectParent' => 'true',
                            'app'            => 'polishdate',
                            'lang'           => $member->getLanguage(),
                            'basketUrl'      => $controller->genUrl('subscription/payment', true),
                        ); 

        $member->setLastPaymentState('init');
        $member->save();
        
        $zongIframeSrc = $entrypointURL . '&' . http_build_query($zongParams, '', '&');
        $this->zongIframeSrc = $zongIframeSrc;
        $this->setLayout(false);
    }
}
