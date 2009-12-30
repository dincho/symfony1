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
  
    public static function getAllByCountry($countries = array())
    {
        $c = new Criteria();
        if( is_array($countries)  ) 
        {
            if( !in_array('GEO_ALL', $countries) )
            {
                if( in_array('GEO_UNASSIGNED', $countries) )
                {
                    $crit = $c->getNewCriterion(GeoPeer::COUNTRY, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::COUNTRY, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::COUNTRY, $countries, Criteria::IN);
                }
            }
            
        } elseif( $countries )
        {
            $c->add(GeoPeer::COUNTRY, $countries);
        }
        
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
    
    public static function getAllByAdm1Name($countries = array(), $adm1s = array())
    {
        $c = new Criteria();
        if( is_array($countries)  ) 
        {
            if( !in_array('GEO_ALL', $countries) )
            {
                if( in_array('GEO_UNASSIGNED', $countries) )
                {
                    $crit = $c->getNewCriterion(GeoPeer::COUNTRY, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::COUNTRY, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::COUNTRY, $countries, Criteria::IN);
                }
            }
            
        } elseif( $countries )
        {
            $c->add(GeoPeer::COUNTRY, $countries);
        }
        
        if( is_array($adm1s)  ) 
        {
            if( !in_array('GEO_ALL', $adm1s) )
            {
                if( in_array('GEO_UNASSIGNED', $adm1s) )
                {
                    $crit = $c->getNewCriterion(GeoPeer::ADM1, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::ADM1, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::ADM1, $adm1s, Criteria::IN);
                }
            }
            
        } elseif( $adm1s )
        {
            $c->add(GeoPeer::ADM1, $adm1s);
        }
                
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
    
    public static function getDSG($countries = array(), $adm1s = array(), $adm2s = array())
    {
        $c = new Criteria();
        if( is_array($countries)  ) 
        {
            if( !in_array('GEO_ALL', $countries) )
            {
                if( in_array('GEO_UNASSIGNED', $countries) )
                {
                    $crit = $c->getNewCriterion(GeoPeer::COUNTRY, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::COUNTRY, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::COUNTRY, $countries, Criteria::IN);
                }
            }
            
        } elseif( $countries )
        {
            $c->add(GeoPeer::COUNTRY, $countries);
        }
        
        if( is_array($adm1s)  ) 
        {
            if( !in_array('GEO_ALL', $adm1s) )
            {
                if( in_array('GEO_UNASSIGNED', $adm1s) )
                {
                    $crit = $c->getNewCriterion(GeoPeer::ADM1, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::ADM1, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::ADM1, $adm1s, Criteria::IN);
                }
            }
            
        } elseif( $adm1s )
        {
            $c->add(GeoPeer::ADM1, $adm1s);
        }
                
        if( is_array($adm2s)  ) 
        {
            if( !in_array('GEO_ALL', $adm2s) )
            {
                if( in_array('GEO_UNASSIGNED', $adm2s) )
                {
                    $crit = $c->getNewCriterion(GeoPeer::ADM2, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::ADM2, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::ADM2, $adm2s, Criteria::IN);
                }
            }
            
        } elseif( $adm2s )
        {
            $c->add(GeoPeer::ADM2, $adm2s);
        }
                        
        $c->addGroupByColumn(GeoPeer::DSG);
        $c->addAscendingOrderByColumn(GeoPeer::DSG);
        $c->clearSelectColumns()->addSelectColumn(GeoPeer::DSG);
        $rs = GeoPeer::doSelectRS($c);
        
        $dsgs_tmp = array();
        while ($rs->next())
        {
            $dsgs_tmp[$rs->get(1)] = $rs->get(1);
        }
        
        return $dsgs_tmp;
    }
    
    public static function getCountriesArray()
    {
        $c = new Criteria();
        $c->add(GeoPeer::DSG, 'PCL');
        $geos = self::doSelect($c);
        
        $countries = array();
        $user = sfContext::getInstance()->getUser();
        $c = new sfCultureInfo($user->getCulture());
        $countries_i18n = $c->getCountries();
                
        foreach($geos as $geo)
        {
            if( $user->getCulture() == 'en' )
            {
                $countries[$geo->getCountry()] = $geo->getName();
            } elseif(isset($countries_i18n[$geo->getCountry()])) {
                $countries[$geo->getCountry()] = $countries_i18n[$geo->getCountry()];
            }
        }
        
        $oldLocale = setlocale(LC_COLLATE, "0");
        setlocale(LC_COLLATE, $user->getLocale());
        asort($countries, SORT_LOCALE_STRING);
        setlocale(LC_COLLATE, $oldLocale);
                
        return $countries;
    }
}
