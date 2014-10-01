<?php

/**
 * Subclass for representing a row from the 'search_criteria' table.
 *
 *
 *
 * @package lib.model
 */
class SearchCriteria extends BaseSearchCriteria
{
    public function getSearchCritDescsArray()
    {
        $ret = array();
        foreach ($this->getSearchCritDescs() as $desc) {
            $ret[$desc->getDescQuestionId()] = $desc;
        }

        return $ret;
    }

    public function clear()
    {
        $c = new Criteria();
        $c->add(SearchCritDescPeer::SEARCH_CRITERIA_ID, $this->getId());

        SearchCritDescPeer::doDelete($c);

        $this->setAges(null);
        $this->setAgesWeight(null);
    }

    /**
     * get the age min and max
     * 0 = min, 1 = max
     *
     * @param  integer $key
     * @return integer
     */
    public function getAgeValue($key = 0)
    {
        $ages = explode(',',$this->getAges());

        return ( !is_null($this->getAges()) && array_key_exists($key, $ages)) ? $ages[$key] : false;
    }
}
