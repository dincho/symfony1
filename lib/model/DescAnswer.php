<?php

/**
 * Subclass for representing a row from the 'desc_answer' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DescAnswer extends BaseDescAnswer
{
  public function __toString()
  {
    return $this->getTitle();
  }
  
  public function getSearchTitle()
  {
  	return ( !is_null(parent::getSearchTitle()) ) ? parent::getSearchTitle() : $this->getTitle();
  }
}
