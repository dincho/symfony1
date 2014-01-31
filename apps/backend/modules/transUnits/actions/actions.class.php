<?php
/**
 * transUnits actions.
 *
 * @package    pr
 * @subpackage transUnits
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class transUnitsActions extends sfActions
{

    public function preExecute()
    {
        if ($this->getRequestParameter('cancel') == 1)
        {
          $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved', false);
        }
            
        $this->left_menu_selected = 'Translation Units';
        $this->top_menu_selected = 'content';
        
        $bc = $this->getUser()->getBC();
        $bc->replaceFirst(array('name' => 'Translation Units', 'uri' => 'transUnits/list'));    
    }
    
    public function executeList()
    {
        $this->processSort();
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/transUnits/filters');
                
        $c = new Criteria();
        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);
        // $c->addAscendingOrderByColumn(TransUnitPeer::SOURCE);
        $c->add(TransUnitPeer::MSG_COLLECTION_ID, null, Criteria::ISNULL);
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('TransUnit', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAllExceptMsgCollection');
        $pager->setPeerCountMethod('doCountJoinAllExceptMsgCollection');
        $pager->init();
        $this->pager = $pager;  
        
        if( $this->getRequestParameter('page', 1)  == 1 )
            $this->getUser()->setAttribute('criteria', $c, 'backend/transUnits/pager');
        
        $this->catalogs = CataloguePeer::doSelect(new Criteria());
    }

    
    public function executeTagList()
    {
      $this->tags = TransUnitPeer::getTagsList();
    }
    
    
    public function executeCreate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            TransUnitPeer::createNewUnit($this->getRequestParameter('source'), 
                                         $this->getRequestParameter('tags'));
            $this->setFlash('msg_ok', 'Translation unit has been added.');
            $this->redirect('transUnits/list');
        }
    }
    
    public function handleErrorCreate()
    {
      return sfView::SUCCESS;
    }

    public function executeEditRelated()
    {
        $trans_unit = TransUnitPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($trans_unit);
                
        $c = new Criteria();
        $c->add(TransUnitPeer::SOURCE, $trans_unit->getSource());
        $c->add(TransUnitPeer::CAT_ID, $this->getRequestParameter('cat_id'));
        $unit = TransUnitPeer::doSelectOne($c);
        
        if( $unit )
        {
            $this->redirect('transUnits/edit?id=' . $unit->getId());
        } else {
            $this->setFlash('msg_error', 'Selected TU does not exist in the selected catalog!');
            $this->redirect('transUnits/edit?id=' . $trans_unit->getId());
        }
    }
    
    public function executeEdit()
    {            
        $trans_unit = TransUnitPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($trans_unit);
        $this->trans_unit = $trans_unit;
        
        $catalogue = $trans_unit->getCatalogue();
        if( $catalogue->getTargetLang() != 'en' )
        {
          $c = new Criteria();
          $c->add(TransUnitPeer::SOURCE, $trans_unit->getSource());
          $c->addJoin(TransUnitPeer::CAT_ID, CataloguePeer::CAT_ID);
          $c->add(CataloguePeer::TARGET_LANG, 'en');
          $c->add(CataloguePeer::DOMAIN, $catalogue->getDomain());
          $en_trans_unit = TransUnitPeer::doSelectOne($c);
          $this->en_trans_unit = $en_trans_unit;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            $trans_unit->setTranslated($this->getRequestParameter('translated'));
            //$trans_unit->setSource($this->getRequestParameter('source'));
            $trans_unit->setTarget($this->getRequestParameter('target'));
            $trans_unit->setTags($this->getRequestParameter('tags'));
            $trans_unit->setLink($this->getRequestParameter('link'));
            $trans_unit->save();

            // save cat related urls
            $c1 = new Criteria();
            $c1->add(TransUnitPeer::SOURCE, $trans_unit->getSource());
            $c2 = new Criteria();
            $c2->add(TransUnitPeer::LINK, $this->getRequestParameter('link'));
            BasePeer::doUpdate($c1, $c2, Propel::getConnection());

            if( $catalogue->getTargetLang() != 'en' && $en_trans_unit)
            {
                $en_trans_unit->setTarget($this->getRequestParameter('en_target'));
                $en_trans_unit->save();
            }
            
            //update all tags
            $select = new Criteria();
            $select->add(TransUnitPeer::SOURCE, $this->getRequestParameter('source'));
            
            $update = new Criteria();
            $update->add(TransUnitPeer::TAGS, $this->getRequestParameter('tags'));
            BasePeer::doUpdate($select, $update, Propel::getConnection());
            
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect($this->getUser()->getRefererUrl());                
        }
        
        $pager_crit = $this->getUser()->getAttribute('criteria', new Criteria(), 'backend/transUnits/pager');
        $this->pager = new TUPager($pager_crit, $this->trans_unit->getId());
        $this->pager->init();
    }

    public function handleErrorEdit()
    {
        $trans_unit = TransUnitPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($trans_unit);
        $this->trans_unit = $trans_unit;
        
        $catalogue = $trans_unit->getCatalogue();
        if( $catalogue->getTargetLang() != 'en' )
        {
          $c = new Criteria();
          $c->add(TransUnitPeer::SOURCE, $trans_unit->getSource());
          $c->addJoin(TransUnitPeer::CAT_ID, CataloguePeer::ID);
          $c->add(CataloguePeer::TARGET_LANG, 'en');
          $c->add(CataloguePeer::DOMAIN, $catalogue->getDomain());
          $en_trans_unit = TransUnitPeer::doSelectOne($c);
          
          $this->forward404Unless($en_trans_unit);
          $this->en_trans_unit = $en_trans_unit;
        }
              
      return sfView::SUCCESS;
    }
    
    public function executeDelete()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        $trans_unit = TransUnitPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($trans_unit);
        $trans_unit->delete();
        
        $c = new Criteria();
        $c->add(TransUnitPeer::SOURCE, $trans_unit->getSource());
        TransUnitPeer::doDelete($c);
        
        $this->setFlash('msg_ok', 'The unit has been deleted');
        return $this->redirect('transUnits/list');
    }

    protected function processSort()
    {
        $this->sort_namespace = 'backend/transUnits/sort';
        
        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }
        
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'TransUnit::source', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'asc', $this->sort_namespace); //default order
        }
    }

    protected function addSortCriteria($c)
    {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $sort_arr = explode('::', $sort_column);
            $peer = $sort_arr[0] . 'Peer';
            
            $sort_column = call_user_func(array($peer,'translateFieldName'), $sort_arr[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
            if ($this->getUser()->getAttribute('type', null, $this->sort_namespace) == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
                 //add extra sorting field if there is duplicates
                 //otherwise MySQL add such field on strange conditions
                 // ( e.g. if trans_unit.target is selected or not)
                $c->addAscendingOrderByColumn(TransUnitPeer::ID);
            } else
            {
                $c->addDescendingOrderByColumn($sort_column);
                $c->addDescendingOrderByColumn(TransUnitPeer::ID);
            }
        }
    }
    
    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/transUnits/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/transUnits/filters');
        }
    }
    
    protected function addFiltersCriteria( Criteria $c)
    {
        if (isset($this->filters['cat_id']) && strlen($this->filters['cat_id']) > 0)
        {
            $c->add(TransUnitPeer::CAT_ID, $this->filters['cat_id']);
        }  else {
            $c->add(TransUnitPeer::CAT_ID, 1); //default to english
        }
              
        if (isset($this->filters['search_query']) && strlen($this->filters['search_query']) > 0)
        {
            $c->add(TransUnitPeer::SOURCE, '%' . $this->filters['search_query'] . '%', Criteria::LIKE);
        }
        
        if (isset($this->filters['target']) && strlen($this->filters['target']) > 0)
        {
            $c->add(TransUnitPeer::TARGET, '%' . $this->filters['target'] . '%', Criteria::LIKE);
        }        
              
        if (isset($this->filters['tags']) && strlen($this->filters['tags']) > 0)
        {
            $c->add(TransUnitPeer::TAGS, '%' . $this->filters['tags'] . '%', Criteria::LIKE);
        }        
              
        if ( isset($this->filters['translated']) && $this->filters['translated'] != '')
        {
            $c->add(TransUnitPeer::TRANSLATED, (bool) $this->filters['translated']);
        }        
    }
        
}
