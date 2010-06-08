<?php

/**
 * Subclass for performing query and update operations on the 'member_notification' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberNotificationPeer extends BaseMemberNotificationPeer
{
  //visitor is actually current sfUser
  public static function addVisit(BaseMember $member, BaseMember $visitor)
  {
    $con = sfContext::getInstance()->getController();
    $i18n = sfI18N::getInstance();
    
    //i18n setCulture makes extra queries, so let's be resource saving
    if($member->getCulture() != $visitor->getCulture()) $i18n->setCulture($member->getCulture());
    
    $title = $i18n->__('Visitor %USERNAME% just opened your profile!', array('%USERNAME%' => $visitor->getUsername(), 
                                                                      '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $visitor->getUsername())));
                                                              
    $notification = new MemberNotification();
    $notification->setMemberId($member->getId());
    $notification->setTitle($title);
    $notification->save();
    
    if($member->getCulture() != $visitor->getCulture()) $i18n->setCulture($visitor->getCulture());
  }
}
