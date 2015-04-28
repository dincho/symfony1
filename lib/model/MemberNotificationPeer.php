<?php

class MemberNotificationPeer
{
    const VISIT = 1;
    const MESSAGE = 2;
    const WINK = 3;
    const HOTLIST = 4;
    const RATE = 5;
    const MUTUAL_RATE = 6;
    const LOGIN = 7;

    public static function send(BaseMember $member, BaseMember $actor, $type, $subjectId = null)
    {
        $note = self::getNote($actor, $type, $subjectId);

        return self::triggerPusher(array('private-notifications-' . $member->getId()), $note);
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
        if (0 == count($members)) {
            return;
        }

        $note = self::getNote($profile, self::LOGIN);

        $channels = array();
        foreach ($members as $member) {
            $channels[] = 'private-notifications-' . $member->getId();
        }

        return self::triggerPusher($channels, $note);
    }

    private static function getNote(BaseMember $profile, $type, $subjectId = null)
    {
        $con = sfContext::getInstance()->getController();
        sfLoader::loadHelpers(array('Asset', 'Tag', 'Url'));
        $thumbImg = image_tag($profile->getMainPhoto()->getImg('30x30'), array('class' => 'thumb_teaser'));
        $profileLink = link_to($thumbImg, '@profile?username=' . $profile->getUsername());

        switch ($type) {
            case self::VISIT:
                $message =  __(
                    'Visitor %USERNAME% just opened your profile!',
                    array(
                        '%USERNAME%' => $profile->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $profile->getUsername())
                        )
                );
            break;
            case self::MESSAGE:
                $message =  __(
                    'Visitor %USERNAME% has send you a <a href="%THREAD_URL%" class="sec_link">message</a>!',
                    array(
                        '%USERNAME%' => $profile->getUsername(),
                        '%THREAD_URL%' => $con->genUrl('messages/thread?mailbox=inbox&id='. $subjectId)
                    )
                );
            break;
            case self::WINK:
                $message =  __(
                    '%USERNAME% just winked at you! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $profile->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $profile->getUsername())
                        )
                );
            break;
            case self::HOTLIST:
                $message =  __(
                    '%USERNAME% just added you to hotlist! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $profile->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $profile->getUsername())
                        )
                );
            break;
            case self::RATE:
                $message =  __(
                    '%USERNAME% just gave you 5 stars! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $profile->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $profile->getUsername())
                        )
                );
            break;
            case self::MUTUAL_RATE:
                $message =  __(
                    '%USERNAME% and you like each other! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $profile->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $profile->getUsername())
                        )
                );
            break;
            case self::LOGIN:
                $message =  __(
                    '%USERNAME% just logged in! Check %USERNAME% out',
                    array(
                        '%USERNAME%' => $profile->getUsername(),
                        '%PROFILE_URL%' => $con->genUrl('@profile?username=' . $profile->getUsername())
                        )
                );
            break;
        }

        return $profileLink . $message;
    }

    private static function triggerPusher($channels, $data)
    {
        $pusher = new Pusher(
            sfConfig::get('app_pusher_key'),
            sfConfig::get('app_pusher_secret'),
            sfConfig::get('app_pusher_app_id')
        );

        return $pusher->trigger($channels, 'notification', $data);
    }
}
