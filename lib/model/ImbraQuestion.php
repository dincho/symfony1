<?php

/**
 * Subclass for representing a row from the 'imbra_question' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ImbraQuestion extends BaseImbraQuestion
{
    public function hasBothAnswers()
    {
        return ( !is_null($this->getNegativeAnswer()) && !is_null($this->getPositiveAnswer()));
    }
}
