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
    
    public function hasAdm2Areas()
    {
      $c = new Criteria();
      $c->add(GeoPeer::COUNTRY, $this->getCountry());
      $c->add(GeoPeer::DSG, "ADM2", Criteria::EQUAL);
      $c->add(GeoPeer::ADM1, $this->getname());
      
      return GeoPeer::doCount($c);
    }
}
