<?php

/**
 * Subclass for performing query and update operations on the 'geo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class GeoPeer extends BaseGeoPeer
{
    public static function hasAdm1AreasIn($country)
    {
      $c = new Criteria();
      $c->add(GeoPeer::COUNTRY, $country);
      $c->add(GeoPeer::DSG, "ADM1", Criteria::EQUAL);
      return self::doCount($c);
    }
  
    public static function getAllByCountry($country)
    {
        $c = new Criteria();
        $c->add(GeoPeer::COUNTRY, $country);
        $c->add(GeoPeer::DSG, "ADM1", Criteria::EQUAL);
        $c->addAscendingOrderByColumn(GeoPeer::NAME);
        
        return GeoPeer::doSelect($c);
    }
    
    public static function getAllByAdm1($adm1)
    {
        $adm1_obj = GeoPeer::retrieveByPK($adm1);
        
        $c = new Criteria();
        $c->add(GeoPeer::COUNTRY, $adm1_obj->getCountry());
        $c->add(GeoPeer::ADM1, $adm1_obj->getName(), Criteria::EQUAL);
        $c->add(GeoPeer::DSG, "ADM2", Criteria::EQUAL);
        $c->addAscendingOrderByColumn(GeoPeer::NAME);
        
        return GeoPeer::doSelect($c);
    }
    
    public static function getAdm1ByCountryAndPK($country, $pk)
    {
      $c = new Criteria();
      $c->add(GeoPeer::DSG, 'ADM1');
      $c->add(GeoPeer::COUNTRY, $country);
      $c->add(GeoPeer::ID, $pk);
      return self::doSelectOne($c);
    }
    
    public static function getAdm2ByCountryAdm1AndPK($country, $adm1, $pk)
    {
      $c = new Criteria();
      $c->add(GeoPeer::DSG, 'ADM2');
      $c->add(GeoPeer::COUNTRY, $country);
      $c->add(GeoPeer::ADM1, $adm1);
      $c->add(GeoPeer::ID, $pk);
      return self::doSelectOne($c);
    }  
    
    public static function getCountriesWithStates()
    {
        $c = new Criteria();
        $c->addGroupByColumn(GeoPeer::COUNTRY);
        $c->clearSelectColumns()->addSelectColumn(GeoPeer::COUNTRY)->addSelectColumn(GeoPeer::COUNT);
        $rs = self::doSelectRs($c);

        $ret = array();
        while($rs->next()) {
            $ret[] = $rs->getString(1);
        }
        
        return $ret;
    }
    
    public static function getAssocByCountry($country)
    {
        $c = new Criteria();
        $c->add(GeoPeer::COUNTRY, $country);
        $adm1s = GeoPeer::doSelect($c);
        
        $ret = array();
        foreach ($adm1s as $adm1)
        {
            $ret[$adm1->getId()] = $adm1;
        }
        
        return $ret;
    }

    public static function getPopulatedPlaceByName($name, $country, $adm1_id = null, $adm2_id = null)
    {   
        $c = new Criteria();
        $c->add(GeoPeer::DSG, 'PPL');
        $c->add(GeoPeer::NAME, $name);
        $c->add(GeoPeer::COUNTRY, $country);

        if( $adm1_id && $adm1 = self::retrieveByPK($adm1_id) )
        {
          $c->add(GeoPeer::ADM1, $adm1->getName());
        }
        
        if( $adm2_id && $adm2 = self::retrieveByPK($adm2_id) )
        {
          $c->add(GeoPeer::ADM2, $adm2->getName());
        }        
        
        return GeoPeer::doSelectOne($c);
    }
    
    public static function getPopulatedPlaces($country, $adm1_id = null, $adm2_id = null)
    {   
        $c = new Criteria();
        $c->add(GeoPeer::DSG, 'PPL');
        $c->add(GeoPeer::COUNTRY, $country);

        if( $adm1_id && $adm1 = self::retrieveByPK($adm1_id) )
        {
          $c->add(GeoPeer::ADM1, $adm1->getName());
        }
        
        if( $adm2_id && $adm2 = self::retrieveByPK($adm2_id) )
        {
          $c->add(GeoPeer::ADM2, $adm2->getName());
        }        
        
        return GeoPeer::doSelect($c);
    }  
}
