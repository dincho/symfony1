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
          $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved');
          $this->redirect($this->getModuleName().'/'.$this->getActionName().'?id=' . $this->getRequestParameter('id'));
        }
            
        $this->left_menu_selected = 'Translation Units';
        $this->top_menu_selected = 'content';
        
        $bc = $this->getUser()->getBC();
        $bc->replaceFirst(array('name' => 'Translation Units', 'uri' => 'transUnits/list'));        
    }
    
    public function executeList()
    {
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/transUnits/filters');
                
        $c = new Criteria();
        $this->addFiltersCriteria($c);
        $c->addAscendingOrderByColumn(TransUnitPeer::SOURCE);
        $c->add(TransUnitPeer::MSG_COLLECTION_ID, null, Criteria::ISNULL);
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('TransUnit', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinAllExceptMsgCollection');
        $pager->setPeerCountMethod('doCountJoinAllExceptMsgCollection');
        $pager->init();
        $this->pager = $pager;  
        
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

    public function executeEdit()
    {
        $trans_unit = TransUnitPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($trans_unit);
        $this->trans_unit = $trans_unit;
        
        if( $trans_unit->getCatId() != 1)
        {
	        $c = new Criteria();
	        $c->add(TransUnitPeer::SOURCE, $trans_unit->getSource());
	        $c->add(TransUnitPeer::CAT_ID, 1); //english catalog
	        $en_trans_unit = TransUnitPeer::doSelectOne($c);
	        $this->forward404Unless($en_trans_unit);
	        $this->en_trans_unit = $en_trans_unit;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            $trans_unit->setTranslated($this->getRequestParameter('translated'));
            $trans_unit->setSource($this->getRequestParameter('source'));
            $trans_unit->setTarget($this->getRequestParameter('target'));
            $trans_unit->setTags($this->getRequestParameter('tags'));
            $trans_unit->setLink($this->getRequestParameter('link'));
            $trans_unit->save();
            
            if( $trans_unit->getCatId() != 1)
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
    }

    public function executeDelete()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        $trans_unit = TransUnitPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($trans_unit);
        $trans_unit->delete();
        
        $this->setFlash('msg_ok', 'The unit has been deleted');
        return $this->redirect('transUnits/list');
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
