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

        $criteria->addAsColumn('mail', '(SELECT IF(msg.sent_box = 1, "SM", "RM") FROM message AS msg WHERE (msg.from_member_id = member_match.MEMBER1_ID AND msg.to_member_id = member_match.MEMBER2_ID AND msg.sent_box = 1) OR (msg.from_member_id = member_match.MEMBER2_ID AND msg.to_member_id = member_match.MEMBER1_ID AND msg.sent_box = 0) ORDER BY msg.created_at DESC LIMIT 1)');
        $criteria->addAsColumn('wink', '(SELECT IF(wink.sent_box = 1, "SW", "RW") FROM wink WHERE (wink.member_id = member_match.MEMBER1_ID AND wink.profile_id = member_match.MEMBER2_ID AND wink.sent_box = 1) OR (wink.member_id = member_match.MEMBER2_ID AND wink.profile_id = member_match.MEMBER1_ID AND wink.sent_box = 0) ORDER BY wink.created_at DESC LIMIT 1)');
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

        $c->addJoin(MemberMatchPeer::MEMBER2_ID, MemberPeer::ID);
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

        $c->addJoin(MemberMatchPeer::MEMBER2_ID, MemberPeer::ID);
        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {
            $results[] = $rs->getString(1);
        }
        return $results;
    }    
}
