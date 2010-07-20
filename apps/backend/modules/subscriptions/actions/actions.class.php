<?php
// auto-generated by sfPropelCrud
// date: 2008/05/07 13:20:11
?>
<?php

/**
 * subscriptions actions.
 *
 * @package    pr
 * @subpackage subscriptions
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class subscriptionsActions extends sfActions
{
  public function executeList()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(SubscriptionPeer::AMOUNT);
    $this->subscriptions = SubscriptionPeer::doSelect($c);
  }

  public function executeEdit()
  {
    //$subscription = SubscriptionPeer::retrieveByPk($this->getRequestParameter('id'));
    //$this->forward404Unless($subscription);
    $subscriptions = SubscriptionPeer::doSelect(new Criteria());
    
    if( $this->getRequest()->getMethod() == sfRequest::POST )
    {
        $this->getUser()->checkPerm(array('subscriptions_edit'));
        $req_subs = $this->getRequestParameter('subs');
        foreach ($subscriptions as $subscription)
        {
            if( array_key_exists($subscription->getId(), $req_subs) )
            {
                $subscription->setCanCreateProfile($req_subs[$subscription->getId()]['can_create_profile']);
                $subscription->setCreateProfiles($req_subs[$subscription->getId()]['create_profiles']);
                $subscription->setCanPostPhoto($req_subs[$subscription->getId()]['can_post_photo']);
                $subscription->setPostPhotos($req_subs[$subscription->getId()]['post_photos']);
                $subscription->setCanPostPrivatePhoto($req_subs[$subscription->getId()]['can_post_private_photo']);
                $subscription->setPostPrivatePhotos($req_subs[$subscription->getId()]['post_private_photos']);
                $subscription->setCanWink($req_subs[$subscription->getId()]['can_wink']);
                $subscription->setWinks($req_subs[$subscription->getId()]['winks']);
                $subscription->setWinksDay($req_subs[$subscription->getId()]['winks_day']);
                $subscription->setCanReadMessages($req_subs[$subscription->getId()]['can_read_messages']);
                $subscription->setReadMessages($req_subs[$subscription->getId()]['read_messages']);
                $subscription->setReadMessagesDay($req_subs[$subscription->getId()]['read_messages_day']);
                $subscription->setCanReplyMessages($req_subs[$subscription->getId()]['can_reply_messages']);
                $subscription->setReplyMessages($req_subs[$subscription->getId()]['reply_messages']);
                $subscription->setReplyMessagesDay($req_subs[$subscription->getId()]['reply_messages_day']);
                $subscription->setCanSendMessages($req_subs[$subscription->getId()]['can_send_messages']);
                $subscription->setSendMessages($req_subs[$subscription->getId()]['send_messages']);
                $subscription->setSendMessagesDay($req_subs[$subscription->getId()]['send_messages_day']);
                $subscription->setCanSeeViewed($req_subs[$subscription->getId()]['can_see_viewed']);
                $subscription->setSeeViewed($req_subs[$subscription->getId()]['see_viewed']);
                $subscription->setCanContactAssistant($req_subs[$subscription->getId()]['can_contact_assistant']);
                $subscription->setContactAssistant($req_subs[$subscription->getId()]['contact_assistant']);
                $subscription->setContactAssistantDay($req_subs[$subscription->getId()]['contact_assistant_day']);
                $subscription->setPreApprove(@$req_subs[$subscription->getId()]['pre_approve']);
                
                $subscription->setPeriod($req_subs[$subscription->getId()]['period']);
                $subscription->setPeriodType($req_subs[$subscription->getId()]['period_type']);
                $subscription->setAmount($req_subs[$subscription->getId()]['amount']);
                $subscription->setImbraAmount($req_subs[$subscription->getId()]['imbra_amount']);
                $subscription->save();   
                
                sfSettingPeer::updateFromRequest(array('currency_en', 'currency_pl'));
            }
        }
        
	    return $this->redirect('subscriptions/list');
    }
    
    $this->subscriptions = $subscriptions;
    $this->sub1 = $subscriptions[0];
  }

  public function validateEdit()
  {
    if( $this->getRequest()->getMethod() == sfRequest::POST )
    {   
        $req_subs = $this->getRequestParameter('subs');
        
        foreach($req_subs as $id => $sub)
        {
          $field_name = 'subs['. $id.'][period]';
        
          if( !is_numeric($sub['period']) || $sub['period'] <= 0 )
          {
              $this->getRequest()->setError($field_name, 'Please enter a positive integer');
              return false;
            
          }
        
          //regular subscription
          switch ($sub['period_type']) {
              case 'D':
                  if( $sub['period'] > 90 )
                  {
                      $this->getRequest()->setError($field_name, 'Allowable range is 1 to 90');
                      return false;
                  }
                  break;
              case 'W':
                  if( $sub['period'] > 52 )
                  {
                      $this->getRequest()->setError($field_name, 'Allowable range is 1 to 52');
                      return false;
                  }            
                  break;
              case 'M':
                  if( $sub['period'] > 24 )
                  {
                      $this->getRequest()->setError($field_name, 'Allowable range is 1 to 24');
                      return false;
                  }            
                  break;
              case 'Y':
                  if( $sub['period'] > 5 )
                  {
                      $this->getRequest()->setError($field_name, 'Allowable range is 1 to 5');
                      return false;
                  }            
                  break;
              default:
                  break;
          }
        }
    }
    
    return true;
  }
  
  public function handleErrorEdit()
  {
      $subscriptions = SubscriptionPeer::doSelect(new Criteria());
      $this->subscriptions = $subscriptions;
      $this->sub1 = $subscriptions[0];  
      
      return sfView::SUCCESS;    
  }
}
