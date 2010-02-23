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
    public static function getAssistantPhotoByCulture($culture = 'en')
    {
        $c = new Criteria();
        $c->add(self::ASSISTANTS, $culture);
        $c->setLimit(1);
        
        return self::doSelectOne($c);
    }
    
    public static function getJoinNowPhotoByCulture($culture = 'en')
    {
        $c = new Criteria();
        $c->add(self::JOIN_NOW, $culture);
        $c->setLimit(1);
        
        return self::doSelectOne($c);
    }    
}
