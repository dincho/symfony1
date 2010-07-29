<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 7, 2009 11:47:49 AM
 * 
 */

class ProfilePager
{
    private $members = array();
    private $cursor = 0;
    
    public function __construct(array $members, $current_member)
    {
        //$this->members = sfContext::getInstance()->getUser()->getAttributeHolder()->getAll('frontend/search/profile_pager');
        $this->members = $members;
        $this->setCursor($current_member);
    }

    protected function setCursor($current_member)
    {
        //cast to int to set cursor = 0 if not member found
        $this->cursor = (int) array_search($current_member, $this->members);
    }
    
    public function getNext()
    {
        return (isset($this->members[$this->cursor+1])) ? $this->members[$this->cursor+1] : null;
    }

    public function getPrevious()
    {
        return (isset($this->members[$this->cursor-1])) ? $this->members[$this->cursor-1] : null;
    }
    
    public function hasResults()
    {
        return (count($this->members) > 0) ? true : false;
    }
}
