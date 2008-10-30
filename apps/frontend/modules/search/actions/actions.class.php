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
    
    
    public function executeSelectCountries()
    {
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $this->getUser()->getAttributeHolder()->removeNamespace('frontend/search/countries');
            $this->getUser()->getAttributeHolder()->add($this->getRequestParameter('countries'), 'frontend/search/countries');
            
            $this->redirect($this->getUser()->getRefererUrl());
        }
        
        $this->selected_countries = $this->getUser()->getAttributeHolder()->getAll('frontend/search/countries');
        $c = new sfCultureInfo(sfContext::getInstance()->getUser()->getCulture());
        $this->countries = $c->getCountries();
        asort($this->countries);
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
                    $crit = $c->getNewCriterion(MemberPeer::COUNTRY, $selected_countries, Criteria::IN);
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
            $crit2 = $c->getNewCriterion(MemberPeer::COUNTRY, 'PL');
            $crit->addOr($crit2);
        }
        if( isset( $crit) ) $c->add($crit);
    }
}
