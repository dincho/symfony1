<?php

/**
 * Subclass for representing a row from the 'static_page_domain' table.
 *
 *
 *
 * @package lib.model
 */
class StaticPageDomain extends BaseStaticPageDomain
{
    public function getSlug()
    {
        return $this->getStaticPage()->getSlug();
    }

    public function hasContent()
    {
        return $this->getStaticPage()->getHasContent();
    }
}
