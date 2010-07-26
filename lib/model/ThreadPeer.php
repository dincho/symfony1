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

            $results[] = $obj1;
        }
        return $results;
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
