<?php

/**
 * dashboard actions.
 *
 * @package    pr
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class dashboardActions extends sfActions
{
  public function executeIndex()
  {
      $c = new Criteria();
      $c->add(SessionStoragePeer::USER_ID, NULL, Criteria::ISNOTNULL);
      $c->addJoin(SessionStoragePeer::USER_ID, MemberPeer::ID);
      $c->add(MemberPeer::SEX, 'M');
      
      $this->males_online = SessionStoragePeer::doCount($c);
      
      $c1 = clone $c;
      $c1->add(MemberPeer::SEX, 'F');
      $this->females_online = SessionStoragePeer::doCount($c1);
  }
}
