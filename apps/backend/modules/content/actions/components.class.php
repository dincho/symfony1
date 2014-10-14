<?php

class contentComponents extends sfComponents
{
  public function executeBottomMenu()
  {
      $c = new Criteria();
      $c->addAlias("cat1",CataloguePeer::TABLE_NAME);
      $c->addJoin(CataloguePeer::alias("cat1",CataloguePeer::TARGET_LANG), CataloguePeer::TARGET_LANG);
      $c->add(CataloguePeer::alias("cat1",CataloguePeer::CAT_ID), $this->catId, Criteria::EQUAL);
      $c->addAnd(CataloguePeer::CAT_ID, $this->catId, Criteria::NOT_EQUAL);
      $this->catalogs = CataloguePeer::getAll($c);
  }
}
