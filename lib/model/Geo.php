<?php

/**
 * Subclass for representing a row from the 'geo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Geo extends BaseGeo
{
    public function __toString()
    {
        return $this->getName();
    }
    
    public function getPopulatedPlaceByName($name)
    {
        if( $this->getDSG() != 'ADM2' ) throw new sfException('This method must be called only from ADM2 objects');
        
        $c = new Criteria();
        $c->add(GeoPeer::DSG, 'PPL');
        $c->add(GeoPeer::NAME, $name);
        $c->add(GeoPeer::ADM2, $this->getName());
        
        return GeoPeer::doSelectOne($c);
    }
}
