<?php
/**
 * areas actions.
 *
 * @package    pr
 * @subpackage areas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class areasActions extends sfActions
{

    public function preExecute()
    {
        $this->getUser()->getBC()->addFirst(array('name' => 'content', 'uri' => 'content/list'));
        $this->top_menu_selected = 'content';
        $this->left_menu_selected = 'Areas';
    }

    public function executeList()
    {
        $this->forward('areas', 'view');
    }

    public function executeInfo()
    {
        $adm1 = GeoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($adm1);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $adm1->setInfo($this->getRequestParameter('info'));
            $adm1->save();
            
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('areas/view?country=' . $adm1->getCountry());
        }
        
        $this->adm1 = $adm1;
    }

    public function executeUploadPhoto()
    {
        $geo = GeoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($geo);
        $this->forward404Unless($this->getRequest()->getMethod() == sfRequest::POST);
        
        if ($this->getRequest()->getFileSize('new_photo'))
        {
            $photo = new GeoPhoto();
            $photo->setGeoId($geo->getId());
            $photo->updateImageFromRequest('file', 'new_photo');
            $photo->save();
            
            $this->setFlash('msg_ok', 'New photo has been uploaded');
        }
        
        $this->redirect('areas/info?id=' . $geo->getId());
    }
    
    public function executeDeletePhoto()
    {
        $photo = GeoPhotoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($photo);
        
        $photo->delete();
        
        $this->setFlash('msg_ok', 'Selected photo has been deleted');
        $this->redirect('areas/info?id=' . $photo->getGeoId());
    }
    
    public function executeView()
    {
        $country = $this->getRequestParameter('country', 'US');
        
        $this->adm1s = GeoPeer::getAllByCountry($country);
        $this->country = $country;
    }
    
}
