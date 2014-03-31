<?php

/**
 * Subclass for performing query and update operations on the 'member_rate' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberRatePeer extends BaseMemberRatePeer
{
    public static function getRatersForLoginNotification(BaseMember $member)
    {
        $c = new Criteria();
        $c->add(MemberRatePeer::MEMBER_ID, $member->getId());
        $c->clearSelectColumns()->addSelectColumn(MemberRatePeer::RATER_ID);

        $ids = array();
        $rs = self::doSelectRS($c);
        while($rs->next()) {
            $ids[] = $rs->getInt(1);
        }

        return $ids;
    }
}
