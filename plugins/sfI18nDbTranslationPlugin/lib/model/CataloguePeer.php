<?php

/**
 * Subclass for performing query and update operations on the 'catalogue' table.
 *
 * 
 *
 * @package lib.model
 */ 
class CataloguePeer extends BaseCataloguePeer
{

  public static function getCatalogues() {
    $c = new Criteria();
    return CataloguePeer::doSelect($c);
  }
}
