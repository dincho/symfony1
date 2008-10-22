<?php
/**
 * notificationsCRUD actions.
 *
 * @package    pr
 * @subpackage notificationsCRUD
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class notificationsCRUDActions extends sfActions
{

    public function executeIndex()
    {
        return $this->forward('notificationsCRUD', 'list');
    }

    public function executeList()
    {
        $this->notifications = NotificationPeer::doSelect(new Criteria());
    }

    public function executeShow()
    {
        $this->notification = NotificationPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($this->notification);
    }

    public function executeCreate()
    {
        $notification = new Notification();
        $notification->setSendFrom('customerservice@polishromance.com');
        $notification->setSendTo('admin@polishromance.com');
        $notification->setReplyTo('noreply@polishromance.com');
        $notification->setIsActive(true);
        
        $this->notification = $notification;
        $this->setTemplate('edit');
    }

    public function executeEdit()
    {
        $this->notification = NotificationPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($this->notification);
    }

    public function executeUpdate()
    {
        if (! $this->getRequestParameter('id'))
        {
            $notification = new Notification();
        } else
        {
            $notification = NotificationPeer::retrieveByPk($this->getRequestParameter('id'));
            $this->forward404Unless($notification);
        }
        $notification->setId($this->getRequestParameter('id'));
        $notification->setName($this->getRequestParameter('name'));
        $notification->setSendFrom($this->getRequestParameter('send_from'));
        $notification->setSendTo($this->getRequestParameter('send_to'));
        $notification->setReplyTo($this->getRequestParameter('reply_to'));
        $notification->setBcc($this->getRequestParameter('bcc'));
        $notification->setTriggerName($this->getRequestParameter('trigger_name'));
        $notification->setSubject($this->getRequestParameter('subject'));
        $notification->setBody($this->getRequestParameter('body'));
        $notification->setIsActive($this->getRequestParameter('is_active', 0));
        $notification->setToAdmins($this->getRequestParameter('to_admins', 0));
        $notification->setDays($this->getRequestParameter('days'));
        $notification->setWhn($this->getRequestParameter('whn'));
        $notification->save();
        return $this->redirect('notificationsCRUD/list');
    }

    public function executeDelete()
    {
        $notification = NotificationPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($notification);
        $notification->delete();
        return $this->redirect('notificationsCRUD/list');
    }
}
