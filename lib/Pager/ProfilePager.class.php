<?php
/**
 *
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 7, 2009 11:47:49 AM
 *
 */

class ProfilePager extends prBasePager
{
    public function __construct(Criteria $crit, $currentID)
    {
        parent::__construct('MemberPeer', $crit, $currentID);
    }
}
