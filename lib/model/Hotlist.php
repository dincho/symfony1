<?php

/**
 * Subclass for representing a row from the 'hotlist' table.
 *
 *
 *
 * @package lib.model
 */
class Hotlist extends BaseHotlist
{
    public function getProfile()
    {
        return MemberPeer::retrieveByPK($this->getProfileId());
    }

    public function save($con = null, $inc_counter = true)
    {
        if ($inc_counter && $this->isNew() && parent::save($con)) {
            $this->getMemberRelatedByMemberId()->incCounter('Hotlist');
            $this->getMemberRelatedByProfileId()->incCounter('OnOthersHotlist');

            return true;
        }

        return parent::save($con);
    }
}
