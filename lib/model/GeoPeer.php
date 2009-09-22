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
    
    public static function retrieveAdm2ByPK($pk)
    {
      $c = new Criteria();
      $c->add(self::DSG, 'ADM2');
      $c->add(self::ID, $pk);
      
      return self::doSelectOne($c);
    }
}
