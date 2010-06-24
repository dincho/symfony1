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
         
}
