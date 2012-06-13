<?php

/**
 * Subclass for representing a row from the 'as_seen_on_logo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AsSeenOnLogo extends BaseAsSeenOnLogo
{
	
	public function getHomepagesArray()
    {
        if (! is_null($this->getHomepages()))
        {
            return explode(',', $this->getHomepages());
        }
        
        return array();
    }
   
  public function setHomepagesArray($array)
    {
        if (! is_array($array) || count($array) == 0)
        {
            $this->setHomepages(null);
        } else
        {
            $this->setHomepages(implode(',', $array));
        }
    }
}
