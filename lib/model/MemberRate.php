<?php

/**
 * Subclass for representing a row from the 'member_rate' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberRate extends BaseMemberRate
{

  // Update "rate" field in "member" table everytime there is update in "members_rate" table
  public function save($con = null)
  {

    $return = parent::save($con);

    $member = MemberPeer::retrieveByPk($this->getMemberId());

    $c = new Criteria();
    $c->add(MemberRatePeer::MEMBER_ID,$this->getMemberId());
    
    $memberRates = MemberRatePeer::doSelect($c);

    $rate = 0;
    foreach($memberRates as $memberRate){

      $rate += $memberRate->getRate();
    }

    $rate = round($rate / count($memberRates));

    $member->setRate($rate);
    $member->save();

    return($return);
  }
}
