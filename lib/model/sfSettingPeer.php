<?php

/**
 * Subclass for performing query and update operations on the 'sf_setting' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfSettingPeer extends BasesfSettingPeer
{
    public static function getByKey($key)
    {
        $c = new Criteria();
        $c->add(sfSettingPeer::NAME, $key);
        
        return sfSettingPeer::doSelectOne($c);
    }
    
    public static function updateFromRequest($keys = array(), $culture = 'en')
    {
        foreach ($keys as $key)
        {
            $setting = sfSettingPeer::getByKey($key);
            $setting->setValue(sfContext::getInstance()->getRequest()->getParameter($key));
            //$setting->setCulture($culture);
            $setting->save();
        }
        
        //clear the cache
        $sf_root_cache_dir = sfConfig::get('sf_root_cache_dir');
        $cache_dir = $sf_root_cache_dir.'/*/*/config/';
        sfToolkit::clearGlob($cache_dir.'config_db_settings.yml.php');         
    }
}
