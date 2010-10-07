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
        $this->left_menu_selected = 'System Notifications';
    }
    
    public function executeList()
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT n.name, n.mail_config, n.is_active, n.id, IF(m.today IS NULL, 0, m.today) as today
                  FROM notification n 
                  LEFT JOIN (SELECT m.notification_id, m.notification_cat,
                               SUM(IF( DATE(m.created_at) = CURDATE(), 1, 0 )) AS today
                  					 FROM pr_mail_message m
                                  WHERE 	status = "sent"
                                  group by m.notification_id, m.notification_cat 
                                  order by m.notification_id, m.notification_cat) m on m.notification_id = n.id and m.notification_cat= n.cat_id
                  WHERE n.to_admins =%TO_ADMIN% and n.cat_id =%CAT_ID%';
             
        $sql = strtr($sql, array(
            '%TO_ADMIN%' => $this->getRequestParameter('to_admins', 0),
            '%CAT_ID%'   => $this->getRequestParameter('cat_id')));
            
        $this->notifications = $customObject->query($sql);
    }

    public function executeEdit()
    {
        $notification = NotificationPeer::retrieveByPK($this->getRequestParameter('id'), $this->getRequestParameter('cat_id'));
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
            $notification->setMailConfig($this->getRequestParameter('mail_config'));
            $notification->save();
            
            $this->setFlash('msg_ok', 'Your changes have been saved');
            $this->redirect('notifications/list?to_admins=' . (int)$notification->getToAdmins() . '&cat_id=' . $notification->getCatId());
        }
        
        $this->notification = $notification;
        
        $mail_options = array();
        foreach(array_keys(sfConfig::get('app_mail_outgoing')) as $mail)
        {
            $mail_options[$mail] = $mail;
        }
        
        $this->mail_options = $mail_options;
    }
}
