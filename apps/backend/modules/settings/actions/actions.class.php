<?php

/**
 * settings actions.
 *
 * @package    PolishRomance
 * @subpackage settings
 * @author     Dincho Todorov <dincho
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class settingsActions extends sfActions
{
    public function preExecute()
    {
        $this->top_menu_selected = 'content';
        $this->left_menu_selected = 'Settings';
    }
    
    public function executeList()
    {
      $c = new Criteria();
      $c->add(sfSettingPeer::CAT_ID, $this->getRequestParameter('cat_id', 1));
      $c->addAscendingOrderByColumn(sfSettingPeer::DESCRIPTION);
      $this->settings = sfSettingPeer::doSelect($c);
    }
    
    public function executeEdit()
    {
        $catalog = CataloguePeer::retrieveByPk($this->getRequestParameter('cat_id'));
        $this->forward404Unless($catalog);
        
        $setting = sfSettingPeer::retrieveByCatalogAndName($catalog, $this->getRequestParameter('name'));
        $this->forward404Unless($setting);

        $c = new Criteria();
        $c->add(CataloguePeer::CAT_ID, $this->getRequestParameter('cat_id'), Criteria::NOT_EQUAL);
        $catalogs = CataloguePeer::getAll($c);
        $idCatMap = array();
        foreach ($catalogs as $cat) {
            $idCatMap[$cat->getCatId()] = $cat;
        }

        $c->clear();
        $c->add(sfSettingPeer::NAME, $this->getRequestParameter('name'));
        $c->add(sfSettingPeer::CAT_ID, array_keys($idCatMap), Criteria::IN);
        $settings = sfSettingPeer::doSelect($c);
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $setting->setValue($this->getRequestParameter('value'));
            $setting->save();

            if ($this->getRequestParameter('allCats')) {
                foreach($settings as $currentSetting){
                    $currentSetting->setValue($this->getRequestParameter('value'));
                    $currentSetting->save();
                }
            }
            //clear the cache
            $sf_root_cache_dir = sfConfig::get('sf_root_cache_dir');
            $cache_dir = $sf_root_cache_dir.'/*/*/config/';
            sfToolkit::clearGlob($cache_dir.'config_db_settings.yml.php'); 
                        
            $this->redirect('settings/list?confirm_msg=' . confirmMessageFilter::OK . '&cat_id=' . $catalog->getCatId());
        }
        
        $this->setting = $setting;
        $this->catalog = $catalog;
        $this->idCatMap = $idCatMap;
        $this->settings = $settings;
    }
}
