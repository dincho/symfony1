<?php

/**
 * Subclass for performing query and update operations on the 'state' table.
 *
 * 
 *
 * @package lib.model
 */ 
class StatePeer extends BaseStatePeer
{
	public static function getAllByCountry($country)
	{
        $c = new Criteria();
        $c->add(StatePeer::COUNTRY, $country);
        return StatePeer::doSelect($c);
	}
	
	public static function getCountriesWithStates()
	{
	    $c = new Criteria();
	    $c->addGroupByColumn(StatePeer::COUNTRY);
	    $states = self::doSelect($c);
	    
	    $ret = array();
	    foreach ($states as $state)
	    {
	        $ret[] = $state->getCountry();
	    }
	    
	    return $ret;
	}
}
