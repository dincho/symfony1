<?php

/**
 * reports actions.
 *
 * @package    pr
 * @subpackage reports
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class reportsActions extends sfActions
{

    public function preExecute()
    {
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/reports/filters');
    }

    public function executeList()
    {
        $this->forward('reports', 'dailySales');
    }

    public function executeDailySales()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Daily Sales'));
        
        $this->dailySalesByStatus = Reports::getDaylySalesByStatus($this->filters);
        $this->dailySalesLambdas = array(1, -1, -1, 1, -1, -1, 1, -1, -11);
        
        $this->dailySalesPaidMembers = Reports::getDaylySalesPaidMembers($this->filters);
        $this->dailySalesPaidMembersLambdas = array(1, 1, 1, 1, -1, -1, -1, -1, 1, -1);
    }

    public function executeMemberActivity()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Member Activity'));
        
        $this->memberContacts = Reports::getMemberContact($this->filters);
        $this->loginActivity = Reports::getLoginActivity();
         
        //most active members
        $c = new Criteria();
        $this->active_namespace = 'backend/reports/sort_active';
        $this->processActivitySort($this->active_namespace, 'sort_active', 'MemberCounter::profile_views');
        $this->addActivitySortCriteria($c, $this->active_namespace, 'sort_active');
        $c->setLimit(60);
        $this->mostActiveMembers = MemberPeer::doSelectJoinMemberCounter($c);
        
        //most popular members
        $c = new Criteria();
        $this->popular_namespace = 'backend/reports/sort_popular';
        $this->processActivitySort($this->popular_namespace, 'sort_popular', 'MemberCounter::made_profile_views');
        $this->addActivitySortCriteria($c, $this->popular_namespace, 'sort_popular');
        $c->setLimit(60);
        $this->mostPopularMembers = MemberPeer::doSelectJoinMemberCounter($c);
    }
    
    protected function processActivitySort($namespace, $sort_column, $default)
    {
        if ($this->getRequestParameter($sort_column))
        {
            $this->getUser()->setAttribute($sort_column, $this->getRequestParameter($sort_column), $namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $namespace);
        }
        
        if (! $this->getUser()->getAttribute($sort_column, null, $namespace))
        {
            $this->getUser()->setAttribute($sort_column, $default, $namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $namespace); //default order
        }        
    }
    
    protected function addActivitySortCriteria($c, $namespace, $sort_field)
    {
        if ($sort_column = $this->getUser()->getAttribute($sort_field, null, $namespace))
        {
            $sort_arr = explode('::', $sort_column);
            $peer = $sort_arr[0] . 'Peer';
            
            $sort_column = call_user_func(array($peer, 'translateFieldName'), $sort_arr[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
            if ($this->getUser()->getAttribute('type', null, $namespace) == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
            } else
            {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }    

    public function executeActiveMembers()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Active Members'));
        
        $this->subscriptions = SubscriptionPeer::doSelect(new Criteria());
    }

    public function executeFlagsSuspensions()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Flags/ Suspensions'));
        
        $this->flagsSuspensions = Reports::getFlagsSuspensions($this->filters);
        $this->suspensions = Reports::getSuspensions($this->filters);
        $this->mostActiveFlaggers = Reports::getMostActiveFlaggers();
    }

    public function executeRegistration()
    {
        $this->objects = Reports::getRegistration($this->filters);
    }

    public function executeOutgoingEmails()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Outgoing Emails'));
        
        $this->outgoingMails = Reports::getOutgoingEmails();
    }

    
    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            if (isset($filters['date_from']) && $filters['date_from'] !== '')
            {
                list($m, $d, $y) = explode('/', $filters['date_from']);
                $filters['date_from'] = mktime(0, 0, 0, $m, $d, $y);
            }
            
            if (isset($filters['date_to']) && $filters['date_to'] !== '')
            {
                list($m, $d, $y) = explode('/', $filters['date_to']);
                $filters['date_to'] = mktime(23, 59, 59, $m, $d, $y);
            }
        } else {
            $filters['date_from'] = mktime(0, 0, 0, date('n'), date('j')-3, date('Y'));
            $filters['date_to'] = mktime(23, 59, 59, date('n'), date('j'), date('Y'));
        }
        
        $this->getUser()->getAttributeHolder()->removeNamespace('backend/reports/filters');
        $this->getUser()->getAttributeHolder()->add($filters, 'backend/reports/filters');
    }    

}
