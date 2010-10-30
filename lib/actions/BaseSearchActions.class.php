<?php
class BaseSearchActions extends prActions
{

    protected function addGlobalCriteria(Criteria $c)
    {
        $c->add(MemberMatchPeer::MEMBER1_ID, $this->getUser()->getId());
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE); //don not show unavailable profiles
        
        //privacy check
        $c->addJoin(MemberMatchPeer::MEMBER1_ID, OpenPrivacyPeer::MEMBER_ID.' AND '. MemberMatchPeer::MEMBER2_ID .' = '. OpenPrivacyPeer::PROFILE_ID, Criteria::LEFT_JOIN);
        $open_privacy_check = sprintf("IF(%s = 1 AND %s IS NULL, FALSE, TRUE) = TRUE", MemberPeer::PRIVATE_DATING, OpenPrivacyPeer::ID);
        $c->add(OpenPrivacyPeer::ID, $open_privacy_check, Criteria::CUSTOM);        
    }

    protected function addFiltersCriteria(Criteria $c)
    {
        if (isset($this->filters['only_with_photo']))
        {
            $c->add(MemberPeer::MAIN_PHOTO_ID, NULL, Criteria::ISNOTNULL);
        }
        
        switch ($this->filters['location']) {
            //in selected countries only
            case 1:
              $this->addSelectedCountriesCriteria($c);
                break;
            //within given radius from where I live
            case 2:
                $this->validateRadius();
                $member_city = $this->getUser()->getProfile()->getCity();
                $radius = $this->filters['radius'];
                
                if ($this->filters['kmmils'] == 'km') // must convert kilometers in miles 
                {
                    $radius = $radius / 1.61; // One mile is 1.61 kilometers 
                }
                
                $distance_column = '(3956 * (2 * ASIN(SQRT(
                                    POWER(SIN(((%f-geo.Latitude)*0.017453293)/2),2) +
                                    COS(%f*0.017453293) *
                                    COS(geo.Latitude*0.017453293) *
                                    POWER(SIN(((%f-geo.Longitude)*0.017453293)/2),2)
                                    ))))';
                $distance_column = sprintf($distance_column, $member_city->getLatitude(), $member_city->getLatitude(), $member_city->getLongitude());
                
                $c->addJoin(GeoPeer::ID, MemberPeer::CITY_ID);
                $c->add(GeoPeer::ID, $distance_column.' <= '.$radius, Criteria::CUSTOM);
                break;
            default:
                break;
        }

    }

    protected function addSelectedCountriesCriteria(Criteria $c)
    {
        $selected_countries = $this->getUser()->getAttributeHolder()->getAll('frontend/search/countries');
        if (!empty($selected_countries))
        {
            $selected_areas = $this->getUser()->getAttributeHolder()->getAll('frontend/search/areas');
            
            foreach ($selected_countries as $key => $selected_country)
            {
                if (array_key_exists($selected_country, $selected_areas))
                {
                    $crit = $c->getNewCriterion(MemberPeer::COUNTRY, $selected_country);
                    $crit->addAnd($c->getNewCriterion(MemberPeer::ADM1_ID, $selected_areas[$selected_country], Criteria::IN));
                    //$crit->addOr($crit2);
                    
                    unset($selected_countries[$key]);
                }
            }
            
            if (!isset($crit)) $crit = $c->getNewCriterion(MemberPeer::COUNTRY, $selected_countries, Criteria::IN);
        }
        else
        {
            $crit = $c->getNewCriterion(MemberPeer::COUNTRY, $this->getUser()->getProfile()->getCountry(), Criteria::IN);
        }
    
        if (isset($crit)) $c->add($crit);
    }


}