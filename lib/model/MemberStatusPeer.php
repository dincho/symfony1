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
    const ACTIVE                        = 1;
    const SUSPENDED                     = 2;
    const CANCELED                      = 3;
    const ABANDONED                     = 4;
    const DEACTIVATED                   = 5;
    const SUSPENDED_FLAGS               = 6;
    const CANCELED_BY_MEMBER            = 7;
    const PENDING                       = 8;
    const DENIED                        = 9;
    const SUSPENDED_FLAGS_CONFIRMED     = 10;
    const DEACTIVATED_AUTO              = 11;
    const FV_REQUIRED                   = 12;
}
