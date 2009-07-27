<?php

/**
 * Subclass for representing a row from the 'geo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Geo extends BaseGeo
{
    public function __toString()
    {
        return $this->getName();
    }
}
