<?php
/**
 * catalogue actions.
 *
 * @package    pr
 * @subpackage catalogue
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class catalogueActions extends sfActions
{

    public function preExecute()
    {
        if ($this->getRequestParameter('cancel') == 1)
        {
          $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved');
          $this->redirect($this->getModuleName().'/'.$this->getActionName().'?cat_id=' . $this->getRequestParameter('cat_id'));
        }

       
        $this->left_menu_selected = 'Translation Catalogue';
        $this->top_menu_selected = 'content';
        $bc = $this->getUser()->getBC();
        $bc->replaceFirst(array('name' => 'Translation Catalogue', 'uri' => 'catalogue/list'));        
    }
    
    public function executeList()
    {
         
        $c = new Criteria();
        $c->addAscendingOrderByColumn(CataloguePeer::TARGET_LANG);
        $this->catalogues = CataloguePeer::doSelect($c);
    }

    public function executeCreate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $source_culture = 'en';
            $tagrget_culture = $this->getRequestParameter('language');
            $catalogue = new Catalogue();
            $catalogue->setName('messages.' . $tagrget_culture);
            $catalogue->setSourceLang($source_culture);
            $catalogue->setTargetLang($tagrget_culture);
            $catalogue->setDateCreated(time());
            //$catalogue->setDateModified();
            //$catalogue->setAuthor();
            $catalogue->save();
            $this->redirect('catalogue/list');
        }
    }
    /*
  public function executeEdit()
  {
    $this->catalogue = CataloguePeer::retrieveByPk($this->getRequestParameter('cat_id'));
    $this->forward404Unless($this->catalogue);
  }

  public function executeDelete()
  {
    $catalogue = CataloguePeer::retrieveByPk($this->getRequestParameter('cat_id'));

    $this->forward404Unless($catalogue);

    $catalogue->delete();

    return $this->redirect('catalogue/list');
  }*/
}
