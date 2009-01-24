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
        $last_homepage_set = $this->getUser()->getAttribute('last_homepage_set', array());
        
        $c = new Criteria();
        $c->add(StockPhotoPeer::HOMEPAGES, null, Criteria::ISNOTNULL);
        $c->add(StockPhotoPeer::HOMEPAGES, 'FIND_IN_SET("' . $this->getUser()->getCulture() .'", ' . StockPhotoPeer::HOMEPAGES . ') != 0', Criteria::CUSTOM);
        $c->add(StockPhotoPeer::ID, $last_homepage_set, Criteria::NOT_IN);
        $c->addAscendingOrderByColumn(StockPhotoPeer::GENDER);
        $c->addAscendingOrderByColumn('RAND()');
        $c->setLimit(9);
        $photos = StockPhotoPeer::doSelect($c);
        
        if( count($photos) < 9)
        {
            $c->remove(StockPhotoPeer::ID);
            $photos = StockPhotoPeer::doSelect($c);
        }
        
        if( count($photos) == 9)
        {
            $new_photos[] = $photos[0]; //f
            $new_photos[] = $photos[5]; //m
            $new_photos[] = $photos[1]; //f
            $new_photos[] = $photos[6]; //m
            $new_photos[] = $photos[2]; //f
            $new_photos[] = $photos[7]; //m
            $new_photos[] = $photos[3]; //f
            $new_photos[] = $photos[8]; //m
            $new_photos[] = $photos[4]; //f
            $this->photos = $new_photos;
        } else {
            $this->photos = array();
        }
    }
}