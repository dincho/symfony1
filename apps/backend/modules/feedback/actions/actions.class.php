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
        //breadcrumb
        $bc = $this->getUser()->getBC();
        $bc->removeLast(); //remove action name
    }

    public function executeList()
    {
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/feedback/filters');        
        $this->processSort();
        
        $c = new Criteria();
        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);
        
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
        $this->getUser()->getBC()->add(array('name' => 'Compose Email', 'uri' => 'feedback/compose'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->getUser()->checkPerm(array('feedback_edit'));
            if ($this->getRequestParameter('save_draft')) {
                $this->saveDraft();
                $this->setFlash('msg_ok', 'Your draft message has been saved.');
                $this->redirect('feedback/list?filter=filter&filters[mailbox]=3');
            }

            if ($this->getRequestParameter('save_as_new_template')) {
                $this->saveTemplate();
            }

            $this->send();
            $this->setFlash('msg_ok', 'Your message has been sent.');
            $this->redirect('feedback/list');
        }

        
        $mail_options = array();
        foreach(sfConfig::get('app_mail_rr_groups') as $group => $values) {
            $mail_options[$group] = $values['title'];
        }
    
        foreach(array_keys(sfConfig::get('app_mail_outgoing')) as $mail) {
            $mail_options[$mail] = $mail;
        }
    
        $selectedMembers = $this->getUser()->getAttributeHolder()->getAll('backend/feedback/selectedMembers');

        $this->selectTemplate();
        $this->mail_options = $mail_options;
        $this->selectedMembers = implode(', ', $selectedMembers);
        $this->feedback_templates = FeedbackTemplatePeer::doSelect(new Criteria());
    }

    public function handleErrorCompose()
    {
        $this->getUser()->getBC()->add(array('name' => 'Compose Email', 'uri' => 'feedback/compose'));
        $this->selectTemplate();
        
        $this->selectedMembers = implode(', ', $this->getUser()->getAttributeHolder()->getAll('backend/feedback/selectedMembers'));
        
        $mail_options = array();
        foreach(sfConfig::get('app_mail_rr_groups') as $group => $values) {
            $mail_options[$group] = $values['title'];
        }
        
        foreach(array_keys(sfConfig::get('app_mail_outgoing')) as $mail) {
            $mail_options[$mail] = $mail;
        }
    
        $this->mail_options = $mail_options; 
                    
        return sfView::SUCCESS;
    }
    
    protected function selectTemplate()
    {
        $templateId = $this->getRequestParameter('template_id');
        if ($templateId) {
            $this->template = FeedbackTemplatePeer::retrieveByPK($templateId);
            $this->getRequest()->setParameter('body', $this->template->getBody());
        }
        
        if (!isset($this->template)) {
            $this->template = new FeedbackTemplate();
        }
    }

    protected function saveTemplate()
    {
        $template = new FeedbackTemplate();
        $template->setName($this->getRequestParameter('save_as_new_template'));
        $template->setMailFrom($this->getRequestParameter('mail_from'));
        $template->setReplyTo($this->getRequestParameter('reply_to'));
        $template->setBcc($this->getRequestParameter('bcc'));
        $template->setSubject($this->getRequestParameter('subject'));
        $template->setBody($this->getRequestParameter('message_body'));
        $template->setFooter($this->getRequestParameter('message_footer'));
        $template->save();
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
        $send_options = $this->getRequestParameter('send_options');
        
        if ($this->getRequestParameter('mail_to'))
        {
            if( in_array('email_address', $send_options) )
            {
                $message = new PrMailMessage();
                $message->setMailConfig($this->getRequestParameter('mail_config'));
                $message->setSender($this->getRequestParameter('mail_from'));
                $message->setMailFrom($this->getRequestParameter('mail_from'));
                $message->setSubject($this->getRequestParameter('subject'));
                $message->setBody($this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
                $message->addRecipient($this->getRequestParameter('mail_to'));
            
                try
                {
                    if( !$message->saveAndSend() )
                    {
                        $this->setFlash('msg_error', 'Error sending email: unknown error or sending emails is disabled');
                        $this->redirect('feedback/list');                            
                    }
                } catch (sfException $e)
                {   
                    if(SF_ENVIRONMENT == 'dev') 
                    {
                        if( sfConfig::get('app_mail_smtp_debug', 0) > 0 ) exit(); //we need to exit to see the output from the SMTP echos
                        throw $e;
                    }
                
                    $this->setFlash('msg_error', 'Error sending email: ' . $e->getMessage());
                    $this->redirect('feedback/list');
                }
            
                $feedback = new Feedback();
                $feedback->setMailbox(FeedbackPeer::SENT);
                $feedback->setIsRead(true);
                $feedback->setMailTo($this->getRequestParameter('mail_to'));
                $feedback->setMailFrom($this->getRequestParameter('mail_from', sfConfig::get('app_mail_from', 'from_email_not_set@PolishRomance.com')));
                $feedback->setSubject($this->getRequestParameter('subject'));
                $feedback->setBody($this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
                $feedback->save();
            }
            
            if( in_array('internal_inbox', $send_options) && 
                $member = MemberPeer::retrieveByEmail($this->getRequestParameter('mail_to')) )
            {
                MessagePeer::sendSystem($member,
                                        $this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
            }
        }
        
        //to members
        $c = new Criteria();
        $this->addSendFiltersCriteria($c);

        if (isset($this->send_to_members) && $this->send_to_members)
        {
            $members = MemberPeer::doSelect($c);
            foreach ($members as $member)
            {
                if( in_array('email_address', $send_options) )
                {
                    $message = new PrMailMessage();
                    $message->setMailConfig($this->getRequestParameter('mail_config'));
                    $message->setMailFrom($this->getRequestParameter('mail_from'));
                    $message->setSender($this->getRequestParameter('mail_from'));
                    $message->setSubject($this->getRequestParameter('subject'));
                    $message->setBody($this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
                    $message->addRecipient($member->getEmail());
                
                    try
                    {
                        if( !$message->saveAndSend() )
                        {
                            $this->setFlash('msg_error', 'Error sending email: unknown error or sending emails is disabled');
                            $this->redirect('feedback/list');                            
                        }
                    } catch (sfException $e)
                    {
                        if(SF_ENVIRONMENT == 'dev') 
                        {
                            if( sfConfig::get('app_mail_smtp_debug', 0) > 0 ) exit(); //we need to exit to see the output from the SMTP echos
                            throw new sfException($e->getMessage(), $e->getCode());
                        }
                    
                        $this->setFlash('msg_error', 'Error sending email: ' . $e->getMessage());
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
                
                if( in_array('internal_inbox', $send_options) )
                {
                    MessagePeer::sendSystem($member, 
                                            $this->getRequestParameter('subject'), 
                                            $this->getRequestParameter('message_body') . $this->getRequestParameter('message_footer'));
                }
            }//foreach
        }//if
    }


    public function executeAddToBugTrac()
    {
        $message = FeedbackPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($message);
        
        $login_url = 'http://' .  sfConfig::get('app_trac_username') . ':' .sfConfig::get('app_trac_password') .'@' . sfConfig::get('app_trac_url') . 'login/xmlrpc';
        $description = "'''From Email: " . $message->getMailFrom();
        if($message->getMemberId()) $description .= "\n[[BR]]Member ID: " . $message->getMemberId();
        $description .= "'''[[BR]][[BR]]\n" .$message->getBody();
        
        require_once('XML/RPC2/Client.php');
        $server = XML_RPC2_Client::create($login_url);
        $ticket_number = $server->remoteCall___('ticket.create', array($message->getSubject(), $description, 
        array('milestone' => sfConfig::get('app_trac_milestone'), 'type' => sfConfig::get('app_trac_ticket_type'))));
        
        
        $this->setFlash('msg_ok', 'Ticket #' . $ticket_number . ' has been added to the Bug Tracking system');
        $this->redirect('feedback/read?id=' . $message->getId());
    }
    
    public function executeOutgoingMailList()
    {
        $this->getUser()->checkPerm(array('feedback_edit'));
        $this->getUser()->getBC()->add(array('name' => 'All Outgoing Emails', 'uri' => 'feedback/outgoingMailList'));
        
        $this->processSort('backend/feedback/outgoing_mail_list/sort', 'PrMailMessage::updated_at');
        
        $c = new Criteria();
        // $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('PrMailMessage', $per_page);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setCriteria($c);
        $pager->init();
        
        $this->pager = $pager;
    }

    public function executeOutgoingRead()
    {
        $this->message = PrMailMessagePeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($this->message);
/*        if (! $this->message->isRead())
        {
            $this->message->setIsRead(true);
            $this->message->save();
        }
*/    }
    
    public function executeOutgoingMailResend()
    {
        $this->getUser()->checkPerm(array('feedback_edit'));
        $marked = $this->getRequestParameter('marked', false);
        if (is_array($marked) && !empty($marked))
        {
            $c = new Criteria();
            $c->add(PrMailMessagePeer::ID, $marked, Criteria::IN);
            $c->addDescendingOrderByColumn(PrMailMessagePeer::CREATED_AT);
            $messages = PrMailMessagePeer::doSelect($c);
            
            foreach($messages as $message)
            {
                $message->send();
            }
        }
        
        $this->setFlash('msg_ok', 'Selected messages has been scheduled for retry.');
        $this->redirect('feedback/outgoingMailList');
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
        } elseif( $has_second_crit )
        {
            $c->add($crit);
            $this->send_to_members = true;
        }
    
    }

    /*
     * Compose methods end
     */
    public function executeDelete()
    {
        $this->getUser()->checkPerm(array('feedback_edit'));
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
        $this->getResponse()->addJavascript('/cropper/lib/prototype.js');
        $this->selectedMembers = $this->getUser()->getAttributeHolder()->getAll('backend/feedback/selectedMembers');
        $this->getUser()->getBC()->add(array('name' => 'Compose Email', 'uri' => 'feedback/compose'));
        $this->getUser()->getBC()->add(array('name' => 'Add Email Recipients', 'uri' => '#'));

        $this->processFilters('backend/feedback/email_recipients/filters');
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/feedback/email_recipients/filters');
        $this->processSort('backend/feedback/email_recipients/sort', 'Member::created_at');
        
        $c = new Criteria();
        $this->addMembersFiltersCriteria($c);
        $this->addSortCriteria($c);
        //$c->setDistinct();
        
        //$this->members = MemberPeer::doSelectJoinAll($c);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$this->getRequestParameter('per_page'))
        {
            $this->redirect('feedback/compose');
        }
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setCriteria($c);
        $pager->setPeerMethod('doSelectJoinAll');
        $pager->setPeerCountMethod('doCountJoinAll');
        $pager->init();
        
        $this->pager = $pager;
    }
    
    protected function processSort($namespace = 'backend/feedback/sort', $default_column = 'Feedback::created_at')
    {
        $this->sort_namespace = $namespace;
        
        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }
        
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', $default_column, $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $this->sort_namespace); //default order
        }
    }

    protected function addSortCriteria($c)
    {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $sort_arr = explode('::', $sort_column);
            $peer = $sort_arr[0] . 'Peer';
            
            $sort_column = call_user_func(array($peer, 'translateFieldName'), $sort_arr[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
            if ($this->getUser()->getAttribute('type', null, $this->sort_namespace) == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
            } else
            {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }

    protected function processFilters($namespace = 'backend/feedback/filters')
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace($namespace);
            $this->getUser()->getAttributeHolder()->add($filters, $namespace);
        }
    }

    protected function addFiltersCriteria($c)
    {
        $bc = $this->getUser()->getBC();
        $filters = $this->filters;
        
        //default to imbox
        if (! isset($filters['mailbox']))
            $filters['mailbox'] = 1;
        
        switch ($filters['mailbox']) {
            case 1:
                $bc->add(array('name' => 'Inbox', 'uri' => 'feedback/list?filter=filter&filters[mailbox]=1'));
                $this->left_menu_selected = 1;
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
        
        $c->add(FeedbackPeer::MAILBOX, $filters['mailbox']);
        
        if (isset($filters['paid']) && $filters['paid'] == 1)
        {
            $c->add(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::FREE, Criteria::NOT_EQUAL);
            $bc->add(array('name' => 'From Paid Members', 'uri' => 'feedback/list?filter=filter&filters[paid]=1'));
            $this->left_menu_selected = 2;
        }
        
        if (isset($filters['external']) && $filters['external'] == 1)
        {
            $c->add(FeedbackPeer::MEMBER_ID, null, Criteria::ISNULL);
            $bc->add(array('name' => 'External Messages', 'uri' => 'feedback/list?filter=filter&filters[external]=1'));
            $this->left_menu_selected = 4;
        }
        
        if (isset($filters['bugs']) && $filters['bugs'] == 1)
        {
            $c->add(FeedbackPeer::MAIL_TO, FeedbackPeer::BUGS_SUGGESIONS_ADDRESS);
            $bc->add(array('name' => 'Reported Bug/Ideas', 'uri' => 'feedback/list?filter=filter&filters[bug]=1'));
            $this->left_menu_selected = 3;
        }
        
        $this->addMembersFiltersCriteria($c);
    }
    
    protected function addMembersFiltersCriteria($c)
    {
        $bc = $this->getUser()->getBC();
        $filters = $this->filters;
        
        if (isset($filters['search_type']) && isset($filters['search_query']) && strlen($filters['search_query']) > 0)
        {
            switch ($filters['search_type']) {
                case 'first_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'feedback/list?filter=filter'));
                    $c->add(MemberPeer::FIRST_NAME, $filters['search_query']);

                    break;
                case 'last_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'feedback/list?filter=filter'));
                    $c->add(MemberPeer::LAST_NAME, $filters['search_query']);

                    break;
                case 'email':
                    $bc->add(array('name' => 'Search', 'uri' => 'feedback/list?filter=filter'));
                    $c->add(MemberPeer::EMAIL, $this->filters['search_query']);

                    break;                    
                default:
                    $bc->add(array('name' => 'Search', 'uri' => 'feedback/list?filter=filter'));
                    $c->add(MemberPeer::USERNAME, $filters['search_query']);

                    break;
            }
        }
    }    
}
