<?php

/**
 * Subclass for performing query and update operations on the 'wink' table.
 *
 * 
 *
 * @package lib.model
 */ 
class WinkPeer extends BaseWinkPeer
{
    /*
     * @FIXME below 2 method are added because sfPropelBehavior do not work as expected
     * @see http://trac.symfony-project.org/ticket/5587 
     */
    
    public static function doSelectJoinMemberRelatedByMemberId(Criteria $c, $con = null)
    {
        $c = clone $c;

                if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        //templorary fix by Dincho because of incorrect hooks
        $c->add(WinkPeer::DELETED_AT, NULL, Criteria::ISNULL);
        
        WinkPeer::addSelectColumns($c);
        $startcol = (WinkPeer::NUM_COLUMNS - WinkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        MemberPeer::addSelectColumns($c);

        $c->addJoin(WinkPeer::MEMBER_ID, MemberPeer::ID);
        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {

            $omClass = WinkPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);

            $omClass = MemberPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol);

            $newObject = true;
            foreach($results as $temp_obj1) {
                $temp_obj2 = $temp_obj1->getMemberRelatedByMemberId();              if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
                    $newObject = false;
                                        $temp_obj2->addWinkRelatedByMemberId($obj1);                    break;
                }
            }
            if ($newObject) {
                $obj2->initWinksRelatedByMemberId();
                $obj2->addWinkRelatedByMemberId($obj1);             }
            $results[] = $obj1;
        }
        return $results;
    }


    
    public static function doSelectJoinMemberRelatedByProfileId(Criteria $c, $con = null)
    {
        $c = clone $c;

                if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        //templorary fix by Dincho because of incorrect hooks
        $c->add(WinkPeer::DELETED_AT, NULL, Criteria::ISNULL);
        
        WinkPeer::addSelectColumns($c);
        $startcol = (WinkPeer::NUM_COLUMNS - WinkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        MemberPeer::addSelectColumns($c);

        $c->addJoin(WinkPeer::PROFILE_ID, MemberPeer::ID);
        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {

            $omClass = WinkPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);

            $omClass = MemberPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol);

            $newObject = true;
            foreach($results as $temp_obj1) {
                $temp_obj2 = $temp_obj1->getMemberRelatedByProfileId();                 if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
                    $newObject = false;
                                        $temp_obj2->addWinkRelatedByProfileId($obj1);                   break;
                }
            }
            if ($newObject) {
                $obj2->initWinksRelatedByProfileId();
                $obj2->addWinkRelatedByProfileId($obj1);            }
            $results[] = $obj1;
        }
        return $results;
    }
        
    public static function send(BaseMember $from_member, BaseMember $to_member)
    {
        //cleanup all old winks to this member
        $c = new Criteria();
        $c->add(WinkPeer::MEMBER_ID, $from_member->getId());
        $c->add(WinkPeer::PROFILE_ID, $to_member->getId());
        $c->add(WinkPeer::SENT_BOX, false);
        self::doDelete($c);
                
        //add to recepient
        $wink = new Wink();
        $wink->setMemberRelatedByMemberId($from_member);
        $wink->setMemberRelatedByProfileId($to_member);
        
        //save to sent box
        $sent_wink = clone $wink;
        $sent_wink->setSentBox(true);
        
        //save objects
        $wink->save();
        $sent_wink->save();
        
        if( $to_member->getEmailNotifications() === 0 ) Events::triggerAccountActivity($to_member);

        return $sent_wink;
    }    
}
