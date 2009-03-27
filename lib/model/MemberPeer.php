<?php
/**
 * Subclass for performing query and update operations on the 'member' table.
 *
 * 
 *
 * @package lib.model
 */
class MemberPeer extends BaseMemberPeer
{

    public static function retrieveByEmail($email)
    {
        $c = new Criteria();
        $c->add(MemberPeer::EMAIL, $email);
        $c->setLimit(1);
        return MemberPeer::doSelectOne($c);
    }

    public static function retrieveByUsername($username)
    {
        $c = new Criteria();
        $c->add(MemberPeer::USERNAME, $username);
        $c->setLimit(1);
        return MemberPeer::doSelectOne($c);
    }

    public static function retrieveByUsernameJoinAll($username)
    {
        $c = new Criteria();
        $c->add(MemberPeer::USERNAME, $username);
        $c->setLimit(1);
        
        $members = MemberPeer::doSelectJoinAll($c);
        return ($members && isset($members[0])) ? $members[0] : null;
    }

    public static function doSelectJoinAllCustom(Criteria $c, $con = null)
    {
        return self::doSelectJoinAll($c, $con, true);
    }

    public static function doSelectJoinAll(Criteria $c, $con = null, $hydrate_custom = false)
    {
        $c = clone $c;
        
        if ($c->getDbName() == Propel::getDefaultDB())
        {
            $c->setDbName(self::DATABASE_NAME);
        }
        
        MemberPeer::addSelectColumns($c);
        $startcol2 = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        
        MemberStatusPeer::addSelectColumns($c);
        $startcol3 = $startcol2 + MemberStatusPeer::NUM_COLUMNS;
        
        UserPeer::addSelectColumns($c);
        $startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;
        
        StatePeer::addSelectColumns($c);
        $startcol5 = $startcol4 + StatePeer::NUM_COLUMNS;
        
        MemberPhotoPeer::addSelectColumns($c);
        $startcol6 = $startcol5 + MemberPhotoPeer::NUM_COLUMNS;
        
        SubscriptionPeer::addSelectColumns($c);
        $startcol7 = $startcol6 + SubscriptionPeer::NUM_COLUMNS;
        
        MemberCounterPeer::addSelectColumns($c);
        $startcol8 = $startcol7 + MemberCounterPeer::NUM_COLUMNS;
        
        $c->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);
        
        $c->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID, Criteria::LEFT_JOIN);
        
        $c->addJoin(MemberPeer::STATE_ID, StatePeer::ID, Criteria::LEFT_JOIN);
        
        $c->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID, Criteria::LEFT_JOIN);
        
        $c->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);
        
        $c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);
        
        $rs = BasePeer::doSelect($c, $con);
        $results = array();
        
        while ($rs->next())
        {
            
            $omClass = MemberPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);
            
            $omClass = MemberStatusPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol2);
            
            $newObject = true;
            for ($j = 0, $resCount = count($results); $j < $resCount; $j ++)
            {
                $temp_obj1 = $results[$j];
                $temp_obj2 = $temp_obj1->getMemberStatus();
                if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey())
                {
                    $newObject = false;
                    $temp_obj2->addMember($obj1);
                    break;
                }
            }
            
            if ($newObject)
            {
                $obj2->initMembers();
                $obj2->addMember($obj1);
            }
            
            $omClass = UserPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj3 = new $cls();
            $obj3->hydrate($rs, $startcol3);
            
            $newObject = true;
            for ($j = 0, $resCount = count($results); $j < $resCount; $j ++)
            {
                $temp_obj1 = $results[$j];
                $temp_obj3 = $temp_obj1->getUser();
                if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey())
                {
                    $newObject = false;
                    $temp_obj3->addMember($obj1);
                    break;
                }
            }
            
            if ($newObject)
            {
                $obj3->initMembers();
                $obj3->addMember($obj1);
            }
            
            $omClass = StatePeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj4 = new $cls();
            $obj4->hydrate($rs, $startcol4);
            
            $newObject = true;
            for ($j = 0, $resCount = count($results); $j < $resCount; $j ++)
            {
                $temp_obj1 = $results[$j];
                $temp_obj4 = $temp_obj1->getState();
                if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey())
                {
                    $newObject = false;
                    $temp_obj4->addMember($obj1);
                    break;
                }
            }
            
            if ($newObject)
            {
                $obj4->initMembers();
                $obj4->addMember($obj1);
            }
            
            $omClass = MemberPhotoPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj5 = new $cls();
            $obj5->hydrate($rs, $startcol5);
            
            $newObject = true;
            for ($j = 0, $resCount = count($results); $j < $resCount; $j ++)
            {
                $temp_obj1 = $results[$j];
                $temp_obj5 = $temp_obj1->getMemberPhoto();
                if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey())
                {
                    $newObject = false;
                    $temp_obj5->addMember($obj1);
                    break;
                }
            }
            
            if ($newObject)
            {
                $obj5->initMembers();
                $obj5->addMember($obj1);
            }
            
            $omClass = SubscriptionPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj6 = new $cls();
            $obj6->hydrate($rs, $startcol6);
            
            $newObject = true;
            for ($j = 0, $resCount = count($results); $j < $resCount; $j ++)
            {
                $temp_obj1 = $results[$j];
                $temp_obj6 = $temp_obj1->getSubscription();
                if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey())
                {
                    $newObject = false;
                    $temp_obj6->addMember($obj1);
                    break;
                }
            }
            
            if ($newObject)
            {
                $obj6->initMembers();
                $obj6->addMember($obj1);
            }
            
            $omClass = MemberCounterPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj7 = new $cls();
            $obj7->hydrate($rs, $startcol7);
            
            $newObject = true;
            for ($j = 0, $resCount = count($results); $j < $resCount; $j ++)
            {
                $temp_obj1 = $results[$j];
                $temp_obj7 = $temp_obj1->getMemberCounter();
                if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey())
                {
                    $newObject = false;
                    $temp_obj7->addMember($obj1);
                    break;
                }
            }
            
            if ($newObject)
            {
                $obj7->initMembers();
                $obj7->addMember($obj1);
            }
            
            if ($hydrate_custom)
                $obj1->custom1 = $rs->getInt($startcol8);
            $results[] = $obj1;
        }
        return $results;
    }

    public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
    {
        $criteria = clone $criteria;
        
        $criteria->clearSelectColumns()->clearOrderByColumns();
        if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers()))
        {
            $criteria->addSelectColumn(MemberPeer::COUNT_DISTINCT);
        } else
        {
            $criteria->addSelectColumn(MemberPeer::COUNT);
        }
        
        foreach ($criteria->getGroupByColumns() as $column)
        {
            $criteria->addSelectColumn($column);
        }
        
        $criteria->addJoin(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ID);
        
        $criteria->addJoin(MemberPeer::REVIEWED_BY_ID, UserPeer::ID, Criteria::LEFT_JOIN);
        
        $criteria->addJoin(MemberPeer::STATE_ID, StatePeer::ID, Criteria::LEFT_JOIN);
        
        $criteria->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID, Criteria::LEFT_JOIN);
        
        $criteria->addJoin(MemberPeer::SUBSCRIPTION_ID, SubscriptionPeer::ID);
        
        $criteria->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);
        
        $rs = MemberPeer::doSelectRS($criteria, $con);
        if ($rs->next())
        {
            return $rs->getInt(1);
        } else
        {
            return 0;
        }
    }

    public static function doSelectJoinMemberPhoto(Criteria $c, $con = null)
    {
        $c = clone $c;
        
        if ($c->getDbName() == Propel::getDefaultDB())
        {
            $c->setDbName(self::DATABASE_NAME);
        }
        
        MemberPeer::addSelectColumns($c);
        $startcol = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        MemberPhotoPeer::addSelectColumns($c);
        
        $c->addJoin(MemberPeer::MAIN_PHOTO_ID, MemberPhotoPeer::ID, Criteria::LEFT_JOIN);
        $rs = BasePeer::doSelect($c, $con);
        $results = array();
        
        while ($rs->next())
        {
            
            $omClass = MemberPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);
            
            $omClass = MemberPhotoPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol);
            
            $newObject = true;
            foreach ($results as $temp_obj1)
            {
                $temp_obj2 = $temp_obj1->getMemberPhoto();
                if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey())
                {
                    $newObject = false;
                    $temp_obj2->addMember($obj1);
                    break;
                }
            }
            if ($newObject)
            {
                $obj2->initMembers();
                $obj2->addMember($obj1);
            }
            $results[] = $obj1;
        }
        return $results;
    }

    public static function doSelectJoinMemberPhotos(Criteria $c, $con = null)
    {
        $c = clone $c;
        
        if ($c->getDbName() == Propel::getDefaultDB())
        {
            $c->setDbName(self::DATABASE_NAME);
        }
        
        MemberPeer::addSelectColumns($c);
        $startcol = (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        MemberPhotoPeer::addSelectColumns($c);
        
        $c->addJoin(MemberPeer::ID, MemberPhotoPeer::MEMBER_ID);
        $rs = BasePeer::doSelect($c, $con);
        $results = array();
        
        while ($rs->next())
        {
            
            $omClass = MemberPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);
            
            $omClass = MemberPhotoPeer::getOMClass();
            
            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol);
            
            $newObject = true;
            foreach ($results as $temp_obj1)
            {
                $temp_obj2 = $temp_obj1->getMemberPhoto();
                if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey())
                {
                    $newObject = false;
                    $temp_obj2->addMember($obj1);
                    break;
                }
            }
            if ($newObject)
            {
                $obj2->initMembers();
                $obj2->addMember($obj1);
            }
            $results[] = $obj1;
        }
        return $results;
    }

    public static function retrieveByPkJoinAll($id, $con = null)
    {
        $c = new Criteria();
        $c->add(MemberPeer::ID, $id);
        $c->setLimit(1);
        
        $result = self::doSelectJoinAll($c, $con);
        return ($result) ? $result[0] : null;
    }
    
    public static function getFrontendProfileUrl($username)
    {
        $hash = sha1(sfConfig::get('app_admin_user_hash') . $username . sfConfig::get('app_admin_user_hash'));
        return sfContext::getInstance()->getRequest()->getUriPrefix() . '/en/profiles/' . $username . '/admin_hash/' . $hash . '.html';
    }

    public static function doSelectJoinStockPhoto(Criteria $c, $con = null)
    {
        $c = clone $c;

                if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        MemberStoryPeer::addSelectColumns($c);
        $startcol = (MemberStoryPeer::NUM_COLUMNS - MemberStoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        StockPhotoPeer::addSelectColumns($c);

        $c->addJoin(MemberStoryPeer::STOCK_PHOTO_ID, StockPhotoPeer::ID, Criteria::LEFT_JOIN);
        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while($rs->next()) {

            $omClass = MemberStoryPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);

            $omClass = StockPhotoPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol);

            $newObject = true;
            foreach($results as $temp_obj1) {
                $temp_obj2 = $temp_obj1->getStockPhoto();               if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
                    $newObject = false;
                                        $temp_obj2->addMemberStory($obj1);                  break;
                }
            }
            if ($newObject) {
                $obj2->initMemberStorys();
                $obj2->addMemberStory($obj1);           }
            $results[] = $obj1;
        }
        return $results;
    }
}
