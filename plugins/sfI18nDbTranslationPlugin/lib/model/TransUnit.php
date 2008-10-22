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

  public function getTargetLang()
  {
    $c = new Criteria();
    $c->add(CataloguePeer::CAT_ID, $this->getCatId());
    $catalogue = CataloguePeer::doSelectOne($c);
    if ($catalogue) {
      return $catalogue->getTargetLang();
    }  
  }
}
