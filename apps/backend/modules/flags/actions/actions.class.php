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
        if (! isset($this->filters['confirmed']))
            $this->filters['confirmed'] = 0;
        $c = new Criteria();
        $this->addFiltersCriteria($c);
        //Breadcrumb item
        if (array_key_exists('confirmed', $this->filters))
        {
            $bc = $this->getUser()->getBC();
            switch ($this->filters['confirmed']) {
                case 0:
                    $bc->add(array('name' => 'New Suspension by Flagging', 'uri' => 'flags/list?filter=filter&filters[confirmed]=0'));
                    $this->left_menu_selected = 'New Susp. by Flagging';
                    break;
                case 1:
                    $bc->add(array('name' => 'Confirmed Suspensions', 'uri' => 'imbra/list?filter=filter&filters[confirmed]=1'));
                    $this->left_menu_selected = 'Susp. By Flagging Confirmed';
                    break;
                default:
                    break;
            }
        }
    }

    public function executeList()
    {
        if (! isset($this->filters['history']))
            $this->filters['history'] = 0;
        $c = new Criteria();
        $c->addJoin(FlagPeer::MEMBER_ID, MemberPeer::ID);
        $c->addGroupByColumn(FlagPeer::MEMBER_ID);
        $c->addDescendingOrderByColumn(MemberPeer::LAST_FLAGGED);
		$this->addFiltersCriteria($c);        
        
        $per_page = ( $this->getRequestParameter('per_page', 0) <= 0 ) ? sfConfig::get('app_pager_default_per_page') : $this->getRequestParameter('per_page');
        
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAll');
        $pager->setPeerCountMethod('doCountJoinAll');
        $pager->init();
        $this->pager = $pager;
        
        //it won`t to order, db restriction becuase of group by
        //$c->addDescendingOrderByColumn(FlagPeer::CREATED_AT);
        
        //$this->members = MemberPeer::doSelectJoinAll($c);
        //Breadcrumb item
        if (array_key_exists('history', $this->filters))
        {
            $bc = $this->getUser()->getBC();
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
        }
    }

    public function executeFlaggers()
    {
        $this->getUser()->getBC()->add(array('name' => 'Flaggers', 'uri' => 'flags/flaggers'));
        $this->left_menu_selected = 'Flaggers';
        //
        $c = new Criteria();
        $c->addJoin(FlagPeer::FLAGGER_ID, MemberPeer::ID);
        $c->add(FlagPeer::IS_HISTORY, false);
        $c->addGroupByColumn(FlagPeer::MEMBER_ID);
        $c->addAsColumn('num_members', 'COUNT(' . FlagPeer::MEMBER_ID . ')');

        $this->addFiltersCriteria($c);
        $rs = FlagPeer::doSelectRS($c);
        $results = array();
        while ($rs->next())
        {
            $flag = new Flag();
            // hydrate the object and store how many columns it has
            $lastColumn = $flag->hydrate($rs);
            
            $flag->num_members = $rs->getInt($lastColumn);
            $results[] = $flag;
            // then retrieve the COUNT from the first column not belonging to the object
            //$counts[] = $rs->getInt($lastColumn);
        }
        $this->flags = $results;
        //$this->counts = $counts;
        //it won`t to order, db restriction becuase of group by
        //$c->addDescendingOrderByColumn(FlagPeer::CREATED_AT);
        
        //$this->flags = FlagPeer::doSelect($c);
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
    
    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/flags/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/flags/filters');
        }
    }

    protected function addFiltersCriteria($c)
    {
        if ( isset($this->filters['history']) && $this->getActionName() == 'list')
        {
            $bHistory = (bool) $this->filters['history'];
            $c->add(FlagPeer::IS_HISTORY, $bHistory);
        }
    }
}
