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
    }

    public function executeIndex()
    {
        $this->forward($this->getModuleName(), 'mostRecent');
    }

    public function executeMostRecent()
    {
        $this->getUser()->setAttribute('last_search_url', 'search/mostRecent');
        
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        $rows = sfConfig::get('app_settings_search_rows_most_recent', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row
        $this->initPager($c, $per_page);
    }

    public function executeCriteria()
    {
        $this->getUser()->setAttribute('last_search_url', 'search/criteria');
        
        $this->has_criteria = true;
        if (! $this->getUser()->getProfile()->hasSearchCriteria())
        {
            $this->has_criteria = false;
            return sfView::SUCCESS;
        }
        
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn(MemberMatchPeer::PCT);
        $rows = sfConfig::get('app_settings_search_rows_custom', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row
        $this->initPager($c, $per_page);
    }

    public function executeReverse()
    {
        $this->getUser()->setAttribute('last_search_url', 'search/reverse');
        
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addHaving($c->getNewCriterion(MemberMatchPeer::ID, 'reverse_pct > 0' ,Criteria::CUSTOM));
        $c->addDescendingOrderByColumn('reverse_pct');
        $rows = sfConfig::get('app_settings_search_rows_reverse', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row        
        $this->initPager($c, $per_page, 'doSelectJoinMemberRelatedByMember2Id', 'doCountJoinMemberRelatedByMember2IdReverse');
    }

    public function executeMatches()
    {
        $this->getUser()->setAttribute('last_search_url', 'search/matches');
        
        $this->has_criteria = true;
        if (! $this->getUser()->getProfile()->hasSearchCriteria())
        {
            $this->has_criteria = false;
            return sfView::SUCCESS;
        }
        
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn('(pct+reverse_pct)');
        $rows = sfConfig::get('app_settings_search_rows_matches', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row        
        $this->initPager($c, $per_page);
    }

    public function executeByKeyword()
    {
        $this->getUser()->setAttribute('last_search_url', 'search/byKeyword');
        
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        if (isset($this->filters['keyword']) && strlen($this->filters['keyword']) > 3)
        {
            $crit = $c->getNewCriterion(MemberPeer::ESSAY_HEADLINE, '%' . $this->filters['keyword'] . '%', Criteria::LIKE);
            $crit->addOr($c->getNewCriterion(MemberPeer::ESSAY_INTRODUCTION, '%' . $this->filters['keyword'] . '%', Criteria::LIKE));
            $c->add($crit);
            $rows = sfConfig::get('app_settings_search_rows_keyword', 4);
            $per_page = $rows * 3; //3 boxes/profiles per row        
            $this->initPager($c, $per_page);
        }
    }

    public function executeProfileID()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->member = MemberPeer::retrieveByPkJoinAll($this->getRequestParameter('profile_id'));
        }
    }

    public function executeSelectAreas()
    {
			  $key =  sfConfig::get('app_gmaps_key_' . str_replace('.', '_', $this->getRequest()->getHost()));
        $this->getResponse()->addJavascript('http://maps.google.com/maps?file=api&v=2&key=' . $key);
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
				$key =  sfConfig::get('app_gmaps_key_' . str_replace('.', '_', $this->getRequest()->getHost()));
        $this->getResponse()->addJavascript('http://maps.google.com/maps?file=api&v=2&key=' . $key);
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

    public function executeSelectCountries()
    {
        $user = $this->getUser();
        $user->getBC()->removeFirst()->add(array('name' => 'Select Countries', 'search/selectCountries'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $user->getAttributeHolder()->removeNamespace('frontend/search/countries');
            $user->getAttributeHolder()->add($this->getRequestParameter('countries'), 'frontend/search/countries');
            
            $this->setFlash('msg_ok', 'Success, your changes have been saved. To return to your search, click here.', false);
        }
        
        $this->selected_countries = $user->getAttributeHolder()->getAll('frontend/search/countries');
        
        $c = new sfCultureInfo($user->getCulture());
        $countries = $c->getCountries();
        //remove continents out of the array ( first 30 elements )
        $countries = array_slice($countries, 30, null, true);
        asort($countries);
        $this->countries = $countries;

        $this->adm1s = GeoPeer::getCountriesWithStates();
    }
    
    public function handleErrorSelectCountries()
    {
        $user = $this->getUser();
        $user->getBC()->add(array('name' => 'Select Countries', 'search/selectCountries'));
            	
        $this->selected_countries = $user->getAttributeHolder()->getAll('frontend/search/countries');
        $c = new sfCultureInfo($user->getCulture());
        $countries = $c->getCountries();
        //remove continents out of the array ( first 30 elements )
        $countries = array_slice($countries, 30, null, true);
        asort($countries);
        $this->countries = $countries;

        $this->adm1s = GeoPeer::getCountriesWithStates(); 

        return sfView::SUCCESS;
    }

    public function executeAreaFilter()
    {
        $adm1 = GeoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($adm1);
        
        $country = $adm1->getCountry();
        
        $countries[] = $country;
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/countries');
        $this->getUser()->getAttributeHolder()->add($countries, 'frontend/search/countries');
        
        $selected_areas[$country] = array($adm1->getId());
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/areas');
        $this->getUser()->getAttributeHolder()->add($selected_areas, 'frontend/search/areas');
        
        $filters = array('location' => 1);
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters');
        $this->getUser()->getAttributeHolder()->add($filters, 'frontend/search/filters');
        
        $this->redirect('search/index');
    }

    protected function initPager(Criteria $c, $per_page = 12, $peerMethod = 'doSelectJoinMemberRelatedByMember2Id', $peerCountMethod = 'doCountJoinMemberRelatedByMember2Id')
    {
        $profile_pager_members = MemberMatchPeer::doSelectJoinMemberRelatedByMember2IdRS($c);
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/profile_pager');
        $this->getUser()->getAttributeHolder()->add($profile_pager_members, 'frontend/search/profile_pager');
        
        $pager = new sfPropelPager('MemberMatch', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod($peerMethod);
        $pager->setPeerCountMethod($peerCountMethod);
        $pager->setMaxRecordLimit(600); //max 600 results due to FS
        $pager->init();
        $this->pager = $pager;
    }

    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'frontend/search/filters');
        }
    }

    protected function addGlobalCriteria(Criteria $c)
    {
        $c->add(MemberMatchPeer::MEMBER1_ID, $this->getUser()->getId());
    }

    protected function processPublicFilters(Criteria $c)
    {
        $filters = $this->filters;
        
        if (isset($filters['location']) && $filters['location'] == 2)
        {
            $this->getRequest()->setError('filter', 'You must be registered member to use area filter');
            $filters['location'] = 0;
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

    protected function addFiltersCriteria(Criteria $c)
    {
        if (isset($this->filters['only_with_video']))
        {
            $c->add(MemberPeer::YOUTUBE_VID, NULL, Criteria::ISNOTNULL);
        }
        
        switch ($this->filters['location']) {
            //in selected countries only
            case 1:
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
                break;
            //within given radius from where I live
            case 2:
                $this->validateRadius();
                $user = $this->getUser();
                $member = MemberPeer::retrieveByPK($user->getId());
                $cityid = $member->getCityId();
                $radius = $this->filters['radius'];
                
                if ($this->filters['kmmils'] == 'km') // must convert kilometers in miles 
                {
                    $radius = $radius / 1.61; // One mile is 1.61 kilometers 
                }                

                $conf = Propel::getConfiguration();
                $conf = $conf['datasources']['propel']['connection'];
                unset($conf['port']);
                $conf['phptype'] = 'mysqli';
                $connection = Creole::getConnection($conf);
                
                $sql="call radiussearch(%d,%d)";
                $sql = sprintf($sql, $cityid, $radius);

                $stmt = $connection->createStatement();
                $rs = $stmt->executeQuery($sql, ResultSet::FETCHMODE_ASSOC);

                if($rs)
                {
                    $area_aray = array();
                    foreach ($rs as $result)
                    {
                        array_push($area_aray, $result['id']);
                    }
                    $crit = $c->getNewCriterion(MemberPeer::CITY_ID, $area_aray, Criteria::IN);
                }
                
                break;
            default:
                break;
        }
        
        if (isset($crit) && $this->filters['location'] != 0 && isset($this->filters['include_poland']))
        {
            $polish_areas = $this->getUser()->getAttributeHolder()->getAll('frontend/search/polish_areas');
            $crit3 = $c->getNewCriterion(MemberPeer::COUNTRY, 'PL');
            if (count($polish_areas) > 0)
            {
                $crit3->addAnd($c->getNewCriterion(MemberPeer::ADM1_ID, $polish_areas, Criteria::IN));
            }
            
            $crit->addOr($crit3);
        }
        if (isset($crit))
            $c->add($crit);
    }
    
    protected function validateRadius()
    {
        $radius = $this->filters['radius'];
        
        if( !$radius )
        {
            $this->setFlash('msg_error', "Please enter radius");
            $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters');
            $this->redirect($this->getUser()->getAttribute('last_search_url', 'search/index'));
        }
        
        if( $radius < 0 || $radius >1000 )
        {
            $this->setFlash('msg_error', "Radius must be betwen 0 and 1000");
            $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters');
            $this->redirect($this->getUser()->getAttribute('last_search_url', 'search/index'));
        }       
    }
}
