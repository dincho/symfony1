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
    
    if ($con === null) {
       $con = Propel::getConnection(MemberRatePeer::DATABASE_NAME);
    }
          
    try {
      $con->begin();
      
      $return = parent::save($con);

      $c = new Criteria();
      $c->add(MemberRatePeer::MEMBER_ID, $this->getMemberId());
      $c->clearSelectColumns()->addSelectColumn('AVG(' . MemberRatePeer::RATE . ')');
      $rs = MemberRatePeer::doSelectRS($c, $con);
      $rs->next();
      $rate = $rs->getInt(1);
    
      $member = $this->getMemberRelatedByMemberId();
      $member->setRate($rate);
      $member->save($con);
      
      $con->commit();
      
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }    
    
    return $return;
  }
}
