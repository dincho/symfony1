<?php

/**
 * Subclass for performing query and update operations on the 'public_search' table.
 *
 *
 *
 * @package lib.model
 */
class PublicSearchPeer extends BasePublicSearchPeer
{
    public static function retrieveByMemberId($member_id)
    {
        $c = new Criteria();
        $c->add(PublicSearchPeer::MEMBER_ID, $member_id);

        return self::doSelectOne($c);
    }
}
