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
	
	public function hasAmount($amount)
	{
	    return ($this->getTrial1Amount() == $amount || $this->getTrial2Amount() == $amount || $this->getAmount() == $amount ) ? true : false;
	}
}
