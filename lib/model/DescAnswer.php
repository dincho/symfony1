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
  
  public function delete($con = null)
  {
      $c = new Criteria();
      $c->add(MemberDescAnswerPeer::DESC_ANSWER_ID, $this->getId());
      MemberDescAnswerPeer::doDelete($c);
      
      parent::delete($con);
  }
}
