<?php

/**
 * Subclass for performing query and update operations on the 'notification' table.
 *
 * 
 *
 * @package lib.model
 */ 
class NotificationPeer extends BaseNotificationPeer
{
    const REGISTRATION_REMINDER = 8;
    const LOGIN_REMINDER = 11;
    const ACCOUNT_ACTIVITY = 9;
    const ABANDONED_REGISTRATION = 18;
    const EOT = 27;
}
