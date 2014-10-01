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
    const WINK = 3;
    const HOTLIST = 4;
    const RATE = 5;
    const MUTUAL_RATE = 6;
    const LOGIN = 7;

    //profile is actually current sfUser
    public static function addNotification(
        BaseMember $member,
        BaseMember $profile,
        $notification_type,
        $subject_id = null
    ) {
        $c = new Criteria();
        $c->add(MemberNotificationPeer::MEMBER_ID, $member->getId());
        $c->add(MemberNotificationPeer::PROFILE_ID, $profile->getId());
        $c->add(MemberNotificationPeer::TYPE, $notification_type);
        $c->add(MemberNotificationPeer::SENT_AT, null, Criteria::ISNULL);
        $c->add(MemberNotificationPeer::CREATED_AT, time()-60, Criteria::GREATER_THAN);

        //add only unique (not sent and last minute) notifications to prevent flooding
        if (MemberNotificationPeer::doCount($c) > 0) {
            return;
        }

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
            case self::VISIT:
                $message =  __(
                    'Visitor %USERNAME% just opened your profile!',
                    array(
                        '%USERNAME%' => $member->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $member->getUsername())
                        )
                );
            break;
            case self::MESSAGE:
                $message =  __(
                    'Visitor %USERNAME% has send you a <a href="%THREAD_URL%" class="sec_link">message</a>!',
                    array(
                        '%USERNAME%' => $member->getUsername(),
                        '%THREAD_URL%' => $con->genUrl('messages/thread?mailbox=inbox&id='. $notification->getSubjectId())
                    )
                );
            break;
            case self::WINK:
                $message =  __(
                    '%USERNAME% just winked at you! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $member->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $member->getUsername())
                        )
                );
            break;
            case self::HOTLIST:
                $message =  __(
                    '%USERNAME% just added you to hotlist! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $member->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $member->getUsername())
                        )
                );
            break;
            case self::RATE:
                $message =  __(
                    '%USERNAME% just gave you 5 stars! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $member->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $member->getUsername())
                        )
                );
            break;
            case self::MUTUAL_RATE:
                $message =  __(
                    '%USERNAME% and you like each other! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $member->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $member->getUsername())
                        )
                );
            break;
            case self::LOGIN:
                $message =  __(
                    '%USERNAME% just logged in! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $member->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $member->getUsername())
                        )
                );
            break;
        }

        return $message;
    }

    public static function sendLoginNotifications(BaseMember $profile)
    {
        $hotlistMemberIds = HotlistPeer::getMembersForLoginNotification($profile);
        $raterIds = MemberRatePeer::getRatersForLoginNotification($profile);
        $interlocutorIds = MessagePeer::getRecentInterlocutors($profile->getId());

        $memberIds = array_unique(array_merge(
            $hotlistMemberIds,
            $raterIds,
            $interlocutorIds
        ));

        $members = MemberPeer::getMembersForLoginNotification($profile, $memberIds);
        foreach ($members as $member) {
            self::addNotification($member, $profile, self::LOGIN);
        }
    }
}
