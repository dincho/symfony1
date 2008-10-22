<?php

/**
 * Subclass for representing a row from the 'imbra_reply_template' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ImbraReplyTemplate extends BaseImbraReplyTemplate
{
	public function __toString()
	{
		return $this->getTitle();
	}
}
