<?php

/**
 * Subclass for representing a row from the 'flag' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Flag extends BaseFlag
{
    public function getFlagger()
    {
        if( $this->getFlaggerId() )
        {
            return MemberPeer::retrieveByPK($this->getFlaggerId());
        }
    }
}
