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
    const MESSAGE = 2;

    //profile is actually current sfUser
    public static function addNotification(
        BaseMember $member,
        BaseMember $profile,
        $notification_type,
        $subject_id = null
    ) {
        $notification = new MemberNotification();
        $notification->setMemberId($member->getId());
        $notification->setProfileId($profile->getId());
        $notification->setType($notification_type);
        $notification->setSubjectId($subject_id);
        $notification->save();
    }

    public static function getNotificationMessage($notification)
    {
        $member = $notification->getMemberRelatedByProfileId();
        $con = sfContext::getInstance()->getController();
        
        switch ($notification->getType()) {
            case MemberNotificationPeer::VISIT:
                $message =  __(
                    'Visitor %USERNAME% just opened your profile!',
                    array(
                        '%USERNAME%' => $member->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $member->getUsername())
                        )
                );
            break;
            case MemberNotificationPeer::MESSAGE:
                $message =  __(
                    'Visitor %USERNAME% has send you a <a href="%THREAD_URL%" class="sec_link">message</a>!',
                    array(
                        '%USERNAME%' => $member->getUsername(),
                        '%THREAD_URL%' => $con->genUrl('messages/thread?mailbox=inbox&id='. $notification->getSubjectId())
                    )
                );
            break;
      }

      return $message;
  }
}
