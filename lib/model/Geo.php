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
      $c->add(GeoPeer::ADM1_ID, $this->getId());
      
      return GeoPeer::doCount($c);
    }
    
    public function getAdm1()
    {
        return GeoPeer::retrieveByPK($this->getAdm1Id());
    }
    
    public function getAdm2()
    {
        return GeoPeer::retrieveByPK($this->getAdm2Id());
    }
    
    public function getDetails($catalog_id)
    {
        $c = new Criteria();
        $c->add(GeoDetailsPeer::ID, $this->getId());
        $c->add(GeoDetailsPeer::CAT_ID, $catalog_id);
        
        return GeoDetailsPeer::doSelectOne($c);
    }
}
