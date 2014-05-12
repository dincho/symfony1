<?php

/**
 * Subclass for representing a row from the 'trans_collection' table.
 *
 *
 *
 * @package lib.model
 */
class TransCollection extends BaseTransCollection
{
    public function __toString()
    {
        return $this->getName();
    }
}
