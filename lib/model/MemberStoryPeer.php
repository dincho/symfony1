<?php

/**
 * Subclass for performing query and update operations on the 'member_story' table.
 *
 *
 *
 * @package lib.model
 */
class MemberStoryPeer extends BaseMemberStoryPeer
{
    public static function doSelectJoinStockPhoto2(Criteria $c, $con = null)
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

        while ($rs->next()) {

            $omClass = MemberStoryPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);

            $omClass = StockPhotoPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol);

            $newObject = true;
            foreach ($results as $temp_obj1) {
                $temp_obj2 = $temp_obj1->getStockPhoto();                 if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
                    $newObject = false;
                                        $temp_obj2->addMemberStory($obj1);                     break;
                }
            }
            if ($newObject) {
                $obj2->initMemberStorys();
                $obj2->addMemberStory($obj1);             }
            $results[] = $obj1;
        }

        return $results;
    }
}
