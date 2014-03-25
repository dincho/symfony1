<?php

class contentComponents extends sfComponents 
{ 
  public function executeBottomMenu()
  {
      $c = new Criteria();
      $c->add(CataloguePeer::CAT_ID, $this->catId, Criteria::NOT_EQUAL);
      $this->catalogs = CataloguePeer::getAll($c);
  }
}