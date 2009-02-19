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
         /*$c = new Criteria();
         $c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);
         $c->addDescendingOrderByColumn(MemberCounterPeer::PROFILE_VIEWS);
         $c->add(MemberPeer::YOUTUBE_VID, null, Criteria::ISNOTNULL);
         $c->setLimit(3);
         
         $this->members = MemberPeer::doSelect($c);*/
         
         $lastm = new DateTime($this->get_last_month());
         $lastmonth = $lastm->format("Y-m");
         $lastmonth = $lastmonth."%";
         
         $c = new Criteria();
         $c->addJoin(MemberPeer::ID, ProfileViewPeer::PROFILE_ID);
         $c->add(MemberPeer::YOUTUBE_VID, null, Criteria::ISNOTNULL);
         $criteria = $c->getNewCriterion(ProfileViewPeer::CREATED_AT, $lastmonth, Criteria::LIKE);
         $c->addAnd($criteria);
         $c->addGroupByColumn(ProfileViewPeer::PROFILE_ID);
         $c->setLimit(3);
         
         $this->members = MemberPeer::doSelect($c);
     }
     
     public static function get_last_month() 
     {
        return (date('m') == 1)?
        join('-', array(date('Y')-1, '12')) :
        join('-', array(date('Y'), date('m')-1)) ;
     }
}
