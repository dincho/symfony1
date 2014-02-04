<?php
class messagesComponents extends sfComponents
{
    public function executeSelectPredefinedMessage()
    {
        $member = $this->getUser()->getProfile();
        
        $c = new Criteria();
        $c->add(PredefinedMessagePeer::CATALOG_ID, $this->getUser()->getCatalogId());
        $crit1 = $c->getNewCriterion(PredefinedMessagePeer::SEX, $member->getSex());
        $crit1->addOr($c->getNewCriterion(PredefinedMessagePeer::SEX, ''));
        
        $crit2 = $c->getNewCriterion(PredefinedMessagePeer::LOOKING_FOR, $member->getLookingFor());
        $crit2->addOr($c->getNewCriterion(PredefinedMessagePeer::LOOKING_FOR, ''));
        
        $c->add($crit1);        
        $c->add($crit2);
        
        $this->messages = PredefinedMessagePeer::doSelect($c);
        
        $js_options = array();
        foreach($this->messages as $message)
        {
            $js_options[$message->getId()] = array('body' => $message->getBody());
        }
        
        $this->js_options = json_encode($js_options);
    }

    public function executeNavigation()
    {
        $c = new Criteria();
        $c->add(MessagePeer::RECIPIENT_ID, $this->getUser()->getId());
        $c->add(MessagePeer::RECIPIENT_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
        $c->add(MessagePeer::UNREAD, true);
        $c->addGroupByColumn(MessagePeer::THREAD_ID);
        $rs = MessagePeer::doSelectRS($c);
        $this->cntUnread = $rs->getRecordCount();

        $c = new Criteria();
        $c->add(MessagePeer::SENDER_ID, $this->getUser()->getId());
        $c->add(MessagePeer::SENDER_DELETED_AT, null, Criteria::ISNULL);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT);
        $c->addDescendingOrderByColumn(MessagePeer::UPDATED_AT);

        $c->add(MessagePeer::BODY, '', Criteria::NOT_EQUAL);

        $rs = MessagePeer::doSelectRS($c);
        $this->cntDrafts = $rs->getRecordCount();
    }
}
