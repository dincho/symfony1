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
        $this->settings = sfSettingPeer::doSelect(new Criteria());
    }
    
    public function executeEdit()
    {
        $setting = sfSettingPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($setting);
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $setting->setValue($this->getRequestParameter('value'));
            $setting->save();
            
            //clear the cache
            $sf_root_cache_dir = sfConfig::get('sf_root_cache_dir');
            $cache_dir = $sf_root_cache_dir.'/*/*/config/';
            sfToolkit::clearGlob($cache_dir.'config_db_settings.yml.php'); 
                        
            $this->redirect('settings/list?confirm_msg=' . confirmMessageFilter::OK);
        }
        
        $this->setting = $setting;
    }
}
