<?php

/**
 * search actions.
 *
 * @package    pr
 * @subpackage search
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class searchActions extends sfActions
{
    public function preExecute()
    {
        $this->getUser()->getBC()->clear()
            ->add(array('name' => 'dashboard', 'uri' => 'dashboard/index'))
            ->add(array('name' => 'search', 'uri' => 'search/index'));
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('frontend/search/filters');
        if( !isset($this->filters['location']) ) $this->filters['location'] = 0;
    }
    
    public function executePublic()
    {
        $this->getUser()->getBC()->clear()
            ->add(array('name' => 'home', 'uri' => '@homepage'))
            ->add(array('name' => 'search', 'uri' => 'search/public'));
            
        $c = new Criteria();
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        //$c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ACTIVE);
        $c->setLimit(12);
        
        $this->members = MemberPeer::doSelectJoinAll($c);     
    }
    
    public function executeIndex()
    {
        $this->forward($this->getModuleName(), 'MostRecent');
    }
    
    public function executeMostRecent()
    {
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        $this->initPager($c, 'doSelectJoinMemberRelatedByMember2Id');
    }
    

    public function executeCriteria()
    {
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn('total_score');
        $this->initPager($c);
    }
    
    public function executeReverse()
    {
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn('reverse_score');
        $this->initPager($c);        
    }
    
    public function executeMatches()
    {
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn('combined_score');
        $this->initPager($c);          
    }
    
    public function executeByKeyword()
    {
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $this->initPager($c, 'doSelectJoinMemberRelatedByMember2Id');          
    }
    
    public function executeProfileID()
    {
        
    }
    
    
    public function executeSelectAreas()
    {
        $this->getResponse()->addJavascript('http://maps.google.com/maps?file=api&v=2&key=' . sfConfig::get('app_gmaps_key'));
        $this->getResponse()->addJavascript('areas_map.js');
        $country = $this->getRequestParameter('country');
        $polish_cities = $this->getRequestParameter('polish_cities');
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $areas = $this->getRequestParameter('areas', array());
            $countries = $this->getUser()->getAttributeHolder()->getAll('frontend/search/countries');
            
            if(!$polish_cities && count($areas) > 0 && !in_array($country, $countries))
            {
                $countries[] = $country;
                $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/countries');
                $this->getUser()->getAttributeHolder()->add($countries, 'frontend/search/countries'); 
            }
            
            if( $polish_cities )
            {
                $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/polish_areas');
                $this->getUser()->getAttributeHolder()->add($areas, 'frontend/search/polish_areas');                  
            } else {
                $selected_areas[$country] = $areas;
                $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/areas');
                $this->getUser()->getAttributeHolder()->add($selected_areas, 'frontend/search/areas');                
            }

            $this->redirect($this->getUser()->getRefererUrl());
        }
        
        if( $polish_cities )
        {
            $this->selected_areas = $this->getUser()->getAttributeHolder()->getAll('frontend/search/polish_areas');
        } else {
            $selected_areas = $this->getUser()->getAttributeHolder()->getAll('frontend/search/areas');
            $this->selected_areas = isset($selected_areas[$country]) ? $selected_areas[$country] : array();
        }
        
        $this->areas = StatePeer::getAllByCountry($country);
    }
    
    public function executeSelectCountries()
    {
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/countries');
            $this->getUser()->getAttributeHolder()->add($this->getRequestParameter('countries'), 'frontend/search/countries');
            
            $this->redirect('search/index');
        }
        
        $this->selected_countries = $this->getUser()->getAttributeHolder()->getAll('frontend/search/countries');
        $c = new sfCultureInfo(sfContext::getInstance()->getUser()->getCulture());
        $this->countries = $c->getCountries();
        asort($this->countries);
        $this->states = StatePeer::getCountriesWithStates();
    }
    
    protected function initPager(Criteria $c, $peedMethod = 'doSelect', $countMethod = 'doCount')
    {
        $pager = new sfPropelPager('Matches', 12);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinMemberRelatedByMember2Id');
        $pager->setPeerCountMethod('doCountJoinMemberRelatedByMember2Id');
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
       $c->add(MatchesPeer::MEMBER1_ID, $this->getUser()->getId()); 
    }
    
    protected function addFiltersCriteria(Criteria $c)
    {
        if( isset($this->filters['only_with_video']) )
        {
            $c->add(MemberPeer::YOUTUBE_VID, NULL, Criteria::ISNOTNULL);
        }
        
        switch ($this->filters['location'])
        {
            //in selected countries only
            case 1:
                $selected_countries = $this->getUser()->getAttributeHolder()->getAll('frontend/search/countries');
                if( !empty($selected_countries) )
                {
                    $selected_areas = $this->getUser()->getAttributeHolder()->getAll('frontend/search/areas');
                    foreach ($selected_countries as $key => $selected_country)
                    {
                        if( array_key_exists($selected_country, $selected_areas) )
                        {
                            $crit = $c->getNewCriterion(MemberPeer::COUNTRY, $selected_country);
                            $crit->addAnd($c->getNewCriterion(MemberPeer::STATE_ID, $selected_areas[$selected_country], Criteria::IN));
                            //$crit->addOr($crit2);
                            
                            unset($selected_countries[$key]);
                        }
                    }
                    if( isset($crit) )
                    {
                        $crit->addOr($c->getNewCriterion(MemberPeer::COUNTRY, $selected_countries, Criteria::IN));    
                    } else {
                        $crit = $c->getNewCriterion(MemberPeer::COUNTRY, $selected_countries, Criteria::IN);
                    }
                }
                break;
            //in my state only
            case 2:
                $crit = $c->getNewCriterion(MemberPeer::STATE_ID, $this->getUser()->getProfile()->getStateId());
                break;
            default:
                break;
        }
        
        if( $this->filters['location'] != 0 && isset($this->filters['include_poland']) )
        {
            $polish_areas = $this->getUser()->getAttributeHolder()->getAll('frontend/search/polish_areas');
            $crit3 = $c->getNewCriterion(MemberPeer::COUNTRY, 'PL');
            if( count($polish_areas) > 0 )
            {
                $crit3->addAnd($c->getNewCriterion(MemberPeer::STATE_ID, $polish_areas, Criteria::IN));  
            }
            $crit->addOr($crit3);
        }
        if( isset( $crit) ) $c->add($crit);
    }
}
