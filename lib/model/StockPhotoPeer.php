<?php

/**
 * Subclass for performing query and update operations on the 'stock_photo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class StockPhotoPeer extends BaseStockPhotoPeer
{
    public static function getAssistantPhotoByCatalog(Catalogue $catalog)
    {
        $c = new Criteria();
        $c->add(self::ASSISTANTS, $catalog->getCatId());
        $c->setLimit(1);
        
        return self::doSelectOne($c);
    }
    
    public static function getJoinNowPhotoByCatalog(Catalogue $catalog)
    {
        $c = new Criteria();
        $c->add(self::JOIN_NOW, $catalog->getCatId());
        $c->setLimit(1);
        
        return self::doSelectOne($c);
    }    
}
