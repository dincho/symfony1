<?php

/**
 * Subclass for representing a row from the 'member_imbra_answer' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberImbraAnswer extends BaseMemberImbraAnswer
{
	public function getAnswerString()
	{
		return ( $this->getAnswer() ) ? 'Yes' : 'No';
	}
}
