<?php
/**
 * messages actions.
 *
 * @package    pr
 * @subpackage messages
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class messagesActions extends sfActions
{

    public function preExecute()
    {
        $this->left_menu_selected = 'Messages';
        $this->getUser()->getBC()->replaceLast(array('name' => 'List', 'uri' => 'messages/list?filter=filter'));
        
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/messages/filters');

    }

    public function executeList()
    {
        $this->getResponse()->addJavascript('preview.js');
        $this->processSort();
        
        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('Message', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinMemberRelatedBySenderId');
        $pager->setPeerCountMethod('doCountJoinMemberRelatedBySenderId');
        $pager->init();
        $this->pager = $pager;
    
    }
    
    public function executeMember()
    {
        $this->member = MemberPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($this->member);
        
        $this->getResponse()->addJavascript('preview.js');
        $this->getUser()->getBC()->replaceLast(array('name' => $this->member->getUsername(), 'uri' => 'messages/member?id=' . $this->member->getId()));
        
        $c = new Criteria();
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $this->addFiltersCriteria($c);
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        
        //sent or received messages ( defaults to sent )
        if ($this->getRequestParameter('received_only'))
        {
            $c->add(MessagePeer::RECIPIENT_ID, $this->member->getId());
        } else
        {
            $c->add(MessagePeer::SENDER_ID, $this->member->getId());
        }
        

        $pager = new sfPropelPager('Message', $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page')));
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinMemberRelatedBySenderId');
        $pager->setPeerCountMethod('doCount');
        $pager->init();
        $this->pager = $pager;
    }

    public function executeDelete()
    {
        $marked = $this->getRequestParameter('marked', false);
        if (is_array($marked) && ! empty($marked))
        {
            $c = new Criteria();
            $c->add(MessagePeer::ID, $marked, Criteria::IN);
            MessagePeer::doDelete($c);
        }
        
        $this->setFlash('msg_ok', 'Selected messages has been deleted.');
        $received_only = ($this->getRequestParameter('received_only')) ? 1 : 0;
        $member_id = $this->getRequestParameter('member_id');
        $this->redirect('messages/member?received_only=' . $received_only . '&id=' . $member_id);
    }

    public function executeConversation()
    {
        $this->getResponse()->addJavascript('show_hide.js');
        $member = MemberPeer::retrieveByPK($this->getRequestParameter('member_id'));
        $this->forward404Unless($member);
        
        $c = new Criteria();
        $c->add(MessagePeer::THREAD_ID, $this->getRequestParameter('id'));
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_NORMAL);
        $c->addAscendingOrderByColumn(MessagePeer::CREATED_AT);
        $messages = MessagePeer::doSelect($c);
        
        $this->forward404Unless($messages); //empty thread ?
        
        $message_sample = $messages[0];
        $profile  = ( $message_sample->getSenderId() == $member->getId() ) ? $message_sample->getMemberRelatedByRecipientId() : $message_sample->getMemberRelatedBySenderId();
        
        //mark messages as reviewed if not
        $select = clone $c;
        $select->add(MessagePeer::THREAD_ID, $this->getRequestParameter('id'));
        $select->add(MessagePeer::IS_REVIEWED, false);
        
        $update = new Criteria();
        $update->add(MessagePeer::IS_REVIEWED, true);
        BasePeer::doUpdate($select, $update, Propel::getConnection());
        
        $this->member = $member;
        $this->profile = $profile;
        $this->messages = $messages;
        $this->thread = $message_sample->getThread();
        
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => $member->getUsername(), 'uri' => 'messages/member?id=' . $member->getId()));
        $bc->add(array('name' => 'Conversation with ' . $profile->getUsername(), 'uri' => '#'));
    }

    protected function processSort()
    {
        $this->sort_namespace = 'backend/messages/sort';
        
        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }
        
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'Message::created_at', $this->sort_namespace); //default sort column
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

    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            //print_r($filters);exit();
            if (isset($filters['date_from']) && $filters['date_from'] !== '')
            {
                list($m, $d, $y) = explode('/', $filters['date_from']);
                $filters['date_from'] = mktime(0, 0, 0, $m, $d, $y);
            }
            if (isset($filters['date_to']) && $filters['date_to'] !== '')
            {
                list($m, $d, $y) = explode('/', $filters['date_to']);
                $filters['date_to'] = mktime(0, 0, 0, $m, $d, $y);
            }
            
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/messages/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/messages/filters');
        }
    }

    protected function addFiltersCriteria($c)
    {
        $bc = $this->getUser()->getBC();
        
/*        if (isset($this->filters['starred']))
        {
            $c->add(MessagePeer::IS_STARRED, $this->filters['starred'], Criteria::IN);
        }
*/
        if (isset($this->filters['search_type']) && isset($this->filters['search_query']) && strlen($this->filters['search_query']) > 0)
        {
            switch ($this->filters['search_type']) {
                case 'first_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'messages/list?filter=filter'));
                    $c->add(MemberPeer::FIRST_NAME, $this->filters['search_query']);
                    ;
                    break;
                case 'last_name':
                    $bc->add(array('name' => 'Search', 'uri' => 'messages/list?filter=filter'));
                    $c->add(MemberPeer::LAST_NAME, $this->filters['search_query']);
                    ;
                    break;
                case 'email':
                    $bc->add(array('name' => 'Search', 'uri' => 'messages/list?filter=filter'));
                    $c->add(MemberPeer::EMAIL, $this->filters['search_query']);
                    break;                
                default:
                    $bc->add(array('name' => 'Search', 'uri' => 'messages/list?filter=filter'));
                    $c->add(MemberPeer::USERNAME, $this->filters['search_query']);
                    ;
                    break;
            }
        }
        
        if (isset($this->filters['date_from']) && isset($this->filters['date_to']))
        {
            $c->add(MessagePeer::CREATED_AT, date('Y-m-d 00:00:00', (int) $this->filters['date_from']), Criteria::GREATER_EQUAL);
            $c->addAnd(MessagePeer::CREATED_AT, date('Y-m-d 23:59:59', (int) $this->filters['date_to']), Criteria::LESS_EQUAL);
        }
    }
}
