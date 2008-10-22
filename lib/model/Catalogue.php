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
        sfLoader::loadHelpers(array('I18N'));
        return format_language($this->getTargetLang());    
    }
}
