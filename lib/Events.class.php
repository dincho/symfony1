<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Sep 16, 2008 3:57:38 PM
 * 
 */
class Events
{
    //registration events
    const JOIN = 1;
    const WELCOME = 12;
    const WELCOME_APPROVED = 8;
    
    //email & password events
    const FORGOT_PASSWORD = 2;
    const NEW_PASSWORD_CONFIRM = 3;
    const NEW_EMAIL_CONFIRM = 4;
    const NEW_EMAIL_CONFIRMED = 5; //when email confirmation is done, and email is changed.
    
    //member events - send to admins
    const ACCOUNT_DELETE_BY_MEMBER = 6;
    const ACCOUNT_DEACTIVATION = 13;
    const AUTO_RENEW = 14;
    const FIRST_CONTACT = 15;
    const SPAM_ACTIVITY = 16;
    const SCAM_ACTIVITY = 17;
    const ABANDONED_REGISTRATION = 18;
    
    //others
    const TELL_FRIEND = 7;
    const GIFT_RECEIVED = 23;

    
    //reminders - crons
    const REGISTRATION_REMINDER = 9;
    const LOGIN_REMINDER = 10;
    const ACCOUNT_ACTIVITY = 11;
    const ACCOUNT_ACTIVITY_MESSAGE = 19;
    const ACCOUNT_ACTIVITY_SYSTEM_MESSAGE = 25;
    const ACCOUNT_ACTIVITY_WINK = 20;
    const ACCOUNT_ACTIVITY_HOTLIST = 21;
    const ACCOUNT_ACTIVITY_VISITOR = 22;
    const ACCOUNT_ACTIVITY_RATE = 26;
    const ACCOUNT_ACTIVITY_MUTUAL_RATE = 27;
    const ACCOUNT_ACTIVITY_PRIVATE_PHOTOS_GRANTED = 28;
    const ACCOUNT_ACTIVITY_PRIVATE_PHOTOS_REQUEST = 29;
    const EOT = 24;
    
    /* REGISTRATION EVENTS */
    public static function triggerJoin($member)
    {
        //sfLoader::loadHelpers(array('Tag', 'Url'));
        $hash = sha1(SALT . $member->getUsername() . SALT);
        
        $activation_url = LinkPeer::create('registration/activate?username=' . $member->getUsername() . '&hash=' . $hash)->getUrl($member->getCatalogue());
        
        $global_vars = array('{ACTIVATION_URL}' => $activation_url, '{REGISTRATION_IP}' => long2ip($member->getRegistrationIp()));
        
        return self::executeNotifications(self::JOIN, $global_vars, $member->getEmail(), $member);
    }

    public static function triggerWelcome($member, $ip = 'UNKNOWN_IP_ADDRESS')
    {
        sfLoader::loadHelpers(array('Tag', 'Url'));
        $global_vars = array('{LOGIN_URL}' => url_for('@signin', array('absolute' => true)),
                             '{PROFILE_URL}' => url_for('@profile?username=' . $member->getUsername(), array('absolute' => true)),
                             '{IP}' => $ip,
                            );
        
        return self::executeNotifications(self::WELCOME, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerWelcomeApproved($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $login_url  = LinkPeer::create('@signin')->getUrl($member->getCatalogue());
        $dashboard_url  = LinkPeer::create('@dashboard', $member->getId())->getUrl($member->getCatalogue());
        
        $global_vars = array('{LOGIN_URL}' => $login_url,
                            '{INSTANT_LOGIN_URL}' => $dashboard_url, 
                            );
        return self::executeNotifications(self::WELCOME_APPROVED, $global_vars, $member->getEmail(), $member);
    }

    /* EMAIL & PASSOWRD EVENTS */
    public static function triggerForgotPassword($member)
    {   
        $confirmation_url  = LinkPeer::create('@forgotten_password_confirm?username='. $member->getUsername(), $member->getId())->getUrl($member->getCatalogue());
        $global_vars = array('{CONFIRMATION_URL}' => $confirmation_url);
        
        return self::executeNotifications(self::FORGOT_PASSWORD, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerNewPasswordConfirm($member)
    {
        $confirmation_url  = LinkPeer::create('@confirm_new_password?username=' . $member->getUsername() . '&hash=' . $member->getNewPassword(), $member->getId())->getUrl($member->getCatalogue());
        $global_vars = array('{CONFIRMATION_URL}' => $confirmation_url);
        
        return self::executeNotifications(self::NEW_PASSWORD_CONFIRM, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerNewEmailConfirm($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $confirmation_url = LinkPeer::create('@confirm_new_email?username=' . $member->getUsername() . '&hash=' . sha1(SALT . $member->getTmpEmail() . SALT ), $member->getId())->getUrl($member->getCatalogue());
        $global_vars = array('{CONFIRMATION_URL}' => $confirmation_url);
        
        return self::executeNotifications(self::NEW_EMAIL_CONFIRM, $global_vars, $member->getTmpEmail(), $member);
    }
    
    public static function triggerNewEmailConfirmed($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $undo_url = url_for('@undo_new_email?username=' . $member->getUsername() . '&hash=' . sha1(SALT . $member->getEmail() . SALT . $member->getTmpEmail() . SALT ), array('absolute' => true));
        $global_vars = array('{UNDO_URL}' => $undo_url);
        
        //send to the old email, which is in the temp field
        return self::executeNotifications(self::NEW_EMAIL_CONFIRMED, $global_vars, $member->getTmpEmail(), $member);
    }
    
    /* MEMBER EVENTS */
    public static function triggerAccountDeleteByMember($member, $reason = null)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)), '{REASON}' => $reason);
        
        return self::executeNotifications(self::ACCOUNT_DELETE_BY_MEMBER, $global_vars, null, $member);     
    }
    
    public static function triggerAccountDeactivation($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)));
        
        return self::executeNotifications(self::ACCOUNT_DEACTIVATION, $global_vars, null, $member);     
    }
    
    public static function triggerAutoRenew($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)),
                             '{EOT_DATE}' => date('M d, Y', $member->getCurrentMemberSubscription()->getExtendedEOT(null)),
                            );
        
        return self::executeNotifications(self::AUTO_RENEW, $global_vars, null, $member);     
    }
    
    public static function triggerScamActivity($member, $nb_flags)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)),
                             '{NB_FLAGS}' =>  $nb_flags,
                            );
        
        return self::executeNotifications(self::SCAM_ACTIVITY, $global_vars, null, $member);     
    }
    
    public static function triggerSpamActivity($member, $nb_messages)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)),
                             '{NB_MESSAGES}' => $nb_messages,
                            );
        
        return self::executeNotifications(self::SPAM_ACTIVITY, $global_vars, null, $member);     
    }
    
    public static function triggerAbandonedRegistration($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $dashboard_url  = LinkPeer::create('@dashboard', $member->getId())->getUrl($member->getCatalogue());
        $global_vars = array('{PROFILE_URL}' => $dashboard_url);
        
        return self::executeNotifications(self::ABANDONED_REGISTRATION, $global_vars, null, $member);
    }
    
    public static function triggerFirstContact(BaseMessage $message)
    {
        $sender = $message->getMemberRelatedBySenderId();
        if( $sender->getCounter('SentMessages') == 0 )
        {
            sfLoader::loadHelpers(array('Url'));
            $recipient = $message->getMemberRelatedByRecipientId();
            
            $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $sender->getUsername(), array('absolute' => true)),
                                 '{TO_PROFILE_URL}' => url_for('profile/index?username=' . $recipient->getUsername(), array('absolute' => true)),
                                 '{TO_FIRST_NAME}' => $recipient->getFirstName(),
                                 '{TO_LAST_NAME}' => $recipient->getLastName(),
                                 '{TO_USERNAME}' => $recipient->getUsername(),
                                 '{SUBJECT}' => $message->getThread()->getSubject(),
                                 '{MESSAGE}' => $message->getBody(),
                                );
            
            return self::executeNotifications(self::FIRST_CONTACT, $global_vars, null, $sender);
        }
    }
    
    /* OTHER EVENTS */
    public static function triggerTellFriend($name, $email, $friend_name, $friend_email, $comments = null)
    {
        
        $global_vars = array('{FRIEND_NAME}' => $friend_name, '{NAME}' => $name, '{EMAIL}' => $email, '{COMMENTS}' => $comments);
        return self::executeNotifications(self::TELL_FRIEND, $global_vars, $friend_email, null, $email);
    }
    
    public static function triggerGiftReceived(BaseMember $recipient, BaseMember $sender)
    {
        $profile_url  = LinkPeer::create('@profile?username=' . $sender->getUsername(), $recipient->getId())->getUrl($recipient->getCatalogue());
        
        $global_vars = array('{SENDER_PROFILE_URL}' => $profile_url,
                             '{SENDER_USERNAME}' => $sender->getUsername(),
                            );
                                    
        return self::executeNotifications(self::GIFT_RECEIVED, $global_vars, $recipient->getEmail(), $recipient);
    }

    
    /* REMINDERS */
    public static function triggerRegistrationReminder($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $login_url  = LinkPeer::create('@signin')->getUrl($member->getCatalogue());
        $dashboard_url  = LinkPeer::create('@dashboard', $member->getId())->getUrl($member->getCatalogue());
        
        $global_vars = array('{LOGIN_URL}' => $login_url,
                            '{INSTANT_LOGIN_URL}' => $dashboard_url,
                            );
        return self::executeNotifications(self::REGISTRATION_REMINDER, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerLoginReminder($member, $deactivationDays)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $login_url  = LinkPeer::create('@signin')->getUrl($member->getCatalogue());
        $dashboard_url  = LinkPeer::create('@dashboard', $member->getId())->getUrl($member->getCatalogue());
        
        $global_vars = array('{LOGIN_URL}' => $login_url, 
                             '{DEACTIVATION_DAYS}' => $deactivationDays,
                             '{INSTANT_LOGIN_URL}' => $dashboard_url,
                             );
        return self::executeNotifications(self::LOGIN_REMINDER, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerAccountActivity($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $nb_unread = $member->getUnreadMessagesCount();
        $nb_winks = MemberCounterPeer::getNbNewWinks($member->getId());
        $nb_hotlist = MemberCounterPeer::getNbNewOnOtherHotlist($member->getId());
        $nb_profile_view = MemberCounterPeer::getNbNewProfileViews($member->getId());
        
        $login_url  = LinkPeer::create('@signin')->getUrl($member->getCatalogue());
        $messages_url = LinkPeer::create('messages/index', $member->getId())->getUrl($member->getCatalogue());
        $winks_url = LinkPeer::create('winks/index', $member->getId())->getUrl($member->getCatalogue());
        $hotlist_url = LinkPeer::create('hotlist/index', $member->getId())->getUrl($member->getCatalogue());
        $profile_viewes_url = LinkPeer::create('dashboard/visitors', $member->getId())->getUrl($member->getCatalogue());

        $global_vars = array('{LOGIN_URL}' => $login_url,
                             '{NB_MESSAGES}' => $nb_unread,
                             '{URL_TO_MESSAGES}' => $messages_url,
                             '{NB_WINKS}' => $nb_winks,
                             '{URL_TO_WINKS}' => $winks_url,
                             '{NB_HOTLIST}' => $nb_hotlist,
                             '{URL_TO_HOTLIST}' => $hotlist_url,
                             '{NB_PROFILE_VIEWES}' => $nb_profile_view,
                             '{URL_TO_PROFILE_VIEWES}' => $profile_viewes_url,
                            );
                            
        $ret = self::executeNotifications(self::ACCOUNT_ACTIVITY, $global_vars, $member->getEmail(), $member);
        
        $member->setLastActivityNotification(time());
        $member->save();
        
        return $ret;
    }
    
    public static function triggerAccountActivityMessage($recipient, $sender, $message)
    {
        $profile_url  = LinkPeer::create('@profile?username=' . $sender->getUsername(), $recipient->getId())->getUrl($recipient->getCatalogue());
        $messages_url = LinkPeer::create('messages/index', $recipient->getId())->getUrl($recipient->getCatalogue());
        $message_url  = LinkPeer::create('messages/thread?return_to_profile=1&id=' . $message->getThreadId(), $recipient->getId())->getUrl($recipient->getCatalogue());
        $message_snippet = Tools::truncate($message->getBody(), 12);
        
        $global_vars = array('{SENDER_PROFILE_URL}' => $profile_url,
                             '{SENDER_USERNAME}' => $sender->getUsername(),
                             '{URL_TO_MESSAGES}' => $messages_url,
                             '{URL_TO_MESSAGE}' => $message_url,
                             '{MESSAGE_SNIPPET}' => $message_snippet,
                            );
        
        
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_MESSAGE, $global_vars, $recipient->getEmail(), $recipient);
    }
    
    public static function triggerAccountActivitySystemMessage($recipient, $message)
    {

        $messages_url = LinkPeer::create('messages/index', $recipient->getId())->getUrl($recipient->getCatalogue());
        $message_url  = LinkPeer::create('messages/thread?id=' . $message->getThreadId())->getUrl($recipient->getCatalogue());

        
        $global_vars = array('{URL_TO_MESSAGES}' => $messages_url,
                             '{URL_TO_MESSAGE}' => $message_url,
                             '{MESSAGE}' => $message->getBody(),
                            );
        
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_SYSTEM_MESSAGE, $global_vars, $recipient->getEmail(), $recipient);
    }    
    
    public static function triggerAccountActivityWink(BaseMember $member, BaseMember $from_member)
    {
        $profile_url = LinkPeer::create('@profile?username=' . $from_member->getUsername(), $member->getId())->getUrl($member->getCatalogue());
        $global_vars = array('{SENDER_PROFILE_URL}' => $profile_url,
                             '{SENDER_USERNAME}' => $from_member->getUsername(),
                            );
                            
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_WINK, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerAccountActivityHotlist(BaseMember $member, BaseMember $from_member)
    {
        $profile_url = LinkPeer::create('@profile?username=' . $from_member->getUsername(), $member->getId())->getUrl($member->getCatalogue());
        $global_vars = array('{SENDER_PROFILE_URL}' => $profile_url,
                             '{SENDER_USERNAME}' => $from_member->getUsername(),
                            );
                            
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_HOTLIST, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerAccountActivityVisitor(BaseMember $member, BaseMember $visitor)
    {
        $profile_url = LinkPeer::create('@profile?username=' . $visitor->getUsername(), $member->getId())->getUrl($member->getCatalogue());
        $global_vars = array('{VISITOR_PROFILE_URL}' => $profile_url,
                             '{VISITOR_USERNAME}' => $visitor->getUsername(),
                            );
                            
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_VISITOR, $global_vars, $member->getEmail(), $member);
    }


    public static function triggerAccountActivityRate(BaseMember $recipient, BaseMember $sender)
    {
        $profile_url  = LinkPeer::create('@profile?username=' . $sender->getUsername(), $recipient->getId())->getUrl($recipient->getCatalogue());
        
        $global_vars = array('{RATER_PROFILE_URL}' => $profile_url,
                             '{RATER_USERNAME}' => $sender->getUsername(),
                            );
                                    
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_RATE, $global_vars, $recipient->getEmail(), $recipient);
    }
    
    public static function triggerAccountActivityMutualRate(BaseMember $recipient, BaseMember $sender)
    {
        $profile_url  = LinkPeer::create('@profile?username=' . $sender->getUsername(), $recipient->getId())->getUrl($recipient->getCatalogue());
        
        $global_vars = array('{RATER_PROFILE_URL}' => $profile_url,
                             '{RATER_USERNAME}' => $sender->getUsername(),
                            );
                                    
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_MUTUAL_RATE, $global_vars, $recipient->getEmail(), $recipient);
    }
    
    public static function triggerAccountActivityPrivatePhotosGranted(BaseMember $grantee, BaseMember $granter)
    {
        $profile_url  = LinkPeer::create('@profile?username=' . $granter->getUsername(), $grantee->getId())->getUrl($grantee->getCatalogue());
        
        $global_vars = array('{GRANTER_PROFILE_URL}' => $profile_url,
                             '{GRANTER_USERNAME}' => $granter->getUsername(),
                            );
                                    
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_PRIVATE_PHOTOS_GRANTED, $global_vars, $grantee->getEmail(), $grantee);
    }    

    public static function triggerAccountActivityPrivatePhotosRequest(BaseMember $request_to, BaseMember $request_from)
    {
        $profile_url  = LinkPeer::create('@profile?username=' . $request_from->getUsername(), $request_to->getId())->getUrl($request_to->getCatalogue());
        
        $global_vars = array('{REQUEST_FROM_PROFILE_URL}' => $profile_url,
                             '{REQUEST_FROM_USERNAME}' => $request_from->getUsername(),
                            );
                                    
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_PRIVATE_PHOTOS_REQUEST, $global_vars, $request_to->getEmail(), $request_to);
    }    

    
    public static function triggerEOT(BaseMemberSubscription $subscription)
    {
        sfLoader::loadHelpers(array('Date'));
        
        $member = $subscription->getMember();
        $date_format = ( $member->getCulture() == 'pl' ) ? 'dd MMM yyyy' : 'MMM dd, yyyy';
        
        $global_vars = array('{EOT_DATE}' => format_date($subscription->getExtendedEOT(), $date_format));
        
        return self::executeNotifications(self::EOT, $global_vars, $member->getEmail(), $member);
    }
    
    
    /**
     * Sends emails to attached notifications for selected event
     *
     * @param integer $event
     * @param array $global_vars
     * @param string $addresses
     * @param object $object
     * @param string $mail_from
     */
    protected static function executeNotifications($event = -1, $global_vars = array(), $addresses = null, $object = null, $mail_from = null)
    {
        if ( !is_null($object) && $object instanceof Member )
        {
            $catalog = $object->getCatalogue();
            $notifications_url = LinkPeer::create('dashboard/emailNotifications', $object->getId())->getUrl($catalog);
            $global_vars['{NOTIFICATIONS_URL}'] = $notifications_url;
        } else {
            //try to get catalog from user's sessions
            $catalog = sfContext::getInstance()->getUser()->getCatalog();
            if( !$catalog ) $catalog = CataloguePeer::retrieveByPK(1); //polishdate.com - english
        }
        
        $c = new Criteria();
        $c->add(NotificationEventPeer::EVENT, $event);
        $c->addJoin(NotificationPeer::ID, NotificationEventPeer::NOTIFICATION_ID);
        $c->add(NotificationPeer::IS_ACTIVE, true);
        $c->add(NotificationPeer::CAT_ID, $catalog->getCatId());
        $notifications = NotificationPeer::doSelect($c);

        $ret = true;
        foreach ($notifications as $notification) 
        {
          // if( $notification->getToAdmins() ) $notification->setCulture('en'); //force admin notifications to English
          $notification_ret = $notification->execute($global_vars, $addresses, $object, $mail_from, $catalog);
          
          if( !$notification_ret ) $ret = false;
        }
        
        return $ret;
    }
}
