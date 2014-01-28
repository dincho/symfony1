<?php

/**
 * Subclass for performing query and update operations on the 'flag' table.
 *
 * 
 *
 * @package lib.model
 */ 
class FlagPeer extends BaseFlagPeer
{
    public static function doSelectJoinAll(Criteria $c, $con = null)
    {
        return self::doSelectJoinAllFlagger($c, $con);
    }
    
    public static function doSelectJoinAllFlagger(Criteria $c, $con = null)
    {
        $c = clone $c;

                if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        FlagPeer::addSelectColumns($c);
        $startcol2 = (FlagPeer::NUM_COLUMNS - FlagPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

        MemberPeer::addSelectColumns($c);
        $startcol3 = $startcol2 + MemberPeer::NUM_COLUMNS;

        $c->addJoin(FlagPeer::FLAGGER_ID, MemberPeer::ID);

        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {

            $omClass = FlagPeer::getOMClass();
            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);

            $omClass = MemberPeer::getOMClass();
            $cls = Propel::import($omClass);
            $obj3 = new $cls();
            $obj3->hydrate($rs, $startcol2);

            $newObject = true;
            for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
                $temp_obj1 = $results[$j];
                $temp_obj3 = $temp_obj1->getMemberRelatedByFlaggerId();                 if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
                    $newObject = false;
                    $temp_obj3->addFlagRelatedByFlaggerId($obj1);                   break;
                }
            }

            if ($newObject) {
                $obj3->initFlagsRelatedByFlaggerId();
                $obj3->addFlagRelatedByFlaggerId($obj1);
            }

            $results[] = $obj1;
        }
        return $results;
    }
    
    public static function doSelectJoinAllFlagged(Criteria $c, $con = null)
    {
        $c = clone $c;

                if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        FlagPeer::addSelectColumns($c);
        $startcol2 = (FlagPeer::NUM_COLUMNS - FlagPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

        MemberPeer::addSelectColumns($c);
        $startcol3 = $startcol2 + MemberPeer::NUM_COLUMNS;

        $c->addJoin(FlagPeer::MEMBER_ID, MemberPeer::ID);

        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {

            $omClass = FlagPeer::getOMClass();
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
                $temp_obj2 = $temp_obj1->getMemberRelatedByMemberId();              if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
                    $newObject = false;
                    $temp_obj2->addFlagRelatedByMemberId($obj1);                    break;
                }
            }

            if ($newObject) {
                $obj2->initFlagsRelatedByMemberId();
                $obj2->addFlagRelatedByMemberId($obj1);
            }

            $results[] = $obj1;
        }
        return $results;
    }

    public static function doSelectFlaggers(Criteria $criteria, $con = null)
    {
        $rs = FlagPeer::doSelectRS($criteria, $con);
        $results = array();
        while ($rs->next())
        {
            $flag = new Flag();
            $lastColumn = $flag->hydrate($rs);
            
            $flag->num_members = $rs->getInt($lastColumn);
            $results[] = $flag;
        }
        
        return $results;
    }
    
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
    {
        $criteria = clone $criteria;

                $criteria->clearSelectColumns()->clearOrderByColumns();
        if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->addSelectColumn(FlagPeer::COUNT_DISTINCT);
        } else {
            $criteria->addSelectColumn(FlagPeer::COUNT);
        }

                foreach($criteria->getGroupByColumns() as $column)
        {
            $criteria->addSelectColumn($column);
        }

        $criteria->addJoin(FlagPeer::MEMBER_ID, MemberPeer::ID);

        $criteria->addJoin(FlagPeer::FLAGGER_ID, MemberPeer::ID);

        $rs = FlagPeer::doSelectRS($criteria, $con);
        if ($rs->next()) {
            return $rs->getInt(1);
        } else {
                        return 0;
        }
    }    
}
