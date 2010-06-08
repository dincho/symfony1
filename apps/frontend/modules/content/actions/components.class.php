<?php
class contentComponents extends sfComponents
{
    public function executeHeaderMenu()
    {
        
    }
    
    public function executeBreadcrumb()
    {
        
    }
    
    public function executeHomepagePhotoSet()
    {
        $culture = $this->getUser()->getCulture();
        
        $c = new Criteria();
        $c->add(StockPhotoPeer::HOMEPAGES, null, Criteria::ISNOTNULL);
        $c->add(StockPhotoPeer::HOMEPAGES, 'FIND_IN_SET("' . $culture .'", ' . StockPhotoPeer::HOMEPAGES . ') != 0', Criteria::CUSTOM);
        $c->add(StockPhotoPeer::HOMEPAGES_SET, $this->homepage_set);
        $c->addAscendingOrderByColumn(StockPhotoPeer::HOMEPAGES_POS);
        $c->setLimit(9);
        $photos = StockPhotoPeer::doSelect($c);
        
        if( count($photos) < 9 && $this->homepage_set != 1)
        {
            $c->add(StockPhotoPeer::HOMEPAGES_SET, 1);
            $photos = StockPhotoPeer::doSelect($c);
        }
        
        $this->photos = ( count($photos) == 9) ? $photos : array();
    }
    
    public function executeHomepageMemberPhotoSet()
    {
        $culture = $this->getUser()->getCulture();
        
        $c = new Criteria();
        $c->add(HomepageMemberPhotoPeer::HOMEPAGES, null, Criteria::ISNOTNULL);
        $c->add(HomepageMemberPhotoPeer::HOMEPAGES, 'FIND_IN_SET("' . $culture .'", ' . HomepageMemberPhotoPeer::HOMEPAGES . ') != 0', Criteria::CUSTOM);
        $c->add(HomepageMemberPhotoPeer::HOMEPAGES_SET, $this->homepage_set);
        $c->addGroupByColumn(HomepageMemberPhotoPeer::HOMEPAGES_POS);
        //$c->addAscendingOrderByColumn(HomepageMemberPhotoPeer::HOMEPAGES_POS);
        $c->setLimit(9);
        $photos = HomepageMemberPhotoPeer::doSelect($c);
        
        if( count($photos) < 9 && $this->homepage_set != 1)
        {
            $c->add(HomepageMemberPhotoPeer::HOMEPAGES_SET, 1);
            $photos = HomepageMemberPhotoPeer::doSelect($c);
        }
        
        $this->photos = ( count($photos) == 9) ? $photos : array();
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