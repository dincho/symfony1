<?php

/**
 * Subclass for representing a row from the 'member_status' table.
 *
 *
 *
 * @package lib.model
 */
class MemberStatus extends BaseMemberStatus
{
  public function __toString()
  {
    return $this->getTitle();
  }
}
