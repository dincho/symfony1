<?php

/**
 * Subclass for representing a row from the 'trans_unit' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TransUnit extends BaseTransUnit
{
    public function save($con = null)
    {

      if( $this->isModified() )
      {
        $this->setDateModified(time());
        //save date_modified in catalogue table
        // used in cache update sfMessageSource_MySQL::getLastModified
        $this->getCatalogue()->setDateModified($this->getDateModified());
      }
      parent::save();
    }

}
