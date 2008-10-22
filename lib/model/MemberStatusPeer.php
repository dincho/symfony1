<?php

/**
 * Subclass for performing query and update operations on the 'member_status' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberStatusPeer extends BaseMemberStatusPeer
{
    const ACTIVE              = 1;
    const SUSPENDED           = 2;
    const CANCELED            = 3;
    const ABANDONED           = 4;
    const DEACTIVATED         = 5;
    const FLAGGED             = 6;
    const CANCELED_BY_MEMBER  = 7;
}
