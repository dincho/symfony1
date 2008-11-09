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
        $this->top_menu_selected = 'staticPages';
        
        $bc = $this->getUser()->getBC();
        $bc->replaceFirst(array('name' => 'Translation Units', 'uri' => 'transUnits/list'));        
    }
    
    public function executeList()
    {
        $this->trans_units = TransUnitPeer::doSelectJoinAll(new Criteria());
    }

    public function executeCreate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $trans_unit = new TransUnit();
            $trans_unit->setCatId($this->getRequestParameter('cat_id'));
            $trans_unit->setSource($this->getRequestParameter('source'));
            $trans_unit->setTarget($this->getRequestParameter('target'));
            $trans_unit->save();
            $this->redirect('transUnits/list');            
        }
    }

    public function executeEdit()
    {
        $trans_unit = TransUnitPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($trans_unit);
        $this->trans_unit = $trans_unit;
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $trans_unit->setCatId($this->getRequestParameter('cat_id'));
            $trans_unit->setSource($this->getRequestParameter('source'));
            $trans_unit->setTarget($this->getRequestParameter('target'));
            $trans_unit->save();
            $this->redirect('transUnits/list');                
        }
    }

    public function executeDelete()
    {
        $trans_unit = TransUnitPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404Unless($trans_unit);
        $trans_unit->delete();
        return $this->redirect('transUnits/list');
    }
}
