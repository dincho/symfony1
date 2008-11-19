<?php
/**
 * feedback actions.
 *
 * @package    pr
 * @subpackage feedback
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class feedbackActions extends sfActions
{

    public function preExecute()
    {
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/feedback/filters');
        //breadcrumb
        $bc = $this->getUser()->getBC();
        $bc->removeLast(); //remove action name
        if (isset($this->filters))
        {
            if (array_key_exists('mailbox', $this->filters))
            {
                switch ($this->filters['mailbox']) {
                    case 1:
                        $bc->add(array('name' => 'Inbox', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1'));
                        $this->left_menu_selected = 'All Messages';
                        break;
                    case 2:
                        $bc->add(array('name' => 'Sent', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=2'));
                        $this->left_menu_selected = 'Sent';
                        break;
                    case 3:
                        $bc->add(array('name' => 'Drafts', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=3'));
                        $this->left_menu_selected = 'Drafts';
                        break;
                    case 4:
                        $bc->add(array('name' => 'Trash', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=4'));
                        $this->left_menu_selected = 'Trash';
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function executeList()
    {
        //default to INBOX
        if (! isset($this->filters['mailbox'])) 
        {
            //because of indirect modification of overloaded property notice
            $filters = $this->filters;
            $filters['mailbox'] = 1;
            $this->filters = $filters;
        }
        
        $c = new Criteria();
        $c->addDescendingOrderByColumn(FeedbackPeer::CREATED_AT);
        $this->addFiltersCriteria($c);
        $per_page = ($this->getRequestParameter('per_page', 0) <= 0) ? sfConfig::get('app_pager_default_per_page') : $this->getRequestParameter('per_page');
        $pager = new sfPropelPager('Feedback', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAll');
        $pager->setPeerCountMethod('doCountJoinAll');
        $pager->init();
        $this->pager = $pager;
    }

    public function executeRead()
    {
        $this->message = FeedbackPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($this->message);
        if (! $this->message->isRead())
        {
            $this->message->setIsRead(true);
            $this->message->save();
        }
    }

    /*
     * Compose methods start
     */
    public function executeCompose()
    {
        //replace mailbox and add compose
        $this->getUser()->getBC()->replaceLast(array('name' => 'Compose Email', 'uri' => 'feedback/compose'));
        $this->template = new ImbraReplyTemplate(); //@todo change this to feedback templates 
        if ($this->getRequestParameter('template_id'))
            $this->selectTemplate();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('save_draft'))
            {
                $this->saveDraft();
                $this->setFlash('msg_ok', 'Your draft message has been saved.');
                $this->redirect('feedback/list?filter=filter&filters[mailbox]=3');
            } else
            {
                if ($this->getRequestParameter('save_as_template'))
                    $this->saveTemplate();
                $this->send();
                $this->setFlash('msg_ok', 'Your message has been sent.');
                //$this->redirect('feedback/list');
            }
        } else
        {
            $this->selectedMembers = implode(', ', $this->getUser()->getAttributeHolder()->getAll('backend/feedback/selectedMembers'));
        }
    }

    protected function selectTemplate()
    {
    }

    protected function saveTemplate()
    {
    }

    public function executeOpen()
    {
        $mail = FeedbackPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($mail);
        $mail->exportToRequestParameters();
        $this->forward($this->getModuleName(), 'compose');
    }

    public function executeReply()
    {
        $mail = FeedbackPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($mail);
        $request = $this->getRequest();
        $request->setParameter('mail_to', $mail->getMailFrom());
        $request->setParameter('subject', 'Re: ' . $mail->getSubject());
        $request->setParameter('body', $mail->getBodyForReply());
        $this->forward($this->getModuleName(), 'compose');
    }

    protected function saveDraft()
    {
        $feedback = new Feedback();
        $feedback->setMailbox(FeedbackPeer::DRAFT);
        $feedback->setIsRead(true);
        $feedback->setMailTo($this->getRequestParameter('mail_to'));
        $feedback->setMailFrom($this->getRequestParameter('mail_from'));
        $feedback->setSubject($this->getRequestParameter('subject'));
        $feedback->setBody($this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
        $feedback->save();
    }

    protected function send()
    {
        if ($this->getRequestParameter('mail_to'))
        {
            $mail = new prMail();
            $mail->setSender($this->getRequestParameter('mail_from'));
            $mail->setFrom($this->getRequestParameter('mail_from'));
            $mail->setSubject($this->getRequestParameter('subject'));
            $mail->setBody($this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
            $mail->addAddress($this->getRequestParameter('mail_to'));
            
            try
            {
                $mail->send();
            } catch (sfException $e)
            {
                $this->setFlash('msg_error', 'Error sending email!<br />' . $e->getMessage());
                $this->redirect('feedback/list');
            }
            
            $feedback = new Feedback();
            $feedback->setMailbox(FeedbackPeer::SENT);
            $feedback->setIsRead(true);
            $feedback->setMailTo($this->getRequestParameter('mail_to'));
            $feedback->setMailFrom($this->getRequestParameter('mail_from', 'noreply@polishromance.com'));
            $feedback->setSubject($this->getRequestParameter('subject'));
            $feedback->setBody($this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
            $feedback->save();
        
        }
        
        //to members
        $c = new Criteria();
        $this->addSendFiltersCriteria($c);
        $c->setLimit(100); //max emails
        
        if (isset($this->send_to_members) && $this->send_to_members)
        {
            $members = MemberPeer::doSelect($c);
            foreach ($members as $member)
            {
                $mail = new prMail();
                $mail->setSender($this->getRequestParameter('mail_from'));
                $mail->setSubject($this->getRequestParameter('subject'));
                $mail->setBody($this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
                $mail->addAddress($member->getEmail(), $member->getFullName());
                
                try
                {
                    $mail->send();
                } catch (sfException $e)
                {
                    $this->setFlash('msg_error', 'Error sending email!<br />' . $e->getMessage());
                    $this->redirect('feedback/list');
                }
                
                $feedback = new Feedback();
                $feedback->setMailbox(FeedbackPeer::SENT);
                $feedback->setIsRead(true);
                $feedback->setMailTo($member->getEmail());
                $feedback->setMailFrom($this->getRequestParameter('mail_from'));
                $feedback->setSubject($this->getRequestParameter('subject'));
                $feedback->setBody($this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
                $feedback->save();
            }
        }
    }

    protected function addSendFiltersCriteria(Criteria $c)
    {
        $has_second_crit = false;
        $send_filter = $this->getRequestParameter('send_filter', array());
        $crit = $c->getNewCriterion(MemberPeer::ID, null, Criteria::ISNOTNULL);
        
        if (strlen($this->getRequestParameter('username')) > 0)
        {
            $usernames = Tools::getStringRequestParameterAsArray('username');
            $crit_usr = $c->getNewCriterion(MemberPeer::USERNAME, $usernames, Criteria::IN);
        }
        
        if (isset($send_filter['subscription_id']) && is_array($send_filter['subscription_id']))
        {
            foreach ($send_filter['subscription_id'] as $subscription_id)
            {
                if (! isset($crit_tmp))
                {
                    $crit_tmp = $c->getNewCriterion(MemberPeer::SUBSCRIPTION_ID, $subscription_id);
                } else
                {
                    $crit_tmp->addOr($c->getNewCriterion(MemberPeer::SUBSCRIPTION_ID, $subscription_id));
                }
            }
            
            $crit->addAnd($crit_tmp);
            unset($crit_tmp);
            $has_second_crit = true;
        }
        
        if (isset($send_filter['status_id']) && is_array($send_filter['status_id']))
        {
            foreach ($send_filter['status_id'] as $status_id)
            {
                if (! isset($crit_tmp))
                {
                    $crit_tmp = $c->getNewCriterion(MemberPeer::MEMBER_STATUS_ID, $status_id);
                } else
                {
                    $crit_tmp->addOr($c->getNewCriterion(MemberPeer::MEMBER_STATUS_ID, $status_id));
                }
            }
            
            $crit->addAnd($crit_tmp);
            unset($crit_tmp);
            $has_second_crit = true;
        }
        
        if (isset($send_filter['imbra_us']))
        {
            $crit->addAnd($c->getNewCriterion(MemberPeer::COUNTRY, 'US'));
            $has_second_crit = true;
        }
        
        if (isset($send_filter['imbra_non_us']))
        {
            $crit->addAnd($c->getNewCriterion(MemberPeer::COUNTRY, 'US', Criteria::NOT_EQUAL));
            
            //OR i`m not US citizen == true
            $has_second_crit = true;
        }
        
        if (isset($send_filter['sex']) && is_array($send_filter['sex']))
        {
            foreach ($send_filter['sex'] as $sex)
            {
                if (! isset($crit_tmp))
                {
                    $crit_tmp = $c->getNewCriterion(MemberPeer::SEX, $sex);
                } else
                {
                    $crit_tmp->addOr($c->getNewCriterion(MemberPeer::SEX, $sex));
                }
            }
            
            $crit->addAnd($crit_tmp);
            unset($crit_tmp);
            $has_second_crit = true;
        }
        
        if (isset($send_filter['filter_country']) && $send_filter['country'])
        {
            $crit->addAnd($c->getNewCriterion(MemberPeer::COUNTRY, $send_filter['country']));
            $has_second_crit = true;
        }
        
        if (isset($send_filter['filter_language']) && $send_filter['language'])
        {
            $crit->addAnd($c->getNewCriterion(MemberPeer::LANGUAGE, $send_filter['language']));
            $has_second_crit = true;
        }
        
        if (isset($crit_usr) && $has_second_crit)
        {
            $crit->addOr($crit_usr);
            $c->add($crit);
            $this->send_to_members = true;
        } elseif (isset($crit_usr))
        {
            $c->add($crit_usr);
            $this->send_to_members = true;
        }
    
    }

    /*
     * Compose methods end
     */
    public function executeDelete()
    {
        $marked = $this->getRequestParameter('marked', false);
        if (is_array($marked) && ! empty($marked))
        {
            //perm delete trashed emails
            $c = new Criteria();
            $c->add(FeedbackPeer::ID, $marked, Criteria::IN);
            $c->add(FeedbackPeer::MAILBOX, FeedbackPeer::TRASH);
            FeedbackPeer::doDelete($c);
            
            //move non-trashed messages to trash mailbox
            $select = new Criteria();
            $select->add(FeedbackPeer::ID, $marked, Criteria::IN);
            $select->add(FeedbackPeer::MAILBOX, FeedbackPeer::TRASH, Criteria::NOT_EQUAL);
            
            $update = new Criteria();
            $update->add(FeedbackPeer::MAILBOX, FeedbackPeer::TRASH);
            BasePeer::doUpdate($select, $update, Propel::getConnection());
        }
        $this->setFlash('msg_ok', 'Selected messages has been deleted.');
        return $this->redirect('feedback/list');
    }

    public function executeAddEmailRecipients()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Add Email Recipients', 'uri' => '#'));
        $c = new Criteria();
        $this->addFiltersCriteria($c);
        $c->setLimit(20);
        $this->members = MemberPeer::doSelectJoinAll($c);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $marked = $this->getRequestParameter('marked', false);
            if (is_array($marked) && ! empty($marked))
            {
                $this->getUser()->getAttributeHolder()->removeNamespace('backend/feedback/selectedMembers');
                $this->getUser()->getAttributeHolder()->add($marked, 'backend/feedback/selectedMembers');
            }
            $this->redirect('feedback/compose');
        }
    }

    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/feedback/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/feedback/filters');
        }
    }

    protected function addFiltersCriteria($c)
    {
        $bc = $this->getUser()->getBC();
        if (isset($this->filters['mailbox']))
        {
            $c->add(FeedbackPeer::MAILBOX, $this->filters['mailbox']);
        }
        
        if (isset($this->filters['paid']) && $this->filters['paid'] == 1)
        {
            $crit = $c->getNewCriterion(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::PAID);
            $crit->addOr($c->getNewCriterion(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::COMP));
            $c->add($crit);
            $bc->add(array('name' => 'From Paid Members', 'uri' => 'feedback/list?filter=filter&filters[paid]=1'));
            $this->left_menu_selected = 'From Paid Members';
        }
        
        if (isset($this->filters['external']) && $this->filters['external'] == 1)
        {
            $c->add(FeedbackPeer::MEMBER_ID, null, Criteria::ISNULL);
            $bc->add(array('name' => 'External Messages', 'uri' => 'feedback/list?filter=filter&filters[external]=1'));
            $this->left_menu_selected = 'External Messages';
        }
        
        if (isset($this->filters['bugs']) && $this->filters['bugs'] == 1)
        {
            $c->add(FeedbackPeer::MAIL_TO, FeedbackPeer::BUGS_SUGGESIONS_ADDRESS);
            $bc->add(array('name' => 'Reported Bug/Ideas', 'uri' => 'feedback/list?filter=filter&filters[bug]=1'));
            $this->left_menu_selected = 'Reported Bug/Ideas';
        }
        
        if (isset($this->filters['search_type']) && isset($this->filters['search_query']) && strlen($this->filters['search_query']) > 0)
        {
            switch ($this->filters['search_type']) {
                case 'first_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'feedback/list?filter=filter'));
                    $c->add(MemberPeer::FIRST_NAME, $this->filters['search_query']);
                    ;
                    break;
                case 'last_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'feedback/list?filter=filter'));
                    $c->add(MemberPeer::LAST_NAME, $this->filters['search_query']);
                    ;
                    break;
                default:
                    $bc->add(array('name' => 'Search', 'uri' => 'feedback/list?filter=filter'));
                    $c->add(MemberPeer::USERNAME, $this->filters['search_query']);
                    ;
                    break;
            }
        }
    }

    public function executeIndex()
    {
        $imap = new IMAP();
        $messages = $imap->getMessages();
        
        echo "<pre>";
        //print_r($messages);exit();
        foreach ($messages as $message)
        {
            echo 'TS: ' . $message->getTS() . '<br />';
            echo 'From: ' . htmlspecialchars($message->getFrom()) . '<br />';
            echo 'To: ' . htmlspecialchars($message->getTo()) . '<br />';
            echo 'Subject: <b>' . $message->getSubject() . '</b><br />';
            echo $message->getBody() . '<hr />';
        }
        
        echo "</pre>";
        exit();
    }
}
