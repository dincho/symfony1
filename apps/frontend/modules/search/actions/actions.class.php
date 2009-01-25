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
        $c->setLimit(12);
        
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
        
        $c->addDescendingOrderByColumn('reverse_pct');
        $rows = sfConfig::get('app_settings_search_rows_reverse', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row        
        $this->initPager($c, $per_page);
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
        $this->getResponse()->addJavascript('http://maps.google.com/maps?file=api&v=2&key=' . sfConfig::get('app_gmaps_key'));
        $this->getResponse()->addJavascript('areas_map.js');
        $country = $this->getRequestParameter('country');
        $polish_cities = $this->getRequestParameter('polish_cities');
        $user = $this->getUser();
        $user->getBC()->add(array('name' => 'Select Areas', 'search/selectAreas'));
        
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
            
            if( $user->isAuthenticated() )
            {
                $this->redirect('search/index');
            } else {
                $this->redirect('search/public');
            }
        }
        
        if ($polish_cities)
        {
            $this->selected_areas = $user->getAttributeHolder()->getAll('frontend/search/polish_areas');
        } else
        {
            $selected_areas = $user->getAttributeHolder()->getAll('frontend/search/areas');
            $this->selected_areas = isset($selected_areas[$country]) ? $selected_areas[$country] : array();
        }
        
        $this->areas = StatePeer::getAllByCountry($country);
    }

    public function executeSelectCountries()
    {
        $user = $this->getUser();
        $user->getBC()->add(array('name' => 'Select Countries', 'search/selectCountries'));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $user->getAttributeHolder()->removeNamespace('frontend/search/countries');
            $user->getAttributeHolder()->add($this->getRequestParameter('countries'), 'frontend/search/countries');
            
            if( $user->isAuthenticated() )
            {
                $this->redirect('search/index');
            } else {
                $this->redirect('search/public');
            }
        }
        
        $this->selected_countries = $this->getUser()->getAttributeHolder()->getAll('frontend/search/countries');
        $c = new sfCultureInfo(sfContext::getInstance()->getUser()->getCulture());
        $this->countries = $c->getCountries();
        asort($this->countries);
        $this->states = StatePeer::getCountriesWithStates();
    }

    public function executeAreaFilter()
    {
        $state = StatePeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($state);
        
        $country = $state->getCountry();
        
        $countries[] = $country;
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/countries');
        $this->getUser()->getAttributeHolder()->add($countries, 'frontend/search/countries');
        
        $selected_areas[$country] = array($state->getId());
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/areas');
        $this->getUser()->getAttributeHolder()->add($selected_areas, 'frontend/search/areas');
        
        $filters = array('location' => 1);
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters');
        $this->getUser()->getAttributeHolder()->add($filters, 'frontend/search/filters');
        
        $this->redirect('search/index');
    }

    protected function initPager(Criteria $c, $per_page = 12)
    {
        $profile_pager_members = MemberMatchPeer::doSelectJoinMemberRelatedByMember2IdRS($c);
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/profile_pager');
        $this->getUser()->getAttributeHolder()->add($profile_pager_members, 'frontend/search/profile_pager');
        
        $pager = new sfPropelPager('MemberMatch', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinMemberRelatedByMember2Id');
        $pager->setPeerCountMethod('doCountJoinMemberRelatedByMember2Id');
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
                    //print_r($selected_countries);print_r($selected_areas);exit();
                    foreach ($selected_countries as $key => $selected_country)
                    {
                        if (array_key_exists($selected_country, $selected_areas))
                        {
                            $crit = $c->getNewCriterion(MemberPeer::COUNTRY, $selected_country);
                            $crit->addAnd($c->getNewCriterion(MemberPeer::STATE_ID, $selected_areas[$selected_country], Criteria::IN));
                            //$crit->addOr($crit2);
                            

                            unset($selected_countries[$key]);
                        }
                    }
                    
                    if (!isset($crit)) $crit = $c->getNewCriterion(MemberPeer::COUNTRY, $selected_countries, Criteria::IN);
                }
                break;
            //in my state only
            case 2:
                $crit = $c->getNewCriterion(MemberPeer::STATE_ID, $this->getUser()->getProfile()->getStateId());
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
                $crit3->addAnd($c->getNewCriterion(MemberPeer::STATE_ID, $polish_areas, Criteria::IN));
            }
            
            $crit->addOr($crit3);
        }
        if (isset($crit))
            $c->add($crit);
    }
}
