<?php

/**
 * Subclass for performing query and update operations on the 'member_match' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberMatchPeer extends BaseMemberMatchPeer
{
    public static function addSelectColumns(Criteria $criteria)
    {

        $criteria->addSelectColumn(MemberMatchPeer::ID);

        $criteria->addSelectColumn(MemberMatchPeer::MEMBER1_ID);

        $criteria->addSelectColumn(MemberMatchPeer::MEMBER2_ID);

        $criteria->addSelectColumn(MemberMatchPeer::PCT);
        
        $criteria->addAsColumn('reverse_pct', '(SELECT m2.pct
                                                    FROM member_match AS m2 
                                                    WHERE m2.member1_id = member_match.member2_id AND m2.member2_id = member_match.member1_id 
                                                    )');

        //$criteria->addAsColumn('last_action', 'last_action(member_match.member1_id, member_match.member2_id)');
    }
    
    public static function doSelectJoinMemberRelatedByMember2Id(Criteria $c, $con = null)
    {
        $c = clone $c;

                if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        MemberMatchPeer::addSelectColumns($c);
        $startcol = (MemberMatchPeer::NUM_COLUMNS - MemberMatchPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        MemberPeer::addSelectColumns($c);

        $c->addJoin(MemberMatchPeer::MEMBER2_ID, MemberPeer::ID, Criteria::LEFT_JOIN);
        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {

            $omClass = MemberMatchPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs, 1, MemberPeer::NUM_COLUMNS);

            $omClass = MemberPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol);

            $newObject = true;
            foreach($results as $temp_obj1) {
                $temp_obj2 = $temp_obj1->getMemberRelatedByMember2Id();                 if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
                    $newObject = false;
                                        $temp_obj2->addMemberMatchRelatedByMember2Id($obj1);                    break;
                }
            }
            if ($newObject) {
                $obj2->initMemberMatchsRelatedByMember2Id();
                $obj2->addMemberMatchRelatedByMember2Id($obj1);             }
            $results[] = $obj1;
        }
        return $results;
    }   
     
    public static function doSelectJoinMemberRelatedByMember2IdRS(Criteria $c, $con = null)
    {
        $c = clone $c;

        if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        MemberMatchPeer::addSelectColumns($c);
        
        $c->clearSelectColumns()->addAsColumn('reverse_pct', '(SELECT m2.pct
                                                    FROM member_match AS m2 
                                                    WHERE m2.member1_id = member_match.member2_id AND m2.member2_id = member_match.member1_id 
                                                    )');
                
        $c->addSelectColumn(MemberPeer::USERNAME);

        $c->addJoin(MemberMatchPeer::MEMBER2_ID, MemberPeer::ID, Criteria::LEFT_JOIN);
        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {
            $results[] = $rs->getString(1);
        }
        return $results;
    }
    
    
    public static function doCountJoinMemberRelatedByMember2IdReverse(Criteria $crit, $distinct = false, $con = null)
    {
        $criteria = new Criteria();
        $criteria->add(MemberMatchPeer::MEMBER1_ID, $crit->get(MemberMatchPeer::MEMBER1_ID));
        
        if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
          $criteria->addSelectColumn(MemberMatchPeer::COUNT_DISTINCT);
        } else {
          $criteria->addSelectColumn(MemberMatchPeer::COUNT);
        }

        foreach($criteria->getGroupByColumns() as $column)
        {
          $criteria->addSelectColumn($column);
        }

        
        $criteria->add(MemberMatchPeer::ID, '(SELECT m2.pct
                                              FROM member_match AS m2
                                              WHERE m2.member1_id = member_match.member2_id
                                              AND m2.member2_id = member_match.member1_id) > 0', Criteria::CUSTOM);
        $criteria->addJoin(MemberMatchPeer::MEMBER2_ID, MemberPeer::ID, Criteria::LEFT_JOIN);                                    
        $rs = MemberMatchPeer::doSelectRS($criteria, $con);
        return ($rs->next()) ? $rs->getInt(1) : 0;
    }        
}
