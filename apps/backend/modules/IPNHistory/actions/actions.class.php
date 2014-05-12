<?php

/**
 * IPNHistory actions.
 *
 * @package    PolishRomance
 * @subpackage IPNHistory
 * @author     Dincho Todorov <dincho
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class IPNHistoryActions extends sfActions
{
    public function executeIndex()
    {
        $this->forward('IPNHistory', 'list');
    }

    public function executeList()
    {
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/IPNHistory/filters');

        $this->processSort();

        $c = new Criteria();
        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);

        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('IpnHistory', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->init();
        $this->pager = $pager;
    }

    public function executeDetails()
    {
        $this->history = IpnHistoryPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($this->history);
    }

    protected function processSort()
    {
        $this->sort_namespace = 'backend/IPNHistory/sort';

        if ($this->getRequestParameter('sort')) {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }

        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace)) {
            $this->getUser()->setAttribute('sort', 'IpnHistory::created_at', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $this->sort_namespace); //default order
        }
    }

    protected function addSortCriteria($c)
    {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace)) {
            $sort_arr = explode('::', $sort_column);
            $peer = $sort_arr[0] . 'Peer';

            $sort_column = call_user_func(array($peer,'translateFieldName'), $sort_arr[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
            if ($this->getUser()->getAttribute('type', null, $this->sort_namespace) == 'asc') {
                $c->addAscendingOrderByColumn($sort_column);
            } else {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }

    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter')) {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/IPNHistory/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/IPNHistory/filters');
        }
    }

    protected function addFiltersCriteria($c)
    {
        if (isset($this->filters['subscr_id']) && strlen($this->filters['subscr_id']) > 0) {
            $c->add(IpnHistoryPeer::SUBSCR_ID, $this->filters['subscr_id']);
        }

        if (isset($this->filters['txn_type']) && strlen($this->filters['txn_type']) > 0) {
            $c->add(IpnHistoryPeer::TXN_TYPE, $this->filters['txn_type']);
        }
    }
}
