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
        $c = new Criteria();
        $c->add(MessagePeer::SENT_BOX, true);
        $this->addFiltersCriteria($c);
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('Message', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinMemberRelatedByFromMemberId');
        $pager->setPeerCountMethod('doCount');
        $pager->init();
        $this->pager = $pager;
                
    }
    
    public function executeMember()
    {
        $this->member = MemberPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($this->member);
        
        $this->getResponse()->addJavascript('preview.js');
        $this->getUser()->getBC()->replaceLast(array('name' => $this->member->getUsername(), 'uri' => 'messages/member?id=' . $this->member->getId()) );
        
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        
        //$bc = $this->getUser()->getBC();
        
        //sent or received messages ( defaults to sent )
        if( $this->getRequestParameter('received_only') )
        {
            $c->add(MessagePeer::TO_MEMBER_ID, $this->member->getId());
            $c->add(MessagePeer::SENT_BOX, false);
            //$c->add(Messa)
            //$bc->add(array('name' => 'Received', 'uri' => 'messages/member?received_only=1&id=' . $this->member->getId()));
        } else {
            $c->add(MessagePeer::FROM_MEMBER_ID, $this->member->getId());
            $c->add(MessagePeer::SENT_BOX, false);
            //$bc->add(array('name' => 'Sent', 'uri' => 'messages/member?id=' . $this->member->getId()));
        }
        
        $this->messages = MessagePeer::doSelectJoinMemberRelatedByFromMemberId($c);        
    }
    
    public function executeDelete()
    {
        $marked = $this->getRequestParameter('marked', false);
        if (is_array($marked) && ! empty($marked))
        {
            //perm delete trashed emails
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
        $message = MessagePeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($message);
        
        $c = new Criteria();
        
        if( $this->getRequestParameter('received_only') )
        {
            $sender = $message->getMemberRelatedByToMemberId();
            $recipient = $message->getMemberRelatedByFromMemberId();
        } else {
            $sender = $message->getMemberRelatedByFromMemberId();
            $recipient = $message->getMemberRelatedByToMemberId();
        }
        
        $crit = $c->getNewCriterion(MessagePeer::TO_MEMBER_ID, $recipient->getId());
        $crit->addAnd($c->getNewCriterion(MessagePeer::FROM_MEMBER_ID, $sender->getId()));
        
        $crit2 = $c->getNewCriterion(MessagePeer::TO_MEMBER_ID, $sender->getId());
        $crit2->addAnd($c->getNewCriterion(MessagePeer::FROM_MEMBER_ID, $recipient->getId()));
        
        $c->add($crit);
        $c->addOr($crit2);
        
        $c->addAscendingOrderByColumn(MessagePeer::CREATED_AT);
        $c->add(MessagePeer::SENT_BOX, false);
        
        $this->messages = MessagePeer::doSelect($c);
        
        //mark messages as reviewed if not
        $select = clone $c;
        $select->add(MessagePeer::IS_REVIEWED, false);
        
        $update = new Criteria();
        $update = $c->add(MessagePeer::IS_REVIEWED, true);
        BasePeer::doUpdate($select, $update, Propel::getConnection());
        
        $this->member = $sender;
        $this->recipient = $recipient;
        
        $bc = $this->getUser()->getBC();
        $bc->replaceLast(array('name' => $sender->getUsername(), 'uri' => 'messages/member?id=' . $sender->getId()) );
        $bc->add(array('name' => 'Conversation with ' . $recipient->getUsername(), 'uri' => '#'));
    }
    
    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/messages/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/messages/filters');
        }
    }
    
    protected function addFiltersCriteria($c)
    {
        $bc = $this->getUser()->getBC();
        
        if (isset($this->filters['search_type']) && isset($this->filters['search_query']) )
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
                
                default:
                    $bc->add(array('name' => 'Search', 'uri' => 'messages/list?filter=filter'));
                    $c->add(MemberPeer::USERNAME, $this->filters['search_query']);
                ;
                break;
            }
        }        
    }    
}
