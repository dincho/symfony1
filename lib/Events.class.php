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
    const JOIN = 1;
    const FORGOT_PASSWORD = 2;
    const NEW_PASSWORD_CONFIRM = 3;
    const NEW_EMAIL_CONFIRM = 4;
    const NEW_EMAIL_CONFIRMED = 5; //when email confirmation is done, and email is changed.
    const ACCOUNT_DELETE_BY_MEMBER = 6;
    const TELL_FRIEND = 7;
    const REGISTRATION_APPROVE = 8;

    public static function triggerJoin($member)
    {
        sfLoader::loadHelpers(array('Tag', 'Url'));
        $hash = sha1(SALT . $member->getUsername() . SALT);
        $global_vars = array('{ACTIVATION_URL}' => url_for('registration/activate?username=' . $member->getUsername() . '&hash=' . $hash, array('absolute' => true)));
        
        self::executeNotifications(self::JOIN, $global_vars, $member->getEmail(), $member);
    }
    
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
    
    public static function triggerAccountDeleteByMember($member, $reason = null)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{PROFILE_URL}' => url_for('profile/index?username=' . $member->getUsername(), array('absolute' => true)), '{REASON}' => $reason);
        
        self::executeNotifications(self::ACCOUNT_DELETE_BY_MEMBER, $global_vars, null, $member);     
    }
    
    public static function triggerTellFriend($name, $email, $friend_name, $friend_email, $comments = null)
    {
        
        $global_vars = array('{FRIEND_NAME}' => $friend_name, '{NAME}' => $name, '{EMAIL}' => $email, '{COMMENTS}' => $comments);
        self::executeNotifications(self::TELL_FRIEND, $global_vars, $friend_email, null, $email);
    }
    
    public static function triggerRegistrationApprove($member)
    {
        sfLoader::loadHelpers(array('Url'));
        
        $global_vars = array('{LOGIN_URL}' => url_for(BASE_URL . 'signin', array('absolute' => true)));
        self::executeNotifications(self::REGISTRATION_APPROVE, $global_vars, $member->getEmail(), $member);
    }
    
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
