<?php

/**
 * notifications actions.
 *
 * @package    pr
 * @subpackage notifications
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class notificationsActions extends sfActions
{

    public function preExecute()
    {
        $this->top_menu_selected = 'content';
    }
    
    public function executeList()
    {
        $c = new Criteria();
        $c->add(NotificationPeer::TO_ADMINS, $this->getRequestParameter('to_admins', 0));
        $this->notifications = NotificationPeer::doSelect($c);
    }

    public function executeEdit()
    {
        $notification = NotificationPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($notification);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            $notification->setName($this->getRequestParameter('name'));
            $notification->setSendFrom($this->getRequestParameter('send_from'));
            if( $notification->getToAdmins() ) $notification->setSendTo($this->getRequestParameter('send_to'));
            $notification->setReplyTo($this->getRequestParameter('reply_to'));
            $notification->setBcc($this->getRequestParameter('bcc'));
            $notification->setSubject($this->getRequestParameter('subject'));
            $notification->setBody($this->getRequestParameter('notification_body'));
            $notification->setFooter($this->getRequestParameter('notification_footer'));
            $notification->setIsActive($this->getRequestParameter('is_active', 0));
            $notification->setDays($this->getRequestParameter('days', 0));
            $notification->setWhn(($this->getRequestParameter('days', 0) == 0) ? null : $this->getRequestParameter('whn'));
            $notification->save();
            
            $this->setFlash('msg_ok', 'Your changes have been saved');
            $this->redirect('notifications/list?to_admins=' . $notification->getToAdmins());
        }
        $this->notification = $notification;
    }
}
