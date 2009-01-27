<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 27, 2009 4:12:40 PM
 * 
 */
 
class staticPagesComponents extends sfComponents
{
     public function executeBestVideos()
     {
         $c = new Criteria();
         $c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);
         $c->addAscendingOrderByColumn(MemberCounterPeer::PROFILE_VIEWS);
         $c->add(MemberPeer::YOUTUBE_VID, null, Criteria::ISNOTNULL);
         $c->setLimit(3);
         
         $this->members = MemberPeer::doSelect($c);
     }
}
