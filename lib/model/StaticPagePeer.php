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
    
    public static function getBySlug($slug)
    {
        $c = new Criteria();
        $c->add(StaticPagePeer::SLUG, $slug);
        $c->setLimit(1);
        $pages = StaticPagePeer::doSelectWithI18n($c);

        return isset($pages[0]) ? $pages[0] : null;
    }
}
