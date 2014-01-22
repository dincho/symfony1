<?php

/**
 * Subclass for representing a row from the 'search_crit_desc' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SearchCritDesc extends BaseSearchCritDesc
{
    public function hasAnswer($id)
    {
        $answers = explode(',', $this->getDescAnswers());
        return in_array($id, $answers);
    }
    
    public function getSelectValue($key)
    {
        $answers = explode(',', $this->getDescAnswers());
        
        return (array_key_exists($key, $answers)) ? $answers[$key] : null;
    }
    
    public function getAgeValue($key = 0)
    {
        $ages = explode(',',$this->getDescAnswers());
        return ( !empty($ages) && array_key_exists($key, $ages)) ? $ages[$key] : false;
    }

    public function getDescAnswersArray()
    {
        return array_map('intval', explode(',',$this->getDescAnswers()));
    }
}
