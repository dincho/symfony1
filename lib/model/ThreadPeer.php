<?php

/**
 * Subclass for performing query and update operations on the 'thread' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ThreadPeer extends BaseThreadPeer
{

    public static function doSelectHydrateObject(Criteria $c, $con = null)
    {
        $c = clone $c;

        if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        ThreadPeer::addSelectColumns($c);
        $startcol = (ThreadPeer::NUM_COLUMNS - ThreadPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        MemberPeer::addSelectColumns($c);
        
        $c->addAsColumn('unread', 'SUM('.MessagePeer::UNREAD.')');
        $unread_index = $startcol + (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS);
        
        self::addCountMessagesColumn($c);
        $cntMessagesIndex = $unread_index+1;

        self::addCountDraftColumn($c);
        $cntDrafts = $cntMessagesIndex+1;

        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {

            $omClass = ThreadPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);

            

            if( $rs->get($startcol) )
            {
                $omClass = MemberPeer::getOMClass();
                $cls = Propel::import($omClass);
                $obj2 = new $cls();
                $obj2->hydrate($rs, $startcol);
                $obj1->object = $obj2;
            } else {
                $obj1->object = null;
            }

            $obj1->unread = $rs->getInt($unread_index);
            $obj1->setCntMessages($rs->getInt($cntMessagesIndex));
            $obj1->setCntDrafts($rs->getInt($cntDrafts));

            $results[] = $obj1;
        }
        return $results;
    }
    
    private static function addCountMessagesColumn(Criteria $c)
    {
        $sql = 'SELECT COUNT(*) FROM message WHERE message.thread_id = thread.id';
        
        if ($c->containsKey(MessagePeer::RECIPIENT_ID)) {
            $sql .= ' AND message.type != ' . MessagePeer::TYPE_DRAFT . '
                      AND message.recipient_deleted_at IS NULL';
        } elseif ($c->containsKey(MessagePeer::SENDER_ID)) {
            $sql .= ' AND message.type != ' . MessagePeer::TYPE_DRAFT . '
                      AND message.sender_deleted_at IS NULL';
        } else {
            throw new Exception("Unsuppoted query");
        }

        $c->addAsColumn('cntMessages', '('. $sql .')');
    }

    private static function addCountDraftColumn(Criteria $c)
    {
        $sql = 'SELECT COUNT(*) FROM message m2
                WHERE m2.thread_id = thread.id 
                AND m2.type = ' . MessagePeer::TYPE_DRAFT .
                ' AND NOT (m2.subject IS NULL OR m2.body IS NULL)';
        
        if ($c->containsKey(MessagePeer::RECIPIENT_ID)) {
            $sql .= ' AND m2.sender_id = ' . $c->getValue(MessagePeer::RECIPIENT_ID);
        } elseif ($c->containsKey(MessagePeer::SENDER_ID)) {
            $sql .= ' AND m2.recipient_id = ' . $c->getValue(MessagePeer::SENDER_ID);
        } else {
            throw new Exception("Unsuppoted query");
        }

        $c->addAsColumn('cntDrafts', '('. $sql .')');
    }

    public static function getOldThreadCriteria(BaseMember $sender, BaseMember $recipient, Criteria $crit = null)
    {
        $c  = (is_null($crit)) ? new Criteria() : clone $crit;
        
        $c->addJoin(ThreadPeer::ID, MessagePeer::THREAD_ID);
        $c->addGroupByColumn(ThreadPeer::ID);
        $c->add(MessagePeer::TYPE, MessagePeer::TYPE_DRAFT, Criteria::NOT_EQUAL);
                
        $crit = $c->getNewCriterion(MessagePeer::RECIPIENT_ID, $sender->getId());
        $crit->addAnd($c->getNewCriterion(MessagePeer::RECIPIENT_DELETED_AT, null, Criteria::ISNULL));
        $crit->addAnd($c->getNewCriterion(MessagePeer::SENDER_ID, $recipient->getId()));

        $crit2 = $c->getNewCriterion(MessagePeer::SENDER_ID, $sender->getId());
        $crit2->addAnd($c->getNewCriterion(MessagePeer::SENDER_DELETED_AT, null, Criteria::ISNULL));
        $crit2->addAnd($c->getNewCriterion(MessagePeer::RECIPIENT_ID, $recipient->getId()));
    
        $crit->addOr($crit2);
        $c->addAnd($crit);
        $c->addDescendingOrderByColumn(ThreadPeer::CREATED_AT);
        
        return $c;
    }
    
    public static function getOldThread(BaseMember $sender, BaseMember $recipient, Criteria $crit = null)
    {
        $c = self::getOldThreadCriteria($sender, $recipient, $crit);
        return ThreadPeer::doSelectOne($c);
    }
    
    public static function countOldThreads(BaseMember $sender, BaseMember $recipient, Criteria $crit = null)
    {
        $c = self::getOldThreadCriteria($sender, $recipient, $crit);
        return ThreadPeer::doCount($c);
    }
}
