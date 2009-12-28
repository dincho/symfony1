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
    
    //reminders - crons
    const REGISTRATION_REMINDER = 9;
    const LOGIN_REMINDER = 10;
    const ACCOUNT_ACTIVITY = 11;
    const ACCOUNT_ACTIVITY_MESSAGE = 19;
    const ACCOUNT_ACTIVITY_WINK = 20;
    const ACCOUNT_ACTIVITY_HOTLIST = 21;
    const ACCOUNT_ACTIVITY_VISITOR = 22;
    
    /* REGISTRATION EVENTS */
    public static function triggerJoin($member)
    {
        //sfLoader::loadHelpers(array('Tag', 'Url'));
        $hash = sha1(SALT . $member->getUsername() . SALT);
        
        $activation_url = LinkPeer::create('registration/activate?username=' . $member->getUsername() . '&hash=' . $hash)->getUrl($member->getCulture());
        
        $global_vars = array('{ACTIVATION_URL}' => $activation_url);
        
        return self::executeNotifications(self::JOIN, $global_vars, $member->getEmail(), $member);
    }

    public static function triggerWelcome($member)
    {
        sfLoader::loadHelpers(array('Tag', 'Url'));
        $global_vars = array('{LOGIN_URL}' => url_for('@signin', array('absolute' => true)),
                             '{PROFILE_URL}' => url_for('@profile?username=' . $member->getUsername(), array('absolute' => true)),
                             '{IP}' => $_SERVER['REMOTE_ADDR'],
                            );
        
        return self::executeNotifications(self::WELCOME, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerWelcomeApproved($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{LOGIN_URL}' => url_for(BASE_URL . 'signin', array('absolute' => true)));
        return self::executeNotifications(self::WELCOME_APPROVED, $global_vars, $member->getEmail(), $member);
    }

    /* EMAIL & PASSOWRD EVENTS */
    public static function triggerForgotPassword($member)
    {
        sfLoader::loadHelpers(array('Url'));
        $global_vars = array('{CONFIRMATION_URL}' => url_for('@forgotten_password_confirm?username='. $member->getUsername() .'&hash=' . sha1(SALT . $member->getNewPassword() . SALT), array('absolute' => true)));
        return self::executeNotifications(self::FORGOT_PASSWORD, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerNewPasswordConfirm($member)
    {
        sfLoader::loadHelpers(array('Url'));
        $confirmation_url = url_for('@confirm_new_password?username=' . $member->getUsername() . '&hash=' . $member->getNewPassword(), array('absolute' => true));
        $global_vars = array('{CONFIRMATION_URL}' => $confirmation_url);
        return self::executeNotifications(self::NEW_PASSWORD_CONFIRM, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerNewEmailConfirm($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $confirmation_url = url_for('@confirm_new_email?username=' . $member->getUsername() . '&hash=' . sha1(SALT . $member->getTmpEmail() . SALT ), array('absolute' => true));
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
                             '{EOT_DATE}' => date('M d, Y', $member->getEotDate()),
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
        
        $global_vars = array('{PROFILE_URL}' => 'http://' . sfConfig::get('app_base_domain') . '/en/dashboard/profile/' . $member->getUsername() . '.html' );
        
        return self::executeNotifications(self::ABANDONED_REGISTRATION, $global_vars, null, $member);     
    }
    
    public static function triggerFirstContact($message)
    {
        $from_member = $message->getMemberRelatedByFromMemberId();
        if( $from_member->getCounter('SentMessages') == 0 )
        {
            sfLoader::loadHelpers(array('Url'));
            $to_member = $message->getMemberRelatedByToMemberId();
            
            $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $from_member->getUsername(), array('absolute' => true)),
                                 '{TO_PROFILE_URL}' => url_for('profile/index?username=' . $to_member->getUsername(), array('absolute' => true)),
                                 '{TO_FIRST_NAME}' => $to_member->getFirstName(),
                                 '{TO_LAST_NAME}' => $to_member->getLastName(),
                                 '{TO_USERNAME}' => $to_member->getUsername(),
                                 '{SUBJECT}' => $message->getSubject(),
                                 '{MESSAGE}' => $message->getContent(),
                                );
            
            return self::executeNotifications(self::FIRST_CONTACT, $global_vars, null, $from_member);
        }
    }
    
    /* OTHER EVENTS */
    public static function triggerTellFriend($name, $email, $friend_name, $friend_email, $comments = null)
    {
        
        $global_vars = array('{FRIEND_NAME}' => $friend_name, '{NAME}' => $name, '{EMAIL}' => $email, '{COMMENTS}' => $comments);
        return self::executeNotifications(self::TELL_FRIEND, $global_vars, $friend_email, null, $email);
    }
    
    /* REMINDERS */
    public static function triggerRegistrationReminder($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{LOGIN_URL}' => url_for(BASE_URL . 'signin', array('absolute' => true)));
        return self::executeNotifications(self::REGISTRATION_REMINDER, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerLoginReminder($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{LOGIN_URL}' => url_for(BASE_URL . 'signin', array('absolute' => true)), 
                             '{DEACTIVATION_DAYS}' => sfConfig::get('app_settings_deactivation_days',0));
        return self::executeNotifications(self::LOGIN_REMINDER, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerAccountActivity($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $nb_unread = $member->getNbUnreadMessages();
        $nb_winks = MemberCounterPeer::getNbNewWinks($member->getId());
        $nb_hotlist = MemberCounterPeer::getNbNewOnOtherHotlist($member->getId());
        $nb_profile_view = MemberCounterPeer::getNbNewProfileViews($member->getId());
        
        $global_vars = array('{LOGIN_URL}' => url_for(BASE_URL . 'signin', array('absolute' => true)),
                             '{NB_MESSAGES}' => $nb_unread,
                             '{NB_WINKS}' => $nb_winks,
                             '{NB_HOTLIST}' => $nb_hotlist,
                             '{NB_PROFILE_VIEWES}' => $nb_profile_view,
                            );
                            
        self::executeNotifications(self::ACCOUNT_ACTIVITY, $global_vars, $member->getEmail(), $member);
        $member->setLastActivityNotification(time());
        $member->save();        
    }
    
    public static function triggerAccountActivityMessage($member, $from_member, $message)
    {
        $profile_url  = LinkPeer::create('@profile?username=' . $from_member->getUsername(), $member->getId())->getUrl($member->getCulture());
        $messages_url = LinkPeer::create('messages/index', $member->getId())->getUrl($member->getCulture());
        $message_url  = LinkPeer::create('messages/view?id=' . $message->getId(), $member->getId())->getUrl($member->getCulture());
        $message_snippet = Tools::truncate($message->getContent(), 12);
        
        $global_vars = array('{SENDER_PROFILE_URL}' => $profile_url,
                             '{SENDER_USERNAME}' => $from_member->getUsername(),
                             '{URL_TO_MESSAGES}' => $messages_url,
                             '{URL_TO_MESSAGE}' => $message_url,
                             '{MESSAGE_SNIPPET}' => $message_snippet,
                            );
        
        
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_MESSAGE, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerAccountActivityWink(BaseMember $member, BaseMember $from_member)
    {
        $profile_url = LinkPeer::create('@profile?username=' . $from_member->getUsername(), $member->getId())->getUrl($member->getCulture());
        $global_vars = array('{SENDER_PROFILE_URL}' => $profile_url,
                             '{SENDER_USERNAME}' => $from_member->getUsername(),
                            );
                            
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_WINK, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerAccountActivityHotlist(BaseMember $member, BaseMember $from_member)
    {
        $profile_url = LinkPeer::create('@profile?username=' . $from_member->getUsername(), $member->getId())->getUrl($member->getCulture());
        $global_vars = array('{SENDER_PROFILE_URL}' => $profile_url,
                             '{SENDER_USERNAME}' => $from_member->getUsername(),
                            );
                            
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_HOTLIST, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerAccountActivityVisitor(BaseMember $member, BaseMember $visitor)
    {
        $profile_url = LinkPeer::create('@profile?username=' . $visitor->getUsername(), $member->getId())->getUrl($member->getCulture());
        $global_vars = array('{VISITOR_PROFILE_URL}' => $profile_url,
                             '{VISITOR_USERNAME}' => $visitor->getUsername(),
                            );
                            
        return self::executeNotifications(self::ACCOUNT_ACTIVITY_VISITOR, $global_vars, $member->getEmail(), $member);
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
        $culture = ( !is_null($object) && $object instanceof Member ) ? $object->getCulture() : null;
        
        $c = new Criteria();
        $c->add(NotificationEventPeer::EVENT, $event);
        $c->addJoin(NotificationPeer::ID, NotificationEventPeer::NOTIFICATION_ID);
        $c->add(NotificationPeer::IS_ACTIVE, true);
        $notifications = NotificationPeer::doSelectWithI18N($c, $culture);
        
        $ret = true;
        foreach ($notifications as $notification) 
        {
          if( $notification->getToAdmins() ) $notification->setCulture('en'); //force admin notifications to English
          $notification_ret = $notification->execute($global_vars, $addresses, $object, $mail_from);
          
          if( !$notification_ret ) $ret = false;
        }
        
        return $ret;
    }
}
