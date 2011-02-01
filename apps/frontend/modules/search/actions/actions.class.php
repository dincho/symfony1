<?php

/**
 * search actions.
 *
 * @package    pr
 * @subpackage search
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class searchActions extends BaseSearchActions
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
        // set location =0 for @matches              
        $filters['location']= 0; 
        $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/filters');
        $this->getUser()->getAttributeHolder()->add($filters, 'frontend/search/filters');

        $this->forward($this->getModuleName(), 'mostRecent');
    }

    public function executeMostRecent()
    {

        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $sort_by_subscription = sprintf("FIELD(%s,%s)", MemberPeer::SUBSCRIPTION_ID, implode(',', array(SubscriptionPeer::VIP, SubscriptionPeer::PREMIUM, SubscriptionPeer::FREE)) );
        $c->addAscendingOrderByColumn( $sort_by_subscription );
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);
        $rows = sfConfig::get('app_settings_search_rows_most_recent', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row
        $this->initPager($c, $per_page);
        
        $this->getUser()->setAttribute('last_search_url', 'search/mostRecent?page=' . $this->pager->getPage());

        //add ajax support
        if($this->getRequest()->isXmlHttpRequest())
        {
          sfLogger::getInstance()->info(" isXmlHttpRequest "); 
          $this->setLayout(false);
          return 'Ajax';
        }
    }

    public function executeLastLogin()
    {
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn(MemberPeer::LAST_LOGIN);
        $rows = sfConfig::get('app_settings_search_rows_last_login', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row
        $this->initPager($c, $per_page);
        
        $this->getUser()->setAttribute('last_search_url', 'search/lastLogin?page=' . $this->pager->getPage());

        //add ajax support
        if($this->getRequest()->isXmlHttpRequest())
        {
          sfLogger::getInstance()->info(" isXmlHttpRequest ");
          $this->setLayout(false);
          return 'Ajax';
        }
    }
    
    public function executeCriteria()
    {
        $this->has_criteria = true;
        if (! $this->getUser()->getProfile()->hasSearchCriteria())
        {
            $this->has_criteria = false;
            $this->setFlash('msg_ok', 'To see search results, please set up your search criteria', false);
            return sfView::SUCCESS;
        }
        
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn(MemberMatchPeer::PCT);
        $rows = sfConfig::get('app_settings_search_rows_custom', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row
        $this->initPager($c, $per_page);
        
        $this->getUser()->setAttribute('last_search_url', 'search/criteria?page=' . $this->pager->getPage());

        //add ajax support
        if($this->getRequest()->isXmlHttpRequest())
        {
          sfLogger::getInstance()->info(" isXmlHttpRequest ");
          $this->setLayout(false);
          return 'Ajax';
        }
    }

    public function executeReverse()
    {
        $c = new Criteria();
        $c->add(MemberMatchPeer::MEMBER2_ID, $this->getUser()->getId());
        $this->reverse_cnt = MemberMatchPeer::doCount($c);
        
        if( $this->reverse_cnt == 0 )
        {
            $this->setFlash('msg_ok', 'The results are calculated during the night, you will see them tomorrow', false);
            return sfView::SUCCESS;
        }
        
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addHaving($c->getNewCriterion(MemberMatchPeer::ID, 'reverse_pct > 0' ,Criteria::CUSTOM));
        $c->addDescendingOrderByColumn('reverse_pct');
        $rows = sfConfig::get('app_settings_search_rows_reverse', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row        
        $this->initPager($c, $per_page, 'doSelectJoinMemberRelatedByMember2Id', 'doCountJoinMemberRelatedByMember2IdReverse');
        
        $this->getUser()->setAttribute('last_search_url', 'search/reverse?page=' . $this->pager->getPage());

        //add ajax support
        if($this->getRequest()->isXmlHttpRequest())
        {
          sfLogger::getInstance()->info(" isXmlHttpRequest ");
          $this->setLayout(false);
          return 'Ajax';
        }
    }

    public function executeMatches()
    {
        $this->has_criteria = true;
        if (! $this->getUser()->getProfile()->hasSearchCriteria())
        {
            $this->has_criteria = false;
            $this->setFlash('msg_ok', 'To see search results, please set up your search criteria', false);
            return sfView::SUCCESS;
        }
        
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        $c->addDescendingOrderByColumn('(pct+reverse_pct)');
        $rows = sfConfig::get('app_settings_search_rows_matches', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row        
        $this->initPager($c, $per_page);
        
        $this->getUser()->setAttribute('last_search_url', 'search/matches?page=' . $this->pager->getPage());

        //add ajax support
        if($this->getRequest()->isXmlHttpRequest())
        {
          sfLogger::getInstance()->info(" isXmlHttpRequest ");
          $this->setLayout(false);
          return 'Ajax';
        }
    }

    public function executeByKeyword()
    {
        $this->getUser()->setAttribute('last_search_url', 'search/byKeyword');
        
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);
        
        if ( isset($this->filters['keyword']) && strlen($this->filters['keyword']) > 0 )
        {
            $crit = $c->getNewCriterion(MemberPeer::ESSAY_HEADLINE, '%' . $this->filters['keyword'] . '%', Criteria::LIKE);
            $crit->addOr($c->getNewCriterion(MemberPeer::ESSAY_INTRODUCTION, '%' . $this->filters['keyword'] . '%', Criteria::LIKE));
            $crit->addOr($c->getNewCriterion(MemberPeer::USERNAME, '%' . $this->filters['keyword'] . '%', Criteria::LIKE));
            $c->add($crit);
            $rows = sfConfig::get('app_settings_search_rows_keyword', 4);
            $per_page = $rows * 3; //3 boxes/profiles per row        
            $this->initPager($c, $per_page);
            
            $this->getUser()->setAttribute('last_search_url', 'search/byKeyword?page=' . $this->pager->getPage());

          //add ajax support
          if($this->getRequest()->isXmlHttpRequest())
          {
            sfLogger::getInstance()->info(" isXmlHttpRequest ");
            $this->setLayout(false);
            return 'Ajax';
          }
       }
    }

    public function executeByRate()
    {
        $c = new Criteria();
        $this->addGlobalCriteria($c);
        $this->addFiltersCriteria($c);

        $c->addJoin(MemberMatchPeer::MEMBER1_ID, MemberRatePeer::RATER_ID.' AND '.MemberMatchPeer::MEMBER2_ID.' = '.MemberRatePeer::MEMBER_ID, Criteria::LEFT_JOIN);
        $c->addDescendingOrderByColumn(MemberRatePeer::RATE);
        $rows = sfConfig::get('app_settings_search_rate', 4);
        $per_page = $rows * 3; //3 boxes/profiles per row
        $this->initPager($c, $per_page);
        
        $this->getUser()->setAttribute('last_search_url', 'search/byRate?page=' . $this->pager->getPage());

        //add ajax support
        if($this->getRequest()->isXmlHttpRequest())
        {
          sfLogger::getInstance()->info(" isXmlHttpRequest ");
          $this->setLayout(false);
          return 'Ajax';
        }
    }
 

    public function executeProfileID()
    {
        if ( $this->getRequestParameter('profile_id') )
        {
          $c = new Criteria();
          $c->addJoin(MemberMatchPeer::MEMBER2_ID, MemberPeer::ID);
          
          $this->addGlobalCriteria($c);
          $this->addFiltersCriteria($c);
          
          $c->add(MemberMatchPeer::MEMBER2_ID, $this->getRequestParameter('profile_id'));
          $this->match = MemberMatchPeer::doSelectOne($c);
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
        
        $this->redirect('search/mostRecent');
    }

    protected function initPager(Criteria $c, $per_page = 12, $peerMethod = 'doSelectJoinMemberRelatedByMember2Id', $peerCountMethod = 'doCountJoinMemberRelatedByMember2Id')
    {
        //update profile pager only on first page 
        //this is some kind of optimization and also allows to not pass the pp_no_update parameter all over the pager
        if( $this->getRequestParameter('page', 1)  == 1 && !$this->getRequestParameter('pp_no_update') )
        {
            $profile_pager_members = MemberMatchPeer::doSelectJoinMemberRelatedByMember2IdRS($c);
            $pager_cache_dir = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'search_profile_pager';
            $pager_cache = new sfFileCache($pager_cache_dir);
            $pager_cache->set($this->getUser()->getId(), null, serialize($profile_pager_members));
            $this->debugMessage('Created search profile pager file: ' . $pager_cache_dir);
        }
        

        $pager = new sfPropelPager('MemberMatch', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod($peerMethod);
        $pager->setPeerCountMethod($peerCountMethod);
        
        $profile = $this->getUser()->getProfile();
        if( sfConfig::get('app_settings_man_should_pay') && $profile->isFree() &&
            $profile->getSex() == 'M' && $profile->getLookingFor() == 'F'
          ) 
        {
            $pager->setMaxRecordLimit(600);
        }
        
        $pager->init();
        $this->pager = $pager;
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
  
}
