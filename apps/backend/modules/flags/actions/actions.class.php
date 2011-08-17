<?php
/**
 * flags actions.
 *
 * @package    pr
 * @subpackage flags
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class flagsActions extends sfActions
{

    public function preExecute()
    {
        $this->getUser()->getBC()->removeLast(); //remove action element
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/flags/filters');
        $this->getResponse()->addJavascript('preview.js');
    }

    public function executeSuspended()
    {
        $this->sort_namespace = 'backend/flags/suspended/sort';
        $this->processSort();
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'Member::last_status_change', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $this->sort_namespace); //default order
        }
                        
        $c = new Criteria();
        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAll');
        $pager->setPeerCountMethod('doCountJoinAll');
        $pager->init();
        $this->pager = $pager;        
    }

    public function executeList()
    {
        $this->sort_namespace = 'backend/flags/list/sort';
        $this->processSort();
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'Member::last_flagged', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $this->sort_namespace); //default order
        }
                
        $this->is_history = ( isset($this->filters['history']) && $this->filters['history'] == 1) ? true : false;
            
        $c = new Criteria();
        $c->addJoin(FlagPeer::MEMBER_ID, MemberPeer::ID);
        //$c->addGroupByColumn(FlagPeer::MEMBER_ID);
        $c->setDistinct();
		$this->addFiltersCriteria($c);
		$this->addSortCriteria($c);
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAll');
        $pager->setPeerCountMethod('doCountJoinAll');
        $pager->init();
        $this->pager = $pager;
    }

    public function executeFlaggers()
    {
        $this->getUser()->getBC()->add(array('name' => 'Flaggers', 'uri' => 'flags/flaggers'));
        $this->left_menu_selected = 'Flaggers';
        
        $this->sort_namespace = 'backend/flags/flaggers/sort';
        $this->processSort();
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'MemberCounter::sent_flags', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $this->sort_namespace); //default order
        }
                
        $c = new Criteria();
        $c->addJoin(FlagPeer::FLAGGER_ID, MemberPeer::ID);
        $c->add(FlagPeer::IS_HISTORY, false);
        $c->addGroupByColumn(FlagPeer::FLAGGER_ID);

        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);

        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAll');
        $pager->setPeerCountMethod('doCount');
        $pager->init();
        $this->pager = $pager;
    }
    
    public function executeProfileFlagged()
    {
        $this->member = MemberPeer::retrieveByPkJoinAll($this->getRequestParameter('id'));
        $this->forward404Unless($this->member);
        
        $bc = $this->getUser()->getBC();
        $bc->add(array('name' => 'Flags', 'uri' => 'flags/list'));
        $bc->add(array('name' => $this->member->getUsername(), 'uri' => 'members/edit?id=' . $this->member->getId()));
        $this->left_menu_selected = 'Flags';
        
        
        $c = new Criteria();
        $c->add(FlagPeer::MEMBER_ID, $this->member->getId());
        $c->add(FlagPeer::IS_HISTORY, false);
        $this->flags = FlagPeer::doSelectJoinAll($c);
        
        $c = new Criteria();
        $c->add(MemberNotePeer::MEMBER_ID, $this->member->getId());
        $this->notes = MemberNotePeer::doSelectJoinAll($c);

    }
    
    public function executeProfileFlagger()
    {
        $this->member = MemberPeer::retrieveByPkJoinAll($this->getRequestParameter('id'));
        $this->forward404Unless($this->member);
        
        $bc = $this->getUser()->getBC();
        $bc->add(array('name' => 'Flaggers', 'uri' => 'flags/flaggers'));
        $bc->add(array('name' => $this->member->getUsername(), 'uri' => 'members/edit?id=' . $this->member->getId()));
        $this->left_menu_selected = 'Flaggers';
        
        
        $c = new Criteria();
        $c->add(FlagPeer::FLAGGER_ID, $this->member->getId());
        $this->flags = FlagPeer::doSelectJoinAll($c);
        
        $c = new Criteria();
        $c->add(MemberNotePeer::MEMBER_ID, $this->member->getId());
        $this->notes = MemberNotePeer::doSelectJoinAll($c);

    }
    
    public function executeSuspend()
    {
        $member = MemberPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($member);

        $member->changeStatus(MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED);
        $member->save();
        $member->resetFlags();
        
        $this->setFlash('msg_ok', $member->getUsername() . ' has been suspended.');
        $this->redirect('flags/profileFlagged?id=' . $member->getId());
    }
    
    public function executeUnsuspend()
    {
        $member = MemberPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($member);

        $member->changeStatus(MemberStatusPeer::ACTIVE);
        $member->save();
        
        $this->setFlash('msg_ok', $member->getUsername() . ' has been un-suspended.');
        $this->redirect('flags/profileFlagged?id=' . $member->getId());
    }
    
    public function executeReset()
    {
        $member = MemberPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($member);

        $member->resetFlags();
        
        $this->setFlash('msg_ok', $member->getUsername() . "'s flags has been reset.");
        $this->redirect('flags/profileFlagged?id=' . $member->getId());
    }
    
    protected function processSort()
    {
        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }
    }

    protected function addSortCriteria($c)
    {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $sort_arr = explode('::', $sort_column);
            $peer = $sort_arr[0] . 'Peer';
            
            $sort_column = call_user_func(array($peer, 'translateFieldName'), $sort_arr[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
            if ($this->getUser()->getAttribute('type', null, $this->sort_namespace) == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
            } else
            {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }
        
    protected function processFilters()
    {
            $filters = $this->getRequestParameter('filters');
            
            //some default values
            if (!isset($filters['confirmed'])) $filters['confirmed'] = 0;
            if (!isset($filters['history'])) $filters['history'] = 0;
            
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/flags/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/flags/filters');
    }

    protected function addFiltersCriteria(Criteria $c)
    {
        $bc = $this->getUser()->getBC();
        
        if ( isset($this->filters['history']) && $this->getActionName() == 'list')
        {
            switch ($this->filters['history']) {
                case 0:
                    $bc->add(array('name' => 'List', 'uri' => 'flags/list?filter=filter&filters[history]=0'));
                    $this->left_menu_selected = 'Flags';
                    break;
                case 1:
                    $bc->add(array('name' => 'History', 'uri' => 'imbra/list?filter=filter&filters[history]=1'));
                    $this->left_menu_selected = 'Flag History';
                    break;
                default:
                    break;
            }
                        
            $bHistory = (bool) $this->filters['history'];
            $c->add(FlagPeer::IS_HISTORY, $bHistory);
        }
        
        if ( isset($this->filters['confirmed']) && $this->getActionName() == 'suspended')
        {
            switch ($this->filters['confirmed']) {
                case 0:
                    $bc->add(array('name' => 'New Suspension by Flagging', 'uri' => 'flags/list?filter=filter&filters[confirmed]=0'));
                    $this->left_menu_selected = 'New Susp. by Flagging';
                    $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::SUSPENDED_FLAGS);
                    break;
                case 1:
                    $bc->add(array('name' => 'Confirmed Suspensions', 'uri' => 'imbra/list?filter=filter&filters[confirmed]=1'));
                    $this->left_menu_selected = 'Susp. By Flagging Confirmed';
                    $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED);
                    break;
                default:
                    break;
            }      
        }
        
        if (isset($this->filters['search_type']) && isset($this->filters['search_query']) && strlen($this->filters['search_query']) > 0)
        {
            switch ($this->filters['search_type']) {
                case 'first_name':
                    $c->add(MemberPeer::FIRST_NAME, $this->filters['search_query']);
                    break;
                case 'last_name':
                    $c->add(MemberPeer::LAST_NAME, $this->filters['search_query']);
                    break;
                
                case 'email':
                    $c->add(MemberPeer::EMAIL, $this->filters['search_query']);
                    break;
                default:
                    $c->add(MemberPeer::USERNAME, $this->filters['search_query']);
                    break;
            }
        }        
    }
}
