<?php

/**
 * Subclass for representing a row from the 'static_page' table.
 *
 * 
 *
 * @package lib.model
 */ 
class StaticPage extends BaseStaticPage
{
    public function clearCache()
    {
      $sf_root_cache_dir = sfConfig::get('sf_root_cache_dir');
      $cache = $sf_root_cache_dir.'/frontend/*/template/*/all/*/content/page/slug/' . $this->getSlug() . '/*';
      sfToolkit::clearGlob($cache);
      $cache = $sf_root_cache_dir.'/frontend/*/template/*/all/*/page/' . $this->getSlug() . '.*';
      sfToolkit::clearGlob($cache);
    }
}
