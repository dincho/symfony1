<?php

/**
 * Subclass for representing a row from the 'flag_category' table.
 *
 * 
 *
 * @package lib.model
 */ 
class FlagCategory extends BaseFlagCategory
{
    public function __toString()
    {
        return $this->getTitle();
    }
}
