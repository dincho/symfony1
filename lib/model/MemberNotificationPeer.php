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
    const VISIT = 1;


  //visitor is actually current sfUser
  public static function addNotification(BaseMember $member, BaseMember $visitor, $notification_type)
  {
    $notification = new MemberNotification();
    $notification->setMemberId($member->getId());
    $notification->setProfileId($visitor->getId());
    $notification->setType($notification_type);
    $notification->save();
  }


  public static function getNotificationMessage($notification)
  {
    switch ($notification->getType() )
    {
      case MemberNotificationPeer::VISIT:
        $member = $notification->getMemberRelatedByProfileId(); 
        $con = sfContext::getInstance()->getController();
        $messsage =  __('Visitor %USERNAME% just opened your profile!', array('%USERNAME%' => $member->getUsername(), 
                                                                      '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $member->getUsername())));
        break;
      
    }
//  sfContext::getInstance()->getLogger()->info('MemberNotificationPeer::getNotification' . $messsage);
     return $messsage;
  }

}
