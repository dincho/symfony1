<?php
/**
 *
 *
 */

class TUPager extends prBasePager
{
    public function __construct(Criteria $crit, $currentID)
    {
        parent::__construct('TransUnitPeer', $crit, $currentID);
    }
}
