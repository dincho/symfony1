<?php

/**
 * Subclass for representing a row from the 'imbra_status' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ImbraStatus extends BaseImbraStatus
{
	public function __toString()
	{
		return $this->getTitle();
	}
}
