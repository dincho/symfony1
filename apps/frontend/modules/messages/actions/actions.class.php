<?php
class messagesActions extends prActions
{

    public function preExecute()
    {
        $bc = $this->getUser()->getBC();
        $bc->addFirst(array('name' => 'Dashboard', 'uri' => 'dashboard/index'));
    }

    public function executeIndex()
    {
        $c = new Criteria();
        $c->add(MessagePeer::RECIPIENT_ID, $this->getUser()->getId());
        $c->add(MessagePeer::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        $cc = clone $c;

        $c->addGroupByColumn(ThreadPeer::ID);
        $c->addJoin(ThreadPeer::ID, MessagePeer::THREAD_ID);
        $c->addJoin(MessagePeer::SENDER_ID, MemberPeer::ID, Criteria::LEFT_JOIN);
        $c->addDescendingOrderByColumn(ThreadPeer::UPDATED_AT);

        $this->pager = new prPropelPager('Thread', 10);
        $this->pager->setCriteria($c);
        $this->pager->setPage($this->getRequestParameter('page', 1));
        $this->pager->setPeerMethod('doSelectHydrateObject');
        $this->pager->init();

        $cc->add(MessagePeer::UNREAD, true);
        $cc->addGroupByColumn(MessagePeer::THREAD_ID);
        $rs = MessagePeer::doSelectRS($cc);
        $this->cnt_unread = $rs->getRecordCount();

        $profile = $this->member = $this->getUser()->getProfile();
        $this->truncateLimit = ($profile->getSex() == 'M'
                                && $profile->isFree()
                                && $profile->hasUnreadMessagesFromFreeFemales()) ? 12 : 80;

        $this->showDeleteConfirmation();
    }

    public function validateIndex()
    {
        return $this->validateDeleteMessages();
    }

    public function executeDrafts()
    {
        $this->getUser()->getBC()
             ->removeLast()->removeLast()
             ->add(array('name' => __('Draft Messages')));

        $c = new Criteria();
        $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENDER_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT);
        $c->addDescendingOrderByColumn(MessagePeer::UPDATED_AT);
        $c->add(MessagePeer::BODY, '', Criteria::NOT_EQUAL);

        $this->pager = new prPropelPager('Message', 10);
        $this->pager->setCriteria($c);
        $this->pager->setPage($this->getRequestParameter('page', 1));
        $this->pager->setPeerMethod('doSelectJoinMemberRelatedByRecipientId');
        $this->pager->init();

        $this->showDeleteConfirmation();
        $this->member = $this->getUser()->getProfile();
    }

    public function validateDrafts()
    {
        return $this->validateDeleteMessages();
    }

    public function executeSent()
    {
        $this->getUser()->getBC()
             ->removeLast()->removeLast()
             ->add(array('name' => __('Sent Headline')));

        $c = new Criteria();
        $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENDER_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->addJoin(MessagePeer::RECIPIENT_ID, MemberPeer::ID);
        $c->addJoin(ThreadPeer::ID, MessagePeer::THREAD_ID);
        $c->addGroupByColumn(ThreadPeer::ID);
        $c->addDescendingOrderByColumn(ThreadPeer::UPDATED_AT);

        $this->pager = new prPropelPager('Thread', 10);
        $this->pager->setCriteria($c);
        $this->pager->setPage($this->getRequestParameter('page', 1));
        $this->pager->setPeerMethod('doSelectHydrateObject');
        $this->pager->init();

        $this->showDeleteConfirmation();
        $this->member = $this->getUser()->getProfile();
    }

    public function validateSent()
    {
        return $this->validateDeleteMessages();
    }

    protected function showDeleteConfirmation()
    {
        if (($this->getRequestParameter('confirm_delete') || $this->getRequestParameter('confirm_delete_draft'))
            && count($this->getRequestParameter('selected', array())) > 0
        ) {
            $i18n = $this->getContext()->getI18N();
            $i18n_options = array(
                '%URL_FOR_CANCEL%' => 'javascript:window.history.go(-1);',
                '%URL_FOR_CONFIRM%' =>
                    'javascript:document.getElementById(\'' . $this->getRequestParameter('form_id') . '\').submit()'
            );
            $del_msg = $i18n->__(
                'Are you sure you want to delete selected message(s)? <a href="%URL_FOR_CANCEL%" class="sec_link">No</a> <a href="%URL_FOR_CONFIRM%" class="sec_link">Yes</a>',
                $i18n_options
            );
            $this->setFlash('msg_error', $del_msg, false);
        }
    }

    protected function validateDeleteMessages()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST
            && ($this->getRequestParameter('confirm_delete')
                || $this->getRequestParameter(
                    'confirm_delete_draft'
                ))
        ) {
            $selected = $this->getRequestParameter('selected', array());

            if (empty($selected)) {
                $backTo = $this->getRequestParameter('backto', 'index');
                $page = $this->getRequestParameter('page');
                $this->setFlash('msg_error', 'You must select at least one message to delete', false);
                $this->redirect('messages/' . $backTo . '?page=' . $page);
            }
        }

        return true;
    }

    public function executeSend()
    {
        $this->recipient = MemberPeer::retrieveByPK($this->getRequestParameter('recipient_id'));
        $this->forward404Unless($this->recipient);

        $this->sender = $this->getUser()->getProfile();

        if ($this->getRequestParameter('layout') == 'window') {
            sfConfig::set('sf_web_debug', false);
            $this->setLayout('window');
        }

        //execution stops here with redirect if there is an old thread already
        if ($ret = $this->needsToforceOneThread($this->sender, $this->recipient)) {
            return $ret;
        }

        $this->draft = MessagePeer::retrieveOrCreateDraft(
            $this->sender->getId(),
            $this->recipient->getId()
        );
        
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $send_msg = MessagePeer::send(
                $this->sender,
                $this->recipient,
                $this->getRequestParameter('content'),
                $this->draft->getId(),
                null, //thread
                PredefinedMessagePeer::retrieveByPK($this->getRequestParameter('predefined_message_id'))
            );

            $this->setFlashConfirmation($send_msg, false);
            return $this->renderText(get_partial('content/messages'));
        }

        
    }

    protected function needsToforceOneThread($sender, $recipient)
    {
        $old_thread = ThreadPeer::getOldThread($sender, $recipient);
        if ($old_thread) {
            $redirect_url = 'messages/thread?id=' . $old_thread->getId();

            if ($this->getRequest()->isXmlHttpRequest()) {
                return $this->renderText(get_partial('content/client_side_redirect', array('url' => $redirect_url)));
            } elseif ($this->getRequestParameter('layout') == 'window') {
                return $this->renderText(
                    get_partial('content/client_side_parent_redirect', array('url' => $redirect_url))
                );
            } else {
                $this->redirect($redirect_url);
            }
        }
    }

    protected function setFLashConfirmation(BaseMessage $sent_msg, $persist = true)
    {
        $to_username = $sent_msg->getMemberRelatedByRecipientId()->getUsername();

        $msg_ok = __(
            'Your message has been sent.',
            array(
                '%URL_TO_SENT_MESSAGE%' => $this->getController()->genUrl(
                        'messages/thread?id=' . $sent_msg->getThreadId() . '#message_' . $sent_msg->getId()
                    ),
                '%MEMBER_PROFILE_URL%' => $this->getController()->genUrl('@profile?username=' . $to_username),
                '%MEMBER_USERNAME%' => $to_username
            )
        );

        $this->setFlash('msg_ok', $msg_ok, $persist);
    }

    public function validateSend()
    {
        //validate only on form submition
        if ($this->getRequest()->getMethod() != sfRequest::POST) {
            return true;
        }

        $recipient = MemberPeer::retrieveByPK($this->getRequestParameter('recipient_id'));
        $this->forward404Unless($recipient);
        $sender = $this->getUser()->getProfile();

        if ($sender->getId() == $recipient->getId()) {
            $this->getRequest()->setError('message', 'You can\'t use this function on your own profile');
            return false;
        }

        //1. is the other member active ?
        if ($recipient->getmemberStatusId() != MemberStatusPeer::ACTIVE) {
            $this->getRequest()->setError('message', 'The member that you want to send a message to is not active.');
            return false;
        }

        //2. Privacy
        $prPrivacyValidator = new prPrivacyValidator();
        $prPrivacyValidator->setProfiles($sender, $recipient);
        $prPrivacyValidator->initialize(
            $this->getContext(),
            array(
                'block_error' => 'You can not send message to this member!',
                'sex_error' => 'Due to privacy restrictions you cannot send message to this profile',
                'onlyfull_error' => 'This member accept messages only from paid members!',
            )
        );

        $error = '';
        if (!$prPrivacyValidator->execute($value, $error)) {
            $this->getRequest()->setError('privacy', $error);
            return false;
        }

        $predefinedMessage = PredefinedMessagePeer::retrieveByPK($this->getRequestParameter('predefined_message_id'));
        if ($predefinedMessage) {
            return true;
        } //subscription limits ( below ) does not apply to predefined messages.

        //3. subscription limits/restrictions ?
        $subscription = $sender->getSubscriptionDetails();

        //we don't need to check the looking for field since privacy validator is already applied.
        if (sfConfig::get('app_settings_man_should_pay') && $sender->getSex() == 'M' && $sender->isFree()
            && $recipient->getSex() == 'F'
            && $recipient->isFree()
        ) {
            $this->getRequest()->setError(
                'subscription',
                'M4F: In order to send message you need to upgrade your membership.'
            );
            return false;
        }

        if (!$subscription->getCanSendMessages() && !$sender->isFree()) {
            $this->getRequest()->setError(
                'subscription',
                sprintf('%s: In order to send message you need to upgrade your membership.', $subscription->getTitle())
            );
            return false;
        }

        if ($sender->getCounter('SentMessagesDay') >= $subscription->getSendMessagesDay()) {
            $this->getRequest()->setError(
                'subscription',
                sprintf(
                    '%s: For the feature that you want to use - send message - you have reached the daily limit up to which you can use it with your membership. In order to send message, please upgrade your membership.',
                    $subscription->getTitle()
                )
            );
            return false;
        }

        if ($sender->getCounter('SentMessages') >= $subscription->getSendMessages()) {
            $this->getRequest()->setError(
                'subscription',
                sprintf(
                    '%s: For the feature that you want to use - send message - you have reached the limit up to which you can use it with your membership. In order to send message, please upgrade your membership.',
                    $subscription->getTitle()
                )
            );
            return false;
        }

        //all passed
        return true;
    }

    public function handleErrorSend()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->getResponse()->setStatusCode(400);
            return $this->renderText(get_partial('content/formErrors'));
        }

        if ($this->getRequestParameter('layout') == 'window') {
            sfConfig::set('sf_web_debug', false);
            $this->setLayout('window');
        }

        $this->recipient = MemberPeer::retrieveByPK($this->getRequestParameter('recipient_id'));
        $this->sender = $this->getUser()->getProfile();
        $this->draft = MessagePeer::retrieveOrCreateDraft(
            $this->sender->getId(),
            $this->recipient->getId()
        );

        return sfView::SUCCESS;
    }

    public function executeDelete()
    {
        $marked = $this->getRequestParameter('selected', array());
        $backTo = $this->getRequestParameter('backto', 'index');
        $page = $this->getRequestParameter('page');

        if (!empty($marked)) {
            //inbox
            $c = new Criteria();
            $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
            $c->add(MessagePeer::THREAD_ID, $marked, Criteria::IN);
            $c->add(MessagePeer::RECIPIENT_ID, $this->getUser()->getId());

            $c2 = new Criteria();
            $c2->add(MessagePeer::RECIPIENT_DELETED_AT, time());

            BasePeer::doUpdate($c, $c2, Propel::getConnection());

            //sent box
            $c = new Criteria();
            $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
            $c->add(MessagePeer::THREAD_ID, $marked, Criteria::IN);
            $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());

            $c2 = new Criteria();
            $c2->add(MessagePeer::SENDER_DELETED_AT, time());

            BasePeer::doUpdate($c, $c2, Propel::getConnection());
        }

        $this->setFlash('msg_ok', 'Selected message(s) has been deleted.');
        $this->redirect('messages/' . $backTo . '?page=' . $page);
    }

    public function executeDeleteDraft()
    {
        $marked = $this->getRequestParameter('selected', array());
        if (!empty($marked)) {
            $c = new Criteria();
            $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT);
            $c->add(MessagePeer::ID, $marked, Criteria::IN);
            $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
            MessagePeer::doDelete($c);
        }

        $this->setFlash('msg_ok', 'Selected message(s) has been deleted.');
        $this->redirect('messages/drafts');
    }

    public function executeDiscard()
    {
        $c = new Criteria();
        $c->add(MessagePeer::ID, $this->getRequestParameter('draft_id'));
        $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT);
        $draft = MessagePeer::doSelectOne($c);

        if ($draft) {
            $draft->delete();
        }

        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequestParameter('layout') == 'window') {
                $this->setFlash('msg_ok', 'Your message has been discarded.', false);
                return $this->renderText(get_partial('content/messages'));
            } else {
                $this->setFlash('msg_ok', 'Your message has been discarded.');
                return $this->renderText(get_partial('content/client_side_redirect', array('url' => 'messages/index')));
            }

        } else {
            $this->setFlash('msg_ok', 'Your message has been discarded.');
            $this->redirect('messages/index');
        }
    }

    public function executeThread()
    {
        $limit = 5;
        $member = $this->getUser()->getProfile();
        $thread = $member->retrieveThreadById($this->getRequestParameter('id'));
        $this->forward404Unless($thread);

        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        $c->addDescendingOrderByColumn(MessagePeer::ID);
        $c->setOffset(0);
        $c->setLimit($limit+1);
        $messages = array_reverse($thread->getMessages($c));
        if (count($messages) > $limit){
            array_shift($messages);
            $displayFetchLink = true;
        } else {
            $displayFetchLink = false;
        }

        $this->forward404Unless($messages);
        $message_sample = $messages[0];

        $profile = ($message_sample->getSenderId() == $member->getId())
            ? $message_sample->getMemberRelatedByRecipientId() : $message_sample->getMemberRelatedBySenderId();
        if ($profile) {
            $this->getUser()->getBC()->removeLast()->add(
                array(
                    'name' => __(
                        'Conversation between You and %USERNAME%',
                        array('%USERNAME%' => $profile->getUsername())
                    )
                )
            );
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $send_msg = MessagePeer::send(
                $member,
                $profile,
                $this->getRequestParameter('content'),
                $this->getRequestParameter('draft_id'),
                $thread,
                PredefinedMessagePeer::retrieveByPK($this->getRequestParameter('predefined_message_id'))
            );

            $this->setFlashConfirmation($send_msg);
            $this->redirect('messages/thread?id=' . $thread->getId());
        }

        MessagePeer::markAsReadInThread($thread->getId(), $member);
        if ($profile) {
            $this->draft = MessagePeer::retrieveOrCreateDraft(
                $member->getId(),
                $profile->getId(),
                $thread->getId()
            );
        }

        //template variables
        $this->thread = $thread;
        $this->member = $member;
        $this->profile = $profile;
        $this->messages = $messages;
        $this->limit = $limit;
        $this->displayFetchLink = $displayFetchLink;
    }

    public function validateThread()
    {
        $member = $this->getUser()->getProfile();
        $thread = $member->retrieveThreadById($this->getRequestParameter('id'));
        $this->forward404Unless($thread);

        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        $c->addDescendingOrderByColumn(MessagePeer::ID);
        $messages = $thread->getMessages($c);
        $this->forward404Unless($messages);
        $message_sample = $messages[0];

        $profile = ($message_sample->getSenderId() == $member->getId())
            ? $message_sample->getMemberRelatedByRecipientId() : $message_sample->getMemberRelatedBySenderId();
        $subscription = $member->getSubscriptionDetails();

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->limit = $this->getRequestParameter('limit');
            $this->displayFetchLink = $this->getRequestParameter('displayFetchLink');
            /* REPLYING TO THREAD */
            //1. is the other member active ?
            if ($profile->getMemberStatusId() != MemberStatusPeer::ACTIVE) {
                $this->getRequest()->setError(
                    'message',
                    'The member that you want to send a message to is not active.'
                );
                return false;
            }

            //2. Privacy
            $prPrivacyValidator = new prPrivacyValidator();
            $prPrivacyValidator->setProfiles($member, $profile);
            $prPrivacyValidator->initialize(
                $this->getContext(),
                array(
                    'block_error' => 'You can not send message to this member!',
                    'sex_error' => 'Due to privacy restrictions you cannot send message to this profile',
                    'check_onlyfull' => false,
                )
            );

            $error = '';
            if (!$prPrivacyValidator->execute($value, $error)) {
                $this->getRequest()->setError('privacy', $error);
                return false;
            }

            $predefinedMessage = PredefinedMessagePeer::retrieveByPK(
                $this->getRequestParameter('predefined_message_id')
            );
            if ($predefinedMessage) {
                return true;
            } //subscription limits ( below ) does not apply to predefined messages.

            //3. subscription limits/restrictions ?

            if (sfConfig::get('app_settings_man_should_pay')
                && $member->getSex() == 'M'
                && $member->isFree()
                && $profile->getSex() == 'F'
                && $profile->isFree()
            ) {
                $this->getRequest()->setError(
                    'subscription',
                    'M4F: In order to reply to message you need to upgrade your membership.'
                );
                return false;
            }

            if (!$subscription->getCanReplyMessages()) {
                $this->getRequest()->setError(
                    'subscription',
                    sprintf(
                        '%s: In order to reply to message you need to upgrade your membership.',
                        $subscription->getTitle()
                    )
                );
                return false;
            }

            if ($member->getCounter('ReplyMessagesDay') >= $subscription->getReplyMessagesDay()) {
                $this->getRequest()->setError(
                    'subscription',
                    sprintf(
                        '%s: For the feature that you want to use - reply to message - you have reached the daily limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.',
                        $subscription->getTitle()
                    )
                );
                return false;
            }

            if ($member->getCounter('ReplyMessages') >= $subscription->getReplyMessages()) {
                $this->getRequest()->setError(
                    'subscription',
                    sprintf(
                        '%s: For the feature that you want to use - reply to message - you have reached the limit up to which you can use it with your membership. In order to reply to message, please upgrade your membership.',
                        $subscription->getTitle()
                    )
                );
                return false;
            }


        } else {
            /* THREAD VIEW */

            if (!$profile) {
                return true;
            } //system message
            if (!$profile->isActive()) {
                $this->setFlash(
                    'msg_error',
                    __('%USERNAME%\'s Profile is not longer available', array('%USERNAME%' => $profile->getUsername())),
                    false
                );
            }

            //break/leave if there is no UNread messages
            $cnt_unread = MessagePeer::countUnreadInThreadExcludePredefined($thread->getId(), $member);
            if ($cnt_unread == 0) {
                return true;
            }


            if (sfConfig::get('app_settings_man_should_pay')
                && $member->getSex() == 'M'
                && $member->isFree()
                && $profile->getSex() == 'F'
                && $profile->isFree()
            ) {
                $this->setFlash('msg_error', 'M4F: In order to read a message you need to upgrade your membership.');
                if ($this->getRequestParameter('return_to_profile')) {
                    $this->redirect('@profile?username=' . $profile->getUsername());
                }
                $this->redirect('messages/index');
            }

            if (!$subscription->getCanReadMessages()) {
                $this->setFlash(
                    'msg_error',
                    sprintf(
                        '%s: In order to read a message you need to upgrade your membership.',
                        $subscription->getTitle()
                    )
                );
                $this->redirect('messages/index');
            } elseif ($member->isFree() && $profile->isFree()
                      && !$profile->getSubscriptionDetails()->getCanSendMessages()
            ) {
                //received by FREE member with send messages OFF
                $this->setFlash(
                    'msg_error',
                    'Sender of the message is not a paid member. At least one of you must be a paid member for either send or receive messages.'
                );
                $this->redirect('messages/index');
            }

            if ($member->getCounter('ReadMessagesDay') >= $subscription->getReadMessagesDay()) {
                $this->setFlash(
                    'msg_error',
                    sprintf(
                        '%s: For the feature that you want to use - read a message - you have reached the daily limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.',
                        $subscription->getTitle()
                    )
                );
                $this->redirect('messages/index');
            }

            if ($member->getCounter('ReadMessages') >= $subscription->getReadMessages()) {
                $this->setFlash(
                    'msg_error',
                    sprintf(
                        '%s: For the feature that you want to use - read a message - you have reached the limit up to which you can use it with your membership. In order to read a message, please upgrade your membership.',
                        $subscription->getTitle()
                    )
                );
                $this->redirect('messages/index');
            }
        }


        return true;
    }

    public function handleErrorThread()
    {
        $member = $this->getUser()->getProfile();
        $thread = $member->retrieveThreadById($this->getRequestParameter('id'));
        $this->forward404Unless($thread);

        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $c->addDescendingOrderByColumn(MessagePeer::ID);
            $c->setLimit($this->getRequestParameter('numberOfMessages'));
            $messages = array_reverse($thread->getMessages($c));
        } else {
            $messages = $thread->getMessages($c);
        }
        $this->forward404Unless($messages);
        $message_sample = $messages[0];

        $profile = ($message_sample->getSenderId() == $member->getId())
            ? $message_sample->getMemberRelatedByRecipientId() : $message_sample->getMemberRelatedBySenderId();

        if ($profile) {
            $this->getUser()->getBC()->removeLast()->add(
                array(
                    'name' => __(
                        'Conversation between You and %USERNAME%',
                        array('%USERNAME%' => $profile->getUsername())
                    )
                )
            );
        }

        $this->draft = MessagePeer::retrieveOrCreateDraft(
            $member->getId(),
            $profile->getId(),
            $thread->getId()
        );
        $this->content = $this->getRequestParameter('content');

        //template variables
        $this->thread = $thread;
        $this->member = $member;
        $this->profile = $profile;
        $this->messages = $messages;

        return sfView::SUCCESS;
    }

    public function executeGetMoreMessages()
    {
        $limit = 5;
        $member = $this->getUser()->getProfile();
        $thread = $member->retrieveThreadById($this->getRequestParameter('id'));

        $offset = $this->getRequest()->getParameter('offset', 0);
        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        $c->addDescendingOrderByColumn(MessagePeer::ID);
        $c->setOffset(intval($offset));
        $c->setLimit($limit+1);
        $messages = array_reverse($thread->getMessages($c));

        if (count($messages) > $limit){
            array_shift($messages);
            $displayFetchLink = true;
        } else {
            $displayFetchLink = false;
        }

        $message_sample = $messages[0];
        $profile = ($message_sample->getSenderId() == $member->getId())
            ? $message_sample->getMemberRelatedByRecipientId() : $message_sample->getMemberRelatedBySenderId();
        $this->messages = $messages;
        $this->member = $member;
        $this->profile = $profile;
        $this->getResponse()->setHttpHeader('displayFetchLink', $displayFetchLink);
        $this->getResponse()->setHttpHeader('numberOfMessages', count($messages));

        return $this->renderText(
            get_partial(
                'get_messages',
                array('messages' => $messages, 'member' => $member, 'profile' => $profile)
            ));
    }
}
