<?php

/**
 * Subclass for performing query and update operations on the 'static_page' table.
 *
 * 
 *
 * @package lib.model
 */ 
class StaticPagePeer extends BaseStaticPagePeer
{
    private static $link_map_cache = null;
    public static function getLinskMap()
    {
        if( is_null(self::$link_map_cache) )
        {
            $pages = StaticPagePeer::doSelectWithI18n(new Criteria());
            
            $map = array();
            foreach ($pages as $page)
            {
                $map[$page->getSlug()] = $page->getLinkName();
            }
            
            self::$link_map_cache = $map;
        }
        
        return self::$link_map_cache;
    }
}
