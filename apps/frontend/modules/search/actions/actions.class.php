<?php

/**
 * search actions.
 *
 * @package    pr
 * @subpackage search
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class searchActions extends prActions
{

    public function preExecute()
    {
        $user = $this->getUser();
        $bc = $user->getBC()->clear();
        
        if( $user->isAuthenticated() )
        {
            $bc->add(array('name' => 'dashboard', 'uri' => 'dashboard/index'));
            $bc->add(array('name' => 'search', 'uri' => 'search/index'));
        } else {
            $bc->add(array('name' => 'home', 'uri' => '@homepage'));
            $bc->add(array('name' => 'search', 'uri' => 'search/public'));
        }
        
        
        $this->processFilters();
        $filters = $this->getUser()->getAttributeHolder()->getAll('frontend/search/filters');
        if (! isset($filters['location']))
            $filters['location'] = 0;
        $this->filters = $filters;
        
    }

    public function executePublic()
    {
        $this->redirectIf($this->getUser()->isAuthenticated(), 'search/index');
        $this->forward404If(sfConfig::get('app_beta_period'));
        
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
        $c->add(MemberPeer::PUBLIC_SEARCH, true);
        
        $rows = sfConfig::get('app_settings_search_rows_public', 4);
        $limit = $rows * 3; //3 boxes/profiles per row        
        $c->setLimit($limit);
        
        $this->processPublicFilters($c);
        $this->members = MemberPeer::doSelectJoinAll($c);
        
        $this->getResponse()->setTitle('Public search title');
        $this->getResponse()->addMeta('description', 'Public search description');
        $this->getResponse()->addMeta('keywords', 'Public search keywords');
    }

    public function executeIndex()
    {
        $this->forward($this->getModuleName(), 'mostRecent');
    }

    public function executeMostRecent()
    {

        $subscriptioIds = implode(',', array(
            SubscriptionPeer::VIP,
            SubscriptionPeer::PREMIUM,
            SubscriptionPeer::FREE
        ));

        $order = sprintf("FIELD(%s,%s)", MemberPeer::SUBSCRIPTION_ID, $subscriptioIds);

        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        $c->addAscendingOrderByColumn($order);
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);

        $rows = sfConfig::get('app_settings_search_rows_most_recent', 4);
        $this->initPager($c, $rows * 3); //3 boxes/profiles per row

        //get matches from search engine
        $members = $this->pager->getResults();
        $this->pager->members = MemberMatchPeer::populateMemberMatches(
            $this->getUser()->getProfile(),
            $members
        );

        $this->storeSearchUrl('search/mostRecent');
    }

    public function executeLastLogin()
    {
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn(MemberPeer::LAST_LOGIN);
        $rows = sfConfig::get('app_settings_search_rows_last_login', 4);
        //3 boxes/profiles per row
        $this->initPager($c, $rows * 3);

        //get matches from search engine
        $members = $this->pager->getResults();
        $this->pager->members = MemberMatchPeer::populateMemberMatches(
            $this->getUser()->getProfile(),
            $members
        );

        $this->storeSearchUrl('search/lastLogin');
    }
    
    public function executeCriteria()
    {
        $this->has_criteria = true;
        if (!$this->getUser()->getProfile()->hasSearchCriteria()) {
            $this->has_criteria = false;
            $this->setFlash('msg_ok', 'To see search results, please set up your search criteria', false);
            return sfView::SUCCESS;
        }
        
        $rows = sfConfig::get('app_settings_search_rows_custom', 4);
        $this->initSearchPager('straight', $rows * 3);
        $this->storeSearchUrl('search/criteria');
    }

    public function executeReverse()
    {
        //3 boxes/profiles per row
        $rows = sfConfig::get('app_settings_search_rows_reverse', 4);
        $this->initSearchPager('reverse', $rows * 3);
        $this->storeSearchUrl('search/reverse');
    }

    public function executeMatches()
    {
        $this->has_criteria = true;
        if (!$this->getUser()->getProfile()->hasSearchCriteria()) {
            $this->has_criteria = false;
            $this->setFlash('msg_ok', 'To see search results, please set up your search criteria', false);
            return sfView::SUCCESS;
        }
        
        //3 boxes/profiles per row    
        $rows = sfConfig::get('app_settings_search_rows_matches', 4);    
        $this->initSearchPager('combined', $rows * 3);
        $this->storeSearchUrl('search/matches');
    }

    public function executeByKeyword()
    {
        if (!isset($this->filters['keyword']) || strlen($this->filters['keyword']) == 0) {
            return sfView::SUCCESS;
        }

        $keyword = $this->filters['keyword'];

        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        $crit = $c->getNewCriterion(MemberPeer::ESSAY_HEADLINE, '%' . $keyword . '%', Criteria::LIKE);
        $crit->addOr($c->getNewCriterion(MemberPeer::ESSAY_INTRODUCTION, '%' . $keyword . '%', Criteria::LIKE));
        $crit->addOr($c->getNewCriterion(MemberPeer::USERNAME, '%' . $keyword . '%', Criteria::LIKE));
        $c->add($crit);

        //3 boxes/profiles per row    
        $per_page = sfConfig::get('app_settings_search_rows_keyword', 4) * 3;
        $this->initPager($c, $per_page);

        //get matches from search engine
        $members = $this->pager->getResults();
        $this->pager->members = MemberMatchPeer::populateMemberMatches(
            $this->getUser()->getProfile(),
            $members
        );

        $this->storeSearchUrl('search/byKeyword');
    }

    public function executeByRate()
    {
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);

        $c->addJoin(MemberPeer::ID, MemberRatePeer::MEMBER_ID.' AND '.MemberRatePeer::RATER_ID.' = '.$this->getUser()->getId(), Criteria::LEFT_JOIN);
        $c->addDescendingOrderByColumn(MemberRatePeer::RATE);
        $per_page = sfConfig::get('app_settings_search_rate', 4) * 3;
        $this->initPager($c, $per_page);
        
        //get matches from search engine
        $members = $this->pager->getResults();
        $this->pager->members = MemberMatchPeer::populateMemberMatches(
            $this->getUser()->getProfile(),
            $members
        );

        $this->storeSearchUrl('search/byRate');
    }
 

    public function executeProfileID()
    {
        if ($id = $this->getRequestParameter('profile_id')) {
            $c = new Criteria();
            $this->addGlobalCriteria($c);
            $this->addFiltersCriteria($c);

            $c->add(MemberPeer::ID, $id);
            $members = MemberPeer::doSelect($c);

            if (count($members)) {
                $members = MemberMatchPeer::populateMemberMatches(
                    $this->getUser()->getProfile(),
                    $members
                );
                $this->member = $members[0];
            } else {
                $this->member = null;
            }
        }
    }

    public function executeSelectCountries()
    {
        $user = $this->getUser();
        $user->getBC()->removeFirst()->add(array('name' => 'Select Countries', 'search/selectCountries'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $user->getAttributeHolder()->removeNamespace('frontend/search/areas');
            $user->getAttributeHolder()->removeNamespace('frontend/search/countries');
            $user->getAttributeHolder()->add(array_unique($this->getRequestParameter('countries')), 'frontend/search/countries');
            
            $this->setFlash('msg_ok', 'Success, your changes have been saved. To return to your search, click here.', false);
        }
        
        $selected_areas = $user->getAttributeHolder()->getAll('frontend/search/areas');
        $this->selected_countries = $user->getAttributeHolder()->getAll('frontend/search/countries');

        $countries = GeoPeer::getCountriesArray();
        $countries_columns['left'] = array_slice($countries, 0, 82, true); //left 
        $countries_columns['middle'] = array_slice($countries, 82, 86, true); //middle
        $countries_columns['right'] = array_slice($countries, 82+86); //right
        $this->countries_columns = $countries_columns;

        $this->adm1s = GeoPeer::getCountriesWithStates();
    }
    
    public function handleErrorSelectCountries()
    {
        $user = $this->getUser();
        $user->getBC()->add(array('name' => 'Select Countries', 'search/selectCountries'));
                
        $this->selected_countries = $user->getAttributeHolder()->getAll('frontend/search/countries');
        $countries = GeoPeer::getCountriesArray();
        $countries_columns['left'] = array_slice($countries, 0, 82, true); //left 
        $countries_columns['middle'] = array_slice($countries, 82, 86, true); //middle
        $countries_columns['right'] = array_slice($countries, 82+86); //right
        $this->countries_columns = $countries_columns;

        $this->adm1s = GeoPeer::getCountriesWithStates(); 

        return sfView::SUCCESS;
    }

    public function executeSelectAreas()
    {
        $this->getResponse()->addJavascript('http://maps.googleapis.com/maps/api/js?sensor=false');
        $this->getResponse()->addJavascript('areas_map.js');

        $country = $this->getRequestParameter('country');
        $polish_cities = $this->getRequestParameter('polish_cities');
        $user = $this->getUser();
        $user->getBC()->removeFirst();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $areas = $this->getRequestParameter('areas', array());
            $countries = $user->getAttributeHolder()->getAll('frontend/search/countries');
            
            if (! $polish_cities && count($areas) > 0 && ! in_array($country, $countries))
            {
                $countries[] = $country;
                $user->getAttributeHolder()->removeNamespace('frontend/search/countries');
                $user->getAttributeHolder()->add($countries, 'frontend/search/countries');
            }
            
            if ($polish_cities && count($areas) > 0)
            {
                $user->getAttributeHolder()->removeNamespace('frontend/search/polish_areas');
                $user->getAttributeHolder()->add($areas, 'frontend/search/polish_areas');
            } else
            {
                $user->getAttributeHolder()->removeNamespace('frontend/search/areas');
                if( count($areas) > 0)
                {
                    $selected_areas[$country] = $areas;
                    $user->getAttributeHolder()->add($selected_areas, 'frontend/search/areas');
                }
            }
            
            $this->setFlash('msg_ok', 'Success, your changes have been saved. To return to your search, click here.', false);
        }
        
        if ($polish_cities)
        {
            $this->selected_areas = $user->getAttributeHolder()->getAll('frontend/search/polish_areas');
        } else
        {
            $selected_areas = $user->getAttributeHolder()->getAll('frontend/search/areas');
            $this->selected_areas = isset($selected_areas[$country]) ? $selected_areas[$country] : array();
        }
        
        $this->areas = GeoPeer::getAllByCountry($country);
    }
    
    public function handleErrorSelectAreas()
    {
        $this->getResponse()->addJavascript('http://maps.googleapis.com/maps/api/js?sensor=false');
        $this->getResponse()->addJavascript('areas_map.js');

        $country = $this->getRequestParameter('country');
        $polish_cities = $this->getRequestParameter('polish_cities');
        $user = $this->getUser();
        $user->getBC()->add(array('name' => 'Select Areas', 'search/selectAreas'));
                
        if ($polish_cities)
        {
            $this->selected_areas = $user->getAttributeHolder()->getAll('frontend/search/polish_areas');
        } else
        {
            $selected_areas = $user->getAttributeHolder()->getAll('frontend/search/areas');
            $this->selected_areas = isset($selected_areas[$country]) ? $selected_areas[$country] : array();
        }
        
        $this->areas = GeoPeer::getAllByCountry($country);    

        return sfView::SUCCESS;
    }

    public function executeAreaFilter()
    {
        $adm1 = GeoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($adm1);
        
        $countries = array($adm1->getCountry());
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/countries');
        $this->getUser()->getAttributeHolder()->add($countries, 'frontend/search/countries');
        
        $selected_areas = array(
            $adm1->getCountry() => array($adm1->getId())
        );

        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/areas');
        $this->getUser()->getAttributeHolder()->add($selected_areas, 'frontend/search/areas');
        
        $filters = array('location' => 1);
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters');
        $this->getUser()->getAttributeHolder()->add($filters, 'frontend/search/filters');
        
        $this->redirect('search/mostRecent');
    }

    protected function initPager(
        Criteria $c, 
        $per_page = 12, 
        $peerMethod = 'doSelect',
        $peerCountMethod = 'doCount'
    ) {
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod($peerMethod);
        $pager->setPeerCountMethod($peerCountMethod);
        $pager->init();
        $pager->members = array();
        $this->pager = $pager;

        //update profile pager only on first page 
        //this is some kind of optimization and also allows to not pass the pp_no_update parameter all over the pager
        if ($this->getRequestParameter('page', 1)  == 1 
            && !$this->getRequestParameter('pp_no_update')
        ) {
            FrontendProfilePager::storeCriteria($this->getUser()->getId(), $c);
        }

        return $pager;
    }

    protected function initSearchPager($searchType, $perPage = 12)
    {
        if ($searchType == 'straight') {
            $builder = new prStraightQueryBuilder($this->getUser()->getProfile());
        } elseif ($searchType == 'reverse') {
            $builder = new prReverseQueryBuilder($this->getUser()->getProfile());
        } elseif ($searchType == 'combined') { //combined
            $builder = new prCombinedQueryBuilder($this->getUser()->getProfile());
        } else {
            throw new LogicException('Unsupported search type');
        }

        $this->applyBuilderFilters($builder);

        $pager = new prSearchPager($builder, $perPage);
        $pager->setPage($this->getRequestParameter('page', 1));
        //get matches from search engine
        $pager->init();
        $pager->getResults();
        $this->pager = $pager;

        //update profile pager only on first page 
        //this is some kind of optimization and also allows to not pass the pp_no_update parameter all over the pager
        if ($this->getRequestParameter('page', 1)  == 1 
            && !$this->getRequestParameter('pp_no_update')
        ) {
            FrontendProfilePager::storeCriteria($this->getUser()->getId(), $builder);
        }

        return $pager;
    }

    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filters'))
        {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'frontend/search/filters');
        }
    }

    protected function addGlobalCriteria(Criteria $c)
    {
        $member = $this->getUser()->getProfile();

        MemberMatchPeer::addGlobalCriteria($c, $member);
    }

    protected function processPublicFilters(Criteria $c)
    {
        $filters = $this->filters;
        
        if (isset($filters['location']))
        {
            if( $filters['location'] == 2 )
            {
                $this->getRequest()->setError('filter', 'You must be registered member to use area filter');
                $filters['location'] = 0;
            }
            
            $countries = $this->getUser()->getAttributeHolder()->getAll('frontend/search/countries');
            if( $filters['location'] == 1 && !$this->getUser()->isAuthenticated() && empty($countries))
            {
                
                $this->getRequest()->setError('filter', 'You need to select countries first');
                $filters['location'] = 0;
            }

        }
        
        if( isset($filters['looking_for']) )
        {
            $looking = explode('_', $filters['looking_for']);
            $c->add(MemberPeer::SEX, $looking[1]);
        }
        
        if( !isset($filters['age_from']) ) $filters['age_from'] = 18;
        if( !isset($filters['age_to']) ) $filters['age_to'] = 35;
        
        
        $filters['age_from'] = max(18, $filters['age_from']);
        $filters['age_to'] = min(100, max($filters['age_from'], $filters['age_to']));
        $d_from = date('Y') - $filters['age_from'];
        $d_to = date('Y') - $filters['age_to'] -1;
        $c->add(MemberPeer::BIRTHDAY, 'YEAR(' . MemberPeer::BIRTHDAY .') BETWEEN ' . $d_to . ' AND ' . $d_from, Criteria::CUSTOM);
        
        $this->filters = $filters;
        $this->addFiltersCriteria($c);
    }

    protected function getAdministrativeFilters()
    {
        $selectedCountries = $this->getUser()->getAttributeHolder()->getAll('frontend/search/countries');
        $selectedAreas = $this->getUser()->getAttributeHolder()->getAll('frontend/search/areas');
        $filterCountries = array();
        $filterAreas = array();

        if (!empty($selectedCountries)) {
            foreach ($selectedCountries as $key => $selectedCountry) {
                if (array_key_exists($selectedCountry, $selectedAreas)) {
                    $filterAreas = array_merge($filterAreas, $selectedAreas[$selectedCountry]);
                    unset($selectedCountries[$key]);
                }
            }
            
            //countries without areas selected
            $filterCountries = array_values($selectedCountries);
        } else {
            //not selected any country but selected location => own country
            $filterCountries = array($this->getUser()->getProfile()->getCountry());
        }

        return array($filterCountries, $filterAreas);
    }

    protected function applyBuilderFilters(prSearchQueryBuilder $builder)
    {
        if (isset($this->filters['only_with_photo'])) {
            $builder->addFilterByPhoto(true);
        }

        //in selected countries only
        if (1 == $this->filters['location']) {
            list($filterCountries, $filterAreas) = $this->getAdministrativeFilters();
            $builder->addFilterByAdministrativeArea($filterCountries, $filterAreas);
        }

        //within given radius from where I live
        if (2 == $this->filters['location']) {
            $this->validateRadius();

            $memberCity = $this->getUser()->getProfile()->getCity();
            $distance = $this->filters['radius'];
                
            //simple validation/filter
            if ($this->filters['kmmils'] == 'km') {
                $dimension = 'km';
            } else {
                $dimension = 'mi';
            }

            $builder->addFilterByDistance(
                $distance,
                $dimension,
                $memberCity->getLatitude(),
                $memberCity->getLongitude()
            );
        }
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
                list($filterCountries, $filterAreas) = $this->getAdministrativeFilters();
                if (!empty($filterAreas)) {
                    $c->add(MemberPeer::ADM1_ID, $filterAreas, Criteria::IN);
                } elseif (!empty($filterCountries)) {
                    $c->add(MemberPeer::COUNTRY, $filterCountries, Criteria::IN);
                }
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

        if (isset($crit)) $c->add($crit);
    }
    
    protected function validateRadius()
    {
        $radius = $this->filters['radius'];
        
        if( !$radius )
        {
            $this->setFlash('msg_error', "Please enter radius");
            $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters'); 
            if(!$this->getRequest()->isXmlHttpRequest())
            {
              $this->redirect($this->getUser()->getAttribute('last_search_url', 'search/index'));
            }
            else
            {
              $this->getResponse()->setStatusCode(404);
            }
        }
        
        if( !is_numeric($radius) || $radius < 0 || $radius >1000 )
        {
            $this->setFlash('msg_error', "Radius must be betwen 0 and 1000");
            $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters');
            if(!$this->getRequest()->isXmlHttpRequest())
            {
              $this->redirect($this->getUser()->getAttribute('last_search_url', 'search/index'));
            }
            else
            {
              $this->getResponse()->setStatusCode(404);
            }
        } 
              
    }

    protected function storeSearchUrl($url)
    {
        $url .= '?page=' . $this->pager->getPage();
        $this->getUser()->setAttribute('last_search_url', $url);
    }
  
}
