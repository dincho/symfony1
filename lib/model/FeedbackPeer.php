<?php

/**
 * Subclass for performing query and update operations on the 'feedback' table.
 *
 * 
 *
 * @package lib.model
 */ 
class FeedbackPeer extends BaseFeedbackPeer
{
    const INBOX = 1;
    const SENT  = 2;
    const DRAFT = 3;
    const TRASH = 4;
    
    const BUGS_SUGGESIONS_ADDRESS = 'bugs_suggestions@polishdate.com';
    const SUPPORT_ADDRESS = 'support@polishdate.com';
    
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
    {
        $criteria = clone $criteria;

                $criteria->clearSelectColumns()->clearOrderByColumns();
        if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->addSelectColumn(FeedbackPeer::COUNT_DISTINCT);
        } else {
            $criteria->addSelectColumn(FeedbackPeer::COUNT);
        }

                foreach($criteria->getGroupByColumns() as $column)
        {
            $criteria->addSelectColumn($column);
        }

        $criteria->addJoin(FeedbackPeer::MEMBER_ID, MemberPeer::ID, Criteria::LEFT_JOIN);

        $rs = FeedbackPeer::doSelectRS($criteria, $con);
        if ($rs->next()) {
            return $rs->getInt(1);
        } else {
                        return 0;
        }
    }


    
    public static function doSelectJoinAll(Criteria $c, $con = null)
    {
        $c = clone $c;

                if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        FeedbackPeer::addSelectColumns($c);
        $startcol2 = (FeedbackPeer::NUM_COLUMNS - FeedbackPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

        MemberPeer::addSelectColumns($c);
        $startcol3 = $startcol2 + MemberPeer::NUM_COLUMNS;

        $c->addJoin(FeedbackPeer::MEMBER_ID, MemberPeer::ID, Criteria::LEFT_JOIN);

        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {

            $omClass = FeedbackPeer::getOMClass();


            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);


                    
            $omClass = MemberPeer::getOMClass();


            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol2);

            $newObject = true;
            for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
                $temp_obj1 = $results[$j];
                $temp_obj2 = $temp_obj1->getMember();               if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
                    $newObject = false;
                    $temp_obj2->addFeedback($obj1);                     break;
                }
            }

            if ($newObject) {
                $obj2->initFeedbacks();
                $obj2->addFeedback($obj1);
            }

            $results[] = $obj1;
        }
        return $results;
    }  
}
