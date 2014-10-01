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
    public static function getByCatalog(Catalogue $catalog)
    {
        $c = new Criteria();
        $c->add(self::CAT_ID, $catalog->getCatId());

        return self::doSelect($c);
    }

    public static function retrieveByCatalogAndName($catalog, $name)
    {
        $c = new Criteria();
        $c->add(sfSettingPeer::NAME, $name);
        $c->add(sfSettingPeer::CAT_ID, $catalog->getCatId());

        return sfSettingPeer::doSelectOne($c);
    }

    public static function valueForCatalogAndName($catalog, $name)
    {
        $setting = self::retrieveByCatalogAndName($catalog, $name);

        return ($setting) ? $setting->getValue() : null;
    }

    public static function updateFromRequest($keys = array(), $catalog = null)
    {
        $c1 = new Criteria();
        if(!is_null($catalog)) $c1->add(sfSettingPeer::CAT_ID, $catalog->getCatId());
        $c2 = new Criteria();

        foreach ($keys as $key) {
            $c1->add(sfSettingPeer::NAME, $key);
            $c2->add(sfSettingPeer::VALUE, sfContext::getInstance()->getRequest()->getParameter($key));
            BasePeer::doUpdate($c1, $c2, Propel::getConnection(sfSettingPeer::DATABASE_NAME));
        }

        //clear the cache
        $sf_root_cache_dir = sfConfig::get('sf_root_cache_dir');
        $cache_dir = $sf_root_cache_dir.'/*/*/config/';
        sfToolkit::clearGlob($cache_dir.'config_db_settings.yml.php');
    }
}
