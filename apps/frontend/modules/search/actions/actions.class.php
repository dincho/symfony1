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
    
    protected function initPager(Criteria $c, $peedMethod = 'doSelect')
    {
        $pager = new sfPropelPager('Matches', 12);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod($peedMethod);
        $pager->setPeerCountMethod('doCount');
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

    }
}
