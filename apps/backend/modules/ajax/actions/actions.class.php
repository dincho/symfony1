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
  public function executeGetFeedbackById()
  {
      $this->message = FeedbackPeer::retrieveByPK($this->getRequestParameter('id'));
  }

  public function executeGetPrMailMessageById()
  {
      $this->message = PrMailMessagePeer::retrieveByPK($this->getRequestParameter('id'));
  }

  
  public function executeGetMessageById()
  {
      $this->message = MessagePeer::retrieveByPK($this->getRequestParameter('id'));
      if( $this->getRequestParameter('details'))
      {
          $msg = clone $this->message;
          $msg->setIsReviewed(true);
          $msg->save();
      }
  }
  
  public function executeGetMemberFlagsFlagged()
  {
      $c = new Criteria();
      $c->add(FlagPeer::MEMBER_ID, $this->getRequestParameter('id'));
      $c->add(FlagPeer::IS_HISTORY, (bool) $this->getRequestParameter('history'));
      $c->addDescendingOrderByColumn(FlagPeer::CREATED_AT);
      
      $this->flags = FlagPeer::doSelectJoinAllFlagger($c);
  }
  
  public function executeGetMemberFlagsFlagger()
  {
      $c = new Criteria();
      $c->add(FlagPeer::FLAGGER_ID, $this->getRequestParameter('id'));
      $c->add(FlagPeer::IS_HISTORY, (bool) $this->getRequestParameter('history'));
      $c->addDescendingOrderByColumn(FlagPeer::CREATED_AT);
      
      $this->flags = FlagPeer::doSelectJoinAllFlagged($c);
  }
  
  public function executeUpdatePublicSearch()
  {
      $member = MemberPeer::retrieveByPK($this->getRequestParameter('member_id'));
      if( $member && !$member->getPrivateDating())
      {
          $member->setPublicSearch(!$member->getPublicSearch());
          $member->save();
      }
      
      return sfView::NONE;
  }
  
  public function executeUpdateEmailRecipients()
  {
      $member = MemberPeer::retrieveByPK($this->getRequestParameter('member_id'));
      $marked = array($this->getRequestParameter('member_id') => $member->getUsername());
      if( $marked )
      {
            if(in_array($member->getUsername(),$this->getUser()->getAttributeHolder()->getAll('backend/feedback/selectedMembers')))
            {
                $temp_array = Array();
                $temp_array = $this->getUser()->getAttributeHolder()->getAll('backend/feedback/selectedMembers');
                unset($temp_array[$this->getRequestParameter('member_id')]);
                $this->getUser()->getAttributeHolder()->removeNamespace('backend/feedback/selectedMembers');
                $this->getUser()->getAttributeHolder()->add($temp_array, 'backend/feedback/selectedMembers');
                
            }
            else
            {
                $this->getUser()->getAttributeHolder()->add($marked, 'backend/feedback/selectedMembers');
            }
      }
      
      return sfView::NONE;  
  }
  
    public function executeGetDSG()
    {
        $countries = ($this->getRequestParameter('country')) ? explode(',', $this->getRequestParameter('country')) : array();
        $adm1s = ($this->getRequestParameter('adm1')) ? explode(',', $this->getRequestParameter('adm1')) : array();
        $adm2s = ($this->getRequestParameter('adm2')) ? explode(',', $this->getRequestParameter('adm2')) : array();
        
        $dsgs = GeoPeer::getDSG($countries, $adm1s, $adm2s);
        
        $output = json_encode(array_values($dsgs));
        return $this->renderText($output);
    }  

    public function executeGetUsersByIp()
    {
        $c = new Criteria();
        $c->add(MemberPeer::ID, MemberPeer::ID. ' IN ( SELECT DISTINCT t.MEMBER_ID'. 
                                ' FROM (SELECT '. MemberLoginHistoryPeer::MEMBER_ID. ' FROM ' .MemberLoginHistoryPeer::TABLE_NAME.                                 
                                          ' WHERE '. MemberLoginHistoryPeer::IP. ' = '. $this->getRequestParameter('ip') .
                                        ') t )', 
                  Criteria::CUSTOM);
                                                                              
        $this->users = MemberPeer::doSelect($c);
        $this->ip = $this->getRequestParameter('ip'); 
    }  
}
