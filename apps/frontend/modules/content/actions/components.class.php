<?php
class contentComponents extends sfComponents
{
    public function executeHeaderMenu()
    {
        
    }
    
    public function executeBreadcrumb()
    {
        
    }

    public function executeHomepageSinglePhoto()
    {
        $catalog_id = $this->getUser()->getCatalogId();
        
        $c = new Criteria();
        $c->add(StockPhotoPeer::HOMEPAGES, null, Criteria::ISNOTNULL);
        $c->add(StockPhotoPeer::HOMEPAGES, 'FIND_IN_SET("' . $catalog_id .'", ' . StockPhotoPeer::HOMEPAGES . ') != 0', Criteria::CUSTOM);
        $c->add(StockPhotoPeer::HOMEPAGES_SET, $this->homepage_set);
        //$c->addGroupByColumn(StockPhotoPeer::HOMEPAGES_POS);
        $c->addDescendingOrderByColumn(StockPhotoPeer::UPDATED_AT);
        $c->setLimit(1);
        $photos = StockPhotoPeer::doSelect($c);
        
        if( count($photos) < 1 && $this->homepage_set != 1)
        {
            $c->add(StockPhotoPeer::HOMEPAGES_SET, 1);
            $photos = StockPhotoPeer::doSelect($c);
        }
        
        $this->photos = ( count($photos) == 1) ? $photos : array();
    }

    
    public function executeNotifications()
    {
      $response = $this->getResponse();
      $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype');
      $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/effects');
      $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/controls');
      $response->addJavascript('notifications.js');
    }
}