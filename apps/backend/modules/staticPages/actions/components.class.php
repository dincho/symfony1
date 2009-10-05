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
    $lastm = new DateTime($this->get_last_month());
    $lastmonth = $lastm->format("Y-m");
    $lastmonth = $lastmonth."%";

    $c = new Criteria();
    $c->addJoin(MemberPeer::ID, ProfileViewPeer::PROFILE_ID);
    $crit = $c->getNewCriterion(MemberPeer::YOUTUBE_VID, NULL, Criteria::ISNOTNULL);
    $crit->addAnd($c->getNewCriterion(MemberPeer::YOUTUBE_VID, '', Criteria::NOT_EQUAL));
    $c->add($crit);
    $criteria = $c->getNewCriterion(ProfileViewPeer::CREATED_AT, $lastmonth, Criteria::LIKE);
    $c->addAnd($criteria);
    $c->addGroupByColumn(ProfileViewPeer::PROFILE_ID);
    $c->addDescendingOrderByColumn('COUNT(profile_view.profile_id)');
    $c->setLimit(3);

    $members = MemberPeer::doSelect($c);
    if( count($members) > 0 )
    {
      $cc = new Criteria();
      $cc->add(BestvTmplI18nPeer::CULTURE, $this->culture);
      $template = BestvTmplI18nPeer::doSelectOne($cc);

      $content = str_replace('{WINNER}', ($members[0]->getFirstName() ." ". $members[0]->getLastName()), $template->getHeader());
      $i=1;
      foreach ($members as $member)
      {
        $tmpl_name=array('{FULL_NAME}', '{USERNAME}', '{YOUTUBE}', '{N}');
        $source_name=array(($member->getFirstName() ." ". $member->getLastName()), $member->getUsername(), $member->getYoutubeVid(), $i);
        $content .= str_replace($tmpl_name, $source_name, $template->getBodyWinner());

        $i++;
      }
      $content .= $template->getFooter();
    } else {
      $content = "!!!NOT ENOUGH DATA TO GENERATE RESULTS!!!";
    }

    $this->content = $content;
  }
     
  public static function get_last_month() 
  {
    return (date('m') == 1)?
    join('-', array(date('Y')-1, '12')) :
    join('-', array(date('Y'), date('m')-1)) ;
  }
}
