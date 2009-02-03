<?php
class contentComponents extends sfComponents
{
    public function executeHeaderMenu()
    {
        
    }
    
    public function executeBreadcrumb()
    {
        
    }
    
    public function executeFooter()
    {
        
    }
    

    public function executeHomepagePhotoSet()
    {
        $last_homepage_set = $this->getUser()->getAttribute('last_homepage_set', 3);
        $homepage_set = ( $last_homepage_set >= 3 ) ? 1 : $last_homepage_set + 1;
        $this->getUser()->setAttribute('last_homepage_set', $homepage_set);
        $culture = $this->getUser()->getCulture();
        
        $c = new Criteria();
        $c->add(StockPhotoPeer::HOMEPAGES, null, Criteria::ISNOTNULL);
        $c->add(StockPhotoPeer::HOMEPAGES, 'FIND_IN_SET("' . $culture .'", ' . StockPhotoPeer::HOMEPAGES . ') != 0', Criteria::CUSTOM);
        $c->add(StockPhotoPeer::HOMEPAGES_SET, $homepage_set);
        $c->addAscendingOrderByColumn(StockPhotoPeer::HOMEPAGES_POS);
        $c->setLimit(9);
        $photos = StockPhotoPeer::doSelect($c);
        
        if( count($photos) < 9 && $homepage_set != 1)
        {
            $c->add(StockPhotoPeer::HOMEPAGES_SET, 1);
            $photos = StockPhotoPeer::doSelect($c);
        }
        
        $this->photos = ( count($photos) == 9) ? $photos : array();
    }
}