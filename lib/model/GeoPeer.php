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

    public static function getAllByCountry($countries)
    {
        $sort = GeoPeer::NAME;

        $c = new Criteria();
        if ( is_array($countries)  ) {
            if ( !in_array('GEO_ALL', $countries) ) {
                if ( in_array('GEO_UNASSIGNED', $countries) ) {
                    $crit = $c->getNewCriterion(GeoPeer::COUNTRY, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::COUNTRY, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::COUNTRY, $countries, Criteria::IN);
                }
            }

        } elseif ($countries) {
            $c->add(GeoPeer::COUNTRY, $countries);
            if($countries == 'PL') $sort = sprintf("%s %s", GeoPeer::NAME, 'COLLATE utf8_polish_ci');
        }

        $c->add(GeoPeer::DSG, "ADM1", Criteria::EQUAL);
        $c->addAscendingOrderByColumn($sort);

        return GeoPeer::doSelect($c);
    }

    public static function getAllByAdm1Id($countries = array(), $adm1s = array())
    {
        $c = new Criteria();
        if ( is_array($countries)  ) {
            if ( !in_array('GEO_ALL', $countries) ) {
                if ( in_array('GEO_UNASSIGNED', $countries) ) {
                    $crit = $c->getNewCriterion(GeoPeer::COUNTRY, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::COUNTRY, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::COUNTRY, $countries, Criteria::IN);
                }
            }

        } elseif ($countries) {
            $c->add(GeoPeer::COUNTRY, $countries);
        }

        if ( is_array($adm1s)  ) {
            if ( !in_array('GEO_ALL', $adm1s) ) {
                if ( in_array('GEO_UNASSIGNED', $adm1s) ) {
                    $crit = $c->getNewCriterion(GeoPeer::ADM1_ID, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::ADM1_ID, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::ADM1_ID, $adm1s, Criteria::IN);
                }
            }

        } elseif ($adm1s) {
            $c->add(GeoPeer::ADM1_ID, $adm1s);
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
      $c->add(GeoPeer::ADM1_ID, $adm1);
      $c->add(GeoPeer::ID, $pk);

      return self::doSelectOne($c);
    }

    public static function getCountriesWithStates()
    {
        $c = new Criteria();
        $c->add(GeoPeer::DSG, 'ADM1');
        $c->addGroupByColumn(GeoPeer::COUNTRY);
        $c->clearSelectColumns()->addSelectColumn(GeoPeer::COUNTRY)->addSelectColumn(GeoPeer::COUNT);
        $rs = self::doSelectRs($c);

        $ret = array();
        while ($rs->next()) {
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
        foreach ($adm1s as $adm1) {
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

        if ( $adm1_id && $adm1 = self::retrieveByPK($adm1_id) ) {
          $c->add(GeoPeer::ADM1, $adm1->getName());
        }

        if ( $adm2_id && $adm2 = self::retrieveByPK($adm2_id) ) {
          $c->add(GeoPeer::ADM2, $adm2->getName());
        }

        return GeoPeer::doSelectOne($c);
    }

    public static function getPopulatedPlaces($country, $adm1_id = null, $adm2_id = null)
    {
        $c = new Criteria();
        $c->add(GeoPeer::DSG, 'PPL');
        $c->add(GeoPeer::COUNTRY, $country);

        $sort = ($country == 'PL') ? sprintf("%s %s", GeoPeer::NAME, 'COLLATE utf8_polish_ci') : GeoPeer::NAME;
        $c->addAscendingOrderByColumn($sort);

        if ($adm1_id) {
          $c->add(GeoPeer::ADM1_ID, $adm1_id);
        }

        if ($adm2_id) {
          $c->add(GeoPeer::ADM2_ID, $adm2_id);
        }

        return GeoPeer::doSelect($c);
    }

    public static function getDSG($countries = array(), $adm1s = array(), $adm2s = array())
    {
        $c = new Criteria();
        if ( is_array($countries)  ) {
            if ( !in_array('GEO_ALL', $countries) ) {
                if ( in_array('GEO_UNASSIGNED', $countries) ) {
                    $crit = $c->getNewCriterion(GeoPeer::COUNTRY, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::COUNTRY, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::COUNTRY, $countries, Criteria::IN);
                }
            }

        } elseif ($countries) {
            $c->add(GeoPeer::COUNTRY, $countries);
        }

        if ( is_array($adm1s)  ) {
            if ( !in_array('GEO_ALL', $adm1s) ) {
                if ( in_array('GEO_UNASSIGNED', $adm1s) ) {
                    $crit = $c->getNewCriterion(GeoPeer::ADM1_ID, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::ADM1_ID, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::ADM1_ID, $adm1s, Criteria::IN);
                }
            }

        } elseif ($adm1s) {
            $c->add(GeoPeer::ADM1_ID, $adm1s);
        }

        if ( is_array($adm2s)  ) {
            if ( !in_array('GEO_ALL', $adm2s) ) {
                if ( in_array('GEO_UNASSIGNED', $adm2s) ) {
                    $crit = $c->getNewCriterion(GeoPeer::ADM2_ID, null, Criteria::ISNULL);
                    $crit->addOr($c->getNewCriterion(GeoPeer::ADM2_ID, ''));
                    $c->add($crit);
                } else {
                    $c->add(GeoPeer::ADM2_ID, $adm2s, Criteria::IN);
                }
            }

        } elseif ($adm2s) {
            $c->add(GeoPeer::ADM2_ID, $adm2s);
        }

        $c->addGroupByColumn(GeoPeer::DSG);
        $c->addAscendingOrderByColumn(GeoPeer::DSG);
        $c->clearSelectColumns()->addSelectColumn(GeoPeer::DSG);
        $rs = GeoPeer::doSelectRS($c);

        $dsgs_tmp = array();
        while ($rs->next()) {
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

        foreach ($geos as $geo) {
            if ( $user->getCulture() != 'en' && isset($countries_i18n[$geo->getCountry()]) ) {
                $countries[$geo->getCountry()] = $countries_i18n[$geo->getCountry()];
            } else {
                $countries[$geo->getCountry()] = $geo->getName();
            }
        }

        $oldLocale = setlocale(LC_COLLATE, "0");
        setlocale(LC_COLLATE, $user->getLocale());
        asort($countries, SORT_LOCALE_STRING);
        setlocale(LC_COLLATE, $oldLocale);

        return $countries;
    }

    public static function retrieveCountryByISO($iso)
    {
        $c = new Criteria();
        $c->add(self::DSG, 'PCL');
        $c->add(self::COUNTRY, $iso);
        $c->setLimit(1);

        return self::doSelectOne($c);
    }

    public static function addAliasSelectColumns($alias, Criteria $criteria)
    {
      foreach (self::getFieldNames(BasePeer::TYPE_COLNAME) as $fieldName) {
        $criteria->addSelectColumn(self::alias($alias ,$fieldName));
      }
    }

    public static function doSelectJoinAllFeatures(Criteria $c, $con = null)
    {
        $c = clone $c;

        if ($c->getDbName() == Propel::getDefaultDB()) {
          $c->setDbName(self::DATABASE_NAME);
        }

        GeoPeer::addSelectColumns($c);

        //see http://www.symfony-project.com/forum/index.php/m/10570/ for addAlias examples
        $c->addAlias("Adm1", GeoPeer::TABLE_NAME);
        $startcol_adm1 = (GeoPeer::NUM_COLUMNS - GeoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
        GeoPeer::addAliasSelectColumns('Adm1', $c);
        $c->addJoin(GeoPeer::ADM1_ID, GeoPeer::alias("Adm1", GeoPeer::ID), Criteria::LEFT_JOIN);

        $c->addAlias("Adm2", GeoPeer::TABLE_NAME);
        $startcol_adm2 = $startcol_adm1 + GeoPeer::NUM_COLUMNS;
        GeoPeer::addAliasSelectColumns('Adm2', $c);
        $c->addJoin(GeoPeer::ADM2_ID, GeoPeer::alias("Adm2", GeoPeer::ID), Criteria::LEFT_JOIN);

        $rs = BasePeer::doSelect($c, $con);
        $results = array();

        while ($rs->next()) {
            $omClass = GeoPeer::getOMClass();
            $cls = Propel::import($omClass);

            $geo = new $cls();
            $geo->hydrate($rs);

            $adm1 = new $cls();
            $adm1->hydrate($rs, $startcol_adm1);
            $geo->setGeoRelatedByAdm1Id($adm1);

            $adm2 = new $cls();
            $adm2->hydrate($rs, $startcol_adm2);
            $geo->setGeoRelatedByAdm2Id($adm2);

            $results[] = $geo;
        }

        return $results;
    }

    public static function doSelectOneJoinAllFeatures(Criteria $criteria, $con = null)
    {
      $critcopy = clone $criteria;
      $critcopy->setLimit(1);
      $objects = self::doSelectJoinAllFeatures($critcopy, $con);
      if ($objects) {
        return $objects[0];
      }

      return null;
    }
}
