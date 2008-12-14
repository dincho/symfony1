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
    
    /* REGISTRATION EVENTS */
    public static function triggerJoin($member)
    {
        sfLoader::loadHelpers(array('Tag', 'Url'));
        $hash = sha1(SALT . $member->getUsername() . SALT);
        $global_vars = array('{ACTIVATION_URL}' => url_for('registration/activate?username=' . $member->getUsername() . '&hash=' . $hash, array('absolute' => true)));
        
        self::executeNotifications(self::JOIN, $global_vars, $member->getEmail(), $member);
    }

    public static function triggerWelcome($member)
    {
        sfLoader::loadHelpers(array('Tag', 'Url'));
        $global_vars = array('{LOGIN_URL}' => url_for('@signin', array('absolute' => true)),
                             '{PROFILE_URL}' => url_for('@profile?username=' . $member->getUsername(), array('absolute' => true)),
                             '{IP}' => $_SERVER['REMOTE_ADDR'],
                            );
        
        self::executeNotifications(self::WELCOME, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerWelcomeApproved($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{LOGIN_URL}' => url_for(BASE_URL . 'signin', array('absolute' => true)));
        self::executeNotifications(self::WELCOME_APPROVED, $global_vars, $member->getEmail(), $member);
    }

    /* EMAIL & PASSOWRD EVENTS */
    public static function triggerForgotPassword($member)
    {
        sfLoader::loadHelpers(array('Url'));
        $global_vars = array('{CONFIRMATION_URL}' => url_for('profile/forgotPasswordConfirm?username='. $member->getUsername() .'&hash=' . sha1(SALT . $member->getPassword() . SALT), array('absolute' => true)));
        self::executeNotifications(self::FORGOT_PASSWORD, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerNewPasswordConfirm($member)
    {
        sfLoader::loadHelpers(array('Url'));
        $confirmation_url = url_for('profile/confirmNewPassword?username=' . $member->getUsername() . '&hash=' . $member->getNewPassword(), array('absolute' => true));
        $global_vars = array('{CONFIRMATION_URL}' => $confirmation_url);
        self::executeNotifications(self::NEW_PASSWORD_CONFIRM, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerNewEmailConfirm($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $confirmation_url = url_for('profile/confirmNewEmail?username=' . $member->getUsername() . '&hash=' . sha1(SALT . $member->getTmpEmail() . SALT ), array('absolute' => true));
        $global_vars = array('{CONFIRMATION_URL}' => $confirmation_url);
        
        self::executeNotifications(self::NEW_EMAIL_CONFIRM, $global_vars, $member->getTmpEmail(), $member);
    }
    
    public static function triggerNewEmailConfirmed($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $undo_url = url_for('profile/undoNewEmail?username=' . $member->getUsername() . '&hash=' . sha1(SALT . $member->getEmail() . SALT . $member->getTmpEmail() . SALT ), array('absolute' => true));
        $global_vars = array('{UNDO_URL}' => $undo_url);
        
        //send to the old email, which is in the temp field
        self::executeNotifications(self::NEW_EMAIL_CONFIRMED, $global_vars, $member->getTmpEmail(), $member);
    }
    
    /* MEMBER EVENTS */
    public static function triggerAccountDeleteByMember($member, $reason = null)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)), '{REASON}' => $reason);
        
        self::executeNotifications(self::ACCOUNT_DELETE_BY_MEMBER, $global_vars, null, $member);     
    }
    
    public static function triggerAccountDeactivation($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)));
        
        self::executeNotifications(self::ACCOUNT_DEACTIVATION, $global_vars, null, $member);     
    }
    
    public static function triggerAutoRenew($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)));
        
        self::executeNotifications(self::AUTO_RENEW, $global_vars, null, $member);     
    }
    
    public static function triggerScamActivity($member, $nb_flags)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)),
                             '{NB_FLAGS}' =>  $nb_flags,
                            );
        
        self::executeNotifications(self::SCAM_ACTIVITY, $global_vars, null, $member);     
    }
    
    public static function triggerSpamActivity($member, $nb_messages)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)),
                             '{NB_MESSAGES}' => $nb_messages,
                            );
        
        self::executeNotifications(self::SPAM_ACTIVITY, $global_vars, null, $member);     
    }
    
    public static function triggerAbandonedRegistration($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)),
                            );
        
        self::executeNotifications(self::ABANDONED_REGISTRATION, $global_vars, null, $member);     
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
            
            self::executeNotifications(self::FIRST_CONTACT, $global_vars, null, $from_member);
        }
    }
    
    /* OTHER EVENTS */
    public static function triggerTellFriend($name, $email, $friend_name, $friend_email, $comments = null)
    {
        
        $global_vars = array('{FRIEND_NAME}' => $friend_name, '{NAME}' => $name, '{EMAIL}' => $email, '{COMMENTS}' => $comments);
        self::executeNotifications(self::TELL_FRIEND, $global_vars, $friend_email, null, $email);
    }
    
    /* REMINDERS */
    public static function triggerRegistrationReminder($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{LOGIN_URL}' => url_for(BASE_URL . 'signin', array('absolute' => true)));
        self::executeNotifications(self::REGISTRATION_REMINDER, $global_vars, $member->getEmail(), $member);
    }
    
    public static function triggerLoginReminder($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{LOGIN_URL}' => url_for(BASE_URL . 'signin', array('absolute' => true)));
        self::executeNotifications(self::LOGIN_REMINDER, $global_vars, $member->getEmail(), $member);
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
        $c = new Criteria();
        $c->add(NotificationEventPeer::EVENT, $event);
        $c->addJoin(NotificationPeer::ID, NotificationEventPeer::NOTIFICATION_ID);
        $c->add(NotificationPeer::IS_ACTIVE, true);
        $notifications = NotificationPeer::doSelect($c);
        
        foreach ($notifications as $notification) $notification->execute($global_vars, $addresses, $object, $mail_from);
    }
}
