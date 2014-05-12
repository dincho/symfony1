<?php

/**
 * Subclass for representing a row from the 'subscription' table.
 *
 *
 *
 * @package lib.model
 */
class Subscription extends BaseSubscription
{
  public function __toString()
  {
    return $this->getTitle();
  }

  public function getShortTitle()
  {
    return substr($this->getTitle(), 0, 4);
  }
}
