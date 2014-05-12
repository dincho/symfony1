<?php

/**
 * Subclass for representing a row from the 'catalogue' table.
 *
 *
 *
 * @package lib.model
 */
class Catalogue extends BaseCatalogue
{
    public function __toString()
    {
        static $langs = array(); //performance, staticPages/index is too slow otherwise

        if ( !isset($langs[$this->getTargetLang()]) ) {
            sfLoader::loadHelpers(array('I18N'));
            $langs[$this->getTargetLang()] = format_language($this->getTargetLang());
        }

        return $this->getDomain() . ' - ' . $langs[$this->getTargetLang()];
    }

    public function getEnglishCatalogForDomain()
    {
        $c = new Criteria();
        $c->add(CataloguePeer::DOMAIN, $this->getDomain());
        $c->add(CataloguePeer::TARGET_LANG, 'en');

        return CataloguePeer::doSelectOne($c);
    }

    public function getVisibleCatalogs()
    {
        $shared = array_map('intval', explode(',', $this->getSharedCatalogs()));
        $shared[] = $this->getCatId();

        return $shared;
    }
}
